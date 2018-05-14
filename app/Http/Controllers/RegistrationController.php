<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use URL;
use Mail;
class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_type=DB::table('user_type')->pluck('user_type_name','user_type_id')->all();
        $ticket_rate=DB::table('user_type')->pluck('ticket_rate')->all();
        return view('registration')->with('user_type',$user_type)->with('ticket_rate',$ticket_rate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $gateway_url='https://www.epaykerala.com/index.php/pay_patron/receive_from_patron';
        $formData=array(
          'user_name'=>$request->user_name,
          'user_type_id'=>$request->user_type,
          'email'=>$request->email,
          'mobile_number'=>$request->contact_no,
        );

        //Checking duplicate email in dB
        $checkMail=DB::table('users')->where('email',$formData['email'])->value('email');
        if($checkMail!=null)
          return "Email id already used for another registration! <a href=".URL::to('/').">Click here to go back</a>";

        //checking registration count
        $count=DB::table('user_type')->where('user_type_id',$formData['user_type_id'])->value('ticket_limit');
        $count_registered=DB::table('users')->where('user_type_id',$formData['user_type_id'])->count();
        if($count_registered>=$count){
          return "Online Registration is completed for this category! For further information write to <a href='mailto:info@icfoss.in'>info@icfoss.in</a> <a href='http://www.swatantra.net.in'>Click here to open Swatantra website</a>";
        }

        /*
         * Security code for the client. Don't change this value. If you change this value then transaction will not be successful.
        */
        $sec_code 	="SA17";
        $client_code	= "SAAI";
        $Amount			= DB::table('user_type')->where('user_type_id',$formData['user_type_id'])->value('ticket_rate');	// Assign your amount
        $tmestmp		= gmdate("hms");
        $name			= $formData['user_name']; // Assign your customer name
        $value_to_chk 	= $sec_code.$tmestmp;
        $chk_digit		= $this->chk_digit($value_to_chk);
        $your_trnid		= substr(md5(uniqid(rand(), true)),0,10); // assign your transid
        $transid		= $chk_digit.$your_trnid;
        $formData['transaction_id']=$transid;
        //inserting data
        $	flag=DB::table('users')->insert($formData);
        if($flag==1){
            $paymentData=array(
              'client_code'=>$client_code,
              'Amount'=>$Amount,
              'transid'=>$transid,
              'tmestmp'=>$tmestmp,
              'name'=>$formData['user_name']
            );
            return view('payment')->with('paymentData',$paymentData);
        }
        else
          return "Operation failed! <a href=".URL::to('/').">Try again</a>";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //return function after payment
    public function payment_status(Request $request){
      $data=$request->data;
      $pass_dataAr=explode("|",$data);
      $amount=(int)$pass_dataAr[5];

      //validating amount
      $org_amount=(int)DB::table('user_type')
                  ->join('users','users.user_type_id','user_type.user_type_id')
                  ->where('users.transaction_id', $pass_dataAr[0])
                  ->value('user_type.ticket_rate');
      if($org_amount==$amount){
        //update transaction status
        DB::table('users')
        ->where('transaction_id', $pass_dataAr[0])
        ->update(['transaction_status' => $pass_dataAr[3]]);

        $mailto=DB::table('users')
        ->where('transaction_id', $pass_dataAr[0])
        ->value('email');

        //send confirmation mail
        $sent = Mail::send('mail',compact('pass_dataAr'), function($message) use ($pass_dataAr,$mailto) {
          $message->to($mailto)->subject('Swatantra - Registration Confirmation');
          $message->from('reg.swatantra2017@gmail.com');
        });
      }
      else{
        //update transaction status
        DB::table('users')
        ->where('transaction_id', $pass_dataAr[0])
        ->update(['transaction_status' => 'Amount mismatch!']);
      }

      return view('payment_status')->with('pass_dataAr',$pass_dataAr);
    }

    //Payment gateway verification digit generation function
    public function chk_digit($our_value){
      		$validChars = "0123456789ABCDEFGHIJKLMNOPQRSTUVYWXZ_";
      		$idWithoutCheckdigit = trim($our_value);
      		$idWithoutCheckdigit = strtoupper($idWithoutCheckdigit);
      		$sum = 0;
      		for ($i = 0; $i < strlen($idWithoutCheckdigit); $i++) {
      			$ch = $idWithoutCheckdigit[(strlen($idWithoutCheckdigit)- $i - 1)];
       			if (strpos($validChars,$ch) === false){
      				return -1;
      			}
      			else{
      				$digit = ord($ch) - 48;
      				$weight =0;

      				if ($i % 2 == 0) {
      					$weight = (2 * $digit) - floor($digit / 5) * 9;
      				}
      				else {	$weight = $digit;	}
      				$sum =$sum+$weight;
      			}
      		}
      		$sum = abs($sum) + 10;
      		return (10 - ($sum % 10)) % 10;
	   }

     //Admin registrations
     public function view_registrations(Request $request){

       $username=$request->user_name;
       $password=$request->password;

       //Authentication hardcoded
       if($username=='SAAI' && $password=='SAAI#2017saai'){
         $reg_details=DB::table('users')
         ->join('user_type','users.user_type_id','user_type.user_type_id')
         ->select('user_name','user_type.user_type_name','email','mobile_number','transaction_id','transaction_status')
         ->orderBy('user_id', 'desc')
         ->get();
         return view('registrations')->with('reg_details',$reg_details);
       }
       else{
         $message="";
         if($request->method()=='POST')
          $message="Invalid username/password";
         return view('admin')->with('message',$message);
       }
     }

     public function update_tickets(Request $request){
       $username=$request->user_name;
       $password=$request->password;

       //Authentication hardcoded
       if($username=='SAAI' && $password=='SAAI#2017saai'){
         $cat_details=DB::table('user_type')->select('user_type_id','user_type_name','ticket_limit','ticket_rate')->get()->toArray();
         return view('tickets',compact('cat_details'));
       }
       else{
         $message="";
         if($request->method()=='POST')
          $message="Invalid username/password";
         return view('admin')->with('message',$message);
       }
     }

     //function to update ticket_rate and ticket_limit
     public function update_category(Request $request){
       $user_type_id=$request->user_type;
       $ticket_limit=$request->ticket_limit;
       $ticket_rate=$request->ticket_rate;

       $update_flg=DB::table('user_type')
                   ->where('user_type_id', $user_type_id)
                   ->update([
                     'ticket_limit' => $ticket_limit,
                     'ticket_rate' => $ticket_rate,
                   ]);

       $cat_details=DB::table('user_type')->select('user_type_id','user_type_name','ticket_limit','ticket_rate')->get()->toArray();
       return view('tickets',compact('cat_details','update_flg'));
     }

     //function to store details of students for later
     public function students_for_later(Request $request){
       if($request->method()=='GET'){
         return view('students');
       }
       else if($request->method()=='POST'){
         $formData=array(
           'user_name'=>$request->user_name,
           'institution'=>$request->institution,
           'email'=>$request->email,
           'mobile_number'=>$request->contact_no,
           'comments'=>$request->comments,
         );

         //Checking duplicate email in dB
         $checkMail=DB::table('students')->where('email',$formData['email'])->value('email');
         if($checkMail!=null)
           return "Email id already used for another registration! <a href=".URL::to('/students').">Click here to go back</a>";

         //inserting data
         $flag=DB::table('students')->insert($formData);
         if($flag==1){
           return "Successfully requested! <a href='http://www.swatantra.net.in'>Click here to open Swatantra website</a>";
         }
         else {
           return "Operation failed! <a href=".URL::to('/students').">Try again</a>";
         }
       }
     }
}

@extends('layout')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-info" style="margin-top:100px">
        <table width="100%">
      		<tr>
            <td align="center"><h2><font color="#094b09">Payment Gateway!..</font></h2>
      			</td>
      		</tr>
          <tr><td align='center'>
        		  <table align='center'>
        			 <tr><td>Thank You For using Epaykerala...</td></tr>
        			<div align='left' class='msgbox'>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
        			 	<p><b>Transaction Number: </b>{{$pass_dataAr[0]}}</p>
        			 	<p><b>Transaction Status: </b>{{$pass_dataAr[3]}}</p>
        			 	<p><b>Transaction Date: </b>{{gmdate("d/m/Y")}}</p>
        			 	<p><b>Payment through: </b>{{$pass_dataAr[4]}}</p>
                <p><b>Amount: </b>{{$pass_dataAr[5]}}</p>
        			</div>
        			</table>
        		</td>
          </tr>
      </table>
      </div>
    </div>
  </div>
</div>
@endsection

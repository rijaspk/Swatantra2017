@extends('layout')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <form method="post" action="https://www.epaykerala.com/index.php/pay_patron/receive_from_patron">
      	<table width="100%">
      		<tr><td align="center"><h2><font color="#094b09">Payment Gateway!..</font></h2>
      			</td>
      		</tr>
          <tr><td align='center'>
      			<table align='center'>
      				<tr><td>Thank You For using Epaykerala...</td></tr>
      				<tr>
                <td>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
      					<input type="hidden" name="client_code" value="<?php echo $paymentData['client_code']; ?>">
          			<input type="hidden" name="amount" value="<?php echo $paymentData['Amount']; ?>">
      					<input type="hidden" name="txnId" value="<?php echo $paymentData['transid']; ?>">
      				  <input type="hidden" name="timestamp" value="<?php echo $paymentData['tmestmp']; ?>">
      					<input type="hidden" name="clntname" value="<?php echo $paymentData['name']; ?>">
      					<input type="submit" name="pay now" value="Pay Now">
      					</td>
      				</tr>
      			</table>
      		</td></tr>
      	</table>
	</form>
    </div>
  </div>
</div>
@endsection

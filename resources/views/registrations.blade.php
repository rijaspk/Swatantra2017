@extends('layout')
@section('content')
<div class="container">
  <div class="row text-center">
    <div class="col-md-1">
      @php $success_count=$failed_count=0; @endphp
    </div>

    <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>
            Total Registered:
            {{count($reg_details)}}
          </h4>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="panel panel-success">
        <div class="panel-heading">
          <h4>
            Completed payments:
            <span id="success_count"></span>
          </h4>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="panel panel-danger">
        <div class="panel-heading">
          <h4>
            Failed payments:
            <span id="failed_count"></span>
          </h4>
        </div>
      </div>
    </div>

  </div>
  <div class="row">
    <table id="registrations" class="table table-striped table-reponsive table-bordered" width="100%" cellspacing="0">
      <thead>
        <tr>
          <td>Name</td>
          <td>Category</td>
          <td>Email</td>
          <td>Mobile</td>
          <td>Transaction id</td>
          <td>Transaction status</td>
        </tr>
      </thead>
      <tbody>
        @foreach($reg_details as $index=>$each)
          <tr>
            <td>
              {{$each->user_name}}
            </td>
            <td>
              {{$each->user_type_name}}
            </td>
            <td>
              {{$each->email}}
            </td>
            <td>
              {{$each->mobile_number}}
            </td>
            <td>
              {{$each->transaction_id}}
            </td>
            <td>
              {{$each->transaction_status}}
              @php
                if(strpos($each->transaction_status, "successfully") !== false)
                  $success_count++;
                elseif($each->transaction_status!='')
                  $failed_count++;
              @endphp
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('page_scripts')
<script src="{{asset('dist/datatables/datatables.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#registrations').DataTable({
      dom:  "<'row'<'col-sm-3'B><'col-sm-3'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: ['copy', 'excel']
    });

    $('#success_count').html('{{$success_count}}');
    $('#failed_count').html('{{$failed_count}}');
});
</script>
@endpush

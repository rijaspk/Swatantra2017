@extends('layout')
@section('content')

<div class="container">
@php
    foreach($cat_details as $each_cat)
      $user_type[$each_cat->user_type_id]=$each_cat->user_type_name;
@endphp
{!! Form::open(['method' => 'put', 'id'=>'contact_form', 'class'=>'well form-horizontal']) !!}
<fieldset>

<!-- Form Name -->
<legend><center><h2><b>Category details</b></h2></center></legend><br>


<!-- Drop down -->
<div class="form-group">
  {!! Form::label('user_type', 'Category', ['class' => 'col-md-4 control-label']) !!}
<div class="col-md-4 selectContainer">
<div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
    {!! Form::select('user_type', $user_type, null, ['placeholder' => 'Select your Category','class'=>'form-control selectpicker']) !!}
</div>
</div>
</div>


<!-- Text input-->

<div class="form-group">
  {!! Form::label('ticket_limit', 'Ticket limit', ['class' => 'col-md-4 control-label']) !!}
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
 {!! Form::text('ticket_limit', null, ['id' => 'ticket_limit','class' => 'form-control','placeholder'=>'Ticket limit','maxlength'=>3])!!}
</div>
</div>
</div>

<!-- Text input-->

<div class="form-group">
  {!! Form::label('ticket_rate', 'Ticket rate', ['class' => 'col-md-4 control-label']) !!}
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
    {!! Form::text('ticket_rate', null, ['id' => 'ticket_rate','class' => 'form-control','placeholder'=>'Ticket rate','maxlength'=>3])!!}
</div>
</div>
</div>

<div class="form-group">
  <div id="update_info" class="col-md-offset-4 col-md-4 inputGroupContainer alert-info">
    @if(isset($update_flg))
      @if($update_flg==1)
        Successfully updated
      @else
        Error occured
      @endif
    @endif
  </div>
</div>

<!-- Button -->
<div class="form-group">
<label class="col-md-4 control-label"></label>
<div class="col-md-4"><br>
<button type="submit" class="btn btn-warning">SUBMIT <span class="glyphicon glyphicon-send"></span></button>
</div>
</div>

</fieldset>
{!! Form::close() !!}
</div>

@endsection

@push('page_scripts')
<script src="{{asset('js/bootstrapvalidator.min.js')}}" ></script>
<script>
$(document).ready(function() {
  $('#contact_form')[0].reset();
  $('.selectpicker').on('change',function(){
    $('#update_info').html('');
    if($(this).val()!=''){
       if($(this).val()==1){
         $('#ticket_rate').val('{{$cat_details[0]->ticket_rate}}');
         $('#ticket_limit').val('{{$cat_details[0]->ticket_limit}}');
       }
       else if($(this).val()==2){
         $('#ticket_rate').val('{{$cat_details[1]->ticket_rate}}');
         $('#ticket_limit').val('{{$cat_details[1]->ticket_limit}}');
       }
       else if($(this).val()==3){
         $('#ticket_rate').val('{{$cat_details[2]->ticket_rate}}');
         $('#ticket_limit').val('{{$cat_details[2]->ticket_limit}}');
       }
       else if($(this).val()==4){
         $('#ticket_rate').val('{{$cat_details[3]->ticket_rate}}');
         $('#ticket_limit').val('{{$cat_details[3]->ticket_limit}}');
       }
       else{
         $('#ticket_rate').val('');
         $('#ticket_limit').val('');
       }
    }
    else{
      $('#ticket_rate').val('');
      $('#ticket_limit').val('');
    }

  });
  $('#contact_form').bootstrapValidator({
      // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
      feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
          user_type: {
                   validators: {
                       notEmpty: {
                           message: 'Please select your Category'
                       }
                   }
          },
          ticket_rate: {
              validators: {
                integer: {
                      message: 'Please enter a valid number'
                },
                stringLength: {
                      min: 1,
                      max: 3,
                   },
                  notEmpty: {
                      message: 'Please enter your ticket limit'
                   }
              },
          },
          ticket_limit: {
              validators: {
                integer: {
                      message: 'Please enter a valid number'
                },
                stringLength: {
                      min: 1,
                      max: 3,
                   },
                  notEmpty: {
                      message: 'Please enter your ticket rate'
                   }
              },
          },
          }
      })
      .on('success.form.bv', function(e) {
          $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
              $('#contact_form').data('bootstrapValidator').resetForm();

          // Prevent form submission
          e.preventDefault();

          // Get the form instance
          var $form = $(e.target);

          // Get the BootstrapValidator instance
          var bv = $form.data('bootstrapValidator');

          // Use Ajax to submit form data
          $.post($form.attr('action'), $form.serialize(), function(result) {
              console.log(result);
          }, 'json');
      });
});
</script>
<style>
#myNavbar.li
{
  float: right;
}
</style>
@endpush

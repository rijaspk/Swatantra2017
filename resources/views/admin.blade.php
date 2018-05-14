@extends('layout')
@section('content')

<div class="container">

{!! Form::open(['method' => 'post', 'id'=>'login_form', 'class'=>'well form-horizontal']) !!}
<fieldset>

<!-- Form Name -->
<legend><center><h2><b>Login</b></h2></center></legend><br>

<!-- Text input-->

<div class="form-group">
  {!! Form::label('user_name', 'User Name', ['class' => 'col-md-4 control-label']) !!}
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
 {!! Form::text('user_name', null, ['class' => 'form-control','placeholder'=>'Name','maxlength'=>20])!!}
</div>
</div>
</div>

<!-- Text input-->

<div class="form-group">
  {!! Form::label('password', 'Password', ['class' => 'col-md-4 control-label']) !!}
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
  {!!  Form::password('password', ['class' => 'form-control', 'placeholder'=>'Password', 'maxlength'=>'20']) !!}
</div>
</div>
</div>

<div class="form-group">
  <div class="col-md-offset-4 col-md-4 inputGroupContainer alert-danger">
    {{$message}}
  </div>
</div>


<!-- Button -->
<div class="form-group">
<label class="col-md-4 control-label"></label>
<div class="col-md-4"><br>
<button type="submit" class="btn btn-warning">LOGIN<span class="glyphicon glyphicon-send"></span></button>
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


  $('#login_form')[0].reset();

  $('#login_form').bootstrapValidator({
      // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
      feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
          user_name: {
              validators: {
                   stringLength: {
                      min: 1,
                      max: 20,
                  },
                  notEmpty: {
                      message: 'Please enter your User Name'
                  }
              }
          },
          password: {
              validators: {
                stringLength: {
                      max: 12,
                   },
                  notEmpty: {
                      message: 'Please enter your password'
                   }
              },
              }
          }
      })
      .on('success.form.bv', function(e) {
          $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
              $('#login_form').data('bootstrapValidator').resetForm();

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

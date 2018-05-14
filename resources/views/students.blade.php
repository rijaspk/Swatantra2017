@extends('layout')
@section('content')






<div class="container">

{!! Form::open(['method' => 'post', 'id'=>'contact_form', 'class'=>'well form-horizontal']) !!}
<fieldset>

<!-- Form Name -->
<legend><center><h2><b>Registration request</b></h2></center></legend><br>

<!-- Text input-->

<div class="form-group">
  {!! Form::label('user_name', 'Name', ['class' => 'col-md-4 control-label']) !!}
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
 {!! Form::text('user_name', null, ['class' => 'form-control','placeholder'=>'Name','maxlength'=>30])!!}
</div>
</div>
</div>

<!-- Text input-->

<div class="form-group">
  {!! Form::label('institution', 'Institution Name', ['class' => 'col-md-4 control-label']) !!}
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
 {!! Form::text('institution', null, ['class' => 'form-control','placeholder'=>'Institution Name','maxlength'=>30])!!}
</div>
</div>
</div>

<!-- Text input-->
   <div class="form-group">
     {!! Form::label('email', 'Email', ['class' => 'col-md-4 control-label']) !!}
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
    {!! Form::email('email', null, ['class' => 'form-control','placeholder'=>'E-Mail Address','maxlength'=>30])!!}
</div>
</div>
</div>


<!-- Text input-->

<div class="form-group">
  {!! Form::label('mobile_number', 'Contact No.', ['class' => 'col-md-4 control-label']) !!}
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
    {!! Form::text('contact_no', null, ['class' => 'form-control','placeholder'=>'Contact No.','maxlength'=>12])!!}
</div>
</div>
</div>

<!-- Ticket Details -->
<div class="form-group details" id="extInfo">
<div class="col-md-4 col-md-offset-4" id="firstCol">
    <strong><span id="category"></span> Pass ₹ <span id="ticket_rate"></span> /-</strong> (inclusive all taxes)
   <p>Registration ends by 05:00 PM, 20 Dec, 2017</p>
   <p>If you think it is  expensive, feel free to write us at <a href="mailto:info@icfoss.in">info@icfoss.in</a> </p>
</div>
<div id="secondCol" class="col-md-8 col-md-offset-2">

</div>
</div>

<!-- <div class="form-group">
  <div class="col-md-8 col-md-offset-4">
 <p>If you unaffordable, feel free to write us at <a href="mailto:info@icfoss.in">info@icfoss.in</a> </p>
</div>
</div> -->
<!-- Success message -->
<div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Success!.</div>



<div class="form-group">
  {!! Form::label('comments', 'Comments', ['class' => 'col-md-4 control-label']) !!}
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
 <!-- <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span> -->
 {!! Form::textarea('comments', null, ['class' => 'form-control','placeholder'=>'','maxlength'=>200,'rows'=>5])!!}
</div>
</div>
</div>


<!-- Button -->
<div class="form-group">
<label class="col-md-4 control-label"></label>
<div class="col-md-4"><br>
<button type="submit" class="btn btn-warning">SUBMIT <span class="glyphicon glyphicon-send"></span></button>
</div>
</div>

<div class="col-md-4 col-md-offset-4" id="firstCol">
   <p>Quiries, feel free to write us at <a href="mailto:info@icfoss.in">info@icfoss.in</a> </p>
</div>
<div id="secondCol" class="col-md-8 col-md-offset-2">

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

  $('#contact_form').bootstrapValidator({
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
                      message: 'Please enter your Name'
                  }
              }
          },
          institution: {
              validators: {
                   stringLength: {
                      min: 1,
                      max: 50,
                  },
                  notEmpty: {
                      message: 'Please enter your Institution Name'
                  }
              }
          },
          user_type: {
                   validators: {
                       notEmpty: {
                           message: 'Please select your Category'
                       }
                   }
          },
          email: {
              validators: {
                  notEmpty: {
                      message: 'Please enter your Email Address'
                  },
                  emailAddress: {
                      message: 'Please enter a valid Email Address'
                  }
              }
          },
          contact_no: {
              validators: {
                stringLength: {
                      min: 10,
                      max: 12,
                   },
                  notEmpty: {
                      message: 'Please enter your Contact No.'
                   }
              },
              }
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
@endpush

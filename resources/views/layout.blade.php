<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registration</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('css/bootstrapValidator.min.css')}}" />
  <link rel="stylesheet" href="{{asset('dist/datatables/datatables.min.css')}}" />
  <script src="{{asset('js/jquery.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
<style>
  #success_message{ display: none;}
  .details{ display: none;}
  </style>
</head>
  <body>
    <nav class="navbar navbar-inverse" style="background-color:#EBD4CC;padding:10px ">
      <div class="container-fluid">
        <div class="navbar-header">
          <!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button> -->
          <a href="https://www.swatantra.net.in/">
            <img src="https://swatantra.net.in/wp-content/uploads/2017/11/TOP-e1510648996264.png" />
          </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav navbar-right">
            <!-- <li><a href="#">Registration</a></li>
            <li><a href="#">Contact</a></li> -->
          </ul>
            </div>
      </div>
    </nav>

    @yield('content')
    <footer class="container-fluid text-center">
      <div class="container">
        <div class="row">
          <a href="https://www.icfoss.in">
            <img src="https://swatantra.net.in/wp-content/uploads/2017/11/LOGO-300x86.png" alt="ICFOSS" />
          </a>
          <p>
            7th Floor, Thejaswini</br>
            Technopark, Trivandrum – 695 581</br>
            <a href="mailto:info@icfoss.in">info@icfoss.in</a> | <a href="https://icfoss.in">https://icfoss.in</a> | +91 471 2700013 /14
          </p>
        </div>
      </div>
    </footer>
    @stack('page_scripts')
  </body>
</html>

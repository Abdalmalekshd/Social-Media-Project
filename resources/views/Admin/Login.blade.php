<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css1/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('login.css') }}">

    <link rel="stylesheet" href="{{ asset('css1/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css1/bootstrap.min.css.map') }}">
    <script src="https://kit.fontawesome.com/f304de03af.js" crossorigin="anonymous"></script>
    <title>Login</title>
</head>
<body>
    

<?php
$noNavbar = '';
?>

<div class="login-page">
    <div class="form">
      @if(Session::has('success'))
    <div class="row mr-2 ml-2">
            <button type="text" class="btn btn-lg btn-block btn-outline-success mb-2"
                    id="type-error">{{Session::get('success')}}
            </button>
    </div>
@endif
      <h4>Admin Login</h4>
      <form class="login-form" method="Post" action="{{ route('admin.login') }}">
        @csrf
        <input type="email" name="email" placeholder="email"/>
        @error('email')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="password" name="password" placeholder="password"/>
        @error('password')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-primary">login</button>
        
        
        

        <a  href="{{ route('Admin.forgetpass') }}">Forget password?</a>

        </form>
    </div>
  </div>
<script src="{{ asset('css&js/all.min.js') }}"></script>

</body>
</html>
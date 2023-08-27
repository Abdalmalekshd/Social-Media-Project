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
    <title>Forget Password</title>
</head>
<body>
    

<?php
$noNavbar = '';
?>
<div class="login-page">
    @if(Session::has('error'))
    <div class="row mr-2 ml-2" >
            <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                    id="type-error">{{Session::get('error')}}
            </button>
    </div>
@endif
    <div class="form">
        <h4>Social_Media Project</h4>
        <form class="login-form" method="Post" action="{{ route('Admin.forgetpassword') }}">
        @csrf
        <input type="email" name="email" placeholder="Please Enter Your Email"/>
        @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        
        <button type="submit" class="btn btn-primary">Reset Password</button>

        </form>
    </div>
  </div>
<script src="{{ asset('css&js/all.min.js') }}"></script>

</body>
</html>
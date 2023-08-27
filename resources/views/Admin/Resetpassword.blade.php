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
    <title>Reset Password</title>
</head>
<body>
    

<?php
$noNavbar = '';
?>
<div class="login-page">
    <div class="form">
        <h4>Social_Media Project</h4>
        <form class="login-form" method="Post" action="{{ route('admin.setnewpass') }}">
        @csrf
        <input type="hidden" name="email" value="{{$admin->email}}">
        <input type="password" name="password" placeholder="Set New Password"/>
        @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        
        <button type="submit" class="btn btn-primary">Confirm Password</button>

        </form>
    </div>
  </div>
<script src="{{ asset('css&js/all.min.js') }}"></script>

</body>
</html>
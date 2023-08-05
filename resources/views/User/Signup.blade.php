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
    <title>SignIn</title>
</head>
<body>
    

<?php
$noNavbar = '';
?>
<div class="login-page">
    <div class="form">
        <form class="register-form" method="POST" action="{{ route('create.account') }}">
        @csrf
            <h4>Social_Media Project</h4>
        <input type="text" name="name" placeholder="Name"/>
@error('name')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
        <input type="text" name="email" placeholder="Email address"/>
        @error('email')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

<input type="radio" name="gender" value="0" class="radio"/><label>male</label>
<input type="radio" name="gender" id="" value="1" class="radio" /><label>female</label>

        @error('gender')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror




        <input type="text" name="phone" placeholder="Phone"/>
        @error('phone')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
        <input type="password" name="password" placeholder="Password"/>
        @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <select name="country" id="" class="select-coutry">
        <optgroup label="{{ __('messages.chosecountry') }}">
        @if($countries && $countries -> count() > 0)
        @foreach ($countries as $country)
        <option value="{{ $country->id }}">{{ $country->name }}</option>
        @endforeach
@endif
    </optgroup>
    </select>
    
            @error('country')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror


     

        <button class="btn btn-primary" type="submit">create</button>

        <div class="or">OR</div>




        <p class="message">Already registered? <a href="{{ route('login') }}">Sign In</a></p>
        </form>
    </div>
    </div>

</body>
</html>
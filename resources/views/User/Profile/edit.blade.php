@extends('layout.UserMaster')

@section('content')

<?php 
$Nosidebar='';

?>

@if(Session::has('success'))
<div class="row mr-2 ml-2">
        <button type="text" class="btn btn-lg btn-block btn-success mb-2"
                id="type-error">{{Session::get('success')}}
        </button>
</div>
@endif
    <form action="{{ route('user.profile.update',$user->id) }}" method="POST" class="edit-profile-form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name='user_id' class="" value="{{ $user->id }}">
        @error('user_id')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
<div class="edit-profile-page">
    <div class="img">
            @if ($user->avatar)
            <img class="edit-profile-img"  src="{{ url('Images/Avatar/', $user->avatar)}}" alt="">
            
            @error('avatar')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        
        <div class="dltavatarbtn">
            <a href="{{ route('user.avatar.dlt',$user->id) }}" title="DELETE AVATAR"><i class="fa fa-trash"></i></a>
        </div>
                @else
                    
            <img class="edit-profile-img" src="{{ url('img.png') }}" alt="">
                
            @endif
            
                <div class="uploadavatar">
                    <input type="file" name='avatar'  (change)="fileEvent($event)" class="inputfile" id="embedpollfileinput" />
                    
                <label for="embedpollfileinput"  class="ui huge red right floated button">
                <i class="fa fa-upload" title="Upload AVATAR"></i> 
                
                </label>
                        <input type="file" (change)="fileEvent($event)" class="inputfile" id="embedpollfileinput" />
                
                    </div>
                
                
            
        </div>

        
            <div class="container">
                <div class="row">
            
            <div class="col-md-6">
        <input type="text" name="name" class="form-group" value="{{ $user->name }}">
    </div>
    </div>
            
            <div class="row">
            
                <div class="col-md-6">
            @error('name')
            <div class="alert alert-danger messeges">{{ $message }}</div>

        @enderror 
    </div>
    <div class="row">

        <div class="col-md-6">
        
            <input type="text" name="phone" class="form-group" value="{{ $user->phone }}">
    </div>
        </div>
    <div class="row">
        <div class="col-md-6">
            
            @error('phone')
            <div class="alert alert-danger messeges">{{ $message }}</div>

        @enderror 
    </div>
</div>

<div class="row">

        <div class="col-md-6">
        
            <input type="text" name="email" class="form-group" value="{{ $user->email }}">
            
        </div>
    </div>
            <div class="row">
            
                <div class="col-md-6">
            @error('email')
            <div class="alert alert-danger messeges">{{ $message }}</div>
        @enderror 
    </div>
        </div>
    
    <div class="row">
        <div class="col-md-8">

            <textarea name="description" cols="27" rows="3" placeholder="Write something about yourself...">{{ $user->description }}</textarea>
        
            
        </div>

        <div class="row">
            
            <div class="col-md-6">
        @error('description')
        <div class="alert alert-danger messeges">{{ $message }}</div>
    @enderror 
</div>
    </div>
    </div>


    <div class="row">
            
        <div class="col-md-6">
    <select name="country_id" id="" class="select-coutry" >
        <optgroup label="{{ __('messages.chosecountry') }}">
        @if($countries && $countries -> count() > 0)
        @foreach ($countries as $country)
        <option value="{{ $country->id }}" @if ( $country->id == $user->country_id)
            selected
        @endif>{{ $country->Name }}</option>
        @endforeach
@endif
    </optgroup>
    </select>

            @error('country')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>




<div class="row">
    <div class="col-md-4">
    <input type="submit" value="{{ __('messages.edit') }}" class="btn btn-success editbtn">
</div>

</div>
        </div>

        <div class="row reset-delete-btn">
            <div class="col-md-3 reset-pass">
                <a href="{{ route('user.profile.dlt',$user->id) }}" data-confirm-delete="true" class="btn btn-danger">{{ __('messages.dltprofile') }}</a>
            </div>
            <div class="col-md-3 reset-pass">
    
                <a href="{{ route('changePassword',$user->id) }}" class="btn btn-primary">{{ __('messages.rstpassword') }}</a>
            </div>
    
    
    </div>

    </form>
    
    <style>
        .grid.container {
  margin-top: 5em;
  position: absolute;
  margin-top: -50px;
  margin-left: 540px
}
.inputfile {
	width: 0.1px;
	height: 0.1px;
	opacity: 0;
	overflow: hidden;
	position: absolute;
	z-index: -1;
}
    </style>
    


</div>
   
   @endsection
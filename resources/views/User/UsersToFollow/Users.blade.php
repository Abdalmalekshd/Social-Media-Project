@extends('layout.UserMaster')

@section('content')

<?php 
$Nosidebar='';

?>



    
    <div class="row">

        @if($user)

        @foreach ($user as $user)
<div class="col-md-12 users" style="color:white;margin-left:20px">
    @if(!$user->avatar)
    <a href="{{ route('Show.User.Profile',$user->id) }}" style="text-decoration: none;">  
    <img src="{{ url('img.png') }}" alt="">
        @else
        <img src="{{  url('Images/Avatar/', $user->avatar) }}" alt=""> 
        @endif 
    </a>

    <a href="{{ route('Show.User.Profile',$user->id) }}" style="text-decoration: none;width: 200px;margin-right:700px;color:white;
  font-size: 20px;">  
        
        {{ $user->name }}
    
</a>


    @if(! \App\Models\Follower::where('user_id',auth()->id())->where('followed_id',$user->id)->first())
        <a class='btn btn-primary' href="{{ route('User.follow',$user->id) }}">{{ __('messages.fllw') }}</a>
    @else
    <a class='btn btn-default' href="{{ route('User.follow.cancel',$user->id) }}">{{ __('messages.unfllw') }}</a>

        @endif
</div>
@endforeach
@else

<form class="search"  action="{{ route('search.users') }}">
    <input type="search" name="search" placeholder="search..." style="width:500px;margin-left:250px;
    border-radius:50px">
</form>
@foreach ($suggested_users as $users)
        

    <div class="col-md-12 users" style="color:white;margin-left:20px">
        @if(!$users->avatar)
            
        <img src="{{ url('img.png') }}" alt="">
            @else
            <img src="{{  url('Images/Avatar/', $users->avatar) }}" alt=""> 
            @endif 
            <label for="">
            {{ $users->name }}
        </label>
    
            <a class='btn btn-primary' href="{{ route('User.follow',$users->id) }}">{{ __('messages.fllw') }}</a>
        
    </div> 
 @endforeach

 <div class="paginatelink">
    {{ $suggested_users->links() }}
</div>

@endif 
    


    </div>
    
  </div>

<style>
    .paginatelink nav{
        margin-left: 300px;
        padding: 10px;
    }

    .paginatelink nav a{
        width: 100px;
    margin-left: 100px;
    text-decoration: none;
    padding: 5px;

    }

</style>




@endsection
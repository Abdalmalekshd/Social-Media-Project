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
        <img src="{{  url('Images/avatar/', $user->avatar) }}" alt=""> 
        @endif 
    </a>

    <a href="{{ route('Show.User.Profile',$user->id) }}" style="text-decoration: none;width: 200px;margin-right:700px;color:white;
  font-size: 20px;">  
        
        {{ $user->name }}
    
</a>


    @if(! \App\Models\Follower::where('user_id',auth()->id())->where('followed_id',$user->id)->first())
        <button  user_id='{{ $user->id }}' class="btn btn-primary followbtn">{{ __('messages.fllw') }}</button>
    
        @else
    <button user_id='{{$user->id}}' title="{{ __('messages.unfllw') }} " class="btn btn-default unfollow"><li> {{ __('messages.unfllw') }}  </li>
            
        
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
            <img src="{{  url('Images/avatar/', $users->avatar) }}" alt=""> 
            @endif 
            <label for="">
            {{ $users->name }}
        </label>
    

            @if(! \App\Models\Follower::where('user_id',auth()->id())->where('followed_id',$users->id)->first())
            <button  user_id='{{ $users->id }}' class="btn btn-primary followbtn">{{ __('messages.fllw') }}</button>
    
            @else
        <button user_id='{{$users->id}}' title="{{ __('messages.unfllw') }}" class="btn btn-default unfollow"><li> {{ __('messages.unfllw') }} </li>
            
        @endif

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

<script>
//Start follow user 
$(document).on('click','.followbtn',function(e){
        e.preventDefault();

        let UserId=$(this).attr('user_id');
        
    $.ajax({
        type: 'post',
        url: "{{ route('User.follow') }}",
        data: {
            '_token':"{{csrf_token()}}",
            'id':UserId
        },
        success: function (data) {

            if (data.status == true) {

            }
        },
        
        error: function (reject) {
            var response = $.parseJSON(reject.responseText);
            $.each(response.errors, function (key, val) {
                $("#" + key + "_error").text(val[0]);
            });
        }
    });
});

    //End follow user 


//Start Delete follow user 

$(document).on('click','.unfollow',function(e){
        e.preventDefault();

        let UserId=$(this).attr('user_id');
        
    $.ajax({
        type: 'post',
        url: "{{ route('User.follow.cancel') }}",
        data: {
            '_token':"{{csrf_token()}}",
            'id':UserId
        },
        success: function (data) {

            if (data.status == true) {

            }
        },
        
        error: function (reject) {
            var response = $.parseJSON(reject.responseText);
            $.each(response.errors, function (key, val) {
                $("#" + key + "_error").text(val[0]);
            });
        }
    });
});

        //End Delete follow user
</script>

@endsection
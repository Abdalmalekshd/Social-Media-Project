@extends('layout.UserMaster')

@section('content')

<?php 
$Nosidebar='';


?>

    
    <div class="row">
        <div class="col-md-12">
            @if (isset($showpost) && count($showpost) > 0)
            @foreach ($showpost as $bookmark)

                

            <div class="user-img">
                <a href="{{ route('Show.User.Profile',$bookmark->post->user->id) }}" style="text-decoration:none;">  @if(!$bookmark->post->user->avatar)
            <img src="{{ url('img.png') }}" alt="">
                @else
            <img src="{{ url('Images/Avatar/',$bookmark->post->user->avatar)}}" class="" alt=""> 
                @endif
                <span style="font-size: 20px;color: white;">{{ $bookmark->post->user->name }}</span></a>
            
                <div class="post-time" style="margin-top:-53px">
                    @if( \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $bookmark->post->created_at)->diffInDays(\Carbon\Carbon::now()) > 30)
                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $bookmark->post->created_at)->diffInMonths(\Carbon\Carbon::now()) }}Months
                    @else
                    @if( \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $bookmark->post->created_at)->diffInHours(\Carbon\Carbon::now()) > 24)
                    {{  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $bookmark->post->created_at)->diffInDays(\Carbon\Carbon::now())}}Days
                    @else
                    @if( \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $bookmark->post->created_at)->diffInDays(\Carbon\Carbon::now()) < 1 &&  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->diffInHours(\Carbon\Carbon::now()) < 1)
                    {{  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $bookmark->post->created_at)->diffInMinutes(\Carbon\Carbon::now())}}Minutes
                    @else
                    {{  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $bookmark->post->created_at)->diffInHours(\Carbon\Carbon::now())}}Hours
                    @endif
        
                    @endif
                    
                    @endif
                </div>    
            
            
            </div>

            <!-- three dot menu -->
            <div class="postoptions1">
                <!-- three dots -->
                <ul class="icons btn-right showLeft" >
                    @if ($bookmark->post->user_id == Auth::user()->id)
                    <a href="{{ route('edit.post',$bookmark->post->id) }}" title="{{ __('messages.edit') }}"><li>
                        {{ __('messages.edit') }}               
                    
                    </li></a>    

                    <a href="{{ route('delete.post',$bookmark->post->id)}}" >
                        <li title="{{ __('messages.dlt') }}">
                            {{ __('messages.dlt') }}

                    </li></a>
                    @else
                    <a href="{{ route('get.report',$bookmark->post->id) }}" ><li title="{{ __('messages.report') }}">
                        {{ __('messages.report') }}                    

                    </li></a>  
                    @if( \App\models\Follower::where('user_id',Auth::user()->id)->where('followed_id',$bookmark->post->user->id)->first())
                    <button  user_id='{{$bookmark->post->user->id}}' class="unfollow" title="{{ __('messages.unfllw') }}  "><li> {{ __('messages.unfllw') }}  </li>
                        
                    @else
                    <button  user_id='{{ $bookmark->post->user->id }}' class="btn btn-primary followbtn">{{ __('messages.fllw') }}</button>
                    @endif
                    
                    </a>
                        @endif
                    
                    
                </ul>
            
            </div>

            

                    <a class="showpost" href="{{ route('show.single.post',$bookmark->post->id) }}">
                @foreach ($bookmark->post->images as $images)
                                    
        <div class="post-img-author-description"><img src="{{ url('Images/posts/' . $images->photo)}}" class="img-thumbnail" alt=""> 
            @endforeach
                    
                
            <p>{{ $bookmark->post->content }}</p></div>
        <div class="reactian1">
            @if( \App\Models\Like::where('post_id',$bookmark->post->id)->Where('user_id',auth()->id())->first())
            <button post_id='{{ $bookmark->post->id }}'  class="unlikepost" title="unlike"><i class="fa fa-heart" style="color: red"></i></button> <span> {{ $bookmark->like_count }} {{ __('messages.like') }}</span>
            
            @else
            <button post_id='{{ $bookmark->post->id }}' class="likepost"   title="like"><i class="fa fa-heart-o"></i></button> <span>{{ $bookmark->like_count }} {{ __('messages.like') }}</span>
            
            @endif
        
        
        <a href=""><i class="fa fa-comment-o"></i></a><span>{{ \App\Models\Comment::where('post_id',$bookmark->post->id)->count() }} {{ __('messages.comment') }}</span>


            
            @if(\App\Models\BookmarkPost::where('post_id',$bookmark->post->id)->where('user_id',Auth::user()->id)->first())
        <button post_id='{{ $bookmark->post->id }}' class="dltbookmarkpost" ><i class="fa fa-bookmark"></i></button>
        @else
        <button post_id='{{ $bookmark->post->id }}' class="bookmarkpost" ><i class="fa fa-bookmark-o"></i></button>

        @endif
    </div>

    <br>
    <br>
    

    @endforeach
    
</a>
    @else
        <div class="text-center saved">You Don't Have Any Saved Posts Yet</div>
    
    @endif

</div>

</div>


<script>
    //Start Like Post 
    $(document).on('click','.likepost',function(e){
        e.preventDefault();

        let PostId=$(this).attr('post_id');
        
    $.ajax({
        type: 'post',
        url: "{{ route('like.post') }}",
        data: {
            '_token':"{{csrf_token()}}",
            'id':PostId
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

    //End Like Post 


    //Start UnLike Post 

$(document).on('click','.unlikepost',function(e){
        e.preventDefault();

        let PostId=$(this).attr('post_id');
        
    $.ajax({
        type: 'post',
        url: "{{ route('delete.like.post') }}",
        data: {
            '_token':"{{csrf_token()}}",
            'id':PostId
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

    //End UnLike Post 

//Start Bookmark Post 
$(document).on('click','.bookmarkpost',function(e){
        e.preventDefault();

        let PostId=$(this).attr('post_id');
        
    $.ajax({
        type: 'post',
        url: "{{ route('bookmark.post') }}",
        data: {
            '_token':"{{csrf_token()}}",
            'id':PostId
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

    //End Bookmark Post 


    //Start Delete Bookmarked Post 

$(document).on('click','.dltbookmarkpost',function(e){
        e.preventDefault();

        let PostId=$(this).attr('post_id');
        
    $.ajax({
        type: 'post',
        url: "{{ route('delete.bookmarked.post') }}",
        data: {
            '_token':"{{csrf_token()}}",
            'id':PostId
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

        //End Delete Bookmarked Post 

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
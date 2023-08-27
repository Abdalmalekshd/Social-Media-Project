@extends('layout.UserMaster')

@section('content')

@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
        @include('sweetalert::alert')

@foreach ($followed_users as $user)
@foreach ($user->user->post as $post)
    

            <div class="post">
            <div class="user-img">
                <a href="{{ route('Show.User.Profile', $user->user->id) }}">
                @if(!$user->user->avatar)
            <img src="{{ url('img.png') }}" alt="">
                @else
            <img src="{{ url('Images/avatar/',$user->user->avatar)}}" class="" alt=""> 
                @endif
                
                <span>{{ $user->user->name }} </span> 

                    
                </a>
                
                <div class="post-time">
                    @if( \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->diffInDays(\Carbon\Carbon::now()) > 30)
                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->diffInMonths(\Carbon\Carbon::now()) }}Months
                    @else
                    @if( \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->diffInHours(\Carbon\Carbon::now()) > 24)
                    {{  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->diffInDays(\Carbon\Carbon::now())}}Days
                    @else
                    @if( \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->diffInDays(\Carbon\Carbon::now()) < 1 &&  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->diffInHours(\Carbon\Carbon::now()) < 1)
                    {{  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->diffInMinutes(\Carbon\Carbon::now())}}Minutes
                    @else
                    {{  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->diffInHours(\Carbon\Carbon::now())}}Hours
                    @endif
        
                    @endif
                    
                    @endif
                </div>
        </div>

                            <!-- three dot menu -->
                            <div class="postoptions">
                                    
                                <!-- three dots -->
                                <ul class="icons btn-right showLeft" >
                                    @if ($post->user_id == Auth::user()->id)
                                    <a href="{{ route('edit.post',$post->id) }}" title="Edit"><li>
                                        {{ __('messages.edit') }}
                
                                    
                                    </li></a>    

                                    <a href="{{ route('delete.post',$post->id)}}" >
                                        <li title="Delete">
                                            {{ __('messages.dlt') }}


                                    </li></a>
                                    @else
                                    <a href="{{ route('get.report',$post->id) }}"><li>    
        {{ __('messages.report') }}
    
    </li>
</a>
<li>
                                    <button  user_id='{{ $user->user->id }}' class='unfollow' title=""> 
<li>
    {{ __('messages.unfllw') }}
</li>

                                    </button>
                                        @endif
                                    
                                    
                                </ul>
                                
                            
                            </div>

        <a class="showpost" href="{{ route('show.single.post',$post->id) }}">
                            

@foreach ($post->images as $image)
    @if($image->post_id == $post->id)
    
        <a class="showpost" href="{{ route('show.single.post',$post->id) }}">
    <div class="post-img-author-desc"><img src="{{ url('Images/posts/' . $image->photo)}}" class="img-thumbnail" alt=""> 
    @endif
                
@endforeach
                    
                
            <p>{{ $post->content }}</p></div>
        <div class="reactian">
            @if( \App\Models\Like::where('post_id',$post->id)->Where('user_id',auth()->id())->first())
            <button post_id='{{ $post->id }}'  class="unlikepost" title="unlike"><i class="fa fa-heart" style="color: red"></i></button> <span> {{ $post->like_count }} {{ __('messages.like') }}</span>
            
            @else
            <button post_id='{{ $post->id }}' class="likepost"   title="like"><i class="fa fa-heart-o"></i></button> <span>{{ $post->like_count }} {{ __('messages.like') }}</span>
            
            @endif
            
            
            <a href=""><i class="fa fa-comment-o"></i></a> <span>{{ $post->comments_count }} {{ __('messages.comment') }}</span>


            
                
                @if(\App\Models\BookmarkPost::where('post_id',$post->id)->where('user_id',Auth::user()->id)->first())
            <button post_id='{{ $post->id }}' class="dltbookmarkpost" ><i class="fa fa-bookmark"></i></button>
            @else
            <button post_id='{{ $post->id }}' class="bookmarkpost" ><i class="fa fa-bookmark-o"></i></button>

            @endif
        </div>
        </div>
    </a> 
    @endforeach


    
@endforeach
    


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
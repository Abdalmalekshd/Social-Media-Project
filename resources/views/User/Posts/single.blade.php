@extends('layout.UserMaster')

@section('content')

<?php
$Nosidebar='';
?>

<div class="row">
    <div class="col-md-12">
        <div class="post">
        <div class="user-img">
            <a href="{{ route('Show.User.Profile',$post->user->id) }}">@if(!$post->user->avatar)
        <img src="{{ url('img.png') }}" alt="">
            @else
        <img src="{{ url('Images/avatar/', $post->user->avatar)}}" class="" alt="">
            @endif

            <span>{{ $post->user->name }}</span> </a>
            <div class="post-time" style="margin-top:-53px">
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
                        <div class="postoptions1">
                            <!-- three dots -->
                            <ul class="icons btn-right showLeft" >
                                @if ($post->user_id == Auth::user()->id)
                                <a href="{{ route('edit.post',$post->id) }}" title="{{ __('messages.edit') }}"><li>
                                    {{ __('messages.edit') }}

                                </li></a>

                                <a href="{{ route('delete.post',$post->id)}}" >
                                    <li title="{{ __('messages.dlt') }}">
                                        {{ __('messages.dlt') }}

                                </li></a>
                                @else
                                <a href="{{ route('get.report',$post->id) }}" ><li title="{{ __('messages.report') }}">
                                    {{ __('messages.report') }}

                                </li></a>
                @if( \App\models\Follower::where('user_id',Auth::user()->id)->where('followed_id',$post->user->id)->first())

            <button user_id='{{$post->user->id}}' title="{{ __('messages.unfllw') }} " class="unfollow"><li> {{ __('messages.unfllw') }}  </li>

            @else
            <button  user_id='{{ $post->user->id }}' class="btn btn-primary followbtn">{{ __('messages.fllw') }}</button>
            @endif

                                </a>
                                    @endif


                            </ul>

                        </div>



@foreach ($post->images as $image)
@if($image->post_id == $post->id )

<div class="post-img-author-description"><img src="{{ url('Images/posts/' . $image->photo)}}" class="img-thumbnail" alt="">
@endif

@endforeach


        <p>{{ $post->content }}</p></div>
    <div class="reactian1">
        @if( \App\Models\Like::where('post_id',$post->id)->Where('user_id',auth()->id())->first())
            <button post_id='{{ $post->id }}'  class="unlikepost" title="unlike"><i class="fa fa-heart" style="color: red"></i></button> <span> {{ $post->like_count }} {{ __('messages.like') }}</span>

            @else
            <button post_id='{{ $post->id }}' class="likepost"   title="like"><i class="fa fa-heart-o"></i></button> <span>{{ $post->like_count }} {{ __('messages.like') }}</span>

            @endif


        <a href=""><i class="fa fa-comment-o"></i></a><span>{{ $post->comments_count }} {{ __('messages.comment') }}</span>




            @if(\App\Models\BookmarkPost::where('post_id',$post->id)->where('user_id',Auth::user()->id)->first())
            <button post_id='{{ $post->id }}' class="dltbookmarkpost" ><i class="fa fa-bookmark"></i></button>
            @else
            <button post_id='{{ $post->id }}' class="bookmarkpost" ><i class="fa fa-bookmark-o"></i></button>

        @endif
    </div>
    </div>

</div>

</div>
<div class="comments-area text-dark">
<div class="row">
    <div class="col-md-12 comments">
        <h4 class="text-center">Post Comments</h4>
        @foreach ($comments as $comment)
        <div class="comment">
        <div class="commenter-info">
            <a href="{{ route('Show.User.Profile',$comment->user->id) }}" style="text-decoration:none;margin-left: -400px;color:white;">
                @if($comment->user->avatar)
            <img src="{{ url('Images/Avatar/', $comment->user->avatar)}}" class="rounded-circle" alt="">
            @else
            <img src="{{ url('img.png')}}" class="rounded-circle" alt="">

            @endif
            {{ $comment->user->name }}</div></a>
        <span>{{ $comment->comment }}</span>

</div>
        <div class="editcommentbtn">
            @if($post->user_id == auth()->id() || $comment->user_id == auth()->id())

        <a href="{{ route('user.dlt.comment',$comment->id) }}" class="fa fa-close text-danger dlt">{{ __('messages.dlt') }}</a>
        @endif
        @if($comment->user_id == auth()->id())
        <a href="{{ route('edit.comment', $comment->id) }}"
            class="fa-solid fa-user-pen
            text-primary rounded-pill border border-0 edit">{{ __('messages.edit') }}</a>

        <a id="open-comm1-btn" class="d-none" data-bs-toggle="modal" data-bs-target="#comment1"></a>

        <a href="{{ route('get.replay.comment', $comment->id) }}"
            class="fa-solid fa-user-pen
            text-primary rounded-pill border border-0  replay">{{ __('messages.replay') }}</a>

        <a id="open-replay1-btn" class="d-none" data-bs-toggle="modal" data-bs-target="#replay1"></a>



@else



<a href="{{ route('get.report',$comment->id) }}" class="text-danger report">{{ __('messages.report') }}</a>


<a href="{{ route('get.replay.comment', $comment->id) }}"
    class="fa-solid fa-user-pen
    text-primary rounded-pill border border-0  replay">{{ __('messages.replay') }}</a>

<a id="open-replay1-btn" class="d-none" data-bs-toggle="modal" data-bs-target="#replay1"></a>

</div>


        @endif
    </div>


        <div class="replaycomments">
            @isset($comment -> childrens)

            <div class="row">
                <div class="col-md-12 comments">

                    @foreach($comment -> childrens as $childern)
                    <div class="comment">
                    <div class="commenter-info">
                       <h5 class="text-center">Replays To {{ $comment->user->name }} Comment </h5>
                         <a href="{{ route('Show.User.Profile',$childern->user->id) }}" style="text-decoration:none;margin-left: -400px;color:white;">
                            @if($childern->user->avatar)
                        <img src="{{ url('Images/Avatar/', $childern->user->avatar)}}" class="rounded-circle" alt="">
                        @else
                        <img src="{{ url('img.png')}}" class="rounded-circle" alt="">

                        @endif
                        {{ $childern ->user->name }}</div></a>
                    <span>{{ $childern->comment }}</span>

                    <div class="editcommentbtn">
                        @if($post->user_id == auth()->id() || $comment->user_id == auth()->id() || $childern->user_id == auth()->id())

                    <a href="{{ route('user.dlt.comment',$childern->id) }}" class="fa fa-close text-danger dlt">{{ __('messages.dlt') }}</a>
                    @endif
                    @if($comment->user_id == auth()->id())
                    <a href="{{ route('edit.comment', $childern->id) }}"
                        class="fa-solid fa-user-pen
                        text-primary rounded-pill border border-0 edit">{{ __('messages.edit') }}</a>

                    <a id="open-comm1-btn" class="d-none" data-bs-toggle="modal" data-bs-target="#comment1"></a>

                    <a href="{{ route('get.replay.comment', $childern->id) }}"
                        class="fa-solid fa-user-pen
                        text-primary rounded-pill border border-0  replay">{{ __('messages.replay') }}</a>

                    <a id="open-replay1-btn" class="d-none" data-bs-toggle="modal" data-bs-target="#replay1"></a>



            @else



            <a href="{{ route('get.report',$childern->id) }}" class="text-danger report">{{ __('messages.report') }}</a>


            <a href="{{ route('get.replay.comment', $childern->id) }}"
                class="fa-solid fa-user-pen
                text-primary rounded-pill border border-0  replay">{{ __('messages.replay') }}</a>

            <a id="open-replay1-btn" class="d-none" data-bs-toggle="modal" data-bs-target="#replay1"></a>



                    @endif
                </div>



                @endforeach
        @endisset

<hr>

        @endforeach


    </div>


    <div class="col-md-12 comment-form">
    <form action="{{ route('comment.post') }}" method="POST" class="form-comment">
        @csrf
    <input type="hidden" name="post_id"  value="{{ $post->id }}">

    <input type="text" name="comment" class="comment-input" placeholder="{{ __('messages.putacomment') }}">


    <button class="btn btn-success" title="comment"><i class="fa fa-send"></i></button>
    <br>
    @error('comment')
    <div  class="alert alert-danger text-center">{{ $message }}</div>
    @enderror



    @if (Session::has('success'))
    <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
@endif
</form>
</div>
</div>

{{-- Edit Comment Form --}}

@if ($comm)
<div class="modal
                        fade border border-3 shadow-lg" id="comment1"
    aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="hedar">

                <label class="ms-3 mt-3">
                    <h3>Edit Your Comment</h3>
                </label>
                <hr width=100% color=#898585>
            </div>



            <div class="modal-body col-sm-12">
                <form id="FormUpdate" method="POST" action="{{ route('update.comment') }}">
                    @csrf

                    <input type="hidden" name="comment_id" value="{{ $comm->id }}" class="d-none" />
                    @error('comment_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                    <div class="form-group">
                        <label for="" class="control-label ps-3">{{ __('messages.edit') }}</label><br>
                        <input type="text" value="{{ $comm->comment }}"
                            class="form-control ms-1" name='comment' placeholder="Enter Your Comment">
                            @error('comment')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                    </div>





                    <div class="modal-footer col-sm-12">

                        <button type="submit" style="width: 600px" class="btn btn-outline-danger float-end me-3 mt-2">
                            Update</button>


                        <a  href="{{ route('show.single.post',$comm->post->id) }}" class="btn btn-outline-primary float-end me-3 mt-3">Cancel</a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endif

 {{--  Replay Form  --}}
@if ($comme)
<div class="modal
                        fade border border-3 shadow-lg" id="replay1"
    aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="hedar">

                <label class="ms-3 mt-3">
                    <h3>Replay To {{ $comme->user->name }} Comment</h3>
                </label>
                <hr width=100% color=#898585>
            </div>



            <div class="modal-body col-sm-12">
                <form  method="POST" action="{{ route('replay.comment') }}">
                    @csrf

                    <input type="hidden" name="parent_id" value="{{ $comme->id }}" class="d-none" />
                    @error('parent_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                            @enderror


                    <input type="hidden" name="post_id" value="{{ $comme->post->id }}" class="d-none" />
                    @error('post_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                    <div class="form-group">
                        <label for="" class="control-label ps-3">{{ __('messages.replay') }}</label><br>
                        <input type="text"
                            class="form-control ms-1" name='replay' placeholder="Enter Your replay">
                            @error('replay')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                    </div>





                    <div class="modal-footer col-sm-12">

                        <button type="submit" style="width: 600px" class="btn btn-outline-danger float-end me-3 mt-2">
                            Replay</button>


                        <a  href="{{ route('show.single.post',$comm->post->id) }}" class="btn btn-outline-primary float-end me-3 mt-3">Cancel</a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endif

<script>
window.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('open-comm1-btn').click()
    });

    window.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('open-replay1-btn').click()
    });


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




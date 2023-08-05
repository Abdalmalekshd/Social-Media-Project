@extends('layout.UserMaster')

@section('content')

<?php 
$Nosidebar='';
?>

<div class="row">
    <div class="col-md-12">
        <div class="post">
        <div class="user-img">
            @if(!$post->user->avatar)
        <img src="{{ url('img.png') }}" alt="">
            @else
        <img src="{{ url('Images/Avatar/', $post->user->avatar)}}" class="" alt=""> 
            @endif
            
            <span>{{ $post->user->name }}</span> 
            <div class="post-time" style="margin-top:-30px">
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

                                <a href="{{ route('User.follow.cancel',$post->user->id) }}" title="{{ __('messages.unfllw') }}  "><li> {{ __('messages.unfllw') }}  </li>

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
        <a href="{{ route('delete.like.post',$post->id) }}" title="unlike"><i class="fa fa-heart" style="color: red"></i></a><span>{{ $post->like_count }} {{ __('messages.like') }}</span>
        
        @else
        <a href="{{ route('like.post',$post->id) }}" title="like"><i class="fa fa-heart-o"></i></a><span>{{ $post->like_count }} {{ __('messages.like') }}</span>
        
        @endif
        
        
        <a href=""><i class="fa fa-comment-o"></i></a><span>{{ $post->comments_count }} {{ __('messages.comment') }}</span>


        
            
            @if(\App\Models\BookmarkPost::where('post_id',$post->id)->where('user_id',Auth::user()->id)->first())
        <a href="{{ route('delete.bookmarked.post',$post->id) }}"><i class="fa fa-bookmark"></i></a>
        @else
        <a href="{{ route('bookmark.post',$post->id) }}"><i class="fa fa-bookmark-o"></i></a>

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
        <div class="commenter-info"><img src="{{ url('Images/Avatar/', $comment->user->avatar)}}" class="rounded-circle" alt="">
        {{ $comment->user->name }}</div>
        <span>{{ $comment->comment }}</span>
        @if($comment->user_id == auth()->id())
        <div class="editcommentbtn">
        <a href="{{ route('dlt.comment',$comment->id) }}" class="text-danger">{{ __('messages.dlt') }}</a>
        <a href="" class="text-success">{{ __('messages.edit') }}</a>
</div>

@else
<a href="{{ route('get.report',$comment->id) }}" class="text-danger">{{ __('messages.report') }}</a>
{{-- <a href="" class="text-danger">Replay</a> --}}

        @endif
        
            

        
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
</form>
</div>
</div>



@endsection




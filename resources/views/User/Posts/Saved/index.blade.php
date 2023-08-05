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
                @if(!$bookmark->post->user->avatar)
            <img src="{{ url('img.png') }}" alt="">
                @else
            <img src="{{ url('Images/Avatar/',$bookmark->post->user->avatar)}}" class="" alt=""> 
                @endif
                <span>{{ $bookmark->post->user->name }}</span>
            
                <div class="post-time" style="margin-top:-30px">
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

                    <a href="{{ route('User.follow.cancel',$bookmark->post->user->id) }}" title="{{ __('messages.unfllw') }}  "><li> {{ __('messages.unfllw') }}  </li>

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
        <a href="{{ route('delete.like.post',$bookmark->post->id) }}" title="unlike"><i class="fa fa-heart" style="color: red"></i></a><span>{{ \App\Models\Like::where('post_id',$bookmark->post->id)->count() }} {{ __('messages.like') }}</span>
        
        @else
        <a href="{{ route('like.post',$bookmark->post->id) }}" title="like"><i class="fa fa-heart-o"></i></a><span>{{ \App\Models\Like::where('post_id',$bookmark->post->id)->count() }} {{ __('messages.like') }}</span>
        
        @endif
        
        
        <a href=""><i class="fa fa-comment-o"></i></a><span>{{ \App\Models\Comment::where('post_id',$bookmark->post->id)->count() }} {{ __('messages.comment') }}</span>


            
            @if(\App\Models\BookmarkPost::where('post_id',$bookmark->post->id)->where('user_id',Auth::user()->id)->first())
        <a href="{{ route('delete.bookmarked.post',$bookmark->post->id) }}"><i class="fa fa-bookmark"></i></a>
        @else
        <a href="{{ route('bookmark.post',$bookmark->post->id) }}"><i class="fa fa-bookmark-o"></i></a>

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



@endsection
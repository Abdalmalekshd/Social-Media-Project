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
            <img src="{{ url('Images/Avatar/',$user->user->avatar)}}" class="" alt=""> 
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

                                    <a href="{{ route('User.follow.cancel',$user->user->id) }}" title=""><li> {{ __('messages.unfllw') }}</li>

                                    </a>
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
            <a href="{{ route('delete.like.post',$post->id) }}" title="unlike"><i class="fa fa-heart" style="color: red"></i></a> <span> {{ $post->like_count }} {{ __('messages.like') }}</span>
            
            @else
            <a href="{{ route('like.post',$post->id) }}" title="like"><i class="fa fa-heart-o"></i></a> <span>{{ $post->like_count }} {{ __('messages.like') }}</span>
            
            @endif
            
            
            <a href=""><i class="fa fa-comment-o"></i></a> <span>{{ $post->comments_count }} {{ __('messages.comment') }}</span>


            
                
                @if(\App\Models\BookmarkPost::where('post_id',$post->id)->where('user_id',Auth::user()->id)->first())
            <a href="{{ route('delete.bookmarked.post',$post->id) }}"><i class="fa fa-bookmark"></i></a>
            @else
            <a href="{{ route('bookmark.post',$post->id) }}"><i class="fa fa-bookmark-o"></i></a>

            @endif
        </div>
        </div>
    </a> 
    @endforeach


    
@endforeach
   
    
@endsection
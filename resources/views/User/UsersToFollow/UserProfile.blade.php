@extends('layout.UserMaster')

@section('content')

<?php 
$Nosidebar='';

?>


<div class="user-header-wrapper">
    <div class="user-header-inner">
      <div class="uh-left">
        <div class="uh-image">
            @if ($user->avatar)
            <img class="profile-img" src="{{  url('Images/Avatar/', $user->avatar) }}" alt="">
                                    
                @else
                    
            <img class="profile-img" src="{{ url('img.png') }}" alt="">
                
            @endif
        
        </div>
    </div>
    <div class="uh-right">
        <div class="user-info">
        <h3>
            {{ $user->name }}
            @if($countFollowers > 10)
            <svg class="uname-verified" style="position: absolute;margin-left: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1350.03 1326.16">
                                <defs><style>.cls-11{fill:var(--blue);}.cls-12{fill:#ffffff;}</style></defs><title>verified</title>
                                <g id="Layer_3" data-name="Layer 3">
                                    <polygon class="cls-11" points="0 747.37 120.83 569.85 70.11 355.04 283.43 292.38 307.3 107.41 554.93 107.41 693.66 0 862.23 120.83 1072.57 126.8 1112.84 319.23 1293.35 399.79 1256.05 614.6 1350.03 793.61 1197.87 941.29 1202.35 1147.15 969.64 1178.48 868.2 1326.16 675.02 1235.17 493.77 1315.72 354.99 1133.73 165.58 1123.29 152.16 878.64 0 747.37"/></g>
                                <g id="Layer_2" data-name="Layer 2">
                                    <path class="cls-12" d="M755.33,979.23s125.85,78.43,165.06,114c34.93-36,234.37-277.22,308.24-331.94,54.71,21.89,85,73.4,93,80.25-3.64,21.89-321.91,418.58-368.42,445.94-32.74-3.84-259-195.16-275.4-217C689.67,1049.45,725.24,1003.85,755.33,979.23Z" transform="translate(-322.83 -335.95)"/></g>
                            </svg>
                            @endif
        </h3>
        @if(!$blocked)
          
        
        @if ($user->id == Auth::user()->id)
        <a class="btn btn-default editProfilebtn" href="{{ route('user.profile.edit') }}">{{ __('messages.edtprf')}}</a>
        @else
        @if($follower)
        <a class="btn btn-default editProfilebtn" href="{{ route('User.follow.cancel',$user->id) }}">{{ __('messages.unfllw')}}</a>
        <a class="btn btn-danger editProfilebtn blkuser" href="{{ route('User.block',$user->id) }}">{{ __('messages.blck') }}</a>
        <a class="btn btn-danger editProfilebtn blkuser" href="{{ route('get.report',$user->id) }}">{{ __('messages.report') }}</a>
        
        @else

        @if(!$blockeduser)
        <a class="btn btn-primary editProfilebtn" href="{{ route('User.follow',$user->id) }}">{{ __('messages.fllw') }}</a>
        @else
        <a class="btn btn-danger editProfilebtn blkuser" href="{{ route('User.UnBlock',$user->id) }}">{{ __('messages.unblck') }}</a>
        
        @endif
        
        @endif
        @endif
      @if(!$blockeduser)
        
      </div>
        <div class=user-links>
        <a><span>{{ $countposts }}</span> {{ __('messages.posts') }}</a>
        <a><span>{{ $countFollowers }}</span> {{ __('messages.fllwrs') }}</a>
        <a><span>{{ $countFollowing }}</span> {{ __('messages.fllwing') }}</a>
        </div>
        @if ($user->description)
        <div class="user-bio">
        <p>{{ $user->description }}</p>
        </div>

        @endif
        

    </div>
    </div>
    </div>
    <hr>
    
    </div>
    <div class="user-page-wrapper">
    <div class="user-page-inner">
    <div id="imgblock1" class="image-block">
      @foreach ($post as $post)
      @forelse ($post->images as $image)

        <div id="imgblockbc1" class="block-background"></div>
      </div>

      <div id="img1" class="image-wrapper">
        <div id="iov1" class="img-overlay-wrapper">
          

        <a href="{{ route('show.single.post',$post->id) }}"> <div class="img-overlay"></div>
        </div>
        
        <img src="{{ url('images/posts/',$image -> photo ?? '')}}" alt="" class="img-fluid" />
        </a>
          @break
    @empty
        {{-- If for some reason the business has no images, you can put here some kind of placeholder image, using 3rd party services or maybe your own generic image --}}
        <img src="//via.placeholder.com/150x150" alt="" class="img-fluid" />
    @endforelse

    
        @endforeach
@else
    </div> 

<div class="row">
  
<div class="text-danger blkmsg">You Blocked This User</div>

</div>
@endif
    </div> 
    </div>
    @else
  </div> 
    
<div class="text-danger">
This User Has Blocked You
</div>
    @endif

   <style>
   html, body {
	margin: 0;
  width: 100%;
  min-height: 100vh;
	overflow-x: hidden;
	font-family: var(--font-family-sans-serif);
  scroll-behavior: smooth;
	-webkit-font-smoothing: antialiased;
  background-color: var(--light-mode-brig);
  color: var(--white);
}


.editProfilebtn {
  margin: 0 70px ;
  border-radius: 3px;
  border: 1px solid var(--white);
  padding: .4em .6em;
  cursor: pointer;
  margin-right: -10px;
  width: 200px;
}
</style>


  @endsection
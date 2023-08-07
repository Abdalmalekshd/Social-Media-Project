<div class="ppl-to-follow">
    <form class="search"  action="{{ route('search.users') }}">
        <input type="search" name="search" placeholder="search...">
    </form>
    <h5>{{ __('messages.sugtofllw') }}</h5>
<ul class="list-unstyled navbar">
    <a href=""><li class="nav-li">
        @if(!$current_user->avatar)
            
        <img src="{{ url('img.png') }}" alt="">
            @else
        <img src="{{  url('Images/Avatar/',$current_user->avatar) }}" alt=""> 
        @endif
        <span class="name">{{ \App\Models\User::where('id',Auth::user()->id)->first()->name }}
        </span>
        
    </li></a>
        @foreach ($suggested_users as $user)
        
        <a href="{{ route('Show.User.Profile',$user->id) }}" class="fllw">
            <li class="nav-li">
        @if(!$user->avatar)
            
        <img src="{{ url('img.png') }}" alt="">
            @else
            <img src="{{ url('Images/Avatar/',$user->avatar)}}" alt=""> 
            @endif
            <span>{{ $user->name }}</span>
            @if(! \App\models\Follower::where('user_id',Auth::user()->id)->where('followed_id',$user->id)->first())
            <button  user_id='{{ $user->id}}' class="btn btn-primary followbtn">{{ __('messages.fllw') }}</button>
            
            
            @endif
        </li></a>
            @endforeach

        <li class="nav-li">
            <a href="{{ route('users') }}" class="more">-----{{ __('messages.mre') }}-----</a>
        </li>
</ul>
</div>
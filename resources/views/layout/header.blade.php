
<nav class="flex-nav">
    <a href="#" class="toggleNav"><i class="fa fa-bars"></i> Menu</a>
    <ul>
      <li><a href="{{ route('user.home') }}" title="{{ __('messages.home') }}"><i class="fa fa-home"></i>{{ __('messages.home') }}</a></li>
      <li><a href="{{ route('AboutUs') }}" title="{{ __('messages.about') }}"><i class="fa fa-pen"></i> {{ __('messages.about') }}</a></li>
      <li><a href="{{ route('create.post') }}" title="{{ __('messages.create') }}"><i class="fa fa-plus-square-o"></i>{{ __('messages.create') }}</a></li>
      <li><a href="{{ url('/chatify') }}" title="{{ __('messages.msg') }}"><i class="fa fa-send-o"></i> {{ __('messages.msg') }}</a></li>
      <li><a href="{{ route('show.bookmarked.posts') }}" title="{{ __('messages.saved') }}"><i class="fa fa-bookmark-o"></i> {{ __('messages.saved') }}</a></li>

      <li class="social">
        <a href="" class="Notifications" title=""><i class="fa fa-bell-o fa-lg"></i></a>
        <span class='Notifications-count'>3+</span>
      </li>
        <li class="social profile" onclick="menuToggle();" >
          
          <a href="#">
                <i class="fa fa-user"></i>
              </a>
    
            <div class="menu">
                <h3>
                    {{ __('messages.wlc') }} {{ \App\Models\User::Where('id',auth()->id())->first()->name }}
                    
                </h3>
                <ul>
                  <a href="{{ route('user.profile') }}"><li>
                    {{ __('messages.prf') }}

                    </li></a>
                      <hr>
                      <a href="{{ route('logout') }}"><li>
                        {{ __('messages.lg') }}
                    </li></a>
                    
                </ul>
            </div>

      </li>
      
    </ul>
  </nav>

<br>
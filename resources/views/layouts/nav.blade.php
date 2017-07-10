<nav class="navbar-default navbar-static-side" role="navigation">
  <div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
      <li class="nav-header">
        <div class="dropdown profile-element">
          <span class="clear">
              <span class="block m-t-xs">
                  <strong class="font-bold">
                      <img src="{{ asset('logo.png') }}" width="100%" height="49px">
                  </strong>
              </span>
          </span>
        </div>
      </li>
      @foreach($navigation as $nav)
        @if($nav['granted'])
          <li class="{{ starts_with(Route::currentRouteName(), $nav['name']) ? 'active' : ''  }}">
            @if(!$nav['node'])
              <a href="{{ url($nav['path']) }}">
                <i class="{{ $nav['icon'] }}"></i>
                <span class="nav-label">{{ $nav['display_name'] }}</span>
              </a>
            @else
              <a href="#">
                <i class="{{ $nav['icon'] }}"></i>
                <span class="nav-label">{{ $nav['display_name'] }}</span>
                <span class="fa arrow"></span>
              </a>
              <ul class="nav nav-second-level">
                @foreach($nav['node'] as $node)
                  @if($node['granted'])
                    <li class="{{ starts_with(Route::currentRouteName(), $node['name']) ? 'active' : ''  }}">
                      <a href="{{ url($node['path']) }}">{{ $node['display_name'] }}</a>
                    </li>
                  @endif
                @endforeach
              </ul>
            @endif
          </li>
        @endif
      @endforeach
    </ul>
  </div>
</nav>

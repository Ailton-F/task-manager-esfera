<div class="area w-100 h-100 px-5 vh-100">
    {{$content}}
</div>
<nav class="main-menu bg-black h-100 left-0 top-0 bottom-0 position-fixed">
    <ul class="p-0 my-2">
        @if(auth()->user()->role == 'admin')
        <li>
            <a class="position-relative text-decoration-none" href="{{route('users.index')}}">
                <i class="position-relative text-center icon fa fa-users fa-2x"></i>
                <span class="nav-text position-relative">
                    Users dashboard
                </span>
            </a>
        </li>
        <li>
            <a class="position-relative text-decoration-none" href="{{route('tasks.index')}}">
                <i class="position-relative text-center icon fa fa-tasks fa-2x"></i>
                <span class="nav-text position-relative">
                    Tasks dashboard
                </span>
            </a>
        @else
        <li>
            <a class="position-relative text-decoration-none" href="{{route('tasks.index')}}">
                <i class="position-relative text-center icon fa fa-home fa-2x"></i>
                <span class="nav-text position-relative">
                    My tasks
                </span>
            </a>
        </li>
        @endif
    </ul>

    <ul class="p-0 position-absolute left-0 bottom-0 my-2">
        <li>
            <form class="position-relative text-decoration-none" method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button type="submit" class="p-0 m-0 bg-transparent border-0 text-white">
                    <i class="position-relative text-center icon fa fa-power-off fa-2x"></i>
                </button>
                <span class="nav-text position-relative p-0 ps-3">
                    Logout
                </span>
            </form>
        </li>
    </ul>
</nav>
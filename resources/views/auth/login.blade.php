@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/login.css') }}">
@endsection

<x-base>
    <x-slot name="content">
        @if ($errors->any())
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                 <div class="toast-header">
                    <small>Error</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    @foreach ($errors->all() as $error)
                        {{$error}}
                    @endforeach
                </div>
            </div>
        @endif
    
        <body class="m-0 p-0 d-flex justify-content-center align-items-center vh-100">
            <main class="main">  	
                <input class="d-none" type="checkbox" id="chk" aria-hidden="true">
                    <div class="position-relative w-100 h-100">
                        <form action="{{route('users.store')}}" method="POST">
                            @csrf
                            <div class="px-5">
                                <label class="d-flex justify-content-center m-5 fw-bold" for="chk" aria-hidden="true">Sign up</label>
    
                                <input class="form-control d-flex my-3 mx-auto p-2 border-0 rounded justify-content-center" type="text" name="name" placeholder="Name" required="">
                                <input class="form-control d-flex my-3 mx-auto p-2 border-0 rounded justify-content-center" type="email" name="email" placeholder="Email" required="">
                                <input class="form-control d-flex my-3 mx-auto p-2 border-0 rounded justify-content-center" type="password" name="password" placeholder="Password" required="">
                            </div>
                            <div class="px-5 d-flex flex-column justify-content-center">
                                <button type="submit" class="text-dark rounded border-0 py-2">Sign up</button>
                            </div>
                        </form>
                    </div>
    
                    <div class="login">
                        <form action="{{route('auth.login')}}" method="POST">
                            @csrf
                            <div class="px-5">
                                <label class="d-flex justify-content-center m-5 fw-bold" for="chk" aria-hidden="true">Login</label>
                                <input class="form-control d-flex my-3 mx-auto p-2 border-0 rounded justify-content-center" type="email" name="email" placeholder="Email" required="">
                                <input class="form-control d-flex my-3 mx-auto p-2 border-0 rounded justify-content-center" type="password" name="password" placeholder="Password" required="">
                            </div>
                            <div class="d-flex flex-column px-5 justify-content-center">
                                <button type="submit" class="text-light bg-dark rounded border-0 py-2">Login</button>
                                <a href="{{route('auth.forgot_password')}}" class="text-decoration-none">Forgot password?</a>
                            </div>
                        </form>
                    </div>
            </main>
        </body>
    </x-slot>
</x-base>

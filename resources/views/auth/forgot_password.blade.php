<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .card {
            max-width: 500px;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            margin-bottom: 1.5rem;
        }
        
        .icon-circle i {
            font-size: 2.5rem;
            color: #212529;
        }
        
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }
        
        .password-strength {
            height: 5px;
            margin-top: 5px;
            border-radius: 2px;
        }
        
        .form-floating label {
            color: #6c757d;
        }
        
        .btn-dark {
            padding: 0.75rem 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 d-flex flex-column align-items-center justify-content-center">
                <div class="card p-4 p-md-5">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="icon-circle">
                                <i class="bi bi-lock"></i>
                            </div>
                            <h2 class="fw-bold">Create New Password</h2>
                        </div>
                        {{var_dump($token)}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form id="resetPasswordForm" action="{{ route('auth.reset_password') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="mb-4 position-relative">
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                                    <label for="email">Email</label>
                                </div>
                            </div>

                            <div class="mb-4 position-relative">
                                <div class="form-floating">
                                    <input type="password" name="password" class="form-control" id="newPassword" placeholder="New Password">
                                    <label for="newPassword">New Password</label>
                                    <span class="text-danger d-none mt-2" id="is-short">Must have at least 8 characters</span>
                                    <span class="password-toggle text-muted">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="mb-4 position-relative">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password_confirmation" id="confirmPassword" placeholder="Confirm Password">
                                    <span class="text-danger d-none mt-2" id="is-invalid">The password don't match</span>
                                    <label for="confirmPassword">Confirm Password</label>
                                    <span class="password-toggle text-muted">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 mt-4">
                                <button id="sbmBtn" disabled="true" type="submit" class="btn btn-dark">Reset Password</button>
                            </div>
                            
                            <div class="text-center mt-3">
                                <a href="#" class="text-dark text-decoration-underline">Back to Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    let passwordVisible = false;
    $('.password-toggle').on('click', function() {
        const input = $(this).siblings('input');
        passwordVisible = !passwordVisible;
        input.attr('type', passwordVisible ? 'text' : 'password');
        $(this).find('i').toggleClass('bi-eye bi-eye-slash');
    });
    $('#newPassword').on('input', function() {
        const password = $(this).val();
        const isShort = password.length < 8;

        $('#is-short').toggleClass('d-none', !isShort);
        $('#sbmBtn').prop('disabled', isShort);
        if (isShort) {
            $('#is-invalid').addClass('d-none');
        } else {
            $('#is-invalid').removeClass('d-none');
        }
    });

    $('#confirmPassword').on('input', function() {
        const password = $('#newPassword').val();
        const confirmPassword = $(this).val();

        if (confirmPassword !== password) {
            $('#is-invalid').removeClass('d-none');
        } else {
            $('#is-invalid').addClass('d-none');
            $('#sbmBtn').prop('disabled', false);
        }
    });
</script>
</html>
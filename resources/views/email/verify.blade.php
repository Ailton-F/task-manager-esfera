
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
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
        
        .btn-dark {
            padding: 0.5rem 2rem;
        }
        
        .alert {
            text-align: left;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        @include('components.toast');
        <div class="row justify-content-center">
            <div class="col-md-8 d-flex flex-column align-items-center justify-content-center">
                <div class="card p-4 p-md-5">
                    <div class="card-body text-center">
                        <div class="icon">✉️</div>
                        <h2 class="fw-bold mb-3">Verification Email Sent</h2>
                        <p class="text-muted mb-4">
                            We've just sent a verification email to your email address.
                            Please check your inbox and click on the verification link to activate your account.
                        </p>
                        <div class="mt-3">
                            <span class="text-muted">Didn't receive the email?</span> 
                            <a href="{{ route('verification.send') }}" class="text-dark text-decoration-underline ms-1">Resend</a>
                        </div>
                        
                        <div class="alert alert-light border mt-4">
                            <strong>Note:</strong> If you can't find the email in your inbox,
                            please check your spam or junk folder.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
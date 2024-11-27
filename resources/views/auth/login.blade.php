<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Isuzu EA USSD Dashboard</title>
    <style>
        /* Ensure the entire viewport is filled */
        html, body {
            height: 100%;
            margin: 0;
        }
        /* Full-height background image */
        .full-height {
            height: 100vh;
            background: url('{{ asset('frontend/img/isuzu-login-bg.jpg') }}') no-repeat center center fixed; /* Replace with Isuzu vehicle image URL */
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        /* Card with opacity */
        .form-card {
            background: rgba(255, 255, 255, 0.9); /* Slightly transparent white */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 400px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header .logo img {
            max-width: 100px;
        }
        .btn-danger {
            background-color: #D71920;
            border-color: #D71920;
        }
        .btn-danger:hover {
            background-color: #C0171E;
            border-color: #C0171E;
        }
    </style>
</head>
<body>

    <div class="container2 full-height">
        <div class="form-card">
            <div class="text-center" style="margin-bottom: 20px; color: #000; font-weight: bolder;">
                <div class="header">
                    <!--logo start-->
                    <a href="{{url('/')}}" class="logo">
                        <img src="{{asset('frontend/img/logoisuzuold.png')}}" alt="Isuzu Logo">
                    </a>
                    <!--logo end-->
                </div>
                <h5 class="text-muted mt-3">Welcome to Isuzu EA USSD Dashboard</h5>
                <p class="text-muted">Please fill out the following fields to login</p>
                <hr>
            </div>
    
            <form class="well" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input id="email" type="email" placeholder="Email Address" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" style="color:#F30000;">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
    
                <div class="form-group">
                    <input id="password" placeholder="Enter your password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" style="color:#F30000;">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
    
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-muted" for="remember">Remember Me</label>
                </div>
    
                <div class="form-group text-center">
                    <button class="btn btn-lg btn-block btn-danger" name="log" type="submit">
                        <i class="fa fa-sign-in"></i> Sign in
                    </button>
                </div>
            </form>
    
            <hr style="border:2px double #F30000">
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>

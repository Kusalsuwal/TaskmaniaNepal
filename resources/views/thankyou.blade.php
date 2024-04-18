<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment {{ $msg }}</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 40px;
            background-color: #f4f4f9;
            height: 100vh;
        }
        .message-box {
            text-align: center;
            margin-top: 50px;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .success { color: #28a745; }
        .failure { color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <div class="message-box">
            @if ($msg === 'Success')
            <i class="fas fa-check-circle icon success"></i>
            @else
            <i class="fas fa-times-circle icon failure"></i>
            @endif
            <h1>Your Payment: {{ $msg }}</h1>
            <p>{{ $msg1 }}</p>
            <a href="{{ url('/home') }}" class="btn btn-primary">Go to Home</a>
        </div>
    </div>
</body>
</html>

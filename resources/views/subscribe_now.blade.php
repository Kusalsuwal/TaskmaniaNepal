<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Esewa in Laravel</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f7f7f7;
        }
        .payment-form {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-header {
            margin-bottom: 20px;
            text-align: center;
        }
        .pay-button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
    </style>
</head>

<body>
    @auth
    <div class="payment-form">
        <div class="form-header">
            <h2>Subscription Payment</h2>
            <p>Only $100 for a year's subscription!</p>
        </div>
        <form action="{{ route('esewa') }}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="name" value="{{ auth()->user()->name }}">
            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
            <input type="hidden" name="amount" value="100"> <!-- Updated amount to $500 -->
            <input type="submit" class="pay-button" value="Pay With Esewa">
        </form>
    </div>
    @else
    <p>You need to be logged in to perform this action.</p>
    @endif
</body>

</html>

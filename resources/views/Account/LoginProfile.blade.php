@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> </title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    .profile-card {
      background-color: #f8f9fa;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-top: 20px;
    }
    .profile-picture {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      margin: 0 auto;
      display: block;
      border: 5px solid #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
            
        .navbar-brand {
            font-size: 1.5em;
            font-weight: bold;
            color: #007bff; /* blue */
        }

        .navbar-nav .nav-link {
            color: #007bff; /* blue */
        }

        .navbar-nav .nav-link:hover {
            color: #0056b3; /* darker blue */
        }
        .jumbotron {
            background-color: #007bff; /* blue */
            padding: 100px 20px;
            text-align: center;
            margin-top: 20px;
            color: #fff; /* white */
        }
  </style>
</head>
<body>

    
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="profile-card text-center">
        <img src="{{ asset('uploads/students/' . Auth::user()->image) }}" alt="" class="profile-picture">
          <h2 class="mt-3">{{ Auth::user()->name }}</h2>
        
          <p>Email:{{ Auth::user()->email }}</p>
          <p>Number:{{ Auth::user()->mobile_no }}</p>

          

          <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Facebook</a></li>
            <li class="list-inline-item"><a href="#">Twitter</a></li>
            <li class="list-inline-item"><a href="#">LinkedIn</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
@endsection
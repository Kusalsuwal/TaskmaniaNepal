<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Options - Taskmania Nepal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7; /* Light grey background */
        }
        .text-muted {
            font-weight: bold;
            color: #0056b3 !important; /* Custom color for brand */
        }
        .container {
            padding-top: 2rem;
        }
        .btn-primary, .btn-secondary {
            width: 100%; /* Full width buttons */
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
             <!-- <h3 class="navbar-brand"  href="#">Taskmania Nepal</h3> -->
             <h3 class="text-muted" style="margin-top: 10px;">Taskmania Nepal</h3>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                </ul> -->
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container mt-4">
        <h1 class="mb-3">Choose Your Subscription</h1>
        <p class="mb-4">Subscribe now or start a 15-day free trial.</p>

        <div class="row">
            <div class="col-md-6 mb-3">
                <!-- Subscribe Now Form -->
                <form action="{{ route('subscribe-now') }}" method="GET"> <!-- Ensure the method is GET if just redirecting -->
                    @csrf
                    <button type="submit" class="btn btn-primary">Subscribe Now</button>
                </form>
            </div>
            <div class="col-md-6">
                <!-- Start Free Trial Form -->
                <form action="{{ route('home') }}" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Start Free Trial</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

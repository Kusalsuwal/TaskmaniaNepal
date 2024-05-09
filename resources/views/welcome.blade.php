<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Welcome to Homepage of Taskmania Nepal</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/prettyPhoto.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <!--NAV SECTION -->
    <header id="header-nav" role="banner">
        <div id="navbar" class="navbar navbar-default">
            <div class="navbar-header">
            <a class="navbar-brand" href="#"><img src="{{ asset('img/team/Taskman.png') }}" alt="Taskmania Nepal Logo"style="margin-top: -12px;width: 129px;height: auto;"></a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav flot-nav">
                    <li><a href="#slide-head"><i class="fa fa-home color-red"></i> Home</a></li>
                    <li><a href="#about-section"><i class="fa fa-wrench color-brown"></i> About Us</a></li>
                    <li><a href="#pricing-section"><i class="fa fa-plane color-blue"></i> Pricing</a></li>
                    <li><a href="#contact-section"><i class="fa fa-tint"></i> Contact</a></li>
                    <li><a href="login"><i class="fa fa-check color-green"></i> Login</a></li>
                    <li><a href="register"><i class="fa fa-picture-o color-light-blue"></i> Register</a></li>
                </ul>
            </div>
        </div>
    </header>

    <section id="slide-head" class="carousel">
        <div class="carousel-inner">
            <div class="item active">
                <div class="container">
                    <div class="carousel-content">
                        <h2>"Empower Your Projects, Unleash Your Success: Taskmania Nepal, Where Tasks Meet Triumph!"

</h2>
                    </div>
                </div>
            </div>    </section>

    <section id="about-section">
        <div class="wrap-pad">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 ">
                    <div class="text-center">
                        <h1><i class="fa fa-wrench small-icons bk-color-brown"></i>Meet Team</h1>
                        <p class="lead">
                        At Taskmania, we're fueled by a passion for innovation and a dedication to excellence. 
                        Our diverse team brings together a wealth of experience and expertise, united by a shared vision to revolutionize task management.
                        From developers and designers to marketers and support specialists, each member plays a vital role in shaping our platform and empowering our users. 
                        Together, we strive to exceed expectations, drive success, and make collaboration effortless for our valued customers.
                       
                        </p>
                    </div>

                </div>
                <!-- ./ Heading div-->
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 margin-top-100  ">
                    <div class="col-md-3 col-sm-6" data-scrollreveal="enter left and move 100px, wait 0.6s">
                        <div class="text-center">
                            <p>
                               <img class="img-responsive img-thumbnail img-circle" src="{{ asset('img/team/team1.png') }}" alt="">

                            </p>
                            <h3>Kusal Suwal</h3>
                            <p>
                               Software Developer
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6" data-scrollreveal="enter bottom and move 100px, wait 0.6s">
                        <div class="text-center">
                            <p>
                                <img class="img-responsive img-thumbnail img-circle" src="{{ asset('img/team/team2.jpg') }}" alt="">
                            </p>
                            <h3>Maria Hary</h3>
                            <p>
                               UI/UX Desginer
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6" data-scrollreveal="enter bottom and move 100px, wait 0.6s">
                        <div class="text-center">
                            <p>
                                <img class="img-responsive img-thumbnail img-circle" src="{{ asset('img/team/team1.png') }}" alt="">
                            </p>
                            <h3>Prajul Khatiwoda</h3>
                            <p>
                              Project Manager
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6" data-scrollreveal="enter right and move 100px, wait 0.6s">
                        <div class="text-center">
                            <p>
                                <img class="img-responsive img-thumbnail img-circle"  src="{{ asset('img/team/team2.jpg') }}" alt="">
                            </p>
                            <h3>Rosal Bhaila</h3>
                            <p>
                               Full Stack Developer
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="pricing-section">
        <div class="wrap-pad">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 " data-scrollreveal="enter top and move 100px, wait 0.5s">
                    <div class="text-center">
                        <h1><i class="fa fa-plane small-icons bk-color-blue"></i>Our Pricing Options</h1>
                        <p class="lead">
                        "Unlock Your Potential with Flexible Pricing Plans: Taskmania Nepal - Where Value Meets Versatility!"                  
                        </p>
                    </div>
                </div>
                <!-- ./ Heading div-->
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 margin-top-100 ">
                    <div id="pricing-table" class="row">
                        <div class="col-md-4 col-sm-4" data-scrollreveal="enter left and move 100px, wait 0.6s">
                            <ul class="plan-main">
                                <li class="plan-name">Starter</li>
                                <li class="plan-price">Rs 100</li>
                                <li>5GB Storage</li>
                                <li>1GB Space</li>
                                <li>Daily Notification</li>
                                <li>Reminder Message</li>
                                <li>24x7 Support</li>
                                <li>Live Chat</li>
                                <li class="plan-action"><a href="register" class="btn btn-primary btn-lg">Signup</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4 col-sm-4" data-scrollreveal="enter bottom and move 100px, wait 0.6s">
                            <ul class="plan-main featured">
                                <li class="plan-name">Medium</li>
                                <li class="plan-price">Rs 200</li>
                                <li>5GB Storage</li>
                                <li>1GB Space</li>
                                <li>Daily Notification</li>
                                <li>Reminder Message</li>
                                <li>24x7 Support</li>
                                <li>Live Chat</li>
                                <li class="plan-action"><a href="register" class="btn btn-primary btn-lg">Signup</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4 col-sm-4" data-scrollreveal="enter right and move 100px, wait 0.6s">
                            <ul class="plan-main">
                                <li class="plan-name">Advance</li>
                                <li class="plan-price">Rs 300</li>
                                <li>5GB Storage</li>
                                <li>1GB Space</li>
                                <li>Daily Notification</li>
                                <li>Reminder Message</li>
                                <li>24x7 Support</li>
                                <li>Live Chat</li>
                                <li class="plan-action"><a href="register" class="btn btn-primary btn-lg">Signup</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ./ Content div-->
            </div>
        </div>
    </section>

    <section id="contact-section">
        <div class="wrap-pad">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 " data-scrollreveal="enter top and move 100px, wait 0.5s">
                    <div class="text-center">
                        <h1><i class="fa fa-tint small-icons bk-color-black"></i>Contact us Now</h1>
                        <p class="lead">
                           We are always here for your help.                       
                        </p>
                    </div>
                </div>
                <!-- ./ Heading div-->
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1  margin-top-20">
                    <div class="col-md-6  col-sm-12" data-scrollreveal="enter left and move 100px, wait 0.6s">
                        <h3><i class="fa fa-pencil small-icons bk-color-light-blue"></i>Send Us Your Query</h3>
                        <hr />
                        <form>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" required="required" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" required="required" placeholder="Email address">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <textarea name="message" id="message" required="required" class="form-control" rows="4" placeholder="Message"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg">Submit Query</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 col-md-offset-1  col-sm-12" data-scrollreveal="enter right and move 100px, wait 0.6s">
                        <h3><i class="fa fa-comments small-icons bk-color-red"></i>Reach Us Here</h3>
                        <hr />
                        13th Street, Pokhara.<br />
                        Call: +977-9860846143<br />
                        Email: taskmanianepal.com.np<br />
                        <h3><i class="fa fa-plus small-icons bk-color-green"></i>Social Presence</h3>
                        <a href="#"><i class="fa fa-facebook fa-3x color-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter fa-3x color-twitter"></i></a>
                        <a href="#"><i class="fa fa-google-plus fa-3x color-google-plus"></i></a>
                        <a href="#"><i class="fa fa-linkedin fa-3x color-linkedin"></i></a>
                        <a href="#"><i class="fa fa-pinterest fa-3x color-pinterest"></i></a>
                    </div>
                </div>
                <!-- ./ Content div-->
            </div>
        </div>
    </section>

    <footer id="footer">
        <div class="row">
            <div class="col-md-12  col-sm-12">
                &copy; 2024 www.taskmanianepal.com.np  |  All Rights Reserved
               
            </div>
        </div>
    </footer>

<script src="{{ asset('js/jquery.js') }}"></script>

<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.prettyPhoto.js') }}"></script>
<script src="{{ asset('js/scrollReveal.js') }}"></script>
</body>
</html>

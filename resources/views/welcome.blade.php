<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link href="{{ asset('z/bootstrap.css') }}" rel="stylesheet" >

    <script src="{{ asset('z/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('z/bootstrap.js') }}" ></script>
    <script src="{{ asset('z/blink.js') }}" defer></script>
    <link href="{{ asset('z/style.css') }}" rel="stylesheet">
    <link href="{{ asset('z/jquery.js') }}" type="text/javascript">
</head>
<body>


<div class="container-fluid" style="">
    <div class="container-fluid"
         style="border-top-left-radius: 15px; border-top-right-radius: 15px; margin-top: 1%;">
        <div class="container-fluid" style="padding-bottom: 1.5%;">
            <div class='col-md-12'>
                <h1 class='logo text-center'><i>Zulaihat Memorial International School Darmanawa</i></h1>
            </div>

        </div>

        <nav class="navbar navbar-inverse custom navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#myDropDownMenu" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="myDropDownMenu">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="{{ url('/home') }}">Home</a></li>
                        <li><a href="student/gallery.php">Gallery</a>
                        </li>
                        <li><a href="gallery.php">School Facilities</a>
                        </li>
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                                aria-haspopup="true" aria-expanded="false">Academics <span
                                        class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="enrolment.php"> Enrollment</a></li>
                                <li><a href="student/register_form.php"> Admission</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Broadcast</a></li>
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                                aria-haspopup="true" aria-expanded="false"> Notice Board <span
                                        class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"> School Calendar</a>
                                </li>
                                <li><a href="#"> Exam Time Table</a></li>
                            </ul>
                        </li>
                    </ul>
                    @if (Route::has('login'))
                        <ul class='nav navbar-nav navbar-right'>

                            @auth
                                <li><a href="{{ url('/home') }}"> Home</a>
                                </li>
                            @else
                                <li><a href="{{ route('login') }}">
                                        Login</a></li>
                                @if (Route::has('register'))
                                    <li><a href="{{ route('register') }}">Register</a>
                                    </li>

                                @endif
                            @endauth
                        </ul>
                    @endif
                </div>
            </div>
        </nav>

        <div class="">
            <div class="row">
                <div class="col-xs-12 col-md-8">
                    <!-- Start WOWSlider.com BODY section --> <!-- add to the <body> of your page -->
                    <div id="wowslider-container1">
                        <div class="ws_images">
                            <ul>
                                <li><img src="{{ asset('img/images/4.jpg') }}" alt="Biology Practicals"
                                         title="Biology Practicals" id="wows1_0"/></li>
                                <li><img src="{{ asset('img/images/5.jpg') }}" alt="jquery slider" title="Classroom"
                                         id="wows1_1"/></li>
                                <li><img src="{{ asset('img/images/6.jpg') }}" alt="Qualified Teachers"
                                         title="Qualified Teachers" id="wows1_2"/></li>
                            </ul>
                        </div>
                        <div class="ws_bullets">
                            <div>
                                <a href="#" title="Biology Practicals"><span><img
                                                src="{{ asset('z/biology_practicals.jpg') }}" alt="Biology Practicals"/>1</span></a>
                                <a href="#" title="Classroom"><span><img src="{{ asset('z/classroom.jpg') }}"
                                                                         alt="Classroom"/>2</span></a>
                                <a href="#" title="Qualified Teachers"><span><img
                                                src="{{ asset('z/qualified_teachers.jpg') }}" alt="Qualified Teachers"/>3</span></a>
                            </div>
                        </div>
                        <div class="ws_script" style="position:absolute;left:-99%"><a href="http://wowslider.com">wow
                                slider</a> by WOWSlider.com v8.7
                        </div>
                        <div class="ws_shadow"></div>
                    </div>
                    <script type="text/javascript" src="{{ asset('z/wowslider.js') }}"></script>
                    <script type="text/javascript" src="{{ asset('z/script.js') }}"></script>
                    <!-- End WOWSlider.com BODY section -->
                </div>

                <div class="col-xs-12 col-md-4">
                    <div class='thumbnail jumbotron'>
                        <h2 class='blinking guest'>Welcome Guest ...</h2>
                        <p>“Anyone who stops learning is old, whether at twenty or eighty. Anyone who keeps learning
                            stays young.” – Henry Ford</p>
                        <p><a class='btn btn-pink btn-xs' href='#' role='button'>Learn more</a></p>
                    </div>
                    <div class='panel panel-primary' style='background-color: #000;'>
                        <div class='panel-footer' style='background-color: #000;'>
                            <h4>
                                <marquee style='color: #f09;'>Zulaihat Memorial International School! Making Education a
                                    tool for change
                                </marquee>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <hr/>


        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="{{ asset('img/images/6.jpg') }}" alt="aminu" title="aminu">
                        <div class="caption">
                            <h3>Students</h3>
                            <p>
                                The youth today run the risk of being use as tools for
                                perpetrating evils. Moral sense of what is good becomes necessary for
                                the future of the youth where honesty, responsibility and sense of
                                purpose are inculcated in the youth consciousness. Darmanawa Youth
                                Movement brings you back to your root ...
                            </p>
                            <p><a href="#" class="btn btn-pink" role="button">Students</a> <a href="#"
                                                                                                          class="btn btn-default"
                                                                                                          role="button">Read
                                    More</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="{{ asset('img/images/1.jpg') }}" alt="Toxaswift" title="Toxaswift">
                        <div class="caption">
                            <h3> About Us</h3>
                            <p>
                                The Rector is the Superior of the local Salesian Community. He
                                animates and directs the whole community towards the achievement of all
                                educational goals in the light of the school philosophy and mission.
                                Together with the House Council, the Rector bears the responsibility for
                                all ...
                            </p>
                            <p><a href="read.txt" class="btn btn-pink fancybox fancybox.ajax" role="button"> About</a> <a href="read.txt"
                                                                                                       class="btn btn-default fancybox fancybox.ajax"
                                                                                                       role="button">Read
                                    More</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="{{ asset('img/images/6.jpg') }}" alt="Toxaswift" title="Toxaswift">
                        <div class="caption">
                            <h3>Our Location</h3>
                            <p>
                                You are very much welcome to Zulaihat Memorial International School Darmanawa.
                                Zulahat International memorial shool is an excellent environment for learning, the schol
                                has been educating children in various fields. the school is situated at N0.500
                                Darmanawa Rinji off Hassan Gwarzo road, Tarauni local government Area Kano State.
                            </p>
                            <p><a href="#" class="btn btn-pink" role="button">Locations</a> <a
                                        href="http://dbssobosi.com/contact.php" class="btn btn-default" role="button">Read
                                    More</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer>
        <div class="row">
            <div class="col-md-3">
                <div class="container-fluid">
                    <ul class='footer_nav'>
                        <h5 class='links'>QUICK LINKS</h5>
                        <li><a href="">Home</a></li>
                        <li><a href="">Gallery</a></li>
                        <li><a href="">Academics</a></li>
                        <li><a href="student/register_form.php">Admission</a></li>
                    </ul>
                </div>
            </div>
            <div class='col-md-3'>
                <ul class='footer_nav'>
                    <h5 class='links'>TOUR</h5>
                    <li><a href="">Exibitions</a></li>
                    <li><a href="">Debate Competitions</a></li>
                    <li><a href="">Excursions</a></li>
                    <li><a href="">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-md-6">
                <br/>
                <div class="container-fluid text-center footer2">
                    <p>Copyright &#169; <?php echo date('Y'); ?> All Rights Reserved
                        &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp; AMINU ISMAIL DARMANAWA.
                    </p>
                    <p>Powered By <a style='color: #f09;' href="www.toxaswift.com">AMINU ISMAIL DARMANAWA</a>&nbsp;&nbsp;&nbsp;&nbsp;<a
                                style='color: #181818;' href='generator.php'> Admin</a></p>
                </div>
            </div>
        </div>
    </footer>
</div>
</body>
</html>

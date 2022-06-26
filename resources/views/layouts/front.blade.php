<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="This is the discription of the project">
    <meta name="robots" content="noindex">
    <!-- Favicon -->
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('front/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" as="style" href="{{ asset('front/css/normalize.css') }}">
    <link rel="stylesheet" as="style" href="{{ asset('front/css/slicknav.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/chosen.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/datatable.min.css') }}">

    <!--popup css-->
    <link rel="stylesheet" href="{{ asset('front/css/jquery-confirm.min.css') }}">
    <!--pagination css-->
    <link rel="stylesheet" href="{{ asset('front/css/pagination.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!--<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5993ef01e2587a001253a261&product=inline-share-buttons"></script>-->
    @yield('title')

</head>

<body>

    <!--Preloader Start-->
    <div id="preloader">
        @php
        $preloader = asset('front/images/loading.gif');
        @endphp
        <div class="lazyload" id="status" style="background-image: url(<?php echo $preloader; ?>)"></div>
    </div>
    <!--Preloader End-->
    @auth('buyer')
    <!--Top-Header Start-->
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="top-header-left">
                        <!-- <p><i class="fa fa-phone"></i><?php if (!empty($contactphone)) {echo $contactphone;}?></p>
                        <p><i class="fa fa-envelope-o"></i><?php if (!empty($contactemail)) {echo $contactemail;}?></p> -->
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="top-header-right" id="loggedstatusdiv">
                        Logged in as: {{ auth('buyer')->user()->email }}
                        |
                        <a href="{{ url('buyer') }}">Dashboard</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endauth

    <!--Menu Start-->
    <div class="menu-area">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <!-- <img class="lazyload" src="" alt="logo"> -->
                            HOMEASE
                        </a>
                    </div>
                </div>
                <div class="col-md-8 col-sm-9">
                    <div class="menu">
                        <ul id="nav" class="main-menu" style="list-style: none;margin:0%;padding: 0;">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('blog') }}">Blog</a></li>
                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                            <li><a href="{{ route('services') }}">Service</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @yield('content')
    <!--Footer-Area Start-->
    <div class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="footer-item footer-service">
                        <h2>Contact</h2>
                        <ul style="list-style: none;margin: 0%;/* padding: 0; */">
                            <li>Address: Lorem ipsum dolor sit amet</li>
                            <li>Email: info@info.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="footer-item footer-service">
                        <h2>Quick Link</h2>
                        <div style="margin-left: 15px;">
                            <ul>
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('blog') }}">Blog</a></li>
                                <li><a href="{{ route('faq') }}">FAQ</a></li>
                                <li><a href="{{ route('services') }}">Service</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="footer-item footer-service">
                        <h2>Social Media</h2>
                        <div class="footer-social-link">
                            <ul>
                                <li>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-google-plus"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="copyright">
                    <p>All rights reserved {{ date('Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!--Footer-Area End-->


    <!--Scroll-Top-->
    <div class="scroll-top">
        <div class="scroll"></div>
    </div>
    <!--Scroll-Top-->

    <!--Js-->
    <script src="{{ asset('front/js/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery.slicknav.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery.filterizr.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery.collapse.js') }}"></script>
    <script src="{{ asset('front/js/custom.js') }}"></script>

    <!--popup js-->
    <script src="{{ asset('front/js/jquery-confirm.min.js') }}"></script>
    <script src="{{ asset('front/js/pagination.js') }}"></script>
    @yield('script')
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Seller || Registration</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('assets/img/favicon.ico') }}" />
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Seller Registration</h4>
                            </div>
                            @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <div class="card-body">
                                <form method="POST" action="{{ route('seller.register.submit') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">{{ __('Name') }}</label>
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="username">{{ __('Username') }}</label>
                                                <input id="username" type="text"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    name="username" value="{{ old('username') }}" required
                                                    autocomplete="username" autofocus>
                                                @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="phone">{{ __('Phone') }}</label>
                                                <input id="phone" type="text"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    name="phone" value="{{ old('phone') }}" required
                                                    autocomplete="phone" autofocus>
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="address" id="address"
                                                        required readonly>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="googlelocation">Get
                                                            Location</span>
                                                    </div>
                                                    <input type="hidden" name="location" id="location" class="col-12" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="email">{{ __('Email Address') }}</label>
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}" required
                                                    autocomplete="email" />
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="password">{{ __('Password') }}</label>
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="new-password">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                                <input id="password-confirm" type="password" class="form-control"
                                                    name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="googleMap" style="width:100%;height:96%;"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/index.js') }}"></script>
    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
    let map;
    let markersArray = [];
    $(document).ready(function() {

        getLocation();
        //get on click
        $("#googlelocation").click(function() {
            event.preventDefault();
            getLocation();
        });

        function getLocation() {
            // location = { latitude : '', longitude : '' };
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError, {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                });
                // navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }

        function showPosition(position) {
            location.latitude = position.coords.latitude;
            location.longitude = position.coords.longitude;

            // latitudeAndLongitude.innerHTML="Latitude: " + position.coords.latitude +
            // "<br>Longitude: " + position.coords.longitude;
            // gujrat coordinates
            location.latitude = "32.5659118";
            location.longitude = "74.0794373";

            var geocoder = new google.maps.Geocoder();
            var latLng = new google.maps.LatLng(location.latitude, location.longitude);
            if (geocoder) {
                geocoder.geocode({
                    'latLng': latLng
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        myCenter = new google.maps.LatLng(location.latitude, location.longitude);
                        var mapOptions = {
                            center: myCenter,
                            zoom: 12,
                            // scrollwheel: false,
                            // draggable: false,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
                        addMarker(myCenter);
                        $('input#address').val(results[0].formatted_address);
                        $('input#location').val(location.latitude + "," + location.longitude)
                        google.maps.event.addListener(map, 'click', function(event) {
                            myCenter = new google.maps.LatLng(event.latLng.lat(), event.latLng
                                .lng());
                            addMarker(myCenter);
                        });
                    } else {
                        // $('#address').html('Geocoding failed: '+status);
                        // console.log("Geocoding failed: " + status);
                        alert("Geocoding failed: " + status);
                    }
                }); //geocoder.geocode()
            }
        } //showPosition

        function addMarker(location) {
            var geocoder = new google.maps.Geocoder();
            var latLng = new google.maps.LatLng(location.lat().toFixed(7), location.lng().toFixed(7));
            if (geocoder) {
                geocoder.geocode({
                    'latLng': latLng
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        deleteOverlays();
                        marker = new google.maps.Marker({
                            position: latLng,
                            map: map
                        });
                        $('input#address').val(results[0].formatted_address);
                        $('input#location').val(location.lat().toFixed(7) + "," + location.lng()
                            .toFixed(7))
                        markersArray.push(marker);
                    } else {
                        // $('#address').html('Geocoding failed: '+status);
                        // console.log("Geocoding failed: " + status);
                        alert("Geocoding failed: " + status);
                    }
                }); //geocoder.geocode()
            }
        }

        function deleteOverlays() {
            if (markersArray) {
                for (i in markersArray) {
                    markersArray[i].setMap(null);
                }
                markersArray.length = 0;
            }
        }

    });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBI0g4W0LFb0SOzwYtTY8A7OzupuvkdAqI"></script>
</body>

</html>
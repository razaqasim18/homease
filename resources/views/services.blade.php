  <!--About us banner-->
  @extends('layouts.front')
  @section('title')
  <title>Service</title>
  <style>
.pagination>li>a,
.pagination>li>span {
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    color: #33AE41;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #ddd;
}

.page-item.active .page-link {
    z-index: 3;
    color: #fff !important;
    background-color: #33AE41 !important;
    border-color: #33AE41 !important;
    padding: 6px 12px;
}
  </style>
  @endsection
  @section('content')
  @php
  $faqimage = asset('front/images/blog.jpg');
  @endphp
  <!--single blog us banner-->
  <div class="banner-slider" class="lazyload" style="height:300px;background-image: url(<?php echo $faqimage; ?>)">
      <div class="bg"></div>
      <div class="bannder-table">
          <div class="banner-text">
              <h1>Services</h1>
          </div>
      </div>
  </div>
  <!--single blog banner-->
  <!--single blog content-->
  <div class="single-blog bg-area">
      <div class="container">
          <div class="row">
              <div class="col-md-3">
                  <div class="single-sidebar">
                      <div class="single-widget categories">
                          <h3>Search By</h3>
                          <form method="GET" action="{{ route('services') }}">
                              <div class="d-block">
                                  <h4>Category</h4>
                                  <select class="form-control" name="category" id="category">
                                      <option value="">Please select an option</option>
                                      @foreach($category as $row)
                                      <option value="{{ $row->id }}">{{ $row->category }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <hr />
                              <div class="d-block">
                                  <h4>Distance</h4>
                                  <select class="form-control" name="distance" id="distance">
                                      <option value="">Please select an option</option>
                                      <option value="2">2 km</option>
                                      <option value="5">5 km</option>
                                      <option value="10">10 km</option>
                                      <option value="15">15 km</option>
                                  </select>
                              </div>
                              <hr />
                              <div class="d-block">
                                  <h4>Your Current Location</h4>
                                  <input type="text" class="form-control" name="hidden_location" id="hidden_location"
                                      style="width:100%;" readonly />
                                  <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                                  <input type="hidden" name="hidden_latitude" id="hidden_latitude" value="" />
                                  <input type="hidden" name="hidden_longitude" id="hidden_longitude" value="" />
                              </div>
                              <hr />
                              <div class="d-block" style="height:600px">
                                  <div id="googleMap" style="width:100%;height:100%;"></div>
                              </div>
                              <hr />
                              <div class="d-block">
                                  <button class="btn btn-info" id="searchButton">Search</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
              <!-- <div class="col-md-6">
                  <div id="googleMap" style="width:100%;height:96%;"></div>
              </div> -->
              <div class="col-md-9 single-blog-item" id="serviceDiv">
                  @include('search_service')
              </div>
          </div>
      </div>
  </div>
  @endsection
  @section('script')

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
        // location.latitude = position.coords.latitude;
        // location.longitude = position.coords.longitude;
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
                    $('input#hidden_location').val(results[0].formatted_address);
                    $('input#hidden_latitude').val(location.latitude);
                    $('input#hidden_longitude').val(location.longitude);
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
                    // $('input#address').val(results[0].formatted_address);
                    // $('input#location').val(location.lat().toFixed(7) + "," + location.lng()
                    //     .toFixed(7))
                    $('input#hidden_location').val(results[0].formatted_address);
                    $('input#hidden_latitude').val(location.lat().toFixed(7));
                    $('input#hidden_longitude').val(location.lng().toFixed(7));
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

  <script>
$(document).ready(function() {
    // getLocation();

    // function getLocation() {
    //     if (navigator.geolocation) {
    //         navigator.geolocation.getCurrentPosition(function(position) {
    //             $('input#hidden_latitude').val(position.coords.latitude);
    //             $('input#hidden_longitude').val(position.coords.longitude);
    //             var geocoder = new google.maps.Geocoder();
    //             var latLng = new google.maps.LatLng(position.coords.latitude, position.coords
    //                 .longitude);
    //             if (geocoder) {
    //                 geocoder.geocode({
    //                     'latLng': latLng
    //                 }, function(results, status) {
    //                     if (status == google.maps.GeocoderStatus.OK) {
    //                         $('input#hidden_location').val(results[0].formatted_address);
    //                         var page = $('#hidden_page').val();
    //                         var category = $('#category').val();
    //                         var distance = $('#distance').val();
    //                         fetch_data(page, category, distance, results[0].formatted_address,
    //                             position
    //                             .coords.latitude,
    //                             position.coords.longitude);
    //                     }
    //                 }); //geocoder.geocode()
    //             }
    //         });
    //     } else {
    //         alert("Geolocation is not supported by this browser.");
    //     }
    // }


    $(document).on('click', '#searchButton', function() {
        event.preventDefault();
        var page = $('#hidden_page').val();
        var category = $('#category').val();
        var distance = $('#distance').val();
        var location = $('#hidden_location').val();
        var latitude = $('#hidden_latitude').val();
        var longitude = $('#hidden_longitude').val();
        fetch_data(page, category, distance, location, latitude, longitude);
    });

    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        $('#hidden_page').val(page);
        var category = $('#category').val();
        var distance = $('#distance').val();
        var location = $('#hidden_location').val();
        var latitude = $('#hidden_latitude').val();
        var longitude = $('#hidden_longitude').val();
        // $('li').removeClass('active');
        // $(this).parent().addClass('active');
        fetch_data(page, category, distance, location, latitude, longitude);
    });

    function fetch_data(page, category, distance, location, latitude, longitude) {
        $.ajax({
            url: "/search/services?page=" + page + "&category=" + category + "&distance=" + distance +
                "&location=" + location + "&latitude=" + latitude + "&longitude=" + longitude,
            success: function(data) {
                $('#serviceDiv').html('');
                $('#serviceDiv').html(data);
            }
        });
    }
});
  </script>

  @endsection
  <!--About us banner-->
  @extends('layouts.front')
  @section('title')
  <title>{{$title}} || Service</title>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <style>
.donner-gallery .owl-nav .owl-prev,
.donner-gallery .owl-nav .owl-next {
    top: -45px;
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
              <h1>{{$title}} Service</h1>
          </div>
      </div>
  </div>
  <!--single blog banner-->
  <!--single blog content-->
  <div class="single-blog bg-area">
      <div class="container">
          <div class="row">
              <div class="col-md-9">
                  <div class="single-blog-item">
                      <div class="single-blog-photo">
                          <?php if (!empty($service->serviceimage)) {?>
                          <img class="lazyload" with="100%"
                              src="<?php echo asset('uploads/service') . '/' . $service->serviceimage; ?>"
                              alt="<?php echo $service->title; ?>">
                          <?php }?>
                      </div>
                      <div class="single-blog-text">
                          <h2 style="text-transform: none;"><?php echo $service->title; ?></h2>
                          <hr />

                          <?php if (!empty($serviceimages)) {?>
                          <!-- <div class="blood-gallery"> -->
                          <!-- <div class="container"> -->
                          <!-- <div class="row"> -->
                          <h2 style="text-transform: none;">Service Images</h2>
                          <div class="headline">
                              <div class="donner-gallery owl-carousel">
                                  <?php foreach ($serviceimages as $row) {?>
                                  <div class="">
                                      <div class="">
                                          <div class="donner-photo lazyload"
                                              style="background-image: url(<?php echo asset('uploads/service/') . "/" . $row->image; ?>)">
                                          </div>
                                      </div>
                                  </div>
                                  <?php }?>
                              </div>
                          </div>
                          <!-- </div> -->
                          <!-- </div> -->
                          <!-- </div> -->
                          <?php }?>

                          <hr />
                          <h2 style="text-transform: none;">Job Description</h2>
                          <div class="single-blog-pra">
                              <p></p>
                              <?php echo $service->description; ?>
                              <p></p>
                          </div>
                          <hr />

                      </div>
                      <!--<h3>Comments</h3>-->
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="single-blog-item">
                      <h2 style="text-transform: none;">Seller Information</h2>
                      <hr />
                      <ul style="list-style: none;">
                          <li><strong>Name</strong> : <p><?php echo $service->name; ?></p>
                          </li>
                          <li><strong>Email</strong> : <p><?php echo $service->email; ?></p>
                          </li>
                          <li><strong>Phone</strong> : <p><?php echo $service->phone; ?></p>
                          </li>
                          <li><strong>Address</strong> : <p><?php echo $service->address; ?></p>
                          </li>
                      </ul>
                      @auth('buyer')
                      <button id="hireme" data-id="<?php echo $service->serviceid; ?>"
                          data-sellers="<?php echo $service->sellersid; ?>" class="btn btn-primary btn-block"
                          style="background: #33AE41;">Hire
                          Me</button>
                      @endauth
                      @guest('buyer')
                      <button id="login" class="btn btn-primary btn-block" style="background: #33AE41;">Login your buyer
                          account
                      </button>
                      @endguest
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-md">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Buyer Login</h4>
                  <!-- <div class="logo">
                      <a href="">
                          <img src="" alt="logo">
                      </a>
                  </div> -->
              </div>
              <div class="modal-body" style="background-color:#33AE41;">
                  <div class="row">
                      <div class="col-md-offset-2 col-md-8">

                          <div class="login-form">
                              <form method="POST" id="loginsubmit" action="#">
                                  <!-- @csrf -->
                                  <div class="form-row">
                                      <div class="form-group">
                                          <label for="" style="color:#fff;">Email</label>
                                          <input type="email" class="form-control" name="email" id="email"
                                              placeholder="Email" value="" maxlength="40" required="">
                                      </div>
                                      <div class="form-group">
                                          <label for="" style="color:#fff;">Password</label>
                                          <input type="password" class="form-control" id="password" name="password"
                                              placeholder="Password" maxlength="30" required="">
                                      </div>
                                  </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <div class="row">
                      <div class="col-xs-6 col-md-6 text-left">
                          @if (Route::has('buyer.register'))
                          <a class="text-small" href="{{ route('buyer.register') }}">
                              {{ __('Create your account') }}
                          </a>
                          @endif
                      </div>
                      <div class="col-xs-6 col-md-6">
                          <button type="submit" class="btn btn-primary loginformbutton" name="form1"
                              style="background: #33AE41;">Login</button>
                          </form>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  @endsection
  @section('script')
  <script>
$(document).ready(function() {
    $("button#hireme").click(function() {
        var serviceid = $(this).data('id');
        var sellerid = $(this).data('sellers');
        var token = $("meta[name='csrf-token']").attr("content");
        var fd = new FormData();
        fd.append('serviceid', serviceid);
        fd.append('sellerid', sellerid);
        fd.append('_token', token);
        $.ajax({
            type: 'POST',
            url: "{{ url('/buyer/hire') }}",
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                var result = jQuery.parseJSON(result);
                var typeOfResponse = result['type'];
                var res = result['msg'];
                if (typeOfResponse == 0) {
                    $.alert({
                        title: 'Encountered an error!',
                        content: res,
                        type: 'red',
                        typeAnimated: true,
                    })
                } else if (typeOfResponse == 1) {
                    $.confirm({
                        title: 'Success!',
                        content: res,
                        type: 'green',
                        typeAnimated: true,
                        buttons: {
                            ok: function() {
                                window.location.href = '/buyer/job';
                            }
                        }
                    });
                }
            }
        });
    });

    $("button#login").click(function() {
        $("#myModal").modal("show");
    });

    $('#loginsubmit').submit(function(e) {
        e.preventDefault();
        var email = $('input#email').val();
        var password = $('#password').val();
        var token = $("meta[name='csrf-token']").attr("content");
        var url = window.location.href;
        var fd = new FormData();
        fd.append('email', email);
        fd.append('password', password);
        fd.append('_token', token);
        fd.append('url', url);
        $.ajax({
            url: "{{ route('buyer.submit.ajax') }}",
            method: "POST",
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            beforeSend: function() {
                $("#loader").show();
            },
            complete: function() {
                $("#loader").hide();
            },
            success: function(response) {
                console.log(response);
                var result = jQuery.parseJSON(JSON.stringify(response));
                var typeOfResponse = result['type'];
                if (typeOfResponse == 0) {
                    var res = result['msg'];
                    $.alert({
                        title: 'Encountered an error!',
                        content: res,
                        type: 'red',
                        typeAnimated: true,
                    })
                } else if (typeOfResponse == 1) {
                    var res = result['redirect_location'];
                    // $.alert({
                    //     title: 'Success!',
                    //     content: res,
                    //     type: 'green',
                    //     typeAnimated: true,
                    // });
                    $('#myModal').modal('hide');
                    window.location = '/buyer';
                    // location.reload();
                }
            }
        });
    });
});
  </script>
  @endsection
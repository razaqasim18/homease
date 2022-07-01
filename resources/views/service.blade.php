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

.text-warning {
    color: #ffc107 !important;
}

.progress {
    display: flex;
    height: 1rem;
    overflow: hidden;
    font-size: .75rem;
    background-color: #e9ecef;
    border-radius: 0.25rem;
}

.progress-label-left {
    float: left;
    margin-right: 0.5em;
    line-height: 1em;
}

.progress-label-right {
    float: right;
    margin-left: 0.3em;
    line-height: 1em;
}

.bg-warning {
    background-color: #ffc107 !important;
}

.rounded-circle {
    border-radius: 50% !important;
}

.pb-2,
.py-2 {
    padding-bottom: 0.5rem !important;
}

.pt-2,
.py-2 {
    padding-top: 0.5rem !important;
}

.card-header {
    padding: 0.75rem 1.25rem;
    margin-bottom: 0;
    border-bottom: 1px solid rgba(0, 0, 0, .125);
    text-align: left;
}

.text-right {
    text-align: right !important;
}

.card-footer {
    padding: 0.75rem 1.25rem;
}

.card {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, .125);
    border-radius: 0.25rem;
}

.mb-3 {
    margin-bottom: 3px;
    margin-left: 2px;
}

.mb-2 {
    margin-bottom: 2px;
    margin-left: 10px;
}

.mb-1 {
    margin-bottom: 1px;
    margin-left: 2px;
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
                          <h2 style="text-transform: none;">Review</h2>
                          <div class="row">
                              @php
                              $average_rating = 0;
                              $total_review = 0;
                              $five_star_review = 0;
                              $four_star_review = 0;
                              $three_star_review = 0;
                              $two_star_review = 0;
                              $one_star_review = 0;
                              $total_user_rating = 0;
                              foreach($review as $row)
                              {
                              if($row->rating == '5.00')
                              {
                              $five_star_review++;
                              }
                              if($row->rating == '4.00')
                              {
                              $four_star_review++;
                              }
                              if($row->rating == '3.00')
                              {
                              $three_star_review++;
                              }
                              if($row->rating == '2.00')
                              {
                              $two_star_review++;
                              }
                              if($row->rating == '1.00')
                              {
                              $one_star_review++;
                              }
                              $total_review++;
                              $total_user_rating = $total_user_rating + $row->rating;
                              }
                              $average_rating = ($total_review != 0) ? $total_user_rating / $total_review :
                              $total_user_rating;
                              @endphp
                              <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                                  <h1 class="text-warning mt-4 mb-4">
                                      <b><span id="average_rating">{{$average_rating}}</span> / 5</b>
                                  </h1>
                                  <div class="mb-3">
                                      <i class="fa fa-star star-light submit_star mr-1" id="submit_star_1"
                                          data-rating="1"></i>
                                      <i class="fa fa-star star-light submit_star mr-1" id="submit_star_2"
                                          data-rating="2"></i>
                                      <i class="fa fa-star star-light submit_star mr-1" id="submit_star_3"
                                          data-rating="3"></i>
                                      <i class="fa fa-star star-light submit_star mr-1" id="submit_star_4"
                                          data-rating="4"></i>
                                      <i class="fa fa-star star-light submit_star mr-1" id="submit_star_5"
                                          data-rating="5"></i>

                                  </div>
                                  <h3><span id="total_review">{{  $total_review }}</span> Review</h3>
                              </div>
                              <div class="col-sm-6 col-md-6 col-lg-6">
                                  <p>
                                  <div class="progress-label-left">
                                      <b>5</b>
                                      <i class="fa fa-star text-warning"></i>
                                  </div>

                                  <div class="progress-label-right">
                                      (<span id="total_five_star_review">{{ $five_star_review }}</span>)
                                  </div>
                                  <div class="progress">
                                      <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                          aria-valuemin="0" aria-valuemax="100" id="five_star_progress"
                                          <?php $width = ($total_review != 0) ? (($five_star_review / $total_review) * 100) : $five_star_review;?>
                                          style="<?php echo 'width:' . $width . '%' ?>"></div>
                                  </div>
                                  </p>
                                  <p>
                                  <div class="progress-label-left"><b>4</b> <i class="fa fa-star text-warning"></i>
                                  </div>
                                  <div class="progress-label-right">(<span
                                          id="total_four_star_review">{{ $four_star_review }}</span>)</div>
                                  <div class="progress">
                                      <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                          aria-valuemin="0" aria-valuemax="100" id="four_star_progress"
                                          <?php $width = ($total_review != 0) ? (($four_star_review / $total_review) * 100) : $four_star_review;?>
                                          style="<?php echo 'width:' . $width . '%' ?>">
                                          ></div>
                                  </div>
                                  </p>
                                  <p>
                                  <div class="progress-label-left"><b>3</b> <i class="fa fa-star text-warning"></i>
                                  </div>

                                  <div class="progress-label-right">(<span
                                          id="total_three_star_review">{{ $three_star_review }}</span>)</div>
                                  <div class="progress">
                                      <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                          aria-valuemin="0" aria-valuemax="100" id="three_star_progress"
                                          <?php $width = ($total_review != 0) ? (($three_star_review / $total_review) * 100) : $three_star_review;?>
                                          style="<?php echo 'width:' . $width . '%' ?>">
                                          ></div>
                                  </div>
                                  </p>
                                  <p>
                                  <div class="progress-label-left"><b>2</b> <i class="fa fa-star text-warning"></i>
                                  </div>

                                  <div class="progress-label-right">(<span
                                          id="total_two_star_review">{{ $two_star_review }}</span>)</div>
                                  <div class="progress">
                                      <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                          aria-valuemin="0" aria-valuemax="100" id="two_star_progress"
                                          <?php $width = ($total_review != 0) ? (($two_star_review / $total_review) * 100) : $two_star_review;?>
                                          style="<?php echo 'width:' . $width . '%' ?>">></div>
                                  </div>
                                  </p>
                                  <p>
                                  <div class="progress-label-left"><b>1</b> <i class="fa fa-star text-warning"></i>
                                  </div>

                                  <div class="progress-label-right">(<span
                                          id="total_one_star_review">{{ $one_star_review }}</span>)</div>
                                  <div class="progress">
                                      <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                          aria-valuemin="0" aria-valuemax="100" id="one_star_progress"
                                          <?php $width = ($total_review != 0) ? (($one_star_review / $total_review) * 100) : $one_star_review;?>
                                          style="<?php echo 'width:' . $width . '%' ?>">></div>
                                  </div>
                                  </p>
                              </div>
                              <div class="mt-5 col-sm-12" id="review_content">
                                  <?php foreach ($review as $row) {?>
                                  <div class="row mb-3">
                                      <div class="col-sm-2">
                                          <div class="rounded-circle bg-danger text-white pt-2 pb-2">
                                              <h3 class="text-center">{{ $row->name }}</h3>
                                          </div>
                                      </div>
                                      <div class="col-sm-10">
                                          <div class="card">
                                              <div class="card-header"><b>{{ $row->email   }}</b></div>
                                              <div class="card-body mb-2">
                                                  <?php for ($i = 0; $i < 5; $i++) {?>
                                                  <i class="fa fa-star star-light submit_star mr-1
                                                    <?php if ($i < $row->rating) {echo "text-warning";}?>
                                                    ">
                                                  </i>
                                                  <?php }?>
                                                  <br>{{ $row->comment }}
                                              </div>
                                              <div class="card-footer text-right">
                                                  {{ date("Y-m-d",strtotime($row->created)) }}
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <?php }?>
                              </div>
                          </div>
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
            beforeSend: function() {
                $("#preloader").show();
            },
            complete: function() {
                $("#preloader").hide();
            },
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
                $("#preloader").show();
            },
            complete: function() {
                $("#preloader").hide();
            },
            success: function(response) {
                var typeOfResponse = response.type;
                var typeOfResponse = response.type;
                if (typeOfResponse == 0) {
                    var res = response.msg;
                    $.alert({
                        title: 'Encountered an error!',
                        content: res,
                        type: 'red',
                        typeAnimated: true,
                    })
                } else if (typeOfResponse == 1) {
                    var res = response.msg;
                    // $.alert({
                    //     title: 'Success!',
                    //     content: res,
                    //     type: 'green',
                    //     typeAnimated: true,
                    // });
                    // $('#myModal').modal('hide');
                    // window.location = '/buyer';
                    location.reload();
                }
            }
        });
    });
});
  </script>
  @endsection
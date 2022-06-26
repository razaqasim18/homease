  <!--About us banner-->
  @extends('layouts.front')
  @section('title')
  <title>Home</title>
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
              <h1><?php $blog->title;?></h1>
          </div>
      </div>
  </div>
  <!--single blog banner-->
  <!--single blog content-->
  <div class="single-blog bg-area">
      <div class="container">
          <div class="row">
              <div class="col-md-8">
                  <div class="single-blog-item">
                      <div class="single-blog-photo">
                          <?php if (!empty($blog->image)) {?>
                          <img class="lazyload" src="<?php echo asset('uploads/blog') . '/' . $blog->image; ?>"
                              alt="<?php echo $blog->title; ?>">
                          <?php }?>
                      </div>
                      <div class="single-blog-text">
                          <h2 style="text-transform: none;"><?php echo $blog->title; ?>
                          </h2>
                          <ul style="list-style: none;">
                              <li>Date: <?php $orgDate = $blog->created_at;
$newDate = date("m-d-Y", strtotime($orgDate));
echo $newDate;?></li>
                          </ul>
                          <div class="single-blog-pra">
                              <p></p>
                              <?php echo $blog->content; ?>
                              <p></p>
                          </div>
                          <h3>Share This</h3>
                          <!-- AddToAny BEGIN -->
                          <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                              <a class="a2a_dd" href="http://www.addtoany.com/share"></a>
                              <a class="a2a_button_facebook"></a>
                              <a class="a2a_button_twitter"></a>
                              <a class="a2a_button_email"></a>
                          </div>
                          <script async src="http://static.addtoany.com/menu/page.js"></script>
                          <!-- AddToAny END -->
                      </div>
                      <!--<h3>Comments</h3>-->
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="single-sidebar">
                      <div class="single-widget categories">
                          <h3>Recent Posts</h3>
                          <ul style="list-style: none;margin: 0%; padding: 0;">
                              <?php if ($recentposts) {foreach ($recentposts as $row) {?>
                              <li><a href="<?php $title = str_replace(' ', '-', $row->title);
    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
    echo url("blog/" . $title . '/' . base64_encode($row->id));?>"><?php echo $row->title; ?></a></li>
                              <?php }} else {?>
                              No record found !
                              <?php }?>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  @endsection
  @section('script')
  @endsection
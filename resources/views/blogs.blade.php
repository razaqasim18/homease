 <!--About us banner-->
 @extends('layouts.front')
 @section('title')
 <title>Home</title>
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
 <!--Blogs us banner-->
 <div class="banner-slider lazyload" style="height:300px;background-image: url(<?php echo $faqimage; ?>)">
     <div class="bg"></div>
     <div class="bannder-table">
         <div class="banner-text">
             <h1>Blogs</h1>
         </div>
     </div>
 </div>
 <!--Blogs us banner-->
 <!--Blogs content-->
 <div class="blog-page-area" style="padding-bottom: 30px;">
     <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <div id="wrapper">
                     <div class="contents">
                         <div class="row">
                             <?php if (!empty($blog)) {foreach ($blog as $row) {?>
                             <div class="col-md-6 col-sm-6 col-xs-12 blog-item">
                                 <div class="latest-item">
                                     <div class="latest-photo"
                                         style="background-image: url(<?php echo asset('uploads/blog') . '/' . $row->image; ?>)">
                                     </div>
                                     <div class="latest-text">
                                         <h2><a href="<?php $title = str_replace(' ', '-', $row->title);
    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
    echo url("blog/" . $title . '/' . base64_encode($row->id));?>"><?php echo $row->title; ?></a></h2>
                                         <ul>
                                             <li>Date: <?php $orgDate = $row->created_at;
    $newDate = date("d:m:Y", strtotime($orgDate));
    echo $newDate;?></li>
                                         </ul>
                                         <div class="latest-pra">
                                             <p></p>
                                             <div style="height: 45px;overflow: hidden;">
                                                 <?php echo trim(substr($row->content, 0, 170)) . "...."; ?>
                                             </div>
                                             <a href="<?php $title = str_replace(' ', '-', $row->title);
    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
    echo url("blog/" . $title . '/' . base64_encode($row->id));?>">Read more</a>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <?php }} else {echo "<h2>No record found !</h2>";}?>
                         </div>
                     </div>
                 </div>
             </div>
             {{-- Pagination --}}
             <div class="col-md-12">
                 {{ $blog->links('paginate') }}
             </div>
         </div>
     </div>
 </div>
 <!--Blogs content-->
 @endsection
 <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
 @section('script')
 @endsection
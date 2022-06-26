@extends('layouts.front')
@section('title')
<title>Home</title>
@endsection
@section('content')

<!--Slider-Area Start-->
<div class="slider-area">
    <div class="slider-item lazyload" style="background-image: url(<?php echo asset('uploads/banner/banner1.jpg') ?>)">
        <div class="bg-3" style="opacity:0.6;"></div>
    </div>
</div>
<!--Slider-Area End-->

<div class="blood-gallery bg-gray">
    <div class="container">
        <div class="row">
            <div class="headline">
                <h2>Recent Blog</h2>
                <div class="donner-gallery owl-carousel">
                    <?php foreach ($blogs as $row) {?>
                    <div class="donner-item">
                        <div class="donner-list">
                            <div class="donner-photo lazyload"
                                style="background-image: url(<?php echo asset('uploads/blog/') . "/" . $row->image; ?>)">
                            </div>
                            <div class="donner-info">
                                <h2><a href="
                                <?php $title = str_replace(' ', '-', $row->title);
    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
    echo url("blog/" . $title . '/' . base64_encode($row->id));?>
    "><?php echo $row->title ?></a></h2>
                                <div class="donner-link">
                                    <a href="<?php $title = str_replace(' ', '-', $row->title);
    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
    echo url("blog/" . $title . '/' . base64_encode($row->id));?>">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
@endsection
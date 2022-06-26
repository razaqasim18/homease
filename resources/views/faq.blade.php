<!--About us banner-->
@extends('layouts.front')
@section('title')
<title>Home</title>
@endsection
@section('content')
@php
$faqimage = asset('front/images/faq.png');
@endphp
<div class="banner-slider" style="height:300px;background-image: url(<?php echo $faqimage; ?>)">
    <div class="bg"></div>
    <div class="bannder-table">
        <div class="banner-text">
            <h1>Some Important Faqs</h1>
        </div>
    </div>
</div>
<!--About us banner-->
<!--About us content-->
<div class="faq-area bg-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="accordion-item">
                    <?php foreach ($faq as $row) {?>
                    <dl class="faq-accordion" style="margin: 1%;">
                        <dt class=""><?php echo $row->question; ?></dt>
                        <dd>
                            <?php echo $row->answer; ?>
                        </dd>
                    </dl>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--About us content-->
@endsection
@section('script')
@endsection
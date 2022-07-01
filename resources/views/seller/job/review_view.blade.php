@extends('buyer.layouts.app')

@section('title')Buyer || Review @endsection
@section('head')
<style>
.text-warning {
    color: #ffc107 !important;
}
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Review</h4>
                </div>
                <div class="card-body">
                    <form id="save-review" method="post">
                        <h4 class="text-center mt-2 mb-4">
                            <?php if ($reviewexists) {?>
                            <?php for ($i = 0; $i < 5; $i++) {?>
                            <i class="fas fa-star star-light submit_star mr-1
                            <?php if ($i < $reviewexists->rating) {echo "text-warning";}?>
                                "></i>
                            <?php }?>
                            <?php } else {?>
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                            <?php }?>
                        </h4>
                        <div class="form-group">
                            <textarea name="comment" id="comment" class="form-control"
                                placeholder="Type Review Here"> @if($reviewexists) {{ $reviewexists->comment }} @endif</textarea>
                        </div>
                        <div class="form-group mt-4">
                            @if($reviewexists)
                            <button type="button" class="btn btn-primary" id="save_review" disabled>Submit</button>
                            @else
                            <button type="button" class="btn btn-primary" id="save_review">Submit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
@endsection
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
                            <input type="hidden" name="service_id" id="service_id" class="form-control"
                                value="{{ $review->service_id }}" />
                            <input type="hidden" name="seller_id" id="seller_id" class="form-control"
                                value="{{ $review->seller_id }}" />
                            <input type="hidden" name="hiring_id" id="hiring_id" class="form-control"
                                value="{{ $review->id }}" />
                        </div>
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

<script>
$(document).ready(function() {

    var rating_data = 0;

    $(document).on('mouseenter', '.submit_star', function() {
        var rating = $(this).data('rating');
        reset_background();
        for (var count = 1; count <= rating; count++) {
            $('#submit_star_' + count).addClass('text-warning');
        }
    });

    $(document).on('mouseleave', '.submit_star', function() {
        reset_background();
        for (var count = 1; count <= rating_data; count++) {
            $('#submit_star_' + count).removeClass('star-light');
            $('#submit_star_' + count).addClass('text-warning');
        }
    });

    $(document).on('click', '.submit_star', function() {
        rating_data = $(this).data('rating');
    });

    function reset_background() {
        for (var count = 1; count <= 5; count++) {
            $('#submit_star_' + count).addClass('star-light');
            $('#submit_star_' + count).removeClass('text-warning');
        }
    }

    $('#save_review').click(function() {
        var service_id = $('#service_id').val();
        var seller_id = $('#seller_id').val();
        var hiring_id = $('#hiring_id').val();
        var comment = $('#comment').val();
        var token = $("meta[name='csrf-token']").attr("content");
        var rating = rating_data;
        var url = "/buyer/job/review";
        $.ajax({
            url: url,
            method: "POST",
            data: {
                "service_id": service_id,
                "seller_id": seller_id,
                "hiring_id": hiring_id,
                "comment": comment,
                "rating": rating,
                "_token": token,
            },
            beforeSend: function() {
                $(".loader").show();
            },
            complete: function() {
                $(".loader").hide();
            },
            success: function(response) {
                var result = JSON.parse(response);
                var type = result['type'];
                var res = result['msg'];
                if (type == 0) {
                    swal('Error', res, 'error');
                } else {
                    swal({
                        title: 'Success',
                        text: res,
                        icon: 'success',
                        type: 'success',
                        showCancelButton: false, // There won't be any cancel button
                        showConfirmButton: true // There won't be any confirm button
                    }).then((oK) => {
                        if (oK) {
                            if (oK) {
                                location.reload();
                            }
                        }
                    });
                }
            }
        });
    });

});
</script>
@endsection
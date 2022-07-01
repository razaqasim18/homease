@extends('seller.layouts.app')
<title>
    Seller || Subscription
</title>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Subscription') }}</div>

                <div class="card-body">
                    <!-- <center> -->
                    <h1>Pay With Easypaisa Online</h1>
                    <form target="_BLANK" action="{{ route('seller.subscription.pay') }}">
                        Order ID:<input class="form-control" type="text" name="orderId"
                            <?php $orderid = rand() . "-" . Auth::guard('seller')->user()->id;?>
                            value="<?php echo $orderid; ?>"><br>
                        Payment:<input class="form-control" type="text" name="amount" value="1.00">
                        <br>
                        <br>
                        <button class="btn btn-primary">Pay</button>
                    </form>
                    <!-- </center> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
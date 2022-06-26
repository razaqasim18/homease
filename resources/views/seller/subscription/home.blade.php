@extends('seller.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Subscription') }}</div>

                <div class="card-body">
                    <center>
                        <h1>Pay With Easypaisa Online</h1>
                        <form target="_BLANK" action="{{ route('seller.subscription.pay') }}">
                            Order ID:<input type="text" name="orderId"
                                <?php $orderid = rand() . "-" . Auth::guard('seller')->user()->id;?>
                                value="<?php echo $orderid; ?>"><br>
                            Payment:<input type="text" name="amount" value="1.00">
                            <br>
                            <button>Pay</button>
                        </form>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
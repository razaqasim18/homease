<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Seller Password Reset') }}</div>
                <div class="card-body">
                    <!-- <h1>Email Verification Mail</h1> -->

                    Please follow link:
                    <a href="{{ route('seller.password.verify', $token) }}">Reset</a>
                </div>
            </div>
        </div>
    </div>
</div>
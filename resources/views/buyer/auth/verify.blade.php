<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>
                <div class="card-body">
                    <h1>Email Verification Mail</h1>

                    Please verify your email with bellow link:
                    <a href="{{ route('buyer.verify', $token) }}">Verify Email</a>
                </div>
            </div>
        </div>
    </div>
</div>
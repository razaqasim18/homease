@extends('seller.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <form name="easypayform" method="get" action="<?php echo $response['easypayIndexPage']; ?>">
                        <input name="storeId" value="<?php echo $response['storeId']; ?>" hidden="true" />
                        <input name="orderId" value="<?php echo $response['orderId']; ?>" hidden="true" />
                        <input name="transactionAmount" value="<?php echo $response['amount']; ?>" hidden="true" />
                        <input name="mobileAccountNo" value="<?php echo $response['custCell']; ?>" hidden="true" />
                        <input name="emailAddress" value="<?php echo $response['custEmail']; ?>" hidden="true" />
                        <input name="transactionType" value="InitialRequest" hidden="true" />
                        <?php if ($response['expiryDate'] != '' && $response['expiryDate'] != null) {?>
                        <input name="tokenExpiry" value="<?php echo $response['expiryDate']; ?>" hidden="true" />
                        <?php }?>
                        <input name="bankIdentificationNumber" value="" hidden="true" />
                        <input name="encryptedHashRequest" value="<?php echo $response['hashRequest']; ?>"
                            hidden="true" />
                        <input name="merchantPaymentMethod" value="<?php echo $response['paymentMethodVal']; ?>"
                            hidden="true" />
                        <input name="postBackURL" value="<?php echo $response['merchantConfirmPage']; ?>"
                            hidden="true" />
                        <input name="signature" value="" hidden="true" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script response-cfasync="false" type="text/javascript">
document.easypayform.submit();
</script>
@endsection
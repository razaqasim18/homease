<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use DateTime;

class SubscriptionController extends Controller
{

    public function index()
    {
        return view('seller.subscription.home');
    }

    public function payWithEasyPaisa()
    {
        // define("storeId", "17119"); //Store ID
        // define("daysToExpire", "2"); // Token Expiry Day
        // define("live", "no"); // yes if live
        // define("hashKey", "TR4VA7CTO5JVGIOQ"); //hash key provided by Easypay
        // define("methods", "");
        //MA_PAYMENT_METHOD
        //OTC_PAYMENT_METHOD
        //MA_PAYMENT_METHOD
        //CC_PAYMENT_METHOD
        //empty To use all
        // define("UrlBack", "https://thebestexperts.com.pk/easypaisa/statusEasypay.php"); // URL where response returned
        $methods = '';
        $UrlBack = url('seller/subscription/pay/urlback');
        $data['storeId'] = $storeId = "17119";
        $daysToExpire = "2";

        $liveVal = "no";
        $easypayIndexPage = '';
        if ($liveVal == 'no') {
            $data['easypayIndexPage'] = 'https://easypaystg.easypaisa.com.pk/tpg/';
        } else {
            $data['easypayIndexPage'] = 'https://easypay.easypaisa.com.pk/tpg/';
        }

        $data['merchantConfirmPage'] = $merchantConfirmPage = $UrlBack;

        $data['orderId'] = $orderId = $_GET['orderId'];
        if (strpos($_GET['amount'], '.') !== false) {
            $data['amount'] = $amount = $_GET['amount'];
        } else {
            $data['amount'] = $amount = sprintf("%0.1f", $_GET['amount']);
        }

        $data['custEmail'] = @$custEmail = $_GET['custEmail'];
        $data['custCell'] = @$custCell = $_GET['custCell'];
        $hashKey = "TR4VA7CTO5JVGIOQ";
        date_default_timezone_set('Asia/Karachi');
        $expiryDate = '';
        $currentDate = new DateTime();
        if ($daysToExpire != null) {
            $currentDate->modify('+' . $daysToExpire . 'day');
            $data['expiryDate'] = $expiryDate = $currentDate->format('Ymd His');
        }

        $data['paymentMethodVal'] = $paymentMethodVal = $methods;

        $hashRequest = '';
        if (strlen($hashKey) > 0 && (strlen($hashKey) == 16 || strlen($hashKey) == 24 || strlen($hashKey) == 32)) {
            // Create Parameter map
            $paramMap = array();
            $paramMap['amount'] = $amount;
            if ($custEmail != null && $custEmail != '') {
                $paramMap['emailAddress'] = $custEmail;
            }
            if ($expiryDate != null && $expiryDate != '') {
                $paramMap['expiryDate'] = $expiryDate;
            }
            if ($paymentMethodVal != null && $paymentMethodVal != '') {
                $paramMap['merchantPaymentMethod'] = $paymentMethodVal;
            }
            if ($custCell != null && $custCell != '') {
                $paramMap['mobileNum'] = $custCell;
            }
            $paramMap['orderRefNum'] = $orderId;
            $paramMap['paymentMethod'] = "InitialRequest";
            $paramMap['postBackURL'] = $merchantConfirmPage;
            $paramMap['storeId'] = $storeId;
            $paramMap['timeStamp'] = date("Y-m-d\TH:i:00");

            //Creating string to be encoded
            $mapString = '';
            foreach ($paramMap as $key => $val) {
                $mapString .= $key . '=' . $val . '&';
            }
            $mapString = substr($mapString, 0, -1);

            // Encrypting mapString

            $cipher = "aes-128-ecb";
            $crypttext = openssl_encrypt($mapString, $cipher, $hashKey, OPENSSL_RAW_DATA);
            $data['hashRequest'] = base64_encode($crypttext);
        }
        return view('seller.subscription.paypaisa', ['response' => $data]);
    }

    public function UrlBack()
    {
        $status = $_GET['status'];
        $orderRefNumber = $_GET['orderRefNumber'];
        $paymentMethod = $_GET['paymentMethod'];

        if (!(is_null($status))) {
            if ($status == '0000') {
                echo "Payment  Received";
                if ($paymentMethod == 'OTC') {
                    echo "Payment  Received but pending";
                } else {
                    // echo "Payment  Received succeddfully";
                    $response = explode("-", $orderRefNumber);
                    $id = $response[1];
                    $seller = Seller::find($id);
                    $expireDate = date("Y-m-d", strtotime(date("Y-m-d") . "+1 month"));
                    $seller->isexpired = 0;
                    $seller->expired_at = $expireDate;
                    $seller->save();
                    return redirect()->route('seller.dashboard')->with('success', "You package have been updated");
                }
            } else {
                echo "Payment Not Received";
            }
        }
    }

    public function updatePackage($id)
    {}
}
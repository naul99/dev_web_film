<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Movie_Package;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Session;

class PayPalPaymentController extends Controller
{
    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request)
    {
        $total = Session::get('total_paypal');
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('successTransaction'),
                'cancel_url' => route('cancelTransaction'),
            ],
            'purchase_units' => [
                0 => [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $total
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()->route('register-package')->with('error', 'Something went wrong');
        } else {
            return redirect()->route('register-package')->with('error', $response['message'] ?? 'Something went wrong');
        }
    }
    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $customer_id = Session::get('customer_id');
            $package_id = Session::get('package_id');
            $date = Session::get('package_time');
            $price = Session::get('package_price');

            $order = new Order;
            $order->customer_id = $customer_id;
            $order->package_id = $package_id;
            $order->price = $price;
            $order->payment = 'paypal';
            $order->number_date = $date;
            $order->expiry = '0';
            $order->date_start = Carbon::now('Asia/Ho_Chi_Minh');
            $order->date_end = Carbon::now('Asia/Ho_Chi_Minh')->addDays($date);
            $order->save();

            //modify status register package movie
            $customer = Customer::where('id', $customer_id)->first();
            $customer->status_registration = '1';
            $customer->save();

            Session::forget('package_id');
            Session::forget('package_time');
            Session::forget('package_price');
            return redirect()->route('register-package')->with('success', 'Thanh toán thành công. Cảm ơn bạn đã sử dụng dịch vụ.');
        } else {
            return redirect()->route('register-package')->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
    /**
     * canel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()->route('register-package')->with('error', $response['message'] ?? 'You have canceled the transaction..');
    }

    public function paymentVnpay(Request $request)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = env('APP_URL')."/register-package";
        $vnp_TmnCode = env('VNP_TMNCODE', ''); //Mã website tại VNPAY
        $vnp_HashSecret = env('VNP_HASHSECRET', ''); //Chuỗi bí mật

        $order=Order::orderBy('id','DESC')->first();
       
        $vnp_TxnRef = $order->id +1; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán cho dịch vụ gói xem phim';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = Session::get('total_vnpay') * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
          
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            header('Location: ' . $vnp_Url);
            die();
           // echo json_encode($returnData);
        }

      
    }
}

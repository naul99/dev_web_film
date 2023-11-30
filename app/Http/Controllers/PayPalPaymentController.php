<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\Customer;
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
}

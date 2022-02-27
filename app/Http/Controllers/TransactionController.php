<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Payment;
use Exception;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandBoxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class TransactionController extends Controller
{
    // Retrieve ID, Secret from env, and setting up the sandbox
    public static function Environment()
    {
        if (getenv("PAYPAL_MODE") == 'sandbox')
        {
            $clientId = getenv("PAYPAL_SANDBOX_CLIENT_ID");
            $clientSecret = getenv("PAYPAL_SANDBOX_CLIENT_SECRET");
            return new SandBoxEnvironment($clientId, $clientSecret);
        }
        else
        {
            // Code to go live with PayPal
        }
        
    }

    public function Payment(Request $request)
    {
        $data = [];

        $paypal = new PayPalHttpClient(self::environment());
        $OrderRequest = new OrdersCreateRequest();
        $OrderRequest->prefer('return=representation');

        $data['purchase_units'] = [
            [
                'amount' => [
                    'value' => $request->amount,
                    'currency_code' => 'USD'
                ]
            ]
        ];
        $data['intent'] = 'CAPTURE';
        $data['application_context'] = [
            'return_url' => route('payment.success'),
            'cancel_url' => route('payment.failed')
        ];

        $OrderRequest->body = $data;
        $response = response()->json($paypal->execute($OrderRequest));
        $content = $response->getOriginalContent();

        if($content->result->status === 'CREATED'){
            $order = new Order;
            $order->order_id = $content->result->id;
            $order->amount = $request->amount;
            $order->status = 'PENDING';
            $order->save();
        }
        return redirect($content->result->links[1]->href);
    }

    public function Success(Request $request) 
    {   
        try
        {
            $paypal = new PayPalHttpClient(self::environment());
            $orderID = $request->input('token');
            $request = new OrdersCaptureRequest($orderID);
            $request->prefer('return=representation');
            $response = response()->json($paypal->execute($request));

            $content = $response->getOriginalContent();
            if($content->result->status === 'COMPLETED'){
                // Save the payment details to payment table
                $payment = new Payment;
                $payment->order_id = $orderID;
                $payment->status = 'COMPLETE';
                $payment->payer_email = $content->result->payer->email_address;
                $payment->payer_order_id = $content->result->id;
                $payment->save();

                // Update Order status to COMPLETE
                DB::table('orders')
                ->where('order_id', $orderID)
                ->update(['status' => 'COMPLETE']);
            }
        }

        // Error handling for various error codes
        catch(Exception $e)
        {
            $errorCode = $e->statusCode;
            // Example of handling error 
            if ($errorCode === 422)
            {
                return 'This order is already processed !<br><br>Reference order id : '.$orderID;
            }
            else if ($errorCode === 404)
            {
                return 'Order not found !';
            }
            else
            {
                return 'Error code : '.$errorCode;
            }
        }
        return view('payment.success', ['orderID' => $orderID]);
    }

    public function Failed(Request $request)
    {
        $orderID = $request->input('token');

        // Update Order status to FAILED
        DB::table('orders')
        ->where('order_id', $orderID)
        ->update(['status' => 'FAILED']);

        return view('payment.failed', ['orderID' => $orderID]);
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Payment;

class RazorpayController extends Controller
{
    public function createOrder(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $order = $api->order->create([
            'receipt' => uniqid(),
            'amount' => $request->amount * 100,
            'currency' => 'INR'
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount' => $order['amount'],
            'currency' => $order['currency'],
        ]);
    }

    public function verify(Request $request)
    {
        $generated_signature = hash_hmac(
            'sha256',
            $request->razorpay_order_id . '|' . $request->razorpay_payment_id,
            env('RAZORPAY_SECRET')
        );

        if ($generated_signature === $request->razorpay_signature) {
            Payment::create([
                'payment_id' => $request->razorpay_payment_id,
                'order_id' => $request->razorpay_order_id,
                'signature' => $request->razorpay_signature,
                'status' => 'success',
                'amount' => 50000 // or fetch from DB
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    public function storeFailed(Request $request)
    {
        Payment::create([
            'payment_id' => null,
            'order_id' => $request->order_id,
            'signature' => null,
            'status' => 'failed',
            'amount' => 50000, // or fetch from DB
            'failure_reason' => $request->reason,
        ]);

        return response()->json(['stored' => true]);
    }
}
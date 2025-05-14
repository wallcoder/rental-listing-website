<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as FacadesLog;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    protected $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }

    public function createOrder(Request $request)
    {
        $order = $this->razorpay->order->create([
            'receipt' => 'rcptid_' . uniqid(),
            'amount' => $request->amount,
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        return response()->json($order->toArray());
    }

    public function verifyPayment(Request $request)
    {
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ];

        try {
            $this->razorpay->utility->verifyPaymentSignature($attributes);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            FacadesLog::error('Razorpay verification failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }


  

public function storePayment(Request $request)
{
    try {
        $payment = Payment::create([
            'user_id' =>  $request->user()->id,
            'amount' => $request->input('amount'),
            'currency' => $request->input('currency', 'INR'),
            'purpose' => $request->input('purpose'),
           
            'post_id' => $request->input('post_id'),
            
            'ref_id' => $request->input('ref_id'),
            'order_id' => $request->input('order_id'),
           
            'status' => $request->input('status'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment stored successfully.',
            'data' => $payment,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to store payment.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}

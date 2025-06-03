<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Exception;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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


public function getUserPayments(Request $request){

    try{
         $payment = Payment::where('user_id', $request->user()->id)->get();

          return response()->json([
            'success' => true,
            'message' => 'Payment fetched.',
            'data' => $payment,
        ]);
    }catch(Exception $e){
         return response()->json([
            'success' => false,
            'message' => 'Failed to store payment.',
            'error' => $e->getMessage(),
        ], 500);
    }
   

}

public function registerSubMerchant(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'phone' => 'required|string',
        'type' => 'required|string|in:route',
        'reference_id' => 'required|string',
        'legal_business_name' => 'required|string',
        'business_type' => 'required|string',
        'contact_name' => 'required|string',
        'profile.category' => 'required|string',
        'profile.subcategory' => 'required|string',
        'profile.addresses.registered.street1' => 'required|string',
        'profile.addresses.registered.street2' => 'nullable|string',
        'profile.addresses.registered.city' => 'required|string',
        'profile.addresses.registered.state' => 'required|string',
        'profile.addresses.registered.postal_code' => 'required|string',
        'profile.addresses.registered.country' => 'required|string|size:2',
        'legal_info.pan' => 'required|string',
        'legal_info.gst' => 'required|string',
    ]);

    $payload = [
        'email' => $request->email,
        'phone' => $request->phone,
        'type' => $request->type,
        'reference_id' => $request->reference_id,
        'legal_business_name' => $request->legal_business_name,
        'business_type' => "individual",
        'contact_name' => $request->contact_name,
        'profile' => [
            'category' => "healthcare",
            'subcategory' => "clinic",
            'addresses' => [
                'registered' => [
                    'street1' => $request->input('profile.addresses.registered.street1'),
                    'street2' => $request->input('profile.addresses.registered.street2'),
                    'city' => $request->input('profile.addresses.registered.city'),
                    'state' => $request->input('profile.addresses.registered.state'),
                    'postal_code' => $request->input('profile.addresses.registered.postal_code'),
                    'country' => $request->input('profile.addresses.registered.country'),
                ],
            ],
        ],
        'legal_info' => [
            'pan' => "AAACL1234C",
            'gst' => "18AABCU9603R1ZM",
        ],
    ];

    try {
        $response = Http::withBasicAuth(config('services.razorpay.key_id'), config('services.razorpay.key_secret'))
            ->post('https://api.razorpay.com/v2/accounts', $payload);

        if ($response->successful()) {
            $accountData = $response->json();

            return response()->json([
                'message' => 'Sub-merchant registered successfully',
                'account_id' => $accountData['id'],
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to create linked account',
                'details' => $response->json(), 'data' => $request->all()
            ], $response->status());
        }
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error communicating with Razorpay',
            'error' => $e->getMessage(),
        ], 500);
    }
}


}

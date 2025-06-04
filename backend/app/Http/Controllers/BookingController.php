<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Post;
use Exception;
use GuzzleHttp\Psr7\Message;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class BookingController extends Controller
{
     public function getCheckoutInfo(Request $request, $slug)
    {
        try {
            $validated = $request->validate([
                'checkin_date' => 'required|date',
                'checkout_date' => 'required|date|after:checkin_date',
            ]);

            $post = Post::where('slug', $slug)->where('category', 'home_stay')
                ->select('id', 'name', 'price', 'duration_type', 'user_id')
                ->with('user:id,merchant_id')
                ->firstOrFail();

            // Check if there is a booking conflict
            $conflict = Booking::where('post_id', $post->id)
                ->where(function ($query) use ($validated) {
                    $query->where(function ($q) use ($validated) {
                        $q->where('checkin_date', '<', $validated['checkout_date'])
                          ->where('checkout_date', '>', $validated['checkin_date']);
                    });
                })
                ->where('status', '=', 'active')
                ->exists();

            if ($conflict) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected dates are already booked.',
                ], 409);
            }

            return response()->json([
                'success' => true,
                'message' => 'Post fetch successful',
                'data' => $post,
            ]);
        } catch (ModelNotFoundException $e) {
            // Return 404 if post not found
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    // Laravel controller (e.g., PaymentController.php)



public function checkBookingConflict(Request $request)
{
    $validated = $request->validate([
        'post_id' => 'required|exists:posts,id',
        'checkin_date' => 'required|date',
        'checkout_date' => 'required|date|after:checkin_date',
    ]);

    $conflict = Booking::where('post_id', $validated['post_id'])
        ->where(function ($query) use ($validated) {
            $query->where(function ($q) use ($validated) {
                $q->where('checkin_date', '<', $validated['checkout_date'])
                  ->where('checkout_date', '>', $validated['checkin_date']);
            });
        })
        ->where('status', '=', 'active')
        ->exists();

    if ($conflict) {
        return response()->json([
            'success' => false,
            'message' => 'Booking conflict: The property is already booked for these dates.'
        ], 409);
    }

    return response()->json([
        'success' => true,
        'message' => 'Dates are available for booking.'
    ], 200);
}

public function insertBooking(Request $request)
{
    $validated = $request->validate([
        'post_id' => 'required|exists:posts,id',
        
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'checkin_date' => 'required|date',
        'checkout_date' => 'required|date|after:checkin_date',
        'total' => 'required|numeric|min:0',
        'status' => 'required|string|in:active,pending,cancelled,completed'
    ]);

    try {
        $booking = Booking::create([
            'post_id'=>$validated['post_id'],
            'full_name'=>$validated['full_name'],
            'email'=>$validated['email'],
            'phone'=>$validated['phone'],
            'checkin_date'=>$validated['checkin_date'],
            'checkout_date'=>$validated['checkout_date'],
            'total'=>$validated['total'],
            'status'=>$validated['status'],
            'user_id'=>$request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully.',
            'data' => $booking
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to create booking.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function createOrder(Request $request)
{
    $validated = $request->validate([
        'amount' => 'required|integer', // in paise
        'sub_account' => 'required|string',
    ]);

    // Set up Razorpay API
    $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

    // Platform commission logic
    $totalAmount = $validated['amount']; // total in paise
    $commissionRate = 0.10; 
    $platformCommission = intval($totalAmount * $commissionRate);
    $subMerchantAmount = $totalAmount - $platformCommission;

    $orderData = [
        'amount' => $totalAmount,
        'currency' => 'INR',
        'receipt' => 'rcptid_' . time(),
        'transfers' => [
            [
                'account' => $validated['sub_account'],
                'amount' => $subMerchantAmount,
                'currency' => 'INR',
                'notes' => [
                    'note' => 'Sub-merchant share after commission',
                ],
                'on_hold' => false
            ]
        ],
    ];

    $order = $api->order->create($orderData);

    return response()->json($order->toArray());
}


public function storePayment(Request $request)
{
    $validated = $request->validate([
        'amount'     => 'required|numeric|min:1',
        'currency'   => 'nullable|string|max:10',
        'signature'  => 'nullable|string',
        'ref_id'     => 'required|string',
        'order_id'   => 'required|string',
        'status'     => 'required|in:success,failed,pending',
        'booking_id' => 'nullable|exists:bookings,id',
    ]);

    try {
        $payment = Payment::create([
            'user_id'    => $request->user()->id,  // Get from authenticated user
            'amount'     => $validated['amount'],
            'currency'   => $validated['currency'] ?? 'INR',
            'signature'  => $validated['signature'] ?? null,
            'ref_id'     => $validated['ref_id'],
            'order_id'   => $validated['order_id'],
            'status'     => $validated['status'],
            'booking_id' => $validated['booking_id'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment recorded successfully',
            'data' => $payment
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to insert payment: ' . $e->getMessage()
        ], 500);
    }
}



public function verifyPayment(Request $request)
{
    $data = $request->only([
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature'
    ]);

    // Verify the signature
    $generatedSignature = hash_hmac(
        'sha256',
        $data['razorpay_order_id'] . '|' . $data['razorpay_payment_id'],
        env('RAZORPAY_SECRET')
    );

    if (!hash_equals($generatedSignature, $data['razorpay_signature'])) {
        return response()->json(['success' => false, 'message' => 'Signature mismatch']);
    }

    // Fetch payment details from Razorpay
    try {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $api->payment->fetch($data['razorpay_payment_id']);

        return response()->json([
            'success' => true,
            'payment_method' => $payment->method,        // upi, card, etc.
            'payment_details' => [
                'id' => $payment->id,
                'method' => $payment->method,
                'bank' => $payment->bank ?? null,
                'wallet' => $payment->wallet ?? null,
                'email' => $payment->email ?? null,
                'contact' => $payment->contact ?? null,
                'status' => $payment->status,
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error fetching payment details',
            'error' => $e->getMessage(),
        ], 500);
    }
}


}

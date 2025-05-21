<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlan;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $plan = Plan::select('id', 'name', 'price')->get();

            return response()->json(['success'=>true, 'message'=> 'Posts fetched successfully', 'data'=> $plan], 200);

        } catch (Exception $e) {
            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try{
            $plan = UserPlan::where('user_id', $request->user()->id)->with(['plan'])->get();

            return response()->json(['success' => true, 'message' => 'plan fetched', 'data'=> $plan ], 200);

        }catch(Exception $e){
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
       
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
{
    try {
        $userId = $request->user()->id;

        $userPlan = UserPlan::where('user_id', $userId)->first();

        if (!$userPlan) {
            return response()->json(['error' => 'User plan not found.'], 404);
        }

        $userPlan->update([
            'plan_id' => $id,
            'payment_id' => null, // keep or change as needed
            'expires_at' => Carbon::now()->addDays(30),
            'is_active' => true,
        ]);

        $user = User::where('id', $userId)->update([
            'current_plan' => 'agent'
        ]);

        return response()->json(['message' => 'User plan updated successfully.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update plan.', 'details' => $e->getMessage()], 500);
    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

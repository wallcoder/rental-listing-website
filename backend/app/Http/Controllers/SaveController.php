<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Save;
use Exception;
use Illuminate\Http\Request;

class SaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $userId = $request->user()->id;

            if(!$userId){
                return response()->json(['success'=>false, 'message'=>"Unauthorized Access"], 401);
            }

            $save = Save::where('user_id', $userId);

            return response()->json(['success'=>true, 'message'=>"Saves Found", 'data'=>$save], 200);

        }catch(Exception $e){
            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }
    }



    public function getSavedListings(Request $request){

        try{
            $userId = $request->user()->id;

            if(!$userId){
                return response()->json(['success'=>false, 'message'=>"Unauthorized Access"], 401);
            }

            $posts = Post::whereHas('saves', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->select('id','user_id', 'category', 'thumbnail', 'status', 'slug', 'created_at')
            ->with([
                'location:post_id,locality,city',
                'house:post_id,price,bedroom,bathroom,description',
                'saves' => function ($q) use ($userId) {
                    $q->where('user_id', $userId)->select('id', 'post_id'); // Include save ID
                },
                'shop:post_id,price,water_supply,electricity,description'
            ])
            ->orderBy('created_at', 'desc')->get();
           
            
            return response()->json(['success'=>true, 'message'=>'Saved Listings Fetched', 'data'=>$posts], 200);

        }catch(Exception $e){
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
    public function store(Request $request, $id)
    {
        try {
            
            $userId = $request->user()->id;

            $check = Save::where('post_id', $id)->where('user_id', $userId)->first();
            
            if ($check) {
                $check->delete();
                return response()->json(['success' => true, 'message' => 'Post deleted from Saved'], 200);
            }

            $save = Save::create([
                'post_id'=>$id,
                'user_id'=>$userId
            ]);

            return response()->json(['success'=>true, 'message'=>'Post added to saved'], 200);
        } catch (Exception $e) {

            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Location;
use App\Models\Shop;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Post;
use App\Models\House;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Support\Str;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $loc = $request->query('loc');
            $pag = $request->query('pag');

            if(!$loc){
                $post = Post::select('id','user_id', 'category', 'thumbnail', 'status', 'slug', 'created_at')->with(['location' => function($query){
                    $query->select('post_id','locality', 'city');
                }, 'house:post_id,price,bedroom,bathroom', 'shop:post_id,price,water_supply,electricity'])->orderBy('created_at', 'desc')->cursorPaginate($pag);

                return response()->json(['success'=>true, 'message'=> 'Posts fetched successfully', 'data'=> $post], 200);
            }

            $post = Post::select('id','user_id', 'category', 'thumbnail', 'status', 'created_at')->whereHas('location', function($query) use($loc){
                $query->where('city', $loc);
            })->with(['location' => function($query){
                $query->select('post_id','locality', 'city');
            }, 'house:post_id,price,bedroom,bathroom', 'shop:post_id,price,water_supply,electricity'])->orderBy('created_at', 'desc')->cursorPaginate($pag);

            return response()->json(['success'=>true, 'message'=> 'Posts fetched successfully', 'data'=> $post], 200);

           

        }catch(Exception $e){
            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }
    }

    public function browse(Request $request){
        try {
            $street = $request->query('street');
            $locality = $request->query('locality');
            $city = $request->query('city');
            $state = $request->query('state');
            $pincode = $request->query('pincode');
            $country = $request->query('country');
            $pag = $request->query('limit', 1);
    
            $post = Post::select('id', 'user_id', 'category', 'thumbnail', 'status', 'slug', 'created_at')
                ->whereHas('location', function($query) use ($street, $locality, $city, $state, $pincode, $country) {
                    $query->when($street, function($q) use ($street) {
                        $q->where('street', 'like', "%$street%");
                    });
                    $query->when($locality, function($q) use ($locality) {
                        $q->where('locality', 'like', "%$locality%");
                    });
                    $query->when($city, function($q) use ($city) {
                        $q->where('city', 'like', "%$city%");
                    });
                    $query->when($pincode, function($q) use ($pincode) {
                        $q->where('pincode', 'like', "%$pincode%");
                    });
                    $query->when($state, function($q) use ($state) {
                        $q->where('state', 'like', "%$state%");
                    });
                    $query->when($country, function($q) use ($country) {
                        $q->where('country', 'like', "%$country%");
                    });
                })
                ->with([
                    'location:post_id,locality,city',
                    'house:post_id,price,bedroom,bathroom',
                    'shop:post_id,price,water_supply,electricity'
                ])
                ->orderBy('created_at', 'desc')
                ->paginate($pag);
    
            return response()->json([
                'success' => true,
                'message' => 'Posts fetched successfully',
                'data' => $post
            ], 200);
    
        } catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $user  = $request->user()->id;
            $thumbnail =  $request->hasFile('thumbnail') ? $request->file('thumbnail')->store('uploads', 'public') : null; 
            $images = [];
            $slug = Str::random(10);
            
            
           if($request->hasFile('images')){
                foreach($request->file('images') as $image){
                    $path = $image->store('uploads', 'public');
                    $images[] = $path;
                }
           }

        //    return response()->json(['hello'=>$request->all()]);
           
           $post = Post::create(
            [
                'user_id'=>$user,
                'category'=>$request->input('category'),
                'type'=>$request->input('type'),
                'thumbnail'=>$thumbnail,
                'owner_name'=>$request->input('contactDetails.owner'),
                'phone'=>$request->input('contactDetails.phone'),
                'email'=>$request->input('contactDetails.email'),
                'slug'=>$slug
            ]

            

            );

           if($request->category == "house"){
            $house = House::create([
                'post_id'=>$post->id,
                'price'=>$request->input('houseDetails.price'),
                'area'=>$request->input('houseDetails.area'),
                'description'=>$request->input('houseDetails.description'),
                'balcony'=>$request->input('houseDetails.balcony'),
                'parking'=>$request->input('houseDetails.parking'),
                'furnished'=>$request->input('houseDetails.furnished'),
                'bathroom'=>$request->input('houseDetails.bathroom'),
                'bedroom'=>$request->input('houseDetails.bedroom'),
            ]);
        }else{

            $shop = Shop::create([
                'post_id'=>$post->id,
                'price'=>$request->input('shopDetails.price'),
                'area'=>$request->input('shopDetails.area'),
                'description'=>$request->input('shopDetails.description'),
                'electricity'=>$request->input('shopDetails.electricity'),
                'water_supply'=>$request->input('shopDetails.water'),
                'attached_bathroom'=>$request->input('shopDetails.bathroom'),
                'floor'=>$request->input('shopDetails.floor'),
                
            ]);

        }


        $location = Location::create([
            'post_id'=>$post->id,
            'latitude'=>$request->input('location.lat'),
            'longitude'=>$request->input('location.lng'),
            'street'=>$request->input('address.street'),
            'locality'=>$request->input('address.locality'),
            'city'=>$request->input('address.city'),
            'state'=>$request->input('address.state'),
            'pincode'=>$request->input('address.pincode'),
            'country'=>$request->input('address.country'),
        ]);

        foreach($images as $i){
            $image = Image::create([
                'post_id'=>$post->id,
                'image'=>$i,
            ]);
        }


        return response()->json(['success'=>true, 'message'=>'Post created successfully'], 200);
        

        }catch(Exception $e){
            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        try{

            $item = Post::where('slug', $slug)->with([
                'location',
                'house',
                'shop',
                'image'
            ])->get();

            return response()->json([
                'success' => true,
                'message' => 'Item fetched successfully',
                'data' => $item
            ], 200);
    

        }catch(Exception $e){
            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);

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

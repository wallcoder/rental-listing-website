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
use Illuminate\Support\Facades\DB;
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
                $post = Post::select('id','user_id', 'category', 'thumbnail', 'status', 'slug', 'area', 'price', 'created_at', 'is_boosted')->with(['location' => function($query){
                    $query->select('post_id','locality', 'city');
                }, 'house:post_id,bedroom,bathroom', 'shop:post_id,water_supply,electricity'])->orderBy('created_at', 'desc')->cursorPaginate($pag);

                return response()->json(['success'=>true, 'message'=> 'Posts fetched successfully', 'data'=> $post], 200);
            }

            $post = Post::select('id','user_id', 'category', 'thumbnail', 'status', 'created_at')->whereHas('location', function($query) use($loc){
                $query->where('city', $loc);
            })->with(['location' => function($query){
                $query->select('post_id','locality', 'city');
            }, 'house:post_id,bedroom,bathroom', 'shop:post_id,water_supply,electricity'])->orderBy('created_at', 'desc')->cursorPaginate($pag);

            return response()->json(['success'=>true, 'message'=> 'Posts fetched successfully', 'data'=> $post], 200);

           

        }catch(Exception $e){
            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }
    }

   public function browse(Request $request)
{
    try {
        // Location filters
        $street = $request->query('street');
        $locality = $request->query('locality');
        $city = $request->query('city');
        $state = $request->query('state');
        $pincode = $request->query('pincode');
        $country = $request->query('country');


        // Filters from frontend
        $category = $request->query('category'); // 'house' or 'shop'
        $type = $request->query('type'); // e.g. 'rent', 'sale'
        $sort = $request->query('sort'); // e.g. 'price_asc', 'price_desc', 'latest'

        $minPrice = $request->query('minPrice');
        $maxPrice = $request->query('maxPrice');
        $minArea = $request->query('minArea');
        $maxArea = $request->query('maxArea');
        // Additional filters
    $minBed = $request->query('minBed');
    $maxBed = $request->query('maxBed');
    $minBath = $request->query('minBath');
    $maxBath = $request->query('maxBath');


        $pag = $request->query('limit', 20);

        // Base query
        $query = Post::select('id', 'user_id', 'category', 'type', 'thumbnail', 'status', 'slug', 'price', 'area', 'created_at')
            ->where('status', 'active')
            ->whereHas('location', function($q) use ($street, $locality, $city, $state, $pincode, $country) {
                $q->when($street, fn($q) => $q->where('street', 'like', "%$street%"));
                $q->when($locality, fn($q) => $q->where('locality', 'like', "%$locality%"));
                $q->when($city, fn($q) => $q->where('city', 'like', "%$city%"));
                $q->when($state, fn($q) => $q->where('state', 'like', "%$state%"));
                $q->when($pincode, fn($q) => $q->where('pincode', 'like', "%$pincode%"));
                $q->when($country, fn($q) => $q->where('country', 'like', "%$country%"));
            })
            ->when($category, fn($q) => $q->where('category', $category))
            ->when($type, fn($q) => $q->where('type', $type))
            ->when($minPrice, fn($q) => $q->where('price', '>=', $minPrice))
            ->when($maxPrice, fn($q) => $q->where('price', '<=', $maxPrice))
            ->when($minArea, fn($q) => $q->where('area', '>=', $minArea))
            ->when($maxArea, fn($q) => $q->where('area', '<=', $maxArea))
            ->with(['location:post_id,locality,city']);

        // Apply house-specific filters
if ($category === 'house' && ($minBed || $maxBed || $minBath || $maxBath)) {
    $query->whereHas('house', function($q) use ($minBed, $maxBed, $minBath, $maxBath) {
        if ($minBed) {
            $q->where('bedroom', '>=', $minBed);
        }
        if ($maxBed) {
            $q->where('bedroom', '<=', $maxBed);
        }
        if ($minBath) {
            $q->where('bathroom', '>=', $minBath);
        }
        if ($maxBath) {
            $q->where('bathroom', '<=', $maxBath);
        }
    });
}


        // Sorting
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'area_asc':
                $query->orderBy('area', 'asc');
                break;
            case 'area_desc':
                $query->orderBy('area', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $posts = $query->paginate($pag);

        return response()->json([
            'success' => true,
            'message' => 'Posts fetched successfully',
            'data' => $posts
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}


    
    public function setBoost(Request $request, $id)
{
    try {
        $post = Post::findOrFail($id);

        $post->is_boosted = true;
        $post->boosted_until = now()->addDays(7);
        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Post has been successfully boosted.',
            'data' => $post
        ]);
    } catch (Exception $e) {
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
            $boostInput = $request->input('boost');
            $boost = filter_var($boostInput, FILTER_VALIDATE_BOOLEAN);
            $boostExpiresAt = null; // Initialize with null

            if ($boost) {
                 $boostExpiresAt = now()->addDays(7);
                }

            
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
                'area'=>$request->input('area'),
                'price'=>$request->input('price'),
                'is_boosted'=>$boost,
                'boosted_until'=>$boostExpiresAt,
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


    public function getUserPosts(Request $request){
        try{
            $userId = $request->user()->id;

            if(!$userId){
                return response()->json(['success'=>false, 'message'=>"Unauthorized Access"], 401);
            }

            $posts = Post::where('user_id', $userId)
            ->select('id','user_id', 'category', 'thumbnail', 'status', 'slug', 'area', 'price', 'is_boosted', 'created_at')
            ->with([
                'location:post_id,locality,city',
                'house:post_id,bedroom,bathroom,description',
                'saves' => function ($q) use ($userId) {
                    $q->where('user_id', $userId)->select('id', 'post_id'); // Include save ID
                },
                'shop:post_id,water_supply,electricity,description'
            ])
            ->orderBy('created_at', 'desc')->get();
            
            return response()->json(['success'=>true, 'message'=>'Posts Fetched', 'data'=>$posts], 200);
        
        
        }catch(Exception $e){
            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);

        }
    }


    public function getTopLocations()
{
    try{

    
    $topLocations = Location::with('post')
        ->whereHas('post', function ($query) {
            $query->where('status', 'active'); // filter active posts
        })
        ->select('city', DB::raw('COUNT(*) as post_count'))
        ->groupBy('city')
        ->orderByDesc('post_count')
        ->limit(3)
        ->get();

    return response()->json(['success'=>true, 'message'=>'Top Location Fetched', 'data'=>$topLocations], 200);
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
    public function destroy(Request $request, string $id)
    {
        try {
            $userId = $request->user()->id;
            if(!$userId){
                return response()->json(['success'=>false, 'message'=>"Unauthorized Access"], 401);
            }

            Post::where('id', $id)->where('user_id', $userId)->delete();

            return response()->json(['success' => true, 'message' => 'Post deleted'], 200);



        } catch(Exception $e){
            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);

        }
        
    }
}

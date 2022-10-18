<?php

namespace App\Http\Controllers;

use App\Models\like;
use App\Http\Requests\StorelikeRequest;
use App\Http\Requests\UpdatelikeRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorelikeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorelikeRequest $request)
    {
        $like = like::query()->create([
            'product_id'=>$request->product_id,
            'owner_id' => Auth::id(),
        ]);
    }


//     public function store(Request $request, Product $product)
// {

//             $product->likes()->create([
//                 'product_id'=>$request->product_id,
//                 'owner_id' => Auth::id(),
//             ]);


// }




}

<?php

namespace App\Http\Controllers;

use App\Models\Categ;
use Illuminate\Http\Request;


class CategController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categ = Categ::query()->get();
        return response()->json(["key"=>$categ],200,[]);
    }



    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {



        $categvalidator=$request->validate([
            'name' => ['required'] ,
        ]);
//
//        if($categvalidator->fails()){
//            return $categvalidator->errors()->all() ;
//        }



        $categ = Categ::query()->create([
            'name'=>$request->name ,

        ]);
        return response()->json(["key"=>$categ],200,[]);
    }



    /**
     * Display the specified resource.
     */
    public function show(Categ $categ)
    {
        return response()->json(["key"=>$categ],200,[]);
    }



    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, Categ $categ)
    {
        $categ->update([
            'name'=>$request->name,

        ]);
        return response()->json(["key"=>$categ],200,[]);
    }



    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Categ $categ)
    {
        $categ->delete();
    }
}

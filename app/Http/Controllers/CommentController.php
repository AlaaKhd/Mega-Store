<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Product $product)
    {
        $comments = $product->comments()->get();
        return response()->json(["key"=>$comments],200,[]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
//        $productvalidator=$request->validate([
//            'text'        => ['required','string']
//
//        ]);

        $request->validate([
            'text' => ['required', 'string','min:1', 'max:400']
        ]);
        $comment = $product->comments()->create([
            'text' => $request->text,
            'owner_id' => Auth::id()
        ]);

        return response()->json(["key"=>$comment],200,[]);
    }



    /**
     * Display the specified resource.
     *

     */


    // public function show(Comment $comment)
    // {

    // }

    /**
     * Update the specified resource in storage.
     *

     */


    // public function update(Request $request, Comment $comment)
    // {
    //     $comment ->update([
    //         'text' => $request->text,
    //     ]);

    //     return response()->json(["key"=>$comment],200,[]);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Comment $comment)
    // {
    //     $comment->delete();
    // }
}

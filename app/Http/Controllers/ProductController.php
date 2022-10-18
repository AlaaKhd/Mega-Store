<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\validator;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $sort_by = $request->query('sort_by');
        $category_id = $request->query('category_id');
        $price_form = $request->query('price_form');
        $price_to = $request->query('price_to');
        $name = $request->query('name');

        $productquery = Product::query();
//        $productquery ->where('price', '>=' , 200);
//        $productquery ->where('price', '<' , 4000);
//        $productquery ->where('category_id', 7);

        if($category_id !==null){
            $productquery->where('category_id', $category_id );
        }
        if($price_form !==null){
            $productquery->where('price','>=', $price_form );
        }
        if($price_to !==null){
            $productquery->where('price','<', $price_to );
        }
        if($name !==null){
            $productquery->where('name',$name );
        }

        if($sort_by !== null) {
            if($sort_by == 'price')
            $productquery->orderBy('price');
            else if($sort_by == 'quantity')
            $productquery->orderBy('quantity');
            else if($sort_by == 'viwes')
            $productquery->orderBy('viwes');
        }

        $products =$productquery
            ->whereDate('exp_date', '>= ',now())
            ->get();

            return response()->json(["key"=>$products],200,[]);
    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



//        $productvalidator = validator::make($request->all(),[
//             'name'        => ['required','string','max:255'] ,
//             'price'       => ['required','integer',] ,
//             'description' => ['required','text',] ,
//             'img_url'     => ['required','text'] ,
//             'quantity'    =>  ['integer'],
//             'exp_date'    => ['required','date'] ,
//             'category_id' => ['required','integer'] ,
//             'owner_id' ,
//
//
//         ]);
        $productvalidator=$request->validate([
            'name'        => ['required','string','max:255'] ,
            'price'       => ['required','integer'] ,
            'description' => ['required','string'] ,
            'img_url'     => ['required','string'] ,
            'quantity'    =>  ['integer'],
            'exp_date'    => ['required','date'] ,
            'phone_number' => ['required','string'] ,
            'category_id' => ['required','integer'] ,
            'category_id' =>[Rule::exists('categs','id')],


        ]);

//        if($productvalidator->fails()){
//            return Response()->validator->errors()->all() ;
//        }

        $product = Product::query()->create([
            'name'=>$request->name,
           // https://www.geeksforgeeks.org/rest-api-architectural-constraints/?ref=lbp
            'price'=>$request->price,
            'current_price'=>$request->price,
            'description'=>$request->description,
            'img_url'=>$request->img_url,
            'exp_date'=>$request->exp_date,
            'category_id'=>$request->category_id,
            'phone_number'=>$request->phone_number,
            'quantity'=>$request->quantity,
            'owner_id'=>Auth::id(),

        ]);
//        $product->discounts()->create([
//                'date' => $request->date,
//    'discount_percentage' => $request->discount_percentage,
//]);

        foreach ($request->list_discounts as $discount){
            $product->discounts()->create([

                    'date'           => $discount['date'],
                'discount_percentage' => $discount['discount_percentage'],

            ]);
        }
//        $product['current_price'] =  $product->price ;



        return response()->json(["key"=>$product],200,[]);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return Response
     */
    public function show(Product $product)
    {
        $product->load('categ','comments','like');
        // $product->increment('viwes');
        Product::find($product->increment('viwes'));

        $discounts = $product->discounts()->get();
        $maxDiscount =  null;


        foreach ($discounts as $discount) {
            if (Carbon::parse($discount['date']) <= now()) {
                $maxDiscount = $discount;
            }
        }


//         if (Carbon::parse($discounts['date']) >= now())  {
//            $maxDiscount = $discounts;
//        }

        if (!is_null($maxDiscount)){
            $discount_value = ($product->price*$maxDiscount['discount_percentage'])/100;
            $product['current_price'] = $product->price - $discount_value;
        }


        return response()->json(["key"=>$product],200,[]);
    }



    public function search(Request $request){
        $search_by_name=$request->input('search_by_name');
        $search_by_datefrom=$request->input('search_by_datefrom');
        $search_by_dateto=$request->input('search_by_dateto');
        $productquery=Product::query();
        if ($search_by_name!==null)
        {
            $productquery->where('name','LIKE','%'.$search_by_name.'%');
        }if ($search_by_datefrom!==null && $search_by_dateto !== null)
        {
            $productquery->whereBetween('exp_date', [$search_by_datefrom, $search_by_dateto]);
        }

        $products=$productquery->get();
        return response()->json(["key"=>$products],200,[]);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update([
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
            'img_url'=>$request->img_url,
//            'exp_date'=>$request->exp_date,
            'category_id'=>$request->category_id,
            'quantity'=>$request->quantity,
            'phone_number'=>$request->phone_number,
        ]);
        return response()->json(["key"=>$product],200,[]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Product as AppProduct;

class ProductController extends Controller
{
    public function index()
    {
        //get all data from db
        $products = AppProduct::all();
        return response()->json($products);
    }


    public function store(Request $request)
    {
        //post data to db from product
        $this->validate($request,[
            'title' => 'required',
            'price' => 'required',
            'photo' => 'required',
            'description' => 'required',

        ]);
        $product = new AppProduct();

        //image upload
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $allowedfileExtention=['pdf','png','jpg'];
            $extention = $file->getClientOriginalExtension();
            $check = in_array($extention, $allowedfileExtention);

            if($check){
                $name = time().$file->getClientOriginalName();
                $file->move('images',$name);
                $product->photo = $name;
            }

        }
        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        $product->save();
        return response()->json($product);

    }

 
    public function show($id)
    {
        //give 1 items from product table
        $product = AppProduct::find($id);
        return response()->json($product);
    }


    public function update(Request $request, $id)
    {
        //update
        $this->validate($request,[
            'title' => 'required',
            'price' => 'required',
            'photo' => 'required',
            'description' => 'required',

        ]);
        $product = AppProduct::find($id);
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $allowedfileExtention=['pdf','png','jpg'];
            $extention = $file->getClientOriginalExtension();
            $check = in_array($extention, $allowedfileExtention);

            if($check){
                $name = time().$file->getClientOriginalName();
                $file->move('images',$name);
                $product->photo = $name;
            }

        }
        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        $product->save();
        return response()->json($product);

    }


    public function destroy($id)
    {
        //delete
        $product = AppProduct::find($id);
        $product->delete();
        return response()->json('product delete successfully');
    }
}

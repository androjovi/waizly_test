<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Image;
use Storage;

class ProductController extends Controller
{
    function show()
    {
        $product = Product::paginate(9);
        return view('product.show', ["product" => $product]);
    }

    function showListProduct()
    {
        $product = Product::paginate(5);
        return view('product.list', ["product" => $product]);
    }

    function makeProduct()
    {
        return view('product.create', ["product" => null , 'action' => 'product.makePerformProduct', 'title' => 'Adding Product']);
    }

    function editProduct($idProduct)
    {
        $product = Product::find($idProduct);
        return view('product.create', ['product' => $product, 'action' => 'product.editPerformProduct', 'title' => 'Edit Product']);
    }

    function makePerformProduct(ProductRequest $request)
    {
        $originalName = "";
        if ($request->hasFile('image_product')){
            $file = $request->file('image_product');
            $originalName = $file->hashName();
            $img = Image::make($file->getRealPath());
            $img->stream();
            Storage::disk('local')->put('public/images/'. $originalName, $img, 'public');
        }

        $validated = [
            'code_product' => Str::random(12),
            'name_product' => $request->name_product,
            'description_product' => $request->description_product,
            'price_product' => $request->price_product,
            'image_product' => $originalName,
            'flag' => "1"
        ];
        
        $product = Product::create($validated);
        if (!$product){
            return back()->with('erorr', 'Product added failed!');    
        }

        return back()->with('success', 'Product added!');
    }

    function editPerformProduct(ProductRequest $request)
    {
        if ($request->hasFile('image_product')){
            $file = $request->file('image_product');
            $originalName = $file->hashName();
            $img = Image::make($file->getRealPath());
            $img->stream();
            Storage::disk('local')->put('public/images/'. $originalName, $img, 'public');
        }

        $product = Product::find($request->id);

        $validated = [
            'id' => $request->id,
            'code_product' => $request->code_product,
            'name_product' => $request->name_product,
            'description_product' => $request->description_product,
            'price_product' => $request->price_product,
            'image_product' => $originalName ?? $product->image_product,
            'flag' => "1"
        ];

        $product->fill($validated)->save();

        if (!$product){
            return back()->with('erorr', 'Product edit failed!');    
        }

        return back()->with('success', 'Product updated!');
    }

    function deletePerformProduct($id)
    {
        $product = Product::find($id)->delete();

        if (!$product){
            return back()->with('erorr', 'Product deleted failed!');    
        }

        return back()->with('success', 'Product deleted!');
    }
}

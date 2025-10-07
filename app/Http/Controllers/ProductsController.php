<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->name) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
        $products = $query->orderBy('id', 'desc')->paginate(100);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $product = new Product();
        return view("admin.products.create", compact('product'));
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if (!$product)
            return redirect()->back();
        return view("admin.products.create", compact('product'));
    }

    public function submit(Request $request)
    {
        // return $request;
        $product = new Product();
        if ($request->has("image")) {
            $productimage = CommonController::imgUpload($request->image, 'Products Images');
            $product->image = $productimage;
        }
        if ($request->has("hover_image")) {
            $producthoverimage = CommonController::imgUpload($request->hover_image, 'Products Hover Images');
            $product->hover_image = $producthoverimage;
        }
        $product->price = $request->price;
        $product->actual_price = $request->actual_price;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();
        return redirect()->route('admin.product.index')->with('success', 'Product Created Successfully');
    }


    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if ($request->has("image")) {
            $previousImagePath = $product->image;
            $productimage = CommonController::imgUpload($request->image, 'Products Images', $previousImagePath);
            $product->image = $productimage;
        }
        if ($request->has("hover_image")) {
            $previousImagePath = $product->hover_image;
            $produchovertimage = CommonController::imgUpload($request->hover_image, 'Products Hover Images', $previousImagePath);
            $product->hover_image = $produchovertimage;
        }
        $product->name = $request->name;
        $product->price = $request->price;
         $product->actual_price = $request->actual_price;
        $product->description = $request->description;
        $product->update();
        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
    }
}

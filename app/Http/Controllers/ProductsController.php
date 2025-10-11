<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category.parent']);

        if ($request->name) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
        $products = $query->orderBy('id', 'desc')->paginate(100);
        return view('admin.products.index', compact('products'));
    }



    // public function create()
    // {
    //     $product = new Product();
    //     return view("admin.products.create", compact('product'));
    // }

    // public function edit($id)
    // {
    //     $product = Product::find($id);
    //     if (!$product)
    //         return redirect()->back();
    //     return view("admin.products.create", compact('product'));
    // }

    public function create()
    {
        $product = new Product();
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view("admin.products.create", compact('product', 'categories'));
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if (!$product)
            return redirect()->back();
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $product_images = DB::table('product_images')->where('product_id', $id)->get();
        return view("admin.products.create", compact('product', 'categories', 'product_images'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'actual_price' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1|lte:actual_price',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'hover_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category is invalid.',
            'price.lte' => 'Sale price cannot exceed actual price.',
        ]);
        $product = new Product();
        if ($request->hasFile('image')) {
            $product->image = CommonController::imgUpload($request->image, 'Products Images');
        }
        if ($request->hasFile('hover_image')) {
            $product->hover_image = CommonController::imgUpload($request->hover_image, 'Products Hover Images');
        }
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->actual_price = $request->actual_price;
        $product->category_id = $request->category_id;
        $product->save();


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = CommonController::imgUpload($image, 'Product Multiple Images');
                DB::table('product_images')->insert([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Product Created Successfully');
    }



    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'actual_price' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1|lte:actual_price',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'hover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category is invalid.',
            'price.lte' => 'Sale price cannot exceed actual price.',
        ]);

        // Single image upload
        if ($request->hasFile('image')) {
            $previousImagePath = $product->image;
            $product->image = CommonController::imgUpload($request->image, 'Products Images', $previousImagePath);
        }

        // Hover image upload
        if ($request->hasFile('hover_image')) {
            $previousImagePath = $product->hover_image;
            $product->hover_image = CommonController::imgUpload($request->hover_image, 'Products Hover Images', $previousImagePath);
        }

        // Update basic info
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'actual_price' => $request->actual_price,
            'category_id' => $request->category_id,
        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $uploadedPath = CommonController::imgUpload($img, 'Product Multiple Images');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $uploadedPath,
                ]);
            }
        }

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Product updated successfully.');
    }



    public function deleteimage($id)
    {
        $product_image = DB::table('product_images')->where('id', $id)->first();
        if ($product_image) {
            if (file_exists(public_path($product_image->image_path))) {
                unlink(public_path($product_image->image_path));
            }
            DB::table('product_images')->where('id', $id)->delete();
            return redirect()->back()->with('success', 'Image Deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'Image not found');
        }
    }

    public function productdetails($id)
    {
        $product = DB::table('products')
            ->where('id', $id)
            ->first();
        return view('products.details', compact('product'));
    }
}

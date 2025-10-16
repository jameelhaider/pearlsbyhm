<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('admin.categories.index', compact('categories'));
    }
    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('admin.categories.create', compact('categories'));
    }


    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id'
        ]);
        $slug = Str::slug($request->name);
        if ($request->parent_id) {
            $parent = Category::find($request->parent_id);
            if ($parent) {
                $parentSlug = Str::slug($parent->name);
                $slug = $parentSlug . '-' . $slug;
            }
        }
        $url = $slug . '-r' . rand(1000, 9999) . '-t' . time();
        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'url' => $url,
        ]);
        return redirect()->route('admin.category.index')
            ->with('success', 'Category added successfully.');
    }


    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $id,
        ]);
        $data = [
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ];
        if ($request->name !== $category->name) {
            $slug = Str::slug($request->name);
            if ($request->parent_id) {
                $parent = Category::find($request->parent_id);
                if ($parent) {
                    $parentSlug = Str::slug($parent->name);
                    $slug = $parentSlug . '-' . $slug;
                }
            }
            $url = $slug . '-r' . rand(1000, 9999) . '-t' . time();
            $data['url'] = $url;
        }
        $category->update($data);
        return redirect()->route('admin.category.index')
            ->with('success', 'Category updated successfully.');
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }





    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.category.index')
            ->with('success', 'Category deleted successfully.');
    }



    public function show($url)
    {
        $category = Category::with(['parent', 'children'])
            ->where('url', $url)
            ->first();
        if (! $category) {
            return redirect()->route('welcome');
        }
        if ($category->url !== $url) {
            return redirect()->route('welcome');
        }
        $breadcrumbs = $this->buildBreadcrumb($category);
        $categoryIds = $this->getAllCategoryIds($category);
        $products = Product::whereIn('category_id', $categoryIds)->paginate(20);
        return view('categories.show', compact('category', 'products', 'breadcrumbs'));
    }


    private function getAllCategoryIds($category)
    {
        $ids = collect([$category->id]);

        foreach ($category->children as $child) {
            $ids = $ids->merge($this->getAllCategoryIds($child));
        }

        return $ids;
    }

    private function buildBreadcrumb($category, $trail = [])
    {
        $trail[] = $category;

        if ($category->parent) {
            return $this->buildBreadcrumb($category->parent, $trail);
        }

        return array_reverse($trail);
    }



    public function shopbycategory()
    {
        return view('categories.shopyby');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category', 'discounts')
            ->when($request->name, function ($query, $name) {
                return $query->where('name', 'like', "%$name%");
            })
            ->when($request->category_id, function ($query, $category_id) {
                return $query->where('category_id', $category_id);
            })
            ->paginate(10);

        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }


    public function create()
    {
        $categories = Category::all();
        $discounts = Discount::all();
        return view('products.create', compact('categories', 'discounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'discounts' => 'array',
            'discounts.*' => 'exists:discounts,id'
        ]);

        $product = Product::create($request->only(['name', 'price', 'category_id']));

        if ($request->has('discounts')) {
            $product->discounts()->sync($request->discounts);
        }

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được tạo thành công.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $discounts = Discount::all();
        $selectedDiscounts = $product->discounts->pluck('id')->toArray();

        return view('products.edit', compact('product', 'categories', 'discounts', 'selectedDiscounts'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'discounts' => 'array',
            'discounts.*' => 'exists:discounts,id'
        ]);

        $product->update($request->only(['name', 'price', 'category_id']));

        if ($request->has('discounts')) {
            $product->discounts()->sync($request->discounts);
        } else {
            $product->discounts()->detach();
        }

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }

    public function destroy(Product $product)
    {
        $product->discounts()->detach();
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được xóa thành công.');
    }
}

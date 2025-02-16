<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $discounts = Discount::when($request->name, function ($query, $name) {
            return $query->where('name', 'like', "%$name%");
        })
            ->when($request->start_date, function ($query, $start) {
                return $query->whereDate('start_date', '>=', $start);
            })
            ->when($request->end_date, function ($query, $end) {
                return $query->whereDate('end_date', '<=', $end);
            })
            ->paginate(10);

        return view('discounts.index', compact('discounts'));
    }

    public function create()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('discounts.create', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $discount = Discount::create($request->only(['name', 'discount_type', 'value', 'start_date', 'end_date', 'membership_required']));

        if ($request->has('products')) {
            $discount->products()->sync($request->products);
        }
        if ($request->has('categories')) {
            $discount->categories()->sync($request->categories);
        }

        return redirect()->route('discounts.index')->with('success', 'Discount created successfully.');
    }

    public function edit(Discount $discount)
    {
        $products = Product::all();
        $categories = Category::all();
        return view('discounts.edit', compact('discount', 'products', 'categories'));
    }

    public function update(Request $request, Discount $discount)
    {
        $discount->update($request->only(['name', 'discount_type', 'value', 'start_date', 'end_date', 'membership_required']));

        if ($request->has('products')) {
            $discount->products()->sync($request->products);
        }
        if ($request->has('categories')) {
            $discount->categories()->sync($request->categories);
        }

        return redirect()->route('discounts.index')->with('success', 'Discount updated successfully.');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully.');
    }
}

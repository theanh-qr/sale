<?php
namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Discount;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer', 'items.product')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::with('discounts')->get();
        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        $order = Order::create([
            'customer_id' => $request->customer_id,
            'total_price' => 0
        ]);

        $totalPrice = 0;
        foreach ($request->items as $itemData) {
            $product = Product::findOrFail($itemData['product_id']);
            $quantity = $itemData['quantity'];
            $price = $product->price * $quantity;

            // Kiểm tra và áp dụng khuyến mãi (nếu có)
            $discount = $product->discounts()->latest()->first();
            if ($discount) {
                if ($discount->discount_type == 'percentage') {
                    $price -= ($price * $discount->value / 100);
                } elseif ($discount->discount_type == 'amount') {
                    $price -= $discount->value;
                } elseif ($discount->discount_type == 'fix_price') {
                    $price = $discount->value * $quantity;
                }
            }

            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
                'discount_id' => $discount ? $discount->id : null
            ]);

            $totalPrice += $price;
        }

        $order->update(['total_price' => $totalPrice]);

        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được tạo thành công.');
    }

    public function edit(Order $order)
    {
        $customers = Customer::all();
        $products = Product::with('discounts')->get();
        return view('orders.edit', compact('order', 'customers', 'products'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array',
            'items.*.product_id' => 'exists:products,id',
            'items.*.quantity' => 'integer|min:1'
        ]);

        $order->items()->delete();
        $totalPrice = 0;

        foreach ($request->items as $itemData) {
            $product = Product::find($itemData['product_id']);
            $quantity = $itemData['quantity'];
            $price = $product->price * $quantity;

            // Kiểm tra khuyến mãi
            $discount = $product->discounts->first();
            if ($discount) {
                if ($discount->discount_type == 'percentage') {
                    $price -= ($price * $discount->value / 100);
                } elseif ($discount->discount_type == 'amount') {
                    $price -= $discount->value;
                } elseif ($discount->discount_type == 'fix_price') {
                    $price = $discount->value * $quantity;
                }
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
                'discount_id' => $discount ? $discount->id : null
            ]);

            $totalPrice += $price;
        }

        $order->update(['total_price' => $totalPrice]);
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được cập nhật thành công.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được xóa thành công.');
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::when($request->name, function ($query, $name) {
            return $query->where('name', 'like', "%$name%");
        })->when($request->email, function ($query, $email) {
            return $query->where('email', 'like', "%$email%");
        })->paginate(10);

        return view('customers.index', compact('customers', 'request'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'membership_type' => 'required|in:regular,vip'
        ]);

        Customer::create($request->only(['name', 'email', 'phone', 'membership_type']));
        return redirect()->route('customers.index')->with('success', 'Khách hàng đã được tạo thành công.');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'membership_type' => 'required|in:regular,vip'
        ]);

        $customer->update($request->only(['name', 'email', 'phone', 'membership_type']));
        return redirect()->route('customers.index')->with('success', 'Khách hàng đã được cập nhật thành công.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Khách hàng đã được xóa thành công.');
    }
}

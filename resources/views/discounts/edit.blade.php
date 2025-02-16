@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Edit Discount</h1>
        <form method="POST" action="{{ route('discounts.update', $discount) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $discount->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Discount Type</label>
                <select name="discount_type" class="form-control">
                    <option value="percentage" {{ $discount->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                    <option value="amount" {{ $discount->discount_type == 'amount' ? 'selected' : '' }}>Amount</option>
                    <option value="fix_price" {{ $discount->discount_type == 'fix_price' ? 'selected' : '' }}>Fixed Price</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Value</label>
                <input type="number" step="0.01" name="value" class="form-control" value="{{ $discount->value }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ $discount->start_date }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ $discount->end_date }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection

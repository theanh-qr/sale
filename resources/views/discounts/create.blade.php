@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Create Discount</h1>
        <form method="POST" action="{{ route('discounts.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Discount Type</label>
                <select name="discount_type" class="form-control">
                    <option value="percentage">Percentage</option>
                    <option value="amount">Amount</option>
                    <option value="fix_price">Fixed Price</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Value</label>
                <input type="number" step="0.01" name="value" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
@endsection

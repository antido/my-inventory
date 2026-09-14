@extends('layouts.app')

@section('title', $product->exists ? 'Edit product' : 'Add product')

@section('content')
    <div class="card form-card">
        <h1>{{ $product->exists ? 'Edit product' : 'Add product' }}</h1>
        <p>Enter the product details used to manage inventory.</p>
        <form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}">
            @csrf
            @if ($product->exists) @method('PUT') @endif

            <label class="form-label">Product name <input class="form-input" name="name" value="{{ old('name', $product->name) }}" required autofocus></label>
            @error('name') <x-alert type="error">{{ $message }}</x-alert> @enderror

            <label class="form-label">SKU <input class="form-input" name="sku" value="{{ old('sku', $product->sku) }}" required></label>
            @error('sku') <x-alert type="error">{{ $message }}</x-alert> @enderror

            <label class="form-label">Description <textarea class="form-input" name="description" rows="4">{{ old('description', $product->description) }}</textarea></label>
            @error('description') <x-alert type="error">{{ $message }}</x-alert> @enderror

            <label class="form-label">Quantity <input class="form-input" type="number" name="quantity" min="0" value="{{ old('quantity', $product->quantity ?? 0) }}" required></label>
            @error('quantity') <x-alert type="error">{{ $message }}</x-alert> @enderror

            <label class="form-label">Price <input class="form-input" type="number" name="price" min="0" step="0.01" value="{{ old('price', $product->price ?? 0) }}" required></label>
            @error('price') <x-alert type="error">{{ $message }}</x-alert> @enderror

            <div class="form-actions"><x-button type="submit">{{ $product->exists ? 'Save changes' : 'Create product' }}</x-button><x-button :href="route('admin.products.index')" variant="secondary">Cancel</x-button></div>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <section class="card">
        <div class="page-heading">
            <div>
                <h1>Products</h1>
                <p>Manage your inventory products.</p>
            </div>
            <x-button :href="route('admin.products.create')">Add product</x-button>
        </div>

        @if (session('status')) <x-alert>{{ session('status') }}</x-alert> @endif

        <form class="search-form" method="GET" action="{{ route('admin.products.index') }}">
            <label class="search-label" for="search">Search products</label>
            <div class="search-controls">
                <input id="search" class="form-input" type="search" name="search" value="{{ $search }}" placeholder="Name, SKU, or description">
                <x-button type="submit">Search</x-button>
                @if ($search)<x-button :href="route('admin.products.index')" variant="secondary">Clear</x-button>@endif
            </div>
        </form>

        <div class="table-wrap">
            <table>
                <thead><tr><th>Product</th><th>SKU</th><th>Quantity</th><th>Price</th><th class="align-right">Actions</th></tr></thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td><strong>{{ $product->name }}</strong>@if ($product->description)<br><span class="help-text">{{ $product->description }}</span>@endif</td>
                            <td>{{ $product->sku }}</td><td>{{ $product->quantity }}</td><td>{{ number_format((float) $product->price, 2) }}</td>
                            <td class="align-right"><a class="icon-action" href="{{ route('admin.products.edit', $product) }}" data-tooltip="Edit product" aria-label="Edit {{ $product->name }}"><i class="fa-solid fa-pen"></i></a><form class="inline-form" method="POST" action="{{ route('admin.products.destroy', $product) }}">@csrf @method('DELETE')<button class="icon-action delete" type="submit" data-tooltip="Delete product" aria-label="Delete {{ $product->name }}" onclick="return confirm('Delete this product?')"><i class="fa-solid fa-trash"></i></button></form></td>
                        </tr>
                    @empty
                        <tr><td colspan="5">{{ $search ? 'No products match your search.' : 'No products found.' }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-pagination :paginator="$products" />
    </section>
@endsection

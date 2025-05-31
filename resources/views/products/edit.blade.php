<x-app-layout>
<div class="container p-10">
    <x-breadcrumbs :links="[
        ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ['url' => route('products.index'), 'label' => 'Products'],
        ['url' => '', 'label' => 'Edit Product']
    ]" />
    <h1 class="h1">Edit Product</h1>

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price ($)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            @error('price') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock Quantity</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
            @error('stock') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="1" {{ old('status', $product->status) == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $product->status) == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary" type="submit">Update Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</x-app-layout>
<x-app-layout>
<div class="container p-10">
    <x-breadcrumbs :links="[
        ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ['url' => '', 'label' => 'Products']
    ]" />
    <h1 class="h1">Products</h1>

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    <x-datatable :headers="['ID', 'Name', 'Price', 'Stock', 'Status', 'Actions']" :items="$products" :fields="['name', 'created_at']">
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock }}</td>
                <!-- <td>{{ $product->status ? 'Active' : 'Inactive' }}</td> -->
                 <td>
                 <span class="badge
                            {{ $product->status ? 'bg-primary' : 'bg-danger' }}">
                            {{ $product->status ? 'Active' : 'Inactive' }}
                        </span>
                 </td>
                <td>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                    <x-confirm-delete-modal
                        :modal-id="'deleteModal' . $product->id"
                        :action="route('products.destroy', $product)"
                        title="Delete Product"
                        confirmText="Yes, Delete"
                    >
                        Are you sure you want to delete {{ $product->name }}?
                    </x-confirm-delete-modal>

                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                        Delete
                    </button>

                </td>
            </tr>
        @endforeach
    </x-datatable>
</div>
</x-app-layout>
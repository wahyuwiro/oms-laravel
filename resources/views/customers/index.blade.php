<x-app-layout>
    <div class="container mt-4">
        <x-breadcrumbs :links="[
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => '', 'label' => 'Customers']
        ]" />
        <h1 class="h1">Customer List</h1>
        <a href="{{ route('customers.create') }}" class="btn btn-primary my-3">Add Customer</a>

        <x-datatable :headers="['ID', 'Name', 'Price', 'Status', 'Actions']" :items="$customers" :fields="['name', 'email', 'phone']">
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>
                        <span class="badge
                            {{ $customer->status === 'active' ? 'bg-primary' : '' }}
                            {{ $customer->status === 'inactive' ? 'bg-danger' : '' }}">
                            {{ ucfirst($customer->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">Edit</a>
                        <x-confirm-delete-modal
                            :modal-id="'deleteModal' . $customer->id"
                            :action="route('customers.destroy', $customer)"
                            title="Delete Customer"
                            confirmText="Yes, Delete"
                        >
                            Are you sure you want to delete {{ $customer->name }}?
                        </x-confirm-delete-modal>

                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $customer->id }}">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </x-datatable>

    </div>
</x-app-layout>

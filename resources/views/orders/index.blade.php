<x-app-layout>
    <div class="container p-10">
        <x-breadcrumbs :links="[
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => '', 'label' => 'Orders']
        ]" />

        <h1 class="h1">Orders List</h1>
        <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">New Order</a>

        <x-datatable :headers="['Customer', 'Total', 'Status', 'Actions']" :items="$orders" :fields="['name','created_at']">
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->customer->name }}</td>
                    <td>${{ $order->total_price }}</td>
                    <td>
                        <span class="badge
                            {{ $order->status === 'new' ? 'bg-primary' : '' }}
                            {{ $order->status === 'completed' ? 'bg-success' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-danger' : '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">View Details</a>
                        <x-confirm-delete-modal
                            :modal-id="'deleteModal' . $order->id"
                            :action="route('orders.destroy', $order)"
                            title="Delete Order"
                            confirmText="Yes, Delete"
                        >
                            Are you sure you want to delete {{ $order->name }}?
                        </x-confirm-delete-modal>

                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $order->id }}">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </x-datatable>

    </div>
</x-app-layout>

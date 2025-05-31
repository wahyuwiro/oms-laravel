<x-app-layout>
    <div class="container p-10">
        <x-breadcrumbs :links="[
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('orders.index'), 'label' => 'Orders'],
            ['url' => '', 'label' => 'Order Details']
        ]"/>
        <h1 class="h1">Order Details</h1>

        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Order ID:</strong> {{ $order->id }}</p>
                <p><strong>Customer:</strong> {{ $order->customer->name }}</p>
                <p><strong>Total Price:</strong> ${{ $order->total_price }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Created At:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>

        <h3>Products</h3>
        <ul class="list-group mb-3">
            @foreach($order->products as $product)
                <li class="list-group-item">
                    {{ $product->name }} - Quantity: {{ $product->pivot->quantity }}
                </li>
            @endforeach
        </ul>

        <h3>Update Status</h3>
        <form method="POST" action="{{ route('orders.update', $order->id) }}">
            @csrf
            @method('PUT')

            <select name="status" onchange="this.form.submit()">
                @foreach (['new', 'completed', 'cancelled'] as $status)
                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
</x-app-layout>

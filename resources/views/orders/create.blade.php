<x-app-layout>
    <div class="container p-10">
        <x-breadcrumbs :links="[
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('orders.index'), 'label' => 'Orders'],
            ['url' => '', 'label' => 'Create Order']
        ]" />
        <h1 class="h1">Create Order</h1>

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf

            {{-- Customer Dropdown --}}
            <div class="mb-3">
                <label for="customer" class="form-label">Customer</label>
                <select name="customer_id" id="customer-select" class="form-select" required>
                    <option value="">Select a customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Product Selector --}}
            <div class="mb-3">
                <label for="product-select" class="form-label">Products</label>
                <select id="product-select" class="form-select" multiple>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} (${{ $product->price }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Selected Products with Quantity --}}
            <div class="mb-3" id="selected-products-container">
                {{-- JS will populate selected products and quantity inputs here --}}
            </div>

            <button type="submit" class="btn btn-success">Create Order</button>
        </form>

    </div>

    {{-- Include jQuery and Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // Init Select2
            $('#customer-select').select2({ placeholder: 'Select a customer' });
            $('#product-select').select2({ placeholder: 'Select products' });

            // Product selection event
            $('#product-select').on('change', function () {
                const selectedProducts = $(this).val();
                const container = $('#selected-products-container');
                container.html('');

                selectedProducts.forEach(productId => {
                    const option = $(`#product-select option[value="${productId}"]`);
                    const productName = option.text();
                    const productPrice = option.data('price');

                    container.append(`
                        <div class="mb-2 border p-2 rounded bg-light">
                            <label class="form-label d-block">${productName}</label>
                            <input type="hidden" name="products[${productId}][selected]" value="1">
                            <input type="number" name="products[${productId}][quantity]" class="form-control" style="width: 150px;"
                                placeholder="Quantity" min="1" required>
                        </div>
                    `);
                });
            });
        });
    </script>
</x-app-layout>

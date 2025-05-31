<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Order::query();

        $field = $request->get('field');
        if ($field === 'created_at' && $request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        } elseif ($field === 'name' && $request->filled('keyword')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%');
            });
        } elseif ($field && $request->filled('keyword')) {
            $query->where($field, 'like', '%' . $request->keyword . '%');
        }

        $orders = $query->paginate($request->get('per_page', 10))->appends($request->query());

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('status', true)->get();
        return view('orders.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array',
        ]);

        $total = 0;
        $selectedProducts = [];

        foreach ($request->products as $productId => $productData) {
            if (isset($productData['selected']) && $productData['selected']) {
                $product = Product::find($productId);
                $qty = (int) $productData['quantity'];

                if ($qty > 0) {
                    $selectedProducts[$productId] = ['quantity' => $qty];
                    $total += $product->price * $qty;
                }
            }
        }

        if (empty($selectedProducts)) {
            return back()->withErrors(['products' => 'Please select at least one product with quantity.']);
        }

        $order = Order::create([
            'customer_id' => $request->customer_id,
            'total_price' => $total,
            'status' => 'new',
        ]);

        $order->products()->attach($selectedProducts);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['customer', 'products'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:new,completed,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Order status updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        // Detach related products if using belongsToMany
        $order->products()->detach();

        // Delete the order
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}

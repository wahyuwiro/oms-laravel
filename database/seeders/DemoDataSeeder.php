<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory(50)->create();
        Product::factory(30)->create();

        // Order::factory(200)->create();
        // Create 200 orders and attach products
        // Get all products (we’ll randomly pick from this)
        $allProducts = Product::all();

        // Create 200 orders
        Order::factory(200)->create()->each(function ($order) use ($allProducts) {
            // Randomly select 1-5 products for each order
            $products = $allProducts->random(rand(1, 5));

            foreach ($products as $product) {
                $quantity = rand(1, 5);
                $order->products()->attach($product->id, [
                    'quantity' => $quantity,
                ]);
            }
        });
    }
}

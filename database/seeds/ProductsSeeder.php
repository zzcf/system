<?php

use App\Models\ProductDetail;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Product::class, 100)->create()->each(function ($product) {
            factory(ProductDetail::class, 4)->make()->each(function ($detail) use ($product) {
                $detail->product_id = $product->id;
                $detail->save();
            });
        });
    }
}

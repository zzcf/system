<?php

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'title' => '信托产品',
                'name' => 'xintuo'
            ],
            [
                'title' => '资管产品',
                'name' => 'ziguan'
            ],
            [
                'title' => '契约型产品',
                'name' => 'qiyue'
            ],
            [
                'title' => '政府债',
                'name' => 'zhengfuzhai'
            ]
        ];

        foreach ($categories as $item) {
            ProductCategory::create($item);
        }
    }
}

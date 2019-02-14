<?php

use Illuminate\Database\Seeder;

class ProductCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\ProductCompany::class, 50)->create();
    }
}

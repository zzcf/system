<?php

use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticleCategoriesSeeder extends Seeder
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
                'title' => '最新资讯'
            ],
            [
                'title' => '金融新规'
            ],
            [
                'title' => '理财知识库'
            ]
        ];

        foreach ($categories as $item) {
            ArticleCategory::create($item);
        }
    }
}

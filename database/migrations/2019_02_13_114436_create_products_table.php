<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->string('full_name')->comment('全称');
            $table->unsignedInteger('category_id')->comment('分类ID');
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->text('description')->nullable()->comment('描述');
            $table->unsignedInteger('raise')->comment('募集状态');

            $table->unsignedInteger('profit')->comment('收益范围');
            $table->decimal('profit_min_value')->comment('收益最小值，%');
            $table->decimal('profit_max_value')->nullable()->comment('收益最大值，%');
            $table->text('profit_description')->nullable()->comment('收益描述');

            $table->unsignedInteger('term')->comment('期限范围');
            $table->integer('term_min_value')->comment('期限最小值，个月');
            $table->integer('term_max_value')->nullable()->comment('期限最大值，个月');

            $table->unsignedInteger('invest_direction')->comment('投资方向');
            $table->unsignedInteger('interest_type')->comment('付息方式');
            $table->integer('min_invest')->default(100)->comment('起投金额，万');
            $table->decimal('collect_size', 8, 1)->comment('募集规模，亿');

            $table->boolean('status')->default(true)->comment('启用状态 ');
            $table->integer('order')->default(999)->comment('排序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

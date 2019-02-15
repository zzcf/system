<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id')->comment('分类ID');
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->string('name')->comment('名称');
            $table->string('simple_name')->nullable()->comment('简称');
            $table->string('english_name')->nullable()->comment('英文名称');
            $table->string('logo')->nullable()->comment('LOGO');
            $table->string('background')->nullable()->comment('股东背景');
            $table->string('capital')->nullable()->comment('注册资本，亿');
            $table->string('scale')->nullable()->comment('资产管理规模，亿');
            $table->string('create_date')->nullable()->comment('成立日期');
            $table->string('city')->nullable()->comment('所在城市');
            $table->string('chairman')->nullable()->comment('董事长');
            $table->string('top_manager')->nullable()->comment('总经理');
            $table->string('representative')->nullable()->comment('法人代表');
            $table->string('stock_holder')->nullable()->comment('大股东');
            $table->boolean('is_list')->default(true)->nullable()->comment('是否上市');
            $table->text('content')->nullable()->comment('详情介绍');

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
        Schema::dropIfExists('product_companies');
    }
}

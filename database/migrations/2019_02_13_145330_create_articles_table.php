<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id')->comment('分类ID');
            $table->foreign('category_id')->references('id')->on('article_categories')->onDelete('cascade');
            $table->string('title')->comment('标题');
            $table->string('cover')->comment('封面');
            $table->text('description')->nullable()->comment('描述');
            $table->text('content')->comment('主要内容');
            $table->timestamp('published_at')->nullable()->comment('发布时间');

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
        Schema::dropIfExists('articles');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->nullable()->comment('产品ID');
            $table->string('name')->comment('称呼');
            $table->string('phone')->comment('手机号码');
            $table->text('content')->nullable()->comment('内容');
            $table->string('source')->nullable()->comment('来源');
            $table->string('source_url')->nullable()->comment('来源网址');
            $table->string('source_ip')->nullable()->comment('来源IP');
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
        Schema::dropIfExists('feedback');
    }
}

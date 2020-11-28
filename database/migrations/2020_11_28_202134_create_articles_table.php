<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->foreignId('category_id');
            $table->date('published_at');
            $table->string('title');
            $table->string('cover')->nullable();
            $table->unsignedTinyInteger('state')->default(1)->comment('0 1');
            $table->string('description')->nullable();
            $table->smallInteger('sequence')->default(0)->nullable();
            $table->text('content');
            $table->timestamps();
            $table->index(['published_at', 'state']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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

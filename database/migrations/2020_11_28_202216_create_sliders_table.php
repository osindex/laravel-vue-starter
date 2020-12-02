<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id');
            $table->datetime('published_at')->nullable();
            $table->string('title');
            $table->string('cover')->nullable();
            $table->string('url')->nullable();
            $table->string('description')->nullable();
            $table->smallInteger('sequence')->default(0)->nullable();
            $table->unsignedTinyInteger('state')->default(1)->comment('0 1');
            $table->timestamps();
            $table->index(['published_at', 'state']);
            $table->foreign('group_id')->references('id')->on('slider_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
}

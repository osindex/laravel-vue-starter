<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->default(0);
            $table->string('name')->comment('部门名称用的name');
            $table->string('cover')->nullable();
            $table->string('description')->nullable();
            $table->smallInteger('sequence')->default(0)->nullable();
            $table->json('options')->nullable()->comment('设置');
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
        Schema::dropIfExists('depts');
    }
}

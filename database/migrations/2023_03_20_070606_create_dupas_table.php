<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dupas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcategory_id');
            $table->string('item_number');
            $table->string('description');
            $table->string('unit');
            $table->string('output_per_hour');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('subcategory_id')->references('id')->on('sow_sub_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('dupas');
    }
};

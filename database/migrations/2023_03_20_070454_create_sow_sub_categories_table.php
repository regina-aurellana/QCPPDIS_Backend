<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sow_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('item_code');
            $table->string('name');
            $table->unsignedBigInteger('sow_cat_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('sow_cat_id')->references('id')->on('sow_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sow_sub_categories');
    }
};

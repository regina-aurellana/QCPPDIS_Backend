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
        Schema::create('sub_cat_references', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sow_subcat_id');
            $table->unsignedBigInteger('parent_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('sow_subcat_id')->references('id')->on('sow_sub_categories');
            $table->foreign('parent_id')->references('id')->on('sow_sub_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_cat_references');
    }
};

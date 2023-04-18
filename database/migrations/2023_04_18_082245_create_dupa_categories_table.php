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
        Schema::create('dupa_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dupa_id');
            $table->unsignedBigInteger('nature_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('dupa_id')->references('id')->on('dupas');
            $table->foreign('nature_id')->references('id')->on('project_natures');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dupa_categories');
    }
};

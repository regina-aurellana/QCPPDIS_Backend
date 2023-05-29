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
        Schema::create('pow_table_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pow_table_id');
            $table->unsignedBigInteger('dupa_id');
            $table->string('quantity');
            $table->timestamps();

            $table->foreign('pow_table_id')->references('id')->on('pow_tables');
            $table->foreign('dupa_id')->references('id')->on('dupas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pow_table_contents');
    }
};

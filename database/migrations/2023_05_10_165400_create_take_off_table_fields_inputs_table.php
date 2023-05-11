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
        Schema::create('take_off_table_fields_inputs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('take_off_table_field_id');
            $table->string('row_no');
            $table->string('value');
            $table->timestamps();

            $table->foreign('take_off_table_field_id')->references('id')->on('take_off_table_fields');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('take_off_table_fields_inputs');
    }
};

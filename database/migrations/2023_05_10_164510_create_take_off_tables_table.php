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
        Schema::create('take_off_tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('take_off_id');
            $table->unsignedBigInteger('sow_category_id');
            $table->unsignedBigInteger('dupa_id');
            $table->unsignedBigInteger('table_row_result_field_id');
            $table->string('table_total_say')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('take_off_id')->references('id')->on('take_offs');
            $table->foreign('sow_category_id')->references('id')->on('sow_categories');
            $table->foreign('dupa_id')->references('id')->on('dupas');
            $table->foreign('table_row_result_field_id')->references('id')->on('unit_of_measurements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('take_off_tables');
    }
};

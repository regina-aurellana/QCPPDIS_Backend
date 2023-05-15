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
        Schema::create('take_offs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('b3_project_id');
            $table->string('limit');
            $table->string('length');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('b3_project_id')->references('id')->on('b3_projects');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('take_offs');
    }
};

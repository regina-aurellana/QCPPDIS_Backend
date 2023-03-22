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
        Schema::create('b3_projects', function (Blueprint $table) {
            $table->id();
            $table->string('registry_no');
            $table->string('project_title');
            $table->unsignedBigInteger('project_nature_id');
            $table->string('project_nature_type');
            $table->string('location');
            $table->string('status');
            $table->timestamps();

            $table->foreign('project_nature_id')->references('id')->on('project_natures');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b3_projects');
    }
};

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
        Schema::create('site_inspection_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('communication_id');
            $table->string('sir_no');
            $table->string('project_title');
            $table->string('project_location');
            $table->unsignedBigInteger('document_reference_id');
            $table->string('findings');
            $table->string('recommendation');

            $table->foreign('communication_id')->references('id')->on('communications');
            $table->foreign('document_reference_id')->references('id')->on('document_references');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_inspection_reports');
    }
};

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
        Schema::create('b1_project_identifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_inspection_report_id');
            $table->unsignedBigInteger('communication_id');
            $table->string('b1_id_no');
            $table->string('address');
            $table->string('requesting_party');
            $table->string('nature_id');
            $table->string('nature_type');
            $table->string('reason');
            $table->string('existing_condition');
            $table->string('estimated_beneficiary');
            $table->string('recommendation');
            $table->string('contact_no');

            $table->foreign('site_inspection_report_id')->references('id')->on('site_inspection_reports');
            $table->foreign('communication_id')->references('id')->on('communications');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b1_project_identifications');
    }
};

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
        Schema::create('communications', function (Blueprint $table) {
            $table->id();
            $table->string('comms_ref_no');
            $table->unsignedBigInteger('communication_category_id');
            $table->string('subject');
            $table->string('location');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('barangay_id');
            $table->unsignedBigInteger('routed_to_user_id');
            $table->unsignedBigInteger('routed_by_user_id');
            $table->string('status');
            $table->string('attachment');
            $table->string('remarks');
            $table->string('action_taken');

            $table->foreign('communication_category_id')->references('id')->on('communication_categories');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('barangay_id')->references('id')->on('barangays');
            $table->foreign('routed_to_user_id')->references('id')->on('users');
            $table->foreign('routed_by_user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communications');
    }
};

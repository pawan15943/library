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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->date('dob')->nullable();
            $table->string('id_proof_name')->nullable();
            $table->string('id_proof_file')->nullable();
            $table->date('join_date')->nullable();
            $table->date('plan_start_date')->nullable();
            $table->date('plan_end_date')->nullable();
            $table->foreignId('plan_price_id')->constrained();
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('plan_type_id');
            $table->unsignedBigInteger('seat_no');
            $table->int('hours')->nullable();
            $table->int('payment_mode')->nullable();
            // Define foreign keys
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->foreign('plan_type_id')->references('id')->on('plan_types')->onDelete('cascade');
            $table->foreign('seat_no')->references('id')->on('seats')->onDelete('cascade');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

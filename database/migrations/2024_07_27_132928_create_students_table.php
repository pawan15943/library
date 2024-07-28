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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile');
            $table->string('alt_mobile')->nullable();
            $table->string('email')->unique();
            $table->string('father_name');
            $table->date('dob');
            $table->enum('gender', ['male', 'female']);
            $table->unsignedBigInteger('grade_id');
            $table->string('stream')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('city_id');
            $table->text('address');
            $table->string('pin_code');
            $table->unsignedBigInteger('course_type_id');
            $table->unsignedBigInteger('course_id');
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
        Schema::dropIfExists('students');
    }
};

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
        Schema::create('historical_retireds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('authorized_id');
            $table->unsignedBigInteger('tutor_id');
            $table->string('student_name');
            $table->string('course_description');
            $table->string('authorized_name');
            $table->string('tutor_name');
            $table->date('date');
            $table->boolean('status');
            $table->boolean('presence');
            $table->boolean('leave_alone');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('authorized_id')->references('id')->on('authorizeds');
            $table->foreign('tutor_id')->references('id')->on('tutors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_retireds');
    }
};

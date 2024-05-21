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
            $table->timestamps();
            $table->string("name");
            $table->string("lastname");
            $table->string("documentnumber");
            $table->unsignedBigInteger("course_id");
            $table->foreign("course_id")->references("id")->on("courses");
            $table->unsignedBigInteger("tutor_id");
            $table->foreign("tutor_id")->references("id")->on("tutors");
            $table->unsignedBigInteger("authorized_id");
            $table->foreign("authorized_id")->references("id")->on("authorizeds");


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

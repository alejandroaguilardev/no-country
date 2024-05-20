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
            $table->unsignedBigInteger("courseid");
            $table->foreign("courseid")->references("id")->on("courses");
            $table->unsignedBigInteger("tutorid");
            $table->foreign("tutorid")->references("id")->on("tutors");
            $table->unsignedBigInteger("authorizedid");
            $table->foreign("authorizedid")->references("id")->on("authorizeds");


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

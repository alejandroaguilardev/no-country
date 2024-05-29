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
        Schema::create('authorizeds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name");
            $table->string("last_name");
            $table->string("document_number");
            $table->string("phone");
            $table->string("photo");
            $table->unsignedBigInteger("tutor_id");
            $table->foreign("tutor_id")->references("id")->on("tutors");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authorizeds');
    }
};

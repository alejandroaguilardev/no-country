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
        Schema::create('retireds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("student_id");
            $table->foreign("student_id")->references("id")->on("students");
            $table->date("date");
            $table->boolean("status");
            $table->boolean("presence");
            $table->boolean("leave_alone");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retired');
    }
};

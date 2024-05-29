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
        Schema::create('vehicle_loan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->bigInteger('stakeholder_id')->unsigned();
            $table->foreignId('vehicle_id');
            $table->enum('status', ['on_progress', 'accept', 'reject', 'done'])->default('on_progress');
            $table->string('notes')->nullable();
            $table->foreign('stakeholder_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_loan');
    }
};

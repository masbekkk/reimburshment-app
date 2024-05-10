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
        Schema::create('reimburshments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->date('date_of_submission');
            $table->string('reimburshment_name');
            $table->text('description');
            $table->string('support_file');
            $table->enum('status', ['on_progress', 'accept', 'reject'])->default('on_progress');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimburshments');
    }
};

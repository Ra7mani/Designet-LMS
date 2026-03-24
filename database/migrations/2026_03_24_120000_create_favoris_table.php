<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favoris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();

            // Ensure one favorite per user-course combination
            $table->unique(['user_id', 'cours_id']);

            // Index for efficient queries
            $table->index('user_id');
            $table->index('cours_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lecons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapitre_id')->constrained('chapitres')->onDelete('cascade');
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('video_url')->nullable();
            $table->integer('duration')->default(0);
            $table->integer('order')->default(0);
            $table->string('type')->default('video');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecons');
    }
};
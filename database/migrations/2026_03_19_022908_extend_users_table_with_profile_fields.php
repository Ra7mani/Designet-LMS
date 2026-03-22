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
        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('role');
            $table->string('phone', 20)->nullable()->after('bio');
            $table->string('location', 255)->nullable()->after('phone');
            $table->string('professional_objective', 255)->nullable()->after('location');
            $table->string('linkedin_url', 500)->nullable()->after('professional_objective');
            $table->string('github_url', 500)->nullable()->after('linkedin_url');
            $table->string('portfolio_url', 500)->nullable()->after('github_url');
            $table->string('avatar_path', 255)->nullable()->after('portfolio_url');
            $table->json('skills_json')->nullable()->after('avatar_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bio',
                'phone',
                'location',
                'professional_objective',
                'linkedin_url',
                'github_url',
                'portfolio_url',
                'avatar_path',
                'skills_json',
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forum_messages', function (Blueprint $table) {
            $table->boolean('is_pinned')->default(false)->after('is_read');
            $table->boolean('is_solution')->default(false)->after('is_pinned');
            $table->boolean('is_hidden')->default(false)->after('is_solution');
            $table->foreignId('pinned_by')->nullable()->after('is_hidden')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('forum_messages', function (Blueprint $table) {
            $table->dropColumn(['is_pinned', 'is_solution', 'is_hidden', 'pinned_by']);
        });
    }
};

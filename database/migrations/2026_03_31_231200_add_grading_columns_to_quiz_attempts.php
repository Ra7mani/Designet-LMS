<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            if (! Schema::hasColumn('quiz_attempts', 'is_graded')) {
                $table->boolean('is_graded')->default(false)->after('status');
            }
            if (! Schema::hasColumn('quiz_attempts', 'grader_comment')) {
                $table->text('grader_comment')->nullable()->after('is_graded');
            }
            if (! Schema::hasColumn('quiz_attempts', 'graded_at')) {
                $table->timestamp('graded_at')->nullable()->after('grader_comment');
            }
        });
    }

    public function down(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            if (Schema::hasColumn('quiz_attempts', 'graded_at')) {
                $table->dropColumn('graded_at');
            }
            if (Schema::hasColumn('quiz_attempts', 'grader_comment')) {
                $table->dropColumn('grader_comment');
            }
            if (Schema::hasColumn('quiz_attempts', 'is_graded')) {
                $table->dropColumn('is_graded');
            }
        });
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            if (! Schema::hasColumn('quizzes', 'is_published')) {
                $table->boolean('is_published')->default(false)->after('type');
            }

            if (! Schema::hasColumn('quizzes', 'random_order')) {
                $table->boolean('random_order')->default(false)->after('is_published');
            }

            if (! Schema::hasColumn('quizzes', 'available_from')) {
                $table->timestamp('available_from')->nullable()->after('random_order');
            }

            if (! Schema::hasColumn('quizzes', 'available_until')) {
                $table->timestamp('available_until')->nullable()->after('available_from');
            }
        });

        Schema::table('questions', function (Blueprint $table) {
            if (! Schema::hasColumn('questions', 'question_type')) {
                $table->string('question_type')->default('qcm')->after('content');
            }
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            if (Schema::hasColumn('questions', 'question_type')) {
                $table->dropColumn('question_type');
            }
        });

        Schema::table('quizzes', function (Blueprint $table) {
            if (Schema::hasColumn('quizzes', 'available_until')) {
                $table->dropColumn('available_until');
            }

            if (Schema::hasColumn('quizzes', 'available_from')) {
                $table->dropColumn('available_from');
            }

            if (Schema::hasColumn('quizzes', 'random_order')) {
                $table->dropColumn('random_order');
            }

            if (Schema::hasColumn('quizzes', 'is_published')) {
                $table->dropColumn('is_published');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lecons', function (Blueprint $table) {
            if (! Schema::hasColumn('lecons', 'resource_path')) {
                $table->string('resource_path')->nullable()->after('video_url');
            }
            if (! Schema::hasColumn('lecons', 'resource_name')) {
                $table->string('resource_name')->nullable()->after('resource_path');
            }
        });

        Schema::table('quizzes', function (Blueprint $table) {
            if (! Schema::hasColumn('quizzes', 'chapitre_id')) {
                $table->foreignId('chapitre_id')->nullable()->after('cours_id')->constrained('chapitres')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            if (Schema::hasColumn('quizzes', 'chapitre_id')) {
                $table->dropConstrainedForeignId('chapitre_id');
            }
        });

        Schema::table('lecons', function (Blueprint $table) {
            if (Schema::hasColumn('lecons', 'resource_name')) {
                $table->dropColumn('resource_name');
            }
            if (Schema::hasColumn('lecons', 'resource_path')) {
                $table->dropColumn('resource_path');
            }
        });
    }
};

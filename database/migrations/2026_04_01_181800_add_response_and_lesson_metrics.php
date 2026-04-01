<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('avis', function (Blueprint $table) {
            $table->text('formateur_response')->nullable()->after('comment');
            $table->timestamp('response_date')->nullable()->after('formateur_response');
            $table->foreignId('response_by')->nullable()->after('response_date')->constrained('users')->nullOnDelete();
        });

        Schema::table('lecons', function (Blueprint $table) {
            $table->unsignedInteger('view_count')->default(0)->after('type');
            $table->unsignedInteger('abandon_count')->default(0)->after('view_count');
        });
    }

    public function down(): void
    {
        Schema::table('lecons', function (Blueprint $table) {
            $table->dropColumn(['view_count', 'abandon_count']);
        });

        Schema::table('avis', function (Blueprint $table) {
            $table->dropConstrainedForeignId('response_by');
            $table->dropColumn(['formateur_response', 'response_date']);
        });
    }
};

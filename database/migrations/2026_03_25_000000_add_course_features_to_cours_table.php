<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cours', function (Blueprint $table) {
            $table->boolean('certificating')->default(true)->after('rating');
            $table->boolean('discussion_forum')->default(true)->after('certificating');
            $table->string('promo_code')->nullable()->after('discussion_forum');
            $table->string('language')->default('fr')->after('promo_code');
        });
    }

    public function down(): void
    {
        Schema::table('cours', function (Blueprint $table) {
            $table->dropColumn(['certificating', 'discussion_forum', 'promo_code', 'language']);
        });
    }
};

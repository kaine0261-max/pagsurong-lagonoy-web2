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
        Schema::table('business_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('business_profiles', 'facebook_page')) {
                $table->string('facebook_page')->nullable();
            }
            if (!Schema::hasColumn('business_profiles', 'instagram_url')) {
                $table->string('instagram_url')->nullable();
            }
            if (!Schema::hasColumn('business_profiles', 'twitter_url')) {
                $table->string('twitter_url')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_profiles', function (Blueprint $table) {
            $table->dropColumn(['instagram_url', 'twitter_url']);
        });
    }
};

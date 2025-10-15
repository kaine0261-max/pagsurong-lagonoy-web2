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
        Schema::table('hotel_rooms', function (Blueprint $table) {
            // SAFE APPROACH: Only add what's missing, don't drop anything
            
            // If business_id doesn't exist, add it as nullable first
            if (!Schema::hasColumn('hotel_rooms', 'business_id')) {
                $table->unsignedBigInteger('business_id')->nullable()->after('id');
                $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            }
            
            // If hotel_id exists, make it nullable so inserts don't fail
            if (Schema::hasColumn('hotel_rooms', 'hotel_id')) {
                $table->unsignedBigInteger('hotel_id')->nullable()->change();
            }
            
            // Ensure image column exists and is nullable
            if (!Schema::hasColumn('hotel_rooms', 'image')) {
                $table->string('image')->nullable()->after('amenities');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotel_rooms', function (Blueprint $table) {
            // Only remove what we added (safe rollback)
            if (Schema::hasColumn('hotel_rooms', 'business_id')) {
                $table->dropForeign(['business_id']);
                $table->dropColumn('business_id');
            }
            
            // Note: We don't reverse the hotel_id nullable change to avoid breaking existing data
        });
    }
};

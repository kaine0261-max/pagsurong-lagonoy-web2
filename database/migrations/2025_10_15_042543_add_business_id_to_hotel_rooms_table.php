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
            // Add business_id column if it doesn't exist
            if (!Schema::hasColumn('hotel_rooms', 'business_id')) {
                $table->foreignId('business_id')->after('id')->constrained('businesses')->onDelete('cascade');
            }
            
            // Add image column if it doesn't exist
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
            // Drop the columns if they exist
            if (Schema::hasColumn('hotel_rooms', 'business_id')) {
                $table->dropForeign(['business_id']);
                $table->dropColumn('business_id');
            }
            
            if (Schema::hasColumn('hotel_rooms', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};

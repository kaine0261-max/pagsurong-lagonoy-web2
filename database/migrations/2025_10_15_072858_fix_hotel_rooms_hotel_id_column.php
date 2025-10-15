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
            // Check if hotel_id exists and business_id doesn't exist
            if (Schema::hasColumn('hotel_rooms', 'hotel_id') && !Schema::hasColumn('hotel_rooms', 'business_id')) {
                // Rename hotel_id to business_id
                $table->renameColumn('hotel_id', 'business_id');
            }
            
            // If hotel_id exists but business_id also exists, drop hotel_id
            if (Schema::hasColumn('hotel_rooms', 'hotel_id') && Schema::hasColumn('hotel_rooms', 'business_id')) {
                // Drop foreign key constraint first
                try {
                    $table->dropForeign(['hotel_id']);
                } catch (Exception $e) {
                    // Foreign key might not exist or have different name
                }
                $table->dropColumn('hotel_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotel_rooms', function (Blueprint $table) {
            // Reverse the changes if needed
            if (Schema::hasColumn('hotel_rooms', 'business_id')) {
                $table->renameColumn('business_id', 'hotel_id');
            }
        });
    }
};

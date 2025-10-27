<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('business_profiles', function (Blueprint $table) {
            // Change business_permit_path from string to JSON to support multiple files
            $table->json('business_permit_path')->nullable()->change();
        });

        // Convert existing single file paths to JSON array format
        DB::table('business_profiles')
            ->whereNotNull('business_permit_path')
            ->where('business_permit_path', '!=', '')
            ->get()
            ->each(function ($profile) {
                // Check if it's already JSON
                $decoded = json_decode($profile->business_permit_path, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return; // Already JSON, skip
                }
                
                // Convert single path to array
                DB::table('business_profiles')
                    ->where('id', $profile->id)
                    ->update([
                        'business_permit_path' => json_encode([$profile->business_permit_path])
                    ]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert JSON arrays back to single string (take first element)
        DB::table('business_profiles')
            ->whereNotNull('business_permit_path')
            ->get()
            ->each(function ($profile) {
                $decoded = json_decode($profile->business_permit_path, true);
                if (is_array($decoded) && !empty($decoded)) {
                    DB::table('business_profiles')
                        ->where('id', $profile->id)
                        ->update([
                            'business_permit_path' => $decoded[0]
                        ]);
                }
            });

        Schema::table('business_profiles', function (Blueprint $table) {
            $table->string('business_permit_path')->nullable()->change();
        });
    }
};

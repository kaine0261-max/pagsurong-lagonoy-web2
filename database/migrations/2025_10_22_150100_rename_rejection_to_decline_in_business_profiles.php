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
            // Rename rejection_reason to decline_reason
            $table->renameColumn('rejection_reason', 'decline_reason');
        });

        // Update existing 'rejected' status to 'declined'
        DB::table('business_profiles')
            ->where('status', 'rejected')
            ->update(['status' => 'declined']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update 'declined' status back to 'rejected'
        DB::table('business_profiles')
            ->where('status', 'declined')
            ->update(['status' => 'rejected']);

        Schema::table('business_profiles', function (Blueprint $table) {
            // Rename decline_reason back to rejection_reason
            $table->renameColumn('decline_reason', 'rejection_reason');
        });
    }
};

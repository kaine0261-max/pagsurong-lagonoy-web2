<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateBusinessProfilesSocialMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:add-social-media-columns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add social media columns to business_profiles table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Adding social media columns to business_profiles table...');

        try {
            // Check if columns already exist
            $hasColumns = Schema::hasColumns('business_profiles', [
                'facebook_page',
                'instagram_url',
                'twitter_url'
            ]);

            if ($hasColumns) {
                $this->warn('Social media columns already exist in business_profiles table!');
                return Command::SUCCESS;
            }

            // Add the columns using raw SQL
            DB::statement('ALTER TABLE business_profiles ADD COLUMN IF NOT EXISTS facebook_page VARCHAR(255) NULL');
            DB::statement('ALTER TABLE business_profiles ADD COLUMN IF NOT EXISTS instagram_url VARCHAR(255) NULL');
            DB::statement('ALTER TABLE business_profiles ADD COLUMN IF NOT EXISTS twitter_url VARCHAR(255) NULL');

            $this->info('✓ facebook_page column added');
            $this->info('✓ instagram_url column added');
            $this->info('✓ twitter_url column added');
            
            $this->newLine();
            $this->info('✅ Social media columns added successfully!');
            
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Error adding columns: ' . $e->getMessage());
            $this->newLine();
            $this->warn('Trying alternative method...');
            
            try {
                // Alternative method without IF NOT EXISTS
                if (!Schema::hasColumn('business_profiles', 'facebook_page')) {
                    DB::statement('ALTER TABLE business_profiles ADD COLUMN facebook_page VARCHAR(255) NULL');
                    $this->info('✓ facebook_page column added');
                }
                
                if (!Schema::hasColumn('business_profiles', 'instagram_url')) {
                    DB::statement('ALTER TABLE business_profiles ADD COLUMN instagram_url VARCHAR(255) NULL');
                    $this->info('✓ instagram_url column added');
                }
                
                if (!Schema::hasColumn('business_profiles', 'twitter_url')) {
                    DB::statement('ALTER TABLE business_profiles ADD COLUMN twitter_url VARCHAR(255) NULL');
                    $this->info('✓ twitter_url column added');
                }
                
                $this->newLine();
                $this->info('✅ Social media columns added successfully!');
                
                return Command::SUCCESS;
                
            } catch (\Exception $e2) {
                $this->error('❌ Failed to add columns: ' . $e2->getMessage());
                return Command::FAILURE;
            }
        }
    }
}

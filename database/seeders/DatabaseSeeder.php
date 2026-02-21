<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            // Local seeders (commented out to prioritize new Proxmox structure)
            // NodeSeeder::class,
            // StorageHealthSeeder::class,
            // VirtualMachineSeeder::class,
            // NextcloudSeeder::class,
            // SystemAlertSeeder::class,
            
            // New Seeders for Database Integration
            ProxmoxSeeder::class,
            CredentialSeeder::class,
        ]);

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\Credential;


class CredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // Credentials for 10.13.15.52
        Credential::create([
            'server_ip' => '10.13.15.52',
            'name' => 'Admin System',
            'username' => 'admin_sys',
            'email' => 'admin@persero.com',
            'password' => bcrypt('password123'),
        ]);

        Credential::create([
            'server_ip' => '10.13.15.52',
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@persero.com',
            'password' => bcrypt('password123'),
        ]);

        Credential::create([
            'server_ip' => '10.13.15.52',
            'name' => 'Jane Smith',
            'username' => 'janesmith',
            'email' => 'jane@persero.com',
            'password' => bcrypt('password123'),
        ]);

        // Credentials for 10.13.15.53 (Subset)
        Credential::create([
            'server_ip' => '10.13.15.53',
            'name' => 'Admin System',
            'username' => 'admin_sys',
            'email' => 'admin@persero.com',
            'password' => bcrypt('password123'),
        ]);

        Credential::create([
            'server_ip' => '10.13.15.53',
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@persero.com',
            'password' => bcrypt('password123'),
        ]);

        // Credentials for 10.13.15.54 (Subset)
        Credential::create([
            'server_ip' => '10.13.15.54',
            'name' => 'Admin System',
            'username' => 'admin_sys',
            'email' => 'admin@persero.com',
            'password' => bcrypt('password123'),
        ]);
        
        Credential::create([
            'server_ip' => '10.13.15.54',
            'name' => 'Jane Smith',
            'username' => 'janesmith',
            'email' => 'jane@persero.com',
            'password' => bcrypt('password123'),
        ]);
    }

}

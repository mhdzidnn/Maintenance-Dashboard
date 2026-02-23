<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sites = [
            ['nama' => 'AGS', 'key' => 'ags', 'ip' => '10.13.15.10', 'desc' => 'Kantor cabang AGS, berisi VM operasional utama'],
            ['nama' => 'Kantor Pusat', 'key' => 'pusat', 'ip' => '10.13.15.20', 'desc' => 'Server pusat dengan beban tinggi, 4 VM aktif'],
            ['nama' => 'Punggur', 'key' => 'punggur', 'ip' => '10.13.15.30', 'desc' => 'Site Punggur, sebagian VM sedang tidak aktif'],
            ['nama' => 'Sekupang', 'key' => 'sekupang', 'ip' => '10.13.15.40', 'desc' => 'Site Sekupang, kondisi normal dan seimbang'],
        ];

        foreach ($sites as $s) {
            $site = \App\Models\Site::create([
                'name' => $s['nama'],
                'key' => $s['key'],
                'ip_node' => $s['ip'],
                'description' => $s['desc'],
            ]);

            $site->thresholdAlert()->create([
                'cpu_limit' => 80,
                'mem_limit' => 80,
                'disk_limit' => 80,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ap_user')->insertOrIgnore([
            [
                'username'   => 'admin_pdc',
                'email'      => 'admin@pdcproduction.com',
                'password'   => Hash::make('admin123'),
                'role'       => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'   => 'editor_pdc',
                'email'      => 'editor@pdcproduction.com',
                'password'   => Hash::make('editor123'),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

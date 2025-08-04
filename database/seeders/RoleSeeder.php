<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // This should run only once on startup
        if (DB::table('roles')->count() > 0) {
            return;
        }
        DB::table('roles')->insert([
            'name' => 'super_admin',
            'display_name' => 'Super Admin',
        ]);
        DB::table('roles')->insert([
            'name' => 'admin',
            'display_name' => 'Administrator',
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // This should run only once on startup
        if (DB::table('admins')->count() > 0) {
            return;
        }

        DB::table('admins')->insert([
            [
                'name' => 'Hussein Al Mawla',
                'username' => 'hmawla',
                'password' => bcrypt('secretpass'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mohammad Dekmak',
                'username' => 'mdekmak',
                'password' => bcrypt('secretpass'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        $superAdminRoleId = DB::table('roles')->where('name', 'super_admin')->first()->id;

        DB::table('admin_role')->insert([
            ['admin_id' => 1, 'role_id' => $superAdminRoleId, 'created_at' => now(), 'updated_at' => now()],
            ['admin_id' => 2, 'role_id' => $superAdminRoleId, 'created_at' => now(), 'updated_at' => now()],
        ]);

    }
}

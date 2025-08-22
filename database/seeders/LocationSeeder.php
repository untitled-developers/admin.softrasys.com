<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'SOFTRASYS S.A.L.',
                'sort_number' => 1,
                'address' => 'Citymall Elevator Home & Deco Sea Side, Level 214 Dora Highway, Bauchrieh, Beirut, Lebanon',
                'email' => 'info@softrasys.com',
                'phone_number' => '+961 (01) 90 55 33',
                'fax_number' => '+961 (01) 90 55 33',
                'support_number' => '+961 (71) 200 448',
                'longitude' => 35.5731000000000000,
                'latitude' => 33.9216000000000000,
                'location_link' => 'https://maps.app.goo.gl/z6JuZe2QuYQf4Vc67',
                'is_hidden' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MASARI AL SAHIH / Syria Branch',
                'sort_number' => 2,
                'address' => 'Damascus, Syria',
                'email' => 'info@masari.net',
                'phone_number' => '+963 (933) 216950',
                'fax_number' => null,
                'support_number' => null,
                'longitude' => 36.2911000000000000,
                'latitude' => 33.5138000000000000,
                'location_link' => null,
                'is_hidden' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TRACAY S.A.R.L. / French Guiana Branch',
                'sort_number' => 3,
                'address' => '5850 route des plages, 97354 Rémire-Montjoly, French Guiana',
                'email' => 'info@tracay.com',
                'phone_number' => '+594 (694) 210320',
                'fax_number' => null,
                'support_number' => null,
                'longitude' => -52.2542000000000000,
                'latitude' => 4.9167000000000000,
                'location_link' => 'https://maps.app.goo.gl/jECskzj3TUiLzQ1f9',
                'is_hidden' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Karam Electronics / Agent',
                'sort_number' => 4,
                'address' => 'Mansourieh - Zip code: 22411, Beirut - Lebanon',
                'email' => 'info@karamelectronics.com',
                'phone_number' => '+961 (04) 40 06 84',
                'fax_number' => null,
                'support_number' => null,
                'longitude' => 35.5731000000000000,
                'latitude' => 33.8547000000000000,
                'location_link' => null,
                'is_hidden' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('locations')->insert($locations);
    }
}

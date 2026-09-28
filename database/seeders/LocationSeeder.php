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
                'longitude' => 35.5692672604137,
                'latitude' =>  33.89086620166421,
                'location_link' => 'https://maps.app.goo.gl/z6JuZe2QuYQf4Vc67',
            ],
            [
                'name' => 'MASARI AL SAHIH / Syria Branch',
                'sort_number' => 2,
                'address' => 'Damascus, Syria',
                'email' => 'info@masari.net',
                'phone_number' => '+963 (933) 216950',
                'fax_number' => null,
                'support_number' => null,
                'longitude' => 36.27315447239067,
                'latitude' =>  33.51168970004839,
                'location_link' => 'https://maps.app.goo.gl/G64UgM6wGFioQL1GA',
            ],
            [
                'name' => 'TRACAY S.A.R.L. / French Guiana Branch',
                'sort_number' => 3,
                'address' => '5850 route des plages, 97354 Rémire-Montjoly, French Guiana',
                'email' => 'info@tracay.com',
                'phone_number' => '+594 (694) 210320',
                'fax_number' => null,
                'support_number' => null,
                'longitude' => -52.245299430684206,
                'latitude' => 4.880261984036498,
                'location_link' => 'https://maps.app.goo.gl/jECskzj3TUiLzQ1f9',
            ],
            [
                'name' => 'Karam Electronics / Agent',
                'sort_number' => 4,
                'address' => 'Mansourieh - Zip code: 22411, Beirut - Lebanon',
                'email' => 'info@karamelectronics.com',
                'phone_number' => '+961 (04) 40 06 84',
                'fax_number' => null,
                'support_number' => null,
                'longitude' => 35.56817625846338,
                'latitude' => 33.85853740200712,
                'location_link' => 'https://maps.app.goo.gl/hZSZX6zJXWFyi2YR7',
            ],
        ];

        foreach ($locations as $location) {
            $locationId = DB::table('locations')->insertGetId([
                'sort_number' => $location['sort_number'],
                'email' => $location['email'],
                'phone_number' => $location['phone_number'],
                'fax_number' => $location['fax_number'],
                'support_number' => $location['support_number'],
                'longitude' => $location['longitude'],
                'latitude' => $location['latitude'],
                'location_link' => $location['location_link'],
                'is_hidden' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ([1, 2, 3] as $langId) {
                DB::table('location_languages')->insert([
                    'location_id' => $locationId,
                    'language_id' => $langId,
                    'name' => $location['name'],
                    'address' => $location['address'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccessorySeeder extends Seeder
{
    use BlobHelper;

    public function run(): void
    {
        $accessories = [
            [
                'name' => 'Tracking Devices',
                'short_description' => 'Monitor your fleet in real time with precise location tracking and access detailed route history, ensuring complete visibility and operational control.',
                'long_description' => '
                 <h2 class="py-2 font-bold text-[#7a37b3]">
                   Advanced GPS Tracking Solutions:
                    </h2>
                    <ul class="list-disc pl-5 space-y-4 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Real-Time Location Tracking: </span> Precision monitoring with multiple satellite support.</li>
                        <li><span class="text-[#7a37b3] font-medium">Historical Playback: </span> Complete journey recording with detailed timestamps.</li>
                        <li><span class="text-[#7a37b3] font-medium">Rugged Design: </span> Weatherproof and tamper-resistant construction.</li>
                        <li><span class="text-[#7a37b3] font-medium">Long Battery Life: </span> Extended operation with efficient power management.</li>
                        <li><span class="text-[#7a37b3] font-medium">Easy Installation: </span> Quick deployment with minimal vehicle downtime.</li>
                    </ul>
                ',
                'btn_text' => 'Learn More',
                'btn_href' => '/accessories/tracking-devices',
                'meta_description' => 'Get real-time GPS tracking and detailed route history for complete fleet visibility and control.',
                'sort_number' => 1,
                'image_url' => '/assets/accessories/img_1.png',

            ],
            [
                'name' => 'Monitoring Sensors',
                'short_description' => 'Upgrade your fleet with cutting-edge monitoring sensors designed for precision, safety, and real-time insights. From fuel and temperature tracking to diagnostics and occupancy detection, our smart accessories deliver greater control, enhanced visibility, and robust protection.',
                'long_description' =>
                    '
                     <h2 class="py-2 font-bold text-[#7a37b3]">
                  Comprehensive Sensor Ecosystem:
                    </h2>
                    <ul class="list-disc pl-5 space-y-4 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Fuel Level Sensors: </span> Precise fuel monitoring with theft detection capabilities.</li>
                        <li><span class="text-[#7a37b3] font-medium">Temperature Sensors: </span> Accurate environmental monitoring for sensitive cargo.</li>
                        <li><span class="text-[#7a37b3] font-medium">OBD Integration: </span>  Direct vehicle diagnostics and health monitoring.</li>
                        <li><span class="text-[#7a37b3] font-medium">Occupancy Sensors: </span> Passenger and driver presence detection.</li>
                        <li><span class="text-[#7a37b3] font-medium">Specialized Sensors: </span> Custom solutions for unique monitoring requirements.</li>
                    </ul>',
                'btn_text' => 'Learn More',
                'btn_href' => '/accessories/monitoring-sensors',
                'meta_description' => 'Monitor fleet performance with Fuel, Temperature, OBD, and Seat sensors. Gain real-time insights, prevent losses, ensure safety, cut costs, and boost efficiency.',
                'sort_number' => 2,
                'image_url' => '/assets/accessories/img_2.png',

            ],
            [
                'name' => 'Security Solutions',
                'short_description' => 'Strengthen your fleet with advanced security accessories designed for control, protection, and peace of mind. From RFID and iButton systems for secure access to panic buttons, door sensors, and immobilizers, our smart tools help safeguard drivers, vehicles, and cargo in real time.',
                'long_description' =>
                    '
                    <h2 class="py-2 font-bold text-[#7a37b3]">
                    Multi-Layered Security Architecture:
                    </h2>
                    <ul class="list-disc pl-5 space-y-4 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Access Control: </span> RFID and biometric driver identification systems.</li>
                        <li><span class="text-[#7a37b3] font-medium">Emergency Alert Feature: </span> Panic buttons with immediate alert capabilities.</li>
                        <li><span class="text-[#7a37b3] font-medium">Perimeter Security: </span> Door and entry point monitoring.</li>
                        <li><span class="text-[#7a37b3] font-medium">Immobilization Systems:</span> Remote vehicle disablement features.</li>
                        <li><span class="text-[#7a37b3] font-medium">Theft Prevention: </span> Comprehensive anti-theft measures and recovery systems.</li>
                    </ul>',
                'btn_text' => 'Learn More',
                'btn_href' => '/accessories/security-solutions',
                'meta_description' => 'Protect your fleet with RFID/iButton access, panic alerts, door sensors, and remote immobilizers with geofencing.',
                'sort_number' => 3,
                'image_url' => '/assets/accessories/img_2.png',

            ],

        ];

        foreach ($accessories as $accessory) {
            $blobId = self::createBlob('Accessory', $accessory['image_url'])->id;

            // Insert into main table
            $accessoryId = DB::table('accessories')->insertGetId([
                'slug'        => Str::slug($accessory['name']),
                'btn_href'    => $accessory['btn_href'],
                'is_hidden'   => 0,
                'sort_number' => $accessory['sort_number'],
                'blob_id' => $blobId,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // Insert translations (assuming 3 languages: English=1, French=2, Arabic=3)
            foreach ([1, 2, 3] as $langId) {
                DB::table('accessory_languages')->insert([
                    'accessory_id'     => $accessoryId,
                    'language_id'      => $langId,
                    'name'             => $accessory['name'],
                    'short_description'=> $accessory['short_description'],
                    'long_description' => $accessory['long_description'],
                    'btn_text'         => $accessory['btn_text'],
                    'meta_description' => $accessory['meta_description'],
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }
    }
}

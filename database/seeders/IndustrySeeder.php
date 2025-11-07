<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IndustrySeeder extends Seeder
{
    use BlobHelper;

    public function run(): void
    {
        $industries = [
            [
                'name' => 'Logistics and Supply Chain',
                'short_description' => '
                        <p>
                        Our solutions address the unique challenges of logistics operations with real-time visibility, route optimization, and cargo monitoring. We help ensure timely deliveries while reducing operational costs and improving customer satisfaction.
                        </p>',
                'long_description' => '
                    <h2 class="font-bold text-[#7a37b3] ">
                    Optimizing Global Supply Chains:
                    </h2>
                    <p>
                    Our solutions address the unique challenges of logistics operations with real-time visibility, route optimization, and cargo monitoring. We help ensure timely deliveries while reducing operational costs and improving customer satisfaction.
                    </p>
                    <h2 class="font-medium text-[#7a37b3]">
                    Recommended Device Package:
                    </h2>
                    <ul class="list-disc pl-5 space-y-4 text-body  marker:text-[#7a37b3]">
                        <li>Advanced GPS tracking with real-time updates.</li>
                        <li>Temperature monitoring for sensitive goods.</li>
                        <li>Fuel management systems for cost control.</li>
                        <li>Security solutions for cargo protection.</li>
                        <li>Driver behavior monitoring for safety compliance.</li>
                    </ul>
                ',
                'btn_text' => 'Learn More',
                'btn_href' => '/industries/logistics-and-supply-chain',
                'meta_description' => 'Our solutions address the unique challenges of logistics operations with real-time visibility, route optimization, and cargo monitoring. We help ensure timely deliveries while reducing operational costs and improving customer satisfaction.',
                'sort_number' => 1,
                'image_url' => '/assets/industries/img_1.png',

            ],
            [
                'name' => 'Fleet and Vehicle Rentals',
                'short_description' => '
                   <p>
                   Transform your rental business with our comprehensive management platform designed specifically for car rentals, public transportation, and tourism sectors. SOFTRASYS™ delivers cutting-edge technology that streamlines reservations, optimizes vehicle utilization, and elevates customer experiences through seamless digital solutions. Our integrated approach ensures efficient fleet management, secure vehicle access, and enhanced passenger safety throughout every rental journey.
                   </p>',
                'long_description' =>
                    '
                     <h2 class="font-bold text-[#7a37b3]">
                  Enhancing Rental Operations with Advanced Fleet Management Solutions:
                    </h2>
                    <p>
                    Enhancing Rental Operations with Advanced Fleet Management Solutions: Transform your rental business with our comprehensive management platform designed specifically for car rentals, public transportation, and tourism sectors. SOFTRASYS™ delivers cutting-edge technology that streamlines reservations, optimizes vehicle utilization, and elevates customer experiences through seamless digital solutions. Our integrated approach ensures efficient fleet management, secure vehicle access, and enhanced passenger safety throughout every rental journey.
                    </p>
                     <h2 class="font-medium text-[#7a37b3]">
                        Comprehensive Solution Features:
                    </h2>
                     <ul class="list-disc pl-5 space-y-4 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Digital Reservation Management:</span> Streamlined online booking system with real-time availability updates and automated confirmation processing.</li>
                        <li><span class="text-[#7a37b3] font-medium">Vehicle Condition Monitoring: </span> Advanced diagnostics and condition reporting with pre- and post-rental inspection documentation.</li>
                        <li><span class="text-[#7a37b3] font-medium">Smart Access Systems:</span> Keyless entry and ignition technology with secure digital authorization protocols.</li>
                        <li><span class="text-[#7a37b3] font-medium">Usage-Based Analytics:</span> Detailed usage reporting with mileage tracking, time utilization, and behavior monitoring.</li>
                        <li><span class="text-[#7a37b3] font-medium">Maintenance Coordination:</span> Automated service scheduling based on actual usage patterns and manufacturer recommendations.</li>
                        <li><span class="text-[#7a37b3] font-medium">Geofencing Security: </span> Virtual perimeter management with instant alerts for unauthorized zone entries or exits.</li>
                        <li><span class="text-[#7a37b3] font-medium">Remote Immobilization: </span> Capability to disable vehicles remotely in case of theft or unauthorized use.</li>
                    </ul>
                    ',
                'btn_text' => 'Learn More',
                'btn_href' => '/industries/fleet-and-vehicle-rentals',
                'meta_description' => 'Enhancing Rental Operations with Advanced Fleet Management Solutions.',
                'sort_number' => 2,
                'image_url' => '/assets/industries/img_2.png',

            ],
            [
                'name' => 'Industrial and Field Operations',
                'short_description' => '
                    <p>
                    Our ruggedized solutions withstand challenging conditions while providing critical operational data for industries like construction, mining, and field services.
                    </p>',
                'long_description' => '
                     <h2 class="font-bold text-[#7a37b3]">
                     Supporting Demanding Environments:
                     </h2>
                    <p>
                    Our ruggedized solutions withstand challenging conditions while providing critical operational data for industries like construction, mining, and field services.
                    </p>
                    <h2 class="font-medium text-[#7a37b3]">
                    Specialized Capabilities:
                    </h2>
                    <ul class="list-disc pl-5 space-y-4 text-body marker:text-[#7a37b3]">
                        <li>Heavy equipment monitoring and management.</li>
                        <li>Remote location tracking with satellite backup.</li>
                        <li>Environmental condition monitoring.</li>
                        <li>Safety compliance enforcement.</li>
                        <li>Resource utilization optimization.</li>
                    </ul>',
                'btn_text' => 'Learn More',
                'btn_href' => '/industries/industrial-and-field-operations',
                'meta_description' => 'Our ruggedized solutions withstand challenging conditions while providing critical operational data for industries like construction, mining, and field services.',
                'sort_number' => 2,
                'image_url' => '/assets/industries/img_4.png',

            ],
            [
                'name' => 'Public and Emergency Services',
                'short_description' => '
                                      <p>
                                      Support your mission-critical operations with reliable tracking and management solutions designed for public safety and emergency response requirements.
                                      </p>',
                'long_description' => '
                    <h2 class="font-bold text-[#7a37b3]">
                        Enabling Critical Operations:
                     </h2>
                    <p>
                    Support your mission-critical operations with reliable tracking and management solutions designed for public safety and emergency response requirements.
                    </p>
                    <h2 class="font-medium text-[#7a37b3]">
                   Public Service Features:
                    </h2>
                    <ul class="list-disc pl-5 space-y-4 text-body marker:text-[#7a37b3]">
                        <li>Priority response capabilities.</li>
                        <li>Secure communications and data handling.</li>
                        <li>Compliance with government standards.</li>
                        <li>Integration with emergency systems.</li>
                        <li>High-reliability operation guarantees.</li>
                    </ul>',
                'btn_text' => 'Learn More',
                'btn_href' => '/industries/public-and-emergency-services',
                'meta_description' => 'Support your mission-critical operations with reliable tracking and management solutions designed for public safety and emergency response requirements.',
                'sort_number' => 4,
                'image_url' => '/assets/industries/emergency-services.webp',

            ],

        ];

        foreach ($industries as $industry) {
            $blobId = self::createBlob('Industry', $industry['image_url'])->id;

            // Insert into main table
            $industryId = DB::table('industries')->insertGetId([
                'slug'        => Str::slug($industry['name']),
                'btn_href'    => $industry['btn_href'],
                'is_hidden'   => 0,
                'sort_number' => $industry['sort_number'],
                'blob_id' => $blobId,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // Insert translations (assuming 3 languages: English=1, French=2, Arabic=3)
            foreach ([1, 2, 3] as $langId) {
                DB::table('industry_languages')->insert([
                    'industry_id'     => $industryId,
                    'language_id'      => $langId,
                    'name'             => $industry['name'],
                    'short_description'=> $industry['short_description'],
                    'long_description' => $industry['long_description'],
                    'btn_text'         => $industry['btn_text'],
                    'meta_description' => $industry['meta_description'],
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }
    }
}

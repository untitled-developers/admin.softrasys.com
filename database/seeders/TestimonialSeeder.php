<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Africell',
                'description' => 'I am writing to express my gratitude and satisfaction with your tracking system services. As a customer who heavily relies on GPS technology for our business, we have had experience with various tracking systems in the past. However, none have come close to the level of service and quality that SOFTRASYS S.A.L provides.',
                'is_hidden' => 0,
                'sort_number' => 1,
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'name' => 'Halal',
                'description' => 'Our experience with your company has been nothing short of exceptional, and Iam pleased to express our complete satisfaction with the services and support we have received.',
                'is_hidden' => 0,
                'sort_number' => 2,
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'name' => 'Sabeh Beton',
                'description' => 'We at Cimenterie Nationale are happy to share our experience using Softrasys as a tracking software company for over 10 years. During this time, Softrasys has consistently provided us with accurate and reliable data that has helped us make informed decisions for our transportation business.',
                'is_hidden' => 0,
                'sort_number' => 3,
                'created_at' => now(),
                'updated_at' => now(),

            ],
        ];

        DB::table('testimonials')->insert($testimonials);
    }
}

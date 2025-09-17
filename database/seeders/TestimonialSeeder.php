<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Africell',
                'description' => 'I am writing to express my gratitude and satisfaction with your tracking system services. As a customer who heavily relies on GPS technology for our business, we have had experience with various tracking systems in the past. However, none have come close to the level of service and quality that SOFTRASYS S.A.L provides.',
                'sort_number' => 1,
            ],
            [
                'name' => 'Halal',
                'description' => 'Our experience with your company has been nothing short of exceptional, and I am pleased to express our complete satisfaction with the services and support we have received.',
                'sort_number' => 2,
            ],
            [
                'name' => 'Sabeh Beton',
                'description' => 'We at Cimenterie Nationale are happy to share our experience using Softrasys as a tracking software company for over 10 years. During this time, Softrasys has consistently provided us with accurate and reliable data that has helped us make informed decisions for our transportation business.',
                'sort_number' => 3,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            // Insert into base table
            $testimonialId = DB::table('testimonials')->insertGetId([
                'is_hidden'   => 0,
                'sort_number' => $testimonial['sort_number'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // Insert 3 translations for each testimonial
            foreach ([1, 2, 3] as $langId) {
                DB::table('testimonial_languages')->insert([
                    'name'        => $testimonial['name'] ,
                    'description' => $testimonial['description'],
                    'testimonial_id' => $testimonialId,
                    'language_id' => $langId,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
    }
}

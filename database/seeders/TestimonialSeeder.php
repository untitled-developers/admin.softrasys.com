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
                'description' => '     Since 2015, SOFTRASYS has transformed our fleet. With real-time tracking, fuel monitoring, and smart maintenance, we gained 28% lower costs, 45% better safety, and full network visibility — a true boost in efficiency and ROI.',
                'sort_number' => 1,
            ],
            [
                'name' => 'Halal',
                'description' => 'Our experience with your company has been nothing short of exceptional, and I am pleased to express our complete satisfaction with the services and support we have received.',
                'sort_number' => 2,
            ],
            [
                'name' => 'Sabeh Beton',
                'description' => 'We at Cimenterie Nationale are happy to share our experience using Softrasys as a tracking software company for over 10 years. During this time, Softrasys has consistently.',
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

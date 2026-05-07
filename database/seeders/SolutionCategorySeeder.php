<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SolutionCategorySeeder extends Seeder
{
    use BlobHelper;

    public function run(): void
    {
        $categories = [
            [
                'slug'        => 'tracking-analytics',
                'sort_number' => 1,
                'is_header_menu' => true,
                'is_featured' => true,
                'name'        => 'Tracking & Analytics',
                'short_description' => 'Real-time GPS tracking and advanced data analytics to maximize fleet visibility and operational intelligence.',
            ],
            [
                'slug'        => 'fleet-operations',
                'sort_number' => 2,
                'is_header_menu' => true,
                'is_featured' => true,
                'name'        => 'Fleet Operations',
                'short_description' => 'End-to-end tools for managing, scheduling, and dispatching your fleet with maximum efficiency.',
            ],
            [
                'slug'        => 'maintenance-safety',
                'sort_number' => 3,
                'is_header_menu' => true,
                'is_featured' => true,
                'name'        => 'Maintenance & Safety',
                'short_description' => 'Proactive maintenance management and comprehensive surveillance solutions to keep your fleet safe and reliable.',
            ],
            [
                'slug'        => 'integration',
                'sort_number' => 4,
                'is_header_menu' => false,
                'is_featured' => false,
                'name'        => 'Integration',
                'short_description' => 'Robust API services that connect our platform seamlessly with your existing business systems and workflows.',
            ],
        ];

        foreach ($categories as $category) {
            $categoryId = DB::table('solution_categories')->insertGetId([
                'slug'           => $category['slug'],
                'blob_id'        => null,
                'sort_number'    => $category['sort_number'],
                'is_hidden'      => false,
                'is_header_menu' => $category['is_header_menu'],
                'is_featured'    => $category['is_featured'],
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            foreach ([1, 2, 3] as $langId) {
                DB::table('solution_category_languages')->insert([
                    'solution_category_id' => $categoryId,
                    'language_id'          => $langId,
                    'name'                 => $category['name'],
                    'short_description'    => $category['short_description'],
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ]);
            }
        }
    }
}

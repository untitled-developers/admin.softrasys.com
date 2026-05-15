<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SolutionCategorySeeder extends Seeder
{
    use BlobHelper;

    public function run(): void
    {
        $categories = [
            [
                'slug'              => 'fleet-management',
                'sort_number'       => 1,
                'is_header_menu'    => true,
                'is_featured'       => true,
                'name'              => 'Fleet Management',
                'short_description' => 'End-to-end fleet intelligence platform combining real-time tracking, analytics, operations, surveillance, and maintenance to maximize fleet performance.',
            ],
            [
                'slug'              => 'ai-development-consulting',
                'sort_number'       => 2,
                'is_header_menu'    => true,
                'is_featured'       => true,
                'name'              => 'AI Development & Consulting Services',
                'short_description' => 'Cutting-edge AI solutions and consulting services to drive digital transformation, automate workflows, and unlock new business opportunities.',
            ],
            [
                'slug'              => 'software-development',
                'sort_number'       => 3,
                'is_header_menu'    => true,
                'is_featured'       => true,
                'name'              => 'Software Development Services',
                'short_description' => 'Custom software development and API integration services tailored to your business needs and existing systems.',
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

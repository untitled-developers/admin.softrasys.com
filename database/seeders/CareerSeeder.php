<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('careers')->insert([
            [
                'title' => 'Software Engineer',
                'short_description' => 'Builds and maintains software applications.',
                'type' => 'Full-time',
                'description' => 'Responsible for designing, developing, and deploying software solutions. Works with cross-functional teams to deliver high-quality applications.',
                'is_hidden' => 0,
                'sort_number' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Graphic Designer',
                'short_description' => 'Creates visual content and branding.',
                'type' => 'Part-time',
                'description' => 'Designs marketing materials, websites, and branding assets to enhance company image. Works closely with marketing and product teams.',
                'is_hidden' => 0,
                'sort_number' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Project Manager',
                'short_description' => 'Oversees projects and ensures deadlines are met.',
                'type' => 'Contract',
                'description' => 'Plans, executes, and finalizes projects according to deadlines and budgets. Manages resources, risks, and stakeholders.',
                'is_hidden' => 0,
                'sort_number' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Data Analyst',
                'short_description' => 'Analyzes data to provide business insights.',
                'type' => 'Full-time',
                'description' => 'Collects, processes, and analyzes large data sets to help organizations make data-driven decisions. Creates reports and dashboards.',
                'is_hidden' => 0,
                'sort_number' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Content Writer',
                'short_description' => 'Writes engaging content for web and marketing.',
                'type' => 'Freelance',
                'description' => 'Creates blog posts, articles, and website content. Works with SEO and marketing teams to improve online visibility.',
                'is_hidden' => 0,
                'sort_number' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'HR Specialist',
                'short_description' => 'Manages recruitment and employee relations.',
                'type' => 'Full-time',
                'description' => 'Handles employee hiring, onboarding, training, and workplace policies. Ensures compliance with labor laws.',
                'is_hidden' => 0,
                'sort_number' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

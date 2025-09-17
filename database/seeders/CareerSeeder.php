<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CareerSeeder extends Seeder
{
    public function run(): void
    {
        $careers = [
            ['type' => 'Full-time', 'sort_number' => 1, 'title' => 'Software Engineer', 'short' => 'Builds and maintains software applications.', 'desc' => 'Responsible for designing, developing, and deploying software solutions. Works with cross-functional teams to deliver high-quality applications.'],
            ['type' => 'Part-time', 'sort_number' => 2, 'title' => 'Graphic Designer', 'short' => 'Creates visual content and branding.', 'desc' => 'Designs marketing materials, websites, and branding assets to enhance company image. Works closely with marketing and product teams.'],
            ['type' => 'Contract',  'sort_number' => 3, 'title' => 'Project Manager', 'short' => 'Oversees projects and ensures deadlines are met.', 'desc' => 'Plans, executes, and finalizes projects according to deadlines and budgets. Manages resources, risks, and stakeholders.'],
            ['type' => 'Full-time', 'sort_number' => 4, 'title' => 'Data Analyst', 'short' => 'Analyzes data to provide business insights.', 'desc' => 'Collects, processes, and analyzes large data sets to help organizations make data-driven decisions. Creates reports and dashboards.'],
            ['type' => 'Freelance', 'sort_number' => 5, 'title' => 'Content Writer', 'short' => 'Writes engaging content for web and marketing.', 'desc' => 'Creates blog posts, articles, and website content. Works with SEO and marketing teams to improve online visibility.'],
            ['type' => 'Full-time', 'sort_number' => 6, 'title' => 'HR Specialist', 'short' => 'Manages recruitment and employee relations.', 'desc' => 'Handles employee hiring, onboarding, training, and workplace policies. Ensures compliance with labor laws.'],
        ];

        foreach ($careers as $index => $career) {
            $careerId = DB::table('careers')->insertGetId([
                'type'        => $career['type'],
                'is_hidden'   => 0,
                'sort_number' => $career['sort_number'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            foreach ([1, 2, 3] as $langId) {
                DB::table('career_languages')->insert([
                    'job_title'         => $career['title'],
                    'short_description' => $career['short'],
                    'job_description'   => $career['desc'],
                    'career_id'         => $careerId,
                    'language_id'       => $langId,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }
        }
    }
}

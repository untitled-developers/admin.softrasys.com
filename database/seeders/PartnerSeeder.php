<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            [
                'sort_number' => 1,
                'languages' => [
                    1 => ['name' => 'BMB', 'short_description' => 'Exclusive Partner'],
                    2 => ['name' => 'BMB', 'short_description' => 'Partenaire exclusif'],
                    3 => ['name' => 'BMB', 'short_description' => 'الشريك الحصري'],
                ],
            ],
            [
                'sort_number' => 2,
                'languages' => [
                    1 => ['name' => 'Lemec', 'short_description' => 'Reseller & Authorized Installer'],
                    2 => ['name' => 'Lemec', 'short_description' => 'Revendeur et installateur agréé'],
                    3 => ['name' => 'Lemec', 'short_description' => 'الموزع والمركب المعتمد'],
                ],
            ],
            [
                'sort_number' => 3,
                'languages' => [
                    1 => ['name' => 'Karam Electronics', 'short_description' => 'Security & Automation — MENA Region'],
                    2 => ['name' => 'Karam Electronics', 'short_description' => 'Sécurité et automatisation — Région MENA'],
                    3 => ['name' => 'Karam Electronics', 'short_description' => 'الأمن والأتمتة — منطقة الشرق الأوسط وشمال إفريقيا'],
                ],
            ],
            [
                'sort_number' => 4,
                'languages' => [
                    1 => ['name' => 'EleCorps', 'short_description' => 'Security & Automation — MENA Region'],
                    2 => ['name' => 'EleCorps', 'short_description' => 'Sécurité et automatisation — Région MENA'],
                    3 => ['name' => 'EleCorps', 'short_description' => 'الأمن والأتمتة — منطقة الشرق الأوسط وشمال إفريقيا'],
                ],
            ],
        ];

        foreach ($partners as $partner) {
            $partnerId = DB::table('partners')->insertGetId([
                'blob_id'     => null,
                'sort_number' => $partner['sort_number'],
                'is_hidden'   => false,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            foreach ($partner['languages'] as $languageId => $translation) {
                DB::table('partner_languages')->insert([
                    'partner_id'        => $partnerId,
                    'language_id'       => $languageId,
                    'name'              => $translation['name'],
                    'short_description' => $translation['short_description'],
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }
        }
    }
}

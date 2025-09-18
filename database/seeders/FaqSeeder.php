<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What is GPS tracking and how does it benefit businesses?',
                'answer'   => 'GPS tracking uses satellite technology to monitor vehicle locations in real-time. It helps businesses optimize routes, reduce fuel costs, and enhance operational efficiency.'
            ],
            [
                'question' => 'How can fleet management solutions help my business?',
                'answer'   => 'Fleet management solutions streamline vehicle operations by automating maintenance schedules, tracking driver behavior, and improving fuel management, ultimately saving time and money.'
            ],
            [
                'question' => 'What type of devices can access the Eyemanager platform?',
                'answer'   => 'Eyemanager is accessible via desktops, laptops, tablets, and smartphones, ensuring you can manage your fleet anytime, anywhere.'
            ],
            [
                'question' => 'Does SOFTRASYS partner with resellers?',
                'answer'   => 'Yes, we collaborate with resellers worldwide to expand our reach and provide localized support for our solutions.'
            ],
            [
                'question' => 'How accurate is GPS tracking?',
                'answer'   => 'GPS tracking provides accurate location information within a few meters, although factors like satellite availability, atmospheric conditions, and signal obstructions can affect accuracy in certain situations.'
            ],
            [
                'question' => 'Does the Eyemanager platform send alerts when drivers are speeding?',
                'answer'   => 'Yes, the Eyemanager platform alerts management of speeding vehicles with alerts and reports, enabling customers to reduce speeding violations and increase safety.'
            ],
            [
                'question' => 'Does SOFTRASYS provide mapping overlays?',
                'answer'   => 'Yes, the Eyemanager platform offers several GPS tracking map overlays, including detailed street overlays for Google Earth and cellular coverage overlays, providing better insight into vehicle locations.'
            ],
            [
                'question' => 'How long does it take to install a SOFTRASYS tracking device?',
                'answer'   => 'The installation time for a GPS tracking device from SOFTRASYS can range from half an hour to a few hours, depending on the device\'s features. The process is well-organized to minimize vehicle downtime.'
            ],
            [
                'question' => 'How secure is the data transmitted by GPS tracking systems?',
                'answer'   => 'Data transmitted by GPS tracking systems is secure as SOFTRASYS uses secure communication protocols and encryption to protect data transmission.'
            ],
        ];

        foreach ($faqs as $index => $faq) {
            // Insert into base faqs table
            $faqId = DB::table('faqs')->insertGetId([
                'is_hidden'   => 0,
                'sort_number' => $index + 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // Insert translations for 3 languages (IDs 1,2,3)
            foreach ([1, 2, 3] as $langId) {
                DB::table('faq_languages')->insert([
                    'question'    => $faq['question'] ,
                    'answer'      => $faq['answer'],
                    'faq_id'      => $faqId,
                    'language_id' => $langId,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Blob;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeds the GPS landing-page content that previously lived as static arrays in
 * gps.softrasys.com/resources/lang/{en,fr,ar}/gps.php and the section blades.
 *
 * Safe to run once: each section is skipped if its table already has rows, so
 * re-running will not create duplicates. Run with:
 *   php artisan db:seed --class=GpsPageSeeder
 */
class GpsPageSeeder extends Seeder
{
    public function run(): void
    {
        $langIds = DB::table('languages')->pluck('id', 'code'); // ['en'=>1, 'fr'=>2, ...]

        $this->seedFeatures($langIds);
        $this->seedStats($langIds);
        $this->seedIndustries($langIds);
        $this->seedTestimonials($langIds);
        $this->seedScreenshots();
        $this->seedFaqs($langIds);
    }

    private function createBlob(string $url, string $directory): int
    {
        $blob = new Blob();
        $blob->url = $url;
        $blob->name = basename($url);
        $blob->directory = $directory;
        $blob->type = 'image/webp';
        $blob->ext = pathinfo($url, PATHINFO_EXTENSION);
        $blob->save();

        return $blob->id;
    }

    private function insertTranslations(string $table, string $fk, int $id, array $translations, $langIds): void
    {
        foreach ($translations as $code => $fields) {
            if (!isset($langIds[$code])) {
                continue;
            }
            DB::table($table)->insert(array_merge($fields, [
                $fk           => $id,
                'language_id' => $langIds[$code],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]));
        }
    }

    private function seedFeatures($langIds): void
    {
        if (DB::table('gps_features')->exists()) {
            $this->command->warn('gps_features already has data, skipping.');
            return;
        }

        $features = [
  0 => 
  [
    'icon' => '/assets/gps/feature-live-tracking.webp',
    'translations' => 
    [
      'en' => 
      [
        'title' => 'Live Tracking',
        'description' => 'Real-time fleet tracking for optimal control, efficiency, and on-time deliveries.',
      ],
      'fr' => 
      [
        'title' => 'Suivi en Direct',
        'description' => 'Suivi de flotte en temps réel pour un contrôle optimal, une meilleure efficacité et des livraisons à l\'heure.',
      ],
      'ar' => 
      [
        'title' => 'التتبع المباشر',
        'description' => 'تتبع مباشر لأسطولك لتحقيق أقصى قدر من السيطرة والكفاءة والتسليم في الوقت المحدد.',
      ],
    ],
  ],
  1 => 
  [
    'icon' => '/assets/gps/feature-fleet-management.webp',
    'translations' => 
    [
      'en' => 
      [
        'title' => 'Fleet Management',
        'description' => 'Maintenance, suppliers, fuel, infractions, policies. Streamline operations with us.',
      ],
      'fr' => 
      [
        'title' => 'Gestion de Flotte',
        'description' => 'Maintenance, fournisseurs, carburant, infractions, politiques. Simplifiez vos opérations avec nous.',
      ],
      'ar' => 
      [
        'title' => 'إدارة الأسطول',
        'description' => 'الصيانة والموردون والوقود والمخالفات والسياسات. بسّط عملياتك معنا.',
      ],
    ],
  ],
  2 => 
  [
    'icon' => '/assets/gps/feature-routes-replay.webp',
    'translations' => 
    [
      'en' => 
      [
        'title' => 'Routes Replay',
        'description' => 'Monitor driver routes for enhanced oversight. Gain valuable insights into vehicle movements.',
      ],
      'fr' => 
      [
        'title' => 'Relecture des Itinéraires',
        'description' => 'Surveillez les itinéraires des conducteurs pour une meilleure supervision et des informations précieuses sur les déplacements.',
      ],
      'ar' => 
      [
        'title' => 'إعادة تشغيل المسارات',
        'description' => 'راقب مسارات السائقين لإشراف أفضل، واستفد من رؤى قيّمة حول تحركات المركبات.',
      ],
    ],
  ],
  3 => 
  [
    'icon' => '/assets/gps/feature-comprehensive-reports.webp',
    'translations' => 
    [
      'en' => 
      [
        'title' => 'Comprehensive Reports',
        'description' => 'Data-driven insights for optimized fleet performance.',
      ],
      'fr' => 
      [
        'title' => 'Rapports Complets',
        'description' => 'Des données analytiques pour optimiser les performances de votre flotte.',
      ],
      'ar' => 
      [
        'title' => 'تقارير شاملة',
        'description' => 'رؤى مبنية على البيانات لتحسين أداء الأسطول.',
      ],
    ],
  ],
];

        foreach ($features as $sort => $feature) {
            $id = DB::table('gps_features')->insertGetId([
                'blob_id'     => $this->createBlob($feature['icon'], 'gps-features'),
                'is_hidden'   => 0,
                'sort_number' => $sort + 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
            $this->insertTranslations('gps_feature_languages', 'gps_feature_id', $id, $feature['translations'], $langIds);
        }
    }

    private function seedStats($langIds): void
    {
        if (DB::table('gps_stats')->exists()) {
            $this->command->warn('gps_stats already has data, skipping.');
            return;
        }

        $stats = [
  0 => 
  [
    'value' => 5000,
    'suffix' => '+',
    'translations' => 
    [
      'en' => 
      [
        'title' => 'Registered Vehicles',
        'subtitle' => 'Managing diverse fleet types across industries',
      ],
      'fr' => 
      [
        'title' => 'Véhicules Enregistrés',
        'subtitle' => 'Gestion de divers types de flottes dans tous les secteurs',
      ],
      'ar' => 
      [
        'title' => 'مركبة مسجلة',
        'subtitle' => 'إدارة أنواع متنوعة من الأساطيل في مختلف القطاعات',
      ],
    ],
  ],
  1 => 
  [
    'value' => 15,
    'suffix' => '+',
    'translations' => 
    [
      'en' => 
      [
        'title' => 'Years of Expertise',
        'subtitle' => 'Deep industry knowledge and technical excellence',
      ],
      'fr' => 
      [
        'title' => 'Années d\'Expertise',
        'subtitle' => 'Connaissance approfondie du secteur et excellence technique',
      ],
      'ar' => 
      [
        'title' => 'سنة خبرة',
        'subtitle' => 'معرفة عميقة بالقطاع وتميز تقني',
      ],
    ],
  ],
  2 => 
  [
    'value' => 20,
    'suffix' => '+',
    'translations' => 
    [
      'en' => 
      [
        'title' => 'Sensor Types',
        'subtitle' => 'Comprehensive monitoring capabilities',
      ],
      'fr' => 
      [
        'title' => 'Types de Capteurs',
        'subtitle' => 'Capacités de surveillance complètes',
      ],
      'ar' => 
      [
        'title' => 'نوع مستشعرات',
        'subtitle' => 'قدرات مراقبة شاملة',
      ],
    ],
  ],
  3 => 
  [
    'value' => 45,
    'suffix' => '+',
    'translations' => 
    [
      'en' => 
      [
        'title' => 'Industries Served',
        'subtitle' => 'Cross-industry experience and best practices',
      ],
      'fr' => 
      [
        'title' => 'Industries Servies',
        'subtitle' => 'Expérience intersectorielle et meilleures pratiques',
      ],
      'ar' => 
      [
        'title' => 'صناعات',
        'subtitle' => 'خبرة شاملة في مختلف القطاعات وأفضل الممارسات',
      ],
    ],
  ],
];

        foreach ($stats as $sort => $stat) {
            $id = DB::table('gps_stats')->insertGetId([
                'value'       => $stat['value'],
                'suffix'      => $stat['suffix'],
                'is_hidden'   => 0,
                'sort_number' => $sort + 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
            $this->insertTranslations('gps_stat_languages', 'gps_stat_id', $id, $stat['translations'], $langIds);
        }
    }

    private function seedIndustries($langIds): void
    {
        if (DB::table('gps_industries')->exists()) {
            $this->command->warn('gps_industries already has data, skipping.');
            return;
        }

        $industries = [
  0 => 
  [
    'icon' => '/assets/gps/industry-fmcg.webp',
    'translations' => 
    [
      'en' => 
      [
        'title' => 'FMCG',
        'description' => 'We offer solutions encompassing temperature monitoring, overheat alerts, and more.',
      ],
      'fr' => 
      [
        'title' => 'Grande Consommation',
        'description' => 'Nous proposons des solutions incluant la surveillance de la température, les alertes de surchauffe, et plus encore.',
      ],
      'ar' => 
      [
        'title' => 'السلع الاستهلاكية',
        'description' => 'نقدم حلولاً تشمل مراقبة درجات الحرارة وتنبيهات الارتفاع الحراري والمزيد.',
      ],
    ],
  ],
  1 => 
  [
    'icon' => '/assets/gps/industry-pharma.webp',
    'translations' => 
    [
      'en' => 
      [
        'title' => 'Pharmaceuticals',
        'description' => 'Our offerings extend to temperature monitoring, overheat alerts, compressor control, RFID integration, and other relevant features.',
      ],
      'fr' => 
      [
        'title' => 'Industrie Pharmaceutique',
        'description' => 'Nos offres incluent la surveillance de la température, les alertes de surchauffe, le contrôle des compresseurs, l\'intégration RFID et d\'autres fonctionnalités pertinentes.',
      ],
      'ar' => 
      [
        'title' => 'الصناعات الدوائية',
        'description' => 'خدماتنا تشمل مراقبة الحرارة والتنبيهات والتحكم بالضاغط وتكامل RFID والمزيد.',
      ],
    ],
  ],
  2 => 
  [
    'icon' => '/assets/gps/industry-rental.webp',
    'translations' => 
    [
      'en' => 
      [
        'title' => 'Car Rental',
        'description' => 'Services include auto-geozone immobilization, real-time monitoring via our mobile app, and accessible 24/7 customer support.',
      ],
      'fr' => 
      [
        'title' => 'Location de Voitures',
        'description' => 'Les services incluent l\'immobilisation automatique par géozone, la surveillance en temps réel via notre application mobile, et un support client accessible 24h/24 et 7j/7.',
      ],
      'ar' => 
      [
        'title' => 'تأجير السيارات',
        'description' => 'خدماتنا تشمل التعطيل الجغرافي التلقائي والمراقبة الآنية وخدمة عملاء على مدار الساعة.',
      ],
    ],
  ],
  3 => 
  [
    'icon' => '/assets/gps/industry-heavy.webp',
    'translations' => 
    [
      'en' => 
      [
        'title' => 'Heavy Trucks',
        'description' => 'We specialize in fuel monitoring systems tailored specifically for heavy trucks.',
      ],
      'fr' => 
      [
        'title' => 'Camions Lourds',
        'description' => 'Nous nous spécialisons dans les systèmes de surveillance du carburant conçus spécifiquement pour les camions lourds.',
      ],
      'ar' => 
      [
        'title' => 'الشاحنات الثقيلة',
        'description' => 'نتخصص في أنظمة مراقبة الوقود المصممة خصيصاً للشاحنات الثقيلة.',
      ],
    ],
  ],
  4 => 
  [
    'icon' => '/assets/gps/industry-system.webp',
    'translations' => 
    [
      'en' => 
      [
        'title' => 'System Integration',
        'description' => 'Expertise in seamless system integration facilitated by automatic web APIs.',
      ],
      'fr' => 
      [
        'title' => 'Intégration de Systèmes',
        'description' => 'Expertise dans l\'intégration transparente des systèmes facilitée par des API web automatiques.',
      ],
      'ar' => 
      [
        'title' => 'تكامل الأنظمة',
        'description' => 'خبرة في التكامل السلس للأنظمة عبر واجهات برمجة الويب التلقائية.',
      ],
    ],
  ],
];

        foreach ($industries as $sort => $industry) {
            $id = DB::table('gps_industries')->insertGetId([
                'blob_id'     => $this->createBlob($industry['icon'], 'gps-industries'),
                'is_hidden'   => 0,
                'sort_number' => $sort + 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
            $this->insertTranslations('gps_industry_languages', 'gps_industry_id', $id, $industry['translations'], $langIds);
        }
    }

    private function seedTestimonials($langIds): void
    {
        if (DB::table('gps_testimonials')->exists()) {
            $this->command->warn('gps_testimonials already has data, skipping.');
            return;
        }

        $testimonials = [
  0 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'name' => 'Africell',
        'text' => 'I am writing to express my gratitude and satisfaction with your tracking system services. As a customer who heavily relies on GPS technology for our business, we have had experience with various tracking systems in the past. However, none have come close to the level of service and quality that SOFTRASYS S.A.L provides.',
      ],
      'fr' => 
      [
        'name' => 'Africell',
        'text' => 'Je vous écris pour exprimer ma gratitude et ma satisfaction concernant vos services de système de suivi. En tant que client qui dépend fortement de la technologie GPS pour notre activité, nous avons eu l\'expérience de divers systèmes de suivi par le passé. Cependant, aucun n\'a égalé le niveau de service et de qualité fourni par SOFTRASYS S.A.L.',
      ],
      'ar' => 
      [
        'name' => 'Africell',
        'text' => 'أكتب للتعبير عن امتناني ورضاي عن خدمات نظام التتبع لديكم. لم يقترب أي نظام آخر من مستوى الخدمة والجودة التي تقدمها SOFTRASYS S.A.L.',
      ],
    ],
  ],
  1 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'name' => 'Halal',
        'text' => 'Our experience with your company has been nothing short of exceptional, and I am pleased to express our complete satisfaction with the services and support we have received.',
      ],
      'fr' => 
      [
        'name' => 'Halal',
        'text' => 'Notre expérience avec votre entreprise a été tout simplement exceptionnelle, et je suis heureux d\'exprimer notre entière satisfaction quant aux services et au soutien que nous avons reçus.',
      ],
      'ar' => 
      [
        'name' => 'Halal',
        'text' => 'تجربتنا مع شركتكم كانت استثنائية بكل المقاييس، ويسعدني التعبير عن رضانا التام عن الخدمات والدعم الذي تلقيناه.',
      ],
    ],
  ],
  2 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'name' => 'Sabeh Beton',
        'text' => 'We at Cimenterie Nationale are happy to share our experience using Softrasys as a tracking software company for over 10 years. Softrasys has consistently provided us with accurate and reliable data that has helped us make informed decisions for our transportation business.',
      ],
      'fr' => 
      [
        'name' => 'Sabeh Beton',
        'text' => 'Chez Cimenterie Nationale, nous sommes heureux de partager notre expérience avec Softrasys en tant qu\'éditeur de logiciels de suivi depuis plus de 10 ans. Softrasys nous a constamment fourni des données précises et fiables qui nous ont aidés à prendre des décisions éclairées pour notre activité de transport.',
      ],
      'ar' => 
      [
        'name' => 'Sabeh Beton',
        'text' => 'نحن في سيمنتيري ناسيونال سعداء بمشاركة تجربتنا مع Softrasys كشريك في تتبع المركبات على مدى أكثر من 10 سنوات. قدمت لنا Softrasys باستمرار بيانات دقيقة وموثوقة ساعدتنا في اتخاذ قرارات مدروسة لأعمالنا.',
      ],
    ],
  ],
];

        foreach ($testimonials as $sort => $testimonial) {
            $id = DB::table('gps_testimonials')->insertGetId([
                'is_hidden'   => 0,
                'sort_number' => $sort + 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
            $this->insertTranslations('gps_testimonial_languages', 'gps_testimonial_id', $id, $testimonial['translations'], $langIds);
        }
    }

    private function seedScreenshots(): void
    {
        if (DB::table('gps_screenshots')->exists()) {
            $this->command->warn('gps_screenshots already has data, skipping.');
            return;
        }

        $screenshots = [
  0 => '/assets/gps/screenshot-1.webp',
  1 => '/assets/gps/screenshot-2.webp',
  2 => '/assets/gps/screenshot-3.webp',
  3 => '/assets/gps/screenshot-4.webp',
  4 => '/assets/gps/screenshot-5.webp',
  5 => '/assets/gps/screenshot-6.webp',
  6 => '/assets/gps/screenshot-7.webp',
];

        foreach ($screenshots as $sort => $url) {
            DB::table('gps_screenshots')->insert([
                'blob_id'     => $this->createBlob($url, 'gps-screenshots'),
                'is_hidden'   => 0,
                'sort_number' => $sort + 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }

    private function seedFaqs($langIds): void
    {
        if (DB::table('gps_faqs')->exists()) {
            $this->command->warn('gps_faqs already has data, skipping.');
            return;
        }

        $faqs = [
  0 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'question' => 'What is GPS tracking?',
        'answer' => 'GPS tracking is a technology that uses GPS to determine the real-time location of vehicles or assets, providing businesses with improved efficiency, security, and decision-making capabilities.',
      ],
      'fr' => 
      [
        'question' => 'Qu\'est-ce que le suivi GPS ?',
        'answer' => 'Le suivi GPS est une technologie qui utilise le GPS pour déterminer en temps réel la position des véhicules ou des actifs, offrant aux entreprises une efficacité, une sécurité et une capacité de décision améliorées.',
      ],
      'ar' => 
      [
        'question' => 'ما هو تتبع GPS؟',
        'answer' => 'تتبع GPS تقنية تستخدم نظام تحديد المواقع لتحديد الموقع الفعلي للمركبات أو الأصول في الوقت الفعلي، مما يوفر للشركات كفاءة ومرونة أفضل في اتخاذ القرارات.',
      ],
    ],
  ],
  1 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'question' => 'How does GPS tracking benefit businesses?',
        'answer' => 'GPS tracking benefits businesses by improving fleet visibility, enhancing asset security, optimizing route planning, enabling efficient dispatching, and assisting in maintenance management.',
      ],
      'fr' => 
      [
        'question' => 'En quoi le suivi GPS profite-t-il aux entreprises ?',
        'answer' => 'Le suivi GPS profite aux entreprises en améliorant la visibilité de la flotte, en renforçant la sécurité des actifs, en optimisant la planification des itinéraires, en permettant une répartition efficace et en facilitant la gestion de la maintenance.',
      ],
      'ar' => 
      [
        'question' => 'كيف يفيد تتبع GPS الشركات؟',
        'answer' => 'يحسّن تتبع GPS رؤية الأسطول ويعزز أمان الأصول ويُحسّن تخطيط المسارات ويُمكّن التوزيع الفعّال ويساعد في إدارة الصيانة.',
      ],
    ],
  ],
  2 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'question' => 'What is fleet management?',
        'answer' => 'Fleet management involves overseeing and controlling a fleet of vehicles or assets, including activities such as vehicle tracking, maintenance management, fuel monitoring, and driver behavior analysis.',
      ],
      'fr' => 
      [
        'question' => 'Qu\'est-ce que la gestion de flotte ?',
        'answer' => 'La gestion de flotte consiste à superviser et contrôler un parc de véhicules ou d\'actifs, y compris des activités telles que le suivi des véhicules, la gestion de la maintenance, le suivi du carburant et l\'analyse du comportement des conducteurs.',
      ],
      'ar' => 
      [
        'question' => 'ما هي إدارة الأسطول؟',
        'answer' => 'تشمل إدارة الأسطول الإشراف على أسطول المركبات والتحكم فيه، بما في ذلك تتبع المركبات وإدارة الصيانة ومراقبة الوقود وتحليل سلوك السائق.',
      ],
    ],
  ],
  3 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'question' => 'How can fleet management solutions help my business?',
        'answer' => 'Fleet management solutions help businesses achieve cost savings, improved safety, enhanced productivity, and maintenance optimization by identifying inefficient practices, monitoring driver behavior, streamlining operations, and tracking vehicle health.',
      ],
      'fr' => 
      [
        'question' => 'Comment les solutions de gestion de flotte peuvent-elles aider mon entreprise ?',
        'answer' => 'Les solutions de gestion de flotte aident les entreprises à réaliser des économies, à améliorer la sécurité, à accroître la productivité et à optimiser la maintenance en identifiant les pratiques inefficaces, en surveillant le comportement des conducteurs, en simplifiant les opérations et en surveillant la santé des véhicules.',
      ],
      'ar' => 
      [
        'question' => 'كيف تُساعد حلول إدارة الأسطول عملي؟',
        'answer' => 'تُساعد حلول إدارة الأسطول الشركات على تحقيق توفير في التكاليف وتحسين السلامة والإنتاجية من خلال تحديد الممارسات غير الفعّالة وتبسيط العمليات.',
      ],
    ],
  ],
  4 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'question' => 'How accurate is GPS tracking?',
        'answer' => 'GPS tracking provides accurate location information within a few meters, although satellite availability, atmospheric conditions, and signal obstructions can affect accuracy in certain situations.',
      ],
      'fr' => 
      [
        'question' => 'Quelle est la précision du suivi GPS ?',
        'answer' => 'Le suivi GPS fournit des informations de localisation précises à quelques mètres près, bien que la disponibilité des satellites, les conditions atmosphériques et les obstructions du signal puissent affecter la précision dans certaines situations.',
      ],
      'ar' => 
      [
        'question' => 'ما مدى دقة تتبع GPS؟',
        'answer' => 'يوفر تتبع GPS معلومات دقيقة عن الموقع في حدود بضعة أمتار، وإن كانت عوامل مثل توافر الأقمار الصناعية والظروف الجوية قد تؤثر على الدقة.',
      ],
    ],
  ],
  5 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'question' => 'How secure is the data transmitted by GPS tracking systems?',
        'answer' => 'Data transmitted by GPS tracking systems is secure — SOFTRASYS uses secure communication protocols and encryption to protect all data transmission.',
      ],
      'fr' => 
      [
        'question' => 'Les données transmises par les systèmes de suivi GPS sont-elles sécurisées ?',
        'answer' => 'Les données transmises par les systèmes de suivi GPS sont sécurisées — SOFTRASYS utilise des protocoles de communication sécurisés et un chiffrement pour protéger toutes les transmissions de données.',
      ],
      'ar' => 
      [
        'question' => 'ما مدى أمان البيانات المُرسَلة عبر أنظمة تتبع GPS؟',
        'answer' => 'تُعدّ البيانات آمنة تمامًا، إذ تستخدم SOFTRASYS بروتوكولات اتصال آمنة وتشفيرًا لحماية جميع البيانات المُرسَلة.',
      ],
    ],
  ],
  6 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'question' => 'How long does it take to install a SOFTRASYS tracking device?',
        'answer' => 'The installation time for a GPS tracking device from SOFTRASYS can range from half an hour to a few hours, depending on the device\'s features. The process is well-organized to minimize vehicle downtime.',
      ],
      'fr' => 
      [
        'question' => 'Combien de temps faut-il pour installer un dispositif de suivi SOFTRASYS ?',
        'answer' => 'Le temps d\'installation d\'un dispositif de suivi GPS de SOFTRASYS peut varier d\'une demi-heure à quelques heures, selon les caractéristiques du dispositif. Le processus est bien organisé pour minimiser l\'immobilisation du véhicule.',
      ],
      'ar' => 
      [
        'question' => 'كم يستغرق تركيب جهاز SOFTRASYS للتتبع؟',
        'answer' => 'يتراوح وقت التركيب بين نصف ساعة وبضع ساعات وفقًا لمواصفات الجهاز، وقد صُمّمت العملية لتقليص وقت توقف المركبة.',
      ],
    ],
  ],
  7 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'question' => 'Does Eyemanager send alerts when drivers are off course?',
        'answer' => 'Yes, the Eyemanager platform sends alerts when drivers are off course using geofences, and allows subscription to receive alerts via SMS, notifications, and email.',
      ],
      'fr' => 
      [
        'question' => 'Eyemanager envoie-t-il des alertes lorsque les conducteurs sortent du parcours ?',
        'answer' => 'Oui, la plateforme Eyemanager envoie des alertes lorsque les conducteurs sortent du parcours grâce aux géofences, et permet de s\'abonner pour recevoir des alertes par SMS, notifications et e-mail.',
      ],
      'ar' => 
      [
        'question' => 'هل تُرسل منصة Eyemanager تنبيهات عند انحراف السائقين؟',
        'answer' => 'نعم، ترسل منصة Eyemanager تنبيهات عند انحراف السائقين عن المسار باستخدام المناطق الجغرافية، مع إمكانية الاشتراك للتنبيهات عبر الرسائل أو الإشعارات أو البريد الإلكتروني.',
      ],
    ],
  ],
  8 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'question' => 'What devices can access the Eyemanager platform?',
        'answer' => 'The Eyemanager platform can be accessed from any smart device (desktop, tablet, smartphone) via a web browser or the map tracking Manager app for iOS or Android.',
      ],
      'fr' => 
      [
        'question' => 'Quels appareils peuvent accéder à la plateforme Eyemanager ?',
        'answer' => 'La plateforme Eyemanager est accessible depuis tout appareil intelligent (ordinateur, tablette, smartphone) via un navigateur web ou l\'application Manager pour iOS ou Android.',
      ],
      'ar' => 
      [
        'question' => 'ما الأجهزة التي يمكنها الوصول إلى منصة Eyemanager؟',
        'answer' => 'يمكن الوصول إلى منصة Eyemanager من أي جهاز ذكي (كمبيوتر، جهاز لوحي، هاتف) عبر متصفح الويب أو تطبيق الهاتف لأنظمة iOS وAndroid.',
      ],
    ],
  ],
  9 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'question' => 'How does SOFTRASYS display vehicle routes?',
        'answer' => 'The Eyemanager platform provides real-time location information and records of vehicles\' routes, including details on travel speed and more.',
      ],
      'fr' => 
      [
        'question' => 'Comment SOFTRASYS affiche-t-il les itinéraires des véhicules ?',
        'answer' => 'La plateforme Eyemanager fournit des informations de localisation en temps réel et des enregistrements des itinéraires des véhicules, y compris les détails de la vitesse et plus encore.',
      ],
      'ar' => 
      [
        'question' => 'كيف تعرض SOFTRASYS مسارات المركبات؟',
        'answer' => 'توفر منصة Eyemanager معلومات فورية عن موقع المركبات وسجلات مساراتها مع تفاصيل السرعة والمزيد.',
      ],
    ],
  ],
  10 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'question' => 'Does Eyemanager send alerts when drivers are speeding?',
        'answer' => 'Yes, the Eyemanager platform alerts management of speeding vehicles with alerts and reports, enabling customers to reduce speeding violations and increase safety.',
      ],
      'fr' => 
      [
        'question' => 'Eyemanager envoie-t-il des alertes lorsque les conducteurs dépassent la vitesse ?',
        'answer' => 'Oui, la plateforme Eyemanager alerte la direction des véhicules en excès de vitesse avec des alertes et des rapports, permettant aux clients de réduire les infractions liées à la vitesse et d\'accroître la sécurité.',
      ],
      'ar' => 
      [
        'question' => 'هل تُرسل منصة Eyemanager تنبيهات عند تجاوز السرعة؟',
        'answer' => 'نعم، تُنبّه المنصة الإدارة بتقارير وتنبيهات فورية لمركبات تتجاوز الحد الأقصى للسرعة.',
      ],
    ],
  ],
  11 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'question' => 'Does SOFTRASYS provide mapping overlays?',
        'answer' => 'Yes, the Eyemanager platform offers several GPS tracking map overlays, including detailed street overlays for Google Earth and cellular coverage overlays.',
      ],
      'fr' => 
      [
        'question' => 'SOFTRASYS propose-t-il des superpositions cartographiques ?',
        'answer' => 'Oui, la plateforme Eyemanager propose plusieurs superpositions cartographiques de suivi GPS, y compris des superpositions de rues détaillées pour Google Earth et des superpositions de couverture cellulaire.',
      ],
      'ar' => 
      [
        'question' => 'هل توفر SOFTRASYS طبقات خرائط إضافية؟',
        'answer' => 'نعم، تتيح منصة Eyemanager عدة طبقات لخرائط تتبع GPS تشمل طبقات شوارع تفصيلية وتغطية شبكات الخلوي.',
      ],
    ],
  ],
  12 => 
  [
    'translations' => 
    [
      'en' => 
      [
        'question' => 'What mapping service does SOFTRASYS use?',
        'answer' => 'The Eyemanager platform uses Google Maps, a web mapping service that offers satellite imagery and traffic information, including Street View for determining points of interest along routes.',
      ],
      'fr' => 
      [
        'question' => 'Quel service cartographique utilise SOFTRASYS ?',
        'answer' => 'La plateforme Eyemanager utilise Google Maps, un service de cartographie web offrant l\'imagerie satellite et les informations de trafic, y compris Street View pour identifier les points d\'intérêt le long des itinéraires.',
      ],
      'ar' => 
      [
        'question' => 'ما خدمة الخرائط التي تستخدمها SOFTRASYS؟',
        'answer' => 'تستخدم منصة Eyemanager خدمة خرائط Google التي تتضمن صور الأقمار الصناعية ومعلومات المرور وميزة Street View.',
      ],
    ],
  ],
];

        foreach ($faqs as $sort => $faq) {
            $id = DB::table('gps_faqs')->insertGetId([
                'is_hidden'   => 0,
                'sort_number' => $sort + 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
            $this->insertTranslations('gps_faq_languages', 'gps_faq_id', $id, $faq['translations'], $langIds);
        }
    }
}
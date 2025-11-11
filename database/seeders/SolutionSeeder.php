<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SolutionSeeder extends Seeder
{
    use BlobHelper;

    public function run(): void
    {
        $solutions = [
            [
                'name' => 'Vehicle Tracking',
                'short_description' => 'Our Fleet Tracker Device provides accurate GPS location data, route playback, and vehicle diagnostics to optimize fleet operations.',
                'long_description' => '
                    <h2 class="text-[#7a37b3] font-medium text-xl py-2">Centralized Real-Time Tracking</h2>
                    <h2 class="py-2 font-semibold">Transform Your Fleet Visibility with Unified Tracking Technology</h2>
                   <p> Our centralized tracking platform represents the cornerstone of modern fleet management, providing a single pane of glass for all your transportation assets. This sophisticated system integrates seamlessly with various vehicle types and tracking devices, offering real-time location data updated every 30 seconds.</p>
                    <h2 class="py-2 font-semibold"> Comprehensive Features:</h2>
                    <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Live Vehicle Monitoring:</span> Track all assets simultaneously with high-frequency updates using licensed Google Maps technology.</li>
                        <li><span class="text-[#7a37b3] font-medium">Historical Playback:</span>  Review comprehensive route histories with detailed timestamps for one year to ensure compliance.</li>
                        <li><span class="text-[#7a37b3] font-medium">Geofencing Capabilities:</span> Create virtual boundaries and receive instant notifications for zone entries/exits.</li>
                        <li><span class="text-[#7a37b3] font-medium">Multi-Asset Support: </span>Manage diverse vehicle types from trucks and vans to specialized equipment.</li>
                        <li><span class="text-[#7a37b3] font-medium">Customizable Views: </span>Tailor your dashboard to display the most critical information for your operations.</li>
                    </ul>
                    <h2 class="py-2 font-semibold">Business Impact:</h2>
                    Companies implementing our centralized tracking system typically experience a 20% improvement in resource allocation and a 15% reduction in unauthorized vehicle usage. The immediate visibility into vehicle status enables faster response times and more efficient daily planning.',
                'btn_text' => ' Experience Complete Fleet Visibility',
                'btn_href' => '/solutions/vehicle-tracking',
                'meta_description' => 'Our centralized tracking platform represents the cornerstone of modern fleet management, providing a single pane of glass for all your transportation assets. This sophisticated system integrates seamlessly with various vehicle types and tracking devices, offering real-time location data updated every 30 seconds.',
                'sort_number' => 1,
                'promotion_text' => 'Accurate GPS tracking & fleet optimization.',
                'image_url' => '/assets/solutions/img.png',
                'promotion_image_url' => '/assets/solutions/vehicle-tracking.svg'
            ],
            [
                'name' => 'In-Depth Analytics and Statistics',
                'short_description' => 'Move beyond basic tracking with our sophisticated analytics engine that transforms raw data into valuable business insights. Our platform processes millions of data points to provide comprehensive reporting across all aspects of fleet operations.',
                'long_description' => '
                    <h2 class="text-[#7a37b3] font-medium text-xl py-2">In-Depth Analytics and Statistics</h2>
                    <h2 class="py-2 font-semibold">Turn Data into Actionable Business Intelligence</h2>
                   <p>Move beyond basic tracking with our sophisticated analytics engine that transforms raw data into valuable business insights. Our platform processes millions of data points to provide comprehensive reporting across all aspects of fleet operations.</p>
                    <h2 class="py-2 font-semibold"> Advanced Reporting Suite:</h2>
                    <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Performance Analytics: </span> Measure vehicle utilization, efficiency metrics, and operational capacity.</li>
                        <li><span class="text-[#7a37b3] font-medium">Fuel Intelligence:</span> Detailed consumption analysis with theft detection and optimization recommendations.</li>
                        <li><span class="text-[#7a37b3] font-medium">Driver Behavior Scoring:</span> Monitor and improve driving patterns with comprehensive behavior analysis.</li>
                        <li><span class="text-[#7a37b3] font-medium">Maintenance Forecasting: </span>Predictive analytics for maintenance needs based on actual usage patterns.</li>
                        <li><span class="text-[#7a37b3] font-medium">Cost Per KM Analysis: </span>Detailed breakdown of operational expenses for accurate budgeting.</li>
                    </ul>
                    <h2 class="py-2 font-semibold">Custom Reporting Capabilities:</h2>
                    Create tailored reports that match your specific business requirements with our drag-and-drop report builder. Schedule automated report delivery to stakeholders, and export data in multiple formats for further analysis.
                    <h2 class="py-2 font-semibold">Proven Results:</h2>
                    Our clients achieve an average of 18% reduction in fuel costs and 22% improvement in maintenance planning efficiency through our analytical capabilities.
                    ',
                'btn_text' => 'Unlock Your Data Potential',
                'btn_href' => '/solutions/analytics-statistics',
                'meta_description' => 'Move beyond basic tracking with our sophisticated analytics engine that transforms raw data into valuable business insights. Our platform processes millions of data points to provide comprehensive reporting across all aspects of fleet operations.',
                'sort_number' => 2,
                'promotion_text' => 'Turn data into powerful fleet insights.',
                'image_url' => '/assets/solutions/img.png',
                'promotion_image_url' => '/assets/solutions/fleet-management.svg'
            ],
            [
                'name' => 'Fleet Management',
                'short_description' => 'Our fleet management solution provides complete command over your transportation operations, combining powerful tools with intuitive interfaces to streamline every aspect of fleet management.',
                'long_description' => '
                <h2 class="text-[#7a37b3] font-medium text-xl py-2">Comprehensive Fleet Management</h2>
                <h2 class="py-2 font-semibold">End-to-End Operational Control and Optimization</h2>
                <p>  Our fleet management solution provides complete command over your transportation operations, combining powerful tools with intuitive interfaces to streamline every aspect of fleet management.</p>
                <h2 class="py-2 font-semibold">Core Management Features:</h2>
                    <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Maintenance Scheduling: </span> Automated maintenance planning with predictive alerts and service history tracking.</li>
                        <li><span class="text-[#7a37b3] font-medium">Fuel Management:</span> Comprehensive fuel monitoring with consumption analysis and theft prevention.</li>
                        <li><span class="text-[#7a37b3] font-medium">Document Management:</span> Centralized storage for insurance documents, registration, and compliance certificates.</li>
                        <li><span class="text-[#7a37b3] font-medium">Cost Control: </span>Detailed expense tracking with categorization and budget comparison tools.</li>
                        <li><span class="text-[#7a37b3] font-medium">Compliance Assurance: </span>Automated regulatory compliance monitoring and reporting.</li>
                    </ul>
                    <h2 class="py-2 font-semibold">Advanced Functionality:</h2>
                      <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Bulk Operations: </span> Manage multiple vehicles simultaneously for efficient fleet-wide updates.</li>
                        <li><span class="text-[#7a37b3] font-medium">Custom Alert System:</span> Configure notifications for specific events and conditions.</li>
                        <li><span class="text-[#7a37b3] font-medium">Integration Ready: </span> Connect with existing ERP, CRM, and accounting systems.</li>
                        <li><span class="text-[#7a37b3] font-medium">Mobile Accessibility: </span>Full management capabilities through our mobile applications.</li>
                        </ul>
                    <h2 class="py-2 font-semibold">Operational Impact:</h2>
                    Businesses using our fleet management platform report 30% reduction in administrative workload and 25% improvement in regulatory compliance accuracy.',
                'btn_text' => 'Streamline Your Operations',
                'btn_href' => '/solutions/fleet-management',
                'meta_description' => 'Our fleet management solution provides complete command over your transportation operations, combining powerful tools with intuitive interfaces to streamline every aspect of fleet management.',
                'sort_number' => 3,
                'promotion_text' => 'Total control over fleet operations.',
                'image_url' => '/assets/solutions/img_1.png',
                'promotion_image_url' => '/assets/solutions/fleet-management.svg'
            ],
            [
                'name' => 'Advanced Maintenance Management',
                'short_description' => 'Transform your maintenance operations from reactive repairs to proactive management with our comprehensive maintenance module. Our system ensures every vehicle receives timely care, reducing downtime and extending asset lifespan.',
                'long_description' => '
                <h2 class="text-[#7a37b3] font-medium text-xl py-2">Advanced Maintenance Management</h2>
                <h2 class="py-2 font-semibold">Proactive Vehicle Care for Maximum Reliability and Longevity</h2>
                <p>Transform your maintenance operations from reactive repairs to proactive management with our comprehensive maintenance module. Our system ensures every vehicle receives timely care, reducing downtime and extending asset lifespan.</p>
                <h2 class="py-2 font-semibold">Maintenance Management Features:</h2>
                    <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Preventive Scheduling: </span> Automated service intervals based on mileage, engine hours, or time periods.</li>
                        <li><span class="text-[#7a37b3] font-medium">Repair Tracking:</span> Complete history of all maintenance activities with cost documentation.</li>
                    </ul>
                    <h2 class="py-2 font-semibold">Predictive Capabilities:</h2>
                      <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Health Monitoring: </span> Real-time monitoring of vehicle systems for early problem detection.</li>
                        <li><span class="text-[#7a37b3] font-medium">Cost Forecasting: </span> Predictive budgeting for future maintenance requirements.</li>
                        <li><span class="text-[#7a37b3] font-medium">Downtime Planning: </span>Schedule maintenance during optimal periods to minimize operational impact.</li>
                        </ul>
                        <h2 class="py-2 font-semibold">Documentation Excellence:</h2>
                      <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Compliance Reporting: </span>  Generate maintenance compliance reports for regulatory requirements.</li>
                        <li><span class="text-[#7a37b3] font-medium">History Analysis: </span> Analyze maintenance patterns to identify recurring issues and opportunities for improvement.</li>
                        </ul>
                    <h2 class="py-2 font-semibold">Demonstrated Benefits:</h2>
                    Our maintenance module helps clients achieve up to 40% reduction in unexpected breakdowns and 20% extension in vehicle lifespan through proper maintenance scheduling.',
                'btn_text' => 'Optimize Your Maintenance Strategy',
                'btn_href' => '/solutions/maintenance-management',
                'meta_description' => 'Transform your maintenance operations from reactive repairs to proactive management with our comprehensive maintenance module. Our system ensures every vehicle receives timely care, reducing downtime and extending asset lifespan.',
                'sort_number' => 4,
                'promotion_text' => 'Proactive vehicle maintenance made easy.',
                'image_url' => '/assets/solutions/img_1.png',
                'promotion_image_url' => '/assets/solutions/dispatch.svg'
            ],
            [
                'name' => 'Vehicle Booking System',
                'short_description' => 'Eliminate scheduling conflicts and maximize vehicle utilization with our smart booking platform. This system provides complete visibility into vehicle availability while ensuring fair and efficient allocation across your organization.',
                'long_description' => '
                <h2 class="text-[#7a37b3] font-medium text-xl py-2">Intelligent Vehicle Booking System</h2>
                <h2 class="py-2 font-semibold">Streamlined Resource Allocation and Utilization</h2>
                <p>Eliminate scheduling conflicts and maximize vehicle utilization with our smart booking platform. This system provides complete visibility into vehicle availability while ensuring fair and efficient allocation across your organization.</p>
                <h2 class="py-2 font-semibold"> Booking System Features: </h2>
                    <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Real-Time Availability: </span> Instant visibility into vehicle status and scheduling conflicts.</li>
                        <li><span class="text-[#7a37b3] font-medium">Multi-Level Approval:</span> Customizable approval workflows based on vehicle type and department.</li>
                        <li><span class="text-[#7a37b3] font-medium">Usage Analytics:</span> Track booking patterns and utilization rates for optimal fleet sizing.</li>
                        <li><span class="text-[#7a37b3] font-medium">Mobile Access: </span>Book and manage vehicles through our mobile application.</li>
                        <li><span class="text-[#7a37b3] font-medium">Integration Capabilities: </span>Connect with calendar systems for seamless scheduling.</li>
                    </ul>
                    <h2 class="py-2 font-semibold" >Advanced Functionality: </h2>
                    <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Priority Management: </span> Set booking priorities based on department needs and urgency levels.</li>
                        <li><span class="text-[#7a37b3] font-medium">Reporting Suite: </span> Comprehensive utilization reports with actionable insights.</li>
                        <li><span class="text-[#7a37b3] font-medium">Custom Rules Engine: </span> Configure booking rules specific to your organizational needs.</li>
                    </ul>
                    <h2 class="py-2 font-semibold">Operational Benefits:</h2>
                    Organizations using our booking system typically achieve 35% better vehicle utilization and complete elimination of scheduling conflicts.
                    ',
                'btn_text' => 'Transform Your Vehicle Allocation',
                'btn_href' => '/solutions/vehicle-booking-system',
                'meta_description' => 'Eliminate scheduling conflicts and maximize vehicle utilization with our smart booking platform. This system provides complete visibility into vehicle availability while ensuring fair and efficient allocation across your organization.',
                'sort_number' => 5,
                'promotion_text' => 'Smart booking for max vehicle use.',
                'image_url' => '/assets/solutions/img_4.png',
                'promotion_image_url' => '/assets/solutions/booking.svg'
            ],
            [
                'name' => 'Dispatch System',
                'short_description' => 'Revolutionize your dispatch operations with our real-time management platform that connects fleet managers and drivers through seamless communication and task coordination.',
                'long_description' => '
                    <h2 class="text-[#7a37b3] font-medium text-xl py-2">Real-Time Dispatch System</h2>
                    <h2 class="py-2 font-semibold">Dynamic Task Management for Maximum Productivity</h2>
                    <p> Revolutionize your dispatch operations with our real-time management platform that connects fleet managers and drivers through seamless communication and task coordination.</p>
                    <h2 class="py-2 font-semibold">Dispatch System Features: </h2>
                    <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Live Task Allocation: </span> Assign and manage tasks in real-time with drag-and-drop simplicity.</li>
                        <li><span class="text-[#7a37b3] font-medium">Driver Communication:</span> Integrated messaging system with read receipts and response tracking.</li>
                        <li><span class="text-[#7a37b3] font-medium">Progress Monitoring:</span> Real-time updates on task status and completion estimates.</li>
                        <li><span class="text-[#7a37b3] font-medium">Route Optimization: </span> Intelligent route planning considering traffic, weather, and priorities.</li>
                        <li><span class="text-[#7a37b3] font-medium">Performance Tracking: </span> Monitor dispatch efficiency and driver response times.</li>
                    </ul>
                    <h2 class="py-2 font-semibold" >Mobile Capabilities:</h2>
                        <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Driver App: </span> Comprehensive mobile application for task management and communication.</li>
                        <li><span class="text-[#7a37b3] font-medium">GPS Integration:</span> Real-time location sharing and ETA calculations.</li>
                        <li><span class="text-[#7a37b3] font-medium">Digital Documentation: </span> photos, barcodes, qr codes, voices and notes directly through the app.</li>
                        <li><span class="text-[#7a37b3] font-medium">Offline Functionality: </span> Continue working without internet connection with automatic sync.</li>
                    </ul>
                    <h2 class="py-2 font-semibold">Efficiency Gains:</h2>
                    Companies using our dispatch system report 45% faster response times and 30% reduction in communication errors.',
                'btn_text' => 'Enhance Your Dispatch Operations',
                'btn_href' => '/solutions/dispatch-system',
                'meta_description' => 'Revolutionize your dispatch operations with our real-time management platform that connects fleet managers and drivers through seamless communication and task coordination.',
                'sort_number' => 6,
                'promotion_text' => 'Real-time dispatch & team coordination.',
                'image_url' => '/assets/solutions/img_2.jpg',
                'promotion_image_url' => '/assets/solutions/dispatch.svg'
            ],
            [
                'name' => 'API Services',
                'short_description' => 'Extend the power of our platform through our robust API services that enable seamless integration with your existing business systems and workflows.',
                'long_description' => '
                <h2 class="text-[#7a37b3] font-medium text-xl py-2">API Integration Services</h2>

                  <h2 class="font-semibold">Seamless System Integration for Unified Operations</h2>
                        <p>Extend the power of our platform through our robust API services that enable seamless integration with your existing business systems and workflows.</p>
                        <h2 class="py-2 font-semibold">API Services Features: </h2>
                    <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">RESTful API: </span> Modern, standards-based API for easy integration.</li>
                        <li><span class="text-[#7a37b3] font-medium">Comprehensive Documentation:</span> Detailed guides and examples for developers.</li>
                        <li><span class="text-[#7a37b3] font-medium">Webhooks Support:</span> Real-time data for immediate system updates.</li>
                        <li><span class="text-[#7a37b3] font-medium">Custom Development: </span> Tailored integration solutions for unique requirements.</li>
                        <li><span class="text-[#7a37b3] font-medium">Testing Environment:  </span> Sandbox setup for development and testing.</li>
                    </ul>
                    <h2 class="py-2 font-semibold" >Integration Capabilities:</h2>
                        <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">ERP Systems & Accounting Software: </span> Complete API catalog available.</li>
                        <li><span class="text-[#7a37b3] font-medium">Custom Applications: </span>  Connect with proprietary systems and applications.</li>
                        <li><span class="text-[#7a37b3] font-medium">Third-Party Services: </span>  Integration with mapping, weather, and traffic services.</li>
                    </ul>

                    <h2 class="font-semibold" >Supported Data Exchange:</h2>
                        <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Real-Time Location: </span> Live vehicle positions and status updates.</li>
                        <li><span class="text-[#7a37b3] font-medium">Historical Data: </span>  Complete historical information for analysis and reporting.</li>
                        <li><span class="text-[#7a37b3] font-medium">Maintenance Information: </span> Vehicle health data and service requirements.</li>
                        <li><span class="text-[#7a37b3] font-medium">Financial Data: </span> Cost information and operational metrics.</li>
                    </ul>
                    <h2 class="py-3 font-semibold" >Implementation Support:</h2>
                        <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Technical Consulting:</span> Expert guidance on integration strategies.</li>
                        <li><span class="text-[#7a37b3] font-medium">Development Resources: </span>  Sample code and implementation examples.</li>
                        <li><span class="text-[#7a37b3] font-medium">Ongoing Maintenance: </span> Continuous support and updates for integrated systems.</li>
                    </ul>',
                'btn_text' => 'Explore Integration Possibilities',
                'btn_href' => '/solutions/api-services',
                'meta_description' => 'Extend the power of our platform through our robust API services that enable seamless integration with your existing business systems and workflows.',
                'sort_number' => 6,
                'promotion_text' => 'Seamless API integration for your systems.',
                'image_url' => '/assets/solutions/img_5.png',
                'promotion_image_url' => '/assets/solutions/api-services.svg'
            ],
            [
                'name' => 'Fleet Surveillance Solution',
                'short_description' => 'Our advanced surveillance solution combines video monitoring, telematics, and behavioral analytics to provide unprecedented visibility into vehicle operations and driver behavior.',
                'long_description' => '
                <h2 class="text-[#7a37b3] font-medium text-xl py-2">Fleet Surveillance Solution</h2>
                  <h2 class="py-2 font-semibold">Comprehensive Monitoring for Enhanced Security and Safety</h2>
                        <p>Our advanced surveillance solution combines video monitoring, telematics, and behavioral analytics to provide unprecedented visibility into vehicle operations and driver behavior.</p>
                        <h2 class="py-2 font-semibold">Surveillance Features: </h2>
                    <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Live Video Streaming: </span> Real-time video monitoring from multiple camera angles.</li>
                        <li><span class="text-[#7a37b3] font-medium">Event Recording: </span> Automatic recording based on triggers like harsh braking or impact.</li>
                        <li><span class="text-[#7a37b3] font-medium">Driver Monitoring: </span> AI-powered analysis of driver behavior and attention.</li>
                        <li><span class="text-[#7a37b3] font-medium">Environmental Sensing: </span> Monitor cargo conditions and vehicle environment.</li>
                        <li><span class="text-[#7a37b3] font-medium">Remote Intervention: </span> Capability for remote vehicle immobilization if needed.</li>
                    </ul>
                    <h2 class="py-2 font-semibold" >Security Enhancements:</h2>
                        <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Theft Prevention: </span> Multiple layers of security including immobilizers and alerts.</li>
                        <li><span class="text-[#7a37b3] font-medium">Cargo Protection: </span>  Monitoring of loading/unloading activities and cargo integrity.</li>
                        <li><span class="text-[#7a37b3] font-medium">Access Control: </span>  Driver identification and authorization systems.</li>
                        <li><span class="text-[#7a37b3] font-medium">Emergency Response: </span>  Panic buttons and automatic incident detection.</li>
                    </ul>

                   <h2 class="py-2 font-semibold">Analytics Capabilities:</h2>
                        <ul class="list-disc pl-5 space-y-2 text-body marker:text-[#7a37b3]">
                        <li><span class="text-[#7a37b3] font-medium">Behavior Analysis: </span>Pattern recognition for driver behavior assessment.</li>
                        <li><span class="text-[#7a37b3] font-medium">Risk Scoring: </span>  Automated risk assessment for drivers and routes.</li>
                        <li><span class="text-[#7a37b3] font-medium">Incident Reconstruction: </span> Detailed event recreation for accident analysis.</li>
                        <li><span class="text-[#7a37b3] font-medium">Compliance Monitoring: </span> Automated compliance checking against safety regulations.</li>
                    </ul>
                    <h2 class="py-2 font-semibold" >Safety Impact:</h2>
                        <p>
                        Organizations using our surveillance solution typically experience 50% reduction in safety incidents and 35% improvement in driver behavior scores.</p>',
                'btn_text' => 'Enhance Your Fleet Safety',
                'btn_href' => '/solutions/fleet-surveillance-solution',
                'meta_description' => 'Our advanced surveillance solution combines video monitoring, telematics, and behavioral analytics to provide unprecedented visibility into vehicle operations and driver behavior.',
                'sort_number' => 7,
                'promotion_text' => 'AI video analytics for safer fleets.',

                'image_url' => '/assets/solutions/img_5.png',
                'promotion_image_url' => '/assets/solutions/api-services.svg'

            ],
        ];

        foreach ($solutions as $solution) {
            $blobId = self::createBlob('Solution', $solution['image_url'])->id;
            $promotionBlobId = self::createBlob('Solution', $solution['promotion_image_url'])->id;


            // Insert into main table
            $solutionId = DB::table('solutions')->insertGetId([
                'slug'        => Str::slug($solution['name']),
                'btn_href'    => $solution['btn_href'],
                'is_hidden'   => 0,
                'sort_number' => $solution['sort_number'],
                'blob_id' => $blobId,
                'promotion_blob_id' => $promotionBlobId,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // Insert translations (assuming 3 languages: English=1, French=2, Arabic=3)
            foreach ([1, 2, 3] as $langId) {
                DB::table('solution_languages')->insert([
                    'solution_id'     => $solutionId,
                    'language_id'      => $langId,
                    'name'             => $solution['name'],
                    'short_description'=> $solution['short_description'],
                    'long_description' => $solution['long_description'],
                    'btn_text'         => $solution['btn_text'],
                    'meta_description' => $solution['meta_description'],
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('content_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('breadcrumb_title')->nullable();
            $table->string('breadcrumb_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->longText('content')->nullable();
            $table->json('sections')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        DB::table('content_pages')->insert([
            ['slug'=>'about-us','title'=>'About Aventaro','breadcrumb_title'=>'About Us','meta_title'=>'About Aventaro','meta_description'=>'Learn about Aventaro and our promise to travellers.','content'=>'We create memorable journeys with trusted local experts, flexible booking, and thoughtful service.','sections'=>json_encode(['promise_title'=>'Quality, service, and memorable travel','promises'=>['Trusted local travel experts','Flexible, hassle-free bookings','Real-time itinerary updates'],'counters'=>[['value'=>'10+','label'=>'Years of experience'],['value'=>'50+','label'=>'Destinations'],['value'=>'5K+','label'=>'Happy travellers'],['value'=>'100+','label'=>'Curated tours']],'show_destinations'=>true,'show_team'=>true,'show_app'=>true,'app_title'=>'Plan your next journey with Aventaro','app_text'=>'Browse tours, save ideas, and keep your travel plans close.','show_news'=>true]),'is_active'=>true,'created_at'=>$now,'updated_at'=>$now],
            ['slug'=>'faq','title'=>'Frequently Asked Questions','breadcrumb_title'=>'FAQ','meta_title'=>'Travel FAQs','meta_description'=>'Answers to common booking and travel questions.','content'=>'Find quick answers about tours, bookings, payments, and cancellations.','sections'=>json_encode(['faqs'=>[['question'=>'How do I book a tour?','answer'=>'Choose a tour, select your travel date and group size, then submit the booking form.'],['question'=>'Can I cancel a booking?','answer'=>'Yes. Open your booking confirmation page and use the cancellation option, subject to the tour policy.'],['question'=>'How will I receive confirmation?','answer'=>'We send confirmation to the email address supplied during booking.']]]),'is_active'=>true,'created_at'=>$now,'updated_at'=>$now],
            ['slug'=>'privacy-policy','title'=>'Privacy Policy','breadcrumb_title'=>'Privacy Policy','meta_title'=>'Privacy Policy','meta_description'=>'How Aventaro collects and uses personal information.','content'=>"We collect information you provide when making a booking, contacting us, or subscribing to updates. We use it to deliver requested services, communicate with you, improve the website, and meet legal obligations.\n\nWe do not sell personal information. We may share necessary data with travel providers and service partners who help fulfil your booking. Contact us to request access, correction, or deletion where applicable.",'sections'=>json_encode([]),'is_active'=>true,'created_at'=>$now,'updated_at'=>$now],
            ['slug'=>'terms','title'=>'Terms and Conditions','breadcrumb_title'=>'Terms and Conditions','meta_title'=>'Terms and Conditions','meta_description'=>'Terms governing Aventaro website and booking use.','content'=>"By using this website or submitting a booking, you agree to provide accurate information and follow the conditions shown for the selected tour. Availability and prices may change until a booking is confirmed.\n\nCancellation, refund, health, visa, and insurance responsibilities vary by tour. The specific booking terms presented for your trip form part of these conditions.",'sections'=>json_encode([]),'is_active'=>true,'created_at'=>$now,'updated_at'=>$now],
        ]);
    }

    public function down(): void { Schema::dropIfExists('content_pages'); }
};

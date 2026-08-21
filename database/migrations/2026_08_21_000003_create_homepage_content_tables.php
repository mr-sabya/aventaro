<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('benefit_items', function(Blueprint $t){$t->id();$t->string('title');$t->string('icon')->nullable();$t->unsignedInteger('sort_order')->default(0);$t->boolean('is_active')->default(true);$t->timestamps();});
        Schema::create('team_members', function(Blueprint $t){$t->id();$t->string('name');$t->string('role');$t->string('image');$t->string('facebook_url')->nullable();$t->string('twitter_url')->nullable();$t->string('instagram_url')->nullable();$t->unsignedInteger('sort_order')->default(0);$t->boolean('is_active')->default(true);$t->timestamps();});
        Schema::create('travel_categories', function(Blueprint $t){$t->id();$t->string('name');$t->string('icon_image');$t->unsignedInteger('tour_count')->default(0);$t->decimal('starting_price',10,2)->default(0);$t->string('url')->nullable();$t->unsignedInteger('sort_order')->default(0);$t->boolean('is_active')->default(true);$t->timestamps();});
        Schema::create('promo_banners', function(Blueprint $t){$t->id();$t->string('subtitle');$t->string('title');$t->string('button_text');$t->string('button_url');$t->string('background_image');$t->boolean('is_active')->default(true);$t->timestamps();});
        Schema::create('testimonials', function(Blueprint $t){$t->id();$t->string('name');$t->string('location')->nullable();$t->text('quote');$t->string('image')->nullable();$t->unsignedTinyInteger('rating')->default(5);$t->unsignedInteger('sort_order')->default(0);$t->boolean('is_active')->default(true);$t->timestamps();});
        Schema::create('news_posts', function(Blueprint $t){$t->id();$t->string('title');$t->string('slug')->unique();$t->string('author')->default('Admin');$t->text('excerpt');$t->longText('content')->nullable();$t->string('image');$t->timestamp('published_at')->nullable()->index();$t->boolean('is_active')->default(true);$t->timestamps();});
        Schema::create('app_promotions', function(Blueprint $t){$t->id();$t->string('subtitle')->nullable();$t->string('title');$t->text('description')->nullable();$t->string('background_image')->nullable();$t->string('app_image')->nullable();$t->string('play_store_url')->nullable();$t->string('app_store_url')->nullable();$t->boolean('is_active')->default(true);$t->timestamps();});
    }
    public function down(): void { foreach(['app_promotions','news_posts','testimonials','promo_banners','travel_categories','team_members','benefit_items'] as $table) Schema::dropIfExists($table); }
};

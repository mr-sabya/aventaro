<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_categories',function(Blueprint $t){$t->id();$t->string('name');$t->string('slug')->unique();$t->text('description')->nullable();$t->timestamps();});
        Schema::create('news_tags',function(Blueprint $t){$t->id();$t->string('name');$t->string('slug')->unique();$t->timestamps();});
        Schema::table('news_posts',function(Blueprint $t){$t->foreignId('news_category_id')->nullable()->after('id')->constrained('news_categories')->nullOnDelete();$t->enum('status',['draft','published'])->default('draft')->after('is_active')->index();$t->unsignedBigInteger('view_count')->default(0)->after('status');});
        Schema::create('news_post_tag',function(Blueprint $t){$t->foreignId('news_post_id')->constrained()->cascadeOnDelete();$t->foreignId('news_tag_id')->constrained()->cascadeOnDelete();$t->primary(['news_post_id','news_tag_id']);});
        DB::table('news_posts')->where('is_active',true)->update(['status'=>'published']);
    }
    public function down(): void
    {
        Schema::dropIfExists('news_post_tag');
        Schema::table('news_posts',function(Blueprint $t){$t->dropForeign(['news_category_id']);$t->dropColumn(['news_category_id','status','view_count']);});
        Schema::dropIfExists('news_tags');Schema::dropIfExists('news_categories');
    }
};

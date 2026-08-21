<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up():void
    {
        Schema::table('team_members',function(Blueprint $t){$t->string('slug')->nullable()->unique()->after('name');$t->text('bio')->nullable()->after('role');$t->string('email')->nullable()->after('bio');$t->string('phone',40)->nullable()->after('email');$t->string('experience')->nullable()->after('phone');});
        DB::table('team_members')->orderBy('id')->get()->each(fn($member)=>DB::table('team_members')->where('id',$member->id)->update(['slug'=>Str::slug($member->name).'-'.$member->id]));
        Schema::table('testimonials',fn(Blueprint $t)=>$t->boolean('is_approved')->default(false)->after('is_active')->index());
        DB::table('testimonials')->where('is_active',true)->update(['is_approved'=>true]);
    }
    public function down():void {Schema::table('testimonials',fn(Blueprint $t)=>$t->dropColumn('is_approved'));Schema::table('team_members',function(Blueprint $t){$t->dropUnique(['slug']);$t->dropColumn(['slug','bio','email','phone','experience']);});}
};

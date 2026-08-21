<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $now=now();
        DB::table('footer_links')->insert([
            ['group_name'=>'Information','label'=>'About Us','url'=>'/about-us','sort_order'=>1,'is_active'=>true,'created_at'=>$now,'updated_at'=>$now],
            ['group_name'=>'Information','label'=>'FAQ','url'=>'/faq','sort_order'=>2,'is_active'=>true,'created_at'=>$now,'updated_at'=>$now],
            ['group_name'=>'Legal','label'=>'Privacy Policy','url'=>'/privacy-policy','sort_order'=>1,'is_active'=>true,'created_at'=>$now,'updated_at'=>$now],
            ['group_name'=>'Legal','label'=>'Terms & Conditions','url'=>'/terms-and-conditions','sort_order'=>2,'is_active'=>true,'created_at'=>$now,'updated_at'=>$now],
        ]);
    }
    public function down(): void { DB::table('footer_links')->whereIn('url',['/about-us','/faq','/privacy-policy','/terms-and-conditions'])->delete(); }
};

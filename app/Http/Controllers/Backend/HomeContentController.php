<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AppPromotion;
use App\Models\BenefitItem;
use App\Models\PromoBanner;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\TravelCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeContentController extends Controller
{
    private function config(): array
    {
        return [
            'benefits'=>['label'=>'Benefit Ticker','model'=>BenefitItem::class,'fields'=>['title'=>'text','icon'=>'image','sort_order'=>'number']],
            'team'=>['label'=>'Tour Guides','model'=>TeamMember::class,'fields'=>['name'=>'text','role'=>'text','bio'=>'textarea','email'=>'text','phone'=>'text','experience'=>'text','image'=>'image','facebook_url'=>'url','twitter_url'=>'url','instagram_url'=>'url','sort_order'=>'number']],
            'categories'=>['label'=>'Travel Inspirations','model'=>TravelCategory::class,'fields'=>['name'=>'text','icon_image'=>'image','tour_count'=>'number','starting_price'=>'number','url'=>'text','sort_order'=>'number']],
            'promos'=>['label'=>'Promotional Banners','model'=>PromoBanner::class,'fields'=>['subtitle'=>'text','title'=>'text','button_text'=>'text','button_url'=>'text','background_image'=>'image']],
            'testimonials'=>['label'=>'Testimonials','model'=>Testimonial::class,'fields'=>['name'=>'text','location'=>'text','quote'=>'textarea','image'=>'image','rating'=>'number','sort_order'=>'number','is_approved'=>'checkbox']],
            'app-promotions'=>['label'=>'App Promotion','model'=>AppPromotion::class,'fields'=>['subtitle'=>'text','title'=>'text','description'=>'textarea','background_image'=>'image','app_image'=>'image','play_store_url'=>'url','app_store_url'=>'url']],
        ];
    }

    public function index()
    {
        $sections=[];
        foreach($this->config() as $key=>$config) $sections[$key]=$config+['records'=>$config['model']::query()->orderBy('id')->get()];
        return view('backend.home-content.index',compact('sections'));
    }

    public function save(Request $request,string $type,?int $id=null)
    {
        $config=$this->config()[$type]??abort(404);
        $model=$id?$config['model']::findOrFail($id):new $config['model'];
        $rules=[];
        foreach($config['fields'] as $field=>$kind){
            $nullable=in_array($field,['icon','facebook_url','twitter_url','instagram_url','location','image','content','subtitle','description','background_image','app_image','play_store_url','app_store_url','url','published_at','bio','email','phone','experience','is_approved'],true);
            $rules[$field]=match($kind){'image'=>[($model->exists||$nullable)?'nullable':'required','image','max:4096'],'url'=>['nullable','url','max:500'],'number'=>[$nullable?'nullable':'required','numeric','min:0'],'checkbox'=>['nullable','boolean'],'datetime-local'=>['nullable','date'],default=>[$nullable?'nullable':'required','string','max:'.($kind==='textarea'?5000:500)]};
        }
        $data=$request->validate($rules);
        foreach($config['fields'] as $field=>$kind) if($kind==='image') { if($request->hasFile($field)){if($model->$field)Storage::disk('public')->delete($model->$field);$data[$field]=$request->file($field)->store('homepage/'.$type,'public');}else unset($data[$field]); }
        foreach($config['fields'] as $field=>$kind) if($kind==='checkbox') $data[$field]=$request->boolean($field);
        $data['is_active']=$request->boolean('is_active');
        $model->fill($data)->save();
        return back()->with('message',$config['label'].' saved.');
    }

    public function delete(string $type,int $id)
    {
        $config=$this->config()[$type]??abort(404);$model=$config['model']::findOrFail($id);
        foreach($config['fields'] as $field=>$kind)if($kind==='image'&&$model->$field)Storage::disk('public')->delete($model->$field);
        $model->delete();return back()->with('message',$config['label'].' item deleted.');
    }
}

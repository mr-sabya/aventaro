<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\FooterGallery;
use App\Models\FooterLink;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class SiteSettingController extends Controller
{
 public function index(){return view('backend.site-settings.index',['settings'=>SiteSetting::firstOrNew(['id'=>1]),'links'=>FooterLink::orderBy('group_name')->orderBy('sort_order')->get(),'gallery'=>FooterGallery::orderBy('sort_order')->get()]);}
 public function update(Request $r){$settings=SiteSetting::firstOrNew(['id'=>1]);$data=$r->validate(['site_name'=>'required|string|max:120','tagline'=>'nullable|string|max:255','logo'=>'nullable|image|max:4096','favicon'=>'nullable|image|max:2048','phone'=>'nullable|string|max:40','email'=>'nullable|email|max:255','address'=>'nullable|string|max:1000','facebook_url'=>'nullable|url|max:500','instagram_url'=>'nullable|url|max:500','twitter_url'=>'nullable|url|max:500','linkedin_url'=>'nullable|url|max:500','header_button_text'=>'nullable|string|max:120','header_button_url'=>'nullable|string|max:500','newsletter_title'=>'nullable|string|max:255','footer_about_title'=>'nullable|string|max:120','copyright_text'=>'nullable|string|max:500','play_store_url'=>'nullable|url|max:500','app_store_url'=>'nullable|url|max:500']);foreach(['logo','favicon'] as $field){if($r->hasFile($field)){if($settings->$field)Storage::disk('public')->delete($settings->$field);$data[$field]=$r->file($field)->store('site','public');}else unset($data[$field]);}$settings->fill($data)->save();return back()->with('message','Site settings updated.');}
 public function saveLink(Request $r,?FooterLink $link=null){$link??=new FooterLink;$data=$r->validate(['group_name'=>'required|string|max:100','label'=>'required|string|max:120','url'=>'required|string|max:500','sort_order'=>'required|integer|min:0']);$link->fill($data+['is_active'=>$r->boolean('is_active')])->save();return back()->with('message','Footer link saved.');}
 public function deleteLink(FooterLink $link){$link->delete();return back()->with('message','Footer link deleted.');}
 public function saveGallery(Request $r,?FooterGallery $gallery=null){$gallery??=new FooterGallery;$data=$r->validate(['image'=>[$gallery->exists?'nullable':'required','image','max:4096'],'url'=>'nullable|string|max:500','alt_text'=>'nullable|string|max:255','sort_order'=>'required|integer|min:0']);if($r->hasFile('image')){if($gallery->image)Storage::disk('public')->delete($gallery->image);$data['image']=$r->file('image')->store('footer-gallery','public');}else unset($data['image']);$gallery->fill($data+['is_active'=>$r->boolean('is_active')])->save();return back()->with('message','Gallery image saved.');}
 public function deleteGallery(FooterGallery $gallery){Storage::disk('public')->delete($gallery->image);$gallery->delete();return back()->with('message','Gallery image deleted.');}
}

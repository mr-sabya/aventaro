<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use App\Models\NewsPost;
use App\Models\NewsTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Support\OptimizedImage;

class NewsController extends Controller
{
    public function index(){return view('backend.news.index',['posts'=>NewsPost::with('category')->latest()->paginate(15),'categories'=>NewsCategory::withCount('posts')->orderBy('name')->get(),'tags'=>NewsTag::withCount('posts')->orderBy('name')->get()]);}
    public function create(){return $this->form(new NewsPost);}
    public function edit(NewsPost $post){$post->load('tags');return $this->form($post);}
    private function form(NewsPost $post){return view('backend.news.form',['post'=>$post,'categories'=>NewsCategory::orderBy('name')->get(),'tags'=>NewsTag::orderBy('name')->get()]);}
    public function store(Request $request){return $this->persist($request,new NewsPost);}
    public function update(Request $request,NewsPost $post){return $this->persist($request,$post);}
    private function persist(Request $request,NewsPost $post)
    {
        $data=$request->validate(['news_category_id'=>['nullable','exists:news_categories,id'],'title'=>['required','string','max:255',Rule::unique('news_posts','title')->ignore($post->id)],'author'=>['required','string','max:120'],'excerpt'=>['required','string','max:1000'],'content'=>['required','string'],'image'=>[$post->exists?'nullable':'required','image','mimes:jpg,jpeg,png,webp','max:4096'],'image_alt'=>['nullable','string','max:255'],'status'=>['required','in:draft,published'],'published_at'=>['nullable','date'],'tags'=>['nullable','array'],'tags.*'=>['integer','exists:news_tags,id']]);
        if($data['status']==='published'&&!$data['published_at'])$data['published_at']=now();
        $data['is_active']=$data['status']==='published';
        if($request->hasFile('image')){if($post->image)Storage::disk('public')->delete($post->image);$data['image']=OptimizedImage::store($request->file('image'),'news');}
        $tags=$data['tags']??[];unset($data['tags']);$post->fill($data)->save();$post->tags()->sync($tags);
        return redirect()->route('admin.news.index')->with('message','Article saved.');
    }
    public function destroy(NewsPost $post){if($post->image)Storage::disk('public')->delete($post->image);$post->delete();return back()->with('message','Article deleted.');}
    public function saveTaxonomy(Request $request,string $type,?int $id=null)
    {
        abort_unless(in_array($type,['category','tag']),404);$class=$type==='category'?NewsCategory::class:NewsTag::class;$model=$id?$class::findOrFail($id):new $class;
        $data=$request->validate(['name'=>['required','string','max:120',Rule::unique($model->getTable(),'name')->ignore($model->id)],'description'=>['nullable','string','max:1000']]);
        if($type==='tag')unset($data['description']);$model->fill($data)->save();return back()->with('message',ucfirst($type).' saved.');
    }
    public function deleteTaxonomy(string $type,int $id){abort_unless(in_array($type,['category','tag']),404);$class=$type==='category'?NewsCategory::class:NewsTag::class;$class::findOrFail($id)->delete();return back()->with('message',ucfirst($type).' deleted.');}
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use App\Models\NewsPost;
use App\Models\NewsTag;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    //
    public function index(Request $request)
    {
        $filters=$request->validate(['search'=>['nullable','string','max:100'],'category'=>['nullable','string','max:150'],'tag'=>['nullable','string','max:150']]);
        $posts=NewsPost::query()->published()->with(['category','tags'])
            ->when($filters['search']??null,fn($q,$term)=>$q->where(fn($inner)=>$inner->where('title','like',"%{$term}%")->orWhere('excerpt','like',"%{$term}%")->orWhere('content','like',"%{$term}%")))
            ->when($filters['category']??null,fn($q,$slug)=>$q->whereHas('category',fn($category)=>$category->where('slug',$slug)))
            ->when($filters['tag']??null,fn($q,$slug)=>$q->whereHas('tags',fn($tag)=>$tag->where('slug',$slug)))
            ->latest('published_at')->paginate(8)->withQueryString();
        return view('frontend.news.index',['posts'=>$posts,'popularPosts'=>NewsPost::published()->orderByDesc('view_count')->limit(5)->get(),'latestPosts'=>NewsPost::published()->latest('published_at')->limit(5)->get(),'categories'=>NewsCategory::withCount(['posts'=>fn($q)=>$q->published()])->orderBy('name')->get(),'tags'=>NewsTag::whereHas('posts',fn($q)=>$q->published())->orderBy('name')->get()]);
    }

    public function show(NewsPost $post)
    {
        abort_unless($post->is_active&&$post->status==='published'&&$post->published_at?->lte(now()),404);
        $post->increment('view_count');$post->load(['category','tags']);
        $related=NewsPost::published()->where('id','!=',$post->id)->when($post->news_category_id,fn($q)=>$q->where('news_category_id',$post->news_category_id))->latest('published_at')->limit(3)->get();
        return view('frontend.news.show',compact('post','related'));
    }
}

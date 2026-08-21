<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContentPageController extends Controller
{
    public function index() { return view('backend.content-pages.index', ['pages'=>ContentPage::orderBy('title')->get()]); }
    public function edit(ContentPage $page) { return view('backend.content-pages.edit', compact('page')); }
    public function update(Request $request, ContentPage $page): RedirectResponse
    {
        $data = $request->validate(['title'=>'required|max:255','breadcrumb_title'=>'nullable|max:255','breadcrumb_image'=>'nullable|image|max:3072','meta_title'=>'nullable|max:255','meta_description'=>'nullable|max:500','content'=>'nullable|string','sections'=>'nullable|json','is_active'=>'nullable|boolean']);
        if ($request->hasFile('breadcrumb_image')) $data['breadcrumb_image']=$request->file('breadcrumb_image')->store('pages','public');
        $data['sections'] = json_decode($data['sections'] ?? '[]', true);
        $data['is_active'] = $request->boolean('is_active');
        $page->update($data);
        return back()->with('success','Page updated successfully.');
    }
}

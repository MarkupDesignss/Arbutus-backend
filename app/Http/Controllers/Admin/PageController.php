<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('id','desc')->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:pages,title',
            'meta_tags' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);

        $validated['slug'] = Str::slug($request->title, '_');

        Page::create($validated);

        return redirect()->route('admin.pages.list')->with('success', 'Page created successfully!');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:pages,title,'.$page->id,
            'meta_tags' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);

        $validated['slug'] = Str::slug($request->title, '_');

        $page->update($validated);

        return redirect()->route('admin.pages.list')->with('success', 'Page updated successfully!');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->route('admin.pages.list')->with('success', 'Page deleted successfully!');
    }

    public function show($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.view', compact('page'));
    }
}

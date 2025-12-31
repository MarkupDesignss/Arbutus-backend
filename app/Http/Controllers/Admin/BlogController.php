<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $query = Blog::orderBy('id', 'desc');
        $data['blogs'] = $query->paginate(10)->withQueryString();
        return view('admin.blogs.index', $data);
    }

    public function create()
    {
        return view('admin.blogs.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|max:255',
            'author_name'        => 'required|string|max:255',
            'post_date' => 'required|date',
            'status'      => 'required|in:0,1', 
            'short_description' => 'required|string', 
            'long_description' => 'nullable|string', 
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:10240', // 10MB
        ]);

        $image = time().'.'.$request->image->extension();
        $request->image->storeAs('blogs', $image, 'public');

        Blog::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'author_name' => $request->author_name,
            'post_date' => $request->post_date,
            'image' => $image,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('admin.blog.list')->with('success','Blog Added Successfully!');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit',compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:blogs,slug,' . $id,
            'author_name' => 'required|string|max:255',
            'post_date'   => 'required|date',
            'status'      => 'required|in:0,1',
            'short_description' => 'required|string',
            'long_description'  => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        if ($request->hasFile('image')) {
            $image = time().'.'.$request->image->extension();
            $request->image->storeAs('blogs', $image, 'public');
            $blog->image = $image;
        }

        $blog->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'author_name' => $request->author_name,
            'post_date' => $request->post_date,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.blog.list')->with('success','Blog Updated Successfully!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image && \Storage::disk('public')->exists('blogs/'.$blog->image)) {
            \Storage::disk('public')->delete('blogs/'.$blog->image);
        }

        $blog->delete();

        return redirect()->route('admin.blog.list')->with('success','Blog Deleted Successfully!');
    }
    
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.view', compact('blog'));
    }

   
}


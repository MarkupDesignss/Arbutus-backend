<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Banner::orderBy('id', 'desc');
        $data['banners'] = $query->paginate(10)->withQueryString();
        return view('admin.banners.index', $data);
    }

    public function create()
    {
        return view('admin.banners.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'nullable|string|max:255',
            'status'      => 'required|in:0,1', 
            'description' => 'nullable|string', 
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:10240', // 10MB
        ]);

        $image = time().'.'.$request->image->extension();
        $request->image->storeAs('banners', $image, 'public');

        Banner::create([
            'title' => $request->title,
            'image' => $image,
            'description' => $request->description,
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('admin.banner.list')->with('success','Banner Added Successfully!');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        if($request->hasFile('image')){
            $request->validate([
                'image' => 'image|mimes:jpg,jpeg,png,webp|max:10240',
            ]);

            Storage::disk('public')->delete('banners/'.$banner->image);
            $name = time().'.'.$request->image->extension();
            $request->image->storeAs('banners', $name, 'public');
            $banner->image = $name;
        }

        $banner->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('admin.banner.list')->with('success','Banner Updated Successfully!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        Storage::disk('public')->delete('banners/'.$banner->image);
        $banner->delete();
        return back()->with('success','Banner Deleted Successfully!');
    }
    public function show($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.view', compact('banner'));
    }
}

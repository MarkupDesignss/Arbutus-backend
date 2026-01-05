<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OurValue;

class OurValueController extends Controller
{
    public function index()
    {
        $query = OurValue::orderBy('id', 'desc');
        $data['values'] = $query->paginate(10)->withQueryString();
        return view('admin.our-values.index', $data);
    }

    public function create()
    {
        return view('admin.our-values.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'status'      => 'required|in:0,1', 
            'short_description' => 'required|string', 
            'long_description' => 'nullable|string', 
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:10240', // 10MB
        ]);

        $image = time().'.'.$request->image->extension();
        $request->image->storeAs('values', $image, 'public');

        OurValue::create([
            'title' => $request->title,
            'image' => $image,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('admin.value.list')->with('success','Our Value Added Successfully!');
    }

    public function edit($id)
    {
        $value = OurValue::findOrFail($id);
        return view('admin.our-values.edit',compact('value'));
    }

    public function update(Request $request, $id)
    {
        $value = OurValue::findOrFail($id);

        $request->validate([
            'title'              => 'required|string|max:255',
            'status'             => 'required|in:0,1',
            'short_description'  => 'required|string',
            'long_description'   => 'nullable|string',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        if ($request->hasFile('image')) {

            // ✅ delete old image
            if (
                $value->image &&
                \Storage::disk('public')->exists('values/' . $value->image)
            ) {
                \Storage::disk('public')->delete('values/' . $value->image);
            }

            // upload new image
            $image = time() . '.' . $request->image->extension();
            $request->image->storeAs('values', $image, 'public');

            $value->image = $image;
        }

        $value->update([
            'title'             => $request->title,
            'short_description' => $request->short_description,
            'long_description'  => $request->long_description,
            'status'            => $request->status,
        ]);

        return redirect()
            ->route('admin.value.list')
            ->with('success', 'Our Value Updated Successfully!');
    }

    public function destroy($id)
    {
        $value = OurValue::findOrFail($id);

        if ($value->image && \Storage::disk('public')->exists('values/'.$value->image)) {
            \Storage::disk('public')->delete('values/'.$value->image);
        }

        $value->delete();

        return redirect()->route('admin.value.list')->with('success','Our Value Deleted Successfully!');
    }
    
    public function show($id)
    {
        $value = OurValue::findOrFail($id);
        return view('admin..our-values.view', compact('value'));
    }  
}
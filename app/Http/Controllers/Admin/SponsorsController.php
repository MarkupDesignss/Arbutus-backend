<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sponsors;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SponsorsController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Sponsors::orderBy('id', 'desc');
        $data['sponsors'] = $query->paginate(10)->withQueryString();
        return view('admin.sponsors.index', $data);
    }

    public function create()
    {
        return view('admin.sponsors.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:10240', // 10MB
            'status'      => 'required|in:0,1',            
        ]);

        $image = time().'.'.$request->image->extension();
        $request->image->storeAs('sponsors', $image, 'public');

        Sponsors::create([
            'image' => $image,
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('admin.sponsors.list')->with('success','Sponsors Added Successfully!');
    }

    public function edit($id)
    {
        $sponsors = Sponsors::findOrFail($id);
        return view('admin.sponsors.edit', compact('sponsors'));
    }

    public function update(Request $request, $id)
    {
        $sponsors = Sponsors::findOrFail($id);

        if($request->hasFile('image')){
            $request->validate([
                'image' => 'image|mimes:jpg,jpeg,png,webp|max:10240',
            ]);

            Storage::disk('public')->delete('sponsors/'.$ponsors->image);
            $name = time().'.'.$request->image->extension();
            $request->image->storeAs('sponsors', $name, 'public');
            $ponsors->image = $name;
        }

        $sponsors->update([
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('admin.sponsors.list')->with('success','Sponsors Updated Successfully!');
    }

    public function destroy($id)
    {
        $sponsors = Sponsors::findOrFail($id);
        Storage::disk('public')->delete('sponsors/'.$sponsors->image);
        $sponsors->delete();
        return back()->with('success','Sponsors Deleted Successfully!');
    }
    
}
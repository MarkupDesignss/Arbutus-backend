<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsLetter;

class NewsLetterController extends Controller
{
    public function index(Request $request)
     {
          $query = NewsLetter::orderBy('id', 'desc');
          $data['newsletters'] = $query->paginate(10)->withQueryString();
          return view('admin.newsletters.index', $data);
     }
    
     public function destroy($id)
     {
          $newsletter = NewsLetter::findOrFail($id);
          $newsletter->delete();
          return redirect()->route('admin.newsletter-subscribe.list')->with('success', 'Newsletter subscription deleted successfully.');
     }  
}

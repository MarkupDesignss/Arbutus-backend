<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
   public function index(Request $request)
    {
        $query = Contact::orderBy('id', 'desc');
        $data['contacts'] = $query->paginate(10)->withQueryString();
        return view('admin.contacts.index', $data);
    }

    public function show($id)
    {
        $data['contact'] = Contact::findOrFail($id);
        return view('admin.contacts.view', $data);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->route('admin.contact.list')->with('success', 'Contact deleted successfully.');
    }
}

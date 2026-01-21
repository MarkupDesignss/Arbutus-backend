<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::orderBy('id','desc');
        $data['users'] = $query->paginate(10)->withQueryString();
        return view('admin.auth-user.index',$data);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.auth.user.list')->with('success','Auth User deleted successfully!');
    }
}

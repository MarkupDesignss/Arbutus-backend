<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminPermission;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Admin::orderBy('id','desc');
        $data['users'] = $query->paginate(10)->withQueryString();
        return view('admin.user-management.index',$data);
    }

    public function create()
    {
        return view('admin.user-management.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email',
            'mobile'   => 'required|string|max:20',
            'password' => 'required|min:6',
            'role'     => 'required|in:administrator,data_manager,read_only',
            'status'   => 'required|in:0,1',
        ]);

        $user = new Admin();
        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->mobile  = $request->mobile;
        $user->password = Hash::make($request->password);
        $user->role   = $request->role;
        $user->status = $request->status;
        $user->save();

        if($request->permissions){
            foreach($request->permissions as $perm){
                AdminPermission::create([
                    'admin_id'=>$user->id,
                    'permission'=>$perm
                ]);
            }
        }

        return redirect()->route('admin.users.list')->with('success','User created successfully!');
    }

    public function edit($id)
    {
        $data['user'] = Admin::findOrFail($id);
        $data['permissions'] = AdminPermission::where('admin_id',$id)->pluck('permission')->toArray();
        return view('admin.user-management.edit',$data);
    }

    public function update(Request $request,$id)
    {
        $user = Admin::findOrFail($id);

        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => "required|email|unique:admins,email,$id",
            'role'   => 'required|in:administrator,data_manager,read_only',
            'status' => 'required|in:0,1',
        ]);

        $user->update($validated);

        if($request->password){
            $user->update(['password'=>Hash::make($request->password)]);
        }

        AdminPermission::where('admin_id',$id)->delete();

        if($request->permissions){
            foreach($request->permissions as $perm){
                AdminPermission::create([
                    'admin_id'=>$id,
                    'permission'=>$perm
                ]);
            }
        }

        return redirect()->route('admin.users.list')->with('success','User updated successfully!');
    }

    public function destroy($id)
    {
        Admin::findOrFail($id)->delete();
        return redirect()->route('admin.users.list')->with('success','User deleted successfully!');
    }
}

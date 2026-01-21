<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Fund;
use App\Models\UserSubscription;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function dashboard()
    {     
        $data['users'] = User::where('status', 1)->count();
        $data['funds'] = Fund::where('status', 1)->count();
        $data['contacts'] = Contact::count();
        $data['subscription'] = UserSubscription::where('status', 'active')->count();       
        return view('admin.dashboard', $data);
    }
}

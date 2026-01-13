<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanAccess;
use App\Models\Subscription;
use App\Models\AccessRule;

class PlanAccessController extends Controller
{
    public function index()
    {
        $plan_accesses = PlanAccess::with(['subscription','accessRule'])
            ->latest()->paginate(10);
        return view('admin.plan_accesses.index', compact('plan_accesses'));
    }

    public function create()
    {
        $subscriptions = Subscription::where('is_active',1)->get();
        $access_rules  = AccessRule::where('status',1)->get();
        return view('admin.plan_accesses.add', compact('subscriptions','access_rules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'access_rule_id'  => 'required|exists:access_rules,id',
            'status'          => 'required|in:0,1'
        ]);

        // Prevent duplicate mapping
        if(PlanAccess::where('subscription_id',$request->subscription_id)
            ->where('access_rule_id',$request->access_rule_id)->exists()){
            return back()->with('error','This access already exists for this plan.');
        }

        $map = new PlanAccess();
        $map->subscription_id = $request->subscription_id;
        $map->access_rule_id  = $request->access_rule_id;
        $map->status          = $request->status;
        $map->save();

        return redirect()->route('admin.plan.access.list')
            ->with('success','Plan Access added successfully.');
    }

    public function edit($id)
    {
        $plan_access  = PlanAccess::findOrFail($id);
        $subscriptions = Subscription::where('is_active',1)->get();
        $access_rules  = AccessRule::where('status',1)->get();
        return view('admin.plan_accesses.edit', compact('plan_access','subscriptions','access_rules'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'access_rule_id'  => 'required|exists:access_rules,id',
            'status'          => 'required|in:0,1'
        ]);

        $map = PlanAccess::findOrFail($id);
        $map->subscription_id = $request->subscription_id;
        $map->access_rule_id  = $request->access_rule_id;
        $map->status          = $request->status;
        $map->save();

        return redirect()->route('admin.plan.access.list')
            ->with('success','Plan Access updated successfully.');
    }

    public function show($id)
    {
        $plan_access = PlanAccess::with(['subscription','accessRule'])->findOrFail($id);
        return view('admin.plan_accesses.view', compact('plan_access'));
    }

    public function destroy($id)
    {
        PlanAccess::findOrFail($id)->delete();
        return redirect()->route('admin.plan.access.list')
            ->with('success','Plan Access deleted successfully.');
    }
}

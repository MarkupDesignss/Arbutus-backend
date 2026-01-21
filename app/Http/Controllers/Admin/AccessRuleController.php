<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessRule;
use Illuminate\Http\Request;

class AccessRuleController extends Controller
{
   
    public function index(Request $request)
    {
        $query = AccessRule::orderBy('id', 'desc');
        $data['access_rules'] = $query->paginate(10)->withQueryString();
        return view('admin.access_rules.index', $data);
    }

    public function create()
    {
        return view('admin.access_rules.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'module'    => 'required|string|max:255',
            'rule_type' => 'required|in:column,filter,feature',
            'rule_key'  => 'required|string|max:255',
            'label'     => 'required|string|max:255',
            'status'    => 'required|in:0,1',
        ]);

        $rule = new AccessRule();
        $rule->module    = $request->module;
        $rule->rule_type = $request->rule_type;
        $rule->rule_key  = $request->rule_key;
        $rule->label     = $request->label;
        $rule->status    = $request->status;
        $rule->save();

        return redirect()->route('admin.access.rule.list')
            ->with('success', 'Access Rule created successfully.');
    }

    public function edit($id)
    {
        $access_rule = AccessRule::findOrFail($id);
        return view('admin.access_rules.edit', compact('access_rule'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'module'    => 'required|string|max:255',
            'rule_type' => 'required|in:column,filter,feature',
            'rule_key'  => 'required|string|max:255',
            'label'     => 'required|string|max:255',
            'status'    => 'required|in:0,1',
        ]);

        $rule = AccessRule::findOrFail($id);
        $rule->module    = $request->module;
        $rule->rule_type = $request->rule_type;
        $rule->rule_key  = $request->rule_key;
        $rule->label     = $request->label;
        $rule->status    = $request->status;
        $rule->save();

        return redirect()->route('admin.access.rule.list')
            ->with('success', 'Access Rule updated successfully.');
    }

    public function show($id)
    {
        $access_rule = AccessRule::findOrFail($id);
        return view('admin.access_rules.view', compact('access_rule'));
    }

    public function destroy($id)
    {
        AccessRule::findOrFail($id)->delete();
        return redirect()->route('admin.access.rule.list')
            ->with('success', 'Access Rule deleted successfully.');
    }
}

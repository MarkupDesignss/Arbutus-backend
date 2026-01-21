<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscription::orderBy('id', 'desc');
        $data['subscriptions'] = $query->paginate(10)->withQueryString();
        return view('admin.subscriptions.index', $data);
    }

    public function create()
    {
        return view('admin.subscriptions.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subscriptions,name',
            'title' => 'nullable|string|max:255',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            'is_popular' => 'nullable|boolean',
            'features' => 'nullable',
            'is_active' => 'required|in:0,1',
        ]);

        if ($request->features) {
            $validated['features'] = json_encode($request->features);
        }

        Subscription::create($validated);

        return redirect()->route('admin.subscriptions.list')->with('success', 'Subscription created successfully!');
    }

    public function edit($id)
    {
        $data['subscription'] = Subscription::findOrFail($id);
        return view('admin.subscriptions.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subscriptions,name,' . $subscription->id,
            'title' => 'nullable|string|max:255',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            'is_popular' => 'nullable|boolean',
            'features' => 'nullable',
            'is_active' => 'required|in:0,1',
        ]);

        if ($request->features) {
            $validated['features'] = json_encode($request->features);
        }

        $subscription->update($validated);

        return redirect()->route('admin.subscriptions.list')->with('success', 'Subscription updated successfully!');
    }

    public function destroy($id)
    {
        Subscription::findOrFail($id)->delete();
        return redirect()->route('admin.subscriptions.list')->with('success', 'Subscription deleted successfully!');
    }

    // View single subscription
    public function show($id)
    {
        $subscription = Subscription::findOrFail($id);
        // Decode features JSON to array
        $subscription->features = json_decode($subscription->features, true) ?? [];
        return view('admin.subscriptions.view', compact('subscription'));
    }

}

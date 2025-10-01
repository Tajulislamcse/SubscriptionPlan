<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
     public function index()
    {

        return view('admin.settings.index');
    }

    public function store(Request $request)
    {
          $request->validate([
           'stripe_publishable_key' => 'required|string|max:255',
            'stripe_secret_key' => 'required|string|max:255',
        ]);

        $settings = [
            'stripe_publishable_key' => $request->stripe_publishable_key,
            'stripe_secret_key' => $request->stripe_secret_key,

        ];

        foreach ($settings as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}

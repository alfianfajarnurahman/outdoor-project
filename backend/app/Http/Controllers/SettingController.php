<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return response()->json($settings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:settings,key',
            'value' => 'nullable|string',
            'group' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $setting = Setting::create($validated);
        return response()->json($setting, 201);
    }

    public function show(Setting $setting)
    {
        return response()->json($setting);
    }

    public function update(Request $request, Setting $setting)
    {
        $validated = $request->validate([
            'key' => ['sometimes', 'string', 'max:255', Rule::unique('settings')->ignore($setting->id)],
            'value' => 'nullable|string',
            'group' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $setting->update($validated);
        return response()->json($setting);
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();
        return response()->json(null, 204);
    }

    // Opsional: ambil setting berdasarkan key (untuk frontend)
    public function getByKey($key)
    {
        $setting = Setting::where('key', $key)->first();
        if (!$setting) {
            return response()->json(['message' => 'Setting not found'], 404);
        }
        return response()->json($setting);
    }
}
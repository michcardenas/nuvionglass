<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHeroController extends Controller
{
    public function edit()
    {
        $hero = HeroSetting::getCurrent();

        return view('admin.hero.edit', compact('hero'));
    }

    public function update(Request $request)
    {
        $hero = HeroSetting::getCurrent();

        $data = $request->except(['_token', '_method', 'media_file', 'use_gradient', 'media_mode']);

        // Handle file upload
        if ($request->hasFile('media_file')) {
            // Delete previous file
            if ($hero->media_path) {
                Storage::disk('public')->delete($hero->media_path);
            }

            $file = $request->file('media_file');
            $ext = strtolower($file->getClientOriginalExtension());
            $data['media_type'] = in_array($ext, ['mp4', 'webm', 'mov']) ? 'video' : 'image';
            $data['media_path'] = $file->store('hero', 'public');
        }

        // If "use gradient" checkbox was checked, remove media and switch to gradient
        if ($request->use_gradient) {
            if ($hero->media_path) {
                Storage::disk('public')->delete($hero->media_path);
            }
            $data['media_type'] = 'gradient';
            $data['media_path'] = null;
        }

        // Trust items: convert textarea (one per line) to JSON array
        if ($request->has('trust_items')) {
            $items = array_filter(array_map('trim', explode("\n", $request->trust_items)));
            $data['trust_items'] = array_values($items);
        }

        $hero->update($data);

        return redirect()->route('admin.hero.edit')
            ->with('success', 'Hero actualizado correctamente.');
    }
}

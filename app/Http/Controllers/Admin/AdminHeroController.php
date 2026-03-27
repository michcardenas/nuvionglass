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

        $data = $request->except(['_token', '_method', 'media_file', 'use_gradient', 'media_mode', 'hero_images_files', 'hero_images_existing']);

        $mode = $request->input('media_mode');

        // Handle single file upload (video or image for background)
        if ($request->hasFile('media_file')) {
            if ($hero->media_path) {
                Storage::disk('public')->delete($hero->media_path);
            }

            $file = $request->file('media_file');
            $ext = strtolower($file->getClientOriginalExtension());
            $data['media_type'] = in_array($ext, ['mp4', 'webm', 'mov']) ? 'video' : 'image';
            $data['media_path'] = $file->store('hero', 'public');
        }

        // If mode is "image" and no single file uploaded but gallery images exist, set type to image
        if ($mode === 'image' && !$request->hasFile('media_file')) {
            $data['media_type'] = 'image';
        }

        // If mode is "video" and no file uploaded, keep current media_type
        if ($mode === 'video' && !$request->hasFile('media_file')) {
            $data['media_type'] = 'video';
        }

        // If "use gradient" checkbox was checked OR radio set to gradient, remove media
        if ($request->use_gradient || $mode === 'gradient') {
            if ($hero->media_path) {
                Storage::disk('public')->delete($hero->media_path);
            }
            $data['media_type'] = 'gradient';
            $data['media_path'] = null;
        }

        // Hero images gallery (multiple uploads)
        $existing = $request->input('hero_images_existing', []);
        $oldImages = $hero->hero_images ?? [];

        // Delete removed images from storage
        foreach ($oldImages as $oldImg) {
            if (!in_array($oldImg, $existing)) {
                Storage::disk('public')->delete($oldImg);
            }
        }

        // Upload new images
        $newPaths = [];
        if ($request->hasFile('hero_images_files')) {
            foreach ($request->file('hero_images_files') as $file) {
                $newPaths[] = $file->store('hero', 'public');
            }
        }

        // Merge existing + new, max 10
        $data['hero_images'] = array_slice(array_merge($existing, $newPaths), 0, 10);

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

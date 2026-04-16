<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LentesPageSetting;
use Illuminate\Http\Request;

class AdminLentesPageController extends Controller
{
    public function edit()
    {
        $page = LentesPageSetting::getCurrent();

        return view('admin.pages.lentes.edit', compact('page'));
    }

    public function update(Request $request)
    {
        $page = LentesPageSetting::getCurrent();

        $data = $request->except(['_token', '_method']);

        $page->update($data);

        return redirect()->route('admin.pages.lentes.edit')
            ->with('success', 'Página de lentes actualizada correctamente.');
    }
}

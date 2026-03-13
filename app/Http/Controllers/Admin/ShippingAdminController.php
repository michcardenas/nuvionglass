<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingRate;
use App\Models\ShippingSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShippingAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.shipping.index', [
            'defaultPrice' => ShippingSetting::get('default_price', '99.00'),
            'freeThreshold' => ShippingSetting::get('free_shipping_threshold', '0'),
            'rates' => ShippingRate::orderBy('city')->get(),
        ]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'default_price' => 'required|numeric|min:0',
            'free_shipping_threshold' => 'required|numeric|min:0',
        ]);

        ShippingSetting::set('default_price', $request->input('default_price'));
        ShippingSetting::set('free_shipping_threshold', $request->input('free_shipping_threshold'));

        return redirect()->route('admin.shipping.index')
            ->with('success', 'Configuración de envío actualizada.');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'city' => 'required|string|max:100|unique:shipping_rates,city',
            'state' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        ShippingRate::create($validated);

        return redirect()->route('admin.shipping.index')
            ->with('success', 'Tarifa de envío creada para ' . $validated['city'] . '.');
    }

    public function update(Request $request, ShippingRate $shippingRate): RedirectResponse
    {
        $validated = $request->validate([
            'city' => 'required|string|max:100|unique:shipping_rates,city,' . $shippingRate->id,
            'state' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $shippingRate->update($validated);

        return redirect()->route('admin.shipping.index')
            ->with('success', 'Tarifa actualizada.');
    }

    public function destroy(ShippingRate $shippingRate): RedirectResponse
    {
        $shippingRate->delete();

        return redirect()->route('admin.shipping.index')
            ->with('success', 'Tarifa eliminada.');
    }
}

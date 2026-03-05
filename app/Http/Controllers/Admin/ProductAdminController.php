<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductAdminController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::orderBy('sort_order')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('sort_order')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'variants.*.name' => 'nullable|string|max:100',
            'variants.*.value' => 'nullable|string|max:100',
            'variants.*.price_modifier' => 'nullable|numeric',
            'variants.*.stock' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products', 'public');
            }
        }
        $validated['images'] = $imagePaths;

        $product = Product::create($validated);

        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                if (! empty($variant['name']) && ! empty($variant['value'])) {
                    $product->variants()->create([
                        'name' => $variant['name'],
                        'value' => $variant['value'],
                        'price_modifier' => $variant['price_modifier'] ?? 0,
                        'stock' => $variant['stock'] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function show(Product $product): View
    {
        $product->load('category', 'variants');

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $product->load('variants');
        $categories = Category::orderBy('sort_order')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_images' => 'nullable|array',
            'variants.*.id' => 'nullable|integer',
            'variants.*.name' => 'nullable|string|max:100',
            'variants.*.value' => 'nullable|string|max:100',
            'variants.*.price_modifier' => 'nullable|numeric',
            'variants.*.stock' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        // Handle image removal
        $currentImages = $product->images ?? [];
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imagePath) {
                Storage::disk('public')->delete($imagePath);
                $currentImages = array_values(array_diff($currentImages, [$imagePath]));
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $currentImages[] = $image->store('products', 'public');
            }
        }
        $validated['images'] = $currentImages;

        unset($validated['remove_images']);
        $product->update($validated);

        // Sync variants
        if ($request->has('variants')) {
            $keepIds = [];
            foreach ($request->variants as $variant) {
                if (! empty($variant['name']) && ! empty($variant['value'])) {
                    if (! empty($variant['id'])) {
                        $product->variants()->where('id', $variant['id'])->update([
                            'name' => $variant['name'],
                            'value' => $variant['value'],
                            'price_modifier' => $variant['price_modifier'] ?? 0,
                            'stock' => $variant['stock'] ?? 0,
                        ]);
                        $keepIds[] = $variant['id'];
                    } else {
                        $newVariant = $product->variants()->create([
                            'name' => $variant['name'],
                            'value' => $variant['value'],
                            'price_modifier' => $variant['price_modifier'] ?? 0,
                            'stock' => $variant['stock'] ?? 0,
                        ]);
                        $keepIds[] = $newVariant->id;
                    }
                }
            }
            $product->variants()->whereNotIn('id', $keepIds)->delete();
        } else {
            $product->variants()->delete();
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->variants()->delete();
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado.');
    }

    public function toggle(Product $product): RedirectResponse
    {
        $product->update(['is_active' => ! $product->is_active]);

        $status = $product->is_active ? 'activado' : 'desactivado';

        return redirect()->route('admin.products.index')
            ->with('success', "Producto {$status}.");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private SeoService $seo,
    ) {}

    public function index(Request $request): View
    {
        $query = Product::active()->with('category', 'variants');

        // Filter: category
        if ($request->filled('categoria')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->categoria));
        }

        // Filter: price range
        if ($request->filled('precio_min')) {
            $query->where('price', '>=', (float) $request->precio_min);
        }
        if ($request->filled('precio_max')) {
            $query->where('price', '<=', (float) $request->precio_max);
        }

        // Filter: only in stock
        if ($request->boolean('disponible')) {
            $query->where('stock', '>', 0);
        }

        // Filter: only on sale
        if ($request->boolean('oferta')) {
            $query->whereNotNull('compare_price')->whereColumn('price', '<', 'compare_price');
        }

        // Sort
        $sort = $request->input('orden', 'destacados');
        $query = match ($sort) {
            'precio_asc'  => $query->orderBy('price', 'asc'),
            'precio_desc' => $query->orderBy('price', 'desc'),
            'recientes'   => $query->orderBy('created_at', 'desc'),
            'nombre'      => $query->orderBy('name', 'asc'),
            default        => $query->orderBy('is_featured', 'desc'),
        };

        // Price bounds for the range filter UI
        $priceRange = Product::active()->selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();

        $products = $query->paginate(12);
        $categories = Category::orderBy('sort_order')->get();

        $breadcrumbs = $this->seo->breadcrumbSchema([
            ['name' => 'Inicio', 'url' => url('/')],
            ['name' => 'Lentes', 'url' => route('products.index')],
        ]);

        return view('storefront.products.index', [
            'products'        => $products,
            'categories'      => $categories,
            'currentCategory' => $request->categoria,
            'currentSort'     => $sort,
            'priceRange'      => $priceRange,
            'breadcrumbs'     => $breadcrumbs,
        ]);
    }

    public function show(string $slug): View
    {
        $product = Product::active()
            ->where('slug', $slug)
            ->with('category', 'variants')
            ->firstOrFail();

        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(3)
            ->get();

        $seo = $this->seo->forProduct($product);
        $schema = $this->seo->productSchema($product);
        $breadcrumbs = $this->seo->breadcrumbSchema([
            ['name' => 'Inicio', 'url' => url('/')],
            ['name' => 'Lentes', 'url' => route('products.index')],
            ['name' => $product->name, 'url' => route('products.show', $product->slug)],
        ]);

        return view('storefront.products.show', compact(
            'product', 'related', 'seo', 'schema', 'breadcrumbs',
        ));
    }
}

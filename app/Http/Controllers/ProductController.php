<?php

namespace App\Http\Controllers;

use App\Helpers\ColorHelper;
use App\Models\Category;
use App\Models\LentesPageSetting;
use App\Models\Product;
use App\Models\ProductVariant;
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
        $tipoFiltro = $request->input('type', 'todos');
        $colorFiltro = $request->input('color');
        $graduacionFiltro = $request->input('graduation');

        $query = Product::active()->with('variants')->orderBy('sort_order');

        if ($tipoFiltro && $tipoFiltro !== 'todos') {
            $query->where('type', $tipoFiltro);
        }

        if ($colorFiltro) {
            $query->whereHas('variants', fn ($q) => $q->where('color', $colorFiltro)->where('is_active', true));
        }

        if ($graduacionFiltro) {
            $query->whereHas('variants', fn ($q) => $q->where('graduation', $graduacionFiltro)->where('is_active', true));
        }

        $products = $query->get();

        // Available colors
        $coloresDisponibles = ProductVariant::whereHas('product', fn ($q) => $q->active())
            ->where('is_active', true)
            ->whereNotNull('color')
            ->distinct()
            ->pluck('color')
            ->sort()
            ->values();

        // Available graduations sorted numerically
        $graduacionesDisponibles = ProductVariant::whereHas('product', fn ($q) => $q->active()->whereIn('type', ['miopia', 'lectura', 'sin_graduacion']))
            ->where('is_active', true)
            ->whereNotNull('graduation')
            ->pluck('graduation')
            ->unique()
            ->filter()
            ->sortBy(fn ($g) => (float) $g)
            ->values();

        // Toallitas always available separately
        $toallitas = Product::active()
            ->where('type', 'toallitas')
            ->with('variants')
            ->get();

        $breadcrumbs = $this->seo->breadcrumbSchema([
            ['name' => 'Inicio', 'url' => url('/')],
            ['name' => 'Lentes', 'url' => route('products.index')],
        ]);

        $lentesPage = LentesPageSetting::getCurrent();

        return view('storefront.products.index', [
            'products' => $products,
            'toallitas' => $toallitas,
            'coloresDisponibles' => $coloresDisponibles,
            'graduacionesDisponibles' => $graduacionesDisponibles,
            'tipoFiltro' => $tipoFiltro,
            'colorFiltro' => $colorFiltro,
            'graduacionFiltro' => $graduacionFiltro,
            'breadcrumbs' => $breadcrumbs,
            'colorHelper' => ColorHelper::all(),
            'lentesPage' => $lentesPage,
        ]);
    }

    public function show(string $slug): View
    {
        $product = Product::active()
            ->where('slug', $slug)
            ->with('variants')
            ->firstOrFail();

        $activeVariants = $product->variants->where('is_active', true);

        // Unique colors
        $colores = $activeVariants->pluck('color')->unique()->filter()->values();

        // Graduations grouped by type
        $graduacionesMiopia = $activeVariants
            ->where('graduation_type', 'miopia')
            ->pluck('graduation')->unique()->filter()
            ->sortBy(fn ($g) => (float) $g)->values();

        $graduacionesLectura = $activeVariants
            ->where('graduation_type', 'lectura')
            ->pluck('graduation')->unique()->filter()
            ->sortBy(fn ($g) => (float) $g)->values();

        $graduacionesSinGrad = $activeVariants
            ->where('graduation_type', 'sin_graduacion')
            ->pluck('graduation')->unique()->filter()->values();

        // Toallitas for suggestion
        $toallitas = Product::active()
            ->where('type', 'toallitas')
            ->with('variants')
            ->get();

        $seo = $this->seo->forProduct($product);
        $schema = $this->seo->productSchema($product);
        $breadcrumbs = $this->seo->breadcrumbSchema([
            ['name' => 'Inicio', 'url' => url('/')],
            ['name' => 'Lentes', 'url' => route('products.index')],
            ['name' => $product->name, 'url' => route('products.show', $product->slug)],
        ]);

        $lentesPage = LentesPageSetting::getCurrent();

        return view('storefront.products.show', compact(
            'product', 'colores',
            'graduacionesMiopia', 'graduacionesLectura', 'graduacionesSinGrad',
            'toallitas', 'seo', 'schema', 'breadcrumbs', 'lentesPage',
        ));
    }
}

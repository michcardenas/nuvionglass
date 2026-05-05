<?php

namespace App\Http\Controllers;

use App\Models\BlogPageSetting;
use App\Models\BlogPost;
use App\Services\SeoService;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function __construct(
        private SeoService $seo,
    ) {}

    public function index(): View
    {
        $posts = BlogPost::published()
            ->orderByDesc('published_at')
            ->paginate(9);

        // Asigna una categoría a cada post a partir de su focus_keyword.
        // Las claves coinciden con los data-filter de los botones.
        $categoryLabels = [
            'salud-visual' => 'Salud visual',
            'luz-azul' => 'Luz azul',
            'habitos' => 'Hábitos digitales',
            'lentes' => 'Lentes',
        ];

        $categorize = function (?string $keyword): string {
            $kw = mb_strtolower($keyword ?? '');
            if (str_contains($kw, 'lentes')) return 'lentes';
            if (str_contains($kw, 'pantalla') || str_contains($kw, 'horas')) return 'habitos';
            if (str_contains($kw, 'luz azul')) return 'luz-azul';
            return 'salud-visual';
        };

        // Decoramos cada post con su categoría calculada para que la vista no tenga lógica.
        $posts->getCollection()->transform(function (BlogPost $post) use ($categorize) {
            $post->category_key = $categorize($post->focus_keyword);
            return $post;
        });

        // Solo mostramos los botones de las categorías que tienen al menos un post visible.
        $countsByCategory = $posts->getCollection()
            ->groupBy('category_key')
            ->map->count();

        $availableCategories = collect($categoryLabels)
            ->filter(fn ($label, $key) => isset($countsByCategory[$key]))
            ->map(fn ($label, $key) => [
                'key' => $key,
                'label' => $label,
                'count' => $countsByCategory[$key] ?? 0,
            ])
            ->values();

        $breadcrumbs = $this->seo->breadcrumbSchema([
            ['name' => 'Inicio', 'url' => url('/')],
            ['name' => 'Blog', 'url' => route('blog.index')],
        ]);

        $blogPage = BlogPageSetting::getCurrent();

        return view('storefront.blog.index', [
            'posts' => $posts,
            'availableCategories' => $availableCategories,
            'totalPostsOnPage' => $posts->count(),
            'breadcrumbs' => $breadcrumbs,
            'blogPage' => $blogPage,
        ]);
    }

    public function show(string $slug): View
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $seo = $this->seo->forBlogPost($post);
        $schema = $this->seo->articleSchema($post);
        $breadcrumbs = $this->seo->breadcrumbSchema([
            ['name' => 'Inicio', 'url' => url('/')],
            ['name' => 'Blog', 'url' => route('blog.index')],
            ['name' => $post->title, 'url' => route('blog.show', $post->slug)],
        ]);

        $recent = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $products = collect([
            ['name' => 'nuvion Classic', 'price' => '$899', 'original_price' => '$1,299', 'slug' => 'nuvion-classic', 'type' => 'Sin Graduación'],
            ['name' => 'nuvion Aura', 'price' => '$999', 'original_price' => '$1,399', 'slug' => 'nuvion-aura', 'type' => 'Sin Graduación'],
            ['name' => 'nuvion Vision Pro', 'price' => '$1,599', 'original_price' => '$2,299', 'slug' => 'nuvion-vision-pro', 'type' => 'Con Graduación'],
        ]);

        return view('storefront.blog.show', compact(
            'post', 'seo', 'schema', 'breadcrumbs', 'recent', 'products',
        ));
    }
}

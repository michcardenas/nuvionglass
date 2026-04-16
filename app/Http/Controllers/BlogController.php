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

        $breadcrumbs = $this->seo->breadcrumbSchema([
            ['name' => 'Inicio', 'url' => url('/')],
            ['name' => 'Blog', 'url' => route('blog.index')],
        ]);

        $blogPage = BlogPageSetting::getCurrent();

        return view('storefront.blog.index', [
            'posts' => $posts,
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

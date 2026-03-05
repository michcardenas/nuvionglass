<?php

namespace App\Http\Controllers;

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

        return view('storefront.blog.index', [
            'posts' => $posts,
            'breadcrumbs' => $breadcrumbs,
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

        return view('storefront.blog.show', compact(
            'post', 'seo', 'schema', 'breadcrumbs', 'recent',
        ));
    }
}

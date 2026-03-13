<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\InfographicImage;
use App\Models\Product;
use App\Services\SeoService;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function __construct(
        private SeoService $seo,
    ) {}

    public function home(): View
    {
        $featuredProducts = Product::active()
            ->featured()
            ->with('category', 'variants')
            ->limit(4)
            ->get();

        $recentPosts = BlogPost::published()
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $infographics = InfographicImage::active()
            ->orderBy('sort_order')
            ->get();

        $organizationSchema = $this->seo->organizationSchema();

        $faqSchema = $this->seo->faqSchema([
            [
                'question' => '¿Qué es la luz azul y por qué es dañina?',
                'answer' => 'La luz azul es una porción del espectro visible (380-500nm) emitida por pantallas y LEDs. La sobreexposición puede causar fatiga visual, dolores de cabeza y alteraciones del sueño.',
            ],
            [
                'question' => '¿Los lentes nuvion tienen graduación?',
                'answer' => 'Sí, ofrecemos lentes con y sin graduación. Nuestra línea Con Graduación incluye modelos con lentes asféricas de alta definición.',
            ],
            [
                'question' => '¿Cuánto tarda el envío?',
                'answer' => 'El envío estándar tarda 3-5 días hábiles. Envío gratis en pedidos mayores a $99.',
            ],
            [
                'question' => '¿Puedo devolver los lentes si no me gustan?',
                'answer' => 'Sí, tienes 30 días para devolverlos si no estás satisfecho. Aplican términos y condiciones.',
            ],
            [
                'question' => '¿Los lentes sirven para gaming?',
                'answer' => 'Sí, nuestra línea Gaming & Sport está diseñada específicamente para sesiones intensas frente a pantallas, con filtro de alto rendimiento y diseño compatible con headsets.',
            ],
        ]);

        return view('storefront.home', compact(
            'featuredProducts', 'recentPosts', 'infographics', 'organizationSchema', 'faqSchema',
        ));
    }

    public function blueLight(): View
    {
        $faqSchema = $this->seo->faqSchema([
            [
                'question' => '¿Qué es la luz azul?',
                'answer' => 'La luz azul es una porción del espectro de luz visible con longitud de onda entre 380 y 500 nanómetros. Es emitida por el sol, pantallas digitales, LEDs y luces fluorescentes.',
            ],
            [
                'question' => '¿Por qué es dañina la luz azul?',
                'answer' => 'La exposición prolongada puede causar fatiga visual digital, dolores de cabeza, ojos secos y alteraciones en el ciclo circadiano que afectan la calidad del sueño.',
            ],
            [
                'question' => '¿Quién debería usar lentes con protección de luz azul?',
                'answer' => 'Cualquier persona que pase más de 4 horas diarias frente a pantallas: trabajadores de oficina, gamers, estudiantes y usuarios frecuentes de dispositivos móviles.',
            ],
        ]);

        $breadcrumbSchema = $this->seo->breadcrumbSchema([
            ['name' => 'Inicio', 'url' => url('/')],
            ['name' => '¿Qué es la luz azul?', 'url' => route('blue-light')],
        ]);

        return view('storefront.pages.que-es-luz-azul', compact('faqSchema', 'breadcrumbSchema'));
    }
}

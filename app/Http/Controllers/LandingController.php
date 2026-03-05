<?php

namespace App\Http\Controllers;

use App\Mail\LeadWelcome;
use App\Models\Lead;
use App\Models\Product;
use App\Services\SeoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function __construct(
        private SeoService $seo,
    ) {}

    /**
     * Generic campaign landing page.
     */
    public function index(): View
    {
        $featuredProducts = Product::active()
            ->featured()
            ->with('category')
            ->limit(3)
            ->get();

        return view('storefront.landing.index', compact('featuredProducts'));
    }

    /**
     * Quiz: "¿Qué lentes son para ti?"
     */
    public function quiz(): View
    {
        return view('storefront.landing.quiz');
    }

    /**
     * Store quiz result as lead (AJAX).
     */
    public function quizResult(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'answers' => 'required|array',
        ]);

        $lead = Lead::updateOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'source' => 'quiz',
            ],
        );

        if ($lead->wasRecentlyCreated) {
            Mail::to($lead->email)->send(new LeadWelcome($lead));
        }

        // Determine recommendation based on answers
        $recommendation = $this->getRecommendation($validated['answers']);

        return response()->json([
            'success' => true,
            'recommendation' => $recommendation,
        ]);
    }

    /**
     * Determine product recommendation from quiz answers.
     */
    private function getRecommendation(array $answers): array
    {
        $usage = $answers['usage'] ?? 'screen';
        $hours = $answers['hours'] ?? '4-6';
        $prescription = $answers['prescription'] ?? 'no';
        $style = $answers['style'] ?? 'classic';

        // Logic: prescription → Con Graduación, gaming → Gaming, else → Sin Graduación
        if ($prescription === 'yes') {
            $product = Product::active()
                ->whereHas('category', fn ($q) => $q->where('slug', 'con-graduacion'))
                ->first();
            $reason = 'Necesitas lentes con graduación y protección de luz azul.';
        } elseif ($usage === 'gaming') {
            $product = Product::active()
                ->whereHas('category', fn ($q) => $q->where('slug', 'gaming-sport'))
                ->first();
            $reason = 'Para sesiones de gaming intensas, necesitas filtro de alto rendimiento.';
        } else {
            $product = Product::active()
                ->whereHas('category', fn ($q) => $q->where('slug', 'sin-graduacion'))
                ->where('is_featured', true)
                ->first();
            $reason = 'Protección diaria sin graduación con diseño que amarás.';
        }

        // Fallback
        if (! $product) {
            $product = Product::active()->featured()->first();
            $reason = 'Este es nuestro modelo más popular y versátil.';
        }

        return [
            'product_name' => $product->name,
            'product_slug' => $product->slug,
            'product_price' => $product->price,
            'product_image' => $product->images[0] ?? null,
            'product_url' => route('products.show', $product->slug),
            'reason' => $reason,
        ];
    }
}

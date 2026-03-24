<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePageSetting;
use Illuminate\Http\Request;

class AdminHomePageController extends Controller
{
    public function edit()
    {
        $page = HomePageSetting::getCurrent();

        return view('admin.pages.home.edit', compact('page'));
    }

    public function update(Request $request)
    {
        $page = HomePageSetting::getCurrent();

        $data = $request->except(['_token', '_method']);

        // Category cards — array of objects
        if ($request->has('category_cards')) {
            $cards = [];
            foreach ($request->input('category_cards', []) as $card) {
                if (!empty($card['name'])) {
                    $cards[] = [
                        'name' => $card['name'],
                        'link_param' => $card['link_param'] ?? '',
                        'description' => $card['description'] ?? '',
                        'icon_svg' => $card['icon_svg'] ?? '',
                    ];
                }
            }
            $data['category_cards'] = $cards;
        }

        // Wipes features — textarea, one per line
        if ($request->has('wipes_features_text')) {
            $items = array_filter(array_map('trim', explode("\n", $request->input('wipes_features_text', ''))));
            $data['wipes_features'] = array_values($items);
            unset($data['wipes_features_text']);
        }

        // FAQs — array of {q, a}
        if ($request->has('faqs')) {
            $faqs = [];
            foreach ($request->input('faqs', []) as $faq) {
                if (!empty($faq['q'])) {
                    $faqs[] = ['q' => $faq['q'], 'a' => $faq['a'] ?? ''];
                }
            }
            $data['faqs'] = $faqs;
        }

        // Trust badges — array of objects
        if ($request->has('trust_badges')) {
            $badges = [];
            foreach ($request->input('trust_badges', []) as $badge) {
                if (!empty($badge['title'])) {
                    $badges[] = [
                        'icon_svg' => $badge['icon_svg'] ?? '',
                        'title' => $badge['title'],
                        'description' => $badge['description'] ?? '',
                    ];
                }
            }
            $data['trust_badges'] = $badges;
        }

        // CTA trust items — textarea, one per line
        if ($request->has('cta_trust_items_text')) {
            $items = array_filter(array_map('trim', explode("\n", $request->input('cta_trust_items_text', ''))));
            $data['cta_trust_items'] = array_values($items);
            unset($data['cta_trust_items_text']);
        }

        $page->update($data);

        return redirect()->route('admin.pages.home.edit')
            ->with('success', 'Secciones del inicio actualizadas correctamente.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\QuizPageSetting;
use Illuminate\Http\Request;

class AdminQuizPageController extends Controller
{
    public function edit()
    {
        $page = QuizPageSetting::getCurrent();
        $products = Product::active()->orderBy('name')->get(['id', 'name']);

        return view('admin.pages.quiz.edit', compact('page', 'products'));
    }

    public function update(Request $request)
    {
        $page = QuizPageSetting::getCurrent();

        $data = $request->except(['_token', '_method']);

        // Recommendation rules — filter out rules without product
        if ($request->has('recommendation_rules')) {
            $rules = [];
            foreach ($request->input('recommendation_rules', []) as $rule) {
                if (!empty($rule['product_id'])) {
                    $rules[] = [
                        'condition_field' => $rule['condition_field'] ?? 'usage',
                        'condition_value' => $rule['condition_value'] ?? '',
                        'product_id' => (int) $rule['product_id'],
                        'reason' => $rule['reason'] ?? '',
                    ];
                }
            }
            $data['recommendation_rules'] = $rules;
        }

        // Questions — filter out questions without key or label, normalize options
        if ($request->has('questions')) {
            $questions = [];
            foreach ($request->input('questions', []) as $q) {
                if (empty($q['key']) || empty($q['label'])) {
                    continue;
                }
                $options = [];
                foreach ($q['options'] ?? [] as $opt) {
                    if (!empty($opt['value']) && !empty($opt['label'])) {
                        $options[] = [
                            'value' => $opt['value'],
                            'label' => $opt['label'],
                            'desc' => $opt['desc'] ?? '',
                        ];
                    }
                }
                if (empty($options)) {
                    continue;
                }
                $questions[] = [
                    'key' => preg_replace('/[^a-z0-9_]/i', '_', strtolower($q['key'])),
                    'label' => $q['label'],
                    'subtitle' => $q['subtitle'] ?? '',
                    'options' => $options,
                ];
            }
            $data['questions'] = $questions;
        }

        // Default product
        $data['default_product_id'] = !empty($data['default_product_id']) ? (int) $data['default_product_id'] : null;

        $page->update($data);

        return redirect()->route('admin.pages.quiz.edit')
            ->with('success', 'Página del quiz actualizada correctamente.');
    }
}

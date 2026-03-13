<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // --- Sin Graduación (category_id: 1) ---
            [
                'category_id' => 1,
                'name' => 'nuvion Classic',
                'slug' => 'nuvion-classic',
                'description' => 'Nuestro modelo insignia. Diseño minimalista y elegante con filtro de luz azul de alta eficiencia. Marco ultraligero de TR-90 que apenas sentirás. Perfecto para uso diario frente a pantallas.',
                'price' => 899.00,
                'compare_price' => 1299.00,
                'stock' => 150,
                'images' => [],
                'meta_title' => 'nuvion Classic — Lentes Anti Luz Azul',
                'meta_description' => 'Protege tus ojos con nuvion Classic. Filtro de luz azul premium en un diseño minimalista y ultraligero.',
                'is_active' => true,
                'is_featured' => true,
                'variants' => [
                    ['name' => 'Color', 'value' => 'Negro Mate', 'price_modifier' => 0, 'stock' => 50],
                    ['name' => 'Color', 'value' => 'Azul Oscuro', 'price_modifier' => 0, 'stock' => 50],
                    ['name' => 'Color', 'value' => 'Transparente', 'price_modifier' => 100.00, 'stock' => 50],
                ],
            ],
            [
                'category_id' => 1,
                'name' => 'nuvion Aura',
                'slug' => 'nuvion-aura',
                'description' => 'Estilo redondo contemporáneo con filtro avanzado de luz azul. Ideal para quienes buscan un look sofisticado sin sacrificar la protección ocular. Bisagras flex para mayor comodidad.',
                'price' => 999.00,
                'compare_price' => 1399.00,
                'stock' => 100,
                'images' => [],
                'meta_title' => 'nuvion Aura — Lentes Redondos Anti Luz Azul',
                'meta_description' => 'Estilo redondo y protección premium. nuvion Aura filtra la luz azul dañina con un diseño sofisticado.',
                'is_active' => true,
                'is_featured' => true,
                'variants' => [
                    ['name' => 'Color', 'value' => 'Dorado', 'price_modifier' => 0, 'stock' => 50],
                    ['name' => 'Color', 'value' => 'Plateado', 'price_modifier' => 0, 'stock' => 50],
                ],
            ],

            // --- Con Graduación (category_id: 2) ---
            [
                'category_id' => 2,
                'name' => 'nuvion Vision Pro',
                'slug' => 'nuvion-vision-pro',
                'description' => 'Lentes con graduación personalizada y filtro de luz azul integrado. Tecnología de lente asférica para una visión nítida. Incluye consulta virtual para verificar tu graduación.',
                'price' => 1599.00,
                'compare_price' => 2299.00,
                'stock' => 80,
                'images' => [],
                'meta_title' => 'nuvion Vision Pro — Lentes Graduados Anti Luz Azul',
                'meta_description' => 'Corrección visual + protección de luz azul. nuvion Vision Pro con lentes asféricas de alta definición.',
                'is_active' => true,
                'is_featured' => true,
                'variants' => [
                    ['name' => 'Color', 'value' => 'Negro Mate', 'price_modifier' => 0, 'stock' => 40],
                    ['name' => 'Color', 'value' => 'Gris Oscuro', 'price_modifier' => 0, 'stock' => 40],
                ],
            ],
            [
                'category_id' => 2,
                'name' => 'nuvion Flex RX',
                'slug' => 'nuvion-flex-rx',
                'description' => 'Marco flexible de titanio con graduación y filtro de luz azul. Ultra resistente y ligero. Se adapta a cualquier forma de rostro con sus patillas ajustables.',
                'price' => 1799.00,
                'compare_price' => 2499.00,
                'stock' => 60,
                'images' => [],
                'meta_title' => 'nuvion Flex RX — Lentes Flexibles Graduados',
                'meta_description' => 'Titanio flexible + graduación + filtro de luz azul. nuvion Flex RX, la combinación perfecta de resistencia y protección.',
                'is_active' => true,
                'is_featured' => false,
                'variants' => [
                    ['name' => 'Color', 'value' => 'Plata', 'price_modifier' => 0, 'stock' => 30],
                    ['name' => 'Color', 'value' => 'Negro', 'price_modifier' => 0, 'stock' => 30],
                ],
            ],

            // --- Gaming & Sport (category_id: 3) ---
            [
                'category_id' => 3,
                'name' => 'nuvion Pro Gamer',
                'slug' => 'nuvion-pro-gamer',
                'description' => 'Diseñados para sesiones de gaming intensas. Filtro de luz azul de alto rendimiento con tinte ámbar sutil. Marco envolvente que no interfiere con headsets. Almohadillas de silicona antideslizantes.',
                'price' => 1199.00,
                'compare_price' => 1599.00,
                'stock' => 90,
                'images' => [],
                'meta_title' => 'nuvion Pro Gamer — Lentes Gaming Anti Luz Azul',
                'meta_description' => 'Máximo rendimiento visual para gamers. nuvion Pro Gamer con filtro de alto rendimiento y diseño compatible con headsets.',
                'is_active' => true,
                'is_featured' => true,
                'variants' => [
                    ['name' => 'Color', 'value' => 'Rojo/Negro', 'price_modifier' => 0, 'stock' => 45],
                    ['name' => 'Color', 'value' => 'Azul/Negro', 'price_modifier' => 0, 'stock' => 45],
                ],
            ],
            [
                'category_id' => 3,
                'name' => 'nuvion Sport Shield',
                'slug' => 'nuvion-sport-shield',
                'description' => 'Lentes deportivos con protección de luz azul y UV400. Marco de policarbonato ultra resistente a impactos. Grip de goma en patillas y puente nasal. Ideales para deportes y actividades al aire libre.',
                'price' => 1099.00,
                'compare_price' => 1499.00,
                'stock' => 70,
                'images' => [],
                'meta_title' => 'nuvion Sport Shield — Lentes Deportivos Anti Luz Azul',
                'meta_description' => 'Protección total para deportistas. nuvion Sport Shield con filtro de luz azul y UV400 en marco ultra resistente.',
                'is_active' => true,
                'is_featured' => false,
                'variants' => [
                    ['name' => 'Color', 'value' => 'Blanco/Gris', 'price_modifier' => 0, 'stock' => 35],
                    ['name' => 'Color', 'value' => 'Negro/Verde', 'price_modifier' => 0, 'stock' => 35],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $variants = $productData['variants'];
            unset($productData['variants']);

            $product = Product::create($productData);

            foreach ($variants as $variant) {
                $product->variants()->create($variant);
            }
        }
    }
}

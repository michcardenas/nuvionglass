<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Backfill: descuenta el stock historico de las ordenes que ya estan
     * cerradas (paid o status confirmed/shipped/delivered) y que aun no
     * han sido ajustadas (orders.inventory_adjusted = false / null).
     *
     * Usa un flag en orders para que sea idempotente: si la migracion se
     * vuelve a correr no descuenta dos veces.
     */
    public function up(): void
    {
        // 1) Asegurar que existe el flag en orders.
        if (! Schema::hasColumn('orders', 'inventory_adjusted')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->boolean('inventory_adjusted')->default(false)->after('payment_status');
            });
        }

        // 2) Procesar ordenes elegibles dentro de una transaccion.
        DB::transaction(function () {
            $orders = DB::table('orders')
                ->where(function ($q) {
                    $q->where('payment_status', 'paid')
                      ->orWhereIn('status', ['confirmed', 'shipped', 'delivered']);
                })
                ->where(function ($q) {
                    $q->where('inventory_adjusted', false)
                      ->orWhereNull('inventory_adjusted');
                })
                ->pluck('id');

            foreach ($orders as $orderId) {
                $items = DB::table('order_items')->where('order_id', $orderId)->get();

                foreach ($items as $item) {
                    $qty = (int) $item->qty;
                    if ($qty <= 0) {
                        continue;
                    }

                    if ($item->variant_id) {
                        $row = DB::table('product_variants')->where('id', $item->variant_id)->lockForUpdate()->first();
                        if ($row) {
                            $newStock = max(0, (int) $row->stock - $qty);
                            DB::table('product_variants')->where('id', $item->variant_id)->update(['stock' => $newStock]);
                            continue;
                        }
                    }

                    if ($item->product_id) {
                        $row = DB::table('products')->where('id', $item->product_id)->lockForUpdate()->first();
                        if ($row) {
                            $newStock = max(0, (int) $row->stock - $qty);
                            DB::table('products')->where('id', $item->product_id)->update(['stock' => $newStock]);
                        }
                    }
                }

                DB::table('orders')->where('id', $orderId)->update(['inventory_adjusted' => true]);
            }
        });
    }

    /**
     * No revertimos: no sabemos cuanto stock se descontó por esta migracion
     * vs ajustes manuales posteriores.
     */
    public function down(): void
    {
        // Intencional: no-op.
    }
};

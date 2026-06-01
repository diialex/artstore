<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MetricsService
{
    private const MONTHS = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

    /**
     * Ingresos (pedidos completados) acumulados por mes del año en curso.
     */
    public function getRevenuePerMonth(): array
    {
        $year = (int) now()->year;
        $currentMonth = (int) now()->format('n');

        $data = array_fill(0, $currentMonth, 0);

        $rows = Order::where('status', 'completed')
            ->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->get();

        foreach ($rows as $row) {
            $month = (int) $row->month;
            if ($month >= 1 && $month <= $currentMonth) {
                $data[$month - 1] = round((float) $row->total, 2);
            }
        }

        return [
            'data'   => $data,
            'labelX' => array_slice(self::MONTHS, 0, $currentMonth),
        ];
    }

    /**
     * Productos más vendidos por unidades.
     */
    public function getTopSellingProducts(int $limit = 5): array
    {
        $rows = OrderItem::selectRaw('product_id, SUM(quantity) as units')
            ->groupBy('product_id')
            ->orderByDesc('units')
            ->limit($limit)
            ->get();

        $data = [];
        $labels = [];

        foreach ($rows as $row) {
            $product = Product::find($row->product_id);
            $labels[] = $product ? Str::limit((string) $product->title, 22) : '#' . $row->product_id;
            $data[] = (int) $row->units;
        }

        return [
            'data'   => $data,
            'labelX' => $labels,
        ];
    }

    /**
     * Distribución de pedidos por estado.
     */
    public function getOrdersByStatus(): array
    {
        $rows = Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        return [
            'data'   => $rows->pluck('total')->map(fn ($v) => (int) $v)->all(),
            'labels' => $rows->pluck('status')
                ->map(fn ($s) => __('messages.status_' . $s))
                ->all(),
        ];
    }

    /**
     * Ingresos por categoría (cantidad * precio de cada línea de pedido).
     */
    public function getRevenueByCategory(): array
    {
        $rows = DB::table('order_items')
            ->join('category_product', 'order_items.product_id', '=', 'category_product.product_id')
            ->join('categories', 'category_product.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as name, SUM(order_items.quantity * order_items.price) as revenue')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->get();

        return [
            'data'   => $rows->pluck('revenue')->map(fn ($v) => round((float) $v, 2))->all(),
            'labels' => $rows->pluck('name')->all(),
        ];
    }
}

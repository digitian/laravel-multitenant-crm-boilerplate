<?php

namespace App\Actions;

use App\Enum\OrderStatus;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CreateOrder
{
    /**
     * @param  array{
     *     customer_id: int,
     *     status: OrderStatus,
     *     estimated_delivery_date: ?string,
     *     address: ?string,
     *     city: ?string,
     *     postal_code: ?string,
     *     country: ?string,
     *     notes: ?string,
     *     items: array<int, array{product_id: int, amount: int, price: float, discount: float}>
     * }  $data
     */
    public function execute(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $items = $data['items'] ?? [];
            unset($data['items']);

            $totalAmount = 0;
            $orderables = [];

            foreach ($items as $item) {
                $itemTotal = ($item['price'] - ($item['price'] * $item['discount'] / 100)) * $item['amount'];
                $totalAmount += $itemTotal;

                $orderables[$item['product_id']] = [
                    'amount' => $item['amount'],
                    'price' => $item['price'],
                    'discount' => $item['discount'],
                    'total' => $itemTotal,
                ];
            }

            $order = Order::create([
                ...$data,
                'total_amount' => $totalAmount,
                'created_by' => auth()->id(),
            ]);

            if (! empty($orderables)) {
                $order->products()->attach($orderables);
            }

            return $order;
        });
    }
}

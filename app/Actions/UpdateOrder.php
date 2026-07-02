<?php

namespace App\Actions;

use App\Enum\OrderStatus;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class UpdateOrder
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
    public function execute(Order $order, array $data): Order
    {
        return DB::transaction(function () use ($order, $data) {
            $items = $data['items'] ?? [];
            unset($data['items']);

            $totalAmount = 0;
            $orderables = [];

            foreach ($items as $item) {
                $itemTotal = ($item['price'] - $item['discount']) * $item['amount'];
                $totalAmount += $itemTotal;

                $orderables[$item['product_id']] = [
                    'amount' => $item['amount'],
                    'price' => $item['price'],
                    'discount' => $item['discount'],
                    'total' => $itemTotal,
                ];
            }

            $data['total_amount'] = $totalAmount;
            $order->update($data);

            $order->products()->sync($orderables);

            return $order;
        });
    }
}

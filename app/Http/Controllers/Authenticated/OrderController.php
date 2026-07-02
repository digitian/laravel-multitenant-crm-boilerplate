<?php

namespace App\Http\Controllers\Authenticated;

use App\Enum\OrderSortBy;
use App\Enum\SortDirection;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders with filtering and sorting.
     */
    public function index(Request $request): View
    {
        $sortBy = $request->enum('sort_by', OrderSortBy::class) ?? OrderSortBy::CreatedAt;
        $orderBy = $request->enum('order_by', SortDirection::class) ?? SortDirection::Desc;

        $orders = Order::with('customer:id,first_name,last_name,email')
            ->select('id', 'customer_id', 'status', 'total_amount', 'estimated_delivery_date', 'created_at')
            ->when($request->filled('search'), fn ($q) => $q->whereHas('customer', function ($q) use ($request) {
                $search = '%'.$request->string('search').'%';
                $q->where('first_name', 'like', $search)
                    ->orWhere('last_name', 'like', $search)
                    ->orWhere('email', 'like', $search);
            })->orWhere('id', 'like', '%'.$request->string('search').'%'))
            ->orderBy($sortBy->value, $orderBy->value)
            ->paginate(20)
            ->withQueryString();

        return view('pages.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order): View
    {
        $order->load(['customer', 'products', 'createdBy:id,first_name,last_name']);

        return view('pages.orders.show', compact('order'));
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order): RedirectResponse
    {
        $id = $order->id;

        $order->delete();

        flash()->success("Order <b>#{$id}</b> deleted successfully.");

        return redirect()->route('orders.index');
    }
}

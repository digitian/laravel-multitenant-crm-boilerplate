<?php

namespace App\Http\Controllers\Authenticated;

use App\Enum\ProductSortBy;
use App\Enum\SortDirection;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of products with filtering and sorting.
     */
    public function index(Request $request): View
    {
        $sortBy = $request->enum('sort_by', ProductSortBy::class) ?? ProductSortBy::CreatedAt;
        $orderBy = $request->enum('order_by', SortDirection::class) ?? SortDirection::Desc;

        $products = Product::select('id', 'name', 'sku', 'amount', 'price', 'created_at')
            ->when($request->filled('search'), fn ($q) => $q->where(function ($q) use ($request) {
                $search = '%'.$request->string('search').'%';
                $q->where('name', 'like', $search)
                    ->orWhere('sku', 'like', $search);
            }))
            ->orderBy($sortBy->value, $orderBy->value)
            ->paginate(20)
            ->withQueryString();

        return view('pages.stock.index', compact('products'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): View
    {
        $product->load('createdBy:id,first_name,last_name');

        return view('pages.stock.show', compact('product'));
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $name = $product->name;

        $product->delete();

        flash()->success("Product <b>{$name}</b> deleted successfully.");

        return redirect()->route('stock.index');
    }
}

<?php

namespace App\Http\Controllers\Authenticated;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class StockController extends Controller
{
    public function index(): View
    {
        return view('pages.stock.index');
    }
}

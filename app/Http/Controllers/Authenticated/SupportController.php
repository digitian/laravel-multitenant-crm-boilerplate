<?php

namespace App\Http\Controllers\Authenticated;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class SupportController extends Controller
{
    public function index(): View
    {
        return view('pages.support.index');
    }
}

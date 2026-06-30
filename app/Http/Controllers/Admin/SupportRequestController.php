<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class SupportRequestController extends Controller
{
    public function index(): View
    {
        return view('admin.support.index');
    }
}

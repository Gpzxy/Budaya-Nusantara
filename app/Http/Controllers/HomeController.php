<?php

namespace App\Http\Controllers;

use App\Models\Culture;
use App\Models\CultureEntry;

class HomeController extends Controller
{
    public function index()
    {
        $cultures = Culture::published()->orderBy('sort_order')->orderBy('name')->get();

        return view('home', [
            'cultures'      => $cultures,
            'entryCount'    => CultureEntry::whereIn('culture_id', $cultures->pluck('id'))->count(),
            'provinceCount' => $cultures->pluck('province')->unique()->count(),
        ]);
    }
}

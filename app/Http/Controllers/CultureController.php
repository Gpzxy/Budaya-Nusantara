<?php

namespace App\Http\Controllers;

use App\Models\Culture;

class CultureController extends Controller
{
    public function show(string $slug)
    {
        $culture = Culture::published()->where('slug', $slug)->with('entries')->firstOrFail();

        $others = Culture::published()
            ->where('id', '!=', $culture->id)
            ->orderBy('sort_order')->orderBy('name')
            ->get(['id', 'slug', 'name']);

        return view('culture.show', compact('culture', 'others'));
    }
}

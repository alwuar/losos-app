<?php

namespace App\Http\Controllers;

use App\Support\Catalog;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __invoke(Catalog $catalog): View
    {
        return view('pages.about', [
            'brands' => $catalog->brands(),
        ]);
    }
}

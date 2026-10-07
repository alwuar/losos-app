<?php

namespace App\Http\Controllers;

use App\Support\Catalog;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __invoke(Catalog $catalog): View
    {
        return view('pages.services', [
            'services' => $catalog->services(),
        ]);
    }
}

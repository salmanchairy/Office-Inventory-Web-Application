<?php

namespace App\Http\Controllers;

class MapController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()?->role?->name === 'admin', 403);

        return view('maps.index');
    }
}

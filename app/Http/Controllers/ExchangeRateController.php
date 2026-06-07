<?php

namespace App\Http\Controllers;

class ExchangeRateController extends Controller
{
    public function index()
    {
        return view('index', [
            'updatedAt' => now()->format('d/m/Y H:i'),
        ]);
    }
}

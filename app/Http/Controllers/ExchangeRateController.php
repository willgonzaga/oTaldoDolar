<?php

namespace App\Http\Controllers;

use App\Services\ExchangeRateService;

class ExchangeRateController extends Controller
{
    public function index()
    {
        $service = new ExchangeRateService();
        $rates = $service->getAll();

        return view('index', [
            'rates' => $rates,
            'updatedAt' => now()->format('d/m/Y H:i'),
        ]);
    }
}

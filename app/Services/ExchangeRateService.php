<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ExchangeRateService
{
    private array $currencies = [
        'USD-BRL' => [
            'name' => 'Dólar Americano',
            'flag' => '🇺🇸',
            'color' => 'amber',
            'code' => 'USD',
        ],
        'EUR-BRL' => [
            'name' => 'Euro',
            'flag' => '🇪🇺',
            'color' => 'blue',
            'code' => 'EUR',
        ],
        'GBP-BRL' => [
            'name' => 'Libra Esterlina',
            'flag' => '🇬🇧',
            'color' => 'purple',
            'code' => 'GBP',
        ],
    ];

    public function getAll(): array
    {
        $rates = $this->fetchRates();

        if (!$rates) {
            return [];
        }

        $result = [];

        foreach ($this->currencies as $key => $meta) {
            $code = str_replace('-', '', $key);

            if (!isset($rates[$code])) {
                continue;
            }

            $data = $rates[$code];
            $bid = (float) ($data['bid'] ?? 0);
            $ask = (float) ($data['ask'] ?? 0);
            $high = (float) ($data['high'] ?? 0);
            $low = (float) ($data['low'] ?? 0);
            $varBid = (float) ($data['varBid'] ?? 0);
            $pctChange = (float) ($data['pctChange'] ?? 0);

            $result[] = [
                'meta' => $meta,
                'bid' => $bid,
                'ask' => $ask,
                'high' => $high,
                'low' => $low,
                'varBid' => $varBid,
                'pctChange' => $pctChange,
                'change' => $pctChange >= 0 ? 'up' : 'down',
                'updatedAt' => $data['create_date'] ?? null,
            ];
        }

        return $result;
    }

    private function fetchRates(): ?array
    {
        $keys = array_keys($this->currencies);
        $codes = implode(',', $keys);

        return Cache::remember('exchange_rates', 180, function () use ($codes) {
            $url = "https://economia.awesomeapi.com.br/json/last/{$codes}";

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_HTTPHEADER => ['Accept: application/json'],
            ]);

            $json = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($json === false || $httpCode !== 200) {
                return null;
            }

            return json_decode($json, true);
        });
    }
}

@extends('layouts.app')

@section('content')
    @if (empty($rates))
        <div class="loading">
            <div class="loading-spinner"></div>
        </div>
    @else
        <div class="grid">
            @foreach ($rates as $rate)
                @php
                    $color = $rate['meta']['color'];
                    $change = $rate['change'];
                    $arrow = $change === 'up' ? '↑' : '↓';
                @endphp

                <div class="card card-{{ $color }}">
                    <div class="card-glow" style="background: radial-gradient(circle, var(--{{ $color }}-glow), transparent 70%);"></div>

                    <div class="card-header">
                        <div class="flag">{{ $rate['meta']['flag'] }}</div>
                        <div class="currency-info">
                            <div class="currency-name">{{ $rate['meta']['name'] }}</div>
                            <div class="currency-code">{{ $rate['meta']['code'] }} / BRL</div>
                        </div>
                    </div>

                    <div class="rate">
                        <span class="rate-prefix">R$</span>
                        {{ number_format($rate['ask'], 4, ',', '.') }}
                    </div>

                    <div class="change change-{{ $change }}">
                        {{ $arrow }} {{ number_format(abs($rate['pctChange']), 2, ',', '.') }}%
                    </div>

                    <div class="details">
                        <div class="detail-item">
                            <span class="detail-label">Compra</span>
                            <span class="detail-value">R$ {{ number_format($rate['bid'], 4, ',', '.') }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Venda</span>
                            <span class="detail-value">R$ {{ number_format($rate['ask'], 4, ',', '.') }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Máxima</span>
                            <span class="detail-value">R$ {{ number_format($rate['high'], 4, ',', '.') }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Mínima</span>
                            <span class="detail-value">R$ {{ number_format($rate['low'], 4, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="card-updated">
                        @if ($rate['updatedAt'])
                            Atualizado em {{ \Carbon\Carbon::parse($rate['updatedAt'])->setTimezone('America/Sao_Paulo')->format('d/m/Y \à\s H:i') }}
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

@extends('layouts.app')

@section('content')
    <div class="loading" id="loading">
        <div class="loading-spinner"></div>
    </div>

    <div class="grid" id="grid" style="display:none"></div>

    <script>
        const currencies = [
            { key: 'USD-BRL', name: 'Dólar Americano', flag: '\u{1F1FA}\u{1F1F8}', color: 'amber', code: 'USD' },
            { key: 'EUR-BRL', name: 'Euro', flag: '\u{1F1EA}\u{1F1FA}', color: 'blue', code: 'EUR' },
            { key: 'GBP-BRL', name: 'Libra Esterlina', flag: '\u{1F1EC}\u{1F1E7}', color: 'purple', code: 'GBP' },
        ];

        function format(n) {
            return parseFloat(n).toFixed(4).replace('.', ',');
        }

        function render(rates) {
            const grid = document.getElementById('grid');
            const loading = document.getElementById('loading');

            const now = new Date();
            const updatedAt = now.toLocaleString('pt-BR', {
                day: '2-digit', month: '2-digit', year: 'numeric',
                hour: '2-digit', minute: '2-digit',
            });
            document.querySelector('.last-update').textContent =
                'Última atualização: ' + updatedAt;

            grid.innerHTML = '';

            currencies.forEach((cur) => {
                const key = cur.key.replace('-', '');
                const data = rates[key];
                if (!data) return;

                const bid = parseFloat(data.bid || 0);
                const ask = parseFloat(data.ask || 0);
                const high = parseFloat(data.high || 0);
                const low = parseFloat(data.low || 0);
                const pct = parseFloat(data.pctChange || 0);
                const change = pct >= 0 ? 'up' : 'down';
                const arrow = pct >= 0 ? '\u2191' : '\u2193';

                const createdAt = data.create_date
                    ? new Date(data.create_date.replace(' ', 'T') + '-03:00')
                          .toLocaleString('pt-BR', {
                              day: '2-digit', month: '2-digit', year: 'numeric',
                              hour: '2-digit', minute: '2-digit',
                          })
                    : '';

                grid.innerHTML += `
                    <div class="card card-${cur.color}">
                        <div class="card-glow" style="background: radial-gradient(circle, var(--${cur.color}-glow), transparent 70%);"></div>
                        <div class="card-header">
                            <div class="flag">${cur.flag}</div>
                            <div class="currency-info">
                                <div class="currency-name">${cur.name}</div>
                                <div class="currency-code">${cur.code} / BRL</div>
                            </div>
                        </div>
                        <div class="rate">
                            <span class="rate-prefix">R$</span>
                            ${format(data.ask)}
                        </div>
                        <div class="change change-${change}">
                            ${arrow} ${Math.abs(pct).toFixed(2).replace('.', ',')}%
                        </div>
                        <div class="details">
                            <div class="detail-item">
                                <span class="detail-label">Compra</span>
                                <span class="detail-value">R$ ${format(data.bid)}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Venda</span>
                                <span class="detail-value">R$ ${format(data.ask)}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Máxima</span>
                                <span class="detail-value">R$ ${format(data.high)}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Mínima</span>
                                <span class="detail-value">R$ ${format(data.low)}</span>
                            </div>
                        </div>
                        ${createdAt ? `<div class="card-updated">Atualizado em ${createdAt}</div>` : ''}
                    </div>
                `;
            });

            loading.style.display = 'none';
            grid.style.display = 'grid';
        }

        function fetchRates() {
            const url = 'https://economia.awesomeapi.com.br/json/last/USD-BRL,EUR-BRL,GBP-BRL';

            return fetch(url)
                .then((r) => r.json())
                .then((data) => render(data))
                .catch(() => {
                    document.getElementById('loading').innerHTML =
                        '<p style="color:var(--text-muted)">Não foi possível carregar as cotações.</p>';
                });
        }

        fetchRates();
        setInterval(fetchRates, 180000);
    </script>
@endsection

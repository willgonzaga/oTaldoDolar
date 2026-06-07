<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Acompanhe as cotações do Dólar, Euro e Libra Esterlina em tempo real. Taxas atualizadas com valor de compra e venda.">
    <title>@yield('title', 'oTalDoDolar - Cotações em Tempo Real')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #08080f;
            --bg-alt: #0d0d1a;
            --surface: rgba(255, 255, 255, 0.03);
            --border: rgba(255, 255, 255, 0.06);
            --border-hover: rgba(255, 255, 255, 0.12);
            --text: #e8e8ed;
            --text-muted: #8a8a9a;
            --amber: #f59e0b;
            --amber-glow: rgba(245, 158, 11, 0.15);
            --blue: #3b82f6;
            --blue-glow: rgba(59, 130, 246, 0.15);
            --purple: #8b5cf6;
            --purple-glow: rgba(139, 92, 246, 0.15);
            --green: #10b981;
            --red: #ef4444;
            --radius: 20px;
            --radius-sm: 12px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            line-height: 1.6;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 50% -20%, rgba(59, 130, 246, 0.08), transparent),
                radial-gradient(ellipse 60% 50% at 0% 100%, rgba(139, 92, 246, 0.06), transparent),
                radial-gradient(ellipse 60% 50% at 100% 100%, rgba(245, 158, 11, 0.06), transparent);
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 80px 80px;
            pointer-events: none;
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        header {
            padding: 48px 0 32px;
            text-align: center;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            background: linear-gradient(135deg, #f59e0b, #ef4444, #8b5cf6, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
            position: relative;
        }

        .logo::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #f59e0b, #ef4444, #8b5cf6, #3b82f6);
            border-radius: 2px;
            opacity: 0.6;
        }

        .subtitle {
            margin-top: 12px;
            color: var(--text-muted);
            font-size: 1.05rem;
            font-weight: 400;
            letter-spacing: 0.01em;
        }

        .last-update {
            margin-top: 8px;
            font-size: 0.82rem;
            color: var(--text-muted);
            opacity: 0.7;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 24px;
            padding: 16px 0 48px;
        }

        .card {
            background: var(--surface);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 32px;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: var(--radius) var(--radius) 0 0;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .card:hover::before {
            opacity: 1;
        }

        .card:hover {
            transform: translateY(-6px);
            border-color: var(--border-hover);
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.4);
        }

        .card-amber::before { background: linear-gradient(90deg, var(--amber), #fbbf24); }
        .card-amber:hover { border-color: rgba(245, 158, 11, 0.2); box-shadow: 0 24px 80px rgba(245, 158, 11, 0.06); }
        .card-blue::before { background: linear-gradient(90deg, var(--blue), #60a5fa); }
        .card-blue:hover { border-color: rgba(59, 130, 246, 0.2); box-shadow: 0 24px 80px rgba(59, 130, 246, 0.06); }
        .card-purple::before { background: linear-gradient(90deg, var(--purple), #a78bfa); }
        .card-purple:hover { border-color: rgba(139, 92, 246, 0.2); box-shadow: 0 24px 80px rgba(139, 92, 246, 0.06); }

        .card-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            border-radius: 50%;
            opacity: 0.03;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }

        .card:hover .card-glow {
            opacity: 0.06;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        .flag {
            font-size: 2.2rem;
            line-height: 1;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
            flex-shrink: 0;
        }

        .currency-info {
            flex: 1;
        }

        .currency-name {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text);
        }

        .currency-code {
            font-size: 0.82rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .rate {
            font-size: 3rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            line-height: 1.1;
            margin-bottom: 20px;
            font-variant-numeric: tabular-nums;
        }

        .rate-prefix {
            font-size: 1.2rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-right: 4px;
        }

        .change {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 100px;
        }

        .change-up {
            color: var(--green);
            background: rgba(16, 185, 129, 0.1);
        }

        .change-down {
            color: var(--red);
            background: rgba(239, 68, 68, 0.1);
        }

        .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.72rem;
            font-weight: 500;
            color: var(--text-muted);
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 600;
            margin-top: 2px;
            font-variant-numeric: tabular-nums;
        }

        .card-updated {
            margin-top: 16px;
            font-size: 0.78rem;
            color: var(--text-muted);
            opacity: 0.6;
        }

        footer {
            text-align: center;
            padding: 32px 0 48px;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
        }

        footer p {
            font-size: 0.82rem;
            color: var(--text-muted);
            opacity: 0.6;
        }

        footer a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        footer a:hover {
            color: var(--text);
        }

        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 400px;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(255, 255, 255, 0.06);
            border-top-color: var(--amber);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            animation: fadeIn 0.6s ease backwards;
        }

        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }

        @media (max-width: 768px) {
            header { padding: 32px 0 24px; }
            .logo { font-size: 1.8rem; }
            .grid { grid-template-columns: 1fr; gap: 16px; padding: 8px 0 32px; }
            .card { padding: 24px; }
            .rate { font-size: 2.2rem; }
            .flag { font-size: 1.8rem; width: 40px; height: 40px; }
        }

        @media (max-width: 480px) {
            .container { padding: 0 16px; }
            .details { grid-template-columns: 1fr 1fr; gap: 8px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">oTalDoDolar</div>
            <p class="subtitle">Acompanhe as cotações das principais moedas em tempo real</p>
            <p class="last-update">Última atualização: {{ $updatedAt ?? '—' }}</p>
        </header>

        <main>
            @yield('content')
        </main>

        <footer>
            <p>
                Dados fornecidos por <a href="https://economia.awesomeapi.com.br" target="_blank" rel="noopener">AwesomeAPI</a>
                &middot; As cotações são atualizadas automaticamente a cada 3 minutos
            </p>
        </footer>
    </div>
</body>
</html>

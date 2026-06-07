# oTalDoDolar

Um site simples pra acompanhar a cotação do Dólar, Euro e Libra em tempo real. Os dados vêm da AwesomeAPI e são atualizados a cada 3 minutos.

## Como rodar com Docker

Você precisa ter o Docker instalado na máquina.

```bash
# Sobe o projeto
APP_PORT=8080 docker compose up -d

# Depois é só abrir no navegador
# http://localhost:8080
```

Se quiser mudar a porta, é só trocar o número:

```bash
APP_PORT=3000 docker compose up -d
```

Pra parar:

```bash
docker compose down
```

Pra ver os logs:

```bash
docker compose logs -f
```

## Como rodar sem Docker (na unha)

Se tiver PHP 8.2+ e Composer instalados:

```bash
# Instala as dependências
composer install

# Gera a chave da aplicação
php artisan key:generate

# Sobe o servidor
php artisan serve

# Abre em http://localhost:8000
```

## Deploy na Vercel

O projeto já vem configurado pra rodar na Vercel. Precisa do `vercel-php` runtime.

1. Instala a CLI da Vercel: `npm i -g vercel`
2. Roda `vercel deploy --prod`
3. No dashboard da Vercel, cria as variáveis de ambiente:

| Variável | Valor |
|---|---|
| `APP_KEY` | Roda `php artisan key:generate --show` e cola o resultado |
| `CACHE_DRIVER` | `array` |
| `SESSION_DRIVER` | `array` |
| `LOG_CHANNEL` | `stderr` |
| `VIEW_COMPILED_PATH` | `/tmp/views` |

## O que mostra na tela

- Cotação atual (venda)
- Valor de compra
- Máxima e mínima do dia
- Variação percentual
- Quando foi atualizado pela última vez

Cada moeda tem um card com a bandeira e um resumo completo.

## Tecnologias

- Laravel 11
- PHP 8.3
- Docker + Nginx
- AwesomeAPI (dados de câmbio)

## Estrutura

```
├── api/              # Entrypoint pra Vercel
├── app/              # Código da aplicação
├── config/           # Configurações do Laravel
├── docker/           # Configuração do Nginx pro Docker
├── resources/views/  # Templates das páginas
├── routes/           # Rotas
├── Dockerfile
├── docker-compose.yml
└── vercel.json
```

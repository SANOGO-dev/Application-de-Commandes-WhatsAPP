<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $shop->nom)</title>
    <style>
        :root { --c: {{ $shop->couleur }}; --bg: #f6f7f8; --card: #fff; --txt: #1b1f23; --muted: #6b7280; --line: #e5e7eb; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; background: var(--bg); color: var(--txt); }
        a { color: inherit; text-decoration: none; }
        .top { position: sticky; top: 0; z-index: 10; background: var(--c); color: #fff; display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; }
        .top .brand { font-weight: 700; font-size: 18px; }
        .cart-link { background: rgba(255,255,255,.2); padding: 8px 12px; border-radius: 999px; font-size: 14px; }
        .badge { background: #fff; color: var(--c); border-radius: 999px; padding: 1px 7px; font-weight: 700; margin-left: 4px; font-size: 12px; }
        .wrap { max-width: 900px; margin: 0 auto; padding: 16px; }
        .alert { padding: 10px 14px; border-radius: 10px; margin-bottom: 12px; font-size: 14px; }
        .ok { background: #dcfce7; color: #166534; }
        .err { background: #fee2e2; color: #991b1b; }
        .err ul { margin: 0; padding-left: 18px; }
        .pills { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 8px; margin-bottom: 12px; }
        .pill { white-space: nowrap; padding: 7px 14px; border-radius: 999px; background: var(--card); border: 1px solid var(--line); font-size: 14px; }
        .pill.on { background: var(--c); color: #fff; border-color: var(--c); }
        .grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
        @media (min-width: 700px) { .grid { grid-template-columns: repeat(3, 1fr); } }
        .card { background: var(--card); border: 1px solid var(--line); border-radius: 14px; overflow: hidden; display: flex; flex-direction: column; }
        .img { aspect-ratio: 1 / 1; background: #e5e7eb; display: flex; align-items: center; justify-content: center; font-size: 40px; overflow: hidden; }
        .img img { width: 100%; height: 100%; object-fit: cover; }
        .card .body { padding: 10px; display: flex; flex-direction: column; gap: 6px; flex: 1; }
        .nom { font-weight: 600; font-size: 15px; }
        .prix { color: var(--c); font-weight: 700; }
        .btn { display: inline-block; width: 100%; border: 0; background: var(--c); color: #fff; padding: 11px; border-radius: 10px; font-size: 15px; font-weight: 600; text-align: center; cursor: pointer; }
        .btn.sec { background: #fff; color: var(--c); border: 1px solid var(--c); }
        .btn[disabled] { background: #d1d5db; color: #fff; cursor: not-allowed; }
        .box { background: var(--card); border: 1px solid var(--line); border-radius: 14px; padding: 14px; margin-bottom: 12px; }
        .row { display: flex; justify-content: space-between; align-items: center; gap: 10px; }
        .line { display: flex; gap: 12px; padding: 12px 0; border-bottom: 1px solid var(--line); }
        .line:last-child { border-bottom: 0; }
        .thumb { width: 64px; height: 64px; border-radius: 10px; overflow: hidden; background: #e5e7eb; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
        .thumb img { width: 100%; height: 100%; object-fit: cover; }
        .grow { flex: 1; min-width: 0; }
        .qty { width: 70px; padding: 8px; border: 1px solid var(--line); border-radius: 8px; font-size: 16px; }
        .muted { color: var(--muted); font-size: 14px; }
        .link-red { background: none; border: 0; color: #dc2626; font-size: 13px; cursor: pointer; padding: 0; }
        label { display: block; font-size: 14px; font-weight: 600; margin: 12px 0 4px; }
        input[type=text], input[type=tel], textarea { width: 100%; padding: 11px; border: 1px solid var(--line); border-radius: 10px; font-size: 16px; font-family: inherit; }
        .total { font-size: 18px; font-weight: 700; }
        .foot { text-align: center; color: var(--muted); font-size: 12px; padding: 24px 0; }
        h1 { font-size: 22px; margin: 0 0 6px; }
    </style>
</head>
<body>
    <header class="top">
        <a href="{{ route('shop.show', $shop) }}" class="brand">{{ $shop->nom }}</a>
        <a href="{{ route('cart.index', $shop) }}" class="cart-link">🛒 Panier <span class="badge">{{ $cartCount ?? 0 }}</span></a>
    </header>
 
    <main class="wrap">
        @if (session('success'))
            <div class="alert ok">{{ session('success') }}</div>
        @endif
 
        @if ($errors->any())
            <div class="alert err">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
 
        @yield('content')
    </main>
 
    <footer class="foot">{{ $shop->nom }} · Commande simple via WhatsApp</footer>
</body>
</html>
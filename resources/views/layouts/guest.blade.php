<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('inventory-icon.svg') }}">
    <style>
        :root { color: #172033; background: #f4f7fb; font-family: system-ui, sans-serif; }
        body { margin: 0; }
        a { color: #2563eb; }
        .page { max-width: 960px; margin: auto; padding: 32px; }
        .auth-card { max-width: 400px; margin: 8vh auto; padding: 32px; background: #fff; border-radius: 16px; box-shadow: 0 12px 32px #1c29401a; }
        .form-label { display: block; margin-top: 16px; font-weight: 600; }
        .form-input { box-sizing: border-box; width: 100%; padding: 10px; margin-top: 6px; border: 1px solid #cbd5e1; border-radius: 7px; }
        .form-check { width: auto; }
        .button { display: inline-block; padding: 11px 18px; color: #fff; text-decoration: none; background: #2563eb; border: 0; border-radius: 8px; font: inherit; cursor: pointer; }
        .button.full-width { width: 100%; margin-top: 24px; }
        .button.secondary { color: #1e40af; background: #e8eefb; }
        .alert { padding: 10px 12px; margin-top: 8px; border-radius: 7px; }
        .alert.error { color: #b91c1c; background: #fef2f2; }
        .alert.info { color: #1e40af; background: #eff6ff; }
        .muted { color: #60708a; }
    </style>
    @stack('styles')
</head>
<body>
    @yield('content')

    @include('partials._footer')
</body>
</html>

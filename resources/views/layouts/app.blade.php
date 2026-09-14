<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('inventory-icon.svg') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">
    <style>
        :root { color: #172033; background: #f4f7fb; font-family: system-ui, sans-serif; }
        body { margin: 0; }
        .page { max-width: 960px; margin: auto; padding: 32px; }
        .nav { display: flex; align-items: center; justify-content: space-between; }
        .nav-actions, .form-actions, .page-heading { display: flex; gap: 12px; align-items: center; justify-content: space-between; }
        .card { margin-top: 48px; padding: 40px; background: #fff; border-radius: 16px; box-shadow: 0 12px 32px #1c29401a; }
        .button { display: inline-block; padding: 11px 18px; color: #fff; text-decoration: none; background: #2563eb; border: 0; border-radius: 8px; font: inherit; cursor: pointer; }
        .button.secondary { color: #1e40af; background: #e8eefb; }
        .form-card { max-width: 640px; }
        .form-label { display: block; margin-top: 16px; font-weight: 600; }
        .form-input { box-sizing: border-box; width: 100%; padding: 10px; margin-top: 6px; border: 1px solid #cbd5e1; border-radius: 7px; }
        .form-check { width: auto; }
        .choice-group { display: grid; gap: 8px; margin: 24px 0 0; padding: 16px; border: 1px solid #cbd5e1; border-radius: 8px; }
        .choice-group legend { padding: 0 4px; font-weight: 600; }
        .choice-label { font-weight: 400; }
        .help-text { margin: 0; color: #64748b; font-size: .9rem; }
        .form-actions { justify-content: flex-start; margin-top: 24px; }
        .search-form { margin-top: 24px; }
        .search-label { display: block; margin-bottom: 6px; font-weight: 600; }
        .search-controls { display: flex; gap: 8px; align-items: end; }
        .search-controls .form-input { margin-top: 0; }
        .alert { padding: 10px 12px; margin-top: 12px; color: #1e40af; background: #eff6ff; border-radius: 7px; }
        .alert.error { color: #b91c1c; background: #fef2f2; }
        .table-wrap { overflow-x: auto; margin-top: 24px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .align-right { text-align: right; }
        .inline-form { display: inline; margin-left: 12px; }
        .link-button { padding: 0; color: #b91c1c; background: none; border: 0; cursor: pointer; font: inherit; }
        .icon-action { position: relative; display: inline-grid; width: 34px; height: 34px; place-items: center; color: #1e40af; text-decoration: none; background: #eff6ff; border: 0; border-radius: 6px; cursor: pointer; }
        .icon-action.delete { color: #b91c1c; background: #fef2f2; }
        .icon-action::after { position: absolute; bottom: calc(100% + 8px); left: 50%; z-index: 1; padding: 5px 8px; color: #fff; content: attr(data-tooltip); white-space: nowrap; visibility: hidden; background: #172033; border-radius: 4px; opacity: 0; transform: translateX(-50%); transition: opacity .15s; font-size: .75rem; }
        .icon-action:hover::after, .icon-action:focus-visible::after { visibility: visible; opacity: 1; }
        .role-badge { padding: 3px 8px; color: #1e40af; background: #dbeafe; border-radius: 999px; font-size: .85rem; }
        .pagination { display: flex; gap: 16px; align-items: center; justify-content: space-between; margin-top: 24px; }
        .pagination-summary { margin: 0; color: #475569; }
        .pagination-links { display: flex; gap: 4px; }
        .pagination-link { min-width: 34px; padding: 7px 10px; color: #1e40af; text-align: center; text-decoration: none; background: #eff6ff; border-radius: 6px; }
        .pagination-link:hover, .pagination-link.active { color: #fff; background: #2563eb; }
        .pagination-link.disabled { color: #94a3b8; background: #f1f5f9; cursor: not-allowed; }
        .admin-shell { display: flex; min-height: 100vh; }
        .admin-sidebar { display: flex; flex: 0 0 240px; flex-direction: column; min-height: 100vh; color: #dbeafe; background: #172554; transition: flex-basis .2s; }
        .sidebar-header { display: flex; align-items: center; justify-content: space-between; padding: 20px; }
        .sidebar-brand, .sidebar-link { display: flex; gap: 12px; align-items: center; color: inherit; text-decoration: none; }
        .sidebar-menu { display: grid; gap: 6px; padding: 12px; }
        .sidebar-link { padding: 12px; background: transparent; border: 0; border-radius: 8px; font: inherit; text-align: left; cursor: pointer; }
        .sidebar-link:hover, .sidebar-link.active { color: #fff; background: #1d4ed8; }
        .sidebar-icon { flex: 0 0 20px; text-align: center; }
        .sidebar-toggle { padding: 8px; color: #dbeafe; background: transparent; border: 0; cursor: pointer; font-size: 1.2rem; }
        .sidebar-footer { margin-top: auto; padding: 12px; }
        .sidebar-logout { width: 100%; color: #dbeafe; }
        .admin-content { flex: 1; min-width: 0; }
        .admin-sidebar.collapsed { flex-basis: 64px; }
        .admin-sidebar.collapsed .sidebar-label { display: none; }
        .admin-sidebar.collapsed .sidebar-header { justify-content: center; }
        @media (max-width: 640px) { .page { padding: 20px; } .admin-sidebar { flex-basis: 64px; } .admin-sidebar .sidebar-label { display: none; } .admin-sidebar .sidebar-header { justify-content: center; } .page-heading, .pagination, .search-controls { align-items: flex-start; flex-direction: column; } .search-controls { align-items: stretch; } }
    </style>
    @stack('styles')
</head>
<body>
    @if (auth()->user()->isAdmin())
        <div class="admin-shell">
            @include('partials._admin_sidebar')

            <main class="admin-content page">
                @yield('content')
            </main>
        </div>
    @else
        <main class="page">
            @include('partials._nav')

            @yield('content')
        </main>
    @endif

    <script>
        const sidebar = document.getElementById('admin-sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');

        sidebarToggle?.addEventListener('click', () => {
            const isCollapsed = sidebar.classList.toggle('collapsed');
            sidebarToggle.setAttribute('aria-expanded', String(!isCollapsed));
        });
    </script>
</body>
</html>

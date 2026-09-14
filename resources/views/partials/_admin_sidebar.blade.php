<aside id="admin-sidebar" class="admin-sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <span class="sidebar-icon">▣</span>
            <span class="sidebar-label">{{ config('app.name') }}</span>
        </a>
        <button id="sidebar-toggle" class="sidebar-toggle" type="button" aria-label="Toggle navigation" aria-expanded="true">
            ☰
        </button>
    </div>

    <nav class="sidebar-menu" aria-label="Admin navigation">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="sidebar-icon">⌂</span>
            <span class="sidebar-label">Home</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <span class="sidebar-icon">♙</span>
            <span class="sidebar-label">Active users</span>
        </a>
        <a href="{{ route('admin.roles.index') }}" class="sidebar-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fa-solid fa-user-tag"></i></span>
            <span class="sidebar-label">Roles</span>
        </a>
        <a href="{{ route('admin.privileges.index') }}" class="sidebar-link {{ request()->routeIs('admin.privileges.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fa-solid fa-key"></i></span>
            <span class="sidebar-label">Privileges</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fa-solid fa-box"></i></span>
            <span class="sidebar-label">Products</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <span class="sidebar-label">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="sidebar-link sidebar-logout" type="submit">
                <span class="sidebar-icon">↪</span>
                <span class="sidebar-label">Log out</span>
            </button>
        </form>
    </div>
</aside>

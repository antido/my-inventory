<nav class="nav">
    <a href="{{ route('home') }}"><strong>{{ config('app.name') }}</strong></a>

    <div class="nav-actions">
        <span>{{ auth()->user()->name }}</span>
        <x-button :href="route('home')" variant="secondary">Home</x-button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-button type="submit">Log out</x-button>
        </form>
    </div>
</nav>

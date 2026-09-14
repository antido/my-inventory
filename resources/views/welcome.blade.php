@extends('layouts.guest')

@section('title', config('app.name'))

@push('styles')
    <style>
        .landing-nav { display: flex; align-items: center; justify-content: space-between; }
        .landing-actions { display: flex; gap: 12px; align-items: center; }
        .landing-card { margin-top: 96px; padding: 56px; background: #fff; border-radius: 18px; box-shadow: 0 12px 32px #1c29401a; }
    </style>
@endpush

@section('content')
    <main class="page">
        <nav class="landing-nav">
            <strong>{{ config('app.name') }}</strong>

            <div class="landing-actions">
                @auth
                    <x-button :href="route('dashboard')" variant="secondary">Dashboard</x-button>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-button type="submit">Log out</x-button>
                    </form>
                @else
                    <x-button :href="route('login')" variant="secondary">Log in</x-button>
                    <x-button :href="route('register')">Sign up</x-button>
                @endauth
            </div>
        </nav>

        <section class="landing-card">
            <p class="muted">Welcome</p>
            <h1>Manage your inventory with confidence.</h1>
            <p class="muted">Sign in to access your account, or create one to get started.</p>

            @guest
                <x-button :href="route('register')">Create an account</x-button>
            @endguest
        </section>
    </main>
@endsection

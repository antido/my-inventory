@extends('layouts.guest')

@section('title', 'Log in')

@section('content')
    <main class="auth-card">
        <h1>Log in</h1>
        <p>Welcome back to {{ config('app.name') }}.</p>

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <label class="form-label">
                Email
                <input class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </label>
            @error('email')
                <x-alert type="error">{{ $message }}</x-alert>
            @enderror

            <label class="form-label">
                Password
                <input class="form-input" type="password" name="password" required>
            </label>
            @error('password')
                <x-alert type="error">{{ $message }}</x-alert>
            @enderror

            <label class="form-label" style="font-weight: 400">
                <input class="form-check" type="checkbox" name="remember">
                Remember me
            </label>

            <x-button type="submit" :full-width="true">Log in</x-button>
        </form>

        <p>New here? <a href="{{ route('register') }}">Sign up</a></p>
    </main>
@endsection

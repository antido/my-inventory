@extends('layouts.guest')

@section('title', 'Sign up')

@section('content')
    <main class="auth-card">
        <h1>Create your account</h1>
        <p>Start using {{ config('app.name') }}.</p>

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <label class="form-label">
                Name
                <input class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus>
            </label>
            @error('name')
                <x-alert type="error">{{ $message }}</x-alert>
            @enderror

            <label class="form-label">
                Email
                <input class="form-input" type="email" name="email" value="{{ old('email') }}" required>
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

            <label class="form-label">
                Confirm password
                <input class="form-input" type="password" name="password_confirmation" required>
            </label>

            <x-button type="submit" :full-width="true">Sign up</x-button>
        </form>

        <p>Already have an account? <a href="{{ route('login') }}">Log in</a></p>
    </main>
@endsection

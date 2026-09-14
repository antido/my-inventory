@extends('layouts.app')

@section('title', 'Admin dashboard')

@section('content')
    <section class="card">
        <h1>Admin dashboard</h1>
        <p>Welcome, {{ auth()->user()->name }}. You have administrator access.</p>
    </section>
@endsection

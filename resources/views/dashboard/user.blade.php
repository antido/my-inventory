@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="card">
        <h1>Welcome, {{ auth()->user()->name }}</h1>
        <p>You are signed in successfully.</p>
    </section>
@endsection

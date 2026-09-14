@extends('layouts.app')

@section('title', 'Edit user')

@section('content')
    <section class="card form-card">
        <h1>Edit user</h1>
        <p>Update {{ $user->name }}'s account details.</p>

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            @include('admin.users._form')
        </form>
    </section>
@endsection

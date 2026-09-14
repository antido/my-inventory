@extends('layouts.app')

@section('title', 'Add user')

@section('content')
    <section class="card form-card">
        <h1>Add user</h1>
        <p>Create an administrator or standard user account.</p>

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            @include('admin.users._form')
        </form>
    </section>
@endsection

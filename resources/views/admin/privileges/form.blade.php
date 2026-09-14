@extends('layouts.app')

@section('title', $privilege->exists ? 'Edit privilege' : 'Add privilege')

@section('content')
    <div class="card form-card"><h1>{{ $privilege->exists ? 'Edit privilege' : 'Add privilege' }}</h1><p>Use a clear action name, such as <code>view reports</code>.</p>
        <form method="POST" action="{{ $privilege->exists ? route('admin.privileges.update', $privilege) : route('admin.privileges.store') }}">@csrf @if ($privilege->exists) @method('PUT') @endif
            <label class="form-label">Privilege name <input class="form-input" name="name" value="{{ old('name', $privilege->name) }}" required autofocus></label>
            @error('name') <x-alert type="error">{{ $message }}</x-alert> @enderror
            <div class="form-actions"><x-button type="submit">{{ $privilege->exists ? 'Save changes' : 'Create privilege' }}</x-button><x-button :href="route('admin.privileges.index')" variant="secondary">Cancel</x-button></div>
        </form>
    </div>
@endsection

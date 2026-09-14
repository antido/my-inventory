@extends('layouts.app')

@section('title', $role->exists ? 'Edit role' : 'Add role')

@section('content')
    <div class="card form-card">
        <h1>{{ $role->exists ? 'Edit role' : 'Add role' }}</h1>
        <p>Assign the privileges that members of this role inherit.</p>
        <form method="POST" action="{{ $role->exists ? route('admin.roles.update', $role) : route('admin.roles.store') }}">
            @csrf
            @if ($role->exists) @method('PUT') @endif
            <label class="form-label">Role name <input class="form-input" name="name" value="{{ old('name', $role->name) }}" required autofocus></label>
            @error('name') <x-alert type="error">{{ $message }}</x-alert> @enderror
            <fieldset class="choice-group">
                <legend>Privileges</legend>
                @forelse ($privileges as $privilege)
                    <label class="choice-label"><input type="checkbox" name="privilege_ids[]" value="{{ $privilege->id }}" @checked(in_array($privilege->id, old('privilege_ids', $role->privileges->pluck('id')->all())))> {{ $privilege->name }}</label>
                @empty
                    <p class="help-text">Create privileges before assigning them to a role.</p>
                @endforelse
            </fieldset>
            @error('privilege_ids') <x-alert type="error">{{ $message }}</x-alert> @enderror
            <div class="form-actions"><x-button type="submit">{{ $role->exists ? 'Save changes' : 'Create role' }}</x-button><x-button :href="route('admin.roles.index')" variant="secondary">Cancel</x-button></div>
        </form>
    </div>
@endsection

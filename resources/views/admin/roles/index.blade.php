@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Roles</h1>
            <p>Group privileges together and assign them to users.</p>
        </div>
        <x-button :href="route('admin.roles.create')">Add role</x-button>
    </div>

    @if (session('status')) <x-alert>{{ session('status') }}</x-alert> @endif

    <div class="table-wrap">
        <table>
            <thead><tr><th>Role</th><th>Privileges</th><th>Users</th><th class="align-right">Actions</th></tr></thead>
            <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td><td>{{ $role->privileges_count }}</td><td>{{ $role->users_count }}</td>
                        <td class="align-right">
                            <a class="icon-action" href="{{ route('admin.roles.edit', $role) }}" data-tooltip="Edit role" aria-label="Edit {{ $role->name }}"><i class="fa-solid fa-pen"></i></a>
                            <form class="inline-form" method="POST" action="{{ route('admin.roles.destroy', $role) }}">@csrf @method('DELETE')<button class="icon-action delete" type="submit" data-tooltip="Delete role" aria-label="Delete {{ $role->name }}" onclick="return confirm('Delete this role?')"><i class="fa-solid fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">No managed roles found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

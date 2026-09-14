@extends('layouts.app')

@section('title', 'Privileges')

@section('content')
    <div class="page-heading"><div><h1>Privileges</h1><p>Define the individual actions that can be granted.</p></div><x-button :href="route('admin.privileges.create')">Add privilege</x-button></div>
    @if (session('status')) <x-alert>{{ session('status') }}</x-alert> @endif
    <div class="table-wrap"><table><thead><tr><th>Privilege</th><th>Roles</th><th>Direct users</th><th class="align-right">Actions</th></tr></thead><tbody>
        @forelse ($privileges as $privilege)
            <tr><td>{{ $privilege->name }}</td><td>{{ $privilege->roles_count }}</td><td>{{ $privilege->users_count }}</td><td class="align-right"><a class="icon-action" href="{{ route('admin.privileges.edit', $privilege) }}" data-tooltip="Edit privilege" aria-label="Edit {{ $privilege->name }}"><i class="fa-solid fa-pen"></i></a><form class="inline-form" method="POST" action="{{ route('admin.privileges.destroy', $privilege) }}">@csrf @method('DELETE')<button class="icon-action delete" type="submit" data-tooltip="Delete privilege" aria-label="Delete {{ $privilege->name }}" onclick="return confirm('Delete this privilege?')"><i class="fa-solid fa-trash"></i></button></form></td></tr>
        @empty
            <tr><td colspan="4">No privileges found.</td></tr>
        @endforelse
    </tbody></table></div>
@endsection

@extends('layouts.app')

@section('title', 'Active users')

@section('content')
    <section class="card">
        <div class="page-heading">
            <div>
                <h1>Active users</h1>
                <p>Manage accounts that can sign in to the system.</p>
            </div>
            <x-button :href="route('admin.users.create')">Add user</x-button>
        </div>

        @if (session('status'))
            <x-alert>{{ session('status') }}</x-alert>
        @endif

        @error('user')
            <x-alert type="error">{{ $message }}</x-alert>
        @enderror

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="align-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="role-badge">{{ ucfirst($user->role->value) }}</span></td>
                            <td class="align-right">
                                <a
                                    class="icon-action"
                                    href="{{ route('admin.users.edit', $user) }}"
                                    data-tooltip="Edit user"
                                    aria-label="Edit {{ $user->name }}"
                                >
                                    <i class="fa-solid fa-pencil" aria-hidden="true"></i>
                                </a>
                                @if (! $user->is(auth()->user()))
                                    <form class="inline-form" method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="icon-action delete"
                                            type="submit"
                                            data-tooltip="Delete user"
                                            aria-label="Delete {{ $user->name }}"
                                            onclick="return confirm('Delete this user?')"
                                        >
                                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No active users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-pagination :paginator="$users" />
    </section>
@endsection

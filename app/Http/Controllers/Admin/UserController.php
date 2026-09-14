<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Privilege;
use Illuminate\Support\Arr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()
                ->with(['roles.privileges', 'privileges'])
                ->where('is_active', true)
                ->orderBy('name')
                ->paginate(15)
                ->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return $this->form(new User);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $this->saveUser(new User, $this->validatedUser($request));

        return redirect()->route('admin.users.index')
            ->with('status', "{$user->name} was added successfully.");
    }

    public function edit(User $user): View
    {
        return $this->form($user->load(['roles', 'privileges']));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->saveUser($user, $this->validatedUser($request, $user));

        return redirect()->route('admin.users.index')
            ->with('status', "{$user->name} was updated successfully.");
    }

    private function form(User $user): View
    {
        return view($user->exists ? 'admin.users.edit' : 'admin.users.create', [
            'user' => $user,
            'roles' => Role::query()->orderBy('name')->get(),
            'privileges' => Privilege::query()->orderBy('name')->get(),
        ]);
    }

    /** @param array<string, mixed> $data */
    private function saveUser(User $user, array $data): User
    {
        $roleIds = Arr::pull($data, 'role_ids', []);
        $privilegeIds = Arr::pull($data, 'privilege_ids', []);
        if ($user->exists) {
            $user->update($data);
        } else {
            $user = User::create($data);
        }
        $user->roles()->sync($roleIds);
        $user->privileges()->sync($privilegeIds);

        return $user;
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->is(auth()->user())) {
            return back()->withErrors(['user' => 'You cannot delete your own account.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('status', 'User deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedUser(Request $request, ?User $user = null): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'role' => ['required', Rule::in(array_map(
                fn (UserRole $role): string => $role->value,
                UserRole::cases(),
            ))],
            'is_active' => ['nullable', 'boolean'],
            'role_ids' => ['nullable', 'array'],
            'role_ids.*' => ['integer', Rule::exists('roles', 'id')],
            'privilege_ids' => ['nullable', 'array'],
            'privilege_ids.*' => ['integer', Rule::exists('privileges', 'id')],
        ];

        $rules['password'] = $user
            ? ['nullable', 'confirmed', 'min:8']
            : ['required', 'confirmed', 'min:8'];

        $validated = $request->validate($rules);
        $validated['is_active'] = $request->boolean('is_active');

        if (blank($validated['password'])) {
            unset($validated['password']);
        }

        return $validated;
    }
}

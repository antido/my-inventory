<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Privilege;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        return view('admin.roles.index', [
            'roles' => Role::query()->withCount(['users', 'privileges'])->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return $this->form(new Role);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedRole($request);
        $role = Role::create(['name' => $data['name']]);
        $role->privileges()->sync($data['privilege_ids'] ?? []);

        return redirect()->route('admin.roles.index')->with('status', "{$role->name} role was added successfully.");
    }

    public function edit(Role $role): View
    {
        return $this->form($role->load('privileges'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $data = $this->validatedRole($request, $role);
        $role->update(['name' => $data['name']]);
        $role->privileges()->sync($data['privilege_ids'] ?? []);

        return redirect()->route('admin.roles.index')->with('status', "{$role->name} role was updated successfully.");
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return redirect()->route('admin.roles.index')->with('status', 'Role deleted successfully.');
    }

    private function form(Role $role): View
    {
        return view('admin.roles.form', [
            'role' => $role,
            'privileges' => Privilege::query()->orderBy('name')->get(),
        ]);
    }

    /** @return array<string, mixed> */
    private function validatedRole(Request $request, ?Role $role = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role)],
            'privilege_ids' => ['nullable', 'array'],
            'privilege_ids.*' => ['integer', Rule::exists('privileges', 'id')],
        ]);
    }
}

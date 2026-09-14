<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Privilege;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PrivilegeController extends Controller
{
    public function index(): View
    {
        return view('admin.privileges.index', [
            'privileges' => Privilege::query()->withCount(['users', 'roles'])->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.privileges.form', ['privilege' => new Privilege]);
    }

    public function store(Request $request): RedirectResponse
    {
        $privilege = Privilege::create($this->validatedPrivilege($request));

        return redirect()->route('admin.privileges.index')->with('status', "{$privilege->name} privilege was added successfully.");
    }

    public function edit(Privilege $privilege): View
    {
        return view('admin.privileges.form', compact('privilege'));
    }

    public function update(Request $request, Privilege $privilege): RedirectResponse
    {
        $privilege->update($this->validatedPrivilege($request, $privilege));

        return redirect()->route('admin.privileges.index')->with('status', "{$privilege->name} privilege was updated successfully.");
    }

    public function destroy(Privilege $privilege): RedirectResponse
    {
        $privilege->delete();

        return redirect()->route('admin.privileges.index')->with('status', 'Privilege deleted successfully.');
    }

    /** @return array<string, string> */
    private function validatedPrivilege(Request $request, ?Privilege $privilege = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('privileges')->ignore($privilege)],
        ]);
    }
}

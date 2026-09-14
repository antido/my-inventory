@php($isEditing = $user->exists)

<label class="form-label">
    Name
    <input class="form-input" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus>
</label>
@error('name')
    <x-alert type="error">{{ $message }}</x-alert>
@enderror

<label class="form-label">
    Email
    <input class="form-input" type="email" name="email" value="{{ old('email', $user->email) }}" required>
</label>
@error('email')
    <x-alert type="error">{{ $message }}</x-alert>
@enderror

<label class="form-label">
    Role
    <select class="form-input" name="role" required>
        @foreach (\App\Enums\UserRole::cases() as $role)
            <option value="{{ $role->value }}" @selected(old('role', $user->role?->value ?? 'user') === $role->value)>
                {{ ucfirst($role->value) }}
            </option>
        @endforeach
    </select>
</label>
@error('role')
    <x-alert type="error">{{ $message }}</x-alert>
@enderror

<fieldset class="choice-group">
    <legend>Managed roles</legend>
    <p class="help-text">Roles group reusable privileges for this user.</p>
    @forelse ($roles as $managedRole)
        <label class="choice-label">
            <input type="checkbox" name="role_ids[]" value="{{ $managedRole->id }}"
                @checked(in_array($managedRole->id, old('role_ids', $user->roles->pluck('id')->all())))>
            {{ $managedRole->name }}
        </label>
    @empty
        <p class="help-text">Create a managed role first.</p>
    @endforelse
</fieldset>
@error('role_ids')
    <x-alert type="error">{{ $message }}</x-alert>
@enderror

<fieldset class="choice-group">
    <legend>Direct privileges</legend>
    <p class="help-text">These are granted in addition to privileges inherited from managed roles.</p>
    @forelse ($privileges as $privilege)
        <label class="choice-label">
            <input type="checkbox" name="privilege_ids[]" value="{{ $privilege->id }}"
                @checked(in_array($privilege->id, old('privilege_ids', $user->privileges->pluck('id')->all())))>
            {{ $privilege->name }}
        </label>
    @empty
        <p class="help-text">Create a privilege first.</p>
    @endforelse
</fieldset>
@error('privilege_ids')
    <x-alert type="error">{{ $message }}</x-alert>
@enderror

<label class="form-label">
    Password {{ $isEditing ? '(leave blank to keep current password)' : '' }}
    <input class="form-input" type="password" name="password" {{ $isEditing ? '' : 'required' }}>
</label>
@error('password')
    <x-alert type="error">{{ $message }}</x-alert>
@enderror

<label class="form-label">
    Confirm password
    <input class="form-input" type="password" name="password_confirmation" {{ $isEditing ? '' : 'required' }}>
</label>

<label class="form-label" style="font-weight: 400">
    <input class="form-check" type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->exists ? $user->is_active : true))>
    Active account
</label>

<div class="form-actions">
    <x-button type="submit">{{ $isEditing ? 'Save changes' : 'Create user' }}</x-button>
    <x-button :href="route('admin.users.index')" variant="secondary">Cancel</x-button>
</div>

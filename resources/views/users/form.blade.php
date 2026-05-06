<x-app-layout>
    <x-slot name="header">{{ isset($user) ? 'Edit User' : 'Add User' }}</x-slot>
    @include('components.page-styles')

    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">{{ isset($user) ? 'Edit User' : 'Add New User' }}</div>
            <div class="page-hdr-sub">{{ isset($user) ? 'Update user details and role assignment' : 'Create a new system user and assign their role' }}</div>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-ghost">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Back to Users
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <div>
                <strong>Please fix the following:</strong>
                <ul style="margin:0.35rem 0 0;padding-left:1.1rem;">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="card" style="max-width:560px;">
        <div class="card-header">
            <span class="card-title">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" style="display:inline;margin-right:0.4rem;vertical-align:middle;"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" stroke="#6366f1" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="7" r="4" stroke="#6366f1" stroke-width="2"/></svg>
                User Details
            </span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}">
                @csrf
                @if(isset($user)) @method('PUT') @endif

                <div class="form-grid" style="margin-bottom:1rem;">
                    <div class="form-group">
                        <label class="form-label" for="name">Full Name <span class="req">*</span></label>
                        <input id="name" name="name" type="text" class="form-control"
                               value="{{ old('name', $user->name ?? '') }}"
                               placeholder="e.g. John Smith" required autofocus>
                        @error('name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address <span class="req">*</span></label>
                        <input id="email" name="email" type="email" class="form-control"
                               value="{{ old('email', $user->email ?? '') }}"
                               placeholder="e.g. john@company.com" required>
                        @error('email')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    @if(!isset($user))
                    <div class="form-group">
                        <label class="form-label" for="password">Password <span class="req">*</span></label>
                        <input id="password" name="password" type="password" class="form-control"
                               placeholder="Min 8 characters" required>
                        @error('password')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirm Password <span class="req">*</span></label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               class="form-control" placeholder="Repeat password" required>
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label" for="role">Role <span class="req">*</span></label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="">— Select a role —</option>
                            <option value="admin"         {{ old('role', $user->role ?? '') === 'admin'         ? 'selected' : '' }}>Admin — Full access</option>
                            <option value="stock_manager" {{ old('role', $user->role ?? '') === 'stock_manager' ? 'selected' : '' }}>Stock Manager — Manage inventory & orders</option>
                            <option value="viewer"        {{ old('role', $user->role ?? '') === 'viewer'        ? 'selected' : '' }}>Viewer — Read-only access</option>
                        </select>
                        @error('role')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Active toggle --}}
                <div style="display:flex;align-items:center;justify-content:space-between;padding:0.85rem;background:var(--main-bg);border:1px solid var(--header-border);border-radius:10px;margin-bottom:0.5rem;">
                    <div>
                        <div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">Account Active</div>
                        <div style="font-size:0.75rem;color:var(--text-secondary);">Inactive users cannot log in.</div>
                    </div>
                    <label style="cursor:pointer;display:flex;align-items:center;gap:0.5rem;">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $user->is_active ?? 1) ? 'checked' : '' }}
                               id="isActiveToggle"
                               style="width:18px;height:18px;accent-color:#6366f1;cursor:pointer;">
                        <span style="font-size:0.83rem;font-weight:500;color:var(--text-secondary);" id="activeLabel">
                            {{ old('is_active', $user->is_active ?? 1) ? 'Yes' : 'No' }}
                        </span>
                    </label>
                </div>

                <div class="form-footer">
                    <a href="{{ route('users.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><polyline points="17 21 17 13 7 13 7 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        {{ isset($user) ? 'Update User' : 'Create User' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('isActiveToggle').addEventListener('change', function () {
            document.getElementById('activeLabel').textContent = this.checked ? 'Yes' : 'No';
        });
    </script>
</x-app-layout>

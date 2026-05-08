<x-app-layout>
    <x-slot name="header">{{ isset($supplier) ? 'Edit Supplier' : 'Add Supplier' }}</x-slot>
    @include('components.page-styles')

    <div class="page-hdr">
        <div class="page-hdr-left">
            <div class="page-hdr-title">{{ isset($supplier) ? 'Edit Supplier' : 'Add New Supplier' }}</div>
            <div class="page-hdr-sub">{{ isset($supplier) ? 'Update supplier details' : 'Fill in the details to add a new vendor' }}</div>
        </div>
        <a href="{{ route('suppliers.index') }}" class="btn btn-ghost">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Back to Suppliers
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <div>
                <strong>Please fix the errors below:</strong>
                <ul style="margin:0.25rem 0 0;padding-left:1.1rem;">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="card" style="max-width:640px;">
        <div class="card-header">
            <span class="card-title">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" style="display:inline;margin-right:0.4rem;vertical-align:middle;"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16" stroke="#6366f1" stroke-width="2"/></svg>
                Supplier Information
            </span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($supplier) ? route('suppliers.update', $supplier) : route('suppliers.store') }}">
                @csrf
                @if(isset($supplier)) @method('PUT') @endif

                <div class="form-group">
                    <label class="form-label" for="name">Supplier Name <span class="req">*</span></label>
                    <input id="name" name="name" type="text" class="form-control"
                           value="{{ old('name', $supplier->name ?? '') }}"
                           placeholder="e.g. Global Tech Solutions" required autofocus>
                    @error('name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-grid form-grid-2" style="margin-top:1.1rem;">
                    <div class="form-group">
                        <label class="form-label" for="contact_person">Contact Person</label>
                        <input id="contact_person" name="contact_person" type="text" class="form-control"
                               value="{{ old('contact_person', $supplier->contact_person ?? '') }}"
                               placeholder="e.g. John Doe">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input id="phone" name="phone" type="text" class="form-control"
                               value="{{ old('phone', $supplier->phone ?? '') }}"
                               placeholder="+237 ...">
                    </div>
                </div>

                <div class="form-group" style="margin-top:1.1rem;">
                    <label class="form-label" for="email">Email Address</label>
                    <input id="email" name="email" type="email" class="form-control"
                           value="{{ old('email', $supplier->email ?? '') }}"
                           placeholder="vendor@example.com">
                </div>

                <div class="form-group" style="margin-top:1.1rem;">
                    <label class="form-label" for="address">Business Address</label>
                    <textarea id="address" name="address" class="form-control" rows="3"
                              placeholder="Street address, City, Country...">{{ old('address', $supplier->address ?? '') }}</textarea>
                </div>

                <div class="form-footer">
                    <a href="{{ route('suppliers.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><polyline points="17 21 17 13 7 13 7 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        {{ isset($supplier) ? 'Update Supplier' : 'Save Supplier' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

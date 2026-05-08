<x-app-layout>
    <x-slot name="header">{{ isset($client) ? 'Edit Client' : 'Add Client' }}</x-slot>
    @include('components.page-styles')

    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">{{ isset($client) ? 'Edit Client' : 'New Client' }}</div>
            <div class="page-hdr-sub">Enter the contact information for the client</div>
        </div>
        <a href="{{ route('clients.index') }}" class="btn btn-ghost">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Back to List
        </a>
    </div>

    <div class="card" style="max-width:800px;">
        <div class="card-header"><span class="card-title">Client Information</span></div>
        <div class="card-body">
            <form method="POST" action="{{ isset($client) ? route('clients.update', $client) : route('clients.store') }}">
                @csrf
                @if(isset($client)) @method('PUT') @endif

                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="name">Client Name <span class="req">*</span></label>
                        <input id="name" name="name" type="text" class="form-control" placeholder="e.g. Acme Corp" value="{{ old('name', $client->name ?? '') }}" required autofocus>
                        @error('name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contact_person">Contact Person</label>
                        <input id="contact_person" name="contact_person" type="text" class="form-control" placeholder="Full name" value="{{ old('contact_person', $client->contact_person ?? '') }}">
                        @error('contact_person')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <input id="email" name="email" type="email" class="form-control" placeholder="client@example.com" value="{{ old('email', $client->email ?? '') }}">
                        @error('email')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input id="phone" name="phone" type="text" class="form-control" placeholder="+237 ..." value="{{ old('phone', $client->phone ?? '') }}">
                        @error('phone')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="address">Address</label>
                    <textarea id="address" name="address" class="form-control" placeholder="Physical location">{{ old('address', $client->address ?? '') }}</textarea>
                    @error('address')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-footer">
                    <a href="{{ route('clients.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        {{ isset($client) ? 'Update Client' : 'Save Client' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

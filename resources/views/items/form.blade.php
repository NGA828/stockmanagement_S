<x-app-layout>
    <x-slot name="header">{{ isset($item) ? 'Edit Item' : 'Add Item' }}</x-slot>
    @include('components.page-styles')

    <div class="page-hdr">
        <div class="page-hdr-left">
            <div class="page-hdr-title">{{ isset($item) ? 'Edit Item' : 'Add New Item' }}</div>
            <div class="page-hdr-sub">{{ isset($item) ? 'Update item details and stock information' : 'Fill in the details to add a new inventory item' }}</div>
        </div>
        <a href="{{ route('items.index') }}" class="btn btn-ghost">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Back to Items
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul style="margin:0.35rem 0 0;padding-left:1.1rem;">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <span class="card-title">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" style="display:inline;margin-right:0.4rem;vertical-align:middle;"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="#6366f1" stroke-width="2"/></svg>
                Item Information
            </span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($item) ? route('items.update', $item) : route('items.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($item)) @method('PUT') @endif

                <div class="form-grid form-grid-2" style="margin-bottom:1.1rem;">
                    <div class="form-group">
                        <label class="form-label" for="name">Item Name <span class="req">*</span></label>
                        <input id="name" name="name" type="text" class="form-control"
                               value="{{ old('name', $item->name ?? '') }}"
                               placeholder="e.g. Wireless Mouse" required autofocus>
                        @error('name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="category_id">Category <span class="req">*</span></label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">— Select category —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $item->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sku">SKU / Code</label>
                        <input id="sku" name="sku" type="text" class="form-control"
                               value="{{ old('sku', $item->sku ?? '') }}"
                               placeholder="e.g. WM-001">
                        @error('sku')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="price">Unit Price (FCFA) <span class="req">*</span></label>
                        <input id="price" name="price" type="number" step="0.01" min="0" class="form-control"
                               value="{{ old('price', $item->price ?? '') }}"
                               placeholder="0.00" required>
                        @error('price')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    @if(!isset($item))
                    <div class="form-group">
                        <label class="form-label" for="quantity">Initial Quantity</label>
                        <input id="quantity" name="quantity" type="number" min="0" class="form-control"
                               value="{{ old('quantity', 0) }}" placeholder="0">
                        <p class="form-hint">Starting stock count for this item.</p>
                        @error('quantity')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label" for="reorder_level">Reorder Level</label>
                        <input id="reorder_level" name="reorder_level" type="number" min="0" class="form-control"
                               value="{{ old('reorder_level', $item->reorder_level ?? 10) }}" placeholder="10">
                        <p class="form-hint">Alert threshold for low stock warnings.</p>
                        @error('reorder_level')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" class="form-control"
                              placeholder="Optional item description...">{{ old('description', $item->description ?? '') }}</textarea>
                    @error('description')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="margin-top:1.1rem;margin-bottom:0;">
                    <label class="form-label" for="image">Item Image</label>
                    @if(isset($item) && $item->image)
                        <div style="margin-bottom:0.75rem;">
                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" style="width:80px;height:80px;object-fit:cover;border-radius:0.4rem;border:1px solid #e2e8f0;">
                        </div>
                    @endif
                    <input id="image" name="image" type="file" class="form-control" accept="image/*">
                    <p class="form-hint">Upload a product photo (JPEG, PNG). Max 2MB.</p>
                    @error('image')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-footer">
                    <a href="{{ route('items.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><polyline points="17 21 17 13 7 13 7 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        {{ isset($item) ? 'Update Item' : 'Save Item' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

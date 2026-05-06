<x-app-layout>
    <x-slot name="header">{{ isset($category) ? 'Edit Category' : 'Add Category' }}</x-slot>
    @include('components.page-styles')

    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">{{ isset($category) ? 'Edit Category' : 'New Category' }}</div>
            <div class="page-hdr-sub">{{ isset($category) ? 'Update category name and description' : 'Create a new category to organise your items' }}</div>
        </div>
        <a href="{{ route('categories.index') }}" class="btn btn-ghost">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Back
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
    @endif

    <div class="card" style="max-width:560px;">
        <div class="card-header">
            <span class="card-title">Category Details</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}">
                @csrf
                @if(isset($category)) @method('PUT') @endif

                <div class="form-grid" style="margin-bottom:1rem;">
                    <div class="form-group">
                        <label class="form-label" for="name">Category Name <span class="req">*</span></label>
                        <input id="name" name="name" type="text" class="form-control"
                               value="{{ old('name', $category->name ?? '') }}"
                               placeholder="e.g. Electronics" required autofocus>
                        @error('name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" class="form-control"
                                  placeholder="Optional description...">{{ old('description', $category->description ?? '') }}</textarea>
                        @error('description')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="form-footer">
                    <a href="{{ route('categories.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><polyline points="17 21 17 13 7 13 7 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        {{ isset($category) ? 'Update Category' : 'Save Category' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

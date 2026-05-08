<x-app-layout>
    <x-slot name="header">New Dispatch</x-slot>
    @include('components.page-styles')

    <div class="page-hdr">
        <div>
            <div class="page-hdr-title">New Dispatch Order</div>
            <div class="page-hdr-sub">Record items being sent to a client or department</div>
        </div>
        <a href="{{ route('dispatches.index') }}" class="btn btn-ghost">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Back
        </a>
    </div>

    <form action="{{ route('dispatches.store') }}" method="POST">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 350px;gap:1.5rem;align-items:start;">
            
            {{-- Left Side: Items selection --}}
            <div class="card">
                <div class="card-header"><span class="card-title">Dispatch Items</span></div>
                <div class="card-body">
                    <table class="data-table" id="itemsTable">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th style="width:120px;">Quantity</th>
                                <th style="width:50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="itemsList">
                            <tr class="item-row">
                                <td>
                                    <select name="items[0][item_id]" class="form-control item-select" required>
                                        <option value="">Select Item</option>
                                        @foreach($items as $item)
                                            <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-stock="{{ $item->quantity }}">
                                                {{ $item->name }} (Stock: {{ $item->quantity }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="items[0][quantity]" class="form-control" min="1" required>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-ghost btn-sm" style="margin-top:1rem;" onclick="addItem()">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Add Another Item
                    </button>
                </div>
            </div>

            {{-- Right Side: Dispatch Info --}}
            <div class="card">
                <div class="card-header"><span class="card-title">Dispatch Details</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Client / Destination <span class="req">*</span></label>
                        <select name="client_id" class="form-control" required>
                            <option value="">Select Client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        @error('client_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Dispatch Date <span class="req">*</span></label>
                        <input type="date" name="dispatch_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        @error('dispatch_date')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Internal Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Optional comments..."></textarea>
                    </div>

                    <div class="form-footer" style="flex-direction:column;gap:0.75rem;">
                        <button type="submit" class="btn btn-primary" style="width:100%;">Create Dispatch Draft</button>
                        <a href="{{ route('dispatches.index') }}" class="btn btn-ghost" style="width:100%;">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        let itemCount = 1;
        function addItem() {
            const list = document.getElementById('itemsList');
            const row = document.createElement('tr');
            row.className = 'item-row';
            row.innerHTML = `
                <td>
                    <select name="items[${itemCount}][item_id]" class="form-control item-select" required>
                        <option value="">Select Item</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-stock="{{ $item->quantity }}">
                                {{ $item->name }} (Stock: {{ $item->quantity }})
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="items[${itemCount}][quantity]" class="form-control" min="1" required>
                </td>
                <td>
                    <button type="button" class="btn btn-ghost btn-sm" style="color:#ef4444;" onclick="this.closest('tr').remove()">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m13 0H4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </td>
            `;
            list.appendChild(row);
            itemCount++;
        }
    </script>
</x-app-layout>

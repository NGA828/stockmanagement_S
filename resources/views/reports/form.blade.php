<x-app-layout>
    <x-slot name="header">Reports</x-slot>
    @include('components.page-styles')

    <div class="page-hdr">
        <div class="page-hdr-left">
            <div class="page-hdr-title">Generate Report</div>
            <div class="page-hdr-sub">Export detailed analytics and data summaries</div>
        </div>
        <a href="{{ route('reports.index') }}" class="btn btn-ghost">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Report History
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
    @endif

    <div style="max-width: 800px;">
        <form method="POST" action="{{ route('reports.store') }}">
            @csrf
            
            <div class="card">
                <div class="card-header">
                    <span class="card-title">1. Select Report Type</span>
                </div>
                <div class="card-body">
                    <input type="hidden" name="type" id="reportTypeInput" value="stock_summary">
                    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:1rem;">
                        @php $reportTypes = [
                            ['value'=>'stock_summary',    'label'=>'Stock Summary',         'icon'=>'M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z', 'desc'=>'Snapshot of current inventory levels and values', 'color'=>'#6366f1',  'bg'=>'rgba(99,102,241,0.08)'],
                            ['value'=>'transaction_logs', 'label'=>'Transaction Ledger',    'icon'=>'M4 4h16v16H4z M8 4v16 M12 4v16 M16 4v16',                                                                            'desc'=>'History of all stock movements (IN/OUT)', 'color'=>'#10b981', 'bg'=>'rgba(16,185,129,0.08)'],
                            ['value'=>'order_history',    'label'=>'Purchase Orders',       'icon'=>'M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z',                                                                   'desc'=>'Track status and items of all procurement orders', 'color'=>'#f59e0b', 'bg'=>'rgba(245,158,11,0.08)'],
                        ]; @endphp

                        @foreach($reportTypes as $rt)
                        <label style="cursor:pointer;" onclick="selectReport('{{ $rt['value'] }}')">
                            <div id="rcard-{{ $rt['value'] }}" 
                                 style="border:2px solid {{ $loop->first ? $rt['color'] : 'var(--header-border)' }}; 
                                        background: {{ $loop->first ? $rt['bg'] : 'transparent' }};
                                        border-radius:14px; padding:1.25rem; height:100%; transition:all 0.2s ease;">
                                <div style="width:40px;height:40px;border-radius:10px;background:{{ $rt['bg'] }};display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="{{ $rt['icon'] }}" stroke="{{ $rt['color'] }}" stroke-width="2" stroke-linecap="round"/></svg>
                                </div>
                                <div style="font-weight:700;font-size:0.95rem;color:var(--text-primary);margin-bottom:0.4rem;">{{ $rt['label'] }}</div>
                                <div style="font-size:0.78rem;color:var(--text-secondary);line-height:1.4;">{{ $rt['desc'] }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <span class="card-title">2. Configuration & Format</span>
                </div>
                <div class="card-body">
                    <div class="form-grid form-grid-2" style="margin-bottom:1.5rem;">
                        <div class="form-group">
                            <label class="form-label" for="start_date">Start Date</label>
                            <input id="start_date" name="start_date" type="date" class="form-control" 
                                   value="{{ old('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="end_date">End Date</label>
                            <input id="end_date" name="end_date" type="date" class="form-control" 
                                   value="{{ old('end_date', now()->format('Y-m-d')) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Export Format</label>
                        <div style="display:flex;gap:1rem;margin-top:0.4rem;">
                            <label style="flex:1; cursor:pointer;">
                                <input type="radio" name="format" value="pdf" checked style="display:none;" onchange="updateFormat(this)">
                                <div id="format-pdf" style="border:1px solid #6366f1; background:rgba(99,102,241,0.05); color:#6366f1; padding:0.75rem; border-radius:9px; text-align:center; font-size:0.85rem; font-weight:700;">
                                    PDF Document
                                </div>
                            </label>
                            <label style="flex:1; cursor:pointer;">
                                <input type="radio" name="format" value="csv" style="display:none;" onchange="updateFormat(this)">
                                <div id="format-csv" style="border:1px solid var(--header-border); padding:0.75rem; border-radius:9px; text-align:center; font-size:0.85rem; font-weight:600; color:var(--text-secondary);">
                                    CSV Spreadsheet
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-footer" style="padding:1.4rem; background:var(--main-bg);">
                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:0.8rem;">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Generate & Download Report
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const reportColors = {
            'stock_summary':    { color:'#6366f1', bg:'rgba(99,102,241,0.08)' },
            'transaction_logs': { color:'#10b981', bg:'rgba(16,185,129,0.08)' },
            'order_history':    { color:'#f59e0b', bg:'rgba(245,158,11,0.08)' },
        };

        function selectReport(value) {
            document.getElementById('reportTypeInput').value = value;
            Object.keys(reportColors).forEach(v => {
                const card = document.getElementById('rcard-' + v);
                if (!card) return;
                if (v === value) {
                    card.style.borderColor = reportColors[v].color;
                    card.style.background  = reportColors[v].bg;
                    card.style.boxShadow = '0 4px 15px ' + reportColors[v].bg.replace('0.08', '0.25');
                } else {
                    card.style.borderColor = 'var(--header-border)';
                    card.style.background  = 'transparent';
                    card.style.boxShadow = 'none';
                }
            });
        }

        function updateFormat(input) {
            ['pdf', 'csv'].forEach(f => {
                const box = document.getElementById('format-' + f);
                if (f === input.value) {
                    box.style.borderColor = '#6366f1';
                    box.style.background = 'rgba(99,102,241,0.05)';
                    box.style.color = '#6366f1';
                    box.style.fontWeight = '700';
                } else {
                    box.style.borderColor = 'var(--header-border)';
                    box.style.background = 'transparent';
                    box.style.color = 'var(--text-secondary)';
                    box.style.fontWeight = '600';
                }
            });
        }
    </script>
</x-app-layout>

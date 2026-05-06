{{--
    Shared inner-page design system styles.
    Include at the top of any x-app-layout page: @include('components.page-styles')
--}}
<style>
/* ── Page utility classes (shared across all inner pages) ── */

/* ── Page Header Bar ── */
.page-hdr {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.75rem;
}
.page-hdr-left { }
.page-hdr-title {
    font-size: 1.45rem; font-weight: 800; color: var(--text-primary);
    letter-spacing: -0.02em; line-height: 1.2;
}
.page-hdr-sub {
    font-size: 0.8rem; color: var(--text-secondary); margin-top: 2px;
}

/* ── Buttons ── */
.btn {
    display: inline-flex; align-items: center; gap: 0.45rem;
    padding: 0.55rem 1.1rem; border-radius: 9px;
    font-size: 0.85rem; font-weight: 600; cursor: pointer;
    transition: all 0.18s ease; text-decoration: none; border: none;
    white-space: nowrap;
}
.btn-primary {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #fff;
    box-shadow: 0 3px 10px rgba(99,102,241,0.35);
}
.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(99,102,241,0.45);
    color: #fff;
}
.btn-primary:active { transform: translateY(0); }
.btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    box-shadow: 0 3px 10px rgba(16,185,129,0.3);
}
.btn-success:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(16,185,129,0.4); color:#fff; }
.btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #fff;
    box-shadow: 0 3px 10px rgba(239,68,68,0.3);
}
.btn-danger:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(239,68,68,0.4); color:#fff; }
.btn-ghost {
    background: var(--main-bg); color: var(--text-primary);
    border: 1px solid var(--header-border);
}
.btn-ghost:hover { border-color: #6366f1; color: #6366f1; }
.btn-sm { padding: 0.35rem 0.75rem; font-size: 0.78rem; border-radius: 7px; }
.btn-icon { padding: 0.45rem; border-radius: 8px; line-height: 0; }
.btn-icon:hover { transform: translateY(-1px); }

/* ── Card / Panel ── */
.card {
    background: var(--card-bg);
    border: 1px solid var(--header-border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    margin-bottom: 1.5rem;
}
.card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.4rem;
    border-bottom: 1px solid var(--header-border);
}
.card-title { font-size: 0.93rem; font-weight: 700; color: var(--text-primary); }
.card-body { padding: 1.4rem; }

/* ── Data Table ── */
.data-table { width: 100%; border-collapse: collapse; }
.data-table thead th {
    font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.07em; color: var(--text-secondary);
    padding: 0.7rem 1.25rem; text-align: left;
    background: var(--main-bg);
    border-bottom: 1px solid var(--header-border);
}
.data-table tbody td {
    padding: 0.9rem 1.25rem;
    border-bottom: 1px solid var(--header-border);
    font-size: 0.855rem; color: var(--text-primary);
    vertical-align: middle;
}
.data-table tbody tr:last-child td { border-bottom: none; }
.data-table tbody tr:hover td {
    background: rgba(99,102,241,0.03);
    transition: background 0.12s;
}
.data-table .actions-cell { display: flex; align-items: center; gap: 0.4rem; }

/* ── Form Styles ── */
.form-grid { display: grid; gap: 1.1rem; }
.form-grid-2 { grid-template-columns: 1fr 1fr; }
@media (max-width: 640px) { .form-grid-2 { grid-template-columns: 1fr; } }

.form-group { display: flex; flex-direction: column; gap: 0.35rem; }
.form-label {
    font-size: 0.8rem; font-weight: 600; color: var(--text-primary);
    letter-spacing: 0.01em;
}
.form-label .req { color: #ef4444; margin-left: 2px; }
.form-control {
    background: var(--main-bg);
    border: 1px solid var(--header-border);
    border-radius: 9px;
    padding: 0.65rem 0.9rem;
    font-size: 0.875rem; color: var(--text-primary);
    transition: all 0.18s ease;
    outline: none; width: 100%;
    font-family: 'Inter', sans-serif;
}
.form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
    background: var(--card-bg);
}
.form-control::placeholder { color: var(--text-secondary); }
select.form-control { cursor: pointer; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' viewBox='0 0 24 24'%3E%3Cpath d='M6 9l6 6 6-6' stroke='%236b7280' stroke-width='2' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 0.75rem center;
    padding-right: 2.5rem;
}
textarea.form-control { resize: vertical; min-height: 90px; }
.form-hint { font-size: 0.75rem; color: var(--text-secondary); }
.form-error { font-size: 0.75rem; color: #ef4444; }
.form-footer {
    display: flex; align-items: center; justify-content: flex-end;
    gap: 0.75rem; padding-top: 1.1rem;
    border-top: 1px solid var(--header-border); margin-top: 0.5rem;
}

/* ── Badges ── */
.badge {
    display: inline-flex; align-items: center; gap: 0.3rem;
    font-size: 0.7rem; font-weight: 700; letter-spacing: 0.04em;
    padding: 0.22rem 0.6rem; border-radius: 100px;
    text-transform: uppercase; white-space: nowrap;
}
.badge-success { background: rgba(16,185,129,0.12); color: #059669; }
.badge-warning { background: rgba(245,158,11,0.12); color: #d97706; }
.badge-danger  { background: rgba(239,68,68,0.12);  color: #dc2626; }
.badge-info    { background: rgba(99,102,241,0.12); color: #6366f1; }
.badge-gray    { background: rgba(107,114,128,0.12); color: #6b7280; }
.badge-blue    { background: rgba(59,130,246,0.12); color: #2563eb; }

/* ── User avatar ── */
.avatar {
    width: 32px; height: 32px; border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #a78bfa);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 0.72rem; font-weight: 700; color: #fff; flex-shrink: 0;
}

/* ── Alert messages ── */
.alert {
    display: flex; align-items: flex-start; gap: 0.75rem;
    padding: 0.9rem 1.1rem; border-radius: 10px;
    font-size: 0.85rem; font-weight: 500; margin-bottom: 1.25rem;
}
.alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25); color: #065f46; }
.alert-danger  { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.25);  color: #991b1b; }
.alert-warning { background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.25); color: #92400e; }
.dark .alert-success { color: #6ee7b7; }
.dark .alert-danger  { color: #fca5a5; }
.dark .alert-warning { color: #fcd34d; }

/* ── Detail grid (key-value info panels) ── */
.detail-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
@media (max-width: 640px) { .detail-grid { grid-template-columns: 1fr; } }
.detail-item { }
.detail-key   { font-size: 0.72rem; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.25rem; }
.detail-value { font-size: 0.93rem; font-weight: 600; color: var(--text-primary); }

/* ── Empty state ── */
.empty-state {
    text-align: center; padding: 3.5rem 1.5rem;
    color: var(--text-secondary);
}
.empty-state svg { margin: 0 auto 1rem; opacity: 0.3; display: block; }
.empty-state h3 { font-size: 0.95rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.35rem; }
.empty-state p  { font-size: 0.82rem; margin-bottom: 1.25rem; }

/* ── Total amount highlight ── */
.amount { font-weight: 700; font-variant-numeric: tabular-nums; }
.amount-positive { color: #10b981; }
.amount-negative { color: #ef4444; }

/* ── Search bar ── */
.search-bar {
    display: flex; align-items: center; gap: 0.5rem;
    background: var(--main-bg); border: 1px solid var(--header-border);
    border-radius: 9px; padding: 0.45rem 0.75rem;
    transition: border-color 0.15s;
}
.search-bar:focus-within { border-color: #6366f1; }
.search-bar input { background: none; border: none; outline: none; flex: 1; font-size: 0.85rem; color: var(--text-primary); font-family: 'Inter', sans-serif; }
.search-bar input::placeholder { color: var(--text-secondary); }

/* ── Order items selection ── */
.order-item-row {
    display: grid; grid-template-columns: 1fr auto;
    align-items: center; gap: 1rem;
    padding: 0.75rem 0; border-bottom: 1px solid var(--header-border);
}
.order-item-row:last-child { border-bottom: none; }
.order-item-name { font-size: 0.85rem; font-weight: 600; color: var(--text-primary); }
.order-item-price { font-size: 0.75rem; color: var(--text-secondary); margin-top: 1px; }
.order-qty-input { width: 80px; }
</style>

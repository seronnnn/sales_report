{{-- resources/views/partials/_sr_filter_bar.blade.php --}}
{{-- Usage: @include('partials._sr_filter_bar', ['prefix' => 'dc02', 'label' => 'DC 2']) --}}
<div class="sr-filter-bar">
    <div class="sr-filter-group">
        <label class="sr-filter-label">Product Family</label>
        <input type="text" class="sr-filter-input" id="{{ $prefix }}-filter-family" placeholder="Search family…">
    </div>
    <div class="sr-filter-group">
        <label class="sr-filter-label">Customer</label>
        <input type="text" class="sr-filter-input" id="{{ $prefix }}-filter-customer" placeholder="Search customer…">
    </div>
    <div class="sr-filter-group">
        <label class="sr-filter-label">Material</label>
        <input type="text" class="sr-filter-input" id="{{ $prefix }}-filter-material" placeholder="Search material…">
    </div>
    <div class="sr-filter-group">
        <label class="sr-filter-label">DC</label>
        <select class="sr-filter-select" id="{{ $prefix }}-filter-dc">
            <option value="">{{ $label }} (all)</option>
        </select>
    </div>
    <button class="sr-clear-btn" onclick="clearSRFilters('{{ $prefix }}')">✕ Clear</button>
    <span id="{{ $prefix }}-filter-count" style="font-size:12px;color:var(--muted);margin-left:4px;"></span>
</div>
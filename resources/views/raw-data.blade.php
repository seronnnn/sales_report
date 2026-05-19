{{-- ===== RAW DATA ===== --}}
<div id="sr-raw-content" class="content-view">
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="section-title">Raw Sales Data</h2>
                <p class="section-sub" id="rawSub">All raw records from database — per row, not aggregated.</p>
            </div>
            <button onclick="exportRawData()" class="btn btn-primary">Export to Excel</button>
        </div>

        <div class="sr-filter-bar">
            <div class="sr-filter-group">
                <label class="sr-filter-label">Product Family</label>
                <input type="text" class="sr-filter-input" id="raw-filter-family" placeholder="Search family…" oninput="applyRawFilters()">
            </div>
            <div class="sr-filter-group">
                <label class="sr-filter-label">Customer</label>
                <input type="text" class="sr-filter-input" id="raw-filter-customer" placeholder="Search customer…" oninput="applyRawFilters()">
            </div>
            <div class="sr-filter-group">
                <label class="sr-filter-label">Material</label>
                <input type="text" class="sr-filter-input" id="raw-filter-material" placeholder="Search material…" oninput="applyRawFilters()">
            </div>
            <div class="sr-filter-group">
                <label class="sr-filter-label">DC</label>
                <select class="sr-filter-select" id="raw-filter-dc" onchange="applyRawFilters()">
                    <option value="">All DC</option>
                    <option value="DC 2">DC 2</option>
                    <option value="DC 4">DC 4</option>
                    <option value="DC 6">DC 6</option>
                    <option value="DC 8">DC 8</option>
                    <option value="DC 12">DC 12</option>
                    <option value="Direct">Direct</option>
                </select>
            </div>
            <button class="sr-clear-btn" onclick="clearRawFilters()">✕ Clear</button>
            <span id="raw-filter-count" style="font-size:12px;color:var(--muted);margin-left:4px;"></span>
        </div>

        <div id="rawLoading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading...</div>
        <div id="rawDataInfo" style="display:none;margin-bottom:12px;font-size:13px;color:var(--muted);">
            Showing <span id="rawRowCount" style="font-weight:700;color:var(--navy);">0</span> rows
            <span id="rawFilterInfo"></span>
        </div>
        <div class="table-container" id="rawTableWrap" style="display:none;">
            <table id="rawTable" class="data-table">
                <thead>
                    <tr>
                        <th>Business Area</th><th>DC</th><th>Division</th><th>Sales Doc. Type</th>
                        <th>02. Month</th><th>Month</th><th>Year</th>
                        <th>Salesman ID</th><th>Salesman</th><th>Customer ID</th><th>Customer</th>
                        <th>Material ID</th><th>Material</th>
                        <th class="num" style="text-align:right;">Qty</th>
                        <th class="num" style="text-align:right;">Gross Revenue</th>
                        <th class="num" style="text-align:right;">Logistic Expense</th>
                        <th class="num" style="text-align:right;">Net Revenue</th>
                        <th class="num" style="text-align:right;">COGS</th>
                        <th class="num" style="text-align:right;">Gross GP</th>
                        <th class="num" style="text-align:right;">Gross GM%</th>
                    </tr>
                </thead>
                <tbody id="rawTableBody"></tbody>
            </table>
        </div>
    </div>
</div>
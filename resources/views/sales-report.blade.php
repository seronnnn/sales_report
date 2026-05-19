{{-- ===== SALES REPORT SUMMARY ===== --}}
<div id="sales-report-content" class="content-view">
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="section-title">Sales Report Summary</h2>
                <p class="section-sub" id="salesReportSub">Automatically grouped by Product Family, Customer, and Material.</p>
            </div>
            <button onclick="exportSalesReport('pivotReportTable','Sales_Report_Summary')" class="btn btn-primary">Export to Excel</button>
        </div>

        <div class="sr-filter-bar" id="sr-filter-bar">
            <div class="sr-filter-group">
                <label class="sr-filter-label">Product Family</label>
                <input type="text" class="sr-filter-input" id="sr-filter-family" placeholder="Search family…" oninput="applyAllSRFilters()">
            </div>
            <div class="sr-filter-group">
                <label class="sr-filter-label">Customer</label>
                <input type="text" class="sr-filter-input" id="sr-filter-customer" placeholder="Search customer…" oninput="applyAllSRFilters()">
            </div>
            <div class="sr-filter-group">
                <label class="sr-filter-label">Material</label>
                <input type="text" class="sr-filter-input" id="sr-filter-material" placeholder="Search material…" oninput="applyAllSRFilters()">
            </div>
            <div class="sr-filter-group">
                <label class="sr-filter-label">DC</label>
                <select class="sr-filter-select" id="sr-filter-dc" onchange="applyAllSRFilters()">
                    <option value="">All DC</option>
                    <option value="DC 2">DC 2</option>
                    <option value="DC 4">DC 4</option>
                    <option value="DC 6">DC 6</option>
                    <option value="DC 8">DC 8</option>
                    <option value="DC 12">DC 12</option>
                    <option value="Direct">Direct</option>
                </select>
            </div>
            <button class="sr-clear-btn" onclick="clearSRFilters('sr')">✕ Clear</button>
            <span id="sr-filter-count" style="font-size:12px;color:var(--muted);margin-left:4px;"></span>
        </div>

        <div id="salesReportLoading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">
            <div style="margin-bottom:8px;">⏳ Loading data from database...</div>
        </div>
        <div class="table-container" id="salesReportTableWrap" style="display:none;">
            <table id="pivotReportTable" class="data-table">
                <thead>
                    <tr>
                        <th>Product Family</th>
                        <th>Customer</th>
                        <th>Material</th>
                        <th>DC</th>
                        <th class="num" style="text-align: right;">Sum of Qty</th>
                        <th class="num" style="text-align: right;">Sum of Gross Revenue</th>
                        <th class="num" style="text-align: right;">Sum of Gross GP</th>
                    </tr>
                </thead>
                <tbody id="salesReportBody"></tbody>
            </table>
        </div>
    </div>
</div>
{{-- ===== DATA PREP ===== --}}
<div id="dashboard-content" class="content-view active">
    <div class="card">
        <h2 class="section-title">Data Preparation</h2>
        <p class="section-sub">Upload your raw sales data to preview and generate reports.</p>

        <div class="flex items-center justify-between flex-wrap gap-4 bg-slate-50 p-4 rounded-lg border border-slate-200 mb-6">
            <div>
                <p style="font-size: 12px; font-weight: 700; margin-bottom: 8px; color: var(--navy);">Step 1: Upload Source File</p>
                <input type="file" id="fileUpload" accept=".xlsx, .xls">
            </div>
            <div style="width: 1px; height: 40px; background: var(--border);"></div>
            <div>
                <p style="font-size: 12px; font-weight: 700; margin-bottom: 8px; color: var(--navy);">Step 2: Save to Database</p>
                <button id="exportBtn" class="btn btn-primary" disabled>Save to Database</button>
            </div>
        </div>

        <div id="dataInfo" style="display:none; margin-bottom: 12px; font-size:13px; color: var(--muted);">
            Showing <span id="rowCount" style="font-weight:700; color:var(--navy);">0</span> rows
            <span id="filterInfo"></span>
        </div>

        <div id="dcTaskbar" class="dc-taskbar"></div>

        <div class="table-container">
            <table id="reportTable" class="data-table">
                <thead id="tableHead"><tr><th>Status</th></tr></thead>
                <tbody id="tableBody">
                    <tr><td style="text-align: center; padding: 30px; color: var(--muted);">Upload an Excel file to view raw data</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="saveToast"
        style="display:none; position:fixed; bottom:24px; right:24px; background:#1B3A6B; color:white; padding:14px 20px; border-radius:10px; font-size:13px; font-weight:700; box-shadow:0 8px 24px rgba(0,0,0,0.2); z-index:9999; max-width:360px;">
        <span id="saveToastMsg"></span>
    </div>
</div>
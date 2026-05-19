{{-- ===== MASTER SALESMAN ===== --}}
<div id="master-salesman-content" class="content-view">
    <div class="card">
        <div class="flex items-center justify-between mb-4" style="flex-wrap:wrap;gap:12px;">
            <div>
                <h2 class="section-title">Master Salesman</h2>
                <p class="section-sub" id="msSub">Performa salesman dirangkum per material dan customer.</p>
            </div>
            <div style="display:flex;gap:8px;">
                <button onclick="openAddSalesmanModal()" class="btn btn-secondary"
                    style="background:#f0f4ff;color:#1d4ed8;border:1px solid #bfdbfe;">+ Add Salesman</button>
                <button onclick="exportMasterSalesman()" class="btn btn-primary">Export to Excel</button>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="sr-filter-bar">
            <div class="sr-filter-group">
                <label class="sr-filter-label">Salesman ID</label>
                <input type="text" class="sr-filter-input" id="ms-filter-id" placeholder="Cari ID…"
                    oninput="applyMsFilters()" style="min-width:110px;">
            </div>
            <div class="sr-filter-group">
                <label class="sr-filter-label">Nama Salesman</label>
                <input type="text" class="sr-filter-input" id="ms-filter-name" placeholder="Cari salesman…"
                    oninput="applyMsFilters()">
            </div>
            <div class="sr-filter-group">
                <label class="sr-filter-label">Customer</label>
                <input type="text" class="sr-filter-input" id="ms-filter-customer" placeholder="Cari customer…"
                    oninput="applyMsFilters()">
            </div>
            <div class="sr-filter-group">
                <label class="sr-filter-label">Material</label>
                <input type="text" class="sr-filter-input" id="ms-filter-material" placeholder="Cari material…"
                    oninput="applyMsFilters()">
            </div>
            <button class="sr-clear-btn" onclick="clearSalesmanFilters()">✕ Clear</button>
            <span id="ms-filter-count" style="font-size:12px;color:var(--muted);margin-left:4px;"></span>
        </div>

        <div id="msLoading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading data...</div>

        <div id="msDataInfo" style="display:none;margin-bottom:12px;font-size:13px;color:var(--muted);">
            Menampilkan <span id="msRowCount" style="font-weight:700;color:var(--navy);">0</span> entri
        </div>

        <div class="table-container" id="msTableWrap" style="display:none;">
            <table id="msTable" class="data-table">
                <thead>
                    <tr>
                        <th style="min-width:110px;">Salesman ID</th>
                        <th style="min-width:160px;">Nama Salesman</th>
                        <th style="min-width:180px;">Customer</th>
                        <th style="min-width:200px;">Material</th>
                        <th class="num" style="text-align:right;min-width:100px;cursor:pointer;" title="Klik untuk melihat detail">Gross GM% ℹ</th>
                        <th style="min-width:80px;text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody id="msTableBody"></tbody>
            </table>
        </div>
    </div>
</div>

{{-- ===== SALESMAN DETAIL MODAL ===== --}}
<div id="salesmanDetailModal"
    style="display:none;position:fixed;inset:0;background:rgba(13,31,60,0.55);z-index:10000;align-items:center;justify-content:center;backdrop-filter:blur(4px);">
    <div style="background:white;border-radius:16px;box-shadow:0 24px 60px rgba(0,0,0,0.25);width:min(700px,95vw);max-height:85vh;overflow:hidden;display:flex;flex-direction:column;">

        {{-- Modal Header --}}
        <div style="padding:20px 24px 16px;border-bottom:1px solid var(--border);display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-shrink:0;">
            <div>
                <div style="font-size:11px;font-weight:700;color:#94a3b8;letter-spacing:0.8px;text-transform:uppercase;margin-bottom:4px;">Detail Performa</div>
                <div id="modalSalesmanName" style="font-size:18px;font-weight:800;color:var(--navy);"></div>
                <div id="modalSalesmanMeta" style="font-size:12px;color:var(--muted);margin-top:2px;"></div>
            </div>
            <button onclick="closeSalesmanModal()"
                style="width:32px;height:32px;border-radius:8px;border:1px solid var(--border);background:white;font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#64748b;transition:all 0.15s;"
                onmouseover="this.style.background='#f0f4ff';this.style.borderColor='#4f6ef7';"
                onmouseout="this.style.background='white';this.style.borderColor='var(--border)';">✕</button>
        </div>

        {{-- KPI Cards --}}
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;padding:16px 24px;border-bottom:1px solid var(--border);flex-shrink:0;">
            <div style="background:#f8fafc;border:1px solid var(--border);border-radius:10px;padding:12px;">
                <div style="font-size:10px;font-weight:700;color:#94a3b8;letter-spacing:0.6px;text-transform:uppercase;margin-bottom:4px;">Qty</div>
                <div id="modalKpiQty" style="font-size:16px;font-weight:800;color:var(--navy);">-</div>
            </div>
            <div style="background:#f8fafc;border:1px solid var(--border);border-radius:10px;padding:12px;">
                <div style="font-size:10px;font-weight:700;color:#94a3b8;letter-spacing:0.6px;text-transform:uppercase;margin-bottom:4px;">Gross Revenue</div>
                <div id="modalKpiRev" style="font-size:16px;font-weight:800;color:var(--navy);">-</div>
            </div>
            <div style="background:#f8fafc;border:1px solid var(--border);border-radius:10px;padding:12px;">
                <div style="font-size:10px;font-weight:700;color:#94a3b8;letter-spacing:0.6px;text-transform:uppercase;margin-bottom:4px;">Gross GP</div>
                <div id="modalKpiGP" style="font-size:16px;font-weight:800;color:var(--navy);">-</div>
            </div>
            <div style="background:#f8fafc;border:1px solid var(--border);border-radius:10px;padding:12px;">
                <div style="font-size:10px;font-weight:700;color:#94a3b8;letter-spacing:0.6px;text-transform:uppercase;margin-bottom:4px;">Gross GM%</div>
                <div id="modalKpiGM" style="font-size:20px;font-weight:900;">-</div>
            </div>
        </div>

        {{-- Breakdown Table --}}
        <div style="padding:16px 24px 24px;overflow-y:auto;flex:1;">
            <div style="font-size:11px;font-weight:700;color:#94a3b8;letter-spacing:0.7px;text-transform:uppercase;margin-bottom:10px;">Rincian per Transaksi</div>
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:12px;">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th style="padding:8px 10px;text-align:left;font-weight:700;color:#64748b;border-bottom:2px solid var(--border);">Customer</th>
                            <th style="padding:8px 10px;text-align:left;font-weight:700;color:#64748b;border-bottom:2px solid var(--border);">Material</th>
                            <th style="padding:8px 10px;text-align:right;font-weight:700;color:#64748b;border-bottom:2px solid var(--border);">Qty</th>
                            <th style="padding:8px 10px;text-align:right;font-weight:700;color:#64748b;border-bottom:2px solid var(--border);">Gross Rev</th>
                            <th style="padding:8px 10px;text-align:right;font-weight:700;color:#64748b;border-bottom:2px solid var(--border);">Net Rev</th>
                            <th style="padding:8px 10px;text-align:right;font-weight:700;color:#64748b;border-bottom:2px solid var(--border);">COGS</th>
                            <th style="padding:8px 10px;text-align:right;font-weight:700;color:#64748b;border-bottom:2px solid var(--border);">Gross GP</th>
                            <th style="padding:8px 10px;text-align:right;font-weight:700;color:#64748b;border-bottom:2px solid var(--border);">GM%</th>
                        </tr>
                    </thead>
                    <tbody id="modalDetailBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
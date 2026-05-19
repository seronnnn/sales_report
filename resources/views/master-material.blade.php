{{-- ===== MASTER MATERIAL ===== --}}
<div id="master-material-content" class="content-view">
    <div class="card">
        <div class="flex items-center justify-between mb-4" style="flex-wrap:wrap;gap:12px;">
            <div>
                <h2 class="section-title">Master Material</h2>
                <p class="section-sub" id="mmSub">Daftar semua material beserta klasifikasinya.</p>
            </div>
            <div style="display:flex;gap:8px;">
                <button onclick="openAddMaterialModal()" class="btn btn-secondary"
                    style="background:#f0f4ff;color:#1d4ed8;border:1px solid #bfdbfe;">+ Add Material</button>
                <button onclick="exportMasterMaterial()" class="btn btn-primary">Export to Excel</button>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="sr-filter-bar">
            <div class="sr-filter-group">
                <label class="sr-filter-label">Material ID</label>
                <input type="text" class="sr-filter-input" id="mm-filter-id" placeholder="Cari ID…"
                    oninput="applyMaterialFilters()" style="min-width:120px;">
            </div>
            <div class="sr-filter-group">
                <label class="sr-filter-label">Material Description</label>
                <input type="text" class="sr-filter-input" id="mm-filter-desc" placeholder="Cari nama material…"
                    oninput="applyMaterialFilters()">
            </div>
            <div class="sr-filter-group">
                <label class="sr-filter-label">Product Family</label>
                <input type="text" class="sr-filter-input" id="mm-filter-family" placeholder="Cari family…"
                    oninput="applyMaterialFilters()" style="min-width:140px;">
            </div>
            <div class="sr-filter-group">
                <label class="sr-filter-label">Subclass 1</label>
                <input type="text" class="sr-filter-input" id="mm-filter-sub1" placeholder="Cari subclass 1…"
                    oninput="applyMaterialFilters()" style="min-width:130px;">
            </div>
            <div class="sr-filter-group">
                <label class="sr-filter-label">Subclass 2</label>
                <input type="text" class="sr-filter-input" id="mm-filter-sub2" placeholder="Cari subclass 2…"
                    oninput="applyMaterialFilters()" style="min-width:130px;">
            </div>
            <button class="sr-clear-btn" onclick="clearMaterialFilters()">✕ Clear</button>
            <span id="mm-filter-count" style="font-size:12px;color:var(--muted);margin-left:4px;"></span>
        </div>

        <div id="mmLoading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading data...</div>

        <div id="mmDataInfo" style="display:none;margin-bottom:12px;font-size:13px;color:var(--muted);">
            Menampilkan <span id="mmRowCount" style="font-weight:700;color:var(--navy);">0</span> material unik
        </div>

        <div class="table-container" id="mmTableWrap" style="display:none;">
            <table id="mmTable" class="data-table">
                <thead>
                    <tr>
                        <th style="min-width:120px;">Material ID</th>
                        <th style="min-width:220px;">Material Description</th>
                        <th style="min-width:160px;">Product Family</th>
                        <th style="min-width:140px;">Subclass 1 (DC)</th>
                        <th style="min-width:140px;">Subclass 2 (Division)</th>
                        <th style="min-width:80px;text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody id="mmTableBody"></tbody>
            </table>
        </div>
    </div>
</div>
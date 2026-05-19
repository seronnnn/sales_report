{{-- ===== RESUME ALL BUSINESS ===== --}}
<div id="resume-all-content" class="content-view">
    <div class="card">
        <div class="flex items-center justify-between mb-4" style="flex-wrap:wrap;gap:12px;">
            <div>
                <h2 class="section-title">Resume All Business</h2>
                <p class="section-sub" id="resumeSub">Grouped by Product Family — select year &amp; month to filter.</p>
            </div>
            <button onclick="exportResumeReport()" class="btn btn-primary">Export to Excel</button>
        </div>

        {{-- Filter Bar --}}
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:20px;padding:14px 16px;background:#f8fafc;border:1px solid var(--border);border-radius:10px;">
            <span style="font-size:12px;font-weight:700;color:var(--navy);white-space:nowrap;">Filter:</span>

            {{-- Business Area --}}
            <div style="position:relative;" id="resumeBAWrapper">
                <button id="resumeBABtn" onclick="toggleResumeBADropdown()"
                    style="display:flex;align-items:center;gap:8px;padding:7px 12px;border:1px solid var(--border);border-radius:7px;background:white;font-size:13px;font-weight:600;color:var(--navy);cursor:pointer;white-space:nowrap;">
                    <span id="resumeBALabel">All Business Area</span>
                    <span style="font-size:10px;">▼</span>
                </button>
                <div id="resumeBAMenu"
                    style="display:none;position:absolute;left:0;top:calc(100% + 6px);background:white;border:1px solid var(--border);border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.12);min-width:200px;z-index:999;overflow:hidden;">
                    <div class="rba-option active" data-value="ALL" onclick="selectResumeBA('ALL','All Business Area')"
                        style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);font-weight:600;border-bottom:1px solid var(--border);">All Business Area</div>
                    <div class="rba-option" data-value="DKJ - Cibitung" onclick="selectResumeBA('DKJ - Cibitung','DKJ - Cibitung')"
                        style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Cibitung</div>
                    <div class="rba-option" data-value="DKJ - Delta Mas" onclick="selectResumeBA('DKJ - Delta Mas','DKJ - Delta Mas')"
                        style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Delta Mas</div>
                    <div class="rba-option" data-value="DKJ - Medan" onclick="selectResumeBA('DKJ - Medan','DKJ - Medan')"
                        style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Medan</div>
                    <div class="rba-option" data-value="DKJ - Surabaya" onclick="selectResumeBA('DKJ - Surabaya','DKJ - Surabaya')"
                        style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Surabaya</div>
                </div>
            </div>

            {{-- Year --}}
            <select id="resumeYearFilter" onchange="onResumeYearChange()"
                style="padding:7px 12px;border:1px solid var(--border);border-radius:7px;font-size:13px;font-weight:600;color:var(--navy);background:white;cursor:pointer;">
                <option value="ALL">All Years</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
            </select>

            {{-- Month --}}
            <div id="resumeMonthFilterWrap" style="display:none;align-items:center;gap:8px;">
                <select id="resumeMonthFilter" onchange="renderResumeReport()"
                    style="padding:7px 12px;border:1px solid var(--border);border-radius:7px;font-size:13px;font-weight:600;color:var(--navy);background:white;cursor:pointer;">
                    <option value="ALL">All Months (YTD)</option>
                </select>
            </div>

            <button onclick="renderResumeReport()"
                style="padding:7px 18px;background:#1B3A6B;color:white;border:none;border-radius:7px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;">
                🔍 Search
            </button>
            <span id="resumeRowInfo" style="font-size:12px;color:var(--muted);margin-left:4px;"></span>
        </div>

        <div id="resumeLoading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading data from database...</div>

        {{-- Summary Table --}}
        <div id="resumeTableWrap" style="display:none;">
            <div class="table-container">
                <table id="resumeTable" class="data-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align:middle;min-width:160px;">GROUP PRODUCT</th>
                            <th colspan="4" style="text-align:center;background:#1B3A6B;color:white;" id="resumeMonthColHeader">PERIOD</th>
                        </tr>
                        <tr>
                            <th class="num" style="text-align:right;">QTY</th>
                            <th class="num" style="text-align:right;">REVENUE</th>
                            <th class="num" style="text-align:right;">PROFIT (GP)</th>
                            <th class="num" style="text-align:right;">%GM</th>
                        </tr>
                    </thead>
                    <tbody id="resumeTableBody"></tbody>
                </table>
            </div>
        </div>

        {{-- Monthly Breakdown (YTD only) --}}
        <div id="resumeMonthlyBreakdownWrap" style="display:none;margin-top:32px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                <div style="height:3px;flex:1;background:linear-gradient(90deg,#1B3A6B,transparent);border-radius:2px;"></div>
                <span style="font-size:11px;font-weight:800;color:#94a3b8;letter-spacing:1.5px;text-transform:uppercase;white-space:nowrap;">Breakdown Per Bulan</span>
                <div style="height:3px;flex:1;background:linear-gradient(270deg,#1B3A6B,transparent);border-radius:2px;"></div>
            </div>
            <div id="resumeMonthlyTablesContainer"></div>
        </div>

        {{-- Legacy wrapper (kept to avoid JS errors) --}}
        <div id="resumeAllMonthsWrap" style="display:none;">
            <div class="table-container" style="overflow-x:auto;">
                <table id="resumeAllMonthsTable" class="data-table" style="min-width:1200px;">
                    <thead id="resumeAllMonthsHead"></thead>
                    <tbody id="resumeAllMonthsBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
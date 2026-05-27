@extends('layouts.app')

@section('content')

    <div id="app-wrapper" style="display:flex; width:100%; min-height:100vh;">
        
        <nav id="sidebar">
            
            <div class="flex items-center justify-center sidebar-logo">
                <img src="{{ asset('images/logo_dkj.jpg') }}" alt="DKJ Logo"
                class="w-10 h-10 rounded-xl object-contain bg-white shadow-lg">
                <div class="mx-4">DKJ Sales Report</div>
            </div> 
            
            <div class="nav-label">Menu</div>
            <div class="nav-item active" data-target="dashboard-content" onclick="activateNavItem(this)">
                <span style="font-size: 18px;">◈</span> Data Prep
            </div>

            {{-- Sales Report — expandable parent --}}
            <div class="nav-item" id="nav-sales-report-parent" onclick="toggleSalesReportMenu(this)">
                <span style="font-size: 18px;">◎</span> Sales Report
                <span id="sales-chevron" style="margin-left:auto;font-size:11px;transition:transform 0.25s;display:inline-block;">▼</span>
            </div>

            {{-- 8 Children (Raw + 7 original) --}}
            <div id="sales-report-submenu" style="overflow:hidden;max-height:0;transition:max-height 0.3s ease;">
                <div class="nav-sub-item" data-target="sr-raw-content" onclick="activateSalesSubItem(this)">
                    <span style="opacity:0.4;margin-right:4px;">–</span> Raw
                </div>
                <div class="nav-sub-item active" data-target="sales-report-content" onclick="activateSalesSubItem(this)">
                    <span style="opacity:0.4;margin-right:4px;">–</span> Sales Report
                </div>
                <div class="nav-sub-item" data-target="sr-dc02-content" onclick="activateSalesSubItem(this)">
                    <span style="opacity:0.4;margin-right:4px;">–</span> Paper DC 02
                </div>
                <div class="nav-sub-item" data-target="sr-dc12-content" onclick="activateSalesSubItem(this)">
                    <span style="opacity:0.4;margin-right:4px;">–</span> Oil Field DC 12
                </div>
                <div class="nav-sub-item" data-target="sr-dc04-content" onclick="activateSalesSubItem(this)">
                    <span style="opacity:0.4;margin-right:4px;">–</span> Plastic Rubber &amp; RA DC 04
                </div>
                <div class="nav-sub-item" data-target="sr-dc06-content" onclick="activateSalesSubItem(this)">
                    <span style="opacity:0.4;margin-right:4px;">–</span> Textile DC 06
                </div>
                <div class="nav-sub-item" data-target="sr-dc08-content" onclick="activateSalesSubItem(this)">
                    <span style="opacity:0.4;margin-right:4px;">–</span> PHC DC 08
                </div>
            </div>

            <div class="nav-item" data-target="resume-all-content" onclick="activateNavItem(this)">
                <span style="font-size: 18px;">◉</span> Resume All Business
            </div>

            {{-- ===== MASTER DATA SECTION ===== --}}
            <div class="nav-label">Master Data</div>
            <div class="nav-item" data-target="master-material-content" onclick="activateNavItem(this)">
                <span style="font-size: 18px;">◧</span> Master Material
            </div>
            <div class="nav-item" data-target="master-salesman-content" onclick="activateNavItem(this)">
                <span style="font-size: 18px;">◨</span> Master Salesman
            </div>

            <div class="mt-auto p-5" style="border-top:1px solid rgba(255,255,255,0.1);">
                <div class="flex items-center gap-3">
                    <div style="width:32px;height:32px;border-radius:50%;background:#F5A623;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#0d1f3c;">A</div>
                    <div>
                        <p style="font-size:13px;font-weight:700;color:white;margin:0;">Admin</p>
                        <p class="mono" style="font-size:10px;color:#94afc8;margin:0;">Sales Team</p>
                    </div>
                </div>
            </div>
        </nav>

        <div id="main">
            <div class="topbar">
                <div class="flex items-center gap-3">
                    <span style="font-size:12px;color:var(--muted);font-weight:700;letter-spacing:0.05em;">WORKSPACE</span>
                    <span style="color:var(--border);">|</span>
                    <span id="topbar-title" style="font-size:14px;font-weight:700;color:var(--navy);">Data Preparation Dashboard</span>
                </div>
                <div class="flex items-center gap-3">
                    <div id="businessAreaFilter" style="display:none; position:relative;">
                        <button id="baDropdownBtn" onclick="toggleBADropdown()" style="display:flex;align-items:center;gap:8px;padding:8px 14px;border:1px solid var(--border);border-radius:8px;background:white;font-size:13px;font-weight:600;color:var(--navy);cursor:pointer;white-space:nowrap;">
                            <span id="baDropdownLabel">All Business Area</span>
                            <span style="font-size:10px;">▼</span>
                        </button>
                        <div id="baDropdownMenu" style="display:none;position:absolute;right:0;top:calc(100% + 6px);background:white;border:1px solid var(--border);border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.12);min-width:200px;z-index:999;overflow:hidden;">
                            <div class="ba-option active" data-value="ALL" onclick="selectBusinessArea('ALL', 'All Business Area')" style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);font-weight:600;border-bottom:1px solid var(--border);">All Business Area</div>
                            <div class="ba-option" data-value="DKJ - Cibitung" onclick="selectBusinessArea('DKJ - Cibitung', 'DKJ - Cibitung')" style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Cibitung</div>
                            <div class="ba-option" data-value="DKJ - Delta Mas" onclick="selectBusinessArea('DKJ - Delta Mas', 'DKJ - Delta Mas')" style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Delta Mas</div>
                            <div class="ba-option" data-value="DKJ - Medan" onclick="selectBusinessArea('DKJ - Medan', 'DKJ - Medan')" style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Medan</div>
                            <div class="ba-option" data-value="DKJ - Surabaya" onclick="selectBusinessArea('DKJ - Surabaya', 'DKJ - Surabaya')" style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Surabaya</div>
                        </div>
                    </div>
                    <button id="logoutBtn" class="btn btn-danger">Logout</button>
                </div>
            </div>

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

                <div id="saveToast" style="display:none; position:fixed; bottom:24px; right:24px; background:#1B3A6B; color:white; padding:14px 20px; border-radius:10px; font-size:13px; font-weight:700; box-shadow:0 8px 24px rgba(0,0,0,0.2); z-index:9999; max-width:360px;">
                    <span id="saveToastMsg"></span>
                </div>
            </div>

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

                    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:20px;padding:14px 16px;background:#f8fafc;border:1px solid var(--border);border-radius:10px;">
                        <span style="font-size:12px;font-weight:700;color:var(--navy);white-space:nowrap;">Filter:</span>

                        {{-- Business Area --}}
                        <div style="position:relative;" id="resumeBAWrapper">
                            <button id="resumeBABtn" onclick="toggleResumeBADropdown()" style="display:flex;align-items:center;gap:8px;padding:7px 12px;border:1px solid var(--border);border-radius:7px;background:white;font-size:13px;font-weight:600;color:var(--navy);cursor:pointer;white-space:nowrap;">
                                <span id="resumeBALabel">All Business Area</span>
                                <span style="font-size:10px;">▼</span>
                            </button>
                            <div id="resumeBAMenu" style="display:none;position:absolute;left:0;top:calc(100% + 6px);background:white;border:1px solid var(--border);border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.12);min-width:200px;z-index:999;overflow:hidden;">
                                <div class="rba-option active" data-value="ALL"      onclick="selectResumeBA('ALL','All Business Area')"   style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);font-weight:600;border-bottom:1px solid var(--border);">All Business Area</div>
                                <div class="rba-option" data-value="DKJ - Cibitung"  onclick="selectResumeBA('DKJ - Cibitung','DKJ - Cibitung')"   style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Cibitung</div>
                                <div class="rba-option" data-value="DKJ - Delta Mas" onclick="selectResumeBA('DKJ - Delta Mas','DKJ - Delta Mas')"  style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Delta Mas</div>
                                <div class="rba-option" data-value="DKJ - Medan"     onclick="selectResumeBA('DKJ - Medan','DKJ - Medan')"          style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Medan</div>
                                <div class="rba-option" data-value="DKJ - Surabaya"  onclick="selectResumeBA('DKJ - Surabaya','DKJ - Surabaya')"    style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Surabaya</div>
                            </div>
                        </div>

                        {{-- Year --}}
                        <select id="resumeYearFilter" onchange="onResumeYearChange()" style="padding:7px 12px;border:1px solid var(--border);border-radius:7px;font-size:13px;font-weight:600;color:var(--navy);background:white;cursor:pointer;">
                            <option value="ALL">All Years</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                        </select>

                        {{-- Month (muncul saat year dipilih) --}}
                        <div id="resumeMonthFilterWrap" style="display:none;align-items:center;gap:8px;">
                            <select id="resumeMonthFilter" onchange="renderResumeReport()" style="padding:7px 12px;border:1px solid var(--border);border-radius:7px;font-size:13px;font-weight:600;color:var(--navy);background:white;cursor:pointer;">
                                <option value="ALL">All Months (YTD)</option>
                            </select>
                        </div>

                        <button onclick="renderResumeReport()" style="padding:7px 18px;background:#1B3A6B;color:white;border:none;border-radius:7px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;">
                            🔍 Search
                        </button>
                        <span id="resumeRowInfo" style="font-size:12px;color:var(--muted);margin-left:4px;"></span>
                    </div>

                    <div id="resumeLoading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading data from database...</div>

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
                    {{-- Container untuk breakdown 12 tabel per bulan (hanya muncul saat YTD) --}}
                    <div id="resumeMonthlyBreakdownWrap" style="display:none;margin-top:32px;">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                            <div style="height:3px;flex:1;background:linear-gradient(90deg,#1B3A6B,transparent);border-radius:2px;"></div>
                            <span style="font-size:11px;font-weight:800;color:#94a3b8;letter-spacing:1.5px;text-transform:uppercase;white-space:nowrap;">Breakdown Per Bulan</span>
                            <div style="height:3px;flex:1;background:linear-gradient(270deg,#1B3A6B,transparent);border-radius:2px;"></div>
                        </div>
                        <div id="resumeMonthlyTablesContainer"></div>
                    </div>

                    {{-- (legacy — tidak dipakai, dijaga agar tidak error) --}}
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

            {{-- ===== SALES REPORT (main summary) ===== --}}
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

            {{-- ===== DC 02 ===== --}}
            <div id="sr-dc02-content" class="content-view">
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <div><h2 class="section-title">Paper DC 02</h2><p class="section-sub">Sales report filtered for DC 2 only.</p></div>
                        <button onclick="exportSalesReport('dc02Table','Paper_DC02')" class="btn btn-primary">Export to Excel</button>
                    </div>
                    @include('partials._sr_filter_bar', ['prefix' => 'dc02', 'label' => 'DC 2'])
                    <div id="dc02Loading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading...</div>
                    <div class="table-container" id="dc02TableWrap" style="display:none;">
                        <table id="dc02Table" class="data-table">
                            <thead><tr><th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th><th class="num" style="text-align:right;">Sum of Qty</th><th class="num" style="text-align:right;">Sum of Gross Revenue</th><th class="num" style="text-align:right;">Sum of Gross GP</th></tr></thead>
                            <tbody id="dc02Body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===== DC 12 ===== --}}
            <div id="sr-dc12-content" class="content-view">
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <div><h2 class="section-title">Oil Field DC 12</h2><p class="section-sub">Sales report filtered for DC 12 only.</p></div>
                        <button onclick="exportSalesReport('dc12Table','OilField_DC12')" class="btn btn-primary">Export to Excel</button>
                    </div>
                    @include('partials._sr_filter_bar', ['prefix' => 'dc12', 'label' => 'DC 12'])
                    <div id="dc12Loading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading...</div>
                    <div class="table-container" id="dc12TableWrap" style="display:none;">
                        <table id="dc12Table" class="data-table">
                            <thead><tr><th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th><th class="num" style="text-align:right;">Sum of Qty</th><th class="num" style="text-align:right;">Sum of Gross Revenue</th><th class="num" style="text-align:right;">Sum of Gross GP</th></tr></thead>
                            <tbody id="dc12Body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===== DC 04 ===== --}}
            <div id="sr-dc04-content" class="content-view">
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <div><h2 class="section-title">Plastic Rubber &amp; RA DC 04</h2><p class="section-sub">Sales report filtered for DC 4 only.</p></div>
                        <button onclick="exportSalesReport('dc04Table','PlasticRubber_DC04')" class="btn btn-primary">Export to Excel</button>
                    </div>
                    @include('partials._sr_filter_bar', ['prefix' => 'dc04', 'label' => 'DC 4'])
                    <div id="dc04Loading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading...</div>
                    <div class="table-container" id="dc04TableWrap" style="display:none;">
                        <table id="dc04Table" class="data-table">
                            <thead><tr><th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th><th class="num" style="text-align:right;">Sum of Qty</th><th class="num" style="text-align:right;">Sum of Gross Revenue</th><th class="num" style="text-align:right;">Sum of Gross GP</th></tr></thead>
                            <tbody id="dc04Body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===== DC 06 ===== --}}
            <div id="sr-dc06-content" class="content-view">
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <div><h2 class="section-title">Textile DC 06</h2><p class="section-sub">Sales report filtered for DC 6 only.</p></div>
                        <button onclick="exportSalesReport('dc06Table','Textile_DC06')" class="btn btn-primary">Export to Excel</button>
                    </div>
                    @include('partials._sr_filter_bar', ['prefix' => 'dc06', 'label' => 'DC 6'])
                    <div id="dc06Loading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading...</div>
                    <div class="table-container" id="dc06TableWrap" style="display:none;">
                        <table id="dc06Table" class="data-table">
                            <thead><tr><th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th><th class="num" style="text-align:right;">Sum of Qty</th><th class="num" style="text-align:right;">Sum of Gross Revenue</th><th class="num" style="text-align:right;">Sum of Gross GP</th></tr></thead>
                            <tbody id="dc06Body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===== DC 08 ===== --}}
            <div id="sr-dc08-content" class="content-view">
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <div><h2 class="section-title">PHC DC 08</h2><p class="section-sub">Sales report filtered for DC 8 only.</p></div>
                        <button onclick="exportSalesReport('dc08Table','PHC_DC08')" class="btn btn-primary">Export to Excel</button>
                    </div>
                    @include('partials._sr_filter_bar', ['prefix' => 'dc08', 'label' => 'DC 8'])
                    <div id="dc08Loading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading...</div>
                    <div class="table-container" id="dc08TableWrap" style="display:none;">
                        <table id="dc08Table" class="data-table">
                            <thead><tr><th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th><th class="num" style="text-align:right;">Sum of Qty</th><th class="num" style="text-align:right;">Sum of Gross Revenue</th><th class="num" style="text-align:right;">Sum of Gross GP</th></tr></thead>
                            <tbody id="dc08Body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

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

            {{-- ===== MASTER SALESMAN ===== --}}
            <div id="master-salesman-content" class="content-view">
                <div class="card">
                    <div class="flex items-center justify-between mb-4" style="flex-wrap:wrap;gap:12px;">
                        <div>
                            <h2 class="section-title">Master Salesman</h2>
                            <p class="section-sub" id="msSub">Performa salesman dirangkum per material dan customer.</p>
                        </div>
                        <div style="display:flex;gap:8px;">
                            <button onclick="openAddSalesmanModal()" class="btn btn-secondary" style="background:#f0f4ff;color:#1d4ed8;border:1px solid #bfdbfe;">+ Add Salesman</button>
                            <button onclick="exportMasterSalesman()" class="btn btn-primary">Export to Excel</button>
                        </div>
                    </div>

                    {{-- Filter Bar --}}
                    <div class="sr-filter-bar">
                        <div class="sr-filter-group">
                            <label class="sr-filter-label">Salesman ID</label>
                            <input type="text" class="sr-filter-input" id="ms-filter-id" placeholder="Cari ID…" oninput="applySalesmanFilters()" style="min-width:110px;">
                        </div>
                        <div class="sr-filter-group">
                            <label class="sr-filter-label">Nama Salesman</label>
                            <input type="text" class="sr-filter-input" id="ms-filter-name" placeholder="Cari salesman…" oninput="applySalesmanFilters()">
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
                                    <th class="num" style="text-align:right;min-width:100px;">Qty</th>
                                    <th class="num" style="text-align:right;min-width:130px;">Gross Revenue</th>
                                    <th class="num" style="text-align:right;min-width:120px;">Gross GP</th>
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
            <div id="salesmanDetailModal" style="display:none;position:fixed;inset:0;background:rgba(13,31,60,0.55);z-index:10000;align-items:center;justify-content:center;backdrop-filter:blur(4px);">
                <div style="background:white;border-radius:16px;box-shadow:0 24px 60px rgba(0,0,0,0.25);width:min(700px,95vw);max-height:85vh;overflow:hidden;display:flex;flex-direction:column;">
                    {{-- Modal Header --}}
                    <div style="padding:20px 24px 16px;border-bottom:1px solid var(--border);display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-shrink:0;">
                        <div>
                            <div style="font-size:11px;font-weight:700;color:#94a3b8;letter-spacing:0.8px;text-transform:uppercase;margin-bottom:4px;">Detail Performa</div>
                            <div id="modalSalesmanName" style="font-size:18px;font-weight:800;color:var(--navy);"></div>
                            <div id="modalSalesmanMeta" style="font-size:12px;color:var(--muted);margin-top:2px;"></div>
                        </div>
                        <button onclick="closeSalesmanModal()" style="width:32px;height:32px;border-radius:8px;border:1px solid var(--border);background:white;font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#64748b;transition:all 0.15s;"
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

        </div>{{-- end #main --}}
    </div>{{-- end #app-wrapper --}}

    {{-- Add / Edit Material Modal --}}
<div id="materialModal"
    style="display:none;position:fixed;inset:0;background:rgba(13,31,60,0.55);z-index:10000;align-items:center;justify-content:center;backdrop-filter:blur(4px);">
    <div style="background:white;border-radius:16px;box-shadow:0 24px 60px rgba(0,0,0,0.25);width:min(480px,95vw);padding:28px 32px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <h3 id="materialModalTitle" style="font-size:17px;font-weight:800;color:var(--navy);">Add Material</h3>
            <button onclick="closeMaterialModal()"
                style="width:30px;height:30px;border-radius:8px;border:1px solid var(--border);background:white;font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;">✕</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div>
                <label style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:6px;display:block;">Material ID *</label>
                <input type="text" id="matIdInput" placeholder="e.g. MAT-001"
                    style="width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;outline:none;">
            </div>
            <div>
                <label style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:6px;display:block;">Material Description *</label>
                <input type="text" id="matDescInput" placeholder="e.g. Chemical XYZ"
                    style="width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;outline:none;">
            </div>
        </div>
        <div id="materialModalError" style="display:none;margin-top:12px;font-size:12px;color:#dc2626;font-weight:600;"></div>
        <div style="display:flex;gap:10px;margin-top:20px;justify-content:flex-end;">
            <button onclick="closeMaterialModal()" class="btn" style="background:#f1f5f9;color:var(--navy);">Cancel</button>
            <button onclick="saveMaterial()" class="btn btn-primary" id="saveMaterialBtn">Save Material</button>
        </div>
    </div>
</div>

{{-- Add / Edit Salesman Modal --}}
<div id="salesmanModal"
    style="display:none;position:fixed;inset:0;background:rgba(13,31,60,0.55);z-index:10000;align-items:center;justify-content:center;backdrop-filter:blur(4px);">
    <div style="background:white;border-radius:16px;box-shadow:0 24px 60px rgba(0,0,0,0.25);width:min(420px,95vw);padding:28px 32px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <h3 id="salesmanModalTitle" style="font-size:17px;font-weight:800;color:var(--navy);">Add Salesman</h3>
            <button onclick="closeSalesmanModal()"
                style="width:30px;height:30px;border-radius:8px;border:1px solid var(--border);background:white;font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;">✕</button>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div>
                <label style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:6px;display:block;">Salesman ID *</label>
                <input type="text" id="smIdInput" placeholder="e.g. SM-001"
                    style="width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;outline:none;">
            </div>
            <div>
                <label style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:6px;display:block;">Salesman Name *</label>
                <input type="text" id="smNameInput" placeholder="e.g. John Doe"
                    style="width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;outline:none;">
            </div>
        </div>
        <div id="salesmanModalError" style="display:none;margin-top:12px;font-size:12px;color:#dc2626;font-weight:600;"></div>
        <div style="display:flex;gap:10px;margin-top:20px;justify-content:flex-end;">
            <button onclick="closeSalesmanModal()" class="btn" style="background:#f1f5f9;color:var(--navy);">Cancel</button>
            <button onclick="saveSalesman()" class="btn btn-primary" id="saveSalesmanBtn">Save Salesman</button>
        </div>
    </div>
</div>

@endsection
@push('scripts')

    {{-- ===== EXTRA STYLES ===== --}}
    <style>
        .rba-option:hover { background: #f0f4ff !important; color: #1d4ed8 !important; }
        .rba-option.active { font-weight: 700 !important; background: #f0f4ff !important; }
        .nav-sub-item {
            display: flex; align-items: center;
            padding: 7px 16px 7px 36px;
            font-size: 12px; font-weight: 400;
            color: rgba(255,255,255,0.45);
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
            border-left: 2px solid transparent;
        }
        .nav-sub-item:hover { background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.8); }
        .nav-sub-item.active { color: #7c9fff; font-weight: 600; background: rgba(124,159,255,0.08); border-left-color: #4f6ef7; }
        .nav-sub-item.active span { opacity: 1 !important; color: #4f6ef7; }

        .sr-filter-bar { display:flex; align-items:flex-end; gap:12px; flex-wrap:wrap; padding:12px 16px; background:#f8fafc; border:1px solid var(--border); border-radius:10px; margin-bottom:16px; }
        .sr-filter-group { display:flex; flex-direction:column; gap:4px; }
        .sr-filter-label { font-size:10px; font-weight:700; color:#94a3b8; letter-spacing:0.8px; text-transform:uppercase; }
        .sr-filter-input { border:1px solid var(--border); border-radius:7px; padding:7px 10px; font-size:12px; color:var(--navy); outline:none; min-width:150px; transition:border-color 0.15s,box-shadow 0.15s; background:white; }
        .sr-filter-input:focus { border-color:#4f6ef7; box-shadow:0 0 0 3px rgba(79,110,247,0.1); }
        .sr-filter-input::placeholder { color:#cbd5e1; }
        .sr-filter-select { border:1px solid var(--border); border-radius:7px; padding:7px 10px; font-size:12px; color:var(--navy); outline:none; min-width:130px; background:white; cursor:pointer; transition:border-color 0.15s; }
        .sr-filter-select:focus { border-color:#4f6ef7; box-shadow:0 0 0 3px rgba(79,110,247,0.1); }
        .sr-clear-btn { padding:7px 14px; border:1px solid var(--border); border-radius:7px; background:white; font-size:12px; font-weight:600; color:#64748b; cursor:pointer; transition:all 0.15s; align-self:flex-end; }
        .sr-clear-btn:hover { border-color:#4f6ef7; color:#4f6ef7; background:#f0f4ff; }

        /* GM% badge styles */
        .gm-badge { display:inline-flex; align-items:center; justify-content:flex-end; gap:4px; font-weight:700; font-size:12px; }
        .gm-badge.good { color:#16a34a; }
        .gm-badge.bad  { color:#dc2626; }

        /* Salesman row hover */
        #msTableBody tr { cursor:default; }
        #msTableBody tr .gm-cell { cursor:pointer; }
        #msTableBody tr:hover { background:#f8fafc; }
        #msTableBody tr .gm-cell:hover { background:#f0f4ff; }

        /* Modal backdrop click to close */
        #salesmanDetailModal { cursor:default; }

        /* Subclass badge */
        .sub-badge {
            display:inline-block; padding:2px 8px; border-radius:4px;
            font-size:11px; font-weight:600;
            background:#f1f5f9; color:#475569; border:1px solid #e2e8f0;
        }
    </style>


<script>
    // NEW SCRIPT
    // =========================================================
// GLOBALS
// =========================================================
const VALID_DCS = ['DC 2', 'DC 12', 'DC 4', 'DC 6', 'DC 8'];
var originalDashboardData = [];
var salesReportDBData     = [];
var currentBAFilter       = 'ALL';
var resumeDBData          = [];
var groupedSRRows         = [];
var groupedDCRows         = {};
 
var masterMaterialData    = [];
var masterMaterialBase    = [];
var masterSalesmanData    = [];
var masterSalesmanBase    = [];
 
// =========================================================
// HELPERS
// =========================================================
function cleanKey(key) { return key.replace(/\u00a0/g, '').trim(); }
function parseIntSafe(val) {
    if (val === undefined || val === null || val === '') return null;
    const n = parseInt(String(val).replace(/[,%\s]/g, ''), 10);
    return isNaN(n) ? null : n;
}
function parseFloatSafe(val) {
    if (val === undefined || val === null || val === '') return null;
    let str = String(val).replace(/[%\s]/g, '');
    if (str === '?' || str === '-' || str === '#') return null;
    if (str.match(/,\d{1,2}$/)) { str = str.replace(/\./g, '').replace(',', '.'); }
    else { str = str.replace(/,/g, ''); }
    const n = parseFloat(str);
    return isNaN(n) ? null : n;
}
function clampGM(val) {
    const n = parseFloatSafe(val);
    if (n === null) return null;
    if (n > 999.99) return 999.99;
    if (n < -999.99) return -999.99;
    return n;
}
function getExcelValue(row, targetKey) {
    if (row[targetKey] !== undefined) return row[targetKey];
    const normalize = s => s.toLowerCase().replace(/[\s_\u00a0]/g, '');
    const nt = normalize(targetKey);
    for (let key in row) { if (normalize(key) === nt) return row[key]; }
    return null;
}
function mapRowToPayload(row) {
    const rawYear  = getExcelValue(row, 'Year');
    const rawMonth = getExcelValue(row, '02. Month');
    let year = null;
    if (rawYear !== null && rawYear !== '') {
        const y = parseInt(String(rawYear).replace(/[^0-9]/g, ''), 10);
        if (!isNaN(y) && y >= 2000 && y <= 2099) year = y;
    }
    let month_num = null;
    if (rawMonth !== null && rawMonth !== '') {
        const m = parseInt(String(rawMonth).replace(/[^0-9]/g, ''), 10);
        if (!isNaN(m) && m >= 1 && m <= 12) month_num = m;
    }
    return {
        business_area:    getExcelValue(row, 'Business area') || null,
        dc:               getExcelValue(row, 'DC') || null,
        division:         getExcelValue(row, 'Division') || null,
        sales_doc_type:   getExcelValue(row, 'Sales doc. type') || null,
        month_num,
        month:            getExcelValue(row, 'Month') || null,
        year,
        salesman_id:      String(getExcelValue(row, 'Salesman ID') || '').trim() || null,
        salesman:         getExcelValue(row, 'Salesman') || null,
        customer_id:      String(getExcelValue(row, 'Customer ID') || '').trim() || null,
        customer:         getExcelValue(row, 'Customer') || null,
        material_id:      String(getExcelValue(row, 'Material ID') || '').trim() || null,
        material:         getExcelValue(row, 'Material') || null,
        qty:              parseIntSafe(getExcelValue(row, 'Qty')),
        gross_revenue:    parseFloatSafe(getExcelValue(row, 'Gross Revenue')),
        logistic_expense: parseFloatSafe(getExcelValue(row, 'Logistic Expense')),
        net_revenue:      parseFloatSafe(getExcelValue(row, 'Net Revenue')),
        cogs:             parseFloatSafe(getExcelValue(row, 'COGS')),
        gross_gp:         parseFloatSafe(getExcelValue(row, 'Gross GP')),
        gross_gm_percent: clampGM(getExcelValue(row, 'Gross GM%')),
    };
}
const formatNum  = n => Math.round(n).toLocaleString('id-ID');
const formatDec2 = n => n.toLocaleString('id-ID', {minimumFractionDigits:2, maximumFractionDigits:2});
function escapeJs(str) {
    return String(str).replace(/\\/g,'\\\\').replace(/'/g,"\\'").replace(/"/g,'\\"');
}
 
// =========================================================
// PAGINATION SYSTEM
// =========================================================
const paginationState = {};
 
function attachPagination(tableId, wrapperId, rows, renderFn) {
    const containerId = `pagination-wrap-${tableId}`;
    const old = document.getElementById(containerId);
    if (old) old.remove();
 
    paginationState[tableId] = { page: 1, pageSize: 10, allRows: rows, renderFn };
 
    const wrap = document.createElement('div');
    wrap.id = containerId;
    wrap.style.cssText = `display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;padding:12px 2px 4px;font-size:12px;color:var(--muted);`;
    wrap.innerHTML = `
        <div style="display:flex;align-items:center;gap:8px;">
            <span style="color:var(--muted);">Rows per page:</span>
            <select id="pagesize-${tableId}" onchange="onPageSizeChange('${tableId}')"
                style="padding:4px 8px;border:1px solid var(--border);border-radius:6px;font-size:12px;color:var(--navy);background:white;cursor:pointer;font-weight:600;">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="all">All</option>
            </select>
        </div>
        <div id="page-info-${tableId}" style="font-size:12px;color:var(--muted);"></div>
        <div style="display:flex;align-items:center;gap:4px;" id="page-btns-${tableId}"></div>`;
 
    // Insert after the table wrapper div if wrapperId given, else after the table itself
    const anchor = wrapperId ? document.getElementById(wrapperId) : document.getElementById(tableId);
    if (anchor) anchor.insertAdjacentElement('afterend', wrap);
 
    renderPage(tableId);
}
 
// FIX: reset pagination for a table so attachPagination is called fresh next render
function resetTablePagination(tableId) {
    delete paginationState[tableId];
    const old = document.getElementById(`pagination-wrap-${tableId}`);
    if (old) old.remove();
    // Also clear sort-wired flags so headers are re-wired
    const table = document.getElementById(tableId);
    if (table) table.querySelectorAll('thead th').forEach(th => delete th.dataset.sortWired);
}
 
function onPageSizeChange(tableId) {
    const sel = document.getElementById(`pagesize-${tableId}`);
    const state = paginationState[tableId];
    if (!state || !sel) return;
    state.pageSize = sel.value === 'all' ? 'all' : parseInt(sel.value);
    state.page = 1;
    renderPage(tableId);
}
 
function renderPage(tableId) {
    const state = paginationState[tableId];
    if (!state) return;
    const { allRows, pageSize, renderFn } = state;
    let { page } = state;
    const totalRows = allRows.length;
    const isAll = pageSize === 'all';
    const totalPages = isAll ? 1 : Math.max(1, Math.ceil(totalRows / pageSize));
    page = Math.min(Math.max(1, page), totalPages);
    state.page = page;
    const start = isAll ? 0 : (page - 1) * pageSize;
    const end   = isAll ? totalRows : Math.min(start + pageSize, totalRows);
    renderFn(allRows.slice(start, end));
 
    const info = document.getElementById(`page-info-${tableId}`);
    if (info) {
        info.textContent = totalRows === 0 ? 'No data'
            : isAll ? `Showing all ${totalRows.toLocaleString()} rows`
            : `${(start+1).toLocaleString()}–${end.toLocaleString()} of ${totalRows.toLocaleString()} rows`;
    }
 
    const btns = document.getElementById(`page-btns-${tableId}`);
    if (!btns) return;
    if (isAll || totalPages <= 1) { btns.innerHTML = ''; return; }
 
    const btnStyle = (active, disabled) => `min-width:28px;height:28px;padding:0 6px;border:1px solid ${active?'#1B3A6B':'var(--border)'};border-radius:6px;font-size:12px;font-weight:${active?'700':'500'};background:${active?'#1B3A6B':'white'};color:${active?'white':'var(--navy)'};cursor:${disabled?'default':'pointer'};transition:all 0.15s;`;
 
    let html = `<button style="${btnStyle(false, page===1)}" ${page===1?'disabled':''} onclick="goToPage('${tableId}',${page-1})">&lsaquo;</button>`;
    const delta = 1;
    const pages = [];
    for (let p = 1; p <= totalPages; p++) {
        if (p === 1 || p === totalPages || (p >= page-delta && p <= page+delta)) pages.push(p);
    }
    let lastP = 0;
    pages.forEach(p => {
        if (lastP && p - lastP > 1) html += `<span style="padding:0 2px;color:var(--muted);">…</span>`;
        html += `<button style="${btnStyle(p===page, p===page)}" onclick="goToPage('${tableId}',${p})">${p}</button>`;
        lastP = p;
    });
    html += `<button style="${btnStyle(false, page===totalPages)}" ${page===totalPages?'disabled':''} onclick="goToPage('${tableId}',${page+1})">&rsaquo;</button>`;
    btns.innerHTML = html;
}
 
function goToPage(tableId, page) {
    const state = paginationState[tableId];
    if (!state) return;
    state.page = page;
    renderPage(tableId);
}
 
function updatePaginationRows(tableId, newRows) {
    const state = paginationState[tableId];
    if (!state) return;
    state.allRows = newRows;
    state.page = 1;
    renderPage(tableId);
}
 
// =========================================================
// TABLE SORTING (works with pagination)
// =========================================================
function makeTableSortable(tableId) {
    const table = document.getElementById(tableId); if (!table) return;
    const headers = table.querySelectorAll('thead th');
    headers.forEach((header, colIndex) => {
        if (header.dataset.sortWired) return;
        header.dataset.sortWired = '1';
        header.style.cursor = 'pointer';
        header.style.userSelect = 'none';
        const iconSpan = document.createElement('span');
        iconSpan.className = 'sort-icon';
        iconSpan.style.cssText = 'margin-left:4px;font-size:9px;opacity:0.3;vertical-align:middle;';
        iconSpan.textContent = '⇅';
        header.appendChild(iconSpan);
 
        header.addEventListener('click', () => {
            const isAsc = header.classList.contains('sort-asc');
            table.querySelectorAll('thead th').forEach(h => {
                h.classList.remove('sort-asc','sort-desc');
                const ic = h.querySelector('.sort-icon');
                if (ic) { ic.textContent = '⇅'; ic.style.opacity = '0.3'; }
            });
            header.classList.add(isAsc ? 'sort-desc' : 'sort-asc');
            iconSpan.textContent = isAsc ? '▲' : '▼';
            iconSpan.style.opacity = '0.8';
            const direction = isAsc ? -1 : 1;
 
            const state = paginationState[tableId];
            if (state) {
                state.allRows.sort((a, b) => {
                    const aVal = getRowColValue(a, colIndex, tableId);
                    const bVal = getRowColValue(b, colIndex, tableId);
                    const aNum = parseFloat(String(aVal).replace(/[^0-9.-]/g,''));
                    const bNum = parseFloat(String(bVal).replace(/[^0-9.-]/g,''));
                    if (!isNaN(aNum) && !isNaN(bNum)) return (aNum-bNum)*direction;
                    return String(aVal).localeCompare(String(bVal))*direction;
                });
                state.page = 1;
                renderPage(tableId);
            } else {
                const tbody = table.querySelector('tbody');
                const rows  = Array.from(tbody.querySelectorAll('tr'));
                rows.sort((a,b) => {
                    if (!a.cells[colIndex]||!b.cells[colIndex]) return 0;
                    let aText = a.cells[colIndex].textContent.trim();
                    let bText = b.cells[colIndex].textContent.trim();
                    let aNum  = parseFloat(aText.replace(/[^0-9.-]+/g,''));
                    let bNum  = parseFloat(bText.replace(/[^0-9.-]+/g,''));
                    if (!isNaN(aNum)&&!isNaN(bNum)&&aText.match(/[0-9]/)&&bText.match(/[0-9]/)) return (aNum-bNum)*direction;
                    return aText.localeCompare(bText)*direction;
                });
                tbody.append(...rows);
            }
        });
    });
}
 
function getRowColValue(row, colIndex, tableId) {
    if (['pivotReportTable','dc02Table','dc12Table','dc04Table','dc06Table','dc08Table'].includes(tableId)) {
        return [row.family, row.customer, row.material, row.dc, row.qty, row.rev, row.gp][colIndex] ?? '';
    }
    if (tableId === 'rawTable') {
        const keys = ['business_area','dc','division','sales_doc_type','month_num','month','year',
                      'salesman_id','salesman','customer_id','customer','material_id','material',
                      'qty','gross_revenue','logistic_expense','net_revenue','cogs','gross_gp','gross_gm_percent'];
        return row[keys[colIndex]] ?? '';
    }
    if (tableId === 'mmTable') {
        return [row.material_id, row.material_name, row.family, row.sub1, row.sub2, ''][colIndex] ?? '';
    }
    if (tableId === 'msTable') {
        const rev = row.gross_revenue ?? 0;
        const gp  = row.gross_gp ?? 0;
        const qty = row.qty ?? 0;
        const gm  = rev > 0 ? (gp/rev*100) : 0;
        return [row.salesman_id, row.salesman, qty, rev, gp, gm, ''][colIndex] ?? '';
    }
    return '';
}
 
// =========================================================
// NAVIGATION — main items
// =========================================================
function activateNavItem(el) {
    document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.nav-sub-item').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    const targetId = el.dataset.target;
    document.querySelectorAll('.content-view').forEach(v => v.classList.remove('active'));
    document.getElementById(targetId)?.classList.add('active');
    const titles = {
        'dashboard-content':        'Data Preparation Dashboard',
        'sales-report-content':     'Sales Report Summary',
        'resume-all-content':       'Resume All Business',
        'sr-raw-content':           'Raw Sales Data',
        'sr-dc02-content':          'Paper DC 02',
        'sr-dc12-content':          'Oil Field DC 12',
        'sr-dc04-content':          'Plastic Rubber & RA DC 04',
        'sr-dc06-content':          'Textile DC 06',
        'sr-dc08-content':          'PHC DC 08',
        'master-material-content':  'Master Material',
        'master-salesman-content':  'Master Salesman',
    };
    document.getElementById('topbar-title').innerText = titles[targetId] || '';
    const salesViews = ['sales-report-content','sr-raw-content','sr-dc02-content','sr-dc12-content','sr-dc04-content','sr-dc06-content','sr-dc08-content'];
    const baFilter = document.getElementById('businessAreaFilter');
    if (salesViews.includes(targetId)) {
        baFilter.style.display = 'block';
        if (salesReportDBData.length === 0) fetchSalesReportFromDB();
    } else {
        baFilter.style.display = 'none';
        closeBADropdown();
    }
    if (targetId === 'resume-all-content') {
        if (resumeDBData.length === 0) fetchResumeData();
        else renderResumeReport();
    }
    if (targetId === 'master-material-content') renderMasterMaterial();
    if (targetId === 'master-salesman-content') renderMasterSalesman();
    if (!salesViews.includes(targetId)) closeSalesMenu();
}
 
// =========================================================
// NAVIGATION — Sales Report parent + sub items
// =========================================================
var salesMenuOpen = false;
function toggleSalesReportMenu(el) {
    salesMenuOpen = !salesMenuOpen;
    const submenu = document.getElementById('sales-report-submenu');
    const chevron = document.getElementById('sales-chevron');
    submenu.style.maxHeight = salesMenuOpen ? '300px' : '0';
    chevron.style.transform = salesMenuOpen ? 'rotate(180deg)' : 'rotate(0deg)';
    document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    if (salesMenuOpen) {
        const firstChild = document.querySelector('.nav-sub-item');
        if (firstChild && !document.querySelector('.nav-sub-item.active')) activateSalesSubItem(firstChild);
    }
}
function closeSalesMenu() {
    salesMenuOpen = false;
    document.getElementById('sales-report-submenu').style.maxHeight = '0';
    document.getElementById('sales-chevron').style.transform = 'rotate(0deg)';
}
function activateSalesSubItem(el) {
    document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));
    document.getElementById('nav-sales-report-parent').classList.add('active');
    document.querySelectorAll('.nav-sub-item').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    const targetId = el.dataset.target;
    document.querySelectorAll('.content-view').forEach(v => v.classList.remove('active'));
    document.getElementById(targetId)?.classList.add('active');
    const titles = {
        'sr-raw-content':       'Raw Sales Data',
        'sales-report-content': 'Sales Report Summary',
        'sr-dc02-content':      'Paper DC 02',
        'sr-dc12-content':      'Oil Field DC 12',
        'sr-dc04-content':      'Plastic Rubber & RA DC 04',
        'sr-dc06-content':      'Textile DC 06',
        'sr-dc08-content':      'PHC DC 08',
    };
    document.getElementById('topbar-title').innerText = titles[targetId] || 'Sales Report';
    document.getElementById('businessAreaFilter').style.display = 'block';
    if (salesReportDBData.length === 0) fetchSalesReportFromDB();
    else renderViewForTarget(targetId);
}
function renderViewForTarget(targetId) {
    if (targetId === 'sr-raw-content')            renderRawView();
    else if (targetId === 'sales-report-content') renderSalesReportFromDB();
    else if (targetId === 'sr-dc02-content')      renderDCView('DC 2',  'dc02');
    else if (targetId === 'sr-dc12-content')      renderDCView('DC 12', 'dc12');
    else if (targetId === 'sr-dc04-content')      renderDCView('DC 4',  'dc04');
    else if (targetId === 'sr-dc06-content')      renderDCView('DC 6',  'dc06');
    else if (targetId === 'sr-dc08-content')      renderDCView('DC 8',  'dc08');
}
 
// =========================================================
// BUSINESS AREA DROPDOWN
// =========================================================
function toggleBADropdown() {
    const menu = document.getElementById('baDropdownMenu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}
function closeBADropdown() { document.getElementById('baDropdownMenu').style.display = 'none'; }
document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('businessAreaFilter');
    if (wrapper && !wrapper.contains(e.target)) closeBADropdown();
});
function selectBusinessArea(value, label) {
    currentBAFilter = value;
    document.getElementById('baDropdownLabel').textContent = label;
    document.querySelectorAll('.ba-option').forEach(opt => {
        opt.classList.toggle('active', opt.dataset.value === value);
        opt.style.fontWeight = opt.dataset.value === value ? '700' : '400';
        opt.style.background = opt.dataset.value === value ? '#f0f4ff' : 'white';
    });
    closeBADropdown();
    buildGroupedData();
 
    // FIX: reset pagination state for all SR/DC tables so they re-attach fresh
    ['pivotReportTable','rawTable','dc02Table','dc12Table','dc04Table','dc06Table','dc08Table']
        .forEach(tid => resetTablePagination(tid));
 
    const activeView = document.querySelector('.content-view.active');
    if (activeView) renderViewForTarget(activeView.id);
}
 
// =========================================================
// FETCH DATA FROM DB
// =========================================================
async function fetchSalesReportFromDB() {
    showAllLoadings();
    try {
        const response = await fetch('/sales/report-data', { headers: { 'Accept': 'application/json' } });
        if (!response.ok) throw new Error(`Server error: ${response.status}`);
        const result = await response.json();
        if (!result.success) throw new Error(result.message || 'Failed to fetch data');
        salesReportDBData = result.data;
        buildGroupedData();
        const activeView = document.querySelector('.content-view.active');
        if (activeView) renderViewForTarget(activeView.id);
    } catch (err) {
        const msg = `<div style="color:#dc2626;font-size:13px;">⚠ Gagal memuat data: ${err.message}</div>`;
        ['salesReportLoading','rawLoading','dc02Loading','dc12Loading','dc04Loading','dc06Loading','dc08Loading']
            .forEach(id => { const el = document.getElementById(id); if(el) el.innerHTML = msg; });
        console.error(err);
    }
}
function showAllLoadings() {
    ['salesReportLoading','rawLoading','dc02Loading','dc12Loading','dc04Loading','dc06Loading','dc08Loading']
        .forEach(id => { const el = document.getElementById(id); if(el) el.style.display = 'block'; });
    ['salesReportTableWrap','rawTableWrap','dc02TableWrap','dc12TableWrap','dc04TableWrap','dc06TableWrap','dc08TableWrap']
        .forEach(id => { const el = document.getElementById(id); if(el) el.style.display = 'none'; });
}
 
// =========================================================
// DC → FAMILY MAPPING
// =========================================================
const dcFamilyMapGlobal = {
    '2':'PAPER CHEMICAL','02':'PAPER CHEMICAL',
    '4':'PLASTIC, RUBBER','04':'PLASTIC, RUBBER',
    '6':'TEXTILE','06':'TEXTILE',
    '8':'PERSONAL & HOME CARE','08':'PERSONAL & HOME CARE',
    '12':'OIL FIELD, MINING'
};
function getFamily(dcRaw) {
    const dcNum = String(dcRaw).replace(/^DC\s*/i, '').trim();
    return dcFamilyMapGlobal[dcNum] || dcFamilyMapGlobal[dcRaw] || 'OTHERS';
}
 
// =========================================================
// BUILD GROUPED DATA
// =========================================================
function buildGroupedData() {
    let filtered = salesReportDBData;
    if (currentBAFilter !== 'ALL') {
        filtered = filtered.filter(r => String(r.business_area || '').trim() === currentBAFilter.trim());
    }
    const map = {};
    filtered.forEach(row => {
        const dcRaw    = String(row.dc || '').trim();
        const family   = getFamily(dcRaw);
        const customer = row.customer || 'Unknown';
        const material = row.material || 'Unknown';
        const key = `${family}|${customer}|${material}|${dcRaw}`;
        if (!map[key]) map[key] = { family, customer, material, dc: dcRaw, qty:0, rev:0, gp:0 };
        map[key].qty += parseFloat(row.qty) || 0;
        map[key].rev += parseFloat(row.gross_revenue) || 0;
        map[key].gp  += parseFloat(row.gross_gp) || 0;
    });
    groupedSRRows = Object.values(map);
    const allDCs = ['DC 2','DC 12','DC 4','DC 6','DC 8'];
    groupedDCRows = {};
    allDCs.forEach(dc => { groupedDCRows[dc] = groupedSRRows.filter(r => r.dc === dc); });
}
 
// =========================================================
// RENDER — RAW VIEW
// =========================================================
var rawBaseRows = [];
function renderRawView() {
    const loading = document.getElementById('rawLoading');
    const wrap    = document.getElementById('rawTableWrap');
    const info    = document.getElementById('rawDataInfo');
    if (salesReportDBData.length === 0) { loading.style.display='block'; wrap.style.display='none'; info.style.display='none'; return; }
    let rows = salesReportDBData;
    if (currentBAFilter !== 'ALL') rows = rows.filter(r => String(r.business_area||'').trim() === currentBAFilter.trim());
    rawBaseRows = rows.map(r => ({
        business_area:    r.business_area    || '',
        dc:               r.dc               || '',
        division:         r.division         || '',
        sales_doc_type:   r.sales_doc_type   || '',
        month_num:        r.month_num        ?? '',
        month:            r.month            || '',
        year:             r.year             ?? '',
        salesman_id:      r.salesman_id      || '',
        salesman:         r.salesman         || '',
        customer_id:      r.customer_id      || '',
        customer:         r.customer         || '',
        material_id:      r.material_id      || '',
        material:         r.material         || '',
        qty:              parseFloat(r.qty)              || 0,
        gross_revenue:    parseFloat(r.gross_revenue)    || 0,
        logistic_expense: parseFloat(r.logistic_expense) || 0,
        net_revenue:      parseFloat(r.net_revenue)      || 0,
        cogs:             parseFloat(r.cogs)             || 0,
        gross_gp:         parseFloat(r.gross_gp)         || 0,
        gross_gm_percent: r.gross_gm_percent != null ? parseFloat(r.gross_gm_percent) : null,
    }));
    document.getElementById('rawSub').innerHTML = currentBAFilter === 'ALL'
        ? 'All raw records from database — per row, not aggregated.'
        : `Filtered by Business Area: <strong>${currentBAFilter}</strong>`;
    loading.style.display = 'none';
    wrap.style.display    = 'block';
    info.style.display    = 'block';
    applyRawFilters();
}
 
function applyRawFilters() {
    const family   = (document.getElementById('raw-filter-family')?.value   || '').toLowerCase().trim();
    const customer = (document.getElementById('raw-filter-customer')?.value  || '').toLowerCase().trim();
    const material = (document.getElementById('raw-filter-material')?.value  || '').toLowerCase().trim();
    const dc       = (document.getElementById('raw-filter-dc')?.value        || '').trim();
    const filtered = rawBaseRows.filter(r => {
        const fam = getFamily(String(r.dc).trim()).toLowerCase();
        return (!family   || fam.includes(family))
            && (!customer || r.customer.toLowerCase().includes(customer))
            && (!material || r.material.toLowerCase().includes(material))
            && (!dc       || r.dc === dc);
    });
 
    const fmt  = n => Math.round(n).toLocaleString('id-ID');
    const fmtD = n => n != null ? n.toLocaleString('id-ID',{minimumFractionDigits:2,maximumFractionDigits:2})+'%' : '-';
 
    const renderFn = (slice) => {
        const tbody = document.getElementById('rawTableBody');
        tbody.innerHTML = slice.length === 0
            ? `<tr><td colspan="20" style="text-align:center;padding:30px;color:var(--muted);">Tidak ada data.</td></tr>`
            : slice.map(r => {
                const gm = r.gross_gm_percent;
                const gmColor = gm != null ? (gm >= 20 ? '#16a34a' : '#dc2626') : 'var(--muted)';
                return `<tr>
                    <td>${r.business_area}</td><td>${r.dc}</td><td>${r.division}</td><td>${r.sales_doc_type}</td>
                    <td class="num" style="text-align:right;">${r.month_num}</td>
                    <td>${r.month}</td>
                    <td class="num" style="text-align:right;">${r.year}</td>
                    <td>${r.salesman_id}</td><td>${r.salesman}</td><td>${r.customer_id}</td><td>${r.customer}</td><td>${r.material_id}</td>
                    <td><span style="background:#f1f5f9;padding:4px 8px;border-radius:4px;font-size:11px;color:var(--muted);border:1px solid var(--border);">${r.material}</span></td>
                    <td class="num" style="text-align:right;">${fmt(r.qty)}</td>
                    <td class="num" style="text-align:right;">${fmt(r.gross_revenue)}</td>
                    <td class="num" style="text-align:right;">${fmt(r.logistic_expense)}</td>
                    <td class="num" style="text-align:right;">${fmt(r.net_revenue)}</td>
                    <td class="num" style="text-align:right;">${fmt(r.cogs)}</td>
                    <td class="num" style="text-align:right;">${fmt(r.gross_gp)}</td>
                    <td class="num" style="text-align:right;font-weight:700;color:${gmColor};">${fmtD(gm)}</td>
                </tr>`;
            }).join('');
    };
 
    document.getElementById('rawRowCount').textContent = filtered.length.toLocaleString();
    const cnt = document.getElementById('raw-filter-count');
    if (cnt) cnt.textContent = filtered.length < rawBaseRows.length
        ? `${filtered.length.toLocaleString()} of ${rawBaseRows.length.toLocaleString()} rows` : '';
 
    if (paginationState['rawTable']) {
        updatePaginationRows('rawTable', filtered);
    } else {
        attachPagination('rawTable', 'rawTableWrap', filtered, renderFn);
        makeTableSortable('rawTable');
    }
}
 
function clearRawFilters() {
    ['raw-filter-family','raw-filter-customer','raw-filter-material'].forEach(id => { const el=document.getElementById(id); if(el) el.value=''; });
    const dcEl = document.getElementById('raw-filter-dc'); if(dcEl) dcEl.value='';
    const cnt  = document.getElementById('raw-filter-count'); if(cnt) cnt.textContent='';
    applyRawFilters();
}
function exportRawData() {
    const table = document.getElementById('rawTable'); if(!table) return;
    const wb = XLSX.utils.table_to_book(table, { sheet:'Raw Data' });
    XLSX.writeFile(wb, 'Raw_Sales_Data.xlsx');
}
 
// =========================================================
// RENDER — SALES REPORT SUMMARY
// =========================================================
 
// FIX: show the wrap BEFORE calling renderSRTable so the pagination
// control has a visible anchor to insert after, and renderPage runs
// against an already-visible tbody.
function renderSalesReportFromDB() {
    document.getElementById('salesReportSub').innerHTML = currentBAFilter === 'ALL'
        ? 'Automatically grouped by Product Family, Customer, and Material.'
        : `Filtered by Business Area: <strong>${currentBAFilter}</strong>`;
 
    // Show wrap FIRST, hide loading
    document.getElementById('salesReportLoading').style.display = 'none';
    document.getElementById('salesReportTableWrap').style.display = 'block';
 
    applyAllSRFilters();
}
 
// FIX: renderSRTable now only handles the actual data render + pagination.
// The wrap show/hide is the caller's responsibility (done before this call).
function renderSRTable(rows, tbodyId) {
    const tbodyToTable = {
        'salesReportBody': 'pivotReportTable',
        'dc02Body': 'dc02Table', 'dc12Body': 'dc12Table',
        'dc04Body': 'dc04Table', 'dc06Body': 'dc06Table', 'dc08Body': 'dc08Table',
    };
    const tbodyToWrap = {
        'salesReportBody': 'salesReportTableWrap',
        'dc02Body': 'dc02TableWrap', 'dc12Body': 'dc12TableWrap',
        'dc04Body': 'dc04TableWrap', 'dc06Body': 'dc06TableWrap', 'dc08Body': 'dc08TableWrap',
    };
    const tableId   = tbodyToTable[tbodyId];
    const wrapperId = tbodyToWrap[tbodyId];
 
    const renderFn = (slice) => {
        const tbody = document.getElementById(tbodyId); if (!tbody) return;
        tbody.innerHTML = slice.length === 0
            ? `<tr><td colspan="7" style="text-align:center;padding:30px;color:var(--muted);">Tidak ada data.</td></tr>`
            : slice.map(item => `<tr>
                <td><span style="font-weight:700;color:var(--navy);">${item.family}</span></td>
                <td>${item.customer}</td>
                <td><span style="background:#f1f5f9;padding:4px 8px;border-radius:4px;font-size:11px;color:var(--muted);border:1px solid var(--border);">${item.material}</span></td>
                <td>${item.dc}</td>
                <td class="num" style="text-align:right;">${formatNum(item.qty)}</td>
                <td class="num" style="text-align:right;">${formatNum(item.rev)}</td>
                <td class="num" style="text-align:right;">${formatNum(item.gp)}</td>
            </tr>`).join('');
    };
 
    if (!tableId) { renderFn(rows); return; }
 
    if (paginationState[tableId]) {
        updatePaginationRows(tableId, rows);
    } else {
        attachPagination(tableId, wrapperId, rows, renderFn);
        makeTableSortable(tableId);
    }
}
 
function getFilterValues(prefix) {
    return {
        family:   (document.getElementById(`${prefix}-filter-family`)?.value  || '').toLowerCase().trim(),
        customer: (document.getElementById(`${prefix}-filter-customer`)?.value || '').toLowerCase().trim(),
        material: (document.getElementById(`${prefix}-filter-material`)?.value || '').toLowerCase().trim(),
        dc:       (document.getElementById(`${prefix}-filter-dc`)?.value       || '').trim(),
    };
}
function filterRows(rows, f) {
    return rows.filter(r =>
        (!f.family   || r.family.toLowerCase().includes(f.family))
     && (!f.customer || r.customer.toLowerCase().includes(f.customer))
     && (!f.material || r.material.toLowerCase().includes(f.material))
     && (!f.dc       || r.dc === f.dc)
    );
}
function applyAllSRFilters() {
    const f = getFilterValues('sr');
    const filtered = filterRows(groupedSRRows, f);
    renderSRTable(filtered, 'salesReportBody');
    const cnt = document.getElementById('sr-filter-count');
    if (cnt) cnt.textContent = filtered.length < groupedSRRows.length
        ? `${filtered.length.toLocaleString()} of ${groupedSRRows.length.toLocaleString()} rows` : '';
}
function applyDCFilter(prefix, dcValue) {
    const f = getFilterValues(prefix);
    const filtered = filterRows(groupedDCRows[dcValue] || [], f);
    renderSRTable(filtered, `${prefix}Body`);
}
function clearSRFilters(prefix) {
    ['family','customer','material'].forEach(field => { const el=document.getElementById(`${prefix}-filter-${field}`); if(el) el.value=''; });
    const dcEl = document.getElementById(`${prefix}-filter-dc`); if(dcEl) dcEl.value='';
    const cnt  = document.getElementById(`${prefix}-filter-count`); if(cnt) cnt.textContent='';
    if (prefix === 'sr') applyAllSRFilters();
    else { const dcMap={dc02:'DC 2',dc12:'DC 12',dc04:'DC 4',dc06:'DC 6',dc08:'DC 8'}; if(dcMap[prefix]) applyDCFilter(prefix, dcMap[prefix]); }
}
 
// =========================================================
// RENDER — DC FILTERED VIEWS
// FIX: show wrap BEFORE calling renderSRTable (same fix as SR summary)
// =========================================================
function renderDCView(dcValue, prefix) {
    // Show wrap FIRST, hide loading
    document.getElementById(`${prefix}Loading`).style.display = 'none';
    document.getElementById(`${prefix}TableWrap`).style.display = 'block';
 
    renderSRTable(groupedDCRows[dcValue] || [], `${prefix}Body`);
 
    ['family','customer','material','dc'].forEach(field => {
        const el = document.getElementById(`${prefix}-filter-${field}`);
        if (el && !el.dataset.wired) {
            el.dataset.wired = '1';
            el.addEventListener(el.tagName==='SELECT'?'change':'input', () => applyDCFilter(prefix, dcValue));
        }
    });
}
 
// =========================================================
// FILE UPLOAD — Data Prep
// =========================================================
document.getElementById('fileUpload').addEventListener('change', handleFile, false);
function handleFile(e) {
    const files = e.target.files; if(files.length===0) return;
    document.getElementById('loadingModal').style.display = 'flex';
    setTimeout(() => {
        try {
            const reader = new FileReader();
            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type:'array', cellDates:true });
                const rawDataJson = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]], { raw:false, defval:'' });
                originalDashboardData = rawDataJson;
                initializeDashboard(rawDataJson);
                document.getElementById('exportBtn').disabled = false;
                document.getElementById('loadingModal').style.display = 'none';
            };
            reader.readAsArrayBuffer(files[0]);
        } catch(err) { console.error(err); alert("Error processing the Excel file."); document.getElementById('loadingModal').style.display='none'; }
    }, 100);
}
 
function initializeDashboard(data) {
    const tableHead = document.getElementById('tableHead'); tableHead.innerHTML='';
    if (!data || data.length===0) return;
    const rawHeaders   = Object.keys(data[0]);
    const cleanHeaders = rawHeaders.map(cleanKey);
    window._dashRawHeaders   = rawHeaders;
    window._dashCleanHeaders = cleanHeaders;
    const headerRow = document.createElement('tr');
    cleanHeaders.forEach(h => { const th=document.createElement('th'); th.textContent=h; headerRow.appendChild(th); });
    tableHead.appendChild(headerRow);
    renderDashboardBody(data, rawHeaders, cleanHeaders);
    populateDcTaskbar(data, rawHeaders, cleanHeaders);
    document.getElementById('dataInfo').style.display = 'block';
    updateRowCount(data.length);
    makeTableSortable('reportTable');
}
 
function renderDashboardBody(data, rawHeaders, cleanHeaders) {
    window._dashRawHeaders   = rawHeaders;
    window._dashCleanHeaders = cleanHeaders;
 
    const renderFn = (slice) => {
        const tbody = document.getElementById('tableBody'); tbody.innerHTML='';
        slice.forEach(row => {
            const tr = document.createElement('tr');
            rawHeaders.forEach((rawHeader, i) => {
                const td = document.createElement('td');
                td.textContent = row[rawHeader] !== undefined ? row[rawHeader] : '';
                const h = cleanHeaders[i].toLowerCase();
                if (h.includes('qty')||h.includes('rev')||h.includes('gp')||h.includes('gm')||h.includes('logistic')||h.includes('cogs')||h.includes('expense'))
                    td.classList.add('num');
                tr.appendChild(td);
            });
            tbody.appendChild(tr);
        });
    };
 
    if (paginationState['reportTable']) {
        paginationState['reportTable'].renderFn = renderFn;
        updatePaginationRows('reportTable', data);
    } else {
        const tableContainer = document.querySelector('#dashboard-content .table-container');
        attachPagination('reportTable', null, data, renderFn);
        if (tableContainer) {
            const wrap = document.getElementById('pagination-wrap-reportTable');
            if (wrap) tableContainer.insertAdjacentElement('afterend', wrap);
        }
        makeTableSortable('reportTable');
    }
}
 
function updateRowCount(count, filterLabel) {
    document.getElementById('rowCount').textContent = count.toLocaleString();
    document.getElementById('filterInfo').textContent = filterLabel ? ` · filtered by ${filterLabel}` : '';
}
function populateDcTaskbar(data, rawHeaders, cleanHeaders) {
    const taskbar = document.getElementById('dcTaskbar'); taskbar.innerHTML='';
    const allBtn = document.createElement('div');
    allBtn.classList.add('dc-btn','active'); allBtn.id='dc-all'; allBtn.textContent='All DCs';
    allBtn.onclick = () => filterByDCDashboard('ALL', rawHeaders, cleanHeaders);
    taskbar.appendChild(allBtn);
    VALID_DCS.forEach(dcValue => {
        const dcBtn = document.createElement('div');
        dcBtn.classList.add('dc-btn'); dcBtn.id=`dc-${dcValue.replace(/\s+/g,'-')}`; dcBtn.textContent=dcValue;
        dcBtn.onclick = () => filterByDCDashboard(dcValue, rawHeaders, cleanHeaders);
        taskbar.appendChild(dcBtn);
    });
}
function getDcColumn(rawHeaders) { return rawHeaders.find(h => cleanKey(h)==='DC') || null; }
function filterByDCDashboard(selectedDC, rawHeaders, cleanHeaders) {
    document.querySelectorAll('.dc-btn').forEach(btn => btn.classList.remove('active'));
    const activeId  = selectedDC==='ALL' ? 'dc-all' : `dc-${selectedDC.replace(/\s+/g,'-')}`;
    const activeBtn = document.getElementById(activeId); if(activeBtn) activeBtn.classList.add('active');
    const dcCol = getDcColumn(rawHeaders);
    const filteredData = selectedDC==='ALL'
        ? originalDashboardData
        : originalDashboardData.filter(row => String(dcCol?row[dcCol]:'').trim()===selectedDC);
    renderDashboardBody(filteredData, rawHeaders, cleanHeaders);
    updateRowCount(filteredData.length, selectedDC!=='ALL'?selectedDC:null);
}
 
// =========================================================
// SAVE TO DATABASE
// =========================================================
document.getElementById('exportBtn').addEventListener('click', async function() {
    if (originalDashboardData.length===0) return;
    const btn = this; btn.disabled=true;
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfMeta) { showToast('✗ CSRF token missing.','#dc2626'); btn.disabled=false; return; }
    const payload    = originalDashboardData.map(mapRowToPayload);
    const CHUNK_SIZE = 200;
    const chunks     = [];
    for (let i=0; i<payload.length; i+=CHUNK_SIZE) chunks.push(payload.slice(i,i+CHUNK_SIZE));
    let totalInserted = 0;
    try {
        for (let i=0; i<chunks.length; i++) {
            btn.textContent = `Saving… (${i+1}/${chunks.length})`;
            const response = await fetch('/sales/store', {
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfMeta.getAttribute('content'),'Accept':'application/json'},
                body:JSON.stringify({transactions:chunks[i]}),
            });
            const rawText = await response.text();
            let result;
            try { result=JSON.parse(rawText); } catch { showToast(`✗ Server error pada batch ${i+1}.`,'#dc2626'); console.error(rawText); return; }
            if (!response.ok||!result.success) { showToast(`✗ Gagal pada batch ${i+1}: ${result.message||'Unknown error'}`,'#dc2626'); return; }
            totalInserted += result.inserted ?? chunks[i].length;
        }
        showToast(`✓ ${totalInserted} rows saved to database successfully.`,'#16a34a');
        salesReportDBData=[]; groupedSRRows=[]; groupedDCRows={};
        masterMaterialBase=[]; masterSalesmanBase=[];
        ['pivotReportTable','rawTable','dc02Table','dc12Table','dc04Table','dc06Table','dc08Table','mmTable','msTable']
            .forEach(tid => resetTablePagination(tid));
    } catch(err) { showToast(`✗ Network error: ${err.message}`,'#dc2626'); console.error(err); }
    finally { btn.disabled=false; btn.textContent='Save to Database'; }
});
function showToast(msg, bg) {
    const toast = document.getElementById('saveToast');
    document.getElementById('saveToastMsg').textContent = msg;
    toast.style.background = bg||'#1B3A6B';
    toast.style.display = 'block';
    setTimeout(()=>{ toast.style.display='none'; }, 5000);
}
 
// =========================================================
// RESUME ALL BUSINESS
// =========================================================
const MONTH_NAMES   = ['','January','February','March','April','May','June','July','August','September','October','November','December'];
const MONTH_MAP_STR = {january:1,february:2,march:3,april:4,may:5,june:6,july:7,august:8,september:9,october:10,november:11,december:12};
const dcFamilyMap   = {
    '2':'PAPER CHEMICAL','02':'PAPER CHEMICAL',
    '4':'PLASTIC, RUBBER','04':'PLASTIC, RUBBER',
    '6':'TEXTILE','06':'TEXTILE',
    '8':'PERSONAL & HOME CARE','08':'PERSONAL & HOME CARE',
    '12':'OIL FIELD, MINING'
};
const FAMILY_ORDER = ['PAPER CHEMICAL','CHEMICAL','BORATE','OIL FIELD, MINING','PLASTIC, RUBBER','TEXTILE','PERSONAL & HOME CARE','OTHERS'];
 
var currentResumeBA = 'ALL';
 
function toggleResumeBADropdown() {
    const menu = document.getElementById('resumeBAMenu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}
function closeResumeBADropdown() {
    const menu = document.getElementById('resumeBAMenu');
    if (menu) menu.style.display = 'none';
}
function selectResumeBA(value, label) {
    currentResumeBA = value;
    document.getElementById('resumeBALabel').textContent = label;
    document.querySelectorAll('.rba-option').forEach(opt => {
        const isActive = opt.dataset.value === value;
        opt.classList.toggle('active', isActive);
        opt.style.fontWeight  = isActive ? '700' : '400';
        opt.style.background  = isActive ? '#f0f4ff' : 'white';
    });
    closeResumeBADropdown();
}
document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('resumeBAWrapper');
    if (wrapper && !wrapper.contains(e.target)) closeResumeBADropdown();
});
 
async function fetchResumeData() {
    document.getElementById('resumeLoading').style.display = 'block';
    document.getElementById('resumeLoading').innerHTML = '⏳ Loading data from database...';
    document.getElementById('resumeTableWrap').style.display = 'none';
    document.getElementById('resumeMonthlyBreakdownWrap').style.display = 'none';
    try {
        const res = await fetch('/sales/report-data', { headers:{'Accept':'application/json'} });
        if (!res.ok) throw new Error(`Server error: ${res.status}`);
        const result = await res.json();
        if (!result.success) throw new Error(result.message||'Failed to fetch');
        resumeDBData = result.data;
        document.getElementById('resumeYearFilter').value = 'ALL';
        document.getElementById('resumeMonthFilterWrap').style.display = 'none';
        renderResumeReport();
    } catch(err) {
        document.getElementById('resumeLoading').innerHTML =
            `<div style="color:#dc2626;font-size:13px;">⚠ Gagal memuat data: ${err.message}</div>`;
    }
}
 
function getResumeFamily(row) {
    const dcRaw = String(row.dc||'').trim();
    const dcNum = dcRaw.replace(/^DC\s*/i,'').trim();
    return dcFamilyMap[dcNum] || dcFamilyMap[dcRaw] || 'OTHERS';
}
function normalizeMonthNum(r) {
    let mn = parseInt(r.month_num);
    if (isNaN(mn)||mn<1||mn>12) mn = MONTH_MAP_STR[String(r.month||'').toLowerCase().trim()] || null;
    return mn;
}
function aggregateByFamily(rows) {
    const map = {};
    rows.forEach(row => {
        const fam = getResumeFamily(row);
        if (!map[fam]) map[fam] = {qty:0,revenue:0,profit:0};
        map[fam].qty     += parseFloat(row.qty)           || 0;
        map[fam].revenue += parseFloat(row.gross_revenue) || 0;
        map[fam].profit  += parseFloat(row.gross_gp)      || 0;
    });
    return map;
}
function getResumeFilteredData(yearVal, monthVal) {
    let filtered = resumeDBData;
    if (currentResumeBA !== 'ALL') {
        filtered = filtered.filter(r => String(r.business_area||'').trim() === currentResumeBA);
    }
    if (yearVal !== 'ALL') {
        filtered = filtered.filter(r => String(r.year||'').trim() === yearVal);
    }
    if (monthVal && monthVal !== 'ALL') {
        const mn = parseInt(monthVal);
        filtered = filtered.filter(r => normalizeMonthNum(r) === mn);
    }
    return filtered;
}
function onResumeYearChange() {
    const yearVal   = document.getElementById('resumeYearFilter').value;
    const monthWrap = document.getElementById('resumeMonthFilterWrap');
    if (yearVal === 'ALL') {
        monthWrap.style.display = 'none';
    } else {
        let yearRows = resumeDBData.filter(r => String(r.year||'').trim() === yearVal);
        if (currentResumeBA !== 'ALL') {
            yearRows = yearRows.filter(r => String(r.business_area||'').trim() === currentResumeBA);
        }
        const monthsInData = [...new Set(yearRows.map(r => normalizeMonthNum(r)).filter(Boolean))].sort((a,b)=>a-b);
        const sel = document.getElementById('resumeMonthFilter');
        sel.innerHTML = `<option value="ALL">All Months (YTD)</option>`;
        monthsInData.forEach(m => { sel.innerHTML += `<option value="${m}">${MONTH_NAMES[m]}</option>`; });
        sel.value = 'ALL';
        monthWrap.style.display = 'flex';
    }
}
function renderResumeReport() {
    if (resumeDBData.length === 0) return;
    document.getElementById('resumeLoading').style.display = 'block';
    document.getElementById('resumeLoading').innerHTML = '⏳ Sedang menyaring data...';
    document.getElementById('resumeTableWrap').style.display = 'none';
    document.getElementById('resumeMonthlyBreakdownWrap').style.display = 'none';
    setTimeout(() => {
        const yearVal  = document.getElementById('resumeYearFilter').value;
        const monthSel = document.getElementById('resumeMonthFilter');
        const monthVal = (yearVal !== 'ALL' && monthSel) ? monthSel.value : 'ALL';
        const filtered = getResumeFilteredData(yearVal, monthVal);
        let baLabel = currentResumeBA !== 'ALL' ? ` · ${currentResumeBA}` : '';
        let label;
        if (yearVal === 'ALL')            label = 'All Data' + baLabel;
        else if (monthVal !== 'ALL')      label = `${MONTH_NAMES[parseInt(monthVal)]} ${yearVal}` + baLabel;
        else                              label = `YTD ${yearVal}` + baLabel;
        document.getElementById('resumeRowInfo').textContent = `(${filtered.length.toLocaleString()} records)`;
        document.getElementById('resumeSub').innerHTML = `Showing data for: <strong>${label}</strong>`;
        renderResumeSingleTable(filtered, label);
        if (yearVal !== 'ALL' && monthVal === 'ALL') renderResumeMonthlyBreakdown(yearVal);
        document.getElementById('resumeLoading').style.display = 'none';
    }, 100);
}
function renderResumeSingleTable(rows, label) {
    document.getElementById('resumeTableWrap').style.display = 'block';
    document.getElementById('resumeMonthColHeader').textContent = label.toUpperCase();
    const map   = aggregateByFamily(rows);
    const tbody = document.getElementById('resumeTableBody');
    tbody.innerHTML = '';
    let totalQty=0, totalRev=0, totalProfit=0;
    const allFamilies = [...FAMILY_ORDER, ...Object.keys(map).filter(f=>!FAMILY_ORDER.includes(f))];
    allFamilies.forEach(fam => {
        if (!map[fam]) return;
        const d  = map[fam];
        const gm = d.revenue > 0 ? (d.profit/d.revenue*100) : 0;
        totalQty+=d.qty; totalRev+=d.revenue; totalProfit+=d.profit;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td style="font-weight:600;color:var(--navy);">${fam}</td>
            <td class="num" style="text-align:right;">${formatNum(d.qty)}</td>
            <td class="num" style="text-align:right;">${formatNum(d.revenue)}</td>
            <td class="num" style="text-align:right;">${formatNum(d.profit)}</td>
            <td class="num" style="text-align:right;font-weight:700;color:${gm>=20?'#16a34a':'#dc2626'};">${formatDec2(gm)}%</td>`;
        tbody.appendChild(tr);
    });
    const totalGM = totalRev > 0 ? (totalProfit/totalRev*100) : 0;
    const trTotal = document.createElement('tr');
    trTotal.style.cssText = 'background:#1B3A6B;color:white;font-weight:700;';
    trTotal.innerHTML = `
        <td style="color:white;font-weight:800;letter-spacing:0.05em;">TOTAL</td>
        <td class="num" style="text-align:right;color:white;">${formatNum(totalQty)}</td>
        <td class="num" style="text-align:right;color:white;">${formatNum(totalRev)}</td>
        <td class="num" style="text-align:right;color:white;">${formatNum(totalProfit)}</td>
        <td class="num" style="text-align:right;color:#F5A623;font-weight:800;">${formatDec2(totalGM)}%</td>`;
    tbody.appendChild(trTotal);
}
function renderResumeMonthlyBreakdown(yearVal) {
    const container = document.getElementById('resumeMonthlyTablesContainer');
    container.innerHTML = '';
    let yearRows = resumeDBData.filter(r => String(r.year||'').trim() === yearVal);
    if (currentResumeBA !== 'ALL') {
        yearRows = yearRows.filter(r => String(r.business_area||'').trim() === currentResumeBA);
    }
    const monthsInData = [...new Set(yearRows.map(r => normalizeMonthNum(r)).filter(Boolean))].sort((a,b)=>a-b);
    if (monthsInData.length === 0) {
        container.innerHTML = `<p style="color:var(--muted);font-size:13px;text-align:center;padding:20px;">Tidak ada data bulan untuk tahun ${yearVal}.</p>`;
        document.getElementById('resumeMonthlyBreakdownWrap').style.display = 'block';
        return;
    }
    monthsInData.forEach(mn => {
        const monthRows = getResumeFilteredData(yearVal, String(mn));
        const map       = aggregateByFamily(monthRows);
        const monthName = MONTH_NAMES[mn];
        const baLabel   = currentResumeBA !== 'ALL' ? ` · ${currentResumeBA}` : '';
        const section = document.createElement('div');
        section.style.cssText = 'margin-bottom:28px;';
        section.innerHTML = `
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
                <div style="width:4px;height:20px;background:#1B3A6B;border-radius:2px;flex-shrink:0;"></div>
                <span style="font-size:14px;font-weight:800;color:var(--navy);">${monthName} ${yearVal}${baLabel}</span>
                <span style="font-size:11px;color:var(--muted);">(${monthRows.length.toLocaleString()} records)</span>
            </div>`;
        const tableId = `resumeMonthTable_${mn}`;
        const tableWrap = document.createElement('div');
        tableWrap.className = 'table-container';
        const table = document.createElement('table');
        table.id        = tableId;
        table.className = 'data-table';
        table.innerHTML = `
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align:middle;min-width:160px;">GROUP PRODUCT</th>
                    <th colspan="4" style="text-align:center;background:#1B3A6B;color:white;">${monthName.toUpperCase()} ${yearVal}${baLabel ? ' · ' + currentResumeBA : ''}</th>
                </tr>
                <tr>
                    <th class="num" style="text-align:right;">QTY</th>
                    <th class="num" style="text-align:right;">REVENUE</th>
                    <th class="num" style="text-align:right;">PROFIT (GP)</th>
                    <th class="num" style="text-align:right;">%GM</th>
                </tr>
            </thead>`;
        const tbody = document.createElement('tbody');
        let totalQty=0, totalRev=0, totalProfit=0;
        const allFamilies = [...FAMILY_ORDER, ...Object.keys(map).filter(f=>!FAMILY_ORDER.includes(f))];
        let hasData = false;
        allFamilies.forEach(fam => {
            if (!map[fam]) return;
            hasData = true;
            const d  = map[fam];
            const gm = d.revenue > 0 ? (d.profit/d.revenue*100) : 0;
            totalQty+=d.qty; totalRev+=d.revenue; totalProfit+=d.profit;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td style="font-weight:600;color:var(--navy);">${fam}</td>
                <td class="num" style="text-align:right;">${formatNum(d.qty)}</td>
                <td class="num" style="text-align:right;">${formatNum(d.revenue)}</td>
                <td class="num" style="text-align:right;">${formatNum(d.profit)}</td>
                <td class="num" style="text-align:right;font-weight:700;color:${gm>=20?'#16a34a':'#dc2626'};">${formatDec2(gm)}%</td>`;
            tbody.appendChild(tr);
        });
        if (!hasData) {
            const trEmpty = document.createElement('tr');
            trEmpty.innerHTML = `<td colspan="5" style="text-align:center;padding:20px;color:var(--muted);">Tidak ada data untuk bulan ini.</td>`;
            tbody.appendChild(trEmpty);
        } else {
            const totalGM = totalRev > 0 ? (totalProfit/totalRev*100) : 0;
            const trTotal = document.createElement('tr');
            trTotal.style.cssText = 'background:#1B3A6B;color:white;font-weight:700;';
            trTotal.innerHTML = `
                <td style="color:white;font-weight:800;letter-spacing:0.05em;">TOTAL</td>
                <td class="num" style="text-align:right;color:white;">${formatNum(totalQty)}</td>
                <td class="num" style="text-align:right;color:white;">${formatNum(totalRev)}</td>
                <td class="num" style="text-align:right;color:white;">${formatNum(totalProfit)}</td>
                <td class="num" style="text-align:right;color:#F5A623;font-weight:800;">${formatDec2(totalGM)}%</td>`;
            tbody.appendChild(trTotal);
        }
        table.appendChild(tbody);
        tableWrap.appendChild(table);
        section.appendChild(tableWrap);
        container.appendChild(section);
        makeTableSortable(tableId);
    });
    document.getElementById('resumeMonthlyBreakdownWrap').style.display = 'block';
}
function exportResumeReport() {
    const yearVal  = document.getElementById('resumeYearFilter').value;
    const monthSel = document.getElementById('resumeMonthFilter');
    const monthVal = monthSel ? monthSel.value : 'ALL';
    const baSlug   = currentResumeBA !== 'ALL' ? `_${currentResumeBA.replace(/\s*-\s*/g,'_')}` : '';
    let label;
    if (yearVal === 'ALL')       label = 'AllData';
    else if (monthVal !== 'ALL') label = `${MONTH_NAMES[parseInt(monthVal)]}_${yearVal}`;
    else                         label = `YTD_${yearVal}`;
    const wb = XLSX.utils.book_new();
    const summaryTable = document.getElementById('resumeTable');
    if (summaryTable) {
        const ws = XLSX.utils.table_to_sheet(summaryTable);
        XLSX.utils.book_append_sheet(wb, ws, 'Summary');
    }
    if (yearVal !== 'ALL' && monthVal === 'ALL') {
        let yearRows = resumeDBData;
        if (currentResumeBA !== 'ALL') yearRows = yearRows.filter(r => String(r.business_area||'').trim() === currentResumeBA);
        yearRows = yearRows.filter(r => String(r.year||'').trim() === yearVal);
        const monthsInData = [...new Set(yearRows.map(r => normalizeMonthNum(r)).filter(Boolean))].sort((a,b)=>a-b);
        monthsInData.forEach(mn => {
            const tbl = document.getElementById(`resumeMonthTable_${mn}`);
            if (tbl) {
                const ws = XLSX.utils.table_to_sheet(tbl);
                XLSX.utils.book_append_sheet(wb, ws, MONTH_NAMES[mn].substring(0,3));
            }
        });
    }
    XLSX.writeFile(wb, `Resume_All_Business_${label}${baSlug}.xlsx`);
}
function exportSalesReport(tableId, filename) {
    const table = document.getElementById(tableId); if(!table) return;
    const wb = XLSX.utils.table_to_book(table, { sheet:'Report' });
    XLSX.writeFile(wb, `${filename}.xlsx`);
}
 
// =========================================================
// MASTER MATERIAL
// =========================================================
function buildMasterMaterialData() {
    if (salesReportDBData.length === 0) return;
    const seen = new Map();
    salesReportDBData.forEach(r => {
        const mid = String(r.material_id || '').trim();
        if (!mid || seen.has(mid)) return;
        const dcRaw  = String(r.dc || '').trim();
        const family = getFamily(dcRaw);
        seen.set(mid, {
            material_id:   mid,
            material_name: r.material || '—',
            family,
            sub1: dcRaw || '—',
            sub2: String(r.division || '').trim() || '—',
        });
    });
    masterMaterialBase = Array.from(seen.values()).sort((a,b) => a.material_id.localeCompare(b.material_id));
}
 
function renderMasterMaterial() {
    const loading = document.getElementById('mmLoading');
    const wrap    = document.getElementById('mmTableWrap');
    const info    = document.getElementById('mmDataInfo');
    masterMaterialBase = [];
    if (salesReportDBData.length === 0) {
        loading.style.display = 'block';
        loading.textContent   = '⏳ Mengambil data dari database...';
        wrap.style.display    = 'none';
        info.style.display    = 'none';
        fetch('/sales/report-data', { headers: { 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(result => {
                if (!result.success) throw new Error(result.message);
                salesReportDBData = result.data;
                buildMasterMaterialData();
                _renderMMTable();
            })
            .catch(err => {
                loading.innerHTML = `<div style="color:#dc2626;font-size:13px;">⚠ Gagal memuat data: ${err.message}</div>`;
            });
        return;
    }
    buildMasterMaterialData();
    _renderMMTable();
}
 
function _renderMMTable() {
    document.getElementById('mmLoading').style.display = 'none';
    document.getElementById('mmTableWrap').style.display = 'block';
    document.getElementById('mmDataInfo').style.display = 'block';
    applyMaterialFilters();
}
 
function applyMaterialFilters() {
    const fId   = (document.getElementById('mm-filter-id')?.value     || '').toLowerCase().trim();
    const fDesc = (document.getElementById('mm-filter-desc')?.value   || '').toLowerCase().trim();
    const fFam  = (document.getElementById('mm-filter-family')?.value || '').toLowerCase().trim();
    const fSub1 = (document.getElementById('mm-filter-sub1')?.value   || '').toLowerCase().trim();
    const fSub2 = (document.getElementById('mm-filter-sub2')?.value   || '').toLowerCase().trim();
 
    const filtered = masterMaterialBase.filter(r =>
        (!fId   || r.material_id.toLowerCase().includes(fId))
     && (!fDesc || r.material_name.toLowerCase().includes(fDesc))
     && (!fFam  || r.family.toLowerCase().includes(fFam))
     && (!fSub1 || r.sub1.toLowerCase().includes(fSub1))
     && (!fSub2 || r.sub2.toLowerCase().includes(fSub2))
    );
 
    const renderFn = (slice) => {
        const tbody = document.getElementById('mmTableBody');
        tbody.innerHTML = slice.length === 0
            ? `<tr><td colspan="6" style="text-align:center;padding:30px;color:var(--muted);">Tidak ada data yang sesuai filter.</td></tr>`
            : slice.map(r => `
                <tr>
                    <td><span style="font-family:monospace;font-size:12px;font-weight:700;color:#475569;">${r.material_id}</span></td>
                    <td style="font-weight:600;color:var(--navy);">${r.material_name}</td>
                    <td><span style="display:inline-flex;align-items:center;gap:4px;font-size:12px;font-weight:700;padding:3px 10px;border-radius:6px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">${r.family}</span></td>
                    <td><span class="sub-badge">${r.sub1}</span></td>
                    <td><span class="sub-badge">${r.sub2}</span></td>
                    <td style="text-align:center;">
                        <button onclick="openEditMaterialModal('${escapeJs(r.material_id)}', '${escapeJs(r.material_name)}')" class="btn" style="padding:4px 10px;font-size:11px;border-radius:6px;border:1px solid #c7d7f4;background:#f0f4ff;color:#1d4ed8;cursor:pointer;font-weight:700;">Edit</button>
                    </td>
                </tr>`).join('');
    };
 
    document.getElementById('mmRowCount').textContent = filtered.length.toLocaleString();
    const cnt = document.getElementById('mm-filter-count');
    if (cnt) cnt.textContent = filtered.length < masterMaterialBase.length
        ? `${filtered.length.toLocaleString()} of ${masterMaterialBase.length.toLocaleString()} material` : '';
 
    if (paginationState['mmTable']) {
        updatePaginationRows('mmTable', filtered);
    } else {
        attachPagination('mmTable', 'mmTableWrap', filtered, renderFn);
        makeTableSortable('mmTable');
    }
}
 
function clearMaterialFilters() {
    ['mm-filter-id','mm-filter-desc','mm-filter-family','mm-filter-sub1','mm-filter-sub2']
        .forEach(id => { const el=document.getElementById(id); if(el) el.value=''; });
    const cnt = document.getElementById('mm-filter-count'); if(cnt) cnt.textContent='';
    applyMaterialFilters();
}
function exportMasterMaterial() {
    const table = document.getElementById('mmTable'); if(!table) return;
    const wb = XLSX.utils.table_to_book(table, { sheet:'Master Material' });
    XLSX.writeFile(wb, 'Master_Material.xlsx');
}
 
// =========================================================
// MASTER SALESMAN
// FIX: makeTableSortable now called inside attachPagination path
// =========================================================
async function renderMasterSalesman() {
    if (masterSalesmanBase.length === 0) {
        document.getElementById('msLoading').style.display   = 'block';
        document.getElementById('msTableWrap').style.display = 'none';
        document.getElementById('msDataInfo').style.display  = 'none';
        try {
            const res  = await fetch('/sales/master-salesman');
            const json = await res.json();
            if (!json.success) throw new Error(json.message);
            masterSalesmanBase = json.data;
            masterSalesmanData = [...masterSalesmanBase];
        } catch(e) {
            document.getElementById('msLoading').textContent = '⚠ Failed to load data.';
            return;
        }
    }
    document.getElementById('msLoading').style.display   = 'none';
    document.getElementById('msTableWrap').style.display = 'block';
    document.getElementById('msDataInfo').style.display  = 'block';
    applyMsFilters();
}
 
function applyMsFilters() { applyMsFilters_internal(masterSalesmanBase); }
window.applySalesmanFilters = applyMsFilters;
 
function applyMsFilters_internal(base) {
    const fId   = (document.getElementById('ms-filter-id')?.value   || '').toLowerCase().trim();
    const fName = (document.getElementById('ms-filter-name')?.value || '').toLowerCase().trim();
 
    const filtered = base.filter(r =>
        (!fId   || (r.salesman_id || '').toLowerCase().includes(fId))
     && (!fName || (r.salesman    || '').toLowerCase().includes(fName))
    );
 
    const renderFn = (slice) => {
        const tbody = document.getElementById('msTableBody');
        if (slice.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:30px;color:var(--muted);">Tidak ada data yang sesuai filter.</td></tr>`;
            document.getElementById('msRowCount').textContent = '0';
            return;
        }
        tbody.innerHTML = slice.map(r => {
            const rev     = r.gross_revenue ?? r.total_gross_revenue ?? 0;
            const gp      = r.gross_gp ?? r.total_gross_gp ?? 0;
            const qty     = r.qty ?? r.total_qty ?? 0;
            const gm      = rev > 0 ? (gp / rev * 100) : 0;
            const gmColor = gm >= 20 ? '#16a34a' : (gm < 0 ? '#dc2626' : '#d97706');
            const fullIdx = filtered.indexOf(r);
            return `<tr>
                <td><strong style="color:#475569;">${r.salesman_id || '—'}</strong></td>
                <td><div style="font-weight:600;color:#1e293b;">${r.salesman || '—'}</div></td>
                <td class="num" style="text-align:right;">${formatNum(qty)}</td>
                <td class="num" style="text-align:right;">${formatNum(rev)}</td>
                <td class="num" style="text-align:right;">${formatNum(gp)}</td>
                <td class="num gm-cell" style="text-align:right;cursor:pointer;"
                    onclick="openSalesmanModal(${fullIdx}, '${escapeJs(r.salesman || '')}', '${escapeJs(r.salesman_id || '')}')"
                    title="Klik untuk melihat detail breakdown">
                    <span style="display:inline-flex;align-items:center;gap:4px;color:${gmColor};font-weight:700;
                                 padding:3px 8px;border-radius:6px;background:${gmColor}18;
                                 border:1px solid ${gmColor}40;transition:all 0.15s;">
                        ${formatDec2(gm)}% 🔍
                    </span>
                </td>
                <td style="text-align:center;">
                    <button onclick="openEditSalesmanModal('${escapeJs(r.salesman_id || '')}', '${escapeJs(r.salesman || '')}')"
                        class="btn" style="padding:4px 10px;font-size:11px;border-radius:6px;border:1px solid #c7d7f4;background:#f0f4ff;color:#1d4ed8;cursor:pointer;font-weight:700;">Edit</button>
                </td>
            </tr>`;
        }).join('');
        document.getElementById('msRowCount').textContent = filtered.length.toLocaleString();
    };
 
    const cnt = document.getElementById('ms-filter-count');
    if (cnt) cnt.textContent = filtered.length < base.length
        ? `${filtered.length.toLocaleString()} of ${base.length.toLocaleString()} salesman` : '';
 
    window._msFilteredRows = filtered;
 
    if (paginationState['msTable']) {
        updatePaginationRows('msTable', filtered);
    } else {
        attachPagination('msTable', 'msTableWrap', filtered, renderFn);
        makeTableSortable('msTable'); // FIX: ensure sort headers wired on first render
    }
}
 
function clearSalesmanFilters() {
    ['ms-filter-id','ms-filter-name'].forEach(id => { const el=document.getElementById(id); if(el) el.value=''; });
    const cnt = document.getElementById('ms-filter-count'); if(cnt) cnt.textContent='';
    applyMsFilters();
}
function exportMasterSalesman() {
    const table = document.getElementById('msTable'); if(!table) return;
    const wb = XLSX.utils.table_to_book(table, { sheet:'Master Salesman' });
    XLSX.writeFile(wb, 'Master_Salesman.xlsx');
}
 
// =========================================================
// SALESMAN DETAIL MODAL — with search bar
// =========================================================
var _modalAllDetailRows = [];
 
function ensureModalSearchBar() {
    if (document.getElementById('modal-search-bar')) return;
    const breakdownSection = document.querySelector('#salesmanDetailModal [style*="overflow-y:auto"]');
    if (!breakdownSection) return;
 
    const bar = document.createElement('div');
    bar.id = 'modal-search-bar';
    bar.style.cssText = `display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:12px;padding:10px 12px;background:#f8fafc;border:1px solid var(--border);border-radius:8px;`;
    bar.innerHTML = `
        <div style="display:flex;flex-direction:column;gap:3px;">
            <label style="font-size:10px;font-weight:700;color:#94a3b8;letter-spacing:0.8px;text-transform:uppercase;">Customer</label>
            <input id="modal-search-customer" type="text" placeholder="Search customer…"
                oninput="filterModalDetail()"
                style="border:1px solid var(--border);border-radius:6px;padding:6px 10px;font-size:12px;color:var(--navy);outline:none;min-width:180px;background:white;transition:border-color 0.15s;">
        </div>
        <div style="display:flex;flex-direction:column;gap:3px;">
            <label style="font-size:10px;font-weight:700;color:#94a3b8;letter-spacing:0.8px;text-transform:uppercase;">Material</label>
            <input id="modal-search-material" type="text" placeholder="Search material…"
                oninput="filterModalDetail()"
                style="border:1px solid var(--border);border-radius:6px;padding:6px 10px;font-size:12px;color:var(--navy);outline:none;min-width:180px;background:white;transition:border-color 0.15s;">
        </div>
        <button onclick="clearModalSearch()"
            style="align-self:flex-end;padding:6px 12px;border:1px solid var(--border);border-radius:6px;background:white;font-size:11px;font-weight:600;color:#64748b;cursor:pointer;transition:all 0.15s;">✕ Clear</button>
        <span id="modal-search-count" style="font-size:11px;color:var(--muted);align-self:flex-end;"></span>`;
 
    const label = breakdownSection.querySelector('[style*="text-transform:uppercase"]');
    if (label) breakdownSection.insertBefore(bar, label);
    else breakdownSection.prepend(bar);
 
    ['modal-search-customer','modal-search-material'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('focus', () => el.style.borderColor = '#4f6ef7');
        el.addEventListener('blur',  () => el.style.borderColor = 'var(--border)');
    });
}
 
function filterModalDetail() {
    const fCust = (document.getElementById('modal-search-customer')?.value || '').toLowerCase().trim();
    const fMat  = (document.getElementById('modal-search-material')?.value  || '').toLowerCase().trim();
    const filtered = _modalAllDetailRows.filter(r =>
        (!fCust || (r.customer || '').toLowerCase().includes(fCust))
     && (!fMat  || (r.material || '').toLowerCase().includes(fMat))
    );
    renderModalDetailRows(filtered);
    const cnt = document.getElementById('modal-search-count');
    if (cnt) cnt.textContent = (fCust || fMat) && filtered.length < _modalAllDetailRows.length
        ? `${filtered.length} of ${_modalAllDetailRows.length} rows` : '';
}
 
function clearModalSearch() {
    const c = document.getElementById('modal-search-customer');
    const m = document.getElementById('modal-search-material');
    if (c) c.value = '';
    if (m) m.value = '';
    const cnt = document.getElementById('modal-search-count');
    if (cnt) cnt.textContent = '';
    renderModalDetailRows(_modalAllDetailRows);
}
 
function renderModalDetailRows(rows) {
    const tbody = document.getElementById('modalDetailBody');
    if (!tbody) return;
    if (rows.length === 0) {
        tbody.innerHTML = `<tr><td colspan="8" style="text-align:center;padding:20px;color:var(--muted);">Tidak ada data yang sesuai.</td></tr>`;
        return;
    }
    tbody.innerHTML = rows.map(r => {
        const rowGM    = r.gross_revenue > 0 ? (r.gross_gp / r.gross_revenue * 100) : 0;
        const rowColor = rowGM >= 20 ? '#16a34a' : '#dc2626';
        return `<tr style="border-bottom:1px solid #f1f5f9;">
            <td style="padding:7px 10px;color:#374151;font-weight:600;">${r.customer}</td>
            <td style="padding:7px 10px;color:#374151;font-size:11px;">${r.material}</td>
            <td style="padding:7px 10px;text-align:right;color:var(--navy);font-weight:600;">${formatNum(r.qty)}</td>
            <td style="padding:7px 10px;text-align:right;color:var(--navy);">${formatNum(r.gross_revenue)}</td>
            <td style="padding:7px 10px;text-align:right;color:var(--navy);">${formatNum(r.net_revenue)}</td>
            <td style="padding:7px 10px;text-align:right;color:var(--navy);">${formatNum(r.cogs)}</td>
            <td style="padding:7px 10px;text-align:right;color:var(--navy);font-weight:600;">${formatNum(r.gross_gp)}</td>
            <td style="padding:7px 10px;text-align:right;font-weight:700;color:${rowColor};">${formatDec2(rowGM)}%</td>
        </tr>`;
    }).join('');
}
 
function openSalesmanModal(idx, salesmanName, salesmanId) {
    const rows = window._msFilteredRows || masterSalesmanBase;
    const agg  = rows[idx];
    if (!agg) return;
 
    document.getElementById('modalSalesmanName').textContent = salesmanName;
    document.getElementById('modalSalesmanMeta').textContent = `ID: ${salesmanId}`;
 
    const rev = agg.gross_revenue ?? agg.total_gross_revenue ?? 0;
    const gp  = agg.gross_gp ?? agg.total_gross_gp ?? 0;
    const qty = agg.qty ?? agg.total_qty ?? 0;
    const gm  = rev > 0 ? (gp / rev * 100) : 0;
    const gmColor = gm >= 20 ? '#16a34a' : '#dc2626';
 
    document.getElementById('modalKpiQty').textContent = formatNum(qty);
    document.getElementById('modalKpiRev').textContent = formatNum(rev);
    document.getElementById('modalKpiGP').textContent  = formatNum(gp);
    document.getElementById('modalKpiGM').textContent  = formatDec2(gm) + '%';
    document.getElementById('modalKpiGM').style.color  = gmColor;
 
    const detailRows = (agg.rows || []).slice().sort((a, b) => {
        const ca = (a.customer || '').localeCompare(b.customer || '');
        return ca !== 0 ? ca : (a.material || '').localeCompare(b.material || '');
    });
    const detailMap = {};
    detailRows.forEach(r => {
        const key = `${r.customer || ''}||${r.material || ''}`;
        if (!detailMap[key]) detailMap[key] = {
            customer: r.customer || '—', material: r.material || '—',
            qty: 0, gross_revenue: 0, net_revenue: 0, cogs: 0, gross_gp: 0
        };
        detailMap[key].qty           += r.qty || 0;
        detailMap[key].gross_revenue += r.gross_revenue || 0;
        detailMap[key].net_revenue   += r.net_revenue || 0;
        detailMap[key].cogs          += r.cogs || 0;
        detailMap[key].gross_gp      += r.gross_gp || 0;
    });
 
    _modalAllDetailRows = Object.values(detailMap);
 
    ensureModalSearchBar();
 
    const c = document.getElementById('modal-search-customer');
    const m = document.getElementById('modal-search-material');
    if (c) c.value = '';
    if (m) m.value = '';
    const cnt = document.getElementById('modal-search-count');
    if (cnt) cnt.textContent = '';
 
    renderModalDetailRows(_modalAllDetailRows);
 
    document.getElementById('salesmanDetailModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
 
function closeSalesmanModal() {
    const detailModal = document.getElementById('salesmanDetailModal');
    if (detailModal) detailModal.style.display = 'none';
    const addEditModal = document.getElementById('salesmanModal');
    if (addEditModal) addEditModal.style.display = 'none';
    document.body.style.overflow = '';
}
 
document.getElementById('salesmanDetailModal').addEventListener('click', function(e) {
    if (e.target === this) closeSalesmanModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeSalesmanModal();
});
 
// =========================================================
// ADD / EDIT MATERIAL MODAL
// =========================================================
var editingMaterialId = null;
 
function openAddMaterialModal() {
    editingMaterialId = null;
    document.getElementById('materialModalTitle').textContent = 'Add Material';
    document.getElementById('matIdInput').value   = '';
    document.getElementById('matDescInput').value = '';
    document.getElementById('matIdInput').disabled = false;
    document.getElementById('materialModalError').style.display = 'none';
    document.getElementById('materialModal').style.display = 'flex';
}
function openEditMaterialModal(id, desc) {
    editingMaterialId = id;
    document.getElementById('materialModalTitle').textContent = 'Edit Material';
    document.getElementById('matIdInput').value   = id;
    document.getElementById('matDescInput').value = desc;
    document.getElementById('matIdInput').disabled = true;
    document.getElementById('materialModalError').style.display = 'none';
    document.getElementById('materialModal').style.display = 'flex';
}
function closeMaterialModal() {
    document.getElementById('materialModal').style.display = 'none';
}
async function saveMaterial() {
    const id   = document.getElementById('matIdInput').value.trim();
    const desc = document.getElementById('matDescInput').value.trim();
    const errEl = document.getElementById('materialModalError');
    const btn   = document.getElementById('saveMaterialBtn');
    if (!id || !desc) { errEl.textContent = 'Material ID and Description are required.'; errEl.style.display = 'block'; return; }
    btn.disabled = true; btn.textContent = 'Saving…';
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    try {
        let url, method;
        if (editingMaterialId) { url = `/master/material/${encodeURIComponent(editingMaterialId)}`; method = 'PUT'; }
        else { url = '/master/material/store'; method = 'POST'; }
        const res = await fetch(url, {
            method, headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify({ material_id: id, material: desc }),
        });
        const json = await res.json();
        if (!json.success) { errEl.textContent = json.message || 'Error saving.'; errEl.style.display = 'block'; return; }
        if (editingMaterialId) {
            const idx = masterMaterialBase.findIndex(m => m.material_id === id);
            if (idx > -1) masterMaterialBase[idx].material_name = desc;
        } else {
            masterMaterialBase.push({ material_id: id, material_name: desc, family: '—', sub1: '—', sub2: '—' });
        }
        closeMaterialModal();
        applyMaterialFilters();
    } catch(e) {
        errEl.textContent = 'Network error.'; errEl.style.display = 'block';
    } finally {
        btn.disabled = false; btn.textContent = 'Save Material';
    }
}
 
// =========================================================
// ADD / EDIT SALESMAN MODAL
// =========================================================
var editingSalesmanId = null;
 
function openAddSalesmanModal() {
    editingSalesmanId = null;
    document.getElementById('salesmanModalTitle').textContent = 'Add Salesman';
    document.getElementById('smIdInput').value   = '';
    document.getElementById('smNameInput').value = '';
    document.getElementById('smIdInput').disabled = false;
    document.getElementById('salesmanModalError').style.display = 'none';
    document.getElementById('salesmanModal').style.display = 'flex';
}
function openEditSalesmanModal(id, name) {
    editingSalesmanId = id;
    document.getElementById('salesmanModalTitle').textContent = 'Edit Salesman';
    document.getElementById('smIdInput').value   = id;
    document.getElementById('smNameInput').value = name;
    document.getElementById('smIdInput').disabled = true;
    document.getElementById('salesmanModalError').style.display = 'none';
    document.getElementById('salesmanModal').style.display = 'flex';
}
async function saveSalesman() {
    const id   = document.getElementById('smIdInput').value.trim();
    const name = document.getElementById('smNameInput').value.trim();
    const errEl = document.getElementById('salesmanModalError');
    const btn   = document.getElementById('saveSalesmanBtn');
    if (!id || !name) { errEl.textContent = 'Salesman ID and Name are required.'; errEl.style.display = 'block'; return; }
    btn.disabled = true; btn.textContent = 'Saving…';
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    try {
        let url, method;
        if (editingSalesmanId) { url = `/master/salesman/${encodeURIComponent(editingSalesmanId)}`; method = 'PUT'; }
        else { url = '/master/salesman/store'; method = 'POST'; }
        const res = await fetch(url, {
            method, headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify({ salesman_id: id, salesman: name }),
        });
        const json = await res.json();
        if (!json.success) { errEl.textContent = json.message || 'Error saving.'; errEl.style.display = 'block'; return; }
        if (editingSalesmanId) {
            masterSalesmanBase.forEach(s => { if (s.salesman_id === id) s.salesman = name; });
        } else {
            masterSalesmanBase.push({ salesman_id: id, salesman: name, qty: 0, gross_revenue: 0, net_revenue: 0, cogs: 0, logistic_expense: 0, gross_gp: 0, rows: [] });
        }
        closeSalesmanModal();
        applyMsFilters();
    } catch(e) {
        errEl.textContent = 'Network error.'; errEl.style.display = 'block';
    } finally {
        btn.disabled = false; btn.textContent = 'Save Salesman';
    }
}
 
document.getElementById('logoutBtn').addEventListener('click', () => window.location.href = '/login');
</script>
@endpush
@extends('layouts.app')

@section('content')

    <div id="app-wrapper">
        
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

            {{-- 7 Children --}}
            <div id="sales-report-submenu" style="overflow:hidden;max-height:0;transition:max-height 0.3s ease;">
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
                        <select id="resumeYearFilter" style="padding:7px 12px;border:1px solid var(--border);border-radius:7px;font-size:13px;font-weight:600;color:var(--navy);background:white;cursor:pointer;">
                            <option value="ALL">All Years</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                        </select>
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

                    {{-- Search & Filter Bar --}}
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

            {{-- ===== DC 02 ===== --}}
            <div id="sr-dc02-content" class="content-view">
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="section-title">Paper DC 02</h2>
                            <p class="section-sub">Sales report filtered for DC 2 only.</p>
                        </div>
                        <button onclick="exportSalesReport('dc02Table','Paper_DC02')" class="btn btn-primary">Export to Excel</button>
                    </div>
                    @include('partials._sr_filter_bar', ['prefix' => 'dc02', 'label' => 'DC 2'])
                    <div id="dc02Loading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading...</div>
                    <div class="table-container" id="dc02TableWrap" style="display:none;">
                        <table id="dc02Table" class="data-table">
                            <thead><tr>
                                <th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th>
                                <th class="num" style="text-align:right;">Sum of Qty</th>
                                <th class="num" style="text-align:right;">Sum of Gross Revenue</th>
                                <th class="num" style="text-align:right;">Sum of Gross GP</th>
                            </tr></thead>
                            <tbody id="dc02Body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===== DC 12 ===== --}}
            <div id="sr-dc12-content" class="content-view">
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="section-title">Oil Field DC 12</h2>
                            <p class="section-sub">Sales report filtered for DC 12 only.</p>
                        </div>
                        <button onclick="exportSalesReport('dc12Table','OilField_DC12')" class="btn btn-primary">Export to Excel</button>
                    </div>
                    @include('partials._sr_filter_bar', ['prefix' => 'dc12', 'label' => 'DC 12'])
                    <div id="dc12Loading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading...</div>
                    <div class="table-container" id="dc12TableWrap" style="display:none;">
                        <table id="dc12Table" class="data-table">
                            <thead><tr>
                                <th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th>
                                <th class="num" style="text-align:right;">Sum of Qty</th>
                                <th class="num" style="text-align:right;">Sum of Gross Revenue</th>
                                <th class="num" style="text-align:right;">Sum of Gross GP</th>
                            </tr></thead>
                            <tbody id="dc12Body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===== DC 04 ===== --}}
            <div id="sr-dc04-content" class="content-view">
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="section-title">Plastic Rubber &amp; RA DC 04</h2>
                            <p class="section-sub">Sales report filtered for DC 4 only.</p>
                        </div>
                        <button onclick="exportSalesReport('dc04Table','PlasticRubber_DC04')" class="btn btn-primary">Export to Excel</button>
                    </div>
                    @include('partials._sr_filter_bar', ['prefix' => 'dc04', 'label' => 'DC 4'])
                    <div id="dc04Loading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading...</div>
                    <div class="table-container" id="dc04TableWrap" style="display:none;">
                        <table id="dc04Table" class="data-table">
                            <thead><tr>
                                <th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th>
                                <th class="num" style="text-align:right;">Sum of Qty</th>
                                <th class="num" style="text-align:right;">Sum of Gross Revenue</th>
                                <th class="num" style="text-align:right;">Sum of Gross GP</th>
                            </tr></thead>
                            <tbody id="dc04Body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===== DC 06 ===== --}}
            <div id="sr-dc06-content" class="content-view">
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="section-title">Textile DC 06</h2>
                            <p class="section-sub">Sales report filtered for DC 6 only.</p>
                        </div>
                        <button onclick="exportSalesReport('dc06Table','Textile_DC06')" class="btn btn-primary">Export to Excel</button>
                    </div>
                    @include('partials._sr_filter_bar', ['prefix' => 'dc06', 'label' => 'DC 6'])
                    <div id="dc06Loading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading...</div>
                    <div class="table-container" id="dc06TableWrap" style="display:none;">
                        <table id="dc06Table" class="data-table">
                            <thead><tr>
                                <th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th>
                                <th class="num" style="text-align:right;">Sum of Qty</th>
                                <th class="num" style="text-align:right;">Sum of Gross Revenue</th>
                                <th class="num" style="text-align:right;">Sum of Gross GP</th>
                            </tr></thead>
                            <tbody id="dc06Body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===== DC 08 ===== --}}
            <div id="sr-dc08-content" class="content-view">
                <div class="card">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="section-title">PHC DC 08</h2>
                            <p class="section-sub">Sales report filtered for DC 8 only.</p>
                        </div>
                        <button onclick="exportSalesReport('dc08Table','PHC_DC08')" class="btn btn-primary">Export to Excel</button>
                    </div>
                    @include('partials._sr_filter_bar', ['prefix' => 'dc08', 'label' => 'DC 8'])
                    <div id="dc08Loading" style="text-align:center;padding:40px;color:var(--muted);font-size:13px;">⏳ Loading...</div>
                    <div class="table-container" id="dc08TableWrap" style="display:none;">
                        <table id="dc08Table" class="data-table">
                            <thead><tr>
                                <th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th>
                                <th class="num" style="text-align:right;">Sum of Qty</th>
                                <th class="num" style="text-align:right;">Sum of Gross Revenue</th>
                                <th class="num" style="text-align:right;">Sum of Gross GP</th>
                            </tr></thead>
                            <tbody id="dc08Body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>{{-- end #main --}}
    </div>{{-- end #app-wrapper --}}

    {{-- ===== EXTRA STYLES ===== --}}
    <style>
        /* Sub-nav items in sidebar */
        .nav-sub-item {
            display: flex;
            align-items: center;
            padding: 7px 16px 7px 36px;
            font-size: 12px;
            font-weight: 400;
            color: rgba(255,255,255,0.45);
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
            border-left: 2px solid transparent;
        }
        .nav-sub-item:hover {
            background: rgba(255,255,255,0.05);
            color: rgba(255,255,255,0.8);
        }
        .nav-sub-item.active {
            color: #7c9fff;
            font-weight: 600;
            background: rgba(124,159,255,0.08);
            border-left-color: #4f6ef7;
        }
        .nav-sub-item.active span { opacity: 1 !important; color: #4f6ef7; }

        /* Search / filter bar */
        .sr-filter-bar {
            display: flex;
            align-items: flex-end;
            gap: 12px;
            flex-wrap: wrap;
            padding: 12px 16px;
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 10px;
            margin-bottom: 16px;
        }
        .sr-filter-group { display: flex; flex-direction: column; gap: 4px; }
        .sr-filter-label {
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }
        .sr-filter-input {
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 7px 10px;
            font-size: 12px;
            color: var(--navy);
            outline: none;
            min-width: 150px;
            transition: border-color 0.15s, box-shadow 0.15s;
            background: white;
        }
        .sr-filter-input:focus {
            border-color: #4f6ef7;
            box-shadow: 0 0 0 3px rgba(79,110,247,0.1);
        }
        .sr-filter-input::placeholder { color: #cbd5e1; }
        .sr-filter-select {
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 7px 10px;
            font-size: 12px;
            color: var(--navy);
            outline: none;
            min-width: 130px;
            background: white;
            cursor: pointer;
            transition: border-color 0.15s;
        }
        .sr-filter-select:focus { border-color: #4f6ef7; box-shadow: 0 0 0 3px rgba(79,110,247,0.1); }
        .sr-clear-btn {
            padding: 7px 14px;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: white;
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all 0.15s;
            align-self: flex-end;
        }
        .sr-clear-btn:hover { border-color: #4f6ef7; color: #4f6ef7; background: #f0f4ff; }
    </style>
@endsection

@push('scripts')
<script>
    // =========================================================
    // GLOBALS
    // =========================================================
    const VALID_DCS = ['DC 2', 'DC 12', 'DC 4', 'DC 6', 'DC 8'];
    var originalDashboardData = [];
    var salesReportDBData     = [];   // all rows from DB
    var currentBAFilter       = 'ALL';
    var resumeDBData          = [];

    // Stores the fully-grouped (pre-filter) rows per view so we can re-filter quickly
    var groupedSRRows  = [];   // Sales Report summary rows
    var groupedDCRows  = {};   // keyed by dc value e.g. "DC 2"

    // =========================================================
    // HELPERS
    // =========================================================
    function cleanKey(key) { return key.replace(/\u00a0/g, '').trim(); }

    function parseIntSafe(val) {
        if (val === undefined || val === null || val === '') return null;
        const n = parseInt(String(val).replace(/[,%\s]/g, ''), 10);
        return isNaN(n) ? null : n;
    }
    function parseYearSafe(val) {
        if (val === undefined || val === null || val === '') return null;
        const m = String(val).match(/\d{4}/);
        return m ? parseInt(m[0], 10) : null;
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
        return {
            business_area:    getExcelValue(row, 'Business area'),
            dc:               getExcelValue(row, 'DC'),
            division:         getExcelValue(row, 'Division'),
            sales_doc_type:   getExcelValue(row, 'Sales doc. type'),
            month_num:        parseIntSafe(getExcelValue(row, '02. Month')),
            month:            getExcelValue(row, 'Month'),
            year:             parseYearSafe(getExcelValue(row, 'Year')),
            salesman_id:      getExcelValue(row, 'Salesman ID'),
            salesman:         getExcelValue(row, 'Salesman'),
            customer_id:      getExcelValue(row, 'Customer ID'),
            customer:         getExcelValue(row, 'Customer'),
            material_id:      getExcelValue(row, 'Material ID'),
            material:         getExcelValue(row, 'Material'),
            qty:              parseIntSafe(getExcelValue(row, 'Qty')),
            gross_revenue:    parseFloatSafe(getExcelValue(row, 'Gross Revenue')),
            logistic_expense: parseFloatSafe(getExcelValue(row, 'Logistic Expense')),
            net_revenue:      parseFloatSafe(getExcelValue(row, 'Net Revenue')),
            cogs:             parseFloatSafe(getExcelValue(row, 'COGS')),
            gross_gp:         parseFloatSafe(getExcelValue(row, 'Gross GP')),
            gross_gm_percent: clampGM(getExcelValue(row, 'Gross GM%')),
        };
    }

    const formatNum = n => Math.round(n).toLocaleString('id-ID');

    // =========================================================
    // NAVIGATION — main items
    // =========================================================
    function activateNavItem(el) {
        // Deactivate all nav + sub items
        document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.nav-sub-item').forEach(b => b.classList.remove('active'));

        el.classList.add('active');

        const targetId = el.dataset.target;
        document.querySelectorAll('.content-view').forEach(v => v.classList.remove('active'));
        document.getElementById(targetId)?.classList.add('active');

        const titles = {
            'dashboard-content':   'Data Preparation Dashboard',
            'sales-report-content':'Sales Report Summary',
            'resume-all-content':  'Resume All Business',
            'sr-dc02-content':     'Paper DC 02',
            'sr-dc12-content':     'Oil Field DC 12',
            'sr-dc04-content':     'Plastic Rubber & RA DC 04',
            'sr-dc06-content':     'Textile DC 06',
            'sr-dc08-content':     'PHC DC 08',
        };
        document.getElementById('topbar-title').innerText = titles[targetId] || '';

        // Business area dropdown — only show when inside sales-report sub-views
        const salesViews = ['sales-report-content','sr-dc02-content','sr-dc12-content','sr-dc04-content','sr-dc06-content','sr-dc08-content'];
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

        // Close sales submenu if navigating away from sales
        if (!salesViews.includes(targetId)) {
            closeSalesMenu();
        }
    }

    // =========================================================
    // NAVIGATION — Sales Report parent + sub items
    // =========================================================
    var salesMenuOpen = false;

    function toggleSalesReportMenu(el) {
        salesMenuOpen = !salesMenuOpen;
        const submenu  = document.getElementById('sales-report-submenu');
        const chevron  = document.getElementById('sales-chevron');
        submenu.style.maxHeight = salesMenuOpen ? '300px' : '0';
        chevron.style.transform = salesMenuOpen ? 'rotate(180deg)' : 'rotate(0deg)';

        // Mark parent as active
        document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));
        el.classList.add('active');

        // If opening for first time, auto-activate first child (Raw)
        if (salesMenuOpen) {
            const firstChild = document.querySelector('.nav-sub-item');
            if (firstChild && !document.querySelector('.nav-sub-item.active')) {
                activateSalesSubItem(firstChild);
            }
        }
    }

    function closeSalesMenu() {
        salesMenuOpen = false;
        document.getElementById('sales-report-submenu').style.maxHeight = '0';
        document.getElementById('sales-chevron').style.transform = 'rotate(0deg)';
    }

    function activateSalesSubItem(el) {
        // Highlight parent nav item
        document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));
        document.getElementById('nav-sales-report-parent').classList.add('active');

        // Highlight sub item
        document.querySelectorAll('.nav-sub-item').forEach(b => b.classList.remove('active'));
        el.classList.add('active');

        const targetId = el.dataset.target;
        document.querySelectorAll('.content-view').forEach(v => v.classList.remove('active'));
        document.getElementById(targetId)?.classList.add('active');

        const titles = {
            'sales-report-content': 'Sales Report Summary',
            'sr-dc02-content':      'Paper DC 02',
            'sr-dc12-content':      'Oil Field DC 12',
            'sr-dc04-content':      'Plastic Rubber & RA DC 04',
            'sr-dc06-content':      'Textile DC 06',
            'sr-dc08-content':      'PHC DC 08',
        };
        document.getElementById('topbar-title').innerText = titles[targetId] || 'Sales Report';

        // Show business area filter for all sales sub-views
        document.getElementById('businessAreaFilter').style.display = 'block';

        if (salesReportDBData.length === 0) {
            fetchSalesReportFromDB();
        } else {
            // Trigger render for the specific view
            renderViewForTarget(targetId);
        }
    }

    function renderViewForTarget(targetId) {
        if (targetId === 'sales-report-content') renderSalesReportFromDB();
        else if (targetId === 'sr-dc02-content') renderDCView('DC 2',  'dc02');
        else if (targetId === 'sr-dc12-content') renderDCView('DC 12', 'dc12');
        else if (targetId === 'sr-dc04-content') renderDCView('DC 4',  'dc04');
        else if (targetId === 'sr-dc06-content') renderDCView('DC 6',  'dc06');
        else if (targetId === 'sr-dc08-content') renderDCView('DC 8',  'dc08');
    }

    // =========================================================
    // BUSINESS AREA DROPDOWN
    // =========================================================
    function toggleBADropdown() {
        const menu = document.getElementById('baDropdownMenu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
    function closeBADropdown() {
        document.getElementById('baDropdownMenu').style.display = 'none';
    }
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

        // Re-build grouped data with new BA filter, then re-render active view
        buildGroupedData();
        const activeView = document.querySelector('.content-view.active');
        if (activeView) renderViewForTarget(activeView.id);
    }

    // =========================================================
    // FETCH DATA FROM DB (single endpoint used by all sub-views)
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

            // Render whichever sub-view is currently active
            const activeView = document.querySelector('.content-view.active');
            if (activeView) renderViewForTarget(activeView.id);

        } catch (err) {
            const msg = `<div style="color:#dc2626;font-size:13px;">⚠ Gagal memuat data: ${err.message}</div>`;
            ['salesReportLoading','dc02Loading','dc12Loading','dc04Loading','dc06Loading','dc08Loading']
                .forEach(id => { const el = document.getElementById(id); if(el) el.innerHTML = msg; });
            console.error(err);
        }
    }

    function showAllLoadings() {
        ['salesReportLoading','dc02Loading','dc12Loading','dc04Loading','dc06Loading','dc08Loading']
            .forEach(id => { const el = document.getElementById(id); if(el) el.style.display = 'block'; });
        ['salesReportTableWrap','dc02TableWrap','dc12TableWrap','dc04TableWrap','dc06TableWrap','dc08TableWrap']
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
    // BUILD GROUPED DATA (runs after fetch or BA filter change)
    // =========================================================
    function buildGroupedData() {
        let filtered = salesReportDBData;
        if (currentBAFilter !== 'ALL') {
            filtered = filtered.filter(r => String(r.business_area || '').trim() === currentBAFilter.trim());
        }

        // Group all into summary rows
        const map = {};
        filtered.forEach(row => {
            const dcRaw   = String(row.dc || '').trim();
            const family  = getFamily(dcRaw);
            const customer = row.customer || 'Unknown';
            const material = row.material || 'Unknown';
            const key = `${family}|${customer}|${material}|${dcRaw}`;
            if (!map[key]) map[key] = { family, customer, material, dc: dcRaw, qty:0, rev:0, gp:0 };
            map[key].qty += parseFloat(row.qty) || 0;
            map[key].rev += parseFloat(row.gross_revenue) || 0;
            map[key].gp  += parseFloat(row.gross_gp) || 0;
        });
        groupedSRRows = Object.values(map);

        // Per-DC grouped data
        const allDCs = ['DC 2','DC 12','DC 4','DC 6','DC 8'];
        groupedDCRows = {};
        allDCs.forEach(dc => {
            groupedDCRows[dc] = groupedSRRows.filter(r => r.dc === dc);
        });
    }

    // =========================================================
    // RENDER — SALES REPORT SUMMARY
    // =========================================================
    function renderSalesReportFromDB() {
        const sub = currentBAFilter === 'ALL'
            ? 'Automatically grouped by Product Family, Customer, and Material.'
            : `Filtered by Business Area: <strong>${currentBAFilter}</strong>`;
        document.getElementById('salesReportSub').innerHTML = sub;

        renderSRTable(groupedSRRows, 'salesReportBody');
        document.getElementById('salesReportLoading').style.display = 'none';
        document.getElementById('salesReportTableWrap').style.display = 'block';
        makeTableSortable('pivotReportTable');
        applyAllSRFilters(); // respect any existing filter inputs
    }

    function renderSRTable(rows, tbodyId) {
        const tbody = document.getElementById(tbodyId);
        if (!tbody) return;
        if (rows.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:30px;color:var(--muted);">Tidak ada data.</td></tr>`;
            return;
        }
        tbody.innerHTML = rows.map(item => `
            <tr>
                <td><span style="font-weight:700;color:var(--navy);">${item.family}</span></td>
                <td>${item.customer}</td>
                <td><span style="background:#f1f5f9;padding:4px 8px;border-radius:4px;font-size:11px;color:var(--muted);border:1px solid var(--border);">${item.material}</span></td>
                <td>${item.dc}</td>
                <td class="num" style="text-align:right;">${formatNum(item.qty)}</td>
                <td class="num" style="text-align:right;">${formatNum(item.rev)}</td>
                <td class="num" style="text-align:right;">${formatNum(item.gp)}</td>
            </tr>
        `).join('');
    }

    // =========================================================
    // SEARCH & FILTER — SALES REPORT (4 columns)
    // =========================================================
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
            (!f.family   || r.family.toLowerCase().includes(f.family)) &&
            (!f.customer || r.customer.toLowerCase().includes(f.customer)) &&
            (!f.material || r.material.toLowerCase().includes(f.material)) &&
            (!f.dc       || r.dc === f.dc)
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
        const baseRows = groupedDCRows[dcValue] || [];
        const filtered = filterRows(baseRows, f);
        renderSRTable(filtered, `${prefix}Body`);
    }

    function clearSRFilters(prefix) {
        ['family','customer','material'].forEach(field => {
            const el = document.getElementById(`${prefix}-filter-${field}`);
            if (el) el.value = '';
        });
        const dcEl = document.getElementById(`${prefix}-filter-dc`);
        if (dcEl) dcEl.value = '';

        const cnt = document.getElementById(`${prefix}-filter-count`);
        if (cnt) cnt.textContent = '';

        if (prefix === 'sr')   applyAllSRFilters();
        else {
            const dcMap = { dc02:'DC 2', dc12:'DC 12', dc04:'DC 4', dc06:'DC 6', dc08:'DC 8' };
            if (dcMap[prefix]) applyDCFilter(prefix, dcMap[prefix]);
        }
    }


    // =========================================================
    // RENDER — DC FILTERED VIEWS
    // =========================================================
    function renderDCView(dcValue, prefix) {
        const rows = groupedDCRows[dcValue] || [];
        renderSRTable(rows, `${prefix}Body`);

        document.getElementById(`${prefix}Loading`).style.display = 'none';
        document.getElementById(`${prefix}TableWrap`).style.display = 'block';
        makeTableSortable(`${prefix}Table`);

        // Wire up inline filter inputs for this DC view
        ['family','customer','material','dc'].forEach(field => {
            const el = document.getElementById(`${prefix}-filter-${field}`);
            if (el && !el.dataset.wired) {
                el.dataset.wired = '1';
                const evt = el.tagName === 'SELECT' ? 'change' : 'input';
                el.addEventListener(evt, () => applyDCFilter(prefix, dcValue));
            }
        });
    }

    // =========================================================
    // FILE UPLOAD — Data Prep
    // =========================================================
    document.getElementById('fileUpload').addEventListener('change', handleFile, false);

    function handleFile(e) {
        const files = e.target.files;
        if (files.length === 0) return;
        document.getElementById('loadingModal').style.display = 'flex';
        setTimeout(() => {
            try {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, { type: 'array', cellDates: true });
                    const firstSheetName = workbook.SheetNames[0];
                    const rawDataJson = XLSX.utils.sheet_to_json(workbook.Sheets[firstSheetName], { raw: false, defval: '' });
                    originalDashboardData = rawDataJson;
                    initializeDashboard(rawDataJson);
                    document.getElementById('exportBtn').disabled = false;
                    document.getElementById('loadingModal').style.display = 'none';
                };
                reader.readAsArrayBuffer(files[0]);
            } catch (err) {
                console.error(err);
                alert("Error processing the Excel file.");
                document.getElementById('loadingModal').style.display = 'none';
            }
        }, 100);
    }

    function initializeDashboard(data) {
        const tableHead = document.getElementById('tableHead');
        tableHead.innerHTML = '';
        if (!data || data.length === 0) return;
        const rawHeaders   = Object.keys(data[0]);
        const cleanHeaders = rawHeaders.map(cleanKey);
        const headerRow = document.createElement('tr');
        cleanHeaders.forEach(h => { const th = document.createElement('th'); th.textContent = h; headerRow.appendChild(th); });
        tableHead.appendChild(headerRow);
        renderDashboardBody(data, rawHeaders, cleanHeaders);
        populateDcTaskbar(data, rawHeaders, cleanHeaders);
        document.getElementById('dataInfo').style.display = 'block';
        updateRowCount(data.length);
        makeTableSortable('reportTable');
    }

    function renderDashboardBody(data, rawHeaders, cleanHeaders) {
        const tbody = document.getElementById('tableBody');
        tbody.innerHTML = '';
        data.forEach(row => {
            const tr = document.createElement('tr');
            rawHeaders.forEach((rawHeader, i) => {
                const td = document.createElement('td');
                td.textContent = row[rawHeader] !== undefined ? row[rawHeader] : '';
                const h = cleanHeaders[i].toLowerCase();
                if (h.includes('qty') || h.includes('rev') || h.includes('gp') || h.includes('gm') || h.includes('logistic') || h.includes('cogs') || h.includes('expense'))
                    td.classList.add('num');
                tr.appendChild(td);
            });
            tbody.appendChild(tr);
        });
    }

    function updateRowCount(count, filterLabel) {
        document.getElementById('rowCount').textContent = count.toLocaleString();
        const fi = document.getElementById('filterInfo');
        fi.textContent = filterLabel ? ` · filtered by ${filterLabel}` : '';
    }

    function populateDcTaskbar(data, rawHeaders, cleanHeaders) {
        const taskbar = document.getElementById('dcTaskbar');
        taskbar.innerHTML = '';
        const allBtn = document.createElement('div');
        allBtn.classList.add('dc-btn', 'active');
        allBtn.id = 'dc-all';
        allBtn.textContent = 'All DCs';
        allBtn.onclick = () => filterByDCDashboard('ALL', rawHeaders, cleanHeaders);
        taskbar.appendChild(allBtn);
        VALID_DCS.forEach(dcValue => {
            const dcBtn = document.createElement('div');
            dcBtn.classList.add('dc-btn');
            dcBtn.id = `dc-${dcValue.replace(/\s+/g, '-')}`;
            dcBtn.textContent = dcValue;
            dcBtn.onclick = () => filterByDCDashboard(dcValue, rawHeaders, cleanHeaders);
            taskbar.appendChild(dcBtn);
        });
    }

    function getDcColumn(rawHeaders) {
        return rawHeaders.find(h => cleanKey(h) === 'DC') || null;
    }

    function filterByDCDashboard(selectedDC, rawHeaders, cleanHeaders) {
        document.querySelectorAll('.dc-btn').forEach(btn => btn.classList.remove('active'));
        const activeId = selectedDC === 'ALL' ? 'dc-all' : `dc-${selectedDC.replace(/\s+/g, '-')}`;
        const activeBtn = document.getElementById(activeId);
        if (activeBtn) activeBtn.classList.add('active');
        const dcCol = getDcColumn(rawHeaders);
        let filteredData = selectedDC === 'ALL'
            ? originalDashboardData
            : originalDashboardData.filter(row => String(dcCol ? row[dcCol] : '').trim() === selectedDC);
        renderDashboardBody(filteredData, rawHeaders, cleanHeaders);
        updateRowCount(filteredData.length, selectedDC !== 'ALL' ? selectedDC : null);
    }

    // =========================================================
    // SAVE TO DATABASE
    // =========================================================
    document.getElementById('exportBtn').addEventListener('click', async function() {
        if (originalDashboardData.length === 0) return;
        const btn = this;
        btn.disabled = true;
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        if (!csrfMeta) { showToast('✗ CSRF token missing.', '#dc2626'); btn.disabled = false; return; }
        const payload    = originalDashboardData.map(mapRowToPayload);
        const CHUNK_SIZE = 200;
        const chunks     = [];
        for (let i = 0; i < payload.length; i += CHUNK_SIZE) chunks.push(payload.slice(i, i + CHUNK_SIZE));
        let totalInserted = 0;
        try {
            for (let i = 0; i < chunks.length; i++) {
                btn.textContent = `Saving… (${i+1}/${chunks.length})`;
                const response = await fetch('/sales/store', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfMeta.getAttribute('content'), 'Accept': 'application/json' },
                    body: JSON.stringify({ transactions: chunks[i] }),
                });
                const rawText = await response.text();
                let result;
                try { result = JSON.parse(rawText); } catch { showToast(`✗ Server error pada batch ${i+1}.`, '#dc2626'); console.error(rawText); return; }
                if (!response.ok || !result.success) { showToast(`✗ Gagal pada batch ${i+1}: ${result.message || 'Unknown error'}`, '#dc2626'); return; }
                totalInserted += result.inserted ?? chunks[i].length;
            }
            showToast(`✓ ${totalInserted} rows saved to database successfully.`, '#16a34a');
            // Reset so Sales Report sub-views reload fresh data
            salesReportDBData = []; groupedSRRows = []; groupedDCRows = {};
        } catch (err) {
            showToast(`✗ Network error: ${err.message}`, '#dc2626');
            console.error(err);
        } finally {
            btn.disabled = false;
            btn.textContent = 'Save to Database';
        }
    });

    function showToast(msg, bg) {
        const toast = document.getElementById('saveToast');
        document.getElementById('saveToastMsg').textContent = msg;
        toast.style.background = bg || '#1B3A6B';
        toast.style.display = 'block';
        setTimeout(() => { toast.style.display = 'none'; }, 5000);
    }

    // =========================================================
    // RESUME ALL BUSINESS
    // =========================================================
    const MONTH_NAMES = ['','January','February','March','April','May','June','July','August','September','October','November','December'];
    const dcFamilyMap = {
        '2':'PAPER CHEMICAL','02':'PAPER CHEMICAL',
        '4':'PLASTIC, RUBBER','04':'PLASTIC, RUBBER',
        '6':'TEXTILE','06':'TEXTILE',
        '8':'PERSONAL & HOME CARE','08':'PERSONAL & HOME CARE',
        '12':'OIL FIELD, MINING'
    };
    const FAMILY_ORDER = ['PAPER CHEMICAL','CHEMICAL','BORATE','OIL FIELD, MINING','PLASTIC, RUBBER','TEXTILE','PERSONAL & HOME CARE','OTHERS'];

    async function fetchResumeData() {
        document.getElementById('resumeLoading').style.display = 'block';
        document.getElementById('resumeTableWrap').style.display = 'none';
        document.getElementById('resumeAllMonthsWrap').style.display = 'none';
        try {
            const res = await fetch('/sales/report-data', { headers: { 'Accept': 'application/json' } });
            if (!res.ok) throw new Error(`Server error: ${res.status}`);
            const result = await res.json();
            if (!result.success) throw new Error(result.message || 'Failed to fetch');
            resumeDBData = result.data;
            document.getElementById('resumeYearFilter').value = 'ALL';
            renderResumeReport();
        } catch (err) {
            document.getElementById('resumeLoading').innerHTML = `<div style="color:#dc2626;font-size:13px;">⚠ Gagal memuat data: ${err.message}</div>`;
        }
    }

    function getResumeFamily(row) {
        const dcRaw = String(row.dc || '').trim();
        const dcNum = dcRaw.replace(/^DC\s*/i, '').trim();
        return dcFamilyMap[dcNum] || dcFamilyMap[dcRaw] || 'OTHERS';
    }

    function renderResumeReport() {
    if (resumeDBData.length === 0) return;
    const yearVal = document.getElementById('resumeYearFilter').value;

    let filtered = resumeDBData;

    if (yearVal !== 'ALL') {
        filtered = filtered.filter(r => String(r.year).trim() === yearVal);
    }

    document.getElementById('resumeRowInfo').textContent = `(${filtered.length.toLocaleString()} records)`;

    const label = yearVal === 'ALL' ? 'All Data' : yearVal;
    renderResumeSingleTable(filtered, label);
}

    function aggregateByFamily(rows) {
        const map = {};
        rows.forEach(row => {
            const fam = getResumeFamily(row);
            if (!map[fam]) map[fam] = { qty:0, revenue:0, profit:0 };
            map[fam].qty     += parseFloat(row.qty) || 0;
            map[fam].revenue += parseFloat(row.gross_revenue) || 0;
            map[fam].profit  += parseFloat(row.gross_gp) || 0;
        });
        return map;
    }

    function renderResumeSingleTable(rows, label) {
        document.getElementById('resumeLoading').style.display = 'none';
        document.getElementById('resumeAllMonthsWrap').style.display = 'none';
        document.getElementById('resumeTableWrap').style.display = 'block';
        document.getElementById('resumeMonthColHeader').textContent = label.toUpperCase();
        const map = aggregateByFamily(rows);
        const tbody = document.getElementById('resumeTableBody');
        tbody.innerHTML = '';
        const fmt  = n => Math.round(n).toLocaleString('id-ID');
        const fmtD = n => n.toLocaleString('id-ID', {minimumFractionDigits:2, maximumFractionDigits:2});
        let totalQty = 0, totalRev = 0, totalProfit = 0;
        const allFamilies = [...FAMILY_ORDER, ...Object.keys(map).filter(f => !FAMILY_ORDER.includes(f))];
        allFamilies.forEach(fam => {
            if (!map[fam]) return;
            const d = map[fam];
            const gm = d.revenue > 0 ? (d.profit/d.revenue*100) : 0;
            totalQty += d.qty; totalRev += d.revenue; totalProfit += d.profit;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td style="font-weight:600;color:var(--navy);">${fam}</td>
                <td class="num" style="text-align:right;">${fmt(d.qty)}</td>
                <td class="num" style="text-align:right;">${fmt(d.revenue)}</td>
                <td class="num" style="text-align:right;">${fmt(d.profit)}</td>
                <td class="num" style="text-align:right;color:${gm>=20?'#16a34a':'#dc2626'};font-weight:700;">${fmtD(gm)}%</td>
            `;
            tbody.appendChild(tr);
        });
        const totalGM = totalRev > 0 ? (totalProfit/totalRev*100) : 0;
        const trTotal = document.createElement('tr');
        trTotal.style.cssText = 'background:#1B3A6B;color:white;font-weight:700;';
        trTotal.innerHTML = `
            <td style="color:white;font-weight:800;letter-spacing:0.05em;">TOTAL</td>
            <td class="num" style="text-align:right;color:white;">${fmt(totalQty)}</td>
            <td class="num" style="text-align:right;color:white;">${fmt(totalRev)}</td>
            <td class="num" style="text-align:right;color:white;">${fmt(totalProfit)}</td>
            <td class="num" style="text-align:right;color:#F5A623;font-weight:800;">${fmtD(totalGM)}%</td>
        `;
        tbody.appendChild(trTotal);
        document.getElementById('resumeSub').innerHTML = `Showing data for: <strong>${label}</strong>`;
    }

    function renderResumeAllMonths(rows, year) {
        document.getElementById('resumeLoading').style.display = 'none';
        document.getElementById('resumeTableWrap').style.display = 'none';
        document.getElementById('resumeAllMonthsWrap').style.display = 'block';
        document.getElementById('resumeSub').innerHTML = `All months for year: <strong>${year}</strong>`;
        const monthNameToNum = { 'january':1,'february':2,'march':3,'april':4,'may':5,'june':6,'july':7,'august':8,'september':9,'october':10,'november':11,'december':12 };
        const rowsWithMonth = rows.map(r => {
            let mn = parseInt(r.month_num);
            if (isNaN(mn) || mn < 1 || mn > 12) mn = monthNameToNum[String(r.month || '').toLowerCase().trim()] || null;
            return { ...r, _month_num: mn };
        }).filter(r => r._month_num !== null);
        const months    = [...new Set(rowsWithMonth.map(r => r._month_num))].sort((a,b)=>a-b);
        const monthMaps = {};
        months.forEach(m => { const mRows = rowsWithMonth.filter(r => r._month_num === m); monthMaps[m] = aggregateByFamily(mRows); });
        const grandMap  = aggregateByFamily(rows);
        const fmt  = n => Math.round(n).toLocaleString('id-ID');
        const fmtD = n => n.toLocaleString('id-ID', {minimumFractionDigits:2, maximumFractionDigits:2});
        const thead = document.getElementById('resumeAllMonthsHead');
        thead.innerHTML = '';
        const tr1 = document.createElement('tr');
        tr1.innerHTML = `<th rowspan="2" style="vertical-align:middle;min-width:150px;position:sticky;left:0;background:#1B3A6B;color:white;z-index:2;">GROUP PRODUCT</th>`;
        months.forEach(m => { tr1.innerHTML += `<th colspan="4" style="text-align:center;background:#1B3A6B;color:white;border-left:2px solid rgba(255,255,255,0.2);">${MONTH_NAMES[m].toUpperCase()}</th>`; });
        tr1.innerHTML += `<th colspan="4" style="text-align:center;background:#0d1f3c;color:#F5A623;border-left:2px solid rgba(255,255,255,0.3);">TOTAL ${year}</th>`;
        thead.appendChild(tr1);
        const tr2 = document.createElement('tr');
        const subCols = ['QTY','REVENUE','PROFIT','%GM'];
        for (let i = 0; i < months.length+1; i++) {
            subCols.forEach(col => { tr2.innerHTML += `<th class="num" style="text-align:right;font-size:11px;${i===months.length?'background:#1a2f52;color:#F5A623;':''}">${col}</th>`; });
        }
        thead.appendChild(tr2);
        const tbody       = document.getElementById('resumeAllMonthsBody');
        tbody.innerHTML   = '';
        const allFamilies = [...FAMILY_ORDER, ...Object.keys(grandMap).filter(f => !FAMILY_ORDER.includes(f))];
        const monthTotals = {};
        months.forEach(m => { monthTotals[m] = {qty:0,revenue:0,profit:0}; });
        let grandTotalQty=0, grandTotalRev=0, grandTotalProfit=0;
        allFamilies.forEach(fam => {
            if (!grandMap[fam]) return;
            const tr = document.createElement('tr');
            let html = `<td style="font-weight:600;color:var(--navy);position:sticky;left:0;background:white;z-index:1;">${fam}</td>`;
            months.forEach(m => {
                const d = monthMaps[m][fam] || {qty:0,revenue:0,profit:0};
                const gm = d.revenue > 0 ? (d.profit/d.revenue*100) : 0;
                monthTotals[m].qty += d.qty; monthTotals[m].revenue += d.revenue; monthTotals[m].profit += d.profit;
                html += `<td class="num" style="text-align:right;border-left:2px solid #f1f5f9;">${fmt(d.qty)}</td><td class="num" style="text-align:right;">${fmt(d.revenue)}</td><td class="num" style="text-align:right;">${fmt(d.profit)}</td><td class="num" style="text-align:right;font-weight:700;color:${gm>=20?'#16a34a':'#dc2626'};">${fmtD(gm)}%</td>`;
            });
            const g   = grandMap[fam];
            const gGM = g.revenue > 0 ? (g.profit/g.revenue*100) : 0;
            grandTotalQty += g.qty; grandTotalRev += g.revenue; grandTotalProfit += g.profit;
            html += `<td class="num" style="text-align:right;border-left:2px solid #c7d2fe;background:#f0f4ff;font-weight:700;">${fmt(g.qty)}</td><td class="num" style="text-align:right;background:#f0f4ff;font-weight:700;">${fmt(g.revenue)}</td><td class="num" style="text-align:right;background:#f0f4ff;font-weight:700;">${fmt(g.profit)}</td><td class="num" style="text-align:right;background:#f0f4ff;font-weight:800;color:${gGM>=20?'#16a34a':'#dc2626'};">${fmtD(gGM)}%</td>`;
            tr.innerHTML = html; tbody.appendChild(tr);
        });
        const trTot = document.createElement('tr');
        trTot.style.cssText = 'background:#1B3A6B;font-weight:700;';
        let totHtml = `<td style="color:white;font-weight:800;letter-spacing:0.05em;position:sticky;left:0;background:#1B3A6B;z-index:1;">TOTAL</td>`;
        months.forEach(m => {
            const d  = monthTotals[m];
            const gm = d.revenue > 0 ? (d.profit/d.revenue*100) : 0;
            totHtml += `<td class="num" style="text-align:right;color:white;border-left:2px solid rgba(255,255,255,0.2);">${fmt(d.qty)}</td><td class="num" style="text-align:right;color:white;">${fmt(d.revenue)}</td><td class="num" style="text-align:right;color:white;">${fmt(d.profit)}</td><td class="num" style="text-align:right;color:#F5A623;font-weight:800;">${fmtD(gm)}%</td>`;
        });
        const grandGM = grandTotalRev > 0 ? (grandTotalProfit/grandTotalRev*100) : 0;
        totHtml += `<td class="num" style="text-align:right;color:white;border-left:2px solid rgba(255,255,255,0.3);background:#0d1f3c;">${fmt(grandTotalQty)}</td><td class="num" style="text-align:right;color:white;background:#0d1f3c;">${fmt(grandTotalRev)}</td><td class="num" style="text-align:right;color:white;background:#0d1f3c;">${fmt(grandTotalProfit)}</td><td class="num" style="text-align:right;color:#F5A623;font-weight:800;background:#0d1f3c;">${fmtD(grandGM)}%</td>`;
        trTot.innerHTML = totHtml; tbody.appendChild(trTot);
    }

    function exportResumeReport() {
    const yearVal = document.getElementById('resumeYearFilter').value;
    const table   = document.getElementById('resumeTable');
    if (!table) return;
    const wb = XLSX.utils.table_to_book(table, { sheet: 'Resume All Business' });
    XLSX.writeFile(wb, `Resume_All_Business_${yearVal}.xlsx`);
}

    function exportSalesReport(tableId, filename) {
        const table = document.getElementById(tableId);
        if (!table) return;
        const wb = XLSX.utils.table_to_book(table, { sheet: 'Report' });
        XLSX.writeFile(wb, `${filename}.xlsx`);
    }

    // =========================================================
    // TABLE SORTING
    // =========================================================
    function makeTableSortable(tableId) {
        const table = document.getElementById(tableId);
        if (!table) return;
        const headers = table.querySelectorAll('thead th');
        headers.forEach((header, index) => {
            const newHeader = header.cloneNode(true);
            header.parentNode.replaceChild(newHeader, header);
            newHeader.style.cursor = 'pointer';
            newHeader.addEventListener('click', () => {
                const tbody = table.querySelector('tbody');
                const rows  = Array.from(tbody.querySelectorAll('tr'));
                if (rows.length === 1 && rows[0].innerText.includes('Upload')) return;
                const isAscending = newHeader.classList.contains('sort-asc');
                table.querySelectorAll('thead th').forEach(h => h.classList.remove('sort-asc', 'sort-desc'));
                newHeader.classList.add(isAscending ? 'sort-desc' : 'sort-asc');
                const direction = isAscending ? -1 : 1;
                rows.sort((a, b) => {
                    if (!a.cells[index] || !b.cells[index]) return 0;
                    let aText = a.cells[index].textContent.trim();
                    let bText = b.cells[index].textContent.trim();
                    let aNum  = parseFloat(aText.replace(/[^0-9.-]+/g, ''));
                    let bNum  = parseFloat(bText.replace(/[^0-9.-]+/g, ''));
                    if (!isNaN(aNum) && !isNaN(bNum) && aText.match(/[0-9]/) && bText.match(/[0-9]/))
                        return (aNum - bNum) * direction;
                    return aText.localeCompare(bText) * direction;
                });
                tbody.append(...rows);
            });
        });
    }

    // =========================================================
    // INIT — show app
    // =========================================================
    document.getElementById('app-wrapper').style.display = 'flex';
    document.getElementById('logoutBtn').addEventListener('click', () => window.location.href = '/login');
</script>
@endpush
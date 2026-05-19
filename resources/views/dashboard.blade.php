@extends('layouts.app')

@section('content')
<div id="app-wrapper" style="display:flex; width:100%; min-height:100vh;">

    {{-- ===== SIDEBAR ===== --}}
    @include('partials._sidebar')

    {{-- ===== MAIN CONTENT ===== --}}
    <div id="main">

        {{-- Topbar --}}
        @include('partials._topbar')

        {{-- ===== CONTENT VIEWS ===== --}}
        @include('data-prep')
        @include('sales-report')
        @include('raw-data')
        @include('dc-views')
        @include('resume-all-business')
        @include('master-material')
        @include('master-salesman')

    </div>
</div>

{{-- ===== MODALS ===== --}}

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
            <div>
                <label style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:6px;display:block;">DC (Subclass 1)</label>
                <input type="text" id="matDcInput" placeholder="e.g. DC 2"
                    style="width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;outline:none;">
            </div>
            <div>
                <label style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:6px;display:block;">Division (Subclass 2)</label>
                <input type="text" id="matDivInput" placeholder="e.g. Textile"
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

{{-- Shared CSS for filter bars & sub-nav --}}
<style>
    /* Sub-nav items */
    .nav-sub-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 20px 9px 32px;
        cursor: pointer;
        color: #7a9cbf;
        font-size: 13px;
        font-weight: 500;
        border-left: 3px solid transparent;
        transition: all 0.15s;
    }
    .nav-sub-item:hover, .nav-sub-item.active {
        color: #ffffff;
        background: rgba(255,255,255,0.06);
        border-left-color: #F5A623;
    }

    /* Filter bars */
    .sr-filter-bar {
        display: flex;
        align-items: flex-end;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 16px;
        padding: 12px 14px;
        background: #f8fafc;
        border: 1px solid var(--border);
        border-radius: 10px;
    }
    .sr-filter-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .sr-filter-label {
        font-size: 10px;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .sr-filter-input, .sr-filter-select {
        padding: 7px 10px;
        border: 1px solid var(--border);
        border-radius: 7px;
        font-size: 13px;
        color: var(--text);
        background: white;
        outline: none;
        min-width: 150px;
        transition: border-color 0.15s;
    }
    .sr-filter-input:focus, .sr-filter-select:focus {
        border-color: var(--accent);
    }
    .sr-clear-btn {
        padding: 7px 14px;
        border-radius: 7px;
        border: 1px solid #fecaca;
        background: #fff5f5;
        color: #dc2626;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s;
        white-space: nowrap;
        align-self: flex-end;
    }
    .sr-clear-btn:hover { background: #fee2e2; }

    /* Grand total rows */
    .grand-total-row td {
        background: #1B3A6B !important;
        color: white !important;
        font-weight: 800 !important;
        font-size: 13px;
    }
    .subtotal-row td {
        background: #f0f4ff;
        font-weight: 700;
        border-top: 2px solid #c7d7f4;
    }
</style>

{{-- ===== JAVASCRIPT ===== --}}
<script>
// =====================================================
// GLOBALS & HELPERS (from helpers.js)
// =====================================================
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

function cleanKey(key) { return key.replace(/\u00a0/g, '').trim(); }

function parseIntSafe(val) {
    if (val === null || val === undefined || val === '') return null;
    const n = parseInt(String(val).replace(/[,%\s]/g, ''), 10);
    return isNaN(n) ? null : n;
}

function parseFloatSafe(val) {
    if (val === null || val === undefined || val === '') return null;
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
        month_num, month: getExcelValue(row, 'Month') || null, year,
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
const formatDec2 = n => n.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

function escapeJs(str) {
    return String(str).replace(/\\/g, '\\\\').replace(/'/g, "\\'").replace(/"/g, '\\"');
}

const dcFamilyMapGlobal = {
    '2': 'PAPER CHEMICAL', '02': 'PAPER CHEMICAL',
    '4': 'PLASTIC, RUBBER', '04': 'PLASTIC, RUBBER',
    '6': 'TEXTILE', '06': 'TEXTILE',
    '8': 'PERSONAL & HOME CARE', '08': 'PERSONAL & HOME CARE',
    '12': 'OIL FIELD, MINING'
};

function getFamily(dcRaw) {
    const dcNum = String(dcRaw).replace(/^DC\s*/i, '').trim();
    return dcFamilyMapGlobal[dcNum] || dcFamilyMapGlobal[dcRaw] || 'OTHERS';
}

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

// =====================================================
// NAVIGATION
// =====================================================
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

// Business Area Dropdown
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
    buildGroupedData();
    const activeView = document.querySelector('.content-view.active');
    if (activeView) renderViewForTarget(activeView.id);
}

// Logout
document.getElementById('logoutBtn').addEventListener('click', function() {
    window.location.href = '/login';
});

// =====================================================
// DATA PREP — FILE UPLOAD
// =====================================================
document.getElementById('fileUpload').addEventListener('change', handleFile, false);

function handleFile(e) {
    const files = e.target.files;
    if (files.length === 0) return;
    document.getElementById('loadingModal').style.display = 'flex';
    setTimeout(() => {
        try {
            const reader = new FileReader();
            reader.onload = function(e) {
                const data     = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array', cellDates: true });
                const rawDataJson = XLSX.utils.sheet_to_json(
                    workbook.Sheets[workbook.SheetNames[0]],
                    { raw: false, defval: '' }
                );
                originalDashboardData = rawDataJson;
                initializeDashboard(rawDataJson);
                document.getElementById('exportBtn').disabled = false;
                document.getElementById('loadingModal').style.display = 'none';
            };
            reader.readAsArrayBuffer(files[0]);
        } catch(err) {
            console.error(err);
            alert('Error processing the Excel file.');
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
    const headerRow    = document.createElement('tr');
    cleanHeaders.forEach(h => {
        const th = document.createElement('th');
        th.textContent = h;
        headerRow.appendChild(th);
    });
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
            if (h.includes('qty') || h.includes('rev') || h.includes('gp') ||
                h.includes('gm') || h.includes('logistic') || h.includes('cogs') || h.includes('expense'))
                td.classList.add('num');
            tr.appendChild(td);
        });
        tbody.appendChild(tr);
    });
}

function updateRowCount(count, filterLabel) {
    document.getElementById('rowCount').textContent = count.toLocaleString();
    document.getElementById('filterInfo').textContent = filterLabel ? ` · filtered by ${filterLabel}` : '';
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

function filterByDCDashboard(selectedDC, rawHeaders, cleanHeaders) {
    document.querySelectorAll('.dc-btn').forEach(btn => btn.classList.remove('active'));
    const activeId  = selectedDC === 'ALL' ? 'dc-all' : `dc-${selectedDC.replace(/\s+/g, '-')}`;
    const activeBtn = document.getElementById(activeId);
    if (activeBtn) activeBtn.classList.add('active');
    const dcCol = rawHeaders.find(h => cleanKey(h) === 'DC') || null;
    const filteredData = selectedDC === 'ALL'
        ? originalDashboardData
        : originalDashboardData.filter(row => String(dcCol ? row[dcCol] : '').trim() === selectedDC);
    renderDashboardBody(filteredData, rawHeaders, cleanHeaders);
    updateRowCount(filteredData.length, selectedDC !== 'ALL' ? selectedDC : null);
}

// Save to Database
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
            btn.textContent = `Saving… (${i + 1}/${chunks.length})`;
            const response = await fetch('/sales/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfMeta.getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ transactions: chunks[i] }),
            });
            const rawText = await response.text();
            let result;
            try { result = JSON.parse(rawText); }
            catch { showToast(`✗ Server error pada batch ${i + 1}.`, '#dc2626'); return; }
            if (!response.ok || !result.success) {
                showToast(`✗ Gagal pada batch ${i + 1}: ${result.message || 'Unknown error'}`, '#dc2626');
                return;
            }
            totalInserted += result.inserted ?? chunks[i].length;
        }
        showToast(`✓ ${totalInserted} rows saved to database successfully.`, '#16a34a');
        salesReportDBData = []; groupedSRRows = []; groupedDCRows = {};
        masterMaterialBase = []; masterSalesmanBase = [];
    } catch(err) {
        showToast(`✗ Network error: ${err.message}`, '#dc2626');
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

// =====================================================
// SALES REPORT — FETCH & RENDER
// =====================================================
async function fetchSalesReportFromDB() {
    try {
        const res  = await fetch('/sales/report-data');
        const json = await res.json();
        if (!json.success) throw new Error(json.message);
        salesReportDBData = json.data;
        buildGroupedData();
        const activeView = document.querySelector('.content-view.active');
        if (activeView) renderViewForTarget(activeView.id);
    } catch(e) {
        console.error('fetchSalesReportFromDB error:', e);
    }
}

function buildGroupedData() {
    const filtered = currentBAFilter === 'ALL'
        ? salesReportDBData
        : salesReportDBData.filter(r => r.business_area === currentBAFilter);

    // grouped by family+customer+material+dc
    const map = {};
    filtered.forEach(r => {
        const dc  = (r.dc || '').trim();
        const fam = getFamily(dc);
        const key = `${fam}||${r.customer || '—'}||${r.material || '—'}||${dc}`;
        if (!map[key]) map[key] = { family: fam, customer: r.customer || '—', material: r.material || '—', dc: dc || '—', qty: 0, gross_revenue: 0, gross_gp: 0 };
        map[key].qty           += parseFloat(r.qty)           || 0;
        map[key].gross_revenue += parseFloat(r.gross_revenue) || 0;
        map[key].gross_gp      += parseFloat(r.gross_gp)      || 0;
    });
    groupedSRRows = Object.values(map).sort((a, b) => a.family.localeCompare(b.family) || a.customer.localeCompare(b.customer));

    // group by DC
    groupedDCRows = {};
    VALID_DCS.forEach(dc => { groupedDCRows[dc] = groupedSRRows.filter(r => r.dc === dc); });
}

function renderSalesReportFromDB() {
    document.getElementById('salesReportLoading').style.display    = 'none';
    document.getElementById('salesReportTableWrap').style.display  = 'block';
    applyAllSRFilters();
}

function applyAllSRFilters() {
    const fam  = document.getElementById('sr-filter-family')?.value.toLowerCase()   || '';
    const cust = document.getElementById('sr-filter-customer')?.value.toLowerCase() || '';
    const mat  = document.getElementById('sr-filter-material')?.value.toLowerCase() || '';
    const dc   = document.getElementById('sr-filter-dc')?.value                     || '';
    const rows = groupedSRRows.filter(r =>
        (!fam  || r.family.toLowerCase().includes(fam))   &&
        (!cust || r.customer.toLowerCase().includes(cust)) &&
        (!mat  || r.material.toLowerCase().includes(mat))  &&
        (!dc   || r.dc === dc)
    );
    const tbody = document.getElementById('salesReportBody');
    tbody.innerHTML = '';
    let totQty = 0, totRev = 0, totGP = 0;
    rows.forEach(r => {
        totQty += r.qty; totRev += r.gross_revenue; totGP += r.gross_gp;
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${r.family}</td><td>${r.customer}</td><td>${r.material}</td><td>${r.dc}</td>
            <td class="num" style="text-align:right;">${formatNum(r.qty)}</td>
            <td class="num" style="text-align:right;">${formatNum(r.gross_revenue)}</td>
            <td class="num" style="text-align:right;">${formatNum(r.gross_gp)}</td>`;
        tbody.appendChild(tr);
    });
    // Grand total
    const tr = document.createElement('tr');
    tr.className = 'grand-total-row';
    tr.innerHTML = `<td colspan="4">GRAND TOTAL</td>
        <td class="num" style="text-align:right;">${formatNum(totQty)}</td>
        <td class="num" style="text-align:right;">${formatNum(totRev)}</td>
        <td class="num" style="text-align:right;">${formatNum(totGP)}</td>`;
    tbody.appendChild(tr);
    const countEl = document.getElementById('sr-filter-count');
    if (countEl) countEl.textContent = `${rows.length} rows`;
}

function clearSRFilters(prefix) {
    ['family','customer','material'].forEach(f => {
        const el = document.getElementById(`${prefix}-filter-${f}`);
        if (el) el.value = '';
    });
    const dc = document.getElementById(`${prefix}-filter-dc`);
    if (dc) dc.value = '';
    if (prefix === 'sr') applyAllSRFilters();
    else {
        const dcMap = { dc02: 'DC 2', dc12: 'DC 12', dc04: 'DC 4', dc06: 'DC 6', dc08: 'DC 8' };
        if (dcMap[prefix]) applyDCFilters(dcMap[prefix], prefix);
    }
}

// =====================================================
// RAW DATA VIEW
// =====================================================
function renderRawView() {
    const loadEl = document.getElementById('rawLoading');
    const wrapEl = document.getElementById('rawTableWrap');
    const infoEl = document.getElementById('rawDataInfo');
    if (loadEl) loadEl.style.display = 'none';
    if (wrapEl) wrapEl.style.display = 'block';
    if (infoEl) infoEl.style.display = 'block';
    applyRawFilters();
}

function applyRawFilters() {
    const fam  = document.getElementById('raw-filter-family')?.value.toLowerCase()   || '';
    const cust = document.getElementById('raw-filter-customer')?.value.toLowerCase() || '';
    const mat  = document.getElementById('raw-filter-material')?.value.toLowerCase() || '';
    const dc   = document.getElementById('raw-filter-dc')?.value                     || '';
    const filtered = currentBAFilter === 'ALL'
        ? salesReportDBData
        : salesReportDBData.filter(r => r.business_area === currentBAFilter);
    const rows = filtered.filter(r =>
        (!fam  || getFamily(r.dc || '').toLowerCase().includes(fam)) &&
        (!cust || (r.customer || '').toLowerCase().includes(cust))   &&
        (!mat  || (r.material || '').toLowerCase().includes(mat))    &&
        (!dc   || (r.dc || '').trim() === dc)
    );
    const tbody = document.getElementById('rawTableBody');
    tbody.innerHTML = '';
    rows.forEach(r => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${r.business_area||''}</td><td>${r.dc||''}</td><td>${r.division||''}</td>
            <td>${r.sales_doc_type||''}</td><td>${r.month_num||''}</td><td>${r.month||''}</td><td>${r.year||''}</td>
            <td>${r.salesman_id||''}</td><td>${r.salesman||''}</td>
            <td>${r.customer_id||''}</td><td>${r.customer||''}</td>
            <td>${r.material_id||''}</td><td>${r.material||''}</td>
            <td class="num" style="text-align:right;">${formatNum(r.qty||0)}</td>
            <td class="num" style="text-align:right;">${formatNum(r.gross_revenue||0)}</td>
            <td class="num" style="text-align:right;">${formatNum(r.logistic_expense||0)}</td>
            <td class="num" style="text-align:right;">${formatNum(r.net_revenue||0)}</td>
            <td class="num" style="text-align:right;">${formatNum(r.cogs||0)}</td>
            <td class="num" style="text-align:right;">${formatNum(r.gross_gp||0)}</td>
            <td class="num" style="text-align:right;">${formatDec2(r.gross_gm_percent||0)}%</td>`;
        tbody.appendChild(tr);
    });
    const countEl = document.getElementById('raw-filter-count');
    if (countEl) countEl.textContent = `${rows.length} rows`;
    const rowCountEl = document.getElementById('rawRowCount');
    if (rowCountEl) rowCountEl.textContent = rows.length.toLocaleString();
}

function clearRawFilters() {
    ['family','customer','material'].forEach(f => {
        const el = document.getElementById(`raw-filter-${f}`);
        if (el) el.value = '';
    });
    const dc = document.getElementById('raw-filter-dc');
    if (dc) dc.value = '';
    applyRawFilters();
}

function exportRawData() {
    const table = document.getElementById('rawTable');
    if (!table) return;
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.table_to_sheet(table);
    XLSX.utils.book_append_sheet(wb, ws, 'Raw Data');
    XLSX.writeFile(wb, 'Raw_Sales_Data.xlsx');
}

// =====================================================
// DC VIEWS
// =====================================================
function renderDCView(dcValue, prefix) {
    const loadEl = document.getElementById(`${prefix}Loading`);
    const wrapEl = document.getElementById(`${prefix}TableWrap`);
    if (loadEl) loadEl.style.display = 'none';
    if (wrapEl) wrapEl.style.display = 'block';
    applyDCFilters(dcValue, prefix);
}

function applyDCFilters(dcValue, prefix) {
    const fam  = document.getElementById(`${prefix}-filter-family`)?.value.toLowerCase()   || '';
    const cust = document.getElementById(`${prefix}-filter-customer`)?.value.toLowerCase() || '';
    const mat  = document.getElementById(`${prefix}-filter-material`)?.value.toLowerCase() || '';
    const rows = (groupedDCRows[dcValue] || []).filter(r =>
        (!fam  || r.family.toLowerCase().includes(fam))   &&
        (!cust || r.customer.toLowerCase().includes(cust)) &&
        (!mat  || r.material.toLowerCase().includes(mat))
    );
    const tbody = document.getElementById(`${prefix}Body`);
    tbody.innerHTML = '';
    let totQty = 0, totRev = 0, totGP = 0;
    rows.forEach(r => {
        totQty += r.qty; totRev += r.gross_revenue; totGP += r.gross_gp;
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${r.family}</td><td>${r.customer}</td><td>${r.material}</td><td>${r.dc}</td>
            <td class="num" style="text-align:right;">${formatNum(r.qty)}</td>
            <td class="num" style="text-align:right;">${formatNum(r.gross_revenue)}</td>
            <td class="num" style="text-align:right;">${formatNum(r.gross_gp)}</td>`;
        tbody.appendChild(tr);
    });
    const tr = document.createElement('tr');
    tr.className = 'grand-total-row';
    tr.innerHTML = `<td colspan="4">TOTAL ${dcValue}</td>
        <td class="num" style="text-align:right;">${formatNum(totQty)}</td>
        <td class="num" style="text-align:right;">${formatNum(totRev)}</td>
        <td class="num" style="text-align:right;">${formatNum(totGP)}</td>`;
    tbody.appendChild(tr);
    const countEl = document.getElementById(`${prefix}-filter-count`);
    if (countEl) countEl.textContent = `${rows.length} rows`;
}

function exportSalesReport(tableId, fileName) {
    const table = document.getElementById(tableId);
    if (!table) return;
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.table_to_sheet(table);
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
    XLSX.writeFile(wb, `${fileName}.xlsx`);
}

// =====================================================
// RESUME ALL BUSINESS
// =====================================================
async function fetchResumeData() {
    try {
        const res  = await fetch('/sales/report-data');
        const json = await res.json();
        if (!json.success) throw new Error(json.message);
        resumeDBData = json.data;
        document.getElementById('resumeLoading').style.display = 'none';
        renderResumeReport();
    } catch(e) {
        console.error('fetchResumeData error:', e);
    }
}

var currentResumeBA = 'ALL';

function toggleResumeBADropdown() {
    const menu = document.getElementById('resumeBAMenu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}
document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('resumeBAWrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        const menu = document.getElementById('resumeBAMenu');
        if (menu) menu.style.display = 'none';
    }
});
function selectResumeBA(value, label) {
    currentResumeBA = value;
    document.getElementById('resumeBALabel').textContent = label;
    document.querySelectorAll('.rba-option').forEach(opt => {
        opt.classList.toggle('active', opt.dataset.value === value);
        opt.style.fontWeight = opt.dataset.value === value ? '700' : '400';
        opt.style.background = opt.dataset.value === value ? '#f0f4ff' : 'white';
    });
    const menu = document.getElementById('resumeBAMenu');
    if (menu) menu.style.display = 'none';
    renderResumeReport();
}

function onResumeYearChange() {
    const yr = document.getElementById('resumeYearFilter').value;
    const mw = document.getElementById('resumeMonthFilterWrap');
    if (yr === 'ALL') {
        mw.style.display = 'none';
    } else {
        mw.style.display = 'flex';
        // Populate months
        const sel = document.getElementById('resumeMonthFilter');
        sel.innerHTML = '<option value="ALL">All Months (YTD)</option>';
        const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        months.forEach((m, i) => {
            const opt = document.createElement('option');
            opt.value = i + 1;
            opt.textContent = m;
            sel.appendChild(opt);
        });
    }
    renderResumeReport();
}

function renderResumeReport() {
    const yr    = document.getElementById('resumeYearFilter').value;
    const month = document.getElementById('resumeMonthFilter')?.value || 'ALL';
    const tableWrap = document.getElementById('resumeTableWrap');
    const tbody     = document.getElementById('resumeTableBody');
    const colHeader = document.getElementById('resumeMonthColHeader');
    tableWrap.style.display = 'block';

    let filtered = currentResumeBA === 'ALL'
        ? resumeDBData
        : resumeDBData.filter(r => r.business_area === currentResumeBA);

    if (yr !== 'ALL') {
        filtered = filtered.filter(r => String(r.year) === yr);
        if (month !== 'ALL') {
            filtered = filtered.filter(r => String(r.month_num) === String(month));
            const mNames = ['','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            if (colHeader) colHeader.textContent = `${mNames[parseInt(month)]} ${yr}`;
        } else {
            if (colHeader) colHeader.textContent = `YTD ${yr}`;
        }
    } else {
        if (colHeader) colHeader.textContent = 'ALL PERIODS';
    }

    // Group by product family
    const families = {};
    filtered.forEach(r => {
        const fam = getFamily(r.dc || '');
        if (!families[fam]) families[fam] = { qty: 0, revenue: 0, gp: 0 };
        families[fam].qty     += parseFloat(r.qty)           || 0;
        families[fam].revenue += parseFloat(r.gross_revenue) || 0;
        families[fam].gp      += parseFloat(r.gross_gp)      || 0;
    });

    tbody.innerHTML = '';
    let totQty = 0, totRev = 0, totGP = 0;
    const order = ['PAPER CHEMICAL','PLASTIC, RUBBER','TEXTILE','PERSONAL & HOME CARE','OIL FIELD, MINING','OTHERS'];
    order.forEach(fam => {
        if (!families[fam]) return;
        const d  = families[fam];
        const gm = d.revenue > 0 ? (d.gp / d.revenue * 100) : 0;
        totQty += d.qty; totRev += d.revenue; totGP += d.gp;
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${fam}</td>
            <td class="num" style="text-align:right;">${formatNum(d.qty)}</td>
            <td class="num" style="text-align:right;">${formatNum(d.revenue)}</td>
            <td class="num" style="text-align:right;">${formatNum(d.gp)}</td>
            <td class="num" style="text-align:right;">${formatDec2(gm)}%</td>`;
        tbody.appendChild(tr);
    });
    const totGM = totRev > 0 ? (totGP / totRev * 100) : 0;
    const tr = document.createElement('tr');
    tr.className = 'grand-total-row';
    tr.innerHTML = `<td>GRAND TOTAL</td>
        <td class="num" style="text-align:right;">${formatNum(totQty)}</td>
        <td class="num" style="text-align:right;">${formatNum(totRev)}</td>
        <td class="num" style="text-align:right;">${formatNum(totGP)}</td>
        <td class="num" style="text-align:right;">${formatDec2(totGM)}%</td>`;
    tbody.appendChild(tr);
    const infoEl = document.getElementById('resumeRowInfo');
    if (infoEl) infoEl.textContent = `${filtered.length} records`;
}

function exportResumeReport() {
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.table_to_sheet(document.getElementById('resumeTable'));
    XLSX.utils.book_append_sheet(wb, ws, 'Resume');
    XLSX.writeFile(wb, 'Resume_All_Business.xlsx');
}

// =====================================================
// MASTER MATERIAL
// =====================================================
async function renderMasterMaterial() {
    if (masterMaterialBase.length === 0) {
        document.getElementById('mmLoading').style.display    = 'block';
        document.getElementById('mmTableWrap').style.display  = 'none';
        document.getElementById('mmDataInfo').style.display   = 'none';
        try {
            const res  = await fetch('/sales/master-material');
            const json = await res.json();
            if (!json.success) throw new Error(json.message);
            masterMaterialBase = json.data;
            masterMaterialData = [...masterMaterialBase];
        } catch(e) {
            document.getElementById('mmLoading').textContent = '⚠ Failed to load data.';
            return;
        }
    }
    document.getElementById('mmLoading').style.display   = 'none';
    document.getElementById('mmTableWrap').style.display = 'block';
    document.getElementById('mmDataInfo').style.display  = 'block';
    applyMaterialFilters();
}

function applyMaterialFilters() {
    const id   = document.getElementById('mm-filter-id')?.value.toLowerCase()     || '';
    const desc = document.getElementById('mm-filter-desc')?.value.toLowerCase()   || '';
    const fam  = document.getElementById('mm-filter-family')?.value.toLowerCase() || '';
    const sub1 = document.getElementById('mm-filter-sub1')?.value.toLowerCase()   || '';
    const sub2 = document.getElementById('mm-filter-sub2')?.value.toLowerCase()   || '';
    masterMaterialData = masterMaterialBase.filter(r =>
        (!id   || (r.material_id || '').toLowerCase().includes(id))       &&
        (!desc || (r.material || '').toLowerCase().includes(desc))         &&
        (!fam  || (r.product_family || '').toLowerCase().includes(fam))    &&
        (!sub1 || (r.subclass_1 || '').toLowerCase().includes(sub1))       &&
        (!sub2 || (r.subclass_2 || '').toLowerCase().includes(sub2))
    );
    renderMaterialTable();
}

function clearMaterialFilters() {
    ['mm-filter-id','mm-filter-desc','mm-filter-family','mm-filter-sub1','mm-filter-sub2'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    applyMaterialFilters();
}

function renderMaterialTable() {
    const tbody = document.getElementById('mmTableBody');
    tbody.innerHTML = '';
    masterMaterialData.forEach(r => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${r.material_id}</td><td>${r.material}</td>
            <td>${r.product_family}</td><td>${r.subclass_1}</td><td>${r.subclass_2}</td>
            <td style="text-align:center;">
                <button onclick="openEditMaterialModal('${escapeJs(r.material_id)}','${escapeJs(r.material)}','${escapeJs(r.subclass_1)}','${escapeJs(r.subclass_2)}')"
                    style="padding:4px 10px;font-size:11px;border-radius:6px;border:1px solid #c7d7f4;background:#f0f4ff;color:#1d4ed8;cursor:pointer;font-weight:700;">Edit</button>
            </td>`;
        tbody.appendChild(tr);
    });
    document.getElementById('mmRowCount').textContent = masterMaterialData.length.toLocaleString();
    const countEl = document.getElementById('mm-filter-count');
    if (countEl) countEl.textContent = masterMaterialData.length !== masterMaterialBase.length ? `(${masterMaterialData.length} of ${masterMaterialBase.length})` : '';
}

function exportMasterMaterial() {
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.table_to_sheet(document.getElementById('mmTable'));
    XLSX.utils.book_append_sheet(wb, ws, 'Master Material');
    XLSX.writeFile(wb, 'Master_Material.xlsx');
}

var editingMaterialId = null;

function openAddMaterialModal() {
    editingMaterialId = null;
    document.getElementById('materialModalTitle').textContent = 'Add Material';
    document.getElementById('matIdInput').value   = '';
    document.getElementById('matDescInput').value = '';
    document.getElementById('matDcInput').value   = '';
    document.getElementById('matDivInput').value  = '';
    document.getElementById('matIdInput').disabled = false;
    document.getElementById('materialModalError').style.display = 'none';
    document.getElementById('materialModal').style.display = 'flex';
}

function openEditMaterialModal(id, desc, dc, div) {
    editingMaterialId = id;
    document.getElementById('materialModalTitle').textContent = 'Edit Material';
    document.getElementById('matIdInput').value   = id;
    document.getElementById('matDescInput').value = desc;
    document.getElementById('matDcInput').value   = dc === '—' ? '' : dc;
    document.getElementById('matDivInput').value  = div === '—' ? '' : div;
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
    const dc   = document.getElementById('matDcInput').value.trim();
    const div  = document.getElementById('matDivInput').value.trim();
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
            body: JSON.stringify({ material_id: id, material: desc, dc, division: div }),
        });
        const json = await res.json();
        if (!json.success) { errEl.textContent = json.message || 'Error saving.'; errEl.style.display = 'block'; return; }
        closeMaterialModal();
        masterMaterialBase = [];
        renderMasterMaterial();
    } catch(e) {
        errEl.textContent = 'Network error.'; errEl.style.display = 'block';
    } finally {
        btn.disabled = false; btn.textContent = 'Save Material';
    }
}

// =====================================================
// MASTER SALESMAN
// =====================================================
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

function applyMsFilters() {
    const id   = document.getElementById('ms-filter-id')?.value.toLowerCase()       || '';
    const name = document.getElementById('ms-filter-name')?.value.toLowerCase()     || '';
    const cust = document.getElementById('ms-filter-customer')?.value.toLowerCase() || '';
    const mat  = document.getElementById('ms-filter-material')?.value.toLowerCase() || '';
    masterSalesmanData = masterSalesmanBase.filter(r =>
        (!id   || (r.salesman_id || '').toLowerCase().includes(id))   &&
        (!name || (r.salesman || '').toLowerCase().includes(name))     &&
        (!cust || (r.customer || '').toLowerCase().includes(cust))     &&
        (!mat  || (r.material || '').toLowerCase().includes(mat))
    );
    renderSalesmanTable();
}

function clearSalesmanFilters() {
    ['ms-filter-id','ms-filter-name','ms-filter-customer','ms-filter-material'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    applyMsFilters();
}

function renderSalesmanTable() {
    const tbody = document.getElementById('msTableBody');
    tbody.innerHTML = '';
    masterSalesmanData.forEach(r => {
        const gm = r.gross_gm_percent !== null ? formatDec2(r.gross_gm_percent) + '%' : '—';
        const gmColor = r.gross_gm_percent > 20 ? '#16a34a' : r.gross_gm_percent < 5 ? '#dc2626' : '#d97706';
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${r.salesman_id}</td><td>${r.salesman}</td>
            <td>${r.customer}</td><td>${r.material}</td>
            <td class="num" style="text-align:right;font-weight:700;color:${gmColor};">${gm}</td>
            <td style="text-align:center;">
                <button onclick="openEditSalesmanModal('${escapeJs(r.salesman_id)}','${escapeJs(r.salesman)}')"
                    style="padding:4px 10px;font-size:11px;border-radius:6px;border:1px solid #c7d7f4;background:#f0f4ff;color:#1d4ed8;cursor:pointer;font-weight:700;">Edit</button>
            </td>`;
        tbody.appendChild(tr);
    });
    document.getElementById('msRowCount').textContent = masterSalesmanData.length.toLocaleString();
    const countEl = document.getElementById('ms-filter-count');
    if (countEl) countEl.textContent = masterSalesmanData.length !== masterSalesmanBase.length ? `(${masterSalesmanData.length} of ${masterSalesmanBase.length})` : '';
}

function exportMasterSalesman() {
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.table_to_sheet(document.getElementById('msTable'));
    XLSX.utils.book_append_sheet(wb, ws, 'Master Salesman');
    XLSX.writeFile(wb, 'Master_Salesman.xlsx');
}

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

function closeSalesmanModal() {
    document.getElementById('salesmanModal').style.display = 'none';
    document.getElementById('salesmanDetailModal').style.display = 'none';
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
        closeSalesmanModal();
        masterSalesmanBase = [];
        renderMasterSalesman();
    } catch(e) {
        errEl.textContent = 'Network error.'; errEl.style.display = 'block';
    } finally {
        btn.disabled = false; btn.textContent = 'Save Salesman';
    }
}
</script>
@endpush
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

// Master data globals
var masterMaterialData    = [];
var masterMaterialBase    = [];
var masterSalesmanData    = [];
var masterSalesmanBase    = [];

// =========================================================
// HELPERS
// =========================================================
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
const formatDec2 = n => n.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

function escapeJs(str) {
    return String(str).replace(/\\/g, '\\\\').replace(/'/g, "\\'").replace(/"/g, '\\"');
}

// DC → Family mapping (shared)
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
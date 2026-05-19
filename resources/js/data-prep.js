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
            reader.onload = function (e) {
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
        } catch (err) {
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

function getDcColumn(rawHeaders) {
    return rawHeaders.find(h => cleanKey(h) === 'DC') || null;
}

function filterByDCDashboard(selectedDC, rawHeaders, cleanHeaders) {
    document.querySelectorAll('.dc-btn').forEach(btn => btn.classList.remove('active'));
    const activeId  = selectedDC === 'ALL' ? 'dc-all' : `dc-${selectedDC.replace(/\s+/g, '-')}`;
    const activeBtn = document.getElementById(activeId);
    if (activeBtn) activeBtn.classList.add('active');
    const dcCol = getDcColumn(rawHeaders);
    const filteredData = selectedDC === 'ALL'
        ? originalDashboardData
        : originalDashboardData.filter(row => String(dcCol ? row[dcCol] : '').trim() === selectedDC);
    renderDashboardBody(filteredData, rawHeaders, cleanHeaders);
    updateRowCount(filteredData.length, selectedDC !== 'ALL' ? selectedDC : null);
}

// =========================================================
// SAVE TO DATABASE
// =========================================================
document.getElementById('exportBtn').addEventListener('click', async function () {
    if (originalDashboardData.length === 0) return;
    const btn      = this;
    btn.disabled   = true;
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
                method:  'POST',
                headers: {
                    'Content-Type':  'application/json',
                    'X-CSRF-TOKEN':  csrfMeta.getAttribute('content'),
                    'Accept':        'application/json',
                },
                body: JSON.stringify({ transactions: chunks[i] }),
            });
            const rawText = await response.text();
            let result;
            try { result = JSON.parse(rawText); }
            catch { showToast(`✗ Server error pada batch ${i + 1}.`, '#dc2626'); console.error(rawText); return; }
            if (!response.ok || !result.success) {
                showToast(`✗ Gagal pada batch ${i + 1}: ${result.message || 'Unknown error'}`, '#dc2626');
                return;
            }
            totalInserted += result.inserted ?? chunks[i].length;
        }
        showToast(`✓ ${totalInserted} rows saved to database successfully.`, '#16a34a');
        // Reset cached data so views reload fresh
        salesReportDBData = []; groupedSRRows = []; groupedDCRows = {};
        masterMaterialBase = []; masterSalesmanBase = [];
    } catch (err) {
        showToast(`✗ Network error: ${err.message}`, '#dc2626');
        console.error(err);
    } finally {
        btn.disabled    = false;
        btn.textContent = 'Save to Database';
    }
});

function showToast(msg, bg) {
    const toast = document.getElementById('saveToast');
    document.getElementById('saveToastMsg').textContent = msg;
    toast.style.background = bg || '#1B3A6B';
    toast.style.display    = 'block';
    setTimeout(() => { toast.style.display = 'none'; }, 5000);
}
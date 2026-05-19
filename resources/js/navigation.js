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

    const salesViews = [
        'sales-report-content', 'sr-raw-content', 'sr-dc02-content',
        'sr-dc12-content', 'sr-dc04-content', 'sr-dc06-content', 'sr-dc08-content'
    ];
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

function closeBADropdown() {
    document.getElementById('baDropdownMenu').style.display = 'none';
}

document.addEventListener('click', function (e) {
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
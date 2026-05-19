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

    {{-- Sales Report Children --}}
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

    {{-- Master Data --}}
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
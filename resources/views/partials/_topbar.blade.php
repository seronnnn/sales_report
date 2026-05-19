<div class="topbar">
    <div class="flex items-center gap-3">
        <span style="font-size:12px;color:var(--muted);font-weight:700;letter-spacing:0.05em;">WORKSPACE</span>
        <span style="color:var(--border);">|</span>
        <span id="topbar-title" style="font-size:14px;font-weight:700;color:var(--navy);">Data Preparation Dashboard</span>
    </div>
    <div class="flex items-center gap-3">
        {{-- Business Area Dropdown --}}
        <div id="businessAreaFilter" style="display:none; position:relative;">
            <button id="baDropdownBtn" onclick="toggleBADropdown()"
                style="display:flex;align-items:center;gap:8px;padding:8px 14px;border:1px solid var(--border);border-radius:8px;background:white;font-size:13px;font-weight:600;color:var(--navy);cursor:pointer;white-space:nowrap;">
                <span id="baDropdownLabel">All Business Area</span>
                <span style="font-size:10px;">▼</span>
            </button>
            <div id="baDropdownMenu"
                style="display:none;position:absolute;right:0;top:calc(100% + 6px);background:white;border:1px solid var(--border);border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.12);min-width:200px;z-index:999;overflow:hidden;">
                <div class="ba-option active" data-value="ALL" onclick="selectBusinessArea('ALL', 'All Business Area')"
                    style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);font-weight:600;border-bottom:1px solid var(--border);">All Business Area</div>
                <div class="ba-option" data-value="DKJ - Cibitung" onclick="selectBusinessArea('DKJ - Cibitung', 'DKJ - Cibitung')"
                    style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Cibitung</div>
                <div class="ba-option" data-value="DKJ - Delta Mas" onclick="selectBusinessArea('DKJ - Delta Mas', 'DKJ - Delta Mas')"
                    style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Delta Mas</div>
                <div class="ba-option" data-value="DKJ - Medan" onclick="selectBusinessArea('DKJ - Medan', 'DKJ - Medan')"
                    style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Medan</div>
                <div class="ba-option" data-value="DKJ - Surabaya" onclick="selectBusinessArea('DKJ - Surabaya', 'DKJ - Surabaya')"
                    style="padding:10px 16px;font-size:13px;cursor:pointer;color:var(--navy);">DKJ - Surabaya</div>
            </div>
        </div>
        <button id="logoutBtn" class="btn btn-danger">Logout</button>
    </div>
</div>
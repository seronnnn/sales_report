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
                <thead>
                    <tr>
                        <th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th>
                        <th class="num" style="text-align:right;">Sum of Qty</th>
                        <th class="num" style="text-align:right;">Sum of Gross Revenue</th>
                        <th class="num" style="text-align:right;">Sum of Gross GP</th>
                    </tr>
                </thead>
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
                <thead>
                    <tr>
                        <th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th>
                        <th class="num" style="text-align:right;">Sum of Qty</th>
                        <th class="num" style="text-align:right;">Sum of Gross Revenue</th>
                        <th class="num" style="text-align:right;">Sum of Gross GP</th>
                    </tr>
                </thead>
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
                <thead>
                    <tr>
                        <th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th>
                        <th class="num" style="text-align:right;">Sum of Qty</th>
                        <th class="num" style="text-align:right;">Sum of Gross Revenue</th>
                        <th class="num" style="text-align:right;">Sum of Gross GP</th>
                    </tr>
                </thead>
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
                <thead>
                    <tr>
                        <th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th>
                        <th class="num" style="text-align:right;">Sum of Qty</th>
                        <th class="num" style="text-align:right;">Sum of Gross Revenue</th>
                        <th class="num" style="text-align:right;">Sum of Gross GP</th>
                    </tr>
                </thead>
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
                <thead>
                    <tr>
                        <th>Product Family</th><th>Customer</th><th>Material</th><th>DC</th>
                        <th class="num" style="text-align:right;">Sum of Qty</th>
                        <th class="num" style="text-align:right;">Sum of Gross Revenue</th>
                        <th class="num" style="text-align:right;">Sum of Gross GP</th>
                    </tr>
                </thead>
                <tbody id="dc08Body"></tbody>
            </table>
        </div>
    </div>
</div>
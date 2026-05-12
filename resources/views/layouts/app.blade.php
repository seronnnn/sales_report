<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DKJ Sales Tool - Laravel</title>
    
    <!-- SheetJS library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    
    <!-- Fonts - CHANGED TO FORMAL & HIGHLY READABLE (INTER) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@500&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CSRF Token for future backend requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --bg: #f5f8fb;
            --surface: #ffffff;
            --border: #e2e8f0;
            --accent: #2563eb;
            --text: #0f1f36;
            --muted: #64748b;
            --navy: #1B3A6B;
            --navy-dark: #0d1f3c;
            --shadow-md: 0 4px 6px -1px rgba(27,58,107,0.07), 0 2px 4px -2px rgba(27,58,107,0.06);
        }

        body {
            background: var(--bg);
            color: var(--text);
            /* CHANGED TO INTER FONT FAMILY */
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
        }

        .mono { font-family: 'DM Mono', monospace; }

        /* ... Paste all your original CSS rules here... but use Inter for body ... */
        /* [KEEP ALL YOUR OTHER EXISTING CSS RULES BELOW THIS] */

        /* Login Screen Styles */
        #login-wrapper { display: flex; justify-content: center; align-items: center; width: 100vw; height: 100vh; }
        #login-container { background: var(--surface); padding: 40px; border-radius: 12px; box-shadow: var(--shadow-md); text-align: center; width: 100%; max-width: 380px; border: 1px solid var(--border); }
        #login-container h2 { font-size: 24px; font-weight: 800; color: var(--navy); margin-bottom: 5px; font-family: 'Inter', sans-serif; }
        .login-input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid var(--border); border-radius: 8px; font-family: 'Inter', sans-serif; outline: none; transition: border-color 0.2s; }
        .login-input:focus { border-color: var(--navy); }
        .login-btn { width: 100%; padding: 12px; background-color: var(--navy); color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 15px; font-weight: 700; transition: background 0.2s; }
        .login-btn:hover { background-color: var(--navy-dark); }
        #login-error { color: #dc2626; margin-top: 15px; display: none; font-size: 13px; font-weight: 600; }

        /* Main Dashboard Layout */
        #app-wrapper { display: none; width: 100%; min-height: 100vh; }

        /* Sidebar */
        #sidebar { position: fixed; top: 0; left: 0; width: 240px; height: 100vh; background: var(--navy-dark); display: flex; flex-direction: column; z-index: 100; box-shadow: 2px 0 12px rgba(13,31,60,0.15); }
        .sidebar-logo { padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); color: white; font-size: 18px; font-weight: 800; letter-spacing: -0.02em; }
        .nav-label { font-size: 10px; color: #6b8aaa; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; padding: 20px 20px 8px; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; cursor: pointer; color: #94afc8; font-size: 14px; font-weight: 600; border-left: 3px solid transparent; transition: all 0.2s; }
        .nav-item:hover, .nav-item.active { color: #ffffff; background: rgba(255,255,255,0.08); border-left-color: #F5A623; }

        /* Main Content Area */
        #main { margin-left: 240px; width: calc(100% - 240px); background: var(--bg); }
        .topbar { height: 64px; background: var(--surface); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 24px; position: sticky; top: 0; z-index: 50; }

        /* Content Views */
        .content-view { display: none; padding: 24px; }
        .content-view.active { display: block; }
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 20px; margin-bottom: 24px; }
        .section-title { font-size: 18px; font-weight: 800; color: var(--navy); margin-bottom: 6px; }
        .section-sub { font-size: 13px; color: var(--muted); margin-bottom: 20px; }

        /* Buttons & Controls */
        .btn { padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; border: none; font-family: 'Inter', sans-serif; }
        .btn-primary { background: var(--navy); color: white; }
        .btn-primary:hover { background: var(--navy-dark); }
        .btn-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .btn-danger:hover { background: #fecaca; }

        /* File Upload Styling */
        input[type="file"] { font-size: 13px; color: var(--muted); }
        input[type="file"]::file-selector-button { padding: 8px 16px; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer; border: 1px solid var(--border); background: var(--surface); color: var(--navy); margin-right: 12px; }
        input[type="file"]::file-selector-button:hover { background: #eef2ff; }

        /* == ADDED FOR FILTER BUTTONS (dcTaskbar) == */
        .dc-taskbar { display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; }
        .dc-btn { padding: 6px 14px; border-radius: 99px; font-size: 12px; font-weight: 700; cursor: pointer; border: 1px solid var(--border); color: var(--muted); background: var(--surface); transition: all 0.2s; }
        .dc-btn:hover { border-color: var(--accent); color: var(--accent); background: #f0f7ff; }
        .dc-btn.active { background: var(--navy); color: white; border-color: var(--navy); }

        /* == UPDATED TABLE STYLING == */
        .table-container { overflow-x: auto; max-height: 600px; border: 1px solid var(--border); border-radius: 8px; }
        .data-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .data-table thead th { background: #f8fafc; color: var(--muted); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; padding: 12px 16px; text-align: left; position: sticky; top: 0; border-bottom: 2px solid var(--border); white-space: nowrap; }
        .data-table tbody tr { border-bottom: 1px solid var(--border); }
        .data-table tbody tr:hover { background: #f0f6ff; }
        .data-table tbody td { padding: 10px 16px; vertical-align: middle; white-space: nowrap; font-weight: 400; text-align: left; }
        .data-table .num { font-family: 'DM Mono', monospace; font-size: 13.5px; font-weight: 500; text-align: left; }

        /* == ADD THIS TO YOUR <style> BLOCK == */
        #loadingModal {
            display: none; 
            position: fixed; 
            inset: 0; 
            background: rgba(13, 31, 60, 0.7);
            z-index: 9999; 
            justify-content: center; 
            align-items: center; 
            backdrop-filter: blur(4px);
        }
        .spinner {
            width: 40px; 
            height: 40px; 
            border: 3px solid rgba(255,255,255,0.2);
            border-top-color: #ffffff; 
            border-radius: 50%; 
            animation: spin 1s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Sorting Indicators */
        th { cursor: pointer; user-select: none; }
        th:hover { background-color: #e2e8f0; }
        th.sort-asc::after { content: " ↑"; color: var(--accent); font-size: 14px; }
        th.sort-desc::after { content: " ↓"; color: var(--accent); font-size: 14px; }
    </style>
</head>
<body>
    <div id="loadingModal">
    <div style="text-align: center;">
        <div class="spinner mx-auto"></div>
        <div style="color: white; margin-top: 16px; font-weight: 600; font-size: 14px; font-family: 'Inter', sans-serif;">
            Processing Excel Data...
        </div>
    </div>
</div>
    @yield('content')
    @stack('scripts')
</body>
</html>
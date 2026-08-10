<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — RSU Fikri Medika CMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* === RESET === */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        a { text-decoration: none; }
        button { border: none; cursor: pointer; font-family: inherit; background: none; }
        [x-cloak] { display: none !important; }

        /* =============================================
           TAILWIND SHIM — covers all utility classes
           used in child views that aren't compiled
        ============================================= */

        /* Spacing — space-y */
        .space-y-1 > * + * { margin-top: 4px; }
        .space-y-2 > * + * { margin-top: 8px; }
        .space-y-3 > * + * { margin-top: 12px; }
        .space-y-4 > * + * { margin-top: 16px; }
        .space-y-5 > * + * { margin-top: 20px; }
        .space-y-6 > * + * { margin-top: 24px; }
        .space-x-2 > * + * { margin-left: 8px; }
        .space-x-3 > * + * { margin-left: 12px; }

        /* Flex */
        .flex { display: flex; }
        .inline-flex { display: inline-flex; }
        .flex-col { flex-direction: column; }
        .flex-row { flex-direction: row; }
        .flex-wrap { flex-wrap: wrap; }
        .flex-grow { flex-grow: 1; }
        .flex-shrink-0, .shrink-0 { flex-shrink: 0; }
        .items-start { align-items: flex-start; }
        .items-center { align-items: center; }
        .items-end { align-items: flex-end; }
        .justify-start { justify-content: flex-start; }
        .justify-center { justify-content: center; }
        .justify-end { justify-content: flex-end; }
        .justify-between { justify-content: space-between; }
        .gap-1 { gap: 4px; }
        .gap-1\.5 { gap: 6px; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .gap-4 { gap: 16px; }
        .gap-5 { gap: 20px; }
        .gap-6 { gap: 24px; }

        /* Grid */
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        @media (min-width: 640px) {
            .sm\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .sm\:flex-row { flex-direction: row; }
            .sm\:items-center { align-items: center; }
            .sm\:p-5 { padding: 20px; }
            .sm\:p-8 { padding: 32px; }
        }

        /* Display */
        .hidden { display: none; }
        .block { display: block; }
        .inline-block { display: inline-block; }
        .inline { display: inline; }
        .overflow-hidden { overflow: hidden; }
        .overflow-x-auto { overflow-x: auto; }
        .overflow-y-auto { overflow-y: auto; }

        /* Width / Height */
        .w-full { width: 100%; }
        .w-auto { width: auto; }
        .w-4 { width: 16px; }
        .w-5 { width: 20px; }
        .w-6 { width: 24px; }
        .w-8 { width: 32px; }
        .w-9 { width: 36px; }
        .w-10 { width: 40px; }
        .w-12 { width: 48px; }
        .w-14 { width: 56px; }
        .h-4 { height: 16px; }
        .h-5 { height: 20px; }
        .h-6 { height: 24px; }
        .h-8 { height: 32px; }
        .h-9 { height: 36px; }
        .h-10 { height: 40px; }
        .h-12 { height: 48px; }
        .h-14 { height: 56px; }
        .h-full { height: 100%; }
        .min-w-0 { min-width: 0; }
        .max-w-xs { max-width: 20rem; }
        .max-w-sm { max-width: 24rem; }
        .max-w-md { max-width: 28rem; }
        .max-w-lg { max-width: 32rem; }
        .max-h-\[90vh\] { max-height: 90vh; }

        /* Padding */
        .p-2 { padding: 8px; }
        .p-3 { padding: 12px; }
        .p-4 { padding: 16px; }
        .p-5 { padding: 20px; }
        .p-6 { padding: 24px; }
        .p-8 { padding: 32px; }
        .px-2 { padding-left: 8px; padding-right: 8px; }
        .px-3 { padding-left: 12px; padding-right: 12px; }
        .px-3\.5 { padding-left: 14px; padding-right: 14px; }
        .px-4 { padding-left: 16px; padding-right: 16px; }
        .px-5 { padding-left: 20px; padding-right: 20px; }
        .py-0\.5 { padding-top: 2px; padding-bottom: 2px; }
        .py-1 { padding-top: 4px; padding-bottom: 4px; }
        .py-1\.5 { padding-top: 6px; padding-bottom: 6px; }
        .py-2 { padding-top: 8px; padding-bottom: 8px; }
        .py-2\.5 { padding-top: 10px; padding-bottom: 10px; }
        .py-3 { padding-top: 12px; padding-bottom: 12px; }
        .py-3\.5 { padding-top: 14px; padding-bottom: 14px; }
        .pb-3 { padding-bottom: 12px; }
        .pb-4 { padding-bottom: 16px; }
        .pt-3 { padding-top: 12px; }
        .pt-4 { padding-top: 16px; }

        /* Margin */
        .mt-0\.5 { margin-top: 2px; }
        .mt-1 { margin-top: 4px; }
        .mt-2 { margin-top: 8px; }
        .mt-3 { margin-top: 12px; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 12px; }
        .mx-auto { margin-left: auto; margin-right: auto; }

        /* Border Radius */
        .rounded { border-radius: 4px; }
        .rounded-md { border-radius: 6px; }
        .rounded-lg { border-radius: 8px; }
        .rounded-xl { border-radius: 12px; }
        .rounded-2xl { border-radius: 16px; }
        .rounded-3xl { border-radius: 24px; }
        .rounded-full { border-radius: 9999px; }

        /* Border */
        .border { border: 1px solid; }
        .border-0 { border: none; }
        .border-b { border-bottom: 1px solid; }
        .border-t { border-top: 1px solid; }
        .border-slate-100 { border-color: #f1f5f9; }
        .border-slate-200 { border-color: #e2e8f0; }
        .border-slate-300 { border-color: #cbd5e1; }
        .divide-y > * + * { border-top-width: 1px; border-top-style: solid; }
        .divide-slate-100 > * + * { border-top-color: #f1f5f9; }

        /* Shadow */
        .shadow { box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06); }
        .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .shadow-sm { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .shadow-md { box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); }
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }

        /* Typography */
        .text-xs { font-size: 12px; line-height: 16px; }
        .text-sm { font-size: 14px; line-height: 20px; }
        .text-base { font-size: 16px; line-height: 24px; }
        .text-lg { font-size: 18px; line-height: 28px; }
        .text-xl { font-size: 20px; line-height: 28px; }
        .text-2xl { font-size: 24px; line-height: 32px; }
        .font-medium { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        .font-extrabold { font-weight: 800; }
        .font-black { font-weight: 900; }
        .font-mono { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; }
        .uppercase { text-transform: uppercase; }
        .lowercase { text-transform: lowercase; }
        .capitalize { text-transform: capitalize; }
        .tracking-wider { letter-spacing: 0.05em; }
        .tracking-widest { letter-spacing: 0.1em; }
        .truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .leading-relaxed { line-height: 1.625; }
        .whitespace-nowrap { white-space: nowrap; }

        /* Text colors */
        .text-white { color: #ffffff; }
        .text-slate-400 { color: #94a3b8; }
        .text-slate-500 { color: #64748b; }
        .text-slate-600 { color: #475569; }
        .text-slate-700 { color: #334155; }
        .text-slate-900 { color: #0f172a; }
        .text-emerald-600 { color: #059669; }
        .text-amber-500 { color: #f59e0b; }
        .text-red-600 { color: #dc2626; }

        /* Background colors */
        .bg-white { background-color: #ffffff; }
        .bg-slate-50 { background-color: #f8fafc; }
        .bg-slate-100 { background-color: #f1f5f9; }
        .bg-slate-200 { background-color: #e2e8f0; }
        .bg-emerald-50 { background-color: #ecfdf5; }
        .bg-emerald-100 { background-color: #d1fae5; }
        .bg-amber-100 { background-color: #fef3c7; }
        .bg-red-100 { background-color: #fee2e2; }

        /* Position */
        .relative { position: relative; }
        .absolute { position: absolute; }
        .fixed { position: fixed; }
        .sticky { position: sticky; }
        .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
        .top-0 { top: 0; }
        .z-50 { z-index: 50; }
        .z-10 { z-index: 10; }

        /* Object fit */
        .object-cover { object-fit: cover; }
        .object-contain { object-fit: contain; }

        /* Cursor */
        .cursor-pointer { cursor: pointer; }

        /* Transition */
        .transition-all { transition: all 0.2s; }
        .transition-colors { transition: color 0.2s, background-color 0.2s; }

        /* Backdrop blur (approximate) */
        .backdrop-blur-xs { backdrop-filter: blur(2px); }

        /* Hover states */
        .hover\:bg-emerald-100:hover { background-color: #d1fae5; }
        .hover\:bg-slate-50\/80:hover { background-color: rgba(248,250,252,0.8); }
        .hover\:bg-slate-200:hover { background-color: #e2e8f0; }
        .hover\:bg-amber-100:hover { background-color: #fef3c7; }
        .hover\:bg-red-100:hover { background-color: #fee2e2; }
        .hover\:shadow-lg:hover { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); }
        .hover\:text-slate-600:hover { color: #475569; }

        /* Focus ring */
        .focus\:ring-2:focus { box-shadow: 0 0 0 2px rgba(14,124,71,0.4); }
        .outline-none { outline: none; }

        /* File input */
        .file\:mr-3::file-selector-button { margin-right: 12px; }
        .file\:py-2::file-selector-button { padding-top: 8px; padding-bottom: 8px; }
        .file\:px-4::file-selector-button { padding-left: 16px; padding-right: 16px; }
        .file\:rounded-xl::file-selector-button { border-radius: 12px; }
        .file\:border-0::file-selector-button { border: none; }
        .file\:text-xs::file-selector-button { font-size: 12px; }
        .file\:font-extrabold::file-selector-button { font-weight: 800; }
        .file\:bg-emerald-50::file-selector-button { background-color: #ecfdf5; }
        .file\:text-\[\#0e7c47\]::file-selector-button { color: #0e7c47; }
        .hover\:file\:bg-emerald-100::file-selector-button:hover { background-color: #d1fae5; }

        /* Modal backdrop */
        .bg-slate-900\/60 { background-color: rgba(15, 23, 42, 0.6); }

        /* Specific one-off values used in views */
        .text-\[11px\] { font-size: 11px; }
        .text-\[10px\] { font-size: 10px; }
        .text-\[10\.5px\] { font-size: 10.5px; }
        .text-\[\#0e7c47\] { color: #0e7c47; }
        .w-1\.5 { width: 6px; }
        .h-1\.5 { height: 6px; }
        .px-2\.5 { padding-left: 10px; padding-right: 10px; }
        .animate-pulse { animation: pulse 2s cubic-bezier(0.4,0,0.6,1) infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }

        /* Table helpers */
        .w-full { width: 100%; }
        .text-left { text-align: left; }
        table { border-collapse: collapse; }

        /* Select & input resets */
        select, input, textarea {
            font-family: 'Inter', -apple-system, sans-serif;
        }

        /* === GLOBAL === */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #1e293b;
            background: #f4f6f8;
            display: flex;
            overflow: hidden;
        }

        /* === SCROLLBAR === */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

        /* =========================================
           SIDEBAR
        ========================================= */
        #sidebar {
            width: 240px;
            min-width: 240px;
            height: 100vh;
            background: #111827;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            flex-shrink: 0;
        }

        /* Brand */
        .sb-brand {
            height: 60px;
            min-height: 60px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 16px;
            border-bottom: 1px solid #1f2937;
        }
        .sb-brand-logo {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #0e7c47;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #fff;
            flex-shrink: 0;
        }
        .sb-brand-logo img {
            width: 22px;
            height: 22px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }
        .sb-brand-info { min-width: 0; }
        .sb-brand-name {
            font-size: 13px;
            font-weight: 700;
            color: #f9fafb;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sb-brand-sub {
            font-size: 10px;
            font-weight: 500;
            color: #6b7280;
            white-space: nowrap;
        }

        /* Nav body */
        .sb-nav {
            flex: 1;
            padding: 12px 10px;
            overflow-y: auto;
        }

        /* Group label */
        .sb-group {
            font-size: 10px;
            font-weight: 600;
            color: #4b5563;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            padding: 16px 6px 6px;
        }
        .sb-group:first-child { padding-top: 4px; }

        /* Nav item */
        .sb-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            color: #9ca3af;
            margin-bottom: 1px;
            transition: background 0.12s, color 0.12s;
        }
        .sb-item:hover {
            background: #1f2937;
            color: #e5e7eb;
        }
        .sb-item.active {
            background: #0e7c47;
            color: #ffffff;
            font-weight: 600;
        }
        .sb-item-icon {
            width: 18px;
            text-align: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        /* User footer */
        .sb-footer {
            border-top: 1px solid #1f2937;
            padding: 12px 10px;
        }
        .sb-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            background: #1f2937;
        }
        .sb-user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #0e7c47;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #fff;
            flex-shrink: 0;
        }
        .sb-user-name {
            font-size: 12.5px;
            font-weight: 600;
            color: #f3f4f6;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sb-user-email {
            font-size: 10.5px;
            color: #6b7280;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* =========================================
           MAIN AREA
        ========================================= */
        #main-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
            min-width: 0;
        }

        /* Topbar */
        #topbar {
            height: 60px;
            min-height: 60px;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            flex-shrink: 0;
            gap: 16px;
        }
        .tb-left {}
        .tb-breadcrumb {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 500;
            color: #9ca3af;
            margin-bottom: 2px;
        }
        .tb-breadcrumb .sep { font-size: 9px; }
        .tb-breadcrumb .curr { color: #0e7c47; font-weight: 600; }
        .tb-title {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.01em;
        }
        .tb-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }
        .tb-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }
        .tb-chip-neutral {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            color: #6b7280;
        }
        .tb-chip-green {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
        }
        .tb-chip-red {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #e11d48;
        }
        .tb-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.12s;
            white-space: nowrap;
        }
        .tb-btn:hover { opacity: 0.85; }
        .tb-btn-green {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
        }
        .tb-btn-red {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #e11d48;
        }

        /* Content scroll area */
        #content-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Flash messages */
        .flash-area { padding: 16px 24px 0; }
        .flash-success {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 15px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 9px;
            color: #15803d;
            font-size: 13px;
            font-weight: 600;
        }
        .flash-error {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 15px;
            background: #fff1f2;
            border: 1px solid #fecdd3;
            border-radius: 9px;
            color: #e11d48;
            font-size: 13px;
            font-weight: 600;
        }

        /* Page content */
        #page-content {
            padding: 24px;
        }

        /* Footer */
        #admin-footer {
            height: 44px;
            min-height: 44px;
            border-top: 1px solid #e5e7eb;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11.5px;
            color: #9ca3af;
            font-weight: 500;
            flex-shrink: 0;
        }

        /* =========================================
           REUSABLE COMPONENT STYLES
        ========================================= */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
        }
        .page-header-title {
            font-size: 19px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.02em;
        }
        .page-header-sub {
            font-size: 13px;
            color: #6b7280;
            margin-top: 2px;
            font-weight: 400;
        }
        .admin-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
        }
        .admin-card-body {
            padding: 20px 24px;
        }
        .admin-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .admin-card-header-title {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }
        .admin-table thead th {
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            padding: 10px 16px;
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-align: left;
            white-space: nowrap;
        }
        .admin-table tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 13px;
            color: #374151;
            vertical-align: middle;
        }
        .admin-table tbody tr:last-child td { border-bottom: none; }
        .admin-table tbody tr:hover td { background: #fafafa; }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.12s, transform 0.1s;
            white-space: nowrap;
            font-family: inherit;
        }
        .btn:hover { opacity: 0.88; }
        .btn:active { transform: scale(0.98); }
        .btn-primary {
            background: #0e7c47;
            color: #ffffff;
            border: 1px solid #0e7c47;
        }
        .btn-secondary {
            background: #ffffff;
            color: #374151;
            border: 1px solid #d1d5db;
        }
        .btn-danger {
            background: #fff1f2;
            color: #e11d48;
            border: 1px solid #fecdd3;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 11.5px;
            border-radius: 6px;
            gap: 5px;
        }
        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 7px;
            font-size: 12.5px;
            cursor: pointer;
            transition: all 0.12s;
        }
        .btn-icon-edit {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }
        .btn-icon-delete {
            background: #fff1f2;
            color: #e11d48;
            border: 1px solid #fecdd3;
        }
        .btn-icon:hover { opacity: 0.8; }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 9px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
        }
        .badge-green { background: #dcfce7; color: #15803d; }
        .badge-red { background: #fff1f2; color: #e11d48; }
        .badge-amber { background: #fef3c7; color: #d97706; }
        .badge-blue { background: #eff6ff; color: #2563eb; }
        .badge-gray { background: #f3f4f6; color: #6b7280; }

        /* Forms */
        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }
        .form-input,
        .form-select,
        .form-textarea {
            display: block;
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            color: #111827;
            font-family: inherit;
            background: #ffffff;
            outline: none;
            transition: border-color 0.12s, box-shadow 0.12s;
        }
        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: #0e7c47;
            box-shadow: 0 0 0 3px rgba(14,124,71,0.1);
        }
        .form-textarea { resize: vertical; min-height: 100px; }
        .form-hint {
            font-size: 11.5px;
            color: #9ca3af;
            margin-top: 4px;
        }

        /* Alerts */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 15px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 18px;
        }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .alert-error { background: #fff1f2; border: 1px solid #fecdd3; color: #e11d48; }
        .alert i { margin-top: 1px; flex-shrink: 0; }

        /* Pagination */
        .pagination-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            border-top: 1px solid #f3f4f6;
            font-size: 12.5px;
            color: #6b7280;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: #9ca3af;
        }
        .empty-state i { font-size: 32px; margin-bottom: 12px; display: block; }
        .empty-state p { font-size: 13px; font-weight: 500; }
    </style>
</head>
<body>

{{-- ==============================
     SIDEBAR
============================== --}}
<aside id="sidebar">

    {{-- Brand --}}
    <div class="sb-brand">
        <div class="sb-brand-logo">
            <i class="fa-solid fa-hospital" style="font-size: 15px;"></i>
        </div>
        <div class="sb-brand-info">
            <div class="sb-brand-name">RSU Fikri Medika</div>
            <div class="sb-brand-sub">Admin CMS</div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sb-nav">

        <div class="sb-group">Utama</div>

        <a href="{{ route('admin.dashboard') }}"
           class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="sb-item-icon"><i class="fa-solid fa-gauge-high"></i></span>
            Dashboard
        </a>
        <a href="{{ route('admin.profile.index') }}"
           class="sb-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <span class="sb-item-icon"><i class="fa-solid fa-hospital"></i></span>
            Profil Rumah Sakit
        </a>
        <a href="{{ route('admin.contact.index') }}"
           class="sb-item {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
            <span class="sb-item-icon"><i class="fa-solid fa-address-book"></i></span>
            Informasi Kontak
        </a>

        <div class="sb-group">Layanan Medis</div>

        <a href="{{ route('admin.doctors.index') }}"
           class="sb-item {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}">
            <span class="sb-item-icon"><i class="fa-solid fa-user-doctor"></i></span>
            Dokter Spesialis
        </a>
        <a href="{{ route('admin.schedules.index') }}"
           class="sb-item {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
            <span class="sb-item-icon"><i class="fa-regular fa-calendar-check"></i></span>
            Jadwal Dokter
        </a>
        <a href="{{ route('admin.polyclinics.index') }}"
           class="sb-item {{ request()->routeIs('admin.polyclinics.*') ? 'active' : '' }}">
            <span class="sb-item-icon"><i class="fa-solid fa-clinic-medical"></i></span>
            Poli / Departemen
        </a>
        <a href="{{ route('admin.services.index') }}"
           class="sb-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
            <span class="sb-item-icon"><i class="fa-solid fa-briefcase-medical"></i></span>
            Fasilitas & Layanan
        </a>

        <div class="sb-group">Media & Publikasi</div>

        <a href="{{ route('admin.news.index') }}"
           class="sb-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
            <span class="sb-item-icon"><i class="fa-regular fa-newspaper"></i></span>
            Berita RS
        </a>
        <a href="{{ route('admin.articles.index') }}"
           class="sb-item {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
            <span class="sb-item-icon"><i class="fa-solid fa-file-medical"></i></span>
            Artikel Kesehatan
        </a>
        <a href="{{ route('admin.galleries.index') }}"
           class="sb-item {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">
            <span class="sb-item-icon"><i class="fa-solid fa-images"></i></span>
            Galeri Foto
        </a>
        <a href="{{ route('admin.banners.index') }}"
           class="sb-item {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
            <span class="sb-item-icon"><i class="fa-solid fa-sliders"></i></span>
            Banner Homepage
        </a>

    </nav>

    {{-- User --}}
    <div class="sb-footer">
        <div class="sb-user">
            <div class="sb-user-avatar">
                <i class="fa-solid fa-user" style="font-size: 12px;"></i>
            </div>
            <div style="min-width:0; flex:1;">
                <div class="sb-user-name">{{ Auth::user()?->name ?? 'Admin' }}</div>
                <div class="sb-user-email">{{ Auth::user()?->email }}</div>
            </div>
        </div>
    </div>

</aside>

{{-- ==============================
     MAIN AREA
============================== --}}
<div id="main-wrap">

    {{-- Topbar --}}
    <header id="topbar">
        <div class="tb-left">
            <div class="tb-breadcrumb">
                <i class="fa-solid fa-house" style="color:#0e7c47; font-size:10px;"></i>
                <span class="sep">›</span>
                <span>CMS Portal</span>
                <span class="sep">›</span>
                <span class="curr">@yield('title', 'Dashboard')</span>
            </div>
            <div class="tb-title">@yield('title', 'Dashboard')</div>
        </div>
        <div class="tb-right">
            <div class="tb-chip tb-chip-neutral">
                <i class="fa-regular fa-calendar-days" style="color:#0e7c47;"></i>
                {{ date('d M Y') }}
            </div>
            <a href="{{ route('home') }}" target="_blank" class="tb-btn tb-btn-green">
                <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:10px;"></i>
                Lihat Website
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="tb-btn tb-btn-red">
                    <i class="fa-solid fa-right-from-bracket" style="font-size:11px;"></i>
                    Keluar
                </button>
            </form>
        </div>
    </header>

    {{-- Scrollable content --}}
    <div id="content-scroll">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="flash-area">
                <div class="flash-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="flash-area">
                <div class="flash-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- Page content --}}
        <div id="page-content">
            @yield('content')
        </div>

        {{-- Footer --}}
        <footer id="admin-footer">
            &copy; {{ date('Y') }} RSU Fikri Medika — Admin CMS Panel
        </footer>

    </div>

</div>

<script>
    window.addEventListener('pageshow', function(e) {
        if (e.persisted || (window.performance && window.performance.navigation.type === 2)) {
            window.location.reload();
        }
    });
</script>
</body>
</html>

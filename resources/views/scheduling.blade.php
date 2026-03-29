<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MindEase — Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1a3c5e;
            --secondary: #2a5c8a;
            --accent: #4a90e2;
            --accent-light: #6bb3ff;
            --accent-dark: #1e5f99;
            --text: #e6f0f7;
            --text-muted: #b8d0e0;
            --card-bg: rgba(255, 255, 255, 0.1);
            --glass: rgba(255, 255, 255, 0.15);
            --sidebar-bg: #0f3a1a;
            --radius: 12px;
            --transition: all 0.3s ease;
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: linear-gradient(135deg, rgba(26, 60, 94, 0.95), rgba(42, 92, 138, 0.95));
            color: var(--text);
            line-height: 1.5;
            height: 100vh;
            overflow: hidden;
            display: flex;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, rgba(26, 60, 94, 0.95), rgba(42, 92, 138, 0.95));
            height: 100vh;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }
        
        .logo {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
        }
        
        .brand-text h1 {
            margin: 0;
            font-size: 20px;
            background: linear-gradient(to right, #ffffff, var(--accent-light));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .brand-text p {
            margin: 0;
            font-size: 12px;
            color: var(--text-muted);
        }
        
        .nav-links {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding: 0 15px;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 8px;
            transition: var(--transition);
        }
        
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .nav-item.active {
            background: rgba(74, 144, 226, 0.2);
            color: var(--accent-light);
            border-left: 3px solid var(--accent);
        }
        
        .nav-item i {
            width: 20px;
            text-align: center;
        }
        
        .admin-profile {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .admin-info h3 {
            font-size: 14px;
            margin-bottom: 2px;
        }
        
        .admin-info p {
            font-size: 12px;
            color: var(--text-muted);
        }
        
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }
        
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .page-title h1 { font-size: 24px; margin-bottom: 5px; }
        .page-title p { color: var(--text-muted); font-size: 14px; }
        
        .admin-actions { display: flex; gap: 15px; }
        
        .notification-btn, .logout-btn {
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255, 255, 255, 0.1); color: var(--text-muted);
            text-decoration: none; transition: var(--transition);
        }
        
        .notification-btn:hover, .logout-btn:hover {
            background: rgba(255, 255, 255, 0.2); color: white;
        }
        
        .notification-btn { position: relative; }
        
        .notification-badge {
            position: absolute; top: -2px; right: -2px;
            background: #e74c3c; color: white; border-radius: 50%;
            width: 18px; height: 18px; font-size: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        
        .admin-notif-dropdown {
            position: absolute; right: 0; top: 50px; width: 320px; z-index: 9999;
            background: rgba(26,60,94,0.98); border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.4);
            backdrop-filter: blur(12px); overflow: hidden;
        }
        .admin-notif-header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 14px 16px; border-bottom: 1px solid rgba(255,255,255,0.1);
            color: white; font-weight: 600; font-size: 14px;
        }
        .admin-notif-item {
            padding: 12px 16px; border-bottom: 1px solid rgba(255,255,255,0.06);
            cursor: pointer; transition: background 0.2s;
        }
        .admin-notif-item:hover { background: rgba(255,255,255,0.07); }
        .admin-notif-item.unread { border-left: 3px solid #3b9ddd; }
        .admin-notif-item .notif-title { color: #e8f4fd; font-size: 13px; font-weight: 600; margin-bottom: 3px; }
        .admin-notif-item .notif-msg { color: #7fa8c9; font-size: 12px; margin-bottom: 4px; }
        .admin-notif-item .notif-time { color: #4a7fa5; font-size: 11px; }
        
        .scheduling-content { flex: 1; padding: 30px; overflow-y: auto; }
        
        .content-header {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 25px;
        }
        
        .content-tabs { display: flex; gap: 10px; }
        
        .tab-btn {
            padding: 10px 20px; border-radius: 20px;
            background: rgba(255, 255, 255, 0.1); color: var(--text-muted);
            border: none; cursor: pointer; transition: var(--transition);
            font-weight: 500;
        }
        
        .tab-btn.active { background: var(--accent); color: white; }
        .tab-btn:hover:not(.active) { background: rgba(255, 255, 255, 0.2); color: white; }
        
        .action-buttons { display: flex; gap: 15px; }
        
        .btn {
            padding: 12px 24px; border-radius: 8px; border: none;
            font-weight: 600; cursor: pointer; transition: var(--transition);
            display: flex; align-items: center; gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            color: white; box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.6);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
        }
        
        .btn-secondary:hover { background: rgba(255, 255, 255, 0.2); }
        
        .content-section {
            background: var(--card-bg); border-radius: var(--radius);
            padding: 25px; border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px); margin-bottom: 30px;
        }
        
        .schedules-table { width: 100%; border-collapse: collapse; }
        
        .schedules-table th {
            text-align: left; padding: 12px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-muted); font-weight: 500; font-size: 14px;
        }
        
        .schedules-table td {
            padding: 15px; border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .status-badge {
            padding: 5px 10px; border-radius: 20px;
            font-size: 12px; font-weight: 500;
        }
        
        .status-upcoming { background: rgba(46, 204, 113, 0.2); color: #2ecc71; }
        .status-completed { background: rgba(52, 152, 219, 0.2); color: #3498db; }
        .status-pending { background: rgba(241, 196, 15, 0.2); color: #f1c40f; }
        .status-denied { background: rgba(231, 76, 60, 0.2); color: #e74c3c; }
        .status-cancelled { background: rgba(127, 140, 141, 0.25); color: #95a5a6; }
        .status-reschedule { background: rgba(155, 89, 182, 0.2); color: #9b59b6; }
        
        .action-buttons-cell { display: flex; gap: 8px; }
        
        /* Icon Action Buttons */
        .btn-action {
            width: 35px;
            height: 35px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            font-size: 14px;
        }

        .btn-action i {
            color: white;
        }

        .btn-action.view {
            background: rgba(52, 152, 219, 0.2);
            color: white;
        }

        .btn-action.view:hover {
            background: rgba(52, 152, 219, 0.3);
            transform: translateY(-2px);
        }

        .btn-action.done {
            background: rgba(46, 204, 113, 0.2);
            color: white;
        }

        .btn-action.done:hover {
            background: rgba(46, 204, 113, 0.3);
            transform: translateY(-2px);
        }

        .btn-action.accept {
            background: rgba(46, 204, 113, 0.2);
            color: white;
        }

        .btn-action.accept:hover {
            background: rgba(46, 204, 113, 0.3);
            transform: translateY(-2px);
        }

        .btn-action.deny {
            background: rgba(231, 76, 60, 0.2);
            color: white;
        }

        .btn-action.deny:hover {
            background: rgba(231, 76, 60, 0.3);
            transform: translateY(-2px);
        }

        .btn-action.resched {
            background: rgba(241, 196, 15, 0.2);
            color: white;
        }

        .btn-action.resched:hover {
            background: rgba(241, 196, 15, 0.3);
            transform: translateY(-2px);
        }
        
        /* Text Action Buttons */
        .action-btn {
            padding: 8px 16px; border-radius: 6px; border: none;
            font-weight: 500; cursor: pointer; transition: var(--transition);
            font-size: 13px;
        }
        
        .view-btn { background: rgba(52, 152, 219, 0.2); color: #3498db; }
        .view-btn:hover { background: rgba(52, 152, 219, 0.3); transform: translateY(-1px); }
        
        .done-btn { background: rgba(46, 204, 113, 0.2); color: #2ecc71; }
        .done-btn:hover { background: rgba(46, 204, 113, 0.3); transform: translateY(-1px); }
        
        .empty-state {
            text-align: center; padding: 40px 20px; color: var(--text-muted);
        }
        
        .empty-state i { font-size: 48px; margin-bottom: 15px; opacity: 0.5; }
        .empty-state h3 { margin-bottom: 10px; font-size: 18px; }
        
        .search-container {
            margin-bottom: 20px;
            position: relative;
        }
        
        .search-input {
            width: 100%;
            padding: 12px 15px 12px 40px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--radius);
            color: var(--text);
            font-size: 14px;
            transition: var(--transition);
        }
        
        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            gap: 10px;
        }
        
        .pagination-btn {
            padding: 8px 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--radius);
            color: var(--text);
            cursor: pointer;
            transition: var(--transition);
        }
        
        .pagination-btn:hover:not(:disabled) {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .pagination-info {
            color: var(--text-muted);
            font-size: 14px;
        }
        
        /* Modal Styles */
        .modal {
            display: none; position: fixed; top: 0; left: 0;
            width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7);
            z-index: 3000; align-items: center; justify-content: center;
        }
        
        .modal-content {
            background: var(--card-bg); border-radius: var(--radius);
            width: 90%; max-width: 900px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px); overflow: hidden;
            max-height: 90vh; overflow-y: auto;
        }
        
        .modal-header {
            padding: 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex; justify-content: space-between; align-items: center;
        }
        
        .modal-header h2 { font-size: 20px; }
        
        .close-modal {
            background: none; border: none; color: var(--text-muted);
            font-size: 20px; cursor: pointer; transition: var(--transition);
        }
        
        .close-modal:hover { color: white; }
        
        .modal-body { padding: 20px; }
        
        .calendar-container {
            display: grid; grid-template-columns: 1fr 1fr; gap: 30px;
        }
        
        .calendar-header {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 15px;
        }
        
        .calendar-nav { display: flex; gap: 10px; }
        
        .calendar-nav-btn {
            width: 36px; height: 36px; border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255, 255, 255, 0.1); color: var(--text-muted);
            border: none; cursor: pointer; transition: var(--transition);
        }
        
        .calendar-nav-btn:hover {
            background: rgba(255, 255, 255, 0.2); color: white;
        }
        
        .calendar-grid {
            display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px;
        }
        
        .calendar-day-header {
            text-align: center; padding: 10px; font-weight: 500;
            color: var(--text-muted); font-size: 14px;
        }
        
        .calendar-day {
            aspect-ratio: 1; display: flex; align-items: center;
            justify-content: center; border-radius: 6px;
            cursor: pointer; transition: var(--transition); font-weight: 500;
        }
        
        .calendar-day.available { background: rgba(255, 255, 255, 0.05); }
        .calendar-day.available:hover { background: rgba(74, 144, 226, 0.2); }
        .calendar-day.selected { background: var(--accent); color: white; }
        .calendar-day.unavailable {
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-muted); cursor: not-allowed;
        }
        
        .time-slots {
            display: grid; grid-template-columns: repeat(2, 1fr);
            gap: 10px; margin-top: 15px;
        }
        
        .time-slot {
            padding: 12px; border-radius: 6px;
            background: rgba(255, 255, 255, 0.05);
            text-align: center; cursor: pointer; transition: var(--transition);
        }
        
        .time-slot:hover { background: rgba(255, 255, 255, 0.1); }
        .time-slot.selected { background: var(--accent); color: white; }
        .time-slot.booked {
            background: rgba(231, 76, 60, 0.2); color: #e74c3c;
            cursor: not-allowed;
        }
        
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block; margin-bottom: 8px; font-weight: 500;
        }
        
        .form-control {
            width: 100%; padding: 12px 15px; border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: var(--text); font-size: 15px;
        }
        
        .form-control:focus {
            outline: none; border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }
        
        .duration-select { display: flex; gap: 10px; }
        
        .duration-option {
            flex: 1; padding: 10px; border-radius: 6px;
            background: rgba(255, 255, 255, 0.05);
            text-align: center; cursor: pointer; transition: var(--transition);
        }
        
        .duration-option:hover { background: rgba(255, 255, 255, 0.1); }
        .duration-option.selected { background: var(--accent); color: white; }
        
        .selected-schedule {
            background: rgba(74, 144, 226, 0.1);
            border-radius: 8px; padding: 15px; margin-top: 20px;
        }
        
        .schedule-detail {
            display: flex; justify-content: space-between; margin-bottom: 8px;
        }
        
        .schedule-label { color: var(--text-muted); }
        
        .modal-footer {
            padding: 20px; border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex; justify-content: flex-end; gap: 10px;
        }
        
        .alert {
            padding: 15px; border-radius: 8px; margin-bottom: 20px;
        }
        
        .alert-success { background: #27ae60; color: white; }
        .alert-error { background: #e74c3c; color: white; }
        
        .user-detail-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
            margin-bottom: 20px;
        }
        
        .detail-group { margin-bottom: 15px; }
        .detail-label {
            font-weight: 500; color: var(--text-muted);
            font-size: 14px; margin-bottom: 5px;
        }
        .detail-value { font-size: 16px; }
        
        .history-section { margin-top: 20px; }
        .history-label { font-weight: 500; margin-bottom: 10px; }
        
        .history-list {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px; padding: 15px; max-height: 300px; overflow-y: auto;
        }
        
        .history-item {
            padding: 10px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .history-item:last-child { border-bottom: none; }
        
        .autocomplete-container {
            position: relative;
        }
        
        .autocomplete-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: rgba(26, 60, 94, 0.98);
            border: 1px solid rgba(74, 144, 226, 0.3);
            border-radius: 8px;
            margin-top: 5px;
            max-height: 150px; /* FIXED: Show max 3 items (50px each) with scroll */
            overflow-y: auto;
            z-index: 1000;
            display: none;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        .autocomplete-dropdown::-webkit-scrollbar {
            width: 6px;
        }
        
        .autocomplete-dropdown::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        
        .autocomplete-dropdown::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 3px;
        }
        
        .autocomplete-item {
            padding: 12px 15px;
            cursor: pointer;
            transition: var(--transition);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .autocomplete-item:hover {
            background: rgba(74, 144, 226, 0.2);
        }
        
        .autocomplete-item:last-child {
            border-bottom: none;
        }
        
        .autocomplete-item-name {
            font-weight: 500;
            color: white;
            font-size: 14px;
        }
        
        .autocomplete-item-id {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 4px;
        }
        
        /* Custom scrollbar */
        .scheduling-content::-webkit-scrollbar,
        .modal-content::-webkit-scrollbar,
        .history-list::-webkit-scrollbar {
            width: 6px;
        }
        
        .scheduling-content::-webkit-scrollbar-track,
        .modal-content::-webkit-scrollbar-track,
        .history-list::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1); border-radius: 3px;
        }
        
        .scheduling-content::-webkit-scrollbar-thumb,
        .modal-content::-webkit-scrollbar-thumb,
        .history-list::-webkit-scrollbar-thumb {
            background: var(--accent); border-radius: 3px;
        }
        
        .scheduling-content::-webkit-scrollbar-thumb:hover,
        .modal-content::-webkit-scrollbar-thumb:hover,
        .history-list::-webkit-scrollbar-thumb:hover {
            background: var(--accent-light);
        }

        #archiveSchedules .schedules-table td, #archiveSchedules .schedules-table th {
            color: #e6f0f7;
        }
        #archiveSchedules .empty-state h3, #archiveSchedules .empty-state p {
            color: #e6f0f7;
        }
        #archiveSchedules .status-badge.status-completed {
            color: #fff !important;
        }
        #archiveSchedules .action-btn.view-btn {
            color: #fff !important;
        }
    </style>
</head>
<body>
    @include('components.navigation')
    
    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>Scheduling</h1>
                <p>Manage student counseling schedules and appointments</p>
            </div>
            
            <div class="admin-actions">
                <!-- Bell notification is now in the sidebar navigation -->
            </div>
        </div>
        
        <div class="scheduling-content">
            @if (session('success'))
                <div id="successAlert" class="alert alert-success" style="transition: opacity 0.5s ease-out;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>Error:</strong>
                    <ul style="margin-left:20px; margin-top:10px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="content-header">
                <div class="content-tabs">
                    <button class="tab-btn active" data-tab="upcoming" onclick="switchTab('upcoming')">Upcoming Schedules</button>
                    <button class="tab-btn" data-tab="archive" onclick="switchTab('archive')">Archive</button>
                </div>
                <div class="action-buttons">
                    <button class="btn btn-primary" onclick="openAddScheduleModal()">
                        <i class="fas fa-plus"></i>
                        Add Schedule
                    </button>
                </div>
            </div>
            
            <div class="content-section" id="upcomingSchedules">
                <!-- Search Input -->
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search schedules by name, date, or status..." id="scheduleSearch">
                </div>
                
                <table class="schedules-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Scheduled Date</th>
                            <th>Scheduled Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="schedulesTableBody">
                        <!-- Schedule rows will be populated by JavaScript -->
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <div class="pagination">
                    <button class="pagination-btn" id="prevSchedulePage" disabled>Previous</button>
                    <span class="pagination-info" id="schedulePageInfo">Page 1 of 1</span>
                    <button class="pagination-btn" id="nextSchedulePage" disabled>Next</button>
                </div>
            </div>
            
            <div class="content-section" id="archiveSchedules" style="display: none;">
                <!-- Search Input -->
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search archived schedules..." id="archiveSearch">
                </div>
                
                <table class="schedules-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Scheduled Date</th>
                            <th>Scheduled Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="archiveTableBody">
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-archive"></i>
                                    <h3>No Archived Schedules</h3>
                                    <p>Completed schedules will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Add Schedule Modal -->
    <div class="modal" id="addScheduleModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Schedule</h2>
                <button class="close-modal">&times;</button>
            </div>
            <form method="POST" action="{{ route('scheduling.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="calendar-container">
                        <div class="calendar-section">
                            <div class="calendar-header">
                                <h3 id="currentMonth"></h3>
                                <div class="calendar-nav">
                                    <button type="button" class="calendar-nav-btn" id="prevMonth">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="calendar-nav-btn" id="nextMonth">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="calendar-grid" id="calendarGrid"></div>
                            
                            <div class="form-group">
                                <label>Available Time Slots</label>
                                <div class="time-slots" id="timeSlots"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="form-group">
                                <label for="schoolId">School ID</label>
                                <div class="autocomplete-container">
                                    <input type="text" name="schoolId" id="schoolId" class="form-control" placeholder="Type to search..." autocomplete="off" required>
                                    <div class="autocomplete-dropdown" id="autocompleteDropdown"></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Session Duration</label>
                                <div class="duration-select">
                                    <div class="duration-option selected" data-duration="60">1 hour</div>
                                    <div class="duration-option" data-duration="90">1.5 hours</div>
                                </div>
                            </div>
                            
                            <div class="selected-schedule" id="selectedSchedule" style="display: none;">
                                <h4>Selected Schedule</h4>
                                <div class="schedule-detail">
                                    <span class="schedule-label">Date:</span>
                                    <span id="selectedDateDisplay">-</span>
                                </div>
                                <div class="schedule-detail">
                                    <span class="schedule-label">Time:</span>
                                    <span id="selectedTimeDisplay">-</span>
                                </div>
                                <div class="schedule-detail">
                                    <span class="schedule-label">Duration:</span>
                                    <span id="selectedDurationDisplay">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="date" id="selectedDate">
                    <input type="hidden" name="time" id="selectedTime">
                    <input type="hidden" name="duration" id="selectedDuration" value="60">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelAddSchedule">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm Schedule</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Schedule Modal -->
    <div class="modal" id="viewScheduleModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Student Details</h2>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="user-detail-grid">
                    <div class="detail-group">
                        <div class="detail-label">Name</div>
                        <div class="detail-value" id="viewName">-</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">School ID</div>
                        <div class="detail-value" id="viewSchoolId">-</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Email</div>
                        <div class="detail-value" id="viewEmail">-</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Program</div>
                        <div class="detail-value" id="viewProgram">-</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Year</div>
                        <div class="detail-value" id="viewYear">-</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Section</div>
                        <div class="detail-value" id="viewSection">-</div>
                    </div>
                </div>
                
                <div class="history-section">
                    <div class="history-label">Schedule History</div>
                    <div class="history-list" id="scheduleHistory"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary close-modal">Close</button>
            </div>
        </div>
    </div>

    <!-- Reschedule Modal -->
    <div class="modal" id="rescheduleModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Reschedule Appointment</h2>
                <button class="close-modal">&times;</button>
            </div>
            <form method="POST" id="rescheduleForm" action="">
                @csrf
                <div class="modal-body">
                    <div class="calendar-container">
                        <div class="calendar-section">
                            <div class="calendar-header">
                                <h3 id="reschCalendarMonth"></h3>
                                <div class="calendar-nav">
                                    <button type="button" class="calendar-nav-btn" id="reschPrevMonth">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="calendar-nav-btn" id="reschNextMonth">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="calendar-grid" id="reschCalendarGrid"></div>

                            <div class="form-group">
                                <label>Available Time Slots</label>
                                <div class="time-slots" id="reschTimeSlots"></div>
                            </div>
                        </div>

                        <div>
                            <div class="form-group">
                                <label>Session Duration</label>
                                <div class="duration-select" id="reschDurationSelect">
                                    <div class="duration-option selected" data-duration="60">1 hour</div>
                                    <div class="duration-option" data-duration="90">1.5 hours</div>
                                </div>
                            </div>

                            <div class="selected-schedule" id="reschSelectedSchedule" style="display: none;">
                                <h4>New Schedule</h4>
                                <div class="schedule-detail">
                                    <span class="schedule-label">Date:</span>
                                    <span id="reschSelectedDateDisplay">-</span>
                                </div>
                                <div class="schedule-detail">
                                    <span class="schedule-label">Time:</span>
                                    <span id="reschSelectedTimeDisplay">-</span>
                                </div>
                                <div class="schedule-detail">
                                    <span class="schedule-label">Duration:</span>
                                    <span id="reschSelectedDurationDisplay">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="date" id="reschSelectedDate">
                    <input type="hidden" name="time" id="reschSelectedTime">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeRescheduleModal()">Cancel</button>
                    <button type="button" class="btn" id="reschDenyBtn" style="background: rgba(231,76,60,0.8); color: white;" onclick="denyFromReschedule()">
                        <i class="fas fa-times" style="margin-right: 6px;"></i> Deny
                    </button>
                    <button type="button" class="btn" id="reschAcceptBtn" style="background: rgba(46,204,113,0.8); color: white;" onclick="acceptFromReschedule()">
                        <i class="fas fa-check" style="margin-right: 6px;"></i> Accept
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-alt" style="margin-right: 6px;"></i> Confirm Reschedule
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Schedule data from Laravel
        const schedules = [
            @foreach($schedules as $schedule)
            {
                id: {{ $schedule->id }},
                name: @json($schedule->userAccount->name),
                date: @json(\Carbon\Carbon::parse($schedule->date)->format('F d, Y')),
                rawDate: @json($schedule->date),
                time: @json(\Carbon\Carbon::parse($schedule->time)->format('g:i A')),
                rawTime: @json($schedule->time),
                duration: @json($schedule->duration),
                status: @json($schedule->status),
                proposedDate: @json($schedule->proposed_date ? \Carbon\Carbon::parse($schedule->proposed_date)->format('F d, Y') : null),
                proposedTime: @json($schedule->proposed_time ? \Carbon\Carbon::parse($schedule->proposed_time)->format('g:i A') : null)
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ];

        console.log('Scheduling page JavaScript loaded. Schedules count:', schedules.length);

        // Format duration from minutes to human-readable
        function formatDuration(minutes) {
            const mins = parseInt(minutes);
            if (mins >= 60) {
                const hours = Math.floor(mins / 60);
                const remainMins = mins % 60;
                return remainMins > 0 ? `${hours}h ${remainMins}m` : `${hours}h`;
            }
            return `${mins}m`;
        }

        // Pagination variables
        let scheduleCurrentPage = 1;
        const scheduleRowsPerPage = 5;
        // Exclude Denied (moves to archive) and Completed from upcoming
        let filteredSchedules = schedules.filter(s => s.status !== 'Completed' && s.status !== 'Denied');

        // DOM elements
        const scheduleSearchInput = document.getElementById('scheduleSearch');
        const scheduleTableBody = document.getElementById('schedulesTableBody');
        const prevSchedulePageBtn = document.getElementById('prevSchedulePage');
        const nextSchedulePageBtn = document.getElementById('nextSchedulePage');
        const schedulePageInfo = document.getElementById('schedulePageInfo');

        // Function to render schedules table
        function renderScheduleTable() {
            scheduleTableBody.innerHTML = '';

            // filteredSchedules already excludes Completed + Denied
            const startIndex = (scheduleCurrentPage - 1) * scheduleRowsPerPage;
            const endIndex = startIndex + scheduleRowsPerPage;
            const paginatedSchedules = filteredSchedules.slice(startIndex, endIndex);
            
            if (paginatedSchedules.length === 0) {
                scheduleTableBody.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted);">
                            No schedules found matching your search
                        </td>
                    </tr>
                `;
            } else {
                paginatedSchedules.forEach(schedule => {
                    const row = document.createElement('tr');
                    row.setAttribute('data-schedule-id', schedule.id);

                    let statusClass = 'status-upcoming';
                    if (schedule.status === 'Pending') statusClass = 'status-pending';
                    else if (schedule.status === 'Denied') statusClass = 'status-denied';
                    else if (schedule.status === 'Reschedule in Process') statusClass = 'status-reschedule';
                    else if (schedule.status === 'Student Reschedule Request') statusClass = 'status-reschedule';
                    
                    let actionButtons = '';
                    if (schedule.status === 'Pending') {
                        actionButtons = `
                            <button class="btn-action view" onclick="viewSchedule(${schedule.id})" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-action accept" onclick="acceptSchedule(${schedule.id})" title="Accept">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn-action resched" onclick="openRescheduleModal(${schedule.id}, '${schedule.rawDate}', '${schedule.rawTime}')" title="Reschedule / Deny">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        `;
                    } else if (schedule.status === 'Upcoming') {
                        actionButtons = `
                            <button class="btn-action view" onclick="viewSchedule(${schedule.id})" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <form method="POST" action="/scheduling/${schedule.id}/complete" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-action done" title="Mark as Done">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <button class="btn-action resched" onclick="openRescheduleModal(${schedule.id}, '${schedule.rawDate}', '${schedule.rawTime}')" title="Reschedule">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        `;
                    } else if (schedule.status === 'Reschedule in Process') {
                        actionButtons = `
                            <button class="btn-action view" onclick="viewSchedule(${schedule.id})" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <span style="font-size:12px;color:var(--text-muted);padding:4px 8px;">Awaiting student response</span>
                        `;
                    } else if (schedule.status === 'Student Reschedule Request') {
                        const propInfo = schedule.proposedDate ? `→ ${schedule.proposedDate} ${schedule.proposedTime}` : '';
                        actionButtons = `
                            <button class="btn-action view" onclick="viewSchedule(${schedule.id})" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-action accept" onclick="acceptStudentReschedule(${schedule.id})" title="Approve Reschedule">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn-action deny" onclick="denyStudentReschedule(${schedule.id})" title="Deny Reschedule">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                    }

                    row.innerHTML = `
                        <td>${schedule.name}</td>
                        <td>
                            ${schedule.date}
                            ${schedule.status === 'Student Reschedule Request' && schedule.proposedDate ? `<div style="font-size:11px;color:#9b59b6;margin-top:3px;"><i class="fas fa-arrow-right"></i> Proposed: ${schedule.proposedDate} ${schedule.proposedTime}</div>` : ''}
                        </td>
                        <td>${schedule.time}</td>
                        <td>${formatDuration(schedule.duration)}</td>
                        <td><span class="status-badge ${statusClass}">${schedule.status}</span></td>
                        <td>
                            <div class="action-buttons-cell">
                                ${actionButtons}
                            </div>
                        </td>
                    `;
                    scheduleTableBody.appendChild(row);
                });
            }
            
            updateSchedulePagination();
        }

        function updateSchedulePagination() {
            const totalPages = Math.ceil(filteredSchedules.length / scheduleRowsPerPage);
            schedulePageInfo.textContent = `Page ${scheduleCurrentPage} of ${totalPages}`;
            prevSchedulePageBtn.disabled = scheduleCurrentPage === 1;
            nextSchedulePageBtn.disabled = scheduleCurrentPage === totalPages || totalPages === 0;
        }

        function filterSchedules() {
            const searchTerm = scheduleSearchInput.value.toLowerCase();
            
            // Base: exclude Completed, Denied, Cancelled from main view
            const baseSchedules = schedules.filter(s => s.status !== 'Completed' && s.status !== 'Denied' && s.status !== 'Cancelled');
            
            if (searchTerm === '') {
                filteredSchedules = baseSchedules;
            } else {
                filteredSchedules = baseSchedules.filter(schedule => 
                    schedule.name.toLowerCase().includes(searchTerm) ||
                    schedule.date.toLowerCase().includes(searchTerm) ||
                    schedule.status.toLowerCase().includes(searchTerm)
                );
            }
            
            scheduleCurrentPage = 1;
            renderScheduleTable();
        }

        scheduleSearchInput.addEventListener('input', filterSchedules);
        
        prevSchedulePageBtn.addEventListener('click', () => {
            if (scheduleCurrentPage > 1) {
                scheduleCurrentPage--;
                renderScheduleTable();
            }
        });
        
        nextSchedulePageBtn.addEventListener('click', () => {
            const totalPages = Math.ceil(filteredSchedules.length / scheduleRowsPerPage);
            if (scheduleCurrentPage < totalPages) {
                scheduleCurrentPage++;
                renderScheduleTable();
            }
        });

        // Archive table rendering
        function renderArchiveTable(searchTerm = '') {
            const archiveTableBody = document.getElementById('archiveTableBody');
            archiveTableBody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:20px;color:var(--text-muted);">Loading...</td></tr>';
            fetch('/scheduling-archive')
                .then(response => response.json())
                .then(archiveSchedules => {
                    if (searchTerm) {
                        archiveSchedules = archiveSchedules.filter(sch =>
                            sch.user_account.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                            sch.date.toLowerCase().includes(searchTerm.toLowerCase()) ||
                            sch.status.toLowerCase().includes(searchTerm.toLowerCase())
                        );
                    }
                    if (archiveSchedules.length === 0) {
                        archiveTableBody.innerHTML = `<tr><td colspan="6"><div class="empty-state"><i class="fas fa-archive"></i><h3>No Archived Schedules</h3><p>Completed, denied, and cancelled schedules will appear here.</p></div></td></tr>`;
                    } else {
                        archiveTableBody.innerHTML = '';
                        archiveSchedules.forEach(schedule => {
                            const row = document.createElement('tr');
                            let statusClass = 'status-completed';
                            if (schedule.status === 'Denied') statusClass = 'status-denied';
                            else if (schedule.status === 'Cancelled') statusClass = 'status-cancelled';
                            let actions = `
                                <button class="btn-action view" onclick="viewSchedule(${schedule.id})" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                            `;
                            if (schedule.status === 'Denied') {
                                actions += `
                                    <button class="btn-action accept" onclick="acceptSchedule(${schedule.id})" title="Accept">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn-action resched" onclick="openRescheduleModal(${schedule.id}, '${schedule.rawDate}', '${schedule.rawTime}')" title="Reschedule">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>
                                `;
                            }
                            row.innerHTML = `
                                <td>${schedule.user_account.name}</td>
                                <td>${schedule.date}</td>
                                <td>${schedule.time}</td>
                                <td>${formatDuration(schedule.duration)}</td>
                                <td><span class="status-badge ${statusClass}">${schedule.status}</span></td>
                                <td><div class="action-buttons-cell">${actions}</div></td>
                            `;
                            archiveTableBody.appendChild(row);
                        });
                    }
                });
        }

        // Add search event for archive
        const archiveSearchInput = document.getElementById('archiveSearch');
        archiveSearchInput.addEventListener('input', function() {
            renderArchiveTable(this.value);
        });
        
        // Initial render
        renderScheduleTable();
        renderArchiveTable();

        // Auto-hide success alert
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                setTimeout(() => {
                    successAlert.remove();
                }, 500);
            }, 3000);
        }

        // Auto-hide validation error
                const dateError = document.querySelector('.alert-error');
                if (dateError && dateError.textContent.includes('date field is required')) {
                    setTimeout(() => {
                        dateError.style.opacity = '0';
                        setTimeout(() => {
                            dateError.remove();
                        }, 500);
                    }, 3000);
                }

        // Add logout confirmation (if logout button exists)
        const logoutBtn = document.querySelector('.logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', async function(event) {
                event.preventDefault();
                const confirmed = await showConfirmModal('Logout', 'Are you sure you want to logout?', 'Logout');
                if (confirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }
        
        // School ID Autocomplete
        let userAccounts = [];
        const schoolIdInput = document.getElementById('schoolId');
        const autocompleteDropdown = document.getElementById('autocompleteDropdown');
        
        // Function to display dropdown with filtered users
        function showDropdown(searchTerm = '') {
            const search = searchTerm.toLowerCase().trim();
            const filteredUsers = search.length === 0 
                ? userAccounts 
                : userAccounts.filter(user => 
                    user.schoolId.toLowerCase().includes(search) ||
                    user.name.toLowerCase().includes(search)
                );
            
            if (filteredUsers.length === 0) {
                autocompleteDropdown.style.display = 'none';
                return;
            }
            
            autocompleteDropdown.innerHTML = '';
            filteredUsers.forEach(user => {
                const item = document.createElement('div');
                item.className = 'autocomplete-item';
                item.innerHTML = `
                    <div class="autocomplete-item-name">${user.name}</div>
                    <div class="autocomplete-item-id">ID: ${user.schoolId} • ${user.program}</div>
                `;
                item.addEventListener('click', function() {
                    schoolIdInput.value = user.schoolId;
                    autocompleteDropdown.style.display = 'none';
                });
                autocompleteDropdown.appendChild(item);
            });
            
            autocompleteDropdown.style.display = 'block';
        }
        
        // Fetch user accounts
        fetch('{{ route("scheduling.users") }}')
            .then(response => response.json())
            .then(data => {
                userAccounts = data;
            })
            .catch(error => console.error('Error fetching user accounts:', error));
        
        // Show dropdown on focus
        schoolIdInput.addEventListener('focus', function() {
            showDropdown(this.value);
        });
        
        // Filter on input
        schoolIdInput.addEventListener('input', function() {
            showDropdown(this.value);
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!schoolIdInput.contains(event.target) && !autocompleteDropdown.contains(event.target)) {
                autocompleteDropdown.style.display = 'none';
            }
        });

        // Calendar and scheduling logic
        let currentDate = new Date();
        let selectedDate = null;
        let selectedTime = null;
        let selectedDuration = 60;
        let bookedSlots = [];

        // Open add schedule modal
        function openAddScheduleModal() {
            console.log('openAddScheduleModal called - button clicked!');
            resetForm();
            document.getElementById('addScheduleModal').style.display = 'flex';
            generateCalendar();
            // Initialize time slots display
            generateTimeSlots();
        }

        // Close all modals
        function closeModals() {
            document.getElementById('addScheduleModal').style.display = 'none';
            document.getElementById('viewScheduleModal').style.display = 'none';
            document.getElementById('rescheduleModal').style.display = 'none';
        }

        // Reschedule modal functions
        let reschCurrentDate = new Date();
        let reschSelectedDate = null;
        let reschSelectedTime = null;
        let reschSelectedDuration = 60;
        let reschBookedSlots = [];
        let reschScheduleId = null;

        function openRescheduleModal(scheduleId, currentDate, currentTime) {
            reschScheduleId = scheduleId;
            document.getElementById('rescheduleForm').action = `/scheduling/${scheduleId}/reschedule`;

            // Reset state
            reschSelectedDate = currentDate;
            reschSelectedTime = currentTime;
            reschCurrentDate = new Date(currentDate + 'T00:00:00');

            // Find the schedule's duration
            const sched = schedules.find(s => s.id === scheduleId);
            reschSelectedDuration = sched ? parseInt(sched.duration) : 60;

            // Set duration option
            document.querySelectorAll('#reschDurationSelect .duration-option').forEach(o => {
                o.classList.remove('selected');
                if (parseInt(o.getAttribute('data-duration')) === reschSelectedDuration) {
                    o.classList.add('selected');
                }
            });

            document.getElementById('reschSelectedDate').value = reschSelectedDate;
            document.getElementById('reschSelectedTime').value = reschSelectedTime;

            document.getElementById('rescheduleModal').style.display = 'flex';
            generateReschCalendar();
            fetchReschBookedSlots(reschSelectedDate);
            updateReschSelectedSchedule();
        }

        function closeRescheduleModal() {
            document.getElementById('rescheduleModal').style.display = 'none';
            reschScheduleId = null;
        }

        function acceptFromReschedule() {
            if (!reschScheduleId) return;
            showConfirmModal('Accept Appointment', 'Are you sure you want to accept this appointment?', 'Accept').then(confirmed => {
                if (!confirmed) return;
                fetch(`/scheduling/${reschScheduleId}/accept`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        updateScheduleInList(data.id, 'Upcoming');
                        closeRescheduleModal();
                        showToastMsg('Appointment accepted. Student notified.', 'success');
                    }
                });
            });
        }

        function denyFromReschedule() {
            if (!reschScheduleId) return;
            showConfirmModal('Deny Appointment', 'Are you sure you want to deny this appointment? The student will be notified.', 'Deny', true).then(confirmed => {
                if (!confirmed) return;
                fetch(`/scheduling/${reschScheduleId}/deny`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        updateScheduleInList(data.id, 'Denied');
                        closeRescheduleModal();
                        renderArchiveTable();
                        showToastMsg('Appointment denied. Student notified.', 'success');
                    }
                });
            });
        }

        // Duration selection for reschedule
        document.querySelectorAll('#reschDurationSelect .duration-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('#reschDurationSelect .duration-option').forEach(o => o.classList.remove('selected'));
                this.classList.add('selected');
                reschSelectedDuration = parseInt(this.getAttribute('data-duration'));
                updateReschSelectedSchedule();
                if (reschSelectedDate) {
                    generateReschTimeSlots();
                }
            });
        });

        // Calendar navigation for reschedule
        document.getElementById('reschPrevMonth')?.addEventListener('click', () => {
            reschCurrentDate.setMonth(reschCurrentDate.getMonth() - 1);
            generateReschCalendar();
        });

        document.getElementById('reschNextMonth')?.addEventListener('click', () => {
            reschCurrentDate.setMonth(reschCurrentDate.getMonth() + 1);
            generateReschCalendar();
        });

        function generateReschCalendar() {
            const year = reschCurrentDate.getFullYear();
            const month = reschCurrentDate.getMonth();
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            document.getElementById('reschCalendarMonth').textContent = reschCurrentDate.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long'
            });

            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();

            const calendarGrid = document.getElementById('reschCalendarGrid');
            calendarGrid.innerHTML = '';

            const dayHeaders = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            dayHeaders.forEach(day => {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day-header';
                dayElement.textContent = day;
                calendarGrid.appendChild(dayElement);
            });

            for (let i = 0; i < firstDay.getDay(); i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day unavailable';
                calendarGrid.appendChild(emptyDay);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                dayElement.textContent = day;

                const date = new Date(year, month, day);
                date.setHours(0, 0, 0, 0);
                const dayOfWeek = date.getDay();
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                if (dayOfWeek === 0 || dayOfWeek === 6 || date < today) {
                    dayElement.className += ' unavailable';
                } else {
                    dayElement.className += ' available';
                    if (reschSelectedDate === dateString) {
                        dayElement.classList.add('selected');
                    }
                    dayElement.addEventListener('click', function() {
                        document.querySelectorAll('#reschCalendarGrid .calendar-day').forEach(d => d.classList.remove('selected'));
                        this.classList.add('selected');
                        reschSelectedDate = dateString;
                        document.getElementById('reschSelectedDate').value = dateString;
                        fetchReschBookedSlots(dateString);
                        updateReschSelectedSchedule();
                    });
                }
                calendarGrid.appendChild(dayElement);
            }
        }

        async function fetchReschBookedSlots(date) {
            try {
                const response = await fetch(`{{ route('scheduling.booked') }}?date=${date}`);
                reschBookedSlots = await response.json();
                generateReschTimeSlots();
            } catch (error) {
                console.error('Error fetching booked slots:', error);
                reschBookedSlots = [];
                generateReschTimeSlots();
            }
        }

        function generateReschTimeSlots() {
            const timeSlots = document.getElementById('reschTimeSlots');

            if (!reschSelectedDate) {
                timeSlots.innerHTML = '<div style="text-align: center; padding: 20px; color: var(--text-muted);">Please select a date first</div>';
                return;
            }

            timeSlots.innerHTML = '';

            const morningSlots = [];
            const afternoonSlots = [];

            for (let hour = 8; hour < 12; hour++) {
                morningSlots.push(`${hour.toString().padStart(2, '0')}:00`);
                morningSlots.push(`${hour.toString().padStart(2, '0')}:30`);
            }
            for (let hour = 13; hour < 17; hour++) {
                afternoonSlots.push(`${hour.toString().padStart(2, '0')}:00`);
                afternoonSlots.push(`${hour.toString().padStart(2, '0')}:30`);
            }

            const allSlots = [...morningSlots, ...afternoonSlots];
            const now = new Date();

            allSlots.forEach(slot => {
                const slotElement = document.createElement('div');
                slotElement.className = 'time-slot';
                slotElement.textContent = formatTime(slot);

                const slotDateTime = new Date(reschSelectedDate + ' ' + slot);
                if (slotDateTime < now) {
                    slotElement.className += ' booked';
                    slotElement.innerHTML = `${formatTime(slot)} <i class="fas fa-times"></i>`;
                    timeSlots.appendChild(slotElement);
                    return;
                }

                const isAvailable = isReschTimeSlotAvailable(slot, reschSelectedDuration);

                if (!isAvailable) {
                    slotElement.className += ' booked';
                    slotElement.innerHTML = `${formatTime(slot)} <i class="fas fa-times"></i>`;
                } else {
                    if (reschSelectedTime === slot) {
                        slotElement.classList.add('selected');
                    }
                    slotElement.addEventListener('click', function() {
                        document.querySelectorAll('#reschTimeSlots .time-slot').forEach(s => s.classList.remove('selected'));
                        this.classList.add('selected');
                        reschSelectedTime = slot;
                        document.getElementById('reschSelectedTime').value = slot;
                        updateReschSelectedSchedule();
                    });
                }
                timeSlots.appendChild(slotElement);
            });
        }

        function isReschTimeSlotAvailable(startTime, duration) {
            const [hours, minutes] = startTime.split(':').map(Number);
            const startMinutes = hours * 60 + minutes;
            const endMinutes = startMinutes + duration;

            if (startMinutes < 12 * 60) {
                if (endMinutes > 12 * 60) return false;
            } else {
                if (endMinutes > 17 * 60) return false;
            }

            for (let i = 0; i < duration; i += 30) {
                const checkMinutes = startMinutes + i;
                const checkHours = Math.floor(checkMinutes / 60);
                const checkMins = checkMinutes % 60;
                const checkTime = `${checkHours.toString().padStart(2, '0')}:${checkMins.toString().padStart(2, '0')}`;
                if (reschBookedSlots.includes(checkTime)) return false;
            }
            return true;
        }

        function updateReschSelectedSchedule() {
            if (reschSelectedDate && reschSelectedTime && reschSelectedDuration) {
                document.getElementById('reschSelectedSchedule').style.display = 'block';
                const dateObj = new Date(reschSelectedDate);
                document.getElementById('reschSelectedDateDisplay').textContent = dateObj.toLocaleDateString('en-US', {
                    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
                });
                document.getElementById('reschSelectedTimeDisplay').textContent = formatTime(reschSelectedTime);
                document.getElementById('reschSelectedDurationDisplay').textContent = reschSelectedDuration === 90 ? '1.5 hours' : '1 hour';
            } else {
                document.getElementById('reschSelectedSchedule').style.display = 'none';
            }
        }
        
        // Tab switching function
        function switchTab(tab) {
            console.log('switchTab called with tab:', tab);
            const upcomingSection = document.getElementById('upcomingSchedules');
            const archiveSection = document.getElementById('archiveSchedules');
            const tabBtns = document.querySelectorAll('.tab-btn');
            
            // Remove active class from all tabs
            tabBtns.forEach(b => b.classList.remove('active'));
            
            // Add active class to clicked tab
            const clickedBtn = document.querySelector(`.tab-btn[data-tab="${tab}"]`);
            if (clickedBtn) {
                clickedBtn.classList.add('active');
            }
            
            if (tab === 'upcoming') {
                upcomingSection.style.display = 'block';
                archiveSection.style.display = 'none';
            } else if (tab === 'archive') {
                upcomingSection.style.display = 'none';
                archiveSection.style.display = 'block';
                renderArchiveTable();
            }
        }
        
        // Close modal buttons
        document.querySelectorAll('.close-modal').forEach(btn => {
            btn.addEventListener('click', closeModals);
        });
        
        // Close modals when clicking outside
        const addScheduleModal = document.getElementById('addScheduleModal');
        const viewScheduleModal = document.getElementById('viewScheduleModal');
        
        addScheduleModal?.addEventListener('click', function(event) {
            if (event.target === addScheduleModal) {
                closeModals();
                resetForm();
            }
        });
        
        viewScheduleModal?.addEventListener('click', function(event) {
            if (event.target === viewScheduleModal) {
                closeModals();
            }
        });

        const rescheduleModal = document.getElementById('rescheduleModal');
        rescheduleModal?.addEventListener('click', function(event) {
            if (event.target === rescheduleModal) {
                closeRescheduleModal();
            }
        });
        
        // Cancel button
        document.getElementById('cancelAddSchedule')?.addEventListener('click', () => {
            closeModals();
            resetForm();
        });
        
        // Calendar navigation
        document.getElementById('prevMonth')?.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            generateCalendar();
        });
        
        document.getElementById('nextMonth')?.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            generateCalendar();
        });
        
        // Duration selection - FIXED to work with clicks
        document.querySelectorAll('.duration-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.duration-option').forEach(o => o.classList.remove('selected'));
                this.classList.add('selected');
                selectedDuration = parseInt(this.getAttribute('data-duration'));
                document.getElementById('selectedDuration').value = selectedDuration;
                updateSelectedSchedule();
                // Regenerate time slots with new duration
                if (selectedDate) {
                    generateTimeSlots();
                }
            });
        });
        
        function generateCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            document.getElementById('currentMonth').textContent = currentDate.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long' 
            });
            
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            
            const calendarGrid = document.getElementById('calendarGrid');
            calendarGrid.innerHTML = '';
            
            // Day headers
            const dayHeaders = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            dayHeaders.forEach(day => {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day-header';
                dayElement.textContent = day;
                calendarGrid.appendChild(dayElement);
            });
            
            // Empty cells before first day
            for (let i = 0; i < firstDay.getDay(); i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day unavailable';
                calendarGrid.appendChild(emptyDay);
            }
            
            // Days of month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                dayElement.textContent = day;
                
                const date = new Date(year, month, day);
                date.setHours(0, 0, 0, 0);
                const dayOfWeek = date.getDay();
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                
                // Check if weekend or past date
                if (dayOfWeek === 0 || dayOfWeek === 6 || date < today) {
                    dayElement.className += ' unavailable';
                } else {
                    dayElement.className += ' available';
                    
                    // Highlight if this is the selected date
                    if (selectedDate === dateString) {
                        dayElement.classList.add('selected');
                    }
                    
                    // FIXED: Properly bind click event
                    dayElement.addEventListener('click', function() {
                        document.querySelectorAll('.calendar-day').forEach(d => {
                            d.classList.remove('selected');
                        });
                        this.classList.add('selected');
                        selectedDate = dateString;
                        document.getElementById('selectedDate').value = dateString;
                        
                        // Fetch booked slots for this date
                        fetchBookedSlotsForDate(dateString);
                        updateSelectedSchedule();
                    });
                }
                
                calendarGrid.appendChild(dayElement);
            }
        }
        
        // FIXED: New function to fetch booked slots when date is selected
        async function fetchBookedSlotsForDate(date) {
            try {
                const response = await fetch(`{{ route('scheduling.booked') }}?date=${date}`);
                bookedSlots = await response.json();
                console.log('Booked slots for', date, ':', bookedSlots);
                // Regenerate time slots with updated booked data
                generateTimeSlots();
            } catch (error) {
                console.error('Error fetching booked slots:', error);
                bookedSlots = [];
                generateTimeSlots();
            }
        }
        
        async function generateTimeSlots() {
            const timeSlots = document.getElementById('timeSlots');
            
            if (!selectedDate) {
                timeSlots.innerHTML = '<div style="text-align: center; padding: 20px; color: var(--text-muted);">Please select a date first</div>';
                return;
            }
            
            if (!selectedDuration) {
                timeSlots.innerHTML = '<div style="text-align: center; padding: 20px; color: var(--text-muted);">Please select a duration first</div>';
                return;
            }
            
            timeSlots.innerHTML = '';
            
            // Generate 30-minute intervals
            // Morning: 8:00 AM - 12:00 NN (extended to allow 2-hour sessions)
            // Afternoon: 1:00 PM - 5:00 PM (extended to allow 2-hour sessions)
            const morningSlots = [];
            const afternoonSlots = [];
            
            // Morning slots (8:00 - 11:30) - slots can start until 11:30 for 30-min sessions
            for (let hour = 8; hour < 12; hour++) {
                morningSlots.push(`${hour.toString().padStart(2, '0')}:00`);
                morningSlots.push(`${hour.toString().padStart(2, '0')}:30`);
            }
            
            // Afternoon slots (13:00 - 16:30) - extended for 2-hour sessions
            for (let hour = 13; hour < 17; hour++) {
                afternoonSlots.push(`${hour.toString().padStart(2, '0')}:00`);
                afternoonSlots.push(`${hour.toString().padStart(2, '0')}:30`);
            }
            
            const allSlots = [...morningSlots, ...afternoonSlots];
            
            const selectedDateTime = new Date(selectedDate + ' 00:00');
            const now = new Date();
            
            allSlots.forEach(slot => {
                const slotElement = document.createElement('div');
                slotElement.className = 'time-slot';
                slotElement.textContent = formatTime(slot);
                
                // Check if slot is in the past
                const slotDateTime = new Date(selectedDate + ' ' + slot);
                if (slotDateTime < now) {
                    slotElement.className += ' booked';
                    slotElement.innerHTML = `${formatTime(slot)} <i class="fas fa-times"></i>`;
                    timeSlots.appendChild(slotElement);
                    return;
                }
                
                // Check if this slot is available based on duration
                const isAvailable = isTimeSlotAvailable(slot, selectedDuration);
                
                if (!isAvailable) {
                    slotElement.className += ' booked';
                    slotElement.innerHTML = `${formatTime(slot)} <i class="fas fa-times"></i>`;
                } else {
                    // Highlight if this is the selected time
                    if (selectedTime === slot) {
                        slotElement.classList.add('selected');
                    }
                    
                    // FIXED: Properly bind click event
                    slotElement.addEventListener('click', function() {
                        document.querySelectorAll('.time-slot').forEach(s => {
                            s.classList.remove('selected');
                        });
                        this.classList.add('selected');
                        selectedTime = slot;
                        document.getElementById('selectedTime').value = slot;
                        updateSelectedSchedule();
                    });
                }
                
                timeSlots.appendChild(slotElement);
            });
        }
        
        function isTimeSlotAvailable(startTime, duration) {
            // Parse the start time
            const [hours, minutes] = startTime.split(':').map(Number);
            const startMinutes = hours * 60 + minutes;
            const endMinutes = startMinutes + duration;
            
            // Check if session would end within allowed hours
            // Morning sessions must end by 12:00 (720 minutes)
            // Afternoon sessions must end by 17:00 (1020 minutes) - extended to 5 PM
            if (startMinutes < 12 * 60) {
                // Morning slot
                if (endMinutes > 12 * 60) {
                    return false; // Would extend past noon
                }
            } else {
                // Afternoon slot
                if (endMinutes > 17 * 60) {
                    return false; // Would extend past 5 PM
                }
            }
            
            // Check if any 30-minute interval in this session is booked
            for (let i = 0; i < duration; i += 30) {
                const checkMinutes = startMinutes + i;
                const checkHours = Math.floor(checkMinutes / 60);
                const checkMins = checkMinutes % 60;
                const checkTime = `${checkHours.toString().padStart(2, '0')}:${checkMins.toString().padStart(2, '0')}`;
                
                if (bookedSlots.includes(checkTime)) {
                    return false; // This interval is booked
                }
            }
            
            return true;
        }
        
        function updateSelectedSchedule() {
            if (selectedDate && selectedTime && selectedDuration) {
                document.getElementById('selectedSchedule').style.display = 'block';
                
                const dateObj = new Date(selectedDate);
                document.getElementById('selectedDateDisplay').textContent = dateObj.toLocaleDateString('en-US', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
                
                document.getElementById('selectedTimeDisplay').textContent = formatTime(selectedTime);
                
                // Display duration text
                let durationText = '1 hour';
                if (selectedDuration === 90) {
                    durationText = '1.5 hours';
                }
                document.getElementById('selectedDurationDisplay').textContent = durationText;
            } else {
                document.getElementById('selectedSchedule').style.display = 'none';
            }
        }
        
        function resetForm() {
            document.getElementById('schoolId').value = '';
            selectedDate = null;
            selectedTime = null;
            selectedDuration = 60;
            bookedSlots = [];
            
            document.querySelectorAll('.calendar-day').forEach(d => {
                d.classList.remove('selected');
            });
            
            document.querySelectorAll('.time-slot').forEach(s => {
                s.classList.remove('selected');
            });
            
            document.querySelectorAll('.duration-option').forEach(o => o.classList.remove('selected'));
            document.querySelectorAll('.duration-option')[0].classList.add('selected');
            
            document.getElementById('selectedSchedule').style.display = 'none';
            document.getElementById('selectedDate').value = '';
            document.getElementById('selectedTime').value = '';
            document.getElementById('selectedDuration').value = '60';
            
            // Reset calendar to current month
            currentDate = new Date();
            
            // Close dropdown (if exists)
            const dropdown = document.getElementById('autocompleteDropdown');
            if (dropdown) {
                dropdown.style.display = 'none';
            }
        }
        
        function formatTime(timeString) {
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes} ${ampm}`;
        }
        
        async function viewSchedule(id) {
            try {
                const response = await fetch(`{{ url('/scheduling') }}/${id}`);
                const data = await response.json();
                
                document.getElementById('viewName').textContent = data.user.name;
                document.getElementById('viewSchoolId').textContent = data.user.schoolId;
                document.getElementById('viewEmail').textContent = data.user.email;
                document.getElementById('viewProgram').textContent = data.user.program;
                document.getElementById('viewYear').textContent = data.user.year + getSuffix(data.user.year) + ' Year';
                document.getElementById('viewSection').textContent = 'Section ' + data.user.section;
                
                // Schedule history
                const historyContainer = document.getElementById('scheduleHistory');
                historyContainer.innerHTML = '';
                
                if (data.history.length === 0) {
                    historyContainer.innerHTML = '<p style="color: var(--text-muted); text-align: center;">No schedule history</p>';
                } else {
                    data.history.forEach(item => {
                        const historyItem = document.createElement('div');
                        historyItem.className = 'history-item';
                        const date = new Date(item.date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                        const time = formatTime(item.time);
                        const duration = formatDuration(item.duration);
                        const statusClass = item.status === 'Pending' ? 'status-pending' : item.status === 'Denied' ? 'status-denied' : item.status === 'Completed' ? 'status-completed' : 'status-upcoming';
                        historyItem.innerHTML = `
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <strong>${date}</strong> at ${time}
                                    <div style="font-size: 12px; color: var(--text-muted);">${duration}</div>
                                </div>
                                <span class="status-badge ${statusClass}">${item.status}</span>
                            </div>
                        `;
                        historyContainer.appendChild(historyItem);
                    });
                }
                
                viewScheduleModal.style.display = 'flex';
            } catch (error) {
                console.error('Error fetching schedule details:', error);
                alert('Error loading schedule details');
            }
        }
        
        function getSuffix(num) {
            const j = num % 10;
            const k = num % 100;
            if (j == 1 && k != 11) return "st";
            if (j == 2 && k != 12) return "nd";
            if (j == 3 && k != 13) return "rd";
            return "th";
        }
        
        // Archive tab initial load handled by renderArchiveTable() call at line 1060
        
        // Initialize calendar on modal open
        generateCalendar();

        // =====================================================================
        // AJAX helper functions
        // =====================================================================

        // Update a schedule's status in the local array and re-render tables
        function updateScheduleInList(id, newStatus) {
            const idx = schedules.findIndex(s => s.id === id);
            if (idx !== -1) schedules[idx].status = newStatus;
            filteredSchedules = schedules.filter(s => s.status !== 'Completed' && s.status !== 'Denied');
            renderScheduleTable();
        }

        // Simple toast notification
        function showToastMsg(msg, type = 'success') {
            const el = document.createElement('div');
            el.style.cssText = `position:fixed;bottom:20px;right:20px;padding:14px 22px;border-radius:8px;color:white;font-weight:600;z-index:99999;backdrop-filter:blur(10px);transition:opacity 0.5s;`;
            el.style.background = type === 'success' ? 'rgba(46,204,113,0.9)' : 'rgba(231,76,60,0.9)';
            el.textContent = msg;
            document.body.appendChild(el);
            setTimeout(() => { el.style.opacity = '0'; setTimeout(() => el.remove(), 500); }, 3000);
        }

        // Accept appointment via AJAX
        async function acceptSchedule(id) {
            const confirmed = await showConfirmModal('Accept Appointment', 'Are you sure you want to accept this appointment? The student will be notified.', 'Accept');
            if (!confirmed) return;
            try {
                const resp = await fetch(`/scheduling/${id}/accept`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await resp.json();
                if (data.success) {
                    updateScheduleInList(id, 'Upcoming');
                    renderArchiveTable(); // refresh archive (removes from there if it was denied)
                    showToastMsg('Appointment accepted. Student notified.');
                }
            } catch(e) { showToastMsg('Error accepting appointment.', 'error'); }
        }

        // Deny appointment via AJAX — moves row to archive in-place
        async function denySchedule(id) {
            const confirmed = await showConfirmModal('Deny Appointment', 'Are you sure you want to deny this appointment? The student will be notified.', 'Deny', true);
            if (!confirmed) return;
            try {
                const resp = await fetch(`/scheduling/${id}/deny`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await resp.json();
                if (data.success) {
                    updateScheduleInList(id, 'Denied'); // removes from upcoming
                    renderArchiveTable(); // adds to archive
                    showToastMsg('Appointment denied. Student notified.');
                }
            } catch(e) { showToastMsg('Error denying appointment.', 'error'); }
        }

        // Intercept reschedule form submit — do AJAX instead of page reload
        document.getElementById('rescheduleForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            if (!reschSelectedDate || !reschSelectedTime) {
                showToastMsg('Please select a date and time.', 'error');
                return;
            }
            const confirmed = await showConfirmModal('Propose Reschedule', 'Propose this new schedule to the student? They will need to accept or cancel it.', 'Propose', false);
            if (!confirmed) return;
            try {
                const resp = await fetch(`/scheduling/${reschScheduleId}/reschedule`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ date: reschSelectedDate, time: reschSelectedTime })
                });
                const data = await resp.json();
                if (data.success) {
                    updateScheduleInList(reschScheduleId, 'Reschedule in Process');
                    closeRescheduleModal();
                    showToastMsg('Reschedule proposed. Student notified.');
                }
            } catch(e) { showToastMsg('Error proposing reschedule.', 'error'); }
        });

        // Poll for new pending schedule requests (for real-time red dot and table updates)
        (function pollScheduleUpdates() {
            let lastPendingCount = -1;
            function check() {
                fetch('/scheduling/pending-count')
                    .then(r => r.json())
                    .then(data => {
                        // If count increased, refresh the table from server
                        if (lastPendingCount !== -1 && data.count > lastPendingCount) {
                            window.location.reload(); // reload to get new schedules into table
                        }
                        lastPendingCount = data.count;
                    })
                    .catch(() => {});
            }
            check();
            setInterval(check, 10000); // check every 10 seconds
        })();

        // Auto-mark schedules as done if past current date
        async function acceptStudentReschedule(id) {
            const confirmed = await showConfirmModal('Approve Reschedule', 'Approve the student\'s reschedule request? Their appointment will be moved to their proposed date.', 'Approve');
            if (!confirmed) return;
            try {
                const resp = await fetch(`/scheduling/${id}/accept-student-reschedule`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                const data = await resp.json();
                if (data.success) {
                    const idx = schedules.findIndex(s => s.id === id);
                    if (idx !== -1) { schedules[idx].status = 'Upcoming'; schedules[idx].proposedDate = null; schedules[idx].proposedTime = null; }
                    filterSchedules();
                    showToast('Reschedule approved! Student notified.', 'success');
                }
            } catch(e) { showToast('Error approving reschedule.', 'error'); }
        }

        async function denyStudentReschedule(id) {
            const confirmed = await showConfirmModal('Deny Reschedule', 'Deny the student\'s reschedule request? Their original appointment will remain.', 'Deny', true);
            if (!confirmed) return;
            try {
                const resp = await fetch(`/scheduling/${id}/deny-student-reschedule`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                const data = await resp.json();
                if (data.success) {
                    const idx = schedules.findIndex(s => s.id === id);
                    if (idx !== -1) { schedules[idx].status = 'Upcoming'; schedules[idx].proposedDate = null; schedules[idx].proposedTime = null; }
                    filterSchedules();
                    showToast('Reschedule request denied. Student notified.', 'success');
                }
            } catch(e) { showToast('Error denying reschedule.', 'error'); }
        }

        function autoCompletePastSchedules() {
            const now = new Date();
            schedules.forEach(schedule => {
                const scheduleDateTime = new Date(schedule.rawDate + 'T' + schedule.rawTime);
                if (scheduleDateTime < now && schedule.status === 'Upcoming') {
                    schedule.status = 'Completed';
                }
            });
        }
        autoCompletePastSchedules();
    </script>
    
    <!-- Hidden logout form -->
    <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>
    
</body>
</html>

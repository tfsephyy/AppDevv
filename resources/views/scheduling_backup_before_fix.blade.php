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
            background: linear-gradient(135deg, #6bb3ff 0%, #4a90e2 100%);
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
        
        .action-buttons-cell { display: flex; gap: 8px; }
        
        .action-btn {
            padding: 8px 16px; border-radius: 6px; border: none;
            font-weight: 500; cursor: pointer; transition: var(--transition);
            font-size: 13px;
        }
        
        .view-btn { background: rgba(52, 152, 219, 0.2); color: #3498db; }
        .view-btn:hover { background: rgba(52, 152, 219, 0.3); }
        
        .done-btn { background: rgba(46, 204, 113, 0.2); color: #2ecc71; }
        .done-btn:hover { background: rgba(46, 204, 113, 0.3); }
        
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
            z-index: 1000; align-items: center; justify-content: center;
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
            max-height: 250px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
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
            border-color: #fff !important;
        }
            font-weight: 600 !important;
        }
        #confirmOkBtn {
            background: #4a90e2 !important;
            color: #fff !important;
            border: none !important;
        }
        #confirmCancelBtn {
            background: #fff !important;
            color: #2a5c8a !important;
            border: none !important;
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
                <!-- Removed notification and logout buttons -->
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

    <script>
        console.log('=== SCRIPT STARTING ===');
        
        // Helper function to format time - MUST be before viewSchedule
        function formatTime(timeString) {
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes} ${ampm}`;
        }
        
        // Helper function for number suffixes - MUST be before viewSchedule
        function getSuffix(num) {
            const j = num % 10;
            const k = num % 100;
            if (j == 1 && k != 11) return "st";
            if (j == 2 && k != 12) return "nd";
            if (j == 3 && k != 13) return "rd";
            return "th";
        }
        
        // Global function: Open Add Schedule Modal
        function openAddScheduleModal() {
            console.log('openAddScheduleModal called!');
            const modal = document.getElementById('addScheduleModal');
            if (!modal) {
                console.error('Modal not found!');
                return;
            }
            modal.style.display = 'flex';
            if (typeof resetForm === 'function') resetForm();
            if (typeof generateCalendar === 'function') generateCalendar();
            console.log('Modal opened successfully');
        }
        
        // Global function: Close all modals
        function closeModals() {
            console.log('closeModals called');
            const addModal = document.getElementById('addScheduleModal');
            const viewModal = document.getElementById('viewScheduleModal');
            if (addModal) addModal.style.display = 'none';
            if (viewModal) viewModal.style.display = 'none';
        }
        
        // Global function: Switch tabs
        function switchTab(tab) {
            console.log('switchTab called with:', tab);
            const upcomingSection = document.getElementById('upcomingSchedules');
            const archiveSection = document.getElementById('archiveSchedules');
            const tabBtns = document.querySelectorAll('.tab-btn');
            
            if (!upcomingSection || !archiveSection) {
                console.error('Tab sections not found!');
                return;
            }
            
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
                if (typeof renderArchiveTable === 'function') renderArchiveTable();
            }
            console.log('Tab switched to:', tab);
        }
        
        // Global function: View schedule details
        async function viewSchedule(id) {
            console.log('viewSchedule called with id:', id);
            try {
                const response = await fetch(`{{ url('/scheduling') }}/${id}`);
                if (!response.ok) throw new Error('Failed to fetch schedule');
                const data = await response.json();
                console.log('Schedule data received:', data);
                
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
                        const duration = item.duration == 60 ? '1 hour' : '1.5 hours';
                        historyItem.innerHTML = `
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <strong>${date}</strong> at ${time}
                                    <div style="font-size: 12px; color: var(--text-muted);">${duration}</div>
                                </div>
                                <span class="status-badge ${item.status === 'Completed' ? 'status-completed' : 'status-upcoming'}">${item.status}</span>
                            </div>
                        `;
                        historyContainer.appendChild(historyItem);
                    });
                }
                
                document.getElementById('viewScheduleModal').style.display = 'flex';
                console.log('Schedule details loaded successfully');
            } catch (error) {
                console.error('Error loading schedule:', error);
                alert('Failed to load schedule details: ' + error.message);
            }
        }
        
        console.log('✅ All global functions defined');
        console.log('openAddScheduleModal:', typeof openAddScheduleModal);
        console.log('closeModals:', typeof closeModals);
        console.log('switchTab:', typeof switchTab);
        console.log('viewSchedule:', typeof viewSchedule);
        
        // NOW wrap everything else in DOMContentLoaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== DOM READY ===');
        const schedules = [
            @foreach($schedules as $schedule)
            {
                id: {{ $schedule->id }},
                name: "{{ $schedule->userAccount ? $schedule->userAccount->name : 'N/A' }}",
                date: "{{ \Carbon\Carbon::parse($schedule->date)->format('F d, Y') }}",
                time: "{{ \Carbon\Carbon::parse($schedule->time)->format('g:i A') }}",
                duration: "{{ $schedule->duration }}",
                status: "{{ $schedule->status }}"
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ];

        console.log('Total schedules loaded:', schedules.length);
        console.log('Schedules:', schedules);

        // Pagination variables
        let scheduleCurrentPage = 1;
        const scheduleRowsPerPage = 5;
        let filteredSchedules = [...schedules];

        // DOM elements
        const scheduleSearchInput = document.getElementById('scheduleSearch');
        const scheduleTableBody = document.getElementById('schedulesTableBody');
        const prevSchedulePageBtn = document.getElementById('prevSchedulePage');
        const nextSchedulePageBtn = document.getElementById('nextSchedulePage');
        const schedulePageInfo = document.getElementById('schedulePageInfo');

        // Function to render schedules table
        function renderScheduleTable() {
            console.log('=== renderScheduleTable called ===');
            console.log('Filtered schedules:', filteredSchedules.length);
            scheduleTableBody.innerHTML = '';
            
            // Only show non-completed schedules in upcoming tab
            const upcomingSchedules = filteredSchedules.filter(sch => sch.status !== 'Completed');
            const startIndex = (scheduleCurrentPage - 1) * scheduleRowsPerPage;
            const endIndex = startIndex + scheduleRowsPerPage;
            const paginatedSchedules = upcomingSchedules.slice(startIndex, endIndex);
            
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
                    row.innerHTML = `
                        <td>${schedule.name}</td>
                        <td>${schedule.date}</td>
                        <td>${schedule.time}</td>
                        <td>${schedule.duration == 60 ? '1 hour' : '1.5 hours'}</td>
                        <td><span class="status-badge status-upcoming">${schedule.status}</span></td>
                        <td>
                            <div class="action-buttons-cell">
                                <button class="action-btn view-btn" onclick="viewSchedule(${schedule.id})">View</button>
                                <form method="POST" action="/scheduling/${schedule.id}/complete" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="action-btn done-btn">Done</button>
                                </form>
                            </div>
                        </td>
                    `;
                    scheduleTableBody.appendChild(row);
                });
                console.log('Rendered', paginatedSchedules.length, 'schedule rows');
            }
            
            updateSchedulePagination();
        }

        function updateSchedulePagination() {
            const upcomingSchedules = filteredSchedules.filter(sch => sch.status !== 'Completed');
            const totalPages = Math.ceil(upcomingSchedules.length / scheduleRowsPerPage);
            schedulePageInfo.textContent = `Page ${scheduleCurrentPage} of ${totalPages || 1}`;
            prevSchedulePageBtn.disabled = scheduleCurrentPage === 1;
            nextSchedulePageBtn.disabled = scheduleCurrentPage === totalPages || totalPages === 0;
        }

        function filterSchedules() {
            const searchTerm = scheduleSearchInput.value.toLowerCase();
            
            if (searchTerm === '') {
                filteredSchedules = [...schedules];
            } else {
                filteredSchedules = schedules.filter(schedule => 
                    (schedule.name && schedule.name.toLowerCase().includes(searchTerm)) ||
                    (schedule.date && schedule.date.toLowerCase().includes(searchTerm)) ||
                    (schedule.status && schedule.status.toLowerCase().includes(searchTerm))
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
            archiveTableBody.innerHTML = '';
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
                        archiveTableBody.innerHTML = `<tr><td colspan="6"><div class="empty-state"><i class="fas fa-archive"></i><h3>No Archived Schedules</h3><p>Completed schedules will appear here.</p></div></td></tr>`;
                    } else {
                        archiveSchedules.forEach(schedule => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${schedule.user_account.name}</td>
                                <td>${schedule.date}</td>
                                <td>${schedule.time}</td>
                                <td>${schedule.duration == 60 ? '1 hour' : '1.5 hours'}</td>
                                <td><span class="status-badge status-completed">${schedule.status}</span></td>
                                <td><button class="action-btn view-btn" onclick="viewSchedule(${schedule.id})">View</button></td>
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

        // Add logout confirmation
        document.querySelector('.logout-btn').addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = '/';
            }
        });
        
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

        // ==================== CALENDAR AND SCHEDULING LOGIC ====================
        let currentDate = new Date();
        let selectedDate = null;
        let selectedTime = null;
        let selectedDuration = 60;
        let bookedSlots = [];
        
        // Close modal buttons
        document.querySelectorAll('.close-modal').forEach(btn => {
            btn.addEventListener('click', closeModals);
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
        
        // Duration selection
        document.querySelectorAll('.duration-option').forEach(option => {
            option.addEventListener('click', () => {
                document.querySelectorAll('.duration-option').forEach(o => o.classList.remove('selected'));
                option.classList.add('selected');
                selectedDuration = parseInt(option.getAttribute('data-duration'));
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
                    dayElement.addEventListener('click', async function() {
                        document.querySelectorAll('.calendar-day').forEach(d => {
                            d.classList.remove('selected');
                        });
                        dayElement.classList.add('selected');
                        selectedDate = dateString;
                        document.getElementById('selectedDate').value = dateString;
                        
                        // Fetch booked slots first, then generate time slots
                        try {
                            const response = await fetch(`{{ route('scheduling.booked') }}?date=${selectedDate}`);
                            bookedSlots = await response.json();
                        } catch (error) {
                            console.error('Error fetching booked slots:', error);
                            bookedSlots = [];
                        }
                        
                        generateTimeSlots();
                        updateSelectedSchedule();
                    });
                }
                
                calendarGrid.appendChild(dayElement);
            }
        }
        
        function generateTimeSlots() {
            if (!selectedDate || !selectedDuration) {
                const timeSlots = document.getElementById('timeSlots');
                timeSlots.innerHTML = '<div style="text-align: center; padding: 20px; color: var(--text-muted);">Please select a date first</div>';
                return;
            }
            
            const timeSlots = document.getElementById('timeSlots');
            timeSlots.innerHTML = '';
            
            // Working hours: 8AM-12NN and 1PM-5PM (17:00)
            const morningSlots = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30'];
            const afternoonSlots = ['13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30'];
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
                    return;
                }
                
                const [hours, minutes] = slot.split(':').map(Number);
                const slotMinutes = hours * 60 + minutes;
                const endTimeMinutes = slotMinutes + selectedDuration;
                
                // Morning session: must end by 12:00 (720 minutes)
                if (slotMinutes < 720) {
                    if (endTimeMinutes > 720) {
                        slotElement.className += ' booked';
                        slotElement.innerHTML = `${formatTime(slot)} <i class="fas fa-times"></i>`;
                        timeSlots.appendChild(slotElement);
                        return;
                    }
                }
                
                // Afternoon session: must end by 5:00 PM (1020 minutes = 17:00)
                if (slotMinutes >= 780) {
                    if (endTimeMinutes > 1020) {
                        slotElement.className += ' booked';
                        slotElement.innerHTML = `${formatTime(slot)} <i class="fas fa-times"></i>`;
                        timeSlots.appendChild(slotElement);
                        return;
                    }
                }
                
                // Check if this slot or any required slots are booked
                const slotsNeeded = selectedDuration / 30;
                let isAvailable = true;
                
                for (let i = 0; i < slotsNeeded; i++) {
                    const checkMinutes = slotMinutes + (i * 30);
                    const checkHours = Math.floor(checkMinutes / 60);
                    const checkMins = checkMinutes % 60;
                    const checkTime = `${String(checkHours).padStart(2, '0')}:${String(checkMins).padStart(2, '0')}`;
                    
                    if (bookedSlots.includes(checkTime)) {
                        isAvailable = false;
                        break;
                    }
                }
                
                if (!isAvailable) {
                    slotElement.className += ' booked';
                    slotElement.innerHTML = `${formatTime(slot)} <i class="fas fa-times"></i>`;
                } else {
                    slotElement.addEventListener('click', () => {
                        document.querySelectorAll('.time-slot').forEach(s => {
                            s.classList.remove('selected');
                        });
                        slotElement.classList.add('selected');
                        selectedTime = slot;
                        document.getElementById('selectedTime').value = slot;
                        updateSelectedSchedule();
                    });
                }
                
                timeSlots.appendChild(slotElement);
            });
        }
        
        function updateSelectedSchedule() {
            if (selectedDate && selectedTime) {
                document.getElementById('selectedSchedule').style.display = 'block';
                
                const dateObj = new Date(selectedDate);
                document.getElementById('selectedDateDisplay').textContent = dateObj.toLocaleDateString('en-US', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
                
                document.getElementById('selectedTimeDisplay').textContent = formatTime(selectedTime);
                document.getElementById('selectedDurationDisplay').textContent = selectedDuration === 60 ? '1 hour' : '1.5 hours';
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
            
            const durationOptions = document.querySelectorAll('.duration-option');
            durationOptions.forEach(o => o.classList.remove('selected'));
            if (durationOptions[0]) durationOptions[0].classList.add('selected');
            
            document.getElementById('selectedSchedule').style.display = 'none';
            document.getElementById('selectedDate').value = '';
            document.getElementById('selectedTime').value = '';
            document.getElementById('selectedDuration').value = '60';
            
            const timeSlots = document.getElementById('timeSlots');
            timeSlots.innerHTML = '<div style="text-align: center; padding: 20px; color: var(--text-muted);">Select a date to see available time slots</div>';
        }
        
        function formatTime(timeString) {
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes} ${ampm}`;
        }
        
        // Helper function for number suffixes
        function getSuffix(num) {
            const j = num % 10;
            const k = num % 100;
            if (j == 1 && k != 11) return "st";
            if (j == 2 && k != 12) return "nd";
            if (j == 3 && k != 13) return "rd";
            return "th";
        }
        
        // Helper function to format time
        function formatTime(timeString) {
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes} ${ampm}`;
        }
        
        // NOTE: viewSchedule is already defined at the top of the script as window.viewSchedule
        // Keeping this comment as placeholder - actual implementation is above
        
        // Test button functionality
        setTimeout(() => {
            const testButton = document.querySelector('button[onclick="openAddScheduleModal()"]');
            console.log('=== BUTTON TEST ===');
            console.log('Add Schedule button found:', testButton ? 'YES' : 'NO');
            if (testButton) {
                console.log('Button onclick:', testButton.getAttribute('onclick'));
                console.log('Button disabled:', testButton.disabled);
                console.log('Button visible:', testButton.offsetParent !== null);
                console.log('Button pointer-events:', window.getComputedStyle(testButton).pointerEvents);
            }
            
            const viewButtons = document.querySelectorAll('button[onclick^="viewSchedule"]');
            console.log('View buttons found:', viewButtons.length);
            
            const tabButtons = document.querySelectorAll('button[onclick^="switchTab"]');
            console.log('Tab buttons found:', tabButtons.length);
            console.log('=== END BUTTON TEST ===')
                        `;
                        historyContainer.appendChild(historyItem);
                    });
                }
                
                document.getElementById('viewScheduleModal').style.display = 'flex';
            } catch (error) {
                console.error('Error fetching schedule details:', error);
                alert('Error loading schedule details');
            }
        };
        
        function getSuffix(num) {
            const j = num % 10;
            const k = num % 100;
            if (j == 1 && k != 11) return "st";
            if (j == 2 && k != 12) return "nd";
            if (j == 3 && k != 13) return "rd";
            return "th";
        }
        
        // Auto-mark schedules as done if past current date
        function autoCompletePastSchedules() {
            const today = new Date();
            schedules.forEach(schedule => {
                const scheduleDate = new Date(schedule.date);
                if (scheduleDate < today && schedule.status !== 'Completed') {
                    schedule.status = 'Completed';
                }
            });
        }
        autoCompletePastSchedules();
        
        // Test button functionality after DOM is ready
        setTimeout(() => {
            console.log('=== FINAL BUTTON TEST ===');
            const addBtn = document.querySelector('button[onclick="openAddScheduleModal()"]');
            console.log('Add Schedule button:', addBtn ? '✅ FOUND' : '❌ NOT FOUND');
            if (addBtn) {
                console.log('- onclick attribute:', addBtn.getAttribute('onclick'));
                console.log('- disabled:', addBtn.disabled);
                console.log('- visible:', addBtn.offsetParent !== null);
            }
            
            const viewBtns = document.querySelectorAll('button[onclick^="viewSchedule"]');
            console.log('View buttons:', viewBtns.length, viewBtns.length > 0 ? '✅' : '❌');
            
            const tabBtns = document.querySelectorAll('button[onclick^="switchTab"]');
            console.log('Tab buttons:', tabBtns.length, tabBtns.length >= 2 ? '✅' : '❌');
            
            console.log('=== FUNCTION CHECK ===');
            console.log('openAddScheduleModal:', typeof openAddScheduleModal === 'function' ? '✅' : '❌');
            console.log('closeModals:', typeof closeModals === 'function' ? '✅' : '❌');
            console.log('switchTab:', typeof switchTab === 'function' ? '✅' : '❌');
            console.log('viewSchedule:', typeof viewSchedule === 'function' ? '✅' : '❌');
            console.log('=== READY TO USE ===');
        }, 500);
        
        }); // End DOMContentLoaded
    </script>
</body>
</html>

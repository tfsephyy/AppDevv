<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MindEase — My Schedules</title>
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
            background: rgba(255, 255, 255, 0.05);
            color: var(--text);
        }
        
        .nav-item.active {
            background: var(--accent);
            color: white;
        }
        
        .nav-item i {
            font-size: 18px;
            width: 20px;
        }
        
        .admin-profile {
            padding: 15px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }
        
        .admin-info h3 {
            font-size: 14px;
            margin: 0;
        }
        
        .admin-info p {
            font-size: 12px;
            color: var(--text-muted);
            margin: 0;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .page-title h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .page-title p {
            color: var(--text-muted);
            font-size: 14px;
        }
        
        .admin-actions {
            display: flex;
            gap: 15px;
        }
        
        .notification-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--glass);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text);
            text-decoration: none;
            position: relative;
            transition: var(--transition);
        }
        
        .notification-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ff4444;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 600;
        }
        
        /* Content Section */
        .scheduling-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }
        
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .content-tabs {
            display: flex;
            gap: 10px;
        }
        
        .tab-btn {
            padding: 10px 20px;
            border: none;
            background: var(--glass);
            color: var(--text);
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
        }
        
        .tab-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .tab-btn.active {
            background: var(--accent);
            color: white;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: var(--accent);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--accent-dark);
        }
        
        .btn-secondary {
            background: var(--glass);
            color: var(--text);
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        /* Search */
        .search-container {
            position: relative;
            margin-bottom: 20px;
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        
        .search-input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            background: var(--glass);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: var(--text);
            font-size: 14px;
        }
        
        .search-input::placeholder {
            color: var(--text-muted);
        }
        
        /* Table */
        .schedules-table {
            width: 100%;
            background: var(--glass);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        
        .schedules-table thead {
            background: rgba(0, 0, 0, 0.2);
        }
        
        .schedules-table th, .schedules-table td {
            padding: 15px;
            text-align: left;
        }
        
        .schedules-table th {
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
        }
        
        .schedules-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
        }
        
        .schedules-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .status-upcoming {
            background: rgba(74, 144, 226, 0.2);
            color: #6bb3ff;
        }
        
        .status-completed {
            background: rgba(46, 213, 115, 0.2);
            color: #2ed573;
        }
        
        /* Action Buttons */
        .action-buttons-cell {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            transition: var(--transition);
        }
        
        .edit-btn {
            background: rgba(74, 144, 226, 0.2);
            color: #6bb3ff;
        }
        
        .edit-btn:hover {
            background: rgba(74, 144, 226, 0.3);
        }
        
        .cancel-btn {
            background: rgba(255, 68, 68, 0.2);
            color: #ff4444;
        }
        
        .cancel-btn:hover {
            background: rgba(255, 68, 68, 0.3);
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }
        
        .pagination-btn {
            padding: 8px 16px;
            background: var(--glass);
            color: var(--text);
            border: none;
            border-radius: 6px;
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
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .modal-content {
            background: linear-gradient(135deg, #6bb3ff 0%, #4a90e2 100%);
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .modal-header h2 {
            font-size: 22px;
        }
        
        .close-modal {
            background: none;
            border: none;
            color: var(--text);
            font-size: 28px;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        
        .close-modal:hover {
            color: var(--accent);
        }
        
        .modal-body {
            padding: 25px;
        }
        
        .modal-footer {
            padding: 20px 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        /* Form */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text);
            font-weight: 500;
            font-size: 14px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: var(--glass);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: var(--text);
            font-size: 14px;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--accent);
        }
        
        /* Calendar */
        .calendar-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .calendar-header h3 {
            font-size: 18px;
        }
        
        .calendar-nav {
            display: flex;
            gap: 10px;
        }
        
        .calendar-nav-btn {
            width: 32px;
            height: 32px;
            background: var(--glass);
            border: none;
            border-radius: 6px;
            color: var(--text);
            cursor: pointer;
            transition: var(--transition);
        }
        
        .calendar-nav-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            background: rgba(255, 255, 255, 0.05);
            padding: 2px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
            font-weight: 500;
            background: var(--glass);
            position: relative;
            min-height: 45px;
        }
        
        .calendar-day.header {
            font-weight: 700;
            color: var(--accent-light);
            cursor: default;
            background: rgba(74, 144, 226, 0.15);
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            aspect-ratio: auto;
            min-height: 35px;
        }
        
        .calendar-day.empty {
            cursor: default;
            background: transparent;
        }
        
        .calendar-day.selectable:hover {
            background: rgba(74, 144, 226, 0.3);
            transform: scale(1.05);
        }
        
        .calendar-day.selected {
            background: var(--accent);
            color: white;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.4);
        }
        
        .calendar-day.disabled {
            color: var(--text-muted);
            opacity: 0.4;
            cursor: not-allowed;
            background: rgba(0, 0, 0, 0.2);
        }
        
        .calendar-day.disabled:hover {
            transform: none;
        }
        
        .calendar-day.today {
            border: 2px solid var(--accent-light);
            font-weight: 700;
        }
        
        .calendar-day.today.disabled {
            border-color: rgba(74, 144, 226, 0.3);
        }
        
        .time-slots {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            max-height: 350px;
            overflow-y: auto;
            padding-right: 8px;
            padding-bottom: 5px;
        }
        
        /* Custom scrollbar for time slots */
        .time-slots::-webkit-scrollbar {
            width: 6px;
        }
        
        .time-slots::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            margin: 4px 0;
        }
        
        .time-slots::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--accent-light), var(--accent));
            border-radius: 10px;
            transition: var(--transition);
        }
        
        .time-slots::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, var(--accent), var(--accent-dark));
            box-shadow: 0 0 8px rgba(74, 144, 226, 0.5);
        }
        
        /* Firefox scrollbar */
        .time-slots {
            scrollbar-width: thin;
            scrollbar-color: var(--accent) rgba(255, 255, 255, 0.05);
        }
        
        .time-slot {
            padding: 10px;
            background: var(--glass);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
        }
        
        .time-slot:hover:not(.disabled) {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--accent);
        }
        
        .time-slot.selected {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }
        
        .time-slot.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            color: var(--text-muted);
            background: rgba(255, 68, 68, 0.1);
            border-color: rgba(255, 68, 68, 0.3);
            position: relative;
        }
        
        .time-slot.disabled::after {
            content: '\f00d';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            right: 8px;
            transform: translateY(-50%);
            color: #ff4444;
            font-size: 12px;
        }
        
        .duration-select {
            display: flex;
            gap: 10px;
        }
        
        .duration-option {
            flex: 1;
            padding: 12px;
            background: var(--glass);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .duration-option:hover {
            background: rgba(255, 255, 255, 0.15);
        }
        
        .duration-option.selected {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }
        
        .selected-schedule {
            background: rgba(74, 144, 226, 0.1);
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }
        
        .selected-schedule h4 {
            margin-bottom: 10px;
            color: var(--accent-light);
        }
        
        .schedule-detail {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .schedule-detail:last-child {
            border-bottom: none;
        }
        
        .schedule-label {
            color: var(--text-muted);
            font-size: 14px;
        }
        
        /* Alert */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-success {
            background: rgba(46, 213, 115, 0.2);
            color: #2ed573;
            border: 1px solid rgba(46, 213, 115, 0.3);
        }
        
        .alert-error {
            background: rgba(255, 68, 68, 0.2);
            color: #ff4444;
            border: 1px solid rgba(255, 68, 68, 0.3);
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }
        
        .empty-state h3 {
            margin-bottom: 10px;
            color: var(--text);
        }
    </style>
</head>
<body>
    <x-user-navigation />
    
    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>My Schedules</h1>
                <p>View and manage your counseling appointments</p>
            </div>
        </div>
        
        <div class="scheduling-content">
            @if (session('success'))
                <div id="successAlert" class="alert alert-success">
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
                    <button class="tab-btn active" data-tab="upcoming">Upcoming Schedules</button>
                    <button class="tab-btn" data-tab="history">History</button>
                </div>
                <div class="action-buttons">
                    <button class="btn btn-primary" id="addScheduleBtn">
                        <i class="fas fa-plus"></i>
                        Add Schedule
                    </button>
                </div>
            </div>
            
            <div class="content-section" id="upcomingSchedules">
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search by date or status..." id="scheduleSearch">
                </div>
                
                <table class="schedules-table">
                    <thead>
                        <tr>
                            <th>Scheduled Date</th>
                            <th>Scheduled Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="schedulesTableBody">
                        <!-- Schedule rows will be populated -->
                    </tbody>
                </table>
                
                <div class="pagination">
                    <button class="pagination-btn" id="prevSchedulePage" disabled>Previous</button>
                    <span class="pagination-info" id="schedulePageInfo">Page 1 of 1</span>
                    <button class="pagination-btn" id="nextSchedulePage" disabled>Next</button>
                </div>
            </div>
            
            <div class="content-section" id="historySchedules" style="display: none;">
                <table class="schedules-table">
                    <thead>
                        <tr>
                            <th>Scheduled Date</th>
                            <th>Scheduled Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="historyTableBody">
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="fas fa-history"></i>
                                    <h3>No History</h3>
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
                <h2>Book Appointment</h2>
                <button class="close-modal">&times;</button>
            </div>
            <form method="POST" action="{{ route('user.schedules.store') }}">
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
                        </div>
                        
                        <div>
                            <div class="form-group">
                                <label>Session Duration</label>
                                <div class="duration-select">
                                    <div class="duration-option selected" data-duration="60">1 hour</div>
                                    <div class="duration-option" data-duration="90">1.5 hours</div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Available Time Slots</label>
                                <div class="time-slots" id="timeSlots"></div>
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
                    <input type="hidden" name="school_id" value="{{ session('school_id') }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelAddSchedule">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm Appointment</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Schedule Modal -->
    <div class="modal" id="editScheduleModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Appointment</h2>
                <button class="close-modal">&times;</button>
            </div>
            <form method="POST" id="editScheduleForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="calendar-container">
                        <div class="calendar-section">
                            <div class="calendar-header">
                                <h3 id="editCurrentMonth"></h3>
                                <div class="calendar-nav">
                                    <button type="button" class="calendar-nav-btn" id="editPrevMonth">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="calendar-nav-btn" id="editNextMonth">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="calendar-grid" id="editCalendarGrid"></div>
                        </div>
                        
                        <div>
                            <div class="form-group">
                                <label>Session Duration</label>
                                <div class="duration-select" id="editDurationSelect">
                                    <div class="duration-option" data-duration="60">1 hour</div>
                                    <div class="duration-option" data-duration="90">1.5 hours</div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Available Time Slots</label>
                                <div class="time-slots" id="editTimeSlots"></div>
                            </div>
                            
                            <div class="selected-schedule" id="editSelectedSchedule" style="display: none;">
                                <h4>Selected Schedule</h4>
                                <div class="schedule-detail">
                                    <span class="schedule-label">Date:</span>
                                    <span id="editSelectedDateDisplay">-</span>
                                </div>
                                <div class="schedule-detail">
                                    <span class="schedule-label">Time:</span>
                                    <span id="editSelectedTimeDisplay">-</span>
                                </div>
                                <div class="schedule-detail">
                                    <span class="schedule-label">Duration:</span>
                                    <span id="editSelectedDurationDisplay">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="date" id="editSelectedDate">
                    <input type="hidden" name="time" id="editSelectedTime">
                    <input type="hidden" name="duration" id="editSelectedDuration">
                    <input type="hidden" id="editScheduleId">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Appointment</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // User schedules from Laravel
        const schedules = [
            @foreach($schedules as $schedule)
            {
                id: {{ $schedule->id }},
                date: "{{ \Carbon\Carbon::parse($schedule->date)->format('F d, Y') }}",
                rawDate: "{{ $schedule->date }}",
                time: "{{ \Carbon\Carbon::parse($schedule->time)->format('g:i A') }}",
                rawTime: "{{ $schedule->time }}",
                duration: "{{ $schedule->duration }}",
                status: "{{ $schedule->status }}"
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ];

        // Pagination variables
        let scheduleCurrentPage = 1;
        const scheduleRowsPerPage = 5;
        let filteredSchedules = schedules.filter(s => s.status !== 'completed');

        // DOM elements
        const scheduleSearchInput = document.getElementById('scheduleSearch');
        const scheduleTableBody = document.getElementById('schedulesTableBody');
        const prevSchedulePageBtn = document.getElementById('prevSchedulePage');
        const nextSchedulePageBtn = document.getElementById('nextSchedulePage');
        const schedulePageInfo = document.getElementById('schedulePageInfo');

        // Render table
        function renderScheduleTable() {
            scheduleTableBody.innerHTML = '';
            
            const startIndex = (scheduleCurrentPage - 1) * scheduleRowsPerPage;
            const endIndex = startIndex + scheduleRowsPerPage;
            const paginatedSchedules = filteredSchedules.slice(startIndex, endIndex);
            
            if (paginatedSchedules.length === 0) {
                scheduleTableBody.innerHTML = `
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-calendar-alt"></i>
                                <h3>No Schedules</h3>
                                <p>Book your first counseling appointment!</p>
                            </div>
                        </td>
                    </tr>
                `;
            } else {
                paginatedSchedules.forEach(schedule => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${schedule.date}</td>
                        <td>${schedule.time}</td>
                        <td>${schedule.duration == 60 ? '1 hour' : '1.5 hours'}</td>
                        <td><span class="status-badge status-upcoming">${schedule.status}</span></td>
                        <td>
                            <div class="action-buttons-cell">
                                <button class="action-btn edit-btn" onclick="editSchedule(${schedule.id})">Edit</button>
                                <button class="action-btn cancel-btn" onclick="cancelSchedule(${schedule.id})">Cancel</button>
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
            schedulePageInfo.textContent = `Page ${scheduleCurrentPage} of ${totalPages || 1}`;
            prevSchedulePageBtn.disabled = scheduleCurrentPage === 1;
            nextSchedulePageBtn.disabled = scheduleCurrentPage === totalPages || totalPages === 0;
        }

        function filterSchedules() {
            const searchTerm = scheduleSearchInput.value.toLowerCase();
            const activeTab = document.querySelector('.tab-btn.active').getAttribute('data-tab');
            
            let baseSchedules = activeTab === 'upcoming' 
                ? schedules.filter(s => s.status !== 'completed')
                : schedules.filter(s => s.status === 'completed');
            
            if (searchTerm === '') {
                filteredSchedules = baseSchedules;
            } else {
                filteredSchedules = baseSchedules.filter(schedule => 
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

        // Tab switching
        const tabBtns = document.querySelectorAll('.tab-btn');
        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.getAttribute('data-tab');
                tabBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                if (tab === 'upcoming') {
                    document.getElementById('upcomingSchedules').style.display = 'block';
                    document.getElementById('historySchedules').style.display = 'none';
                    filteredSchedules = schedules.filter(s => s.status !== 'completed');
                } else {
                    document.getElementById('upcomingSchedules').style.display = 'none';
                    document.getElementById('historySchedules').style.display = 'block';
                    loadHistory();
                }
                
                scheduleCurrentPage = 1;
                renderScheduleTable();
            });
        });

        function loadHistory() {
            const historyBody = document.getElementById('historyTableBody');
            const completedSchedules = schedules.filter(s => s.status.toLowerCase() === 'completed');
            
            if (completedSchedules.length === 0) {
                historyBody.innerHTML = `
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <i class="fas fa-history"></i>
                                <h3>No History</h3>
                                <p>Completed schedules will appear here.</p>
                            </div>
                        </td>
                    </tr>
                `;
            } else {
                historyBody.innerHTML = '';
                completedSchedules.forEach(schedule => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${schedule.date}</td>
                        <td>${schedule.time}</td>
                        <td>${schedule.duration == 60 ? '1 hour' : '1.5 hours'}</td>
                        <td><span class="status-badge status-completed" style="background:rgba(52,152,219,0.2);color:#3498db;">${schedule.status}</span></td>
                    `;
                    historyBody.appendChild(row);
                });
            }
        }

        async function cancelSchedule(id) {
            const confirmed = await showConfirmModal('Cancel Appointment', 'Are you sure you want to cancel this appointment?', 'Cancel', true);
            if (confirmed) {
                fetch(`/user/schedules/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to cancel appointment');
                });
            }
        }

        function editSchedule(id) {
            const schedule = schedules.find(s => s.id === id);
            if (schedule) {
                document.getElementById('editScheduleId').value = id;
                document.getElementById('editScheduleForm').action = `/user/schedules/${id}`;
                
                // Set duration
                const durationOptions = document.querySelectorAll('#editDurationSelect .duration-option');
                durationOptions.forEach(opt => {
                    opt.classList.toggle('selected', opt.getAttribute('data-duration') == schedule.duration);
                });
                
                document.getElementById('editSelectedDuration').value = schedule.duration;
                editSelectedDuration = parseInt(schedule.duration);
                
                // Parse date and time
                const dateParts = schedule.rawDate.split('-');
                editCurrentDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                
                editSelectedDate = schedule.rawDate;
                editSelectedTime = schedule.rawTime;
                
                document.getElementById('editSelectedDate').value = editSelectedDate;
                document.getElementById('editSelectedTime').value = editSelectedTime;
                
                // Fetch booked slots for this date
                fetch(`{{ route("user.schedules.booked") }}?date=${editSelectedDate}`)
                    .then(response => response.json())
                    .then(data => {
                        bookedSlots = data;
                        generateEditCalendar();
                    })
                    .catch(error => console.error('Error fetching booked slots:', error));
                
                document.getElementById('editScheduleModal').style.display = 'flex';
            }
        }

        // Initial render
        renderScheduleTable();

        // Auto-hide success alert
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }, 3000);
        }

        // Calendar and scheduling logic
        let currentDate = new Date();
        let selectedDate = null;
        let selectedTime = null;
        let selectedDuration = 60;
        let bookedSlots = [];

        let editCurrentDate = new Date();
        let editSelectedDate = null;
        let editSelectedTime = null;
        let editSelectedDuration = 60;

        const addScheduleModal = document.getElementById('addScheduleModal');
        const editScheduleModal = document.getElementById('editScheduleModal');
        const addScheduleBtn = document.getElementById('addScheduleBtn');
        const closeModalBtns = document.querySelectorAll('.close-modal');
        const cancelAddScheduleBtn = document.getElementById('cancelAddSchedule');
        const prevMonthBtn = document.getElementById('prevMonth');
        const nextMonthBtn = document.getElementById('nextMonth');
        const editPrevMonthBtn = document.getElementById('editPrevMonth');
        const editNextMonthBtn = document.getElementById('editNextMonth');
        const durationOptions = document.querySelectorAll('.duration-option');

        // Modal controls
        addScheduleBtn.addEventListener('click', () => {
            addScheduleModal.style.display = 'flex';
            bookedSlots = []; // Reset booked slots
            generateCalendar();
        });

        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                addScheduleModal.style.display = 'none';
                editScheduleModal.style.display = 'none';
                resetForm();
            });
        });

        cancelAddScheduleBtn.addEventListener('click', () => {
            addScheduleModal.style.display = 'none';
            resetForm();
        });

        prevMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            generateCalendar();
        });

        nextMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            generateCalendar();
        });

        editPrevMonthBtn.addEventListener('click', () => {
            editCurrentDate.setMonth(editCurrentDate.getMonth() - 1);
            generateEditCalendar();
        });

        editNextMonthBtn.addEventListener('click', () => {
            editCurrentDate.setMonth(editCurrentDate.getMonth() + 1);
            generateEditCalendar();
        });

        durationOptions.forEach(option => {
            option.addEventListener('click', () => {
                durationOptions.forEach(o => o.classList.remove('selected'));
                option.classList.add('selected');
                selectedDuration = parseInt(option.getAttribute('data-duration'));
                document.getElementById('selectedDuration').value = selectedDuration;
                updateSelectedSchedule();
                if (selectedDate) {
                    generateTimeSlots(); // Regenerate to reflect new duration constraints
                }
            });
        });

        document.querySelectorAll('#editDurationSelect .duration-option').forEach(option => {
            option.addEventListener('click', () => {
                document.querySelectorAll('#editDurationSelect .duration-option').forEach(o => o.classList.remove('selected'));
                option.classList.add('selected');
                editSelectedDuration = parseInt(option.getAttribute('data-duration'));
                document.getElementById('editSelectedDuration').value = editSelectedDuration;
                updateEditSelectedSchedule();
                if (editSelectedDate) {
                    generateEditTimeSlots(); // Regenerate to reflect new duration constraints
                }
            });
        });

        function fetchBookedSlots() {
            if (!selectedDate) return;
            
            console.log('Fetching booked slots for date:', selectedDate);
            
            fetch(`{{ route("user.schedules.booked") }}?date=${selectedDate}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Booked slots received:', data);
                    bookedSlots = data; // Array of time strings like ['08:00', '08:30', '09:00']
                    generateTimeSlots(); // Regenerate time slots with updated booked data
                })
                .catch(error => {
                    console.error('Error fetching booked slots:', error);
                    bookedSlots = []; // Reset on error
                    generateTimeSlots();
                });
        }

        function generateCalendar() {
            const calendarGrid = document.getElementById('calendarGrid');
            const currentMonth = document.getElementById('currentMonth');
            
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            currentMonth.textContent = currentDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            
            calendarGrid.innerHTML = '';
            
            const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            daysOfWeek.forEach(day => {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day header';
                dayElement.textContent = day;
                calendarGrid.appendChild(dayElement);
            });
            
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            
            for (let i = 0; i < firstDay; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day empty';
                calendarGrid.appendChild(emptyDay);
            }
            
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            console.log(`Generating calendar for ${currentMonth.textContent}: ${daysInMonth} days`);
            
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                const dayDate = new Date(year, month, day);
                dayDate.setHours(0, 0, 0, 0);
                
                const dayOfWeek = dayDate.getDay();
                const isWeekend = dayOfWeek === 0 || dayOfWeek === 6; // Sunday = 0, Saturday = 6
                const isPast = dayDate < today;
                const isToday = dayDate.getTime() === today.getTime();
                
                if (isPast || isWeekend) {
                    dayElement.className = 'calendar-day disabled';
                } else {
                    dayElement.className = 'calendar-day selectable';
                    dayElement.addEventListener('click', () => selectDate(dayDate));
                }
                
                // Highlight today
                if (isToday) {
                    dayElement.classList.add('today');
                }
                
                dayElement.textContent = day;
                calendarGrid.appendChild(dayElement);
            }
        }

        function generateEditCalendar() {
            const calendarGrid = document.getElementById('editCalendarGrid');
            const currentMonth = document.getElementById('editCurrentMonth');
            
            const year = editCurrentDate.getFullYear();
            const month = editCurrentDate.getMonth();
            
            currentMonth.textContent = editCurrentDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            
            calendarGrid.innerHTML = '';
            
            const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            daysOfWeek.forEach(day => {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day header';
                dayElement.textContent = day;
                calendarGrid.appendChild(dayElement);
            });
            
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            
            for (let i = 0; i < firstDay; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day empty';
                calendarGrid.appendChild(emptyDay);
            }
            
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                const dayDate = new Date(year, month, day);
                dayDate.setHours(0, 0, 0, 0);
                
                const dateStr = dayDate.toISOString().split('T')[0];
                const dayOfWeek = dayDate.getDay();
                const isWeekend = dayOfWeek === 0 || dayOfWeek === 6;
                const isPast = dayDate < today;
                const isToday = dayDate.getTime() === today.getTime();
                
                if (isPast || isWeekend) {
                    dayElement.className = 'calendar-day disabled';
                } else {
                    dayElement.className = 'calendar-day selectable';
                    if (dateStr === editSelectedDate) {
                        dayElement.classList.add('selected');
                    }
                    dayElement.addEventListener('click', () => selectEditDate(dayDate));
                }
                
                // Highlight today
                if (isToday) {
                    dayElement.classList.add('today');
                }
                
                dayElement.textContent = day;
                calendarGrid.appendChild(dayElement);
            }
            
            if (editSelectedDate) {
                generateEditTimeSlots();
                updateEditSelectedSchedule();
            }
        }

        function selectDate(date) {
            // Format date as YYYY-MM-DD in local timezone (not UTC)
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            selectedDate = `${year}-${month}-${day}`;
            
            document.getElementById('selectedDate').value = selectedDate;
            
            document.querySelectorAll('#calendarGrid .calendar-day').forEach(day => {
                day.classList.remove('selected');
            });
            event.target.classList.add('selected');
            
            // Fetch booked slots for this date
            fetchBookedSlots();
            updateSelectedSchedule();
        }

        function selectEditDate(date) {
            // Format date as YYYY-MM-DD in local timezone (not UTC)
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            editSelectedDate = `${year}-${month}-${day}`;
            
            document.getElementById('editSelectedDate').value = editSelectedDate;
            
            document.querySelectorAll('#editCalendarGrid .calendar-day').forEach(day => {
                day.classList.remove('selected');
            });
            event.target.classList.add('selected');
            
            generateEditTimeSlots();
            updateEditSelectedSchedule();
        }

        function generateTimeSlots() {
            const timeSlotsContainer = document.getElementById('timeSlots');
            timeSlotsContainer.innerHTML = '';
            
            if (!selectedDate) {
                timeSlotsContainer.innerHTML = '<p style="text-align:center; color: var(--text-muted);">Select a date first</p>';
                return;
            }
            
            // Generate 30-minute intervals
            // Morning: 8:00 AM - 11:00 AM (last slot that can fit 1.5 hours before noon)
            // Afternoon: 1:00 PM - 3:00 PM (last slot that can fit 1.5 hours before 4 PM)
            const morningSlots = [];
            const afternoonSlots = [];
            
            // Morning slots (8:00 - 11:00) - removed 11:30
            for (let hour = 8; hour <= 11; hour++) {
                morningSlots.push(`${hour.toString().padStart(2, '0')}:00`);
                if (hour < 11) { // Don't add 11:30
                    morningSlots.push(`${hour.toString().padStart(2, '0')}:30`);
                }
            }
            
            // Afternoon slots (13:00 - 15:00) - removed 15:30
            for (let hour = 13; hour <= 15; hour++) {
                afternoonSlots.push(`${hour.toString().padStart(2, '0')}:00`);
                if (hour < 15) { // Don't add 15:30 (3:30 PM)
                    afternoonSlots.push(`${hour.toString().padStart(2, '0')}:30`);
                }
            }
            
            const allSlots = [...morningSlots, ...afternoonSlots];
            
            allSlots.forEach(time => {
                const slot = document.createElement('div');
                slot.className = 'time-slot';
                slot.textContent = convertTo12Hour(time);
                
                // Check if this slot is available based on duration
                const isAvailable = isTimeSlotAvailable(time, selectedDuration, selectedDate);
                
                if (!isAvailable) {
                    slot.classList.add('disabled');
                } else {
                    slot.addEventListener('click', () => selectTime(time));
                }
                
                timeSlotsContainer.appendChild(slot);
            });
        }
        
        function isTimeSlotAvailable(startTime, duration, date) {
            // Parse the start time
            const [hours, minutes] = startTime.split(':').map(Number);
            const startMinutes = hours * 60 + minutes;
            const endMinutes = startMinutes + duration;
            
            // Check if session would end within allowed hours
            // Morning sessions must end by 12:00 (720 minutes)
            // Afternoon sessions must end by 16:00 (960 minutes)
            if (startMinutes < 12 * 60) {
                // Morning slot
                if (endMinutes > 12 * 60) {
                    console.log(`${startTime} unavailable: would extend past noon`);
                    return false; // Would extend past noon
                }
            } else {
                // Afternoon slot
                if (endMinutes > 16 * 60) {
                    console.log(`${startTime} unavailable: would extend past 4 PM`);
                    return false; // Would extend past 4 PM
                }
            }
            
            // Check if any 30-minute interval in this session is booked
            for (let i = 0; i < duration; i += 30) {
                const checkMinutes = startMinutes + i;
                const checkHours = Math.floor(checkMinutes / 60);
                const checkMins = checkMinutes % 60;
                const checkTime = `${checkHours.toString().padStart(2, '0')}:${checkMins.toString().padStart(2, '0')}`;
                
                if (bookedSlots.includes(checkTime)) {
                    console.log(`${startTime} unavailable: ${checkTime} is booked. Booked slots:`, bookedSlots);
                    return false; // This interval is booked
                }
            }
            
            return true;
        }

        function generateEditTimeSlots() {
            const timeSlotsContainer = document.getElementById('editTimeSlots');
            timeSlotsContainer.innerHTML = '';
            
            if (!editSelectedDate) {
                timeSlotsContainer.innerHTML = '<p style="text-align:center; color: var(--text-muted);">Select a date first</p>';
                return;
            }
            
            // Generate 30-minute intervals
            const morningSlots = [];
            const afternoonSlots = [];
            
            // Morning slots (8:00 - 11:00) - removed 11:30
            for (let hour = 8; hour <= 11; hour++) {
                morningSlots.push(`${hour.toString().padStart(2, '0')}:00`);
                if (hour < 11) { // Don't add 11:30
                    morningSlots.push(`${hour.toString().padStart(2, '0')}:30`);
                }
            }
            
            // Afternoon slots (13:00 - 15:00) - removed 15:30
            for (let hour = 13; hour <= 15; hour++) {
                afternoonSlots.push(`${hour.toString().padStart(2, '0')}:00`);
                if (hour < 15) { // Don't add 15:30 (3:30 PM)
                    afternoonSlots.push(`${hour.toString().padStart(2, '0')}:30`);
                }
            }
            
            const allSlots = [...morningSlots, ...afternoonSlots];
            
            allSlots.forEach(time => {
                const slot = document.createElement('div');
                slot.className = 'time-slot';
                slot.textContent = convertTo12Hour(time);
                
                // Highlight currently selected time
                if (time === editSelectedTime.substring(0, 5)) {
                    slot.classList.add('selected');
                }
                
                // Check if this slot is available (excluding the current appointment's time)
                const isCurrentTime = time === editSelectedTime.substring(0, 5);
                const isAvailable = isCurrentTime || isTimeSlotAvailable(time, editSelectedDuration, editSelectedDate);
                
                if (!isAvailable) {
                    slot.classList.add('disabled');
                } else {
                    slot.addEventListener('click', () => selectEditTime(time));
                }
                
                timeSlotsContainer.appendChild(slot);
            });
        }

        function selectTime(time) {
            selectedTime = time + ':00'; // Store as HH:mm:ss for backend
            document.getElementById('selectedTime').value = selectedTime;
            
            document.querySelectorAll('#timeSlots .time-slot').forEach(slot => {
                slot.classList.remove('selected');
            });
            event.target.classList.add('selected');
            
            updateSelectedSchedule();
        }

        function selectEditTime(time) {
            editSelectedTime = time + ':00';
            document.getElementById('editSelectedTime').value = editSelectedTime;
            
            document.querySelectorAll('#editTimeSlots .time-slot').forEach(slot => {
                slot.classList.remove('selected');
            });
            event.target.classList.add('selected');
            
            updateEditSelectedSchedule();
        }

        function updateSelectedSchedule() {
            const scheduleDiv = document.getElementById('selectedSchedule');
            
            if (selectedDate && selectedTime) {
                scheduleDiv.style.display = 'block';
                
                const date = new Date(selectedDate);
                document.getElementById('selectedDateDisplay').textContent = date.toLocaleDateString('en-US', { 
                    month: 'long', 
                    day: 'numeric', 
                    year: 'numeric' 
                });
                
                document.getElementById('selectedTimeDisplay').textContent = convertTo12Hour(selectedTime.substring(0, 5));
                document.getElementById('selectedDurationDisplay').textContent = selectedDuration === 60 ? '1 hour' : '1.5 hours';
            } else {
                scheduleDiv.style.display = 'none';
            }
        }

        function updateEditSelectedSchedule() {
            const scheduleDiv = document.getElementById('editSelectedSchedule');
            
            if (editSelectedDate && editSelectedTime) {
                scheduleDiv.style.display = 'block';
                
                const date = new Date(editSelectedDate);
                document.getElementById('editSelectedDateDisplay').textContent = date.toLocaleDateString('en-US', { 
                    month: 'long', 
                    day: 'numeric', 
                    year: 'numeric' 
                });
                
                document.getElementById('editSelectedTimeDisplay').textContent = convertTo12Hour(editSelectedTime.substring(0, 5));
                document.getElementById('editSelectedDurationDisplay').textContent = editSelectedDuration === 60 ? '1 hour' : '1.5 hours';
            } else {
                scheduleDiv.style.display = 'none';
            }
        }

        function convertTo12Hour(time24) {
            const [hours, minutes] = time24.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const hour12 = hour % 12 || 12;
            return `${hour12}:${minutes} ${ampm}`;
        }

        function resetForm() {
            selectedDate = null;
            selectedTime = null;
            selectedDuration = 60;
            document.getElementById('selectedSchedule').style.display = 'none';
            document.getElementById('selectedDate').value = '';
            document.getElementById('selectedTime').value = '';
            document.getElementById('selectedDuration').value = '60';
        }
    </script>
    @include('components.confirm-modal')
</body>
</html>

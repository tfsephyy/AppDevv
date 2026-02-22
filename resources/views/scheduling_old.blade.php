<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
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
        
        /* Main Content Styles */
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
        
        .page-title h1 {
            font-size: 24px;
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
        
        .notification-btn, .logout-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--transition);
        }
        
        .notification-btn:hover, .logout-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .notification-btn {
            position: relative;
        }
        
        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Scheduling Content */
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
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
            border: none;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
        }
        
        .tab-btn.active {
            background: var(--accent);
            color: white;
        }
        
        .tab-btn:hover:not(.active) {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            color: white;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.6);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .content-section {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            margin-bottom: 30px;
        }
        
        .schedules-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .schedules-table th {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
            font-weight: 500;
            font-size: 14px;
        }
        
        .schedules-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .student-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .student-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(74, 144, 226, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-light);
            font-size: 14px;
            font-weight: 600;
        }
        
        .student-name {
            font-weight: 500;
        }
        
        .student-id {
            color: var(--text-muted);
            font-size: 12px;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-upcoming {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
        }
        
        .status-completed {
            background: rgba(52, 152, 219, 0.2);
            color: #3498db;
        }
        
        .status-archived {
            background: rgba(149, 165, 166, 0.2);
            color: #95a5a6;
        }
        
        .action-buttons-cell {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            font-size: 13px;
        }
        
        .reschedule-btn {
            background: rgba(241, 196, 15, 0.2);
            color: #f1c40f;
        }
        
        .reschedule-btn:hover {
            background: rgba(241, 196, 15, 0.3);
        }
        
        .done-btn {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
        }
        
        .done-btn:hover {
            background: rgba(46, 204, 113, 0.3);
        }
        
        .delete-btn {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
        }
        
        .delete-btn:hover {
            background: rgba(231, 76, 60, 0.3);
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }
        
        .empty-state h3 {
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: var(--card-bg);
            border-radius: var(--radius);
            width: 90%;
            max-width: 900px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            overflow: hidden;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-header h2 {
            font-size: 20px;
        }
        
        .close-modal {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 20px;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .close-modal:hover {
            color: white;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .calendar-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .calendar-section {
            margin-bottom: 20px;
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .calendar-nav {
            display: flex;
            gap: 10px;
        }
        
        .calendar-nav-btn {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .calendar-nav-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        
        .calendar-day-header {
            text-align: center;
            padding: 10px;
            font-weight: 500;
            color: var(--text-muted);
            font-size: 14px;
        }
        
        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
        }
        
        .calendar-day.available {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .calendar-day.available:hover {
            background: rgba(74, 144, 226, 0.2);
        }
        
        .calendar-day.selected {
            background: var(--accent);
            color: white;
        }
        
        .calendar-day.unavailable {
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-muted);
            cursor: not-allowed;
        }
        
        .calendar-day.fully-booked {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
            cursor: not-allowed;
        }
        
        .time-slots {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 15px;
        }
        
        .time-slot {
            padding: 12px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.05);
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .time-slot:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .time-slot.selected {
            background: var(--accent);
            color: white;
        }
        
        .time-slot.booked {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
            cursor: not-allowed;
        }
        
        .form-section {
            margin-top: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
            font-size: 15px;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }
        
        .duration-select {
            display: flex;
            gap: 10px;
        }
        
        .duration-option {
            flex: 1;
            padding: 10px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.05);
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .duration-option:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .duration-option.selected {
            background: var(--accent);
            color: white;
        }
        
        .selected-schedule {
            background: rgba(74, 144, 226, 0.1);
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }
        
        .schedule-detail {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .schedule-label {
            color: var(--text-muted);
        }
        
        .modal-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        /* Custom scrollbar */
        .scheduling-content::-webkit-scrollbar,
        .modal-content::-webkit-scrollbar {
            width: 6px;
        }
        
        .scheduling-content::-webkit-scrollbar-track,
        .modal-content::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        
        .scheduling-content::-webkit-scrollbar-thumb,
        .modal-content::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 3px;
        }
        
        .scheduling-content::-webkit-scrollbar-thumb:hover,
        .modal-content::-webkit-scrollbar-thumb:hover {
            background: var(--accent-light);
        }
    </style>
</head>
<body>
 @include('components.navigation')
  
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="page-title">
                <h1 id="page-title">Scheduling</h1>
                <p id="page-subtitle">Manage student counseling schedules and appointments</p>
            </div>
            
            <div class="admin-actions">
                <a href="#" class="notification-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </a>
                <a href="login.html" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
        
        <!-- Scheduling Content -->
        <div class="scheduling-content">
            <div class="content-header">
                <div class="content-tabs">
                    <button class="tab-btn active" data-tab="upcoming">Upcoming Schedules</button>
                    <button class="tab-btn" data-tab="archive">Archive</button>
                </div>
                <div class="action-buttons">
                    <button class="btn btn-secondary" id="archiveFolderBtn">
                        <i class="fas fa-archive"></i>
                        Archive Folder
                    </button>
                    <button class="btn btn-primary" id="addScheduleBtn">
                        <i class="fas fa-plus"></i>
                        Add Schedule
                    </button>
                </div>
            </div>
            
            <!-- Upcoming Schedules Section -->
            <div class="content-section" id="upcomingSchedules">
                <table class="schedules-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Scheduled Date</th>
                            <th>Scheduled Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar">JS</div>
                                    <div>
                                        <div class="student-name">John Smith</div>
                                        <div class="student-id">2023-00125 • Computer Science</div>
                                    </div>
                                </div>
                            </td>
                            <td>October 20, 2023</td>
                            <td>10:00 AM</td>
                            <td>1 hour</td>
                            <td><span class="status-badge status-upcoming">Upcoming</span></td>
                            <td>
                                <div class="action-buttons-cell">
                                    <button class="action-btn reschedule-btn">Reschedule</button>
                                    <button class="action-btn done-btn">Done</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar">MJ</div>
                                    <div>
                                        <div class="student-name">Maria Johnson</div>
                                        <div class="student-id">2023-00126 • Psychology</div>
                                    </div>
                                </div>
                            </td>
                            <td>October 21, 2023</td>
                            <td>2:30 PM</td>
                            <td>1.5 hours</td>
                            <td><span class="status-badge status-upcoming">Upcoming</span></td>
                            <td>
                                <div class="action-buttons-cell">
                                    <button class="action-btn reschedule-btn">Reschedule</button>
                                    <button class="action-btn done-btn">Done</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar">RD</div>
                                    <div>
                                        <div class="student-name">Robert Davis</div>
                                        <div class="student-id">2023-00127 • Engineering</div>
                                    </div>
                                </div>
                            </td>
                            <td>October 23, 2023</td>
                            <td>11:00 AM</td>
                            <td>1 hour</td>
                            <td><span class="status-badge status-upcoming">Upcoming</span></td>
                            <td>
                                <div class="action-buttons-cell">
                                    <button class="action-btn reschedule-btn">Reschedule</button>
                                    <button class="action-btn done-btn">Done</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Archive Section -->
            <div class="content-section" id="archiveSchedules" style="display: none;">
                <table class="schedules-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Scheduled Date</th>
                            <th>Scheduled Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar">TB</div>
                                    <div>
                                        <div class="student-name">Thomas Brown</div>
                                        <div class="student-id">2023-00129 • Information Tech</div>
                                    </div>
                                </div>
                            </td>
                            <td>October 15, 2023</td>
                            <td>9:30 AM</td>
                            <td>1 hour</td>
                            <td><span class="status-badge status-completed">Completed</span></td>
                            <td>
                                <div class="action-buttons-cell">
                                    <button class="action-btn delete-btn">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar">SW</div>
                                    <div>
                                        <div class="student-name">Sarah Williams</div>
                                        <div class="student-id">2023-00128 • Business Admin</div>
                                    </div>
                                </div>
                            </td>
                            <td>October 12, 2023</td>
                            <td>3:00 PM</td>
                            <td>1.5 hours</td>
                            <td><span class="status-badge status-completed">Completed</span></td>
                            <td>
                                <div class="action-buttons-cell">
                                    <button class="action-btn delete-btn">Delete</button>
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
            <div class="modal-body">
                <div class="calendar-container">
                    <div class="calendar-section">
                        <div class="calendar-header">
                            <h3 id="currentMonth">October 2023</h3>
                            <div class="calendar-nav">
                                <button class="calendar-nav-btn" id="prevMonth">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="calendar-nav-btn" id="nextMonth">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="calendar-grid" id="calendarGrid">
                            <!-- Calendar will be generated by JavaScript -->
                        </div>
                        
                        <div class="form-group">
                            <label>Available Time Slots</label>
                            <div class="time-slots" id="timeSlots">
                                <!-- Time slots will be generated by JavaScript -->
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="form-group">
                            <label for="studentName">Student Name</label>
                            <input type="text" id="studentName" class="form-control" placeholder="Enter student name">
                        </div>
                        
                        <div class="form-group">
                            <label for="studentId">Student ID</label>
                            <input type="text" id="studentId" class="form-control" placeholder="Enter student ID">
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
                                <span id="selectedDate">-</span>
                            </div>
                            <div class="schedule-detail">
                                <span class="schedule-label">Time:</span>
                                <span id="selectedTime">-</span>
                            </div>
                            <div class="schedule-detail">
                                <span class="schedule-label">Duration:</span>
                                <span id="selectedDuration">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelAddSchedule">Cancel</button>
                <button class="btn btn-primary" id="confirmSchedule">Confirm Schedule</button>
            </div>
        </div>
    </div>

    <script>
        // Sample data for schedules
        let upcomingSchedules = [
            {
                id: 1,
                studentName: "John Smith",
                studentId: "2023-00125",
                course: "Computer Science",
                date: "2023-10-20",
                time: "10:00",
                duration: 60,
                status: "upcoming"
            },
            {
                id: 2,
                studentName: "Maria Johnson",
                studentId: "2023-00126",
                course: "Psychology",
                date: "2023-10-21",
                time: "14:30",
                duration: 90,
                status: "upcoming"
            },
            {
                id: 3,
                studentName: "Robert Davis",
                studentId: "2023-00127",
                course: "Engineering",
                date: "2023-10-23",
                time: "11:00",
                duration: 60,
                status: "upcoming"
            }
        ];
        
        let archivedSchedules = [
            {
                id: 4,
                studentName: "Thomas Brown",
                studentId: "2023-00129",
                course: "Information Tech",
                date: "2023-10-15",
                time: "09:30",
                duration: 60,
                status: "completed"
            },
            {
                id: 5,
                studentName: "Sarah Williams",
                studentId: "2023-00128",
                course: "Business Admin",
                date: "2023-10-12",
                time: "15:00",
                duration: 90,
                status: "completed"
            }
        ];
        
        // Sample booked time slots for demonstration
        const bookedSlots = {
            "2023-10-20": ["10:00", "11:00"],
            "2023-10-21": ["14:30"],
            "2023-10-23": ["11:00", "15:00"]
        };
        
        // Calendar variables
        let currentDate = new Date();
        let selectedDate = null;
        let selectedTime = null;
        let selectedDuration = 60;
        
        // DOM Elements
        const tabBtns = document.querySelectorAll('.tab-btn');
        const upcomingSchedulesSection = document.getElementById('upcomingSchedules');
        const archiveSchedulesSection = document.getElementById('archiveSchedules');
        const addScheduleBtn = document.getElementById('addScheduleBtn');
        const archiveFolderBtn = document.getElementById('archiveFolderBtn');
        const addScheduleModal = document.getElementById('addScheduleModal');
        const closeModalBtns = document.querySelectorAll('.close-modal');
        const cancelAddScheduleBtn = document.getElementById('cancelAddSchedule');
        const confirmScheduleBtn = document.getElementById('confirmSchedule');
        const prevMonthBtn = document.getElementById('prevMonth');
        const nextMonthBtn = document.getElementById('nextMonth');
        const currentMonthElement = document.getElementById('currentMonth');
        const calendarGrid = document.getElementById('calendarGrid');
        const timeSlots = document.getElementById('timeSlots');
        const durationOptions = document.querySelectorAll('.duration-option');
        const selectedSchedule = document.getElementById('selectedSchedule');
        const selectedDateElement = document.getElementById('selectedDate');
        const selectedTimeElement = document.getElementById('selectedTime');
        const selectedDurationElement = document.getElementById('selectedDuration');
        
        // Event Listeners
        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.getAttribute('data-tab');
                tabBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                if (tab === 'upcoming') {
                    upcomingSchedulesSection.style.display = 'block';
                    archiveSchedulesSection.style.display = 'none';
                } else {
                    upcomingSchedulesSection.style.display = 'none';
                    archiveSchedulesSection.style.display = 'block';
                }
            });
        });
        
        addScheduleBtn.addEventListener('click', () => {
            addScheduleModal.style.display = 'flex';
            generateCalendar();
            generateTimeSlots();
        });
        
        archiveFolderBtn.addEventListener('click', () => {
            document.querySelector('[data-tab="archive"]').click();
        });
        
        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                addScheduleModal.style.display = 'none';
                resetForm();
            });
        });
        
        cancelAddScheduleBtn.addEventListener('click', () => {
            addScheduleModal.style.display = 'none';
            resetForm();
        });
        
        confirmScheduleBtn.addEventListener('click', addNewSchedule);
        
        prevMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            generateCalendar();
        });
        
        nextMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            generateCalendar();
        });
        
        durationOptions.forEach(option => {
            option.addEventListener('click', () => {
                durationOptions.forEach(o => o.classList.remove('selected'));
                option.classList.add('selected');
                selectedDuration = parseInt(option.getAttribute('data-duration'));
                updateSelectedSchedule();
            });
        });
        
        // Add event listeners to action buttons in tables
        document.addEventListener('click', function(e) {
            // Done button
            if (e.target.closest('.done-btn')) {
                const row = e.target.closest('tr');
                const studentId = row.querySelector('.student-id').textContent.split('•')[0].trim();
                completeSchedule(studentId);
            }
            
            // Reschedule button
            if (e.target.closest('.reschedule-btn')) {
                const row = e.target.closest('tr');
                const studentId = row.querySelector('.student-id').textContent.split('•')[0].trim();
                rescheduleStudent(studentId);
            }
            
            // Delete button
            if (e.target.closest('.delete-btn')) {
                const row = e.target.closest('tr');
                const studentId = row.querySelector('.student-id').textContent.split('•')[0].trim();
                deleteSchedule(studentId);
            }
        });
        
        // Functions
        function generateCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            // Update month display
            currentMonthElement.textContent = currentDate.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long' 
            });
            
            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            
            // Clear previous calendar
            calendarGrid.innerHTML = '';
            
            // Add day headers
            const dayHeaders = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            dayHeaders.forEach(day => {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day-header';
                dayElement.textContent = day;
                calendarGrid.appendChild(dayElement);
            });
            
            // Add empty cells for days before the first day of the month
            for (let i = 0; i < firstDay.getDay(); i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day unavailable';
                calendarGrid.appendChild(emptyDay);
            }
            
            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                dayElement.textContent = day;
                
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const date = new Date(year, month, day);
                const dayOfWeek = date.getDay();
                
                // Check if it's a weekend (0 = Sunday, 6 = Saturday)
                if (dayOfWeek === 0 || dayOfWeek === 6) {
                    dayElement.className += ' unavailable';
                } else {
                    dayElement.className += ' available';
                    
                    // Check if date is fully booked
                    if (bookedSlots[dateString] && bookedSlots[dateString].length >= 8) {
                        dayElement.className += ' fully-booked';
                        dayElement.innerHTML = `${day} <i class="fas fa-times"></i>`;
                    }
                    
                    // Add click event
                    dayElement.addEventListener('click', () => {
                        if (!dayElement.classList.contains('unavailable') && 
                            !dayElement.classList.contains('fully-booked')) {
                            // Remove selected class from all days
                            document.querySelectorAll('.calendar-day').forEach(d => {
                                d.classList.remove('selected');
                            });
                            
                            // Add selected class to clicked day
                            dayElement.classList.add('selected');
                            
                            selectedDate = dateString;
                            generateTimeSlots();
                            updateSelectedSchedule();
                        }
                    });
                }
                
                calendarGrid.appendChild(dayElement);
            }
        }
        
        function generateTimeSlots() {
            // Clear previous time slots
            timeSlots.innerHTML = '';
            
            if (!selectedDate) return;
            
            // Define available time slots (9:00 AM - 12:00 PM and 1:00 PM - 4:30 PM)
            const morningSlots = [
                '09:00', '09:30', '10:00', '10:30', '11:00', '11:30'
            ];
            
            const afternoonSlots = [
                '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00'
            ];
            
            const allSlots = [...morningSlots, ...afternoonSlots];
            
            // Check if date is fully booked
            const dateBookings = bookedSlots[selectedDate] || [];
            
            allSlots.forEach(slot => {
                const slotElement = document.createElement('div');
                slotElement.className = 'time-slot';
                slotElement.textContent = formatTime(slot);
                
                // Check if this time slot is already booked
                if (dateBookings.includes(slot)) {
                    slotElement.className += ' booked';
                    slotElement.innerHTML = `${formatTime(slot)} <i class="fas fa-times"></i>`;
                } else {
                    // Add click event
                    slotElement.addEventListener('click', () => {
                        // Remove selected class from all time slots
                        document.querySelectorAll('.time-slot').forEach(s => {
                            s.classList.remove('selected');
                        });
                        
                        // Add selected class to clicked time slot
                        slotElement.classList.add('selected');
                        
                        selectedTime = slot;
                        updateSelectedSchedule();
                    });
                }
                
                timeSlots.appendChild(slotElement);
            });
        }
        
        function updateSelectedSchedule() {
            if (selectedDate && selectedTime) {
                selectedSchedule.style.display = 'block';
                
                // Format date for display
                const dateObj = new Date(selectedDate);
                selectedDateElement.textContent = dateObj.toLocaleDateString('en-US', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
                
                selectedTimeElement.textContent = formatTime(selectedTime);
                selectedDurationElement.textContent = selectedDuration === 60 ? '1 hour' : '1.5 hours';
            } else {
                selectedSchedule.style.display = 'none';
            }
        }
        
        function addNewSchedule() {
            const studentName = document.getElementById('studentName').value;
            const studentId = document.getElementById('studentId').value;
            
            if (!studentName || !studentId || !selectedDate || !selectedTime) {
                alert('Please fill in all required fields and select a date and time');
                return;
            }
            
            const newSchedule = {
                id: Date.now(),
                studentName: studentName,
                studentId: studentId,
                course: "Not specified", // In a real app, this would come from a database
                date: selectedDate,
                time: selectedTime,
                duration: selectedDuration,
                status: "upcoming"
            };
            
            upcomingSchedules.push(newSchedule);
            
            // In a real app, you would update the table here
            alert('Schedule added successfully!');
            addScheduleModal.style.display = 'none';
            resetForm();
        }
        
        function completeSchedule(studentId) {
            const scheduleIndex = upcomingSchedules.findIndex(s => s.studentId === studentId);
            
            if (scheduleIndex !== -1) {
                const schedule = upcomingSchedules[scheduleIndex];
                schedule.status = "completed";
                archivedSchedules.push(schedule);
                upcomingSchedules.splice(scheduleIndex, 1);
                
                // In a real app, you would update the tables here
                alert('Schedule marked as completed and moved to archive!');
            }
        }
        
        function rescheduleStudent(studentId) {
            // For simplicity, we'll just open the add schedule modal
            // In a real app, you would pre-fill the form with existing data
            addScheduleModal.style.display = 'flex';
            generateCalendar();
            generateTimeSlots();
            
            // Find the student and show a message
            const student = upcomingSchedules.find(s => s.studentId === studentId);
            if (student) {
                alert(`Please select a new date and time for ${student.studentName}`);
            }
        }
        
        function deleteSchedule(studentId) {
            if (confirm('Are you sure you want to permanently delete this schedule?')) {
                const scheduleIndex = archivedSchedules.findIndex(s => s.studentId === studentId);
                
                if (scheduleIndex !== -1) {
                    archivedSchedules.splice(scheduleIndex, 1);
                    
                    // In a real app, you would update the table here
                    alert('Schedule deleted successfully!');
                }
            }
        }
        
        function resetForm() {
            document.getElementById('studentName').value = '';
            document.getElementById('studentId').value = '';
            selectedDate = null;
            selectedTime = null;
            selectedDuration = 60;
            
            // Reset UI selections
            document.querySelectorAll('.calendar-day').forEach(d => {
                d.classList.remove('selected');
            });
            
            document.querySelectorAll('.time-slot').forEach(s => {
                s.classList.remove('selected');
            });
            
            durationOptions.forEach(o => o.classList.remove('selected'));
            durationOptions[0].classList.add('selected');
            
            selectedSchedule.style.display = 'none';
        }
        
        function formatTime(timeString) {
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes} ${ampm}`;
        }
        
        // Initial calendar generation
        generateCalendar();

        document.querySelector('.logout-btn').addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = '/';
            }
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MindEase — Counseling</title>
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
        
        /* Main Content */
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
        
        /* Content */
        .counseling-content {
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
        }
        
        .students-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .students-table th {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
            font-weight: 500;
            font-size: 14px;
        }
        
        .students-table td {
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
            object-fit: cover;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(74,144,226,0.08);
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
        
        .status-Active {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
        }
        
        .status-Inactive {
            background: rgba(241, 196, 15, 0.2);
            color: #f1c40f;
        }
        
        .status-Completed {
            background: rgba(52, 152, 219, 0.2);
            color: #3498db;
        }
        
        .action-buttons-cell {
            display: flex;
            gap: 8px;
        }
        
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

        .btn-action.edit {
            background: rgba(46, 204, 113, 0.2);
            color: white;
        }

        .btn-action.edit:hover {
            background: rgba(46, 204, 113, 0.3);
            transform: translateY(-2px);
        }

        .btn-action.archive {
            background: rgba(230, 126, 34, 0.2);
            color: white;
        }

        .btn-action.archive:hover {
            background: rgba(230, 126, 34, 0.3);
            transform: translateY(-2px);
        }

        .btn-action.delete {
            background: rgba(231, 76, 60, 0.2);
            color: white;
        }

        .btn-action.delete:hover {
            background: rgba(231, 76, 60, 0.3);
            transform: translateY(-2px);
        }

        .btn-action.unarchive {
            background: rgba(46, 204, 113, 0.2);
            color: white;
        }

        .btn-action.unarchive:hover {
            background: rgba(46, 204, 113, 0.3);
            transform: translateY(-2px);
        }
        
        /* Text Action Buttons */
        .action-btn {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .view-btn {
            background: rgba(52, 152, 219, 0.2);
            color: #3498db;
        }
        
        .view-btn:hover {
            background: rgba(52, 152, 219, 0.3);
            transform: translateY(-1px);
        }
        
        .edit-btn {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
        }
        
        .edit-btn:hover {
            background: rgba(46, 204, 113, 0.3);
            transform: translateY(-1px);
        }
        
        .archive-btn {
            background: rgba(230, 126, 34, 0.2);
            color: #e67e22;
        }
        
        .archive-btn:hover {
            background: rgba(230, 126, 34, 0.3);
            transform: translateY(-1px);
        }
        
        .unarchive-btn {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
        }
        
        .unarchive-btn:hover {
            background: rgba(46, 204, 113, 0.3);
            transform: translateY(-1px);
        }
        
        .delete-btn {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
        }
        
        .delete-btn:hover {
            background: rgba(231, 76, 60, 0.3);
            transform: translateY(-1px);
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
        
        /* Autocomplete */
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
        
        /* Modal */
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
            max-width: 600px;
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
        
        .form-control option {
            background: linear-gradient(135deg, rgba(26, 60, 94, 0.95), rgba(42, 92, 138, 0.95));
            color: var(--text);
            padding: 10px;
        }

        select.form-control {
            background: #1a3c5e;
            cursor: pointer;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }
        
        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
        }
        
        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }
        
        .radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        
        .radio-option input[type="radio"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        .schedule-list {
            max-height: 200px;
            overflow-y: auto;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
        }
        
        .schedule-item {
            padding: 10px;
            margin-bottom: 5px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .schedule-item:hover {
            background: rgba(74, 144, 226, 0.3);
        }
        
        .schedule-item.selected {
            background: rgba(74, 144, 226, 0.5);
            border: 2px solid var(--accent);
        }
        
        .modal-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        /* Scrollbar */
        .counseling-content::-webkit-scrollbar,
        .modal-content::-webkit-scrollbar,
        .schedule-list::-webkit-scrollbar,
        .autocomplete-dropdown::-webkit-scrollbar {
            width: 6px;
        }
        
        .counseling-content::-webkit-scrollbar-track,
        .modal-content::-webkit-scrollbar-track,
        .schedule-list::-webkit-scrollbar-track,
        .autocomplete-dropdown::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        
        .counseling-content::-webkit-scrollbar-thumb,
        .modal-content::-webkit-scrollbar-thumb,
        .schedule-list::-webkit-scrollbar-thumb,
        .autocomplete-dropdown::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 3px;
        }
        
        .counseling-content::-webkit-scrollbar-thumb:hover,
        .modal-content::-webkit-scrollbar-thumb:hover,
        .schedule-list::-webkit-scrollbar-thumb:hover,
        .autocomplete-dropdown::-webkit-scrollbar-thumb:hover {
            background: var(--accent-light);
        }
    </style>
</head>
<body>
    @include('components.navigation')
    
    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>Counseling</h1>
                <p>Manage student counseling sessions and records</p>
            </div>
            
            <div class="admin-actions">
                <!-- Removed notification and logout buttons -->
            </div>
        </div>
        
        <div class="counseling-content">
            @if(session('success'))
                <div id="successAlert" style="background: rgba(46, 204, 113, 0.2); color: #2ecc71; padding: 15px; border-radius: 8px; margin-bottom: 20px; transition: opacity 0.5s ease-out;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="content-header">
                <div class="content-tabs">
                    <button class="tab-btn active" data-tab="active" onclick="switchCounselingTab('active')">Active Cases</button>
                    <button class="tab-btn" data-tab="archive" onclick="switchCounselingTab('archive')">Archive</button>
                </div>
                <div class="action-buttons">
                    <button class="btn btn-primary" onclick="openAddSessionModal()">
                        <i class="fas fa-plus"></i>
                        Add Session
                    </button>
                </div>
            </div>
            
            <div class="content-section" id="activeCases">
                <!-- Search Input -->
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search by student name, concern, or status..." id="sessionSearch">
                </div>
                
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Status</th>
                            <th>Concern</th>
                            <th>Last Session</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sessionsTableBody">
                        <!-- Session rows will be populated by JavaScript -->
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <div class="pagination">
                    <button class="pagination-btn" id="prevSessionPage" disabled>Previous</button>
                    <span class="pagination-info" id="sessionPageInfo">Page 1 of 1</span>
                    <button class="pagination-btn" id="nextSessionPage" disabled>Next</button>
                </div>
            </div>
            
            <div class="content-section" id="archiveCases" style="display: none;">
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Status</th>
                            <th>Concern</th>
                            <th>Last Session</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="archiveTableBody">
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-archive"></i>
                                    <h3>No Archived Cases</h3>
                                    <p>Completed sessions will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Add Session Modal -->
    <div class="modal" id="addSessionModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Counseling Session</h2>
                <button class="close-modal" onclick="closeModals()">&times;</button>
            </div>
            <form method="POST" action="{{ route('counceling.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="schoolId">Student ID</label>
                        <div class="autocomplete-container">
                            <input type="text" name="schoolId" id="schoolId" class="form-control" placeholder="Type to search..." autocomplete="off" required>
                            <div class="autocomplete-dropdown" id="autocompleteDropdown"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="concern">Concern</label>
                        <input type="text" name="concern" id="concern" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Last Session</label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="sessionType" value="calendar" checked>
                                <span>Choose Date</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="sessionType" value="recent">
                                <span>From Recent Schedule</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group" id="calendarGroup">
                        <input type="date" name="last_session" id="last_session" class="form-control" required>
                    </div>
                    
                    <div class="form-group" id="scheduleGroup" style="display: none;">
                        <div class="schedule-list" id="scheduleList">
                            <p style="text-align: center; color: var(--text-muted);">Select a student first</p>
                        </div>
                        <input type="hidden" name="selected_schedule_date" id="selected_schedule_date">
                    </div>
                    
                    <div class="form-group">
                        <label for="note">Counselor Note</label>
                        <textarea name="note" id="note" class="form-control" placeholder="Enter notes about the session..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" onclick="closeModals()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Session</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- View Session Modal -->
    <div class="modal" id="viewSessionModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Session Details</h2>
                <button class="close-modal" onclick="closeModals()">&times;</button>
            </div>
            <div class="modal-body" id="viewSessionBody">
                <!-- Content loaded via JavaScript -->
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
    
    <!-- Edit Session Modal -->
    <div class="modal" id="editSessionModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Counseling Session</h2>
                <button class="close-modal" onclick="closeModals()">&times;</button>
            </div>
            <form method="POST" id="editSessionForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editStatus">Status</label>
                        <select name="status" id="editStatus" class="form-control" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="editConcern">Concern</label>
                        <input type="text" name="concern" id="editConcern" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editLastSession">Last Session</label>
                        <input type="date" name="last_session" id="editLastSession" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editNote">Counselor Note</label>
                        <textarea name="note" id="editNote" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModals()">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Student History Modal -->
    <div class="modal" id="historyModal">
        <div class="modal-content" style="max-width: 900px;">
            <div class="modal-header">
                <h2>Session History - <span id="historyStudentName"></span></h2>
                <button class="close-modal" onclick="closeHistoryModal()">&times;</button>
            </div>
            <div class="modal-body">
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>Session Date</th>
                            <th>Concern</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="historyTableBody">
                        <!-- Populated by JavaScript -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeHistoryModal()">Close</button>
            </div>
        </div>
    </div>

    <!-- Session Details Modal -->
    <div class="modal" id="sessionDetailsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Session Details</h2>
                <button class="close-modal" onclick="closeSessionDetailsModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Student Name</label>
                    <input type="text" class="form-control" id="detailStudentName" readonly>
                </div>
                <div class="form-group">
                    <label>Session Date</label>
                    <input type="text" class="form-control" id="detailSessionDate" readonly>
                </div>
                <div class="form-group">
                    <label>Concern</label>
                    <textarea class="form-control" id="detailConcern"></textarea>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" id="detailStatus">
                        <option value="Active">Active</option>
                        <option value="Completed">Completed</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Notes</label>
                    <textarea class="form-control" id="detailNotes"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="updateSessionDetails()">Update</button>
            </div>
        </div>
    </div>

    <script>
        // Session data from Laravel
        const sessions = [
            @foreach($sessions as $session)
            {
                id: {{ $session->id }},
                userId: {{ $session->userAccount->id }},
                name: "{{ $session->userAccount->name }}",
                schoolId: "{{ $session->userAccount->schoolId }}",
                program: "{{ $session->userAccount->program }}",
                status: "{{ $session->status }}",
                concern: "{{ $session->concern }}",
                lastSession: "{{ \Carbon\Carbon::parse($session->last_session)->format('M d, Y') }}"
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ];

        // Pagination variables
        let sessionCurrentPage = 1;
        const sessionRowsPerPage = 5;
        let filteredSessions = [...sessions];

        // Open add session modal
        function openAddSessionModal() {
            document.getElementById('addSessionModal').style.display = 'flex';
            loadSchedules();
        }

        // Close all modals
        function closeModals(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            console.log('Closing all modals');
            
            const addModal = document.getElementById('addSessionModal');
            const viewModal = document.getElementById('viewSessionModal');
            const editModal = document.getElementById('editSessionModal');
            const historyModal = document.getElementById('historyModal');
            const detailsModal = document.getElementById('sessionDetailsModal');
            
            if (addModal) addModal.style.display = 'none';
            if (viewModal) viewModal.style.display = 'none';
            if (editModal) editModal.style.display = 'none';
            if (historyModal) historyModal.style.display = 'none';
            if (detailsModal) detailsModal.style.display = 'none';
            
            console.log('All modals closed');
        }

        // DOM elements
        const sessionSearchInput = document.getElementById('sessionSearch');
        const sessionTableBody = document.getElementById('sessionsTableBody');
        const prevSessionPageBtn = document.getElementById('prevSessionPage');
        const nextSessionPageBtn = document.getElementById('nextSessionPage');
        const sessionPageInfo = document.getElementById('sessionPageInfo');

        // Function to render sessions table
        function renderSessionTable() {
            sessionTableBody.innerHTML = '';
            
            const startIndex = (sessionCurrentPage - 1) * sessionRowsPerPage;
            const endIndex = startIndex + sessionRowsPerPage;
            const paginatedSessions = filteredSessions.slice(startIndex, endIndex);
            
            if (paginatedSessions.length === 0) {
                sessionTableBody.innerHTML = `
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px; color: var(--text-muted);">
                            No sessions found matching your search
                        </td>
                    </tr>
                `;
            } else {
                paginatedSessions.forEach(session => {
                    const row = document.createElement('tr');
                    row.dataset.studentId = session.id;
                    row.dataset.studentName = session.name;
                    row.dataset.userId = session.userId;
                    row.style.cursor = 'pointer';
                    row.innerHTML = `
                        <td>
                            <div class="student-info">
                                <div class="student-avatar">${session.name.substring(0, 2).toUpperCase()}</div>
                                <div>
                                    <div class="student-name">${session.name}</div>
                                    <div class="student-id">${session.schoolId} • ${session.program}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="status-badge status-${session.status}">${session.status}</span></td>
                        <td>${session.concern}</td>
                        <td>${session.lastSession}</td>
                        <td>
                            <div class="action-buttons-cell">
                                <button class="btn-action view" onclick="viewSession(${session.id})" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action edit" onclick="editSession(${session.id})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action archive" onclick="archiveSession(${session.id})" title="Archive">
                                    <i class="fas fa-archive"></i>
                                </button>
                            </div>
                        </td>
                    `;
                    
                    // Add double-click handler
                    row.addEventListener('dblclick', function(e) {
                        // Don't trigger if clicking on action buttons
                        if (!e.target.closest('.action-buttons-cell')) {
                            const userId = this.dataset.userId;
                            const studentName = this.dataset.studentName;
                            showStudentHistory(userId, studentName);
                        }
                    });
                    
                    sessionTableBody.appendChild(row);
                });
            }
            
            updateSessionPagination();
        }

        function updateSessionPagination() {
            const totalPages = Math.ceil(filteredSessions.length / sessionRowsPerPage);
            sessionPageInfo.textContent = `Page ${sessionCurrentPage} of ${totalPages}`;
            prevSessionPageBtn.disabled = sessionCurrentPage === 1;
            nextSessionPageBtn.disabled = sessionCurrentPage === totalPages || totalPages === 0;
        }

        function filterSessions() {
            const searchTerm = sessionSearchInput.value.toLowerCase();
            
            if (searchTerm === '') {
                filteredSessions = [...sessions];
            } else {
                filteredSessions = sessions.filter(session => 
                    session.name.toLowerCase().includes(searchTerm) ||
                    session.concern.toLowerCase().includes(searchTerm) ||
                    session.status.toLowerCase().includes(searchTerm)
                );
            }
            
            sessionCurrentPage = 1;
            renderSessionTable();
        }

        sessionSearchInput.addEventListener('input', filterSessions);
        
        prevSessionPageBtn.addEventListener('click', () => {
            if (sessionCurrentPage > 1) {
                sessionCurrentPage--;
                renderSessionTable();
            }
        });
        
        nextSessionPageBtn.addEventListener('click', () => {
            const totalPages = Math.ceil(filteredSessions.length / sessionRowsPerPage);
            if (sessionCurrentPage < totalPages) {
                sessionCurrentPage++;
                renderSessionTable();
            }
        });

        // Initial render
        renderSessionTable();

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

        // Logout confirmation is handled by navigation.blade.php
        
        
        // Show student history modal
        async function showStudentHistory(userId, studentName) {
            try {
                const response = await fetch(`/counseling/student/${userId}/history`);
                const historySessions = await response.json();
                document.getElementById('historyStudentName').textContent = studentName;
                const tbody = document.getElementById('historyTableBody');
                tbody.innerHTML = '';
                if (historySessions.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                No session history found
                            </td>
                        </tr>
                    `;
                } else {
                    historySessions.forEach(session => {
                        const row = document.createElement('tr');
                        const sessionDate = new Date(session.last_session).toLocaleDateString('en-US', { 
                            year: 'numeric', 
                            month: 'short', 
                            day: 'numeric' 
                        });
                        row.innerHTML = `
                            <td>${sessionDate}</td>
                            <td>${session.concern || 'N/A'}</td>
                            <td><span class="status-badge status-${session.status}">${session.status}</span></td>
                            <td style="display:flex; gap:8px;">
                                <button class="action-btn view-btn" onclick="viewSessionDetails(${session.id})">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="action-btn edit-btn" onclick="editSession(${session.id})">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }
                document.getElementById('historyModal').style.display = 'flex';
            } catch (error) {
                console.error('Error fetching history:', error);
                alert('Failed to load session history');
            }
        }
        
        // View session details in modal
        async function viewSessionDetails(sessionId) {
            try {
                const response = await fetch(`/counseling/${sessionId}`);
                const session = await response.json();
                document.getElementById('detailStudentName').value = session.user_account.name;
                const sessionDate = new Date(session.last_session).toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric' 
                });
                document.getElementById('detailSessionDate').value = sessionDate;
                document.getElementById('detailConcern').value = session.concern || '';
                document.getElementById('detailStatus').value = session.status;
                document.getElementById('detailNotes').value = session.note || '';
                document.getElementById('detailConcern').setAttribute('readonly', true);
                document.getElementById('detailStatus').setAttribute('disabled', true);
                document.getElementById('detailNotes').setAttribute('readonly', true);
                document.getElementById('sessionDetailsModal').dataset.sessionId = sessionId;
                document.getElementById('sessionDetailsModal').style.zIndex = '10001';
                document.getElementById('sessionDetailsModal').style.display = 'flex';
                document.querySelector('#sessionDetailsModal .btn-primary').style.display = 'none';
            } catch (error) {
                console.error('Error fetching session details:', error);
                alert('Failed to load session details');
            }
        }

        function openEditSessionModal(sessionId) {
            viewSessionDetails(sessionId).then(() => {
                document.getElementById('detailConcern').removeAttribute('readonly');
                document.getElementById('detailStatus').removeAttribute('disabled');
                document.getElementById('detailNotes').removeAttribute('readonly');
                document.getElementById('sessionDetailsModal').style.zIndex = '10001';
                document.getElementById('sessionDetailsModal').style.display = 'flex';
                // Show update button only in edit
                document.querySelector('#sessionDetailsModal .btn-primary').style.display = 'inline-block';
            });
        }
        
        // Update session details
        async function updateSessionDetails() {
            const sessionId = document.getElementById('sessionDetailsModal').dataset.sessionId;
            const data = {
                concern: document.getElementById('detailConcern').value,
                status: document.getElementById('detailStatus').value,
                note: document.getElementById('detailNotes').value,
                last_session: document.getElementById('detailSessionDate').value
            };
            
            try {
                const response = await fetch(`/counseling/${sessionId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });
                
                if (response.ok) {
                    showToast('Session updated successfully!', 'success');
                    closeSessionDetailsModal();
                    document.getElementById('editSessionModal').style.display = 'none';
                    document.getElementById('historyModal').style.display = 'none';
                } else {
                    showToast('Failed to update session', 'error');
                }
            } catch (error) {
                console.error('Error updating session:', error);
                alert('Failed to update session');
            }
        }
        
        // Close history modal
        function closeHistoryModal(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            console.log('Closing history modal');
            const historyModal = document.getElementById('historyModal');
            if (historyModal) {
                historyModal.style.display = 'none';
                console.log('History modal closed');
            }
        }
        
        // Close session details modal
        function closeSessionDetailsModal(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            console.log('Closing session details modal');
            const sessionDetailsModal = document.getElementById('sessionDetailsModal');
            if (sessionDetailsModal) {
                sessionDetailsModal.style.display = 'none';
                console.log('Session details modal closed');
            }
        }
        
        // Format date helper
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        }
        
        // Toast notification
        function showSuccessBanner(msg) {
            let banner = document.getElementById('successAlert');
            if (!banner) {
                banner = document.createElement('div');
                banner.id = 'successAlert';
                banner.style.cssText = 'background:rgba(46,204,113,0.2);color:#2ecc71;padding:15px;border-radius:8px;margin-bottom:20px;transition:opacity 0.5s ease-out;';
                const content = document.querySelector('.counseling-content');
                content.insertBefore(banner, content.firstChild);
            }
            banner.style.opacity = '1';
            banner.style.display = 'block';
            banner.textContent = msg;
            setTimeout(() => {
                banner.style.opacity = '0';
                setTimeout(() => { banner.style.display = 'none'; }, 500);
            }, 3000);
        }

        function showToast(msg, type = 'success') {
            const el = document.createElement('div');
            el.style.cssText = 'position:fixed;bottom:20px;right:20px;padding:14px 22px;border-radius:8px;color:white;font-weight:600;z-index:99999;backdrop-filter:blur(10px);transition:opacity 0.5s;';
            el.style.background = type === 'success' ? 'rgba(46,204,113,0.9)' : 'rgba(231,76,60,0.9)';
            el.textContent = msg;
            document.body.appendChild(el);
            setTimeout(() => { el.style.opacity = '0'; setTimeout(() => el.remove(), 500); }, 3000);
        }

        // User accounts for autocomplete
        let userAccounts = [];
        const schoolIdInput = document.getElementById('schoolId');
        const autocompleteDropdown = document.getElementById('autocompleteDropdown');
        
        // Fetch user accounts
        fetch('/scheduling/user-accounts')
            .then(response => response.json())
            .then(data => {
                userAccounts = data;
            })
            .catch(error => console.error('Error fetching user accounts:', error));
        
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
                    schoolIdInput.setAttribute('data-user-id', user.id);
                    autocompleteDropdown.style.display = 'none';
                    
                    // Load schedules if recent schedule option is selected
                    if (document.querySelector('input[name="sessionType"]:checked').value === 'recent') {
                        loadUserSchedules(user.schoolId);
                    }
                });
                autocompleteDropdown.appendChild(item);
            });
            
            autocompleteDropdown.style.display = 'block';
        }
        
        schoolIdInput.addEventListener('focus', function() {
            showDropdown(this.value);
        });
        
        schoolIdInput.addEventListener('input', function() {
            showDropdown(this.value);
        });
        
        document.addEventListener('click', function(event) {
            if (!schoolIdInput.contains(event.target) && !autocompleteDropdown.contains(event.target)) {
                autocompleteDropdown.style.display = 'none';
            }
        });
        
        // Session type radio buttons
        const sessionTypeRadios = document.querySelectorAll('input[name="sessionType"]');
        const calendarGroup = document.getElementById('calendarGroup');
        const scheduleGroup = document.getElementById('scheduleGroup');
        const lastSessionInput = document.getElementById('last_session');
        
        sessionTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'calendar') {
                    calendarGroup.style.display = 'block';
                    scheduleGroup.style.display = 'none';
                    lastSessionInput.required = true;
                } else {
                    calendarGroup.style.display = 'none';
                    scheduleGroup.style.display = 'block';
                    lastSessionInput.required = false;
                    
                    if (schoolIdInput.value) {
                        loadUserSchedules(schoolIdInput.value);
                    }
                }
            });
        });
        
        function loadUserSchedules(schoolId) {
            fetch(`/counseling/user-schedules/${schoolId}`)
                .then(response => response.json())
                .then(allSchedules => {
                    const schedules = allSchedules.slice(0, 5);
                    const scheduleList = document.getElementById('scheduleList');
                    scheduleList.innerHTML = '';
                    
                    if (schedules.length === 0) {
                        scheduleList.innerHTML = '<p style="text-align: center; color: var(--text-muted);">No recent schedules found</p>';
                        return;
                    }

                    const header = document.createElement('p');
                    header.style.cssText = 'font-size:12px;color:var(--text-muted);margin-bottom:8px;';
                    header.textContent = '5 most recent schedules — click to select:';
                    scheduleList.appendChild(header);
                    
                    schedules.forEach(schedule => {
                        const item = document.createElement('div');
                        item.className = 'schedule-item';
                        const date = new Date(schedule.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                        const time = new Date('2000-01-01 ' + schedule.time).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
                        item.innerHTML = `${date} at ${time}`;
                        item.addEventListener('click', function() {
                            document.querySelectorAll('.schedule-item').forEach(i => i.classList.remove('selected'));
                            item.classList.add('selected');
                            document.getElementById('selected_schedule_date').value = schedule.date;
                            lastSessionInput.value = schedule.date;
                        });
                        scheduleList.appendChild(item);
                    });
                })
                .catch(error => console.error('Error loading schedules:', error));
        }
        
        // Initialize close modal buttons after DOM loads
        document.addEventListener('DOMContentLoaded', function() {
            // Show persisted success banner after page reload (archive/unarchive)
            const pendingMsg = sessionStorage.getItem('counselingSuccess');
            if (pendingMsg) {
                sessionStorage.removeItem('counselingSuccess');
                showSuccessBanner(pendingMsg);
            }

            console.log('DOM loaded - Initializing modal close buttons');
            const closeButtons = document.querySelectorAll('.close-modal');
            console.log('Found ' + closeButtons.length + ' close buttons');
            
            closeButtons.forEach((btn, index) => {
                console.log('Attaching listener to button ' + (index + 1));
                btn.addEventListener('click', function(e) {
                    console.log('Close button clicked - calling closeModals()');
                    e.preventDefault();
                    e.stopPropagation();
                    closeModals(e);
                });
            });
            
            console.log('All modal close buttons initialized');
        });
        
        // Tab switching function
        function switchCounselingTab(tab) {
            const activeCases = document.getElementById('activeCases');
            const archiveCases = document.getElementById('archiveCases');
            const tabBtns = document.querySelectorAll('.tab-btn');
            
            // Remove active class from all tabs
            tabBtns.forEach(b => b.classList.remove('active'));
            
            // Add active class to clicked tab
            const clickedBtn = document.querySelector(`.tab-btn[data-tab="${tab}"]`);
            if (clickedBtn) {
                clickedBtn.classList.add('active');
            }
            
            if (tab === 'active') {
                activeCases.style.display = 'block';
                archiveCases.style.display = 'none';
            } else if (tab === 'archive') {
                activeCases.style.display = 'none';
                archiveCases.style.display = 'block';
                loadArchive();
            }
        }
        
        async function viewSession(id) {
            try {
                const response = await fetch(`/counseling/${id}`);
                const session = await response.json();
                
                const body = document.getElementById('viewSessionBody');
                body.innerHTML = `
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <div style="margin-bottom: 15px;">
                                <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 5px;">Student Name</div>
                                <div style="font-size: 16px;">${session.user_account.name}</div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 5px;">Student ID</div>
                                <div style="font-size: 16px;">${session.user_account.schoolId}</div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 5px;">Program</div>
                                <div style="font-size: 16px;">${session.user_account.program}</div>
                            </div>
                        </div>
                        <div>
                            <div style="margin-bottom: 15px;">
                                <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 5px;">Status</div>
                                <div style="font-size: 16px;"><span class="status-badge status-${session.status}">${session.status}</span></div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 5px;">Concern</div>
                                <div style="font-size: 16px;">${session.concern}</div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 5px;">Last Session</div>
                                <div style="font-size: 16px;">${new Date(session.last_session).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 20px;">
                        <div style="color: var(--text-muted); font-size: 14px; margin-bottom: 10px;">Counselor Note</div>
                        <div style="background: rgba(255, 255, 255, 0.05); border-radius: 8px; padding: 15px; min-height: 100px;">
                            ${session.note || 'No notes available'}
                        </div>
                    </div>
                `;
                
                viewSessionModal.style.display = 'flex';
            } catch (error) {
                console.error('Error loading session:', error);
                alert('Failed to load session details');
            }
        }
        
        async function editSession(id) {
            try {
                const response = await fetch(`/counseling/${id}`);
                const session = await response.json();
                
                document.getElementById('editStatus').value = session.status;
                document.getElementById('editConcern').value = session.concern;
                if (session.last_session) {
                  const d = new Date(session.last_session);
                  const yyyy = d.getFullYear();
                  const mm = String(d.getMonth() + 1).padStart(2, '0');
                  const dd = String(d.getDate()).padStart(2, '0');
                  document.getElementById('editLastSession').value = `${yyyy}-${mm}-${dd}`;
                } else {
                  document.getElementById('editLastSession').value = '';
                }
                document.getElementById('editNote').value = session.note || '';
                
                document.getElementById('editSessionForm').action = `/counseling/${id}`;
                editSessionModal.style.display = 'flex';
                editSessionModal.style.zIndex = '10002';
                document.getElementById('historyModal').style.zIndex = '10001';
            } catch (error) {
                console.error('Error loading session:', error);
                alert('Failed to load session details');
            }
        }
        
        async function archiveSession(id) {
            const confirmed = await showConfirmModal('Archive Session', 'Are you sure you want to archive this session?', 'Archive');
            if (!confirmed) return;

            try {
                const response = await fetch(`/counseling/${id}/archive`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                if (response.ok) {
                    sessionStorage.setItem('counselingSuccess', 'Session archived successfully!');
                    location.reload();
                } else {
                    showToast('Failed to archive session.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('An error occurred.', 'error');
            }
        }
        
        async function unarchiveSession(id) {
            const confirmed = await showConfirmModal('Unarchive Session', 'Are you sure you want to unarchive this session?', 'Unarchive');
            if (!confirmed) return;

            try {
                const response = await fetch(`/counseling/${id}/unarchive`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                if (response.ok) {
                    sessionStorage.setItem('counselingSuccess', 'Session unarchived successfully!');
                    location.reload();
                } else {
                    showToast('Failed to unarchive session.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('An error occurred.', 'error');
            }
        }
        
        async function deleteSession(id) {
            const confirmed = await showConfirmModal('Delete Session', 'Are you sure you want to delete this session? This action cannot be undone.', 'Delete', true);
            if (!confirmed) return;

            try {
                const response = await fetch(`/counseling/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                if (response.ok) {
                    showSuccessBanner('Session deleted successfully!');
                    loadArchive();
                } else {
                    showToast('Failed to delete session.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('An error occurred.', 'error');
            }
        }
        
        async function loadArchive() {
            try {
                const response = await fetch('/counseling-archive');
                const sessions = await response.json();
                
                const tbody = document.getElementById('archiveTableBody');
                tbody.innerHTML = '';
                
                if (sessions.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-archive"></i>
                                    <h3>No Archived Cases</h3>
                                    <p>Completed sessions will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    `;
                } else {
                    sessions.forEach(session => {
                        const date = new Date(session.last_session).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                        const initials = session.user_account.name.split(' ').map(n => n[0]).join('').toUpperCase();
                        
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar">${initials}</div>
                                    <div>
                                        <div class="student-name">${session.user_account.name}</div>
                                        <div class="student-id">${session.user_account.schoolId} • ${session.user_account.program}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge status-${session.status}">${session.status}</span></td>
                            <td>${session.concern}</td>
                            <td>${date}</td>
                            <td>
                                <div class="action-buttons-cell">
                                    <button class="btn-action view" onclick="viewSession(${session.id})" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action unarchive" onclick="unarchiveSession(${session.id})" title="Unarchive">
                                        <i class="fas fa-box-open"></i>
                                    </button>
                                    <button class="btn-action delete" onclick="deleteSession(${session.id})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }
            } catch (error) {
                console.error('Error loading archive:', error);
            }
        }
    </script>
    
    <!-- Hidden logout form -->
    <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>
    
    @include('components.confirm-modal')
</body>
</html>

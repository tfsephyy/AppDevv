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
        
        /* Counseling Content */
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
            margin-bottom: 30px;
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
        
        .status-active {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
        }
        
        .status-pending {
            background: rgba(241, 196, 15, 0.2);
            color: #f1c40f;
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
            width: 32px;
            height: 32px;
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
        
        .action-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .view-btn:hover {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
        }
        
        .edit-btn:hover {
            background: rgba(52, 152, 219, 0.2);
            color: #3498db;
        }
        
        .archive-btn:hover {
            background: rgba(241, 196, 15, 0.2);
            color: #f1c40f;
        }
        
        .delete-btn:hover {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
        }
        
        .unarchive-btn:hover {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
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
            max-width: 700px;
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
        
        .student-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .detail-group {
            margin-bottom: 15px;
        }
        
        .detail-label {
            font-weight: 500;
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .detail-value {
            font-size: 16px;
        }
        
        .notes-section {
            margin-top: 20px;
        }
        
        .notes-label {
            font-weight: 500;
            margin-bottom: 10px;
        }
        
        .notes-content {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 15px;
            min-height: 100px;
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
        
        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
        }
        
        .modal-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        /* Custom scrollbar */
        .counseling-content::-webkit-scrollbar,
        .modal-content::-webkit-scrollbar {
            width: 6px;
        }
        
        .counseling-content::-webkit-scrollbar-track,
        .modal-content::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        
        .counseling-content::-webkit-scrollbar-thumb,
        .modal-content::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 3px;
        }
        
        .counseling-content::-webkit-scrollbar-thumb:hover,
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
                <h1 id="page-title">Counseling</h1>
                <p id="page-subtitle">Manage student counseling sessions and records</p>
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
        
        <!-- Counseling Content -->
        <div class="counseling-content">
            <div class="content-header">
                <div class="content-tabs">
                    <button class="tab-btn active" data-tab="active">Active Cases</button>
                    <button class="tab-btn" data-tab="archive">Archive</button>
                </div>
                <div class="action-buttons">
                    <button class="btn btn-secondary" id="archiveFolderBtn">
                        <i class="fas fa-archive"></i>
                        Archive Folder
                    </button>
                    <button class="btn btn-primary" id="addStudentBtn">
                        <i class="fas fa-plus"></i>
                        Add Session
                    </button>
                </div>
            </div>
            
            <!-- Active Cases Section -->
            <div class="content-section" id="activeCases">
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Status</th>
                            <th>concern</th>
                            <th>Last Session</th>
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
                            <td><span class="status-badge status-active">Active</span></td>
                            <td>Anxiety Disorder</td>
                            <td>Oct 15, 2023</td>
                            <td>
                                <div class="action-buttons-cell">
                                    <button class="action-btn view-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn archive-btn" title="Archive">
                                        <i class="fas fa-archive"></i>
                                    </button>
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
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>Depression</td>
                            <td>Oct 14, 2023</td>
                            <td>
                                <div class="action-buttons-cell">
                                    <button class="action-btn view-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn archive-btn" title="Archive">
                                        <i class="fas fa-archive"></i>
                                    </button>
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
                            <td><span class="status-badge status-completed">Completed</span></td>
                            <td>Stress Management</td>
                            <td>Oct 12, 2023</td>
                            <td>
                                <div class="action-buttons-cell">
                                    <button class="action-btn view-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn archive-btn" title="Archive">
                                        <i class="fas fa-archive"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Archive Section -->
            <div class="content-section" id="archiveCases" style="display: none;">
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Status</th>
                            <th>concern</th>
                            <th>Archived Date</th>
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
                            <td><span class="status-badge status-archived">Archived</span></td>
                            <td>Academic Stress</td>
                            <td>Oct 10, 2023</td>
                            <td>
                                <div class="action-buttons-cell">
                                    <button class="action-btn view-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn unarchive-btn" title="Unarchive">
                                        <i class="fas fa-box-open"></i>
                                    </button>
                                    <button class="action-btn delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- View Student Modal -->
    <div class="modal" id="viewStudentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Student Details</h2>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="student-details">
                    <div class="detail-group">
                        <div class="detail-label">Full Name</div>
                        <div class="detail-value" id="viewName">John Smith</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Student ID</div>
                        <div class="detail-value" id="viewId">2023-00125</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Course</div>
                        <div class="detail-value" id="viewCourse">Computer Science</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Status</div>
                        <div class="detail-value" id="viewStatus"><span class="status-badge status-active">Active</span></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">concern</div>
                        <div class="detail-value" id="viewconcern">Anxiety Disorder</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Last Session</div>
                        <div class="detail-value" id="viewLastSession">October 15, 2023</div>
                    </div>
                </div>
                <div class="notes-section">
                    <div class="notes-label">Counselor Notes</div>
                    <div class="notes-content" id="viewNotes">
                        John has been showing improvement in managing his anxiety through the breathing exercises we've practiced. He reports feeling more in control during stressful situations but still struggles with exam-related anxiety. We'll continue working on coping strategies for academic stress.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="closeViewModal">Close</button>
            </div>
        </div>
    </div>
    
    <!-- Edit Student Modal -->
    <div class="modal" id="editStudentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Student Record</h2>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="editName">Full Name</label>
                    <input type="text" id="editName" class="form-control" value="John Smith">
                </div>
                <div class="form-group">
                    <label for="editId">Student ID</label>
                    <input type="text" id="editId" class="form-control" value="2023-00125" readonly>
                </div>
                <div class="form-group">
                    <label for="editCourse">Course</label>
                    <input type="text" id="editCourse" class="form-control" value="Computer Science">
                </div>
                <div class="form-group">
                    <label for="editStatus">Status</label>
                    <select id="editStatus" class="form-control">
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editconcern">concern</label>
                    <input type="text" id="editconcern" class="form-control" value="Anxiety Disorder">
                </div>
                <div class="form-group">
                    <label for="editLastSession">Last Session</label>
                    <input type="date" id="editLastSession" class="form-control" value="2023-10-15">
                </div>
                <div class="form-group">
                    <label for="editNotes">Counselor Notes</label>
                    <textarea id="editNotes" class="form-control">John has been showing improvement in managing his anxiety through the breathing exercises we've practiced. He reports feeling more in control during stressful situations but still struggles with exam-related anxiety. We'll continue working on coping strategies for academic stress.</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelEdit">Cancel</button>
                <button class="btn btn-primary" id="saveEdit">Save Changes</button>
            </div>
        </div>
    </div>
    
    <!-- Add Student Modal -->
    <div class="modal" id="addStudentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Student</h2>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="addName">Full Name</label>
                    <input type="text" id="addName" class="form-control" placeholder="Enter student's full name">
                </div>
                <div class="form-group">
                    <label for="addId">Student ID</label>
                    <input type="text" id="addId" class="form-control" placeholder="Enter student ID">
                </div>
                <div class="form-group">
                    <label for="addCourse">Course</label>
                    <input type="text" id="addCourse" class="form-control" placeholder="Enter student's course">
                </div>
                <div class="form-group">
                    <label for="addStatus">Status</label>
                    <select id="addStatus" class="form-control">
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="addconcern">concern</label>
                    <input type="text" id="addconcern" class="form-control" placeholder="Enter concern">
                </div>
                <div class="form-group">
                    <label for="addLastSession">Last Session</label>
                    <input type="date" id="addLastSession" class="form-control">
                </div>
                <div class="form-group">
                    <label for="addNotes">Counselor Notes</label>
                    <textarea id="addNotes" class="form-control" placeholder="Enter notes about the student"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelAdd">Cancel</button>
                <button class="btn btn-primary" id="saveAdd">Add Student</button>
            </div>
        </div>
    </div>

    <script>
        // Sample data for students
        let students = [
            {
                id: 1,
                name: "John Smith",
                studentId: "2023-00125",
                course: "Computer Science",
                status: "active",
                concern: "Anxiety Disorder",
                lastSession: "2023-10-15",
                notes: "John has been showing improvement in managing his anxiety through the breathing exercises we've practiced. He reports feeling more in control during stressful situations but still struggles with exam-related anxiety. We'll continue working on coping strategies for academic stress.",
                archived: false
            },
            {
                id: 2,
                name: "Maria Johnson",
                studentId: "2023-00126",
                course: "Psychology",
                status: "pending",
                concern: "Depression",
                lastSession: "2023-10-14",
                notes: "Maria is making progress but still experiences depressive episodes. We're working on identifying triggers and developing coping mechanisms. She has shown interest in mindfulness practices.",
                archived: false
            },
            {
                id: 3,
                name: "Robert Davis",
                studentId: "2023-00127",
                course: "Engineering",
                status: "completed",
                concern: "Stress Management",
                lastSession: "2023-10-12",
                notes: "Robert has successfully completed the stress management program. He has developed effective coping strategies and reports significant improvement in handling academic pressure.",
                archived: false
            }
        ];
        
        let archivedStudents = [
            {
                id: 4,
                name: "Thomas Brown",
                studentId: "2023-00129",
                course: "Information Tech",
                status: "archived",
                concern: "Academic Stress",
                lastSession: "2023-10-10",
                notes: "Thomas completed counseling sessions for academic stress. Case closed as student has graduated.",
                archived: true
            }
        ];
        
        // DOM Elements
        const tabBtns = document.querySelectorAll('.tab-btn');
        const activeCases = document.getElementById('activeCases');
        const archiveCases = document.getElementById('archiveCases');
        const addStudentBtn = document.getElementById('addStudentBtn');
        const archiveFolderBtn = document.getElementById('archiveFolderBtn');
        const viewStudentModal = document.getElementById('viewStudentModal');
        const editStudentModal = document.getElementById('editStudentModal');
        const addStudentModal = document.getElementById('addStudentModal');
        const closeModalBtns = document.querySelectorAll('.close-modal');
        const closeViewModalBtn = document.getElementById('closeViewModal');
        const cancelEditBtn = document.getElementById('cancelEdit');
        const saveEditBtn = document.getElementById('saveEdit');
        const cancelAddBtn = document.getElementById('cancelAdd');
        const saveAddBtn = document.getElementById('saveAdd');
        
        // Event Listeners
        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.getAttribute('data-tab');
                tabBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                if (tab === 'active') {
                    activeCases.style.display = 'block';
                    archiveCases.style.display = 'none';
                } else {
                    activeCases.style.display = 'none';
                    archiveCases.style.display = 'block';
                }
            });
        });
        
        addStudentBtn.addEventListener('click', () => {
            addStudentModal.style.display = 'flex';
        });
        
        archiveFolderBtn.addEventListener('click', () => {
            document.querySelector('[data-tab="archive"]').click();
        });
        
        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                viewStudentModal.style.display = 'none';
                editStudentModal.style.display = 'none';
                addStudentModal.style.display = 'none';
            });
        });
        
        closeViewModalBtn.addEventListener('click', () => {
            viewStudentModal.style.display = 'none';
        });
        
        cancelEditBtn.addEventListener('click', () => {
            editStudentModal.style.display = 'none';
        });
        
        cancelAddBtn.addEventListener('click', () => {
            addStudentModal.style.display = 'none';
        });
        
        saveEditBtn.addEventListener('click', saveStudentEdit);
        saveAddBtn.addEventListener('click', addNewStudent);
        
        // Add event listeners to action buttons in tables
        document.addEventListener('click', function(e) {
            // View button
            if (e.target.closest('.view-btn')) {
                const row = e.target.closest('tr');
                const studentId = row.querySelector('.student-id').textContent.split('•')[0].trim();
                openViewModal(studentId);
            }
            
            // Edit button
            if (e.target.closest('.edit-btn')) {
                const row = e.target.closest('tr');
                const studentId = row.querySelector('.student-id').textContent.split('•')[0].trim();
                openEditModal(studentId);
            }
            
            // Archive button
            if (e.target.closest('.archive-btn')) {
                const row = e.target.closest('tr');
                const studentId = row.querySelector('.student-id').textContent.split('•')[0].trim();
                archiveStudent(studentId);
            }
            
            // Unarchive button
            if (e.target.closest('.unarchive-btn')) {
                const row = e.target.closest('tr');
                const studentId = row.querySelector('.student-id').textContent.split('•')[0].trim();
                unarchiveStudent(studentId);
            }
            
            // Delete button
            if (e.target.closest('.delete-btn')) {
                const row = e.target.closest('tr');
                const studentId = row.querySelector('.student-id').textContent.split('•')[0].trim();
                deleteStudent(studentId);
            }
        });
        
        // Functions
        function openViewModal(studentId) {
            let student;
            
            // Search in active students
            student = students.find(s => s.studentId === studentId);
            
            // If not found, search in archived students
            if (!student) {
                student = archivedStudents.find(s => s.studentId === studentId);
            }
            
            if (student) {
                document.getElementById('viewName').textContent = student.name;
                document.getElementById('viewId').textContent = student.studentId;
                document.getElementById('viewCourse').textContent = student.course;
                
                // Set status badge
                const statusElement = document.getElementById('viewStatus');
                statusElement.innerHTML = `<span class="status-badge status-${student.status}">${student.status.charAt(0).toUpperCase() + student.status.slice(1)}</span>`;
                
                document.getElementById('viewconcern').textContent = student.concern;
                document.getElementById('viewLastSession').textContent = formatDate(student.lastSession);
                document.getElementById('viewNotes').textContent = student.notes;
                
                viewStudentModal.style.display = 'flex';
            }
        }
        
        function openEditModal(studentId) {
            const student = students.find(s => s.studentId === studentId);
            
            if (student) {
                document.getElementById('editName').value = student.name;
                document.getElementById('editId').value = student.studentId;
                document.getElementById('editCourse').value = student.course;
                document.getElementById('editStatus').value = student.status;
                document.getElementById('editconcern').value = student.concern;
                document.getElementById('editLastSession').value = student.lastSession;
                document.getElementById('editNotes').value = student.notes;
                
                // Store the student ID for saving
                document.getElementById('editStudentModal').setAttribute('data-student-id', studentId);
                
                editStudentModal.style.display = 'flex';
            }
        }
        
        function saveStudentEdit() {
            const studentId = document.getElementById('editStudentModal').getAttribute('data-student-id');
            const studentIndex = students.findIndex(s => s.studentId === studentId);
            
            if (studentIndex !== -1) {
                students[studentIndex].name = document.getElementById('editName').value;
                students[studentIndex].course = document.getElementById('editCourse').value;
                students[studentIndex].status = document.getElementById('editStatus').value;
                students[studentIndex].concern = document.getElementById('editconcern').value;
                students[studentIndex].lastSession = document.getElementById('editLastSession').value;
                students[studentIndex].notes = document.getElementById('editNotes').value;
                
                // In a real app, you would update the table here
                alert('Student record updated successfully!');
                editStudentModal.style.display = 'none';
            }
        }
        
        function addNewStudent() {
            const name = document.getElementById('addName').value;
            const studentId = document.getElementById('addId').value;
            const course = document.getElementById('addCourse').value;
            const status = document.getElementById('addStatus').value;
            const concern = document.getElementById('addconcern').value;
            const lastSession = document.getElementById('addLastSession').value;
            const notes = document.getElementById('addNotes').value;
            
            if (!name || !studentId || !course || !concern) {
                alert('Please fill in all required fields');
                return;
            }
            
            const newStudent = {
                id: Date.now(),
                name: name,
                studentId: studentId,
                course: course,
                status: status,
                concern: concern,
                lastSession: lastSession,
                notes: notes,
                archived: false
            };
            
            students.push(newStudent);
            
            // In a real app, you would update the table here
            alert('Student added successfully!');
            addStudentModal.style.display = 'none';
            
            // Reset form
            document.getElementById('addName').value = '';
            document.getElementById('addId').value = '';
            document.getElementById('addCourse').value = '';
            document.getElementById('addStatus').value = 'active';
            document.getElementById('addconcern').value = '';
            document.getElementById('addLastSession').value = '';
            document.getElementById('addNotes').value = '';
        }
        
        function archiveStudent(studentId) {
            const studentIndex = students.findIndex(s => s.studentId === studentId);
            
            if (studentIndex !== -1) {
                const student = students[studentIndex];
                student.archived = true;
                archivedStudents.push(student);
                students.splice(studentIndex, 1);
                
                // In a real app, you would update the tables here
                alert('Student archived successfully!');
            }
        }
        
        function unarchiveStudent(studentId) {
            const studentIndex = archivedStudents.findIndex(s => s.studentId === studentId);
            
            if (studentIndex !== -1) {
                const student = archivedStudents[studentIndex];
                student.archived = false;
                students.push(student);
                archivedStudents.splice(studentIndex, 1);
                
                // In a real app, you would update the tables here
                alert('Student unarchived successfully!');
            }
        }
        
        function deleteStudent(studentId) {
            if (confirm('Are you sure you want to permanently delete this student record?')) {
                const studentIndex = archivedStudents.findIndex(s => s.studentId === studentId);
                
                if (studentIndex !== -1) {
                    archivedStudents.splice(studentIndex, 1);
                    
                    // In a real app, you would update the table here
                    alert('Student record deleted successfully!');
                }
            }
        }
        
        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('en-US', options);
        }
        
        document.querySelector('.logout-btn').addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = '/';
            }
        });
    </script>
</body>
</html>

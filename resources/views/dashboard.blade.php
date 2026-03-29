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
        
        /* Dashboard Content */
        .dashboard-content {
            padding: 30px;
            height: calc(100vh - 80px);
            overflow-y: auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 18px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 18px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 0;
            box-shadow: 0 2px 8px rgba(74,144,226,0.08);
            border: 1px solid rgba(255,255,255,0.08);
        }

        .stat-header {
            margin-bottom: 8px;
        }

        .stat-icon {
            font-size: 22px;
            color: var(--accent-light);
            background: rgba(74,144,226,0.12);
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: white;
            text-align: center;
            margin-bottom: 4px;
            width: 100%;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            text-align: center;
        }

        .stat-change {
            font-size: 12px;
            margin-top: 4px;
            text-align: center;
        }

        .stat-change.negative {
            color: #e74c3c;
        }

        .stat-change.positive {
            color: #27ae60;
        }

        .content-section {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            margin-bottom: 30px;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
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
        
        .schedule-item {
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .schedule-info h4 {
            font-size: 15px;
            margin-bottom: 5px;
        }
        
        .schedule-info p {
            color: var(--text-muted);
            font-size: 13px;
        }
        
        .schedule-time {
            text-align: right;
        }
        
        .schedule-date {
            font-weight: 600;
            margin-bottom: 3px;
        }
        
        .schedule-duration {
            color: var(--text-muted);
            font-size: 13px;
        }
        
        /* Scrollbar */
        .dashboard-content::-webkit-scrollbar {
            width: 6px;
        }
        
        .dashboard-content::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        
        .dashboard-content::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 3px;
        }
        
        .dashboard-content::-webkit-scrollbar-thumb:hover {
            background: var(--accent-light);
        }
    </style>
</head>
<body>
    @include('components.navigation')
    
    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>Dashboard</h1>
                <p>Overview of your counseling system</p>
            </div>
            
            <div class="admin-actions">
                <!-- Removed notification and logout buttons -->
            </div>
        </div>
        
        <div class="dashboard-content">
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $totalStudents }}</div>
                    <div class="stat-label">Total Students</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $todaySchedules }}</div>
                    <div class="stat-label">Today's Schedules</div>
                    @if($schedulesDifference != 0)
                        <div class="stat-change {{ $schedulesDifference > 0 ? 'positive' : 'negative' }}">
                            <i class="fas fa-arrow-{{ $schedulesDifference > 0 ? 'up' : 'down' }}"></i>
                            {{ abs($schedulesDifference) }} from yesterday
                        </div>
                    @endif
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $newStudentsThisWeek }}</div>
                    <div class="stat-label">New Students This Week</div>
                    @if($studentsDifference != 0)
                        <div class="stat-change {{ $studentsDifference > 0 ? 'positive' : 'negative' }}">
                            <i class="fas fa-arrow-{{ $studentsDifference > 0 ? 'up' : 'down' }}"></i>
                            {{ abs($studentsDifference) }} from last week
                        </div>
                    @endif
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $activeSessions }}</div>
                    <div class="stat-label">Active Sessions</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $totalPosts }}</div>
                    <div class="stat-label">Total Posts</div>
                </div>
            </div>
            
            <!-- Recent Students -->
            <div class="content-section">
                <div class="section-header" style="display:flex; justify-content:space-between; align-items:center;">
                    <h2 class="section-title">Recent Students</h2>
                    <div style="width:33%; min-width:180px; display:flex; align-items:center;">
                        <input type="text" id="studentSearch" placeholder="Search..." style="width:100%; padding:6px 32px 6px 12px; border-radius:8px; border:1px solid #b8d0e0; background:rgba(255,255,255,0.08); color:#fff; font-size:14px;">
                        <style>
                            #studentSearch::placeholder {
                                color: #fff;
                                opacity: 0.7;
                            }
                        </style>
                        <i class="fas fa-search" style="position:relative; right:28px; color:#b8d0e0;"></i>
                    </div>
                </div>

                <table class="students-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>School ID</th>
                            <th>Email</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody id="studentsTableBody">
                        <!-- Students will be populated by JavaScript -->
                    </tbody>
                </table>

                <div class="pagination">
                    <button class="pagination-btn" id="prevPage" disabled>Previous</button>
                    <span class="pagination-info" id="pageInfo">Page 1 of 1</span>
                    <button class="pagination-btn" id="nextPage" disabled>Next</button>
                </div>
            </div>

            <!-- Student Details Modal -->
            <div id="studentDetailsModal" class="modal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); align-items:center; justify-content:center;">
                <div class="modal-content" style="background: var(--card-bg); border-radius: var(--radius); width: 90%; max-width: 900px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); overflow: hidden; max-height: 90vh; overflow-y: auto;">
                    <div class="modal-header" style="padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between; align-items: center;">
                        <h2 style="font-size: 20px;">Student Details</h2>
                        <button id="closeStudentModal" style="background: linear-gradient(90deg, var(--accent), var(--accent-light)); border: none; color: #fff; font-size: 20px; cursor: pointer; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; transition: var(--transition); box-shadow: 0 2px 8px rgba(74,144,226,0.18);" onmouseover="this.style.background='linear-gradient(90deg, var(--accent-light), var(--accent))'" onmouseout="this.style.background='linear-gradient(90deg, var(--accent), var(--accent-light))'">&times;</button>
                    </div>
                    <div class="modal-body" style="padding: 20px;">
                        <div class="user-detail-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div class="detail-group"><div class="detail-label" style="font-weight:500;color:var(--text-muted);font-size:14px;margin-bottom:5px;">Name</div><div class="detail-value" id="modalName">-</div></div>
                            <div class="detail-group"><div class="detail-label" style="font-weight:500;color:var(--text-muted);font-size:14px;margin-bottom:5px;">School ID</div><div class="detail-value" id="modalSchoolId">-</div></div>
                            <div class="detail-group"><div class="detail-label" style="font-weight:500;color:var(--text-muted);font-size:14px;margin-bottom:5px;">Email</div><div class="detail-value" id="modalEmail">-</div></div>
                            <div class="detail-group"><div class="detail-label" style="font-weight:500;color:var(--text-muted);font-size:14px;margin-bottom:5px;">Program</div><div class="detail-value" id="modalProgram">-</div></div>
                            <div class="detail-group"><div class="detail-label" style="font-weight:500;color:var(--text-muted);font-size:14px;margin-bottom:5px;">Year</div><div class="detail-value" id="modalYear">-</div></div>
                            <div class="detail-group"><div class="detail-label" style="font-weight:500;color:var(--text-muted);font-size:14px;margin-bottom:5px;">Section</div><div class="detail-value" id="modalSection">-</div></div>
                        </div>
                        <div class="history-section" style="margin-top: 20px;">
                            <div class="history-label" style="font-weight:500;margin-bottom:10px;">Schedule History</div>
                            <div class="history-list" id="modalScheduleHistory" style="background:rgba(255,255,255,0.05);border-radius:8px;padding:15px;max-height:300px;overflow-y:auto;"></div>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding: 20px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: flex-end; gap: 10px;">
                        <!-- Close button removed to match scheduling modal -->
                    </div>
                </div>
            </div>
            
            <!-- Upcoming Schedules -->
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">Upcoming Schedules</h2>
                </div>
                
                @if($recentSchedules->count() > 0)
                    @foreach($recentSchedules as $schedule)
                        <div class="schedule-item">
                            <div class="schedule-info">
                                <h4>{{ $schedule->userAccount->name ?? 'Unknown' }}</h4>
                                <p>{{ $schedule->userAccount->schoolId ?? 'N/A' }}</p>
                            </div>
                            <div class="schedule-time">
                                <div class="schedule-date">{{ \Carbon\Carbon::parse($schedule->date)->format('M d, Y') }}</div>
                                <div class="schedule-duration">{{ $schedule->time }} • {{ $schedule->duration }} min</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p style="text-align: center; color: var(--text-muted); padding: 20px;">No upcoming schedules</p>
                @endif
            </div>
        </div>
    </div>
    
    @include('components.confirm-modal')
    
    <!-- Hidden logout form -->
    <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>
    
    <script>
        // Students data from Laravel
        let students = @json($recentStudents);
        let filteredStudents = [...students];
        // Sort students by joined date descending
        students = students.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        filteredStudents = [...students];
        // Pagination settings
        const itemsPerPage = 5;
        let currentPage = 1;

        function renderStudents() {
            const tbody = document.getElementById('studentsTableBody');
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageStudents = filteredStudents.slice(startIndex, endIndex);

            tbody.innerHTML = '';

            pageStudents.forEach((student, idx) => {
                const initials = student.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                const joinedDate = new Date(student.created_at).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
                const row = document.createElement('tr');
                row.innerHTML = `
                        <td>
                            <div class="student-info">
                                <div class="student-avatar">${initials}</div>
                                <div>
                                    <div class="student-name">${student.name}</div>
                                    <div class="student-id">${student.schoolId} ${student.program || ''}</div>
                                </div>
                            </div>
                        </td>
                        <td>${student.schoolId}</td>
                        <td>${student.email}</td>
                        <td>${joinedDate}</td>
                `;
                row.addEventListener('dblclick', function() {
                    showStudentDetailsModal(student);
                });
                tbody.appendChild(row);
            });

            updatePagination();
        }

        function updatePagination() {
            const totalPages = Math.ceil(filteredStudents.length / itemsPerPage);
            document.getElementById('pageInfo').textContent = `Page ${currentPage} of ${totalPages}`;
            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = currentPage === totalPages;
        }

        document.getElementById('prevPage').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderStudents();
            }
        });

        document.getElementById('nextPage').addEventListener('click', () => {
            const totalPages = Math.ceil(filteredStudents.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderStudents();
            }
        });

        // Search feature
        document.getElementById('studentSearch').addEventListener('input', function() {
            const term = this.value.trim().toLowerCase();
            filteredStudents = students.filter(student =>
                student.name.toLowerCase().includes(term) ||
                student.schoolId.toLowerCase().includes(term) ||
                (student.email && student.email.toLowerCase().includes(term)) ||
                (student.program && student.program.toLowerCase().includes(term))
            );
            currentPage = 1;
            renderStudents();
        });

        // Student Details Modal logic

        function showStudentDetailsModal(student) {
            // Populate modal fields
            document.getElementById('modalName').textContent = student.name || '-';
            document.getElementById('modalSchoolId').textContent = student.schoolId || '-';
            document.getElementById('modalEmail').textContent = student.email || '-';
            document.getElementById('modalProgram').textContent = student.program || '-';
            document.getElementById('modalYear').textContent = student.year ? (student.year + getSuffix(student.year) + ' Year') : '-';
            document.getElementById('modalSection').textContent = student.section ? ('Section ' + student.section) : '-';

            // Fetch schedule history via AJAX
            fetch(`/student/${student.id}/schedule-history`)
                .then(res => res.json())
                .then(data => {
                    const historyContainer = document.getElementById('modalScheduleHistory');
                    historyContainer.innerHTML = '';
                    if (data.length === 0) {
                        historyContainer.innerHTML = '<p style="color: var(--text-muted); text-align: center;">No schedule history</p>';
                    } else {
                        data.forEach(item => {
                            const date = new Date(item.date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                            const time = formatTime(item.time);
                            const duration = item.duration == 60 ? '1 hour' : '1.5 hours';
                            const statusClass = item.status === 'Completed' ? 'status-completed' : 'status-upcoming';
                            const historyItem = document.createElement('div');
                            historyItem.className = 'history-item';
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
                    document.getElementById('studentDetailsModal').style.display = 'flex';
                });
        }

        function getSuffix(num) {
            const j = num % 10;
            const k = num % 100;
            if (j == 1 && k != 11) return "st";
            if (j == 2 && k != 12) return "nd";
            if (j == 3 && k != 13) return "rd";
            return "th";
        }

        function formatTime(timeString) {
            if (!timeString) return '-';
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes} ${ampm}`;
        }

        document.getElementById('closeStudentModal').addEventListener('click', function() {
            document.getElementById('studentDetailsModal').style.display = 'none';
        });
        // Footer close button removed; event listener also removed to prevent JS errors

        // ...existing code...
        // Render students table on page load
        document.addEventListener('DOMContentLoaded', function() {
            renderStudents();
        });
        
        // Logout button
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
        
        // Delete button example
        const deleteBtns = document.querySelectorAll('.delete-btn');
        deleteBtns.forEach(function(btn) {
          btn.addEventListener('click', async function(event) {
            event.preventDefault();
            const confirmed = await showConfirmModal('Delete Item', 'Are you sure you want to delete this item?', 'Delete', true);
            if (confirmed) {
              // Perform delete logic here
            }
          });
        });
    </script>
    @include('components.confirm-modal')
</body>
</html>

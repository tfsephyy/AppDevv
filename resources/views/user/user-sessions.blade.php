<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MindEase — My Sessions</title>
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
        .logo-img {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            object-fit: contain;
            padding: 5px;
            background: transparent;
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
        
        .notification-btn {
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
        
        .notification-btn:hover {
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
        
        .content-section {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 25px;
            backdrop-filter: blur(10px);
        }
        
        /* Search */
        .search-container {
            position: relative;
            margin-bottom: 25px;
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
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: var(--text);
            font-size: 14px;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.15);
        }
        
        /* Table */
        .students-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .students-table thead {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .students-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: var(--text);
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }
        
        .students-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .students-table tbody tr {
            transition: var(--transition);
        }
        
        .students-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .student-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }
        
        .student-name {
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .student-id {
            font-size: 12px;
            color: var(--text-muted);
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-Active {
            background: rgba(46, 204, 113, 0.3);
            color: #7ef5b4;
        }
        
        .status-Inactive {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
        }
        
        .status-Completed {
            background: rgba(52, 152, 219, 0.2);
            color: #3498db;
        }
        
        .action-buttons-cell {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: var(--transition);
            font-size: 13px;
        }
        
        .view-btn {
            background: rgba(52, 152, 219, 0.2);
            color: var(--text);
        }
        
        .view-btn:hover {
            background: rgba(52, 152, 219, 0.3);
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .pagination-btn {
            padding: 8px 16px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
            border: none;
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
            backdrop-filter: blur(5px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            background: var(--primary);
            border-radius: var(--radius);
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .modal-header h2 {
            font-size: 20px;
        }
        
        .close-modal {
            background: none;
            border: none;
            color: var(--text);
            font-size: 24px;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .close-modal:hover {
            color: var(--accent-light);
        }
        
        .modal-body {
            padding: 25px;
        }
        
        .detail-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: var(--text-muted);
            width: 140px;
            flex-shrink: 0;
        }
        
        .detail-value {
            color: var(--text);
        }
        
        .modal-footer {
            padding: 20px 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
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
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 20px;
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
        
        /* Scrollbar */
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

        /* Table scroll wrapper */
        .table-scroll-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 20px;
        }

        .table-scroll-wrapper .students-table {
            margin-bottom: 0;
        }

        /* =====================================================
           MOBILE STYLES — sessions page only (≤ 768px)
           ===================================================== */
        @media (max-width: 768px) {

            body { overflow-x: hidden !important; }

            .main-content {
                overflow: visible !important;
                height: auto !important;
                flex: 1 0 auto !important;
                min-height: calc(100vh - 60px);
            }

            .counseling-content {
                overflow-y: visible !important;
                overflow-x: visible !important;
                padding: 14px !important;
                flex: none !important;
            }

            /* Compact top bar */
            .top-bar {
                padding: 12px 16px !important;
                flex-wrap: wrap !important;
                gap: 8px !important;
            }

            .page-title h1 { font-size: 20px !important; }
            .page-title p  { font-size: 13px !important; }

            /* Tabs */
            .content-header {
                margin-bottom: 14px !important;
            }

            .tab-btn {
                padding: 10px 14px !important;
                font-size: 13px !important;
            }

            /* Content section padding */
            .content-section {
                padding: 14px !important;
            }

            /* Search */
            .search-container {
                margin-bottom: 14px !important;
            }

            /* Table scroll */
            .table-scroll-wrapper {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
                margin-bottom: 0 !important;
            }

            .students-table { min-width: 520px !important; }

            /* Pagination */
            .pagination { margin-top: 14px !important; }

            /* Modal */
            .modal {
                align-items: flex-start !important;
                padding: 70px 12px 24px !important;
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch !important;
            }

            .modal-content {
                width: 100% !important;
                max-width: 100% !important;
                max-height: none !important;
                border-radius: 12px !important;
            }

            .modal-header { padding: 14px 16px !important; }
            .modal-header h2 { font-size: 18px !important; }
            .modal-body { padding: 14px 16px !important; }

            .modal-footer {
                padding: 12px 16px 16px !important;
                flex-wrap: wrap !important;
                gap: 8px !important;
            }

            .modal-footer .btn {
                flex: 1 !important;
                min-width: 120px !important;
                justify-content: center !important;
            }

            /* Detail rows in modal */
            .detail-row {
                flex-direction: column !important;
                gap: 4px !important;
            }

            .detail-label {
                width: auto !important;
            }
        }
    </style>
</head>
<body>
    <x-user-navigation />
    
    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>My Sessions</h1>
                <p>View your counseling sessions and records</p>
            </div>
        </div>
        
        <div class="counseling-content">
            <div class="content-header">
                <div class="content-tabs">
                    <button class="tab-btn active" data-tab="active">My Cases</button>
                </div>
            </div>
            
            <div class="content-section" id="activeCases">
                <!-- Search Input -->
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search by concern or status..." id="sessionSearch">
                </div>
                
                <div class="table-scroll-wrapper">
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>Counselor</th>
                            <th>Status</th>
                            <th>Concern</th>
                            <th>Last Session</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sessionsTableBody">
                        @if($sessions->isEmpty())
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-clipboard-list"></i>
                                    <h3>No Sessions Yet</h3>
                                    <p>Your counseling sessions will appear here.</p>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                </div>
                
                <!-- Pagination -->
                <div class="pagination">
                    <button class="pagination-btn" id="prevSessionPage" disabled>Previous</button>
                    <span class="pagination-info" id="sessionPageInfo">Page 1 of 1</span>
                    <button class="pagination-btn" id="nextSessionPage" disabled>Next</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- View Session Modal -->
    <div class="modal" id="viewSessionModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Session Details</h2>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body" id="viewSessionBody">
                <!-- Content loaded via JavaScript -->
            </div>
        </div>
    </div>

    <script>
        // Session data from Laravel
        const sessions = [
            @foreach($sessions as $session)
            {
                id: {{ $session->id }},
                counselor: "Admin",
                status: "{{ $session->status }}",
                concern: "{{ $session->concern }}",
                lastSession: "{{ \Carbon\Carbon::parse($session->last_session)->format('M d, Y') }}",
                note: "{{ $session->note }}"
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ];

        // Pagination variables
        let sessionCurrentPage = 1;
        const sessionRowsPerPage = 5;
        let filteredSessions = [...sessions];

        // DOM elements
        const sessionSearchInput = document.getElementById('sessionSearch');
        const sessionTableBody = document.getElementById('sessionsTableBody');
        const prevSessionPageBtn = document.getElementById('prevSessionPage');
        const nextSessionPageBtn = document.getElementById('nextSessionPage');
        const sessionPageInfo = document.getElementById('sessionPageInfo');

        // Function to render sessions table
        function renderSessionTable() {
            if (sessions.length === 0) return; // Keep empty state from blade
            
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
                    row.innerHTML = `
                        <td>
                            <div class="student-info">
                                <div class="student-avatar">AD</div>
                                <div>
                                    <div class="student-name">${session.counselor}</div>
                                    <div class="student-id">Guidance Counselor</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="status-badge status-${session.status}">${session.status}</span></td>
                        <td>${session.concern}</td>
                        <td>${session.lastSession}</td>
                        <td>
                            <div class="action-buttons-cell">
                                <button class="action-btn view-btn" onclick="viewSession(${session.id})">View</button>
                            </div>
                        </td>
                    `;
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

        // View session function
        function viewSession(sessionId) {
            const session = sessions.find(s => s.id === sessionId);
            if (!session) return;
            
            const viewSessionBody = document.getElementById('viewSessionBody');
            viewSessionBody.innerHTML = `
                <div class="detail-row">
                    <div class="detail-label">Counselor:</div>
                    <div class="detail-value">${session.counselor}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Status:</div>
                    <div class="detail-value"><span class="status-badge status-${session.status}">${session.status}</span></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Concern:</div>
                    <div class="detail-value">${session.concern}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Last Session:</div>
                    <div class="detail-value">${session.lastSession}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Counselor Note:</div>
                    <div class="detail-value">${session.note || 'No notes available'}</div>
                </div>
            `;
            
            document.getElementById('viewSessionModal').classList.add('active');
        }

        // Modal controls
        document.querySelectorAll('.close-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.modal').forEach(modal => {
                    modal.classList.remove('active');
                });
            });
        });

        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('active');
                }
            });
        });

        // Initial render
        if (sessions.length > 0) {
            renderSessionTable();
        }

    </script>
    @include('components.confirm-modal')
    @include('components.toast-notification')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MindEase — Journal</title>
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

        /* Sidebar */
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

        .nav-item:hover { background: rgba(255, 255, 255, 0.1); color: white; }
        .nav-item.active {
            background: rgba(74, 144, 226, 0.2);
            color: var(--accent-light);
            border-left: 3px solid var(--accent);
        }
        .nav-item i { width: 20px; text-align: center; }

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

        .admin-info h3 { font-size: 14px; margin-bottom: 2px; }
        .admin-info p { font-size: 12px; color: var(--text-muted); }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 25px 30px;
            overflow-y: auto;
            height: 100vh;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-title h1 {
            font-size: 24px;
            font-weight: 700;
        }

        .page-title p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* Public Journal Card Styles */
        .journals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 20px;
            padding-bottom: 30px;
        }

        .public-journal-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: var(--radius);
            padding: 20px;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .public-journal-card:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.15);
        }

        .public-journal-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .public-user-avatar {
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
            flex-shrink: 0;
        }

        .public-user-info {
            flex: 1;
        }

        .public-user-name {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 2px;
        }

        .public-journal-time {
            font-size: 11px;
            color: var(--text-muted);
        }

        .public-journal-title {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .public-journal-content {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 12px;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .public-journal-images {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 6px;
            margin-bottom: 12px;
        }

        .public-journal-images img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .public-journal-actions {
            display: flex;
            gap: 18px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .action-button {
            display: flex;
            align-items: center;
            gap: 6px;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 13px;
            transition: var(--transition);
        }

        .action-button:hover {
            color: var(--accent-light);
        }

        .action-button.liked {
            color: #e74c3c;
        }

        .action-button i {
            font-size: 14px;
        }

        /* Comments Section */
        .comments-section {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .comment-item {
            padding: 8px 0;
            font-size: 12px;
            display: flex;
            align-items: baseline;
            gap: 6px;
            flex-wrap: wrap;
        }

        .comment-author {
            font-weight: 600;
            color: var(--text);
        }

        .comment-text {
            color: var(--text-muted);
            flex: 1;
        }

        .comment-time {
            font-size: 10px;
            color: var(--text-muted);
        }

        .comment-delete-btn {
            background: none;
            border: none;
            color: #e74c3c;
            cursor: pointer;
            font-size: 11px;
            opacity: 0;
            transition: opacity 0.2s;
            padding: 2px 4px;
        }

        .comment-item:hover .comment-delete-btn {
            opacity: 1;
        }

        .comment-input-container {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .comment-input {
            flex: 1;
            padding: 8px 14px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
            font-size: 12px;
            outline: none;
        }

        .comment-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .comment-input:focus {
            border-color: var(--accent);
        }

        .comment-send-btn {
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 50%;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .comment-send-btn:hover {
            background: var(--accent-light);
        }

        /* Loading & Empty */
        .loading-state, .empty-state, .error-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .loading-state i, .empty-state i, .error-state i {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .error-state {
            color: #e74c3c;
        }

        .retry-btn {
            margin-top: 12px;
            padding: 8px 20px;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            transition: var(--transition);
        }

        .retry-btn:hover {
            background: var(--accent-light);
        }

        /* Reload button */
        .reload-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 14px;
            padding: 4px 8px;
            border-radius: 6px;
            transition: var(--transition);
        }

        .reload-btn:hover {
            color: var(--accent-light);
            background: rgba(255, 255, 255, 0.1);
        }

        /* Toast */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
        }

        .toast {
            padding: 12px 20px;
            border-radius: 8px;
            color: white;
            font-size: 13px;
            margin-bottom: 8px;
            animation: slideIn 0.3s ease;
            max-width: 350px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .toast.success { background: rgba(46, 204, 113, 0.9); }
        .toast.error { background: rgba(231, 76, 60, 0.9); }
        .toast.info { background: rgba(52, 152, 219, 0.9); }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Search bar */
        .search-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-input {
            flex: 1;
            max-width: 400px;
            padding: 10px 16px 10px 40px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
            font-size: 13px;
            outline: none;
            transition: var(--transition);
        }

        .search-input:focus {
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.15);
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
        }

        /* Scrollbar */
        .main-content::-webkit-scrollbar {
            width: 6px;
        }

        .main-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .main-content::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        @media (max-width: 768px) {
            .journals-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    @include('components.navigation')

    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>Public Journals</h1>
                <p>View journals shared by students</p>
            </div>
            <button class="reload-btn" onclick="loadPublicJournals(true)" title="Reload">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>

        <div class="search-bar">
            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" id="journalSearch" placeholder="Search journals..." oninput="filterJournals()">
            </div>
        </div>

        <div id="journalsContainer">
            <div class="loading-state">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Loading public journals...</p>
            </div>
        </div>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <!-- Hidden logout form -->
    <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>

    @include('components.confirm-modal')
    @include('components.toast-notification')

    <script>
        let allJournals = [];

        document.addEventListener('DOMContentLoaded', () => {
            loadPublicJournals();

            // Enter to submit comment
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && e.target.classList.contains('comment-input')) {
                    const journalId = e.target.id.replace('comment-input-', '');
                    addComment(journalId);
                }
            });
        });

        async function loadPublicJournals(force = false) {
            const container = document.getElementById('journalsContainer');

            container.innerHTML = `
                <div class="loading-state">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading public journals...</p>
                </div>
            `;

            try {
                const url = force ? '/user/journal-public?t=' + Date.now() : '/user/journal-public';
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Cache-Control': force ? 'no-cache' : 'default'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const journals = await response.json();
                allJournals = journals;

                if (!Array.isArray(journals) || journals.length === 0) {
                    container.innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-book-open"></i>
                            <p>No public journals yet</p>
                            <p style="font-size: 12px; margin-top: 5px;">Students haven't shared any journals publicly yet.</p>
                        </div>
                    `;
                    return;
                }

                renderJournals(journals);
            } catch (error) {
                console.error('Error loading public journals:', error);
                container.innerHTML = `
                    <div class="error-state">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>Error loading public journals</p>
                        <p style="font-size: 12px; margin-top: 5px;">${error.message}</p>
                        <button class="retry-btn" onclick="loadPublicJournals(true)">Retry</button>
                    </div>
                `;
            }
        }

        function renderJournals(journals) {
            const container = document.getElementById('journalsContainer');

            container.innerHTML = `<div class="journals-grid">${journals.map(journal => {
                const maxLength = 400;
                let displayContent = journal.content || '';
                if (displayContent.length > maxLength) {
                    displayContent = displayContent.substring(0, maxLength) + '...';
                }

                return `
                    <div class="public-journal-card" data-journal-id="${journal.id}">
                        <div class="public-journal-header">
                            <div class="public-user-avatar">${journal.user_initials || 'AN'}</div>
                            <div class="public-user-info">
                                <div class="public-user-name">${journal.user_name || 'Anonymous'}</div>
                                <div class="public-journal-time">${journal.created_at || ''}</div>
                            </div>
                        </div>
                        <div class="public-journal-title">${journal.title || 'Untitled'}</div>
                        <div class="public-journal-content">${displayContent}</div>
                        ${journal.images && Array.isArray(journal.images) && journal.images.length > 0 ? `
                            <div class="public-journal-images">
                                ${journal.images.slice(0, 4).map(img => `
                                    <img src="/storage/${img}" alt="Journal image" onerror="this.style.display='none'">
                                `).join('')}
                            </div>
                        ` : ''}
                        <div class="public-journal-actions">
                            <button class="action-button" disabled style="cursor: default;">
                                <i class="fas fa-heart"></i>
                                <span>${journal.likes_count || 0}</span>
                            </button>
                            <button class="action-button" onclick="toggleComments(${journal.id})">
                                <i class="fas fa-comment"></i>
                                <span>${journal.comments_count || 0}</span>
                            </button>
                        </div>
                        <div class="comments-section" id="comments-${journal.id}" style="display: none;">
                            <div id="comments-list-${journal.id}">
                                ${Array.isArray(journal.comments) ? journal.comments.map(comment => `
                                    <div class="comment-item" data-comment-id="${comment.id}">
                                        <span class="comment-author">${comment.user_name || 'User'}</span>
                                        <span class="comment-text">${comment.comment || ''}</span>
                                        <span class="comment-time">${comment.created_at || ''}</span>
                                        <button class="comment-delete-btn" onclick="deleteComment(${comment.id}, ${journal.id})" title="Delete comment">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                `).join('') : ''}
                            </div>
                            <div class="comment-input-container">
                                <input type="text" class="comment-input" id="comment-input-${journal.id}" placeholder="Add a comment...">
                                <button class="comment-send-btn" onclick="addComment(${journal.id})">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('')}</div>`;
        }

        function toggleComments(journalId) {
            const commentsSection = document.getElementById(`comments-${journalId}`);
            commentsSection.style.display = commentsSection.style.display === 'none' ? 'block' : 'none';
        }

        async function addComment(journalId) {
            const input = document.getElementById(`comment-input-${journalId}`);
            const comment = input.value.trim();
            if (!comment) {
                showToast('Please enter a comment', 'error');
                return;
            }

            try {
                const response = await fetch(`/user/journal/${journalId}/comment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ comment })
                });

                const data = await response.json();
                if (data.success) {
                    const commentsList = document.getElementById(`comments-list-${journalId}`);
                    const newComment = document.createElement('div');
                    newComment.className = 'comment-item';
                    newComment.setAttribute('data-comment-id', data.comment.id);
                    newComment.innerHTML = `
                        <span class="comment-author">${data.comment.user_name || 'User'}</span>
                        <span class="comment-text">${data.comment.comment}</span>
                        <span class="comment-time">${data.comment.created_at || 'Just now'}</span></span>
                        <button class="comment-delete-btn" onclick="deleteComment(${data.comment.id}, ${journalId})" title="Delete comment">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                    commentsList.appendChild(newComment);
                    input.value = '';

                    // Update comment count
                    const commentBtn = document.querySelector(`[data-journal-id="${journalId}"] .action-button:nth-child(2) span`);
                    if (commentBtn) {
                        commentBtn.textContent = parseInt(commentBtn.textContent || 0) + 1;
                    }

                    showToast('Comment added', 'success');
                } else if (data.error === 'toxic_content') {
                    showToast(data.message || 'Your comment contains inappropriate content.', 'error');
                } else {
                    showToast(data.message || 'Error adding comment', 'error');
                }
            } catch (error) {
                console.error('Error adding comment:', error);
                showToast('Error adding comment', 'error');
            }
        }

        async function deleteComment(commentId, journalId) {
            const confirmed = await showConfirmModal('Delete Comment', 'Are you sure you want to delete this comment?', 'Delete', true);
            if (!confirmed) return;

            try {
                const response = await fetch(`/user/journal/comment/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    const commentEl = document.querySelector(`[data-comment-id="${commentId}"]`);
                    if (commentEl) commentEl.remove();

                    // Update comment count
                    const commentBtn = document.querySelector(`[data-journal-id="${journalId}"] .action-button:nth-child(2) span`);
                    if (commentBtn) {
                        const count = Math.max(0, parseInt(commentBtn.textContent || 0) - 1);
                        commentBtn.textContent = count;
                    }

                    showToast('Comment deleted', 'success');
                } else {
                    showToast(data.error || 'Error deleting comment', 'error');
                }
            } catch (error) {
                console.error('Error deleting comment:', error);
                showToast('Error deleting comment', 'error');
            }
        }

        function filterJournals() {
            const query = document.getElementById('journalSearch').value.toLowerCase().trim();
            if (!query) {
                renderJournals(allJournals);
                return;
            }

            const filtered = allJournals.filter(j =>
                (j.title || '').toLowerCase().includes(query) ||
                (j.content || '').toLowerCase().includes(query) ||
                (j.user_name || '').toLowerCase().includes(query)
            );

            if (filtered.length === 0) {
                document.getElementById('journalsContainer').innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-search"></i>
                        <p>No journals match your search</p>
                    </div>
                `;
                return;
            }

            renderJournals(filtered);
        }

        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            if (!container) return;
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.textContent = message;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s';
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <title>MindEase — Motivational Messages</title>
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

        .notification-btn { position: relative; }

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

        /* Feed Content */
        .feed-content {
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

        .content-tabs { display: flex; gap: 10px; }

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

        /* Post Card */
        .post-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .post-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .post-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .author-avatar {
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

        .author-info h3 { font-size: 14px; margin-bottom: 2px; }
        .author-info p { font-size: 12px; color: var(--text-muted); }

        .post-options {
            display: flex;
            gap: 5px;
        }

        .options-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 8px 10px;
            border-radius: 6px;
            transition: var(--transition);
            font-size: 16px;
        }

        .options-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .post-content {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .post-images {
            display: grid;
            gap: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            overflow: hidden;
        }

        .post-images.single { grid-template-columns: 1fr; }
        .post-images.double { grid-template-columns: 1fr 1fr; }
        .post-images.triple { grid-template-columns: 2fr 1fr 1fr; }
        .post-images.multiple { grid-template-columns: 1fr 1fr 1fr; }

        .post-image-wrapper {
            position: relative;
            height: 250px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
        }

        .post-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .post-image:hover {
            transform: scale(1.05);
        }

        .more-images-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            font-weight: 600;
            cursor: pointer;
        }

        .post-actions {
            display: flex;
            gap: 20px;
            padding: 15px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 6px;
            transition: var(--transition);
            font-size: 14px;
        }

        .action-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .action-btn.liked {
            color: #e74c3c;
        }

        .comments-section {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .comment-form {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .comment-input {
            flex: 1;
            padding: 10px 15px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
            font-size: 14px;
        }

        .comment-input:focus {
            outline: none;
            border-color: var(--accent);
        }

        .comment-btn {
            padding: 10px 20px;
            border-radius: 20px;
            background: var(--accent);
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: var(--transition);
        }

        .comment-btn:hover {
            background: var(--accent-light);
        }

        .comment {
            margin-bottom: 15px;
            padding-left: 0;
        }

        .comment.reply {
            margin-left: 50px;
        }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .comment-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(74, 144, 226, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-light);
            font-size: 12px;
            font-weight: 600;
        }

        .comment-author {
            font-weight: 600;
            font-size: 14px;
        }

        .comment-time {
            font-size: 12px;
            color: var(--text-muted);
        }

        .comment-text {
            margin-left: 42px;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .comment-actions {
            margin-left: 42px;
        }

        .comment-reply-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 4px;
            transition: var(--transition);
        }

        .comment-reply-btn:hover {
            color: var(--accent-light);
            background: rgba(74, 144, 226, 0.1);
        }

        /* Comment Context Menu */
        .comment-context-menu {
            position: fixed;
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 5px 0;
            min-width: 150px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            z-index: 1500;
            display: none;
            backdrop-filter: blur(10px);
        }

        .context-menu-item {
            padding: 10px 15px;
            color: var(--text);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .context-menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .context-menu-item.delete {
            color: #e74c3c;
        }

        .context-menu-item i {
            width: 16px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 24px;
            margin-bottom: 10px;
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
            z-index: 3000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: var(--card-bg);
            border-radius: var(--radius);
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .modal-header h2 { font-size: 20px; }

        .close-modal {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 20px;
            cursor: pointer;
            transition: var(--transition);
        }

        .close-modal:hover { color: white; }

        .modal-body {
            padding: 20px;
            overflow-y: auto !important;
            flex: 1;
            min-height: 0;
            max-height: calc(90vh - 200px);
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-shrink: 0;
            background: var(--card-bg);
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
            min-height: 80px;
            max-height: 150px;
            font-family: inherit;
        }

        .image-upload-area {
            border: 2px dashed rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .image-upload-area:hover {
            border-color: var(--accent);
            background: rgba(74, 144, 226, 0.05);
        }

        .image-upload-area i {
            font-size: 40px;
            color: var(--text-muted);
            margin-bottom: 8px;
            display: block;
        }

        .image-upload-area p {
            color: var(--text-muted);
            font-size: 14px;
            margin: 0;
        }

        .image-preview-container {
            max-height: none;
            overflow: visible;
            margin-top: 15px;
            margin-bottom: 0;
            display: none;
        }

        .image-preview-container.has-images {
            display: block;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px;
            background: rgba(0, 0, 0, 0.2);
        }

        .image-preview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }

        .preview-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
        }

        .preview-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(231, 76, 60, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Image Viewer Modal */
        .image-viewer-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .image-viewer-content {
            max-width: 90%;
            max-height: 90vh;
            position: relative;
        }

        .viewer-image {
            max-width: 100%;
            max-height: 90vh;
            object-fit: contain;
        }

        .viewer-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .viewer-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .viewer-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .viewer-nav:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .viewer-prev {
            left: 20px;
        }

        .viewer-next {
            right: 20px;
        }

        .viewer-counter {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
        }

        /* Scrollbar */
        .feed-content::-webkit-scrollbar,
        .modal-body::-webkit-scrollbar,
        .image-preview-container::-webkit-scrollbar {
            width: 6px;
        }

        .feed-content::-webkit-scrollbar-track,
        .modal-body::-webkit-scrollbar-track,
        .image-preview-container::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .feed-content::-webkit-scrollbar-thumb,
        .modal-body::-webkit-scrollbar-thumb,
        .image-preview-container::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 3px;
        }

        .feed-content::-webkit-scrollbar-thumb:hover,
        .modal-body::-webkit-scrollbar-thumb:hover,
        .image-preview-container::-webkit-scrollbar-thumb:hover {
            background: var(--accent-light);
        }
    </style>
</head>
<body>
    @include('components.navigation')

    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>Motivational Messages</h1>
                <p>Manage inspirational messages for students</p>
            </div>

            <div class="admin-actions">
                <!-- Removed notification and logout buttons -->
            </div>
        </div>

        <div class="feed-content">
            @if(session('success'))
                <div id="successAlert" style="background: rgba(46, 204, 113, 0.2); color: #2ecc71; padding: 15px; border-radius: 8px; margin-bottom: 20px; transition: opacity 0.5s ease-out;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="content-header">
                <div class="content-tabs">
                    <button class="tab-btn {{ request()->routeIs('motivational') ? 'active' : '' }}" onclick="window.location.href='{{ route('motivational') }}'">Active Messages</button>
                    <button class="tab-btn {{ request()->routeIs('motivational.archive') ? 'active' : '' }}" onclick="window.location.href='{{ route('motivational.archive') }}'">Archive</button>
                </div>
                <button class="btn btn-primary" onclick="openAddModal()">
                    <i class="fas fa-plus"></i>
                    Add Message
                </button>
            </div>

            <div class="motivational-container">
                <div class="table-container">
                    <table class="motivational-table">
                        <thead>
                            <tr>
                                <th>NO.</th>
                                <th>Message</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $index => $message)
                            <tr data-message-id="{{ $message->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td class="message-content">{{ Str::limit($message->message, 100) }}</td>
                                <td class="actions">
                                    <button class="btn-action view" onclick="viewMessage({{ $message->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action edit" onclick="editMessage({{ $message->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action archive" onclick="archiveMessage({{ $message->id }})">
                                        <i class="fas fa-archive"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="no-data">No motivational messages found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="messageModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add Motivational Message</h2>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="messageForm">
                    <div class="form-group">
                        <label for="message">Motivational Message</label>
                        <textarea id="message" name="message" class="form-control" rows="5" placeholder="Enter your motivational message..." required></textarea>
                    </div>
                    <div class="modal-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>View Motivational Message</h2>
                <button class="close-modal" onclick="closeViewModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div id="viewMessageContent" class="view-message-content"></div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeViewModal()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .motivational-container {
            padding: 30px;
        }

        .table-container {
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .motivational-table {
            width: 100%;
            border-collapse: collapse;
        }

        .motivational-table th,
        .motivational-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .motivational-table th {
            background: rgba(255, 255, 255, 0.05);
            font-weight: 600;
            color: var(--text);
        }

        .motivational-table td {
            color: var(--text-muted);
        }

        .motivational-table td:first-child {
            font-weight: 600;
            color: var(--accent);
            width: 80px;
        }

        .message-content {
            max-width: 500px;
            word-wrap: break-word;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

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

        .no-data {
            text-align: center;
            color: var(--text-muted);
            font-style: italic;
            padding: 40px !important;
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
            max-width: 600px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            color: var(--text);
            font-size: 20px;
            margin: 0;
        }

        .close-modal {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 24px;
            cursor: pointer;
            transition: var(--transition);
        }

        .close-modal:hover {
            color: var(--text);
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
            color: var(--text);
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
            font-size: 14px;
            resize: vertical;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .view-message-content {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 8px;
            color: var(--text);
            line-height: 1.6;
            white-space: pre-wrap;
        }
    </style>

    <script>
        let currentMessageId = null;

        // Open add modal
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add Motivational Message';
            document.getElementById('messageForm').reset();
            currentMessageId = null;
            document.getElementById('messageModal').style.display = 'flex';
        }

        // Close modal
        function closeModal() {
            document.getElementById('messageModal').style.display = 'none';
        }

        // Close view modal
        function closeViewModal() {
            document.getElementById('viewModal').style.display = 'none';
        }

        // View message
        async function viewMessage(id) {
            try {
                const response = await fetch(`/motivational/${id}`);
                const message = await response.json();

                document.getElementById('viewMessageContent').textContent = message.message;
                document.getElementById('viewModal').style.display = 'flex';
            } catch (error) {
                console.error('Error loading message:', error);
                alert('Error loading message');
            }
        }

        // Edit message
        async function editMessage(id) {
            try {
                const response = await fetch(`/motivational/${id}`);
                const message = await response.json();

                document.getElementById('modalTitle').textContent = 'Edit Motivational Message';
                document.getElementById('message').value = message.message;
                currentMessageId = id;
                document.getElementById('messageModal').style.display = 'flex';
            } catch (error) {
                console.error('Error loading message:', error);
                alert('Error loading message');
            }
        }

        // Archive message
        async function archiveMessage(id) {
            const confirmed = await showConfirmModal('Archive Message', 'Are you sure you want to archive this message?', 'Archive');
            if (confirmed) {
                try {
                    const response = await fetch(`/motivational/${id}/archive`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    if (response.ok) {
                        // Remove the message row from the DOM
                        const messageRow = document.querySelector(`[data-message-id="${id}"]`);
                        if (messageRow) {
                            messageRow.remove();
                        }
                        // Show success message
                        alert('Message archived successfully!');
                    } else {
                        alert('Error archiving message');
                    }
                } catch (error) {
                    console.error('Error archiving message:', error);
                    alert('Error archiving message');
                }
            }
        }

        // Handle form submission
        document.getElementById('messageForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('message', document.getElementById('message').value);

            try {
                let response;
                if (currentMessageId) {
                    // Update - use PUT method
                    formData.append('_method', 'PUT');
                    response = await fetch(`/motivational/${currentMessageId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    });
                } else {
                    // Create
                    response = await fetch('/motivational', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    });
                }

                if (response.ok) {
                    location.reload();
                } else {
                    alert('Error saving message');
                }
            } catch (error) {
                console.error('Error saving message:', error);
                alert('Error saving message');
            }
        });
    </script>
    @include('components.confirm-modal')
</body>
</html>

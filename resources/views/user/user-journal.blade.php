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
            width: 20px;
            font-size: 16px;
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
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .admin-info h3 {
            margin: 0;
            font-size: 14px;
        }

        .admin-info p {
            margin: 0;
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
            padding: 20px 30px;
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            align-items: center;
        }

        .notification-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--card-bg);
            color: var(--text);
            text-decoration: none;
            transition: var(--transition);
            position: relative;
        }

        .notification-btn:hover {
            background: var(--glass);
            transform: translateY(-2px);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #e74c3c;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
        }

        .journal-content {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
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
            background: var(--card-bg);
            color: var(--text-muted);
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
        }

        .tab-btn:hover {
            background: var(--glass);
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
            background: var(--accent-light);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--card-bg);
            color: var(--text);
        }

        .btn-secondary:hover {
            background: var(--glass);
        }

        .write-section {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 25px;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
        }

        .write-section h2 {
            margin-bottom: 20px;
            font-size: 20px;
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
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 200px;
        }

        .journal-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 20px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            transition: var(--transition);
        }

        .journal-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .journal-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .journal-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .journal-date {
            color: var(--text-muted);
            font-size: 13px;
        }

        .journal-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn:hover {
            background: var(--accent);
        }

        .action-btn.post-btn:hover {
            background: #27ae60;
        }

        .action-btn.archive-btn:hover {
            background: #f39c12;
        }

        .journal-content-preview {
            color: var(--text-muted);
            line-height: 1.6;
            max-height: 150px;
            overflow: hidden;
            position: relative;
        }

        .journal-content-preview.expanded {
            max-height: none;
        }

        .see-more-btn {
            color: var(--accent);
            background: none;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            font-size: 14px;
            padding: 0;
        }

        .see-more-btn:hover {
            text-decoration: underline;
        }

        .posted-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            background: rgba(39, 174, 96, 0.2);
            color: #27ae60;
            border-radius: 12px;
            font-size: 12px;
            margin-left: 10px;
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
            margin-bottom: 10px;
            color: var(--text);
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
            background: var(--primary);
            border-radius: var(--radius);
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
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
            font-size: 24px;
            cursor: pointer;
            transition: var(--transition);
        }

        .close-modal:hover {
            color: white;
        }

        .modal-body {
            padding: 20px;
            overflow-y: auto;
            flex: 1;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Scrollbar */
        .journal-content::-webkit-scrollbar,
        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .journal-content::-webkit-scrollbar-track,
        .modal-body::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .journal-content::-webkit-scrollbar-thumb,
        .modal-body::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 3px;
        }

        /* White placeholder text */
        .form-control::placeholder {
            color: white;
            opacity: 0.7;
        }

        /* Image Upload Styles */
        .image-upload-section {
            margin-bottom: 20px;
        }

        .image-upload-label {
            display: block;
            margin-bottom: 10px;
            color: var(--text);
            font-weight: 500;
        }

        .image-upload-container {
            border: 2px dashed rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .image-upload-container:hover {
            border-color: var(--accent);
            background: rgba(74, 144, 226, 0.1);
        }

        .image-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }

        .image-preview-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 1;
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-image-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(231, 76, 60, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        /* Layout Split */
        .journal-layout {
            display: grid;
            grid-template-columns: 70% 30%;
            gap: 20px;
            height: 100%;
        }

        .journal-main {
            overflow-y: auto;
        }

        .public-journal-sidebar {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 20px;
            overflow-y: auto;
            backdrop-filter: blur(10px);
        }

        .public-journal-sidebar h3 {
            margin-bottom: 20px;
            font-size: 18px;
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .reload-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: var(--transition);
            font-size: 14px;
        }

        .reload-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
        }

        .reload-btn:active {
            transform: scale(0.95);
        }

        /* Public Journal Card */
        .public-journal-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: var(--transition);
        }

        .public-journal-card:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .public-journal-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .public-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
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
            font-size: 15px;
            margin-bottom: 8px;
        }

        .public-journal-content {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 10px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .public-journal-images {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 5px;
            margin-bottom: 10px;
        }

        .public-journal-images img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
        }

        .image-overlay {
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
            font-size: 24px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
        }

        .image-overlay:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .image-grid-item {
            position: relative;
        }

        .public-journal-actions {
            display: flex;
            gap: 15px;
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .action-button {
            display: flex;
            align-items: center;
            gap: 5px;
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

        /* Toggle Switch */
        .toggle-public-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .toggle-switch {
            position: relative;
            width: 50px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.2);
            transition: 0.4s;
            border-radius: 24px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: var(--accent);
        }

        input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }

        /* Comments Section */
        .comments-section {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .comment-item {
            padding: 8px 0;
            font-size: 12px;
        }

        .comment-author {
            font-weight: 600;
            color: var(--text);
            margin-right: 5px;
        }

        .comment-text {
            color: var(--text-muted);
        }

        .comment-time {
            font-size: 10px;
            color: var(--text-muted);
            margin-left: 5px;
        }

        .comment-input-container {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .comment-input {
            flex: 1;
            padding: 8px 12px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
            font-size: 12px;
        }

        .comment-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .comment-send-btn {
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .comment-send-btn:hover {
            background: var(--accent-light);
        }

        /* Scrollbar for sidebar */
        .public-journal-sidebar::-webkit-scrollbar,
        .journal-main::-webkit-scrollbar {
            width: 6px;
        }

        .public-journal-sidebar::-webkit-scrollbar-track,
        .journal-main::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .public-journal-sidebar::-webkit-scrollbar-thumb,
        .journal-main::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <x-user-navigation />

    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>My Journal</h1>
                <p>Write your thoughts and share them with the community</p>
            </div>
        </div>

        <div class="journal-content">
            <div class="journal-layout">
                <div class="journal-main">
                    <div class="content-header">
                        <div class="content-tabs">
                            <button class="tab-btn active" data-tab="write">Write</button>
                            <button class="tab-btn" data-tab="my-journals">My Journals</button>
                            <button class="tab-btn" data-tab="archive">Archive</button>
                        </div>
                    </div>

            <!-- Write Section -->
            <div id="writeSection">
                <div class="write-section">
                    <h2>Write New Journal</h2>
                    <form id="journalForm">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" class="form-control" placeholder="Enter journal title..." required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea id="content" class="form-control" placeholder="Write your thoughts here..." required></textarea>
                        </div>
                        <div class="image-upload-section">
                            <label class="image-upload-label">Add picture about your day</label>
                            <div class="image-upload-container" onclick="document.getElementById('imageInput').click()">
                                <i class="fas fa-images" style="font-size: 32px; color: var(--text-muted); margin-bottom: 10px;"></i>
                                <p style="color: var(--text-muted); margin: 0;">Click to upload images</p>
                            </div>
                            <input type="file" id="imageInput" accept="image/*" multiple style="display: none;">
                            <div id="imagePreviewGrid" class="image-preview-grid"></div>
                        </div>
                        <div class="toggle-public-container">
                            <label class="toggle-switch">
                                <input type="checkbox" id="makePublic">
                                <span class="toggle-slider"></span>
                            </label>
                            <span style="color: var(--text);">Make this journal public</span>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Save Journal
                        </button>
                    </form>
                </div>
            </div>

            <!-- My Journals Section -->
            <div id="myJournalsSection" style="display: none;">
                @forelse($journals as $journal)
                <div class="journal-card" data-journal-id="{{ $journal->id }}">
                    <div class="journal-header">
                        <div>
                            <div class="journal-title">
                                {{ $journal->title }}
                                @if($journal->is_posted)
                                <span class="posted-badge">
                                    <i class="fas fa-check-circle"></i>
                                    Posted
                                </span>
                                @endif
                                @if($journal->is_public)
                                <span class="posted-badge" style="background: #27ae60; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 15px; text-align: center; min-width: 80px; border: 1px solid #27ae60;">
                                    <i class="fas fa-globe" style="color: #fff; margin-right: 6px;"></i>
                                    <span style="width:100%;text-align:center; color: #fff;">Public</span>
                                </span>
                                @endif
                            </div>
                            <div class="journal-date">{{ $journal->created_at->format('M d, Y • g:i A') }}</div>
                        </div>
                        <div class="journal-actions">
                            <button class="action-btn" onclick="toggleJournalPublic({{ $journal->id }}, event)" title="{{ $journal->is_public ? 'Make Private' : 'Make Public' }}">
                                <i class="fas fa-{{ $journal->is_public ? 'globe' : 'lock' }}"></i>
                            </button>
                            <button class="action-btn archive-btn" onclick="archiveJournal({{ $journal->id }})" title="Archive">
                                <i class="fas fa-archive"></i>
                            </button>
                        </div>
                    </div>
                    <div class="journal-content-preview" id="preview-{{ $journal->id }}">
                        {{ Str::limit($journal->content, 300) }}
                    </div>
                    @if(strlen($journal->content) > 300)
                    <button class="see-more-btn" onclick="toggleContent({{ $journal->id }})">
                        See more
                    </button>
                    @endif
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-book"></i>
                    <h3>No Journals Yet</h3>
                    <p>Start writing your first journal entry!</p>
                </div>
                @endforelse
            </div>

            <!-- Archive Section -->
            <div id="archiveSection" style="display: none;">
                <div id="archiveContent"></div>
            </div>
                </div><!-- Close journal-main -->
                
                <!-- Public Journal Sidebar -->
                <div class="public-journal-sidebar">
                    <h3><i class="fas fa-globe"></i> Public Journals <button onclick="loadPublicJournals(true)" class="reload-btn" title="Reload Public Journals"><i class="fas fa-sync-alt"></i></button></h3>
                    <div id="publicJournalsContainer">
                        <div style="text-align: center; padding: 20px; color: var(--text-muted);">
                            <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
                            <p style="margin-top: 10px;">Loading public journals...</p>
                        </div>
                    </div>
                </div>
            </div><!-- Close journal-layout -->
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Journal</h2>
                <button class="close-modal">&times;</button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="editJournalId">
                    <div class="form-group">
                        <label for="editTitle">Title</label>
                        <input type="text" id="editTitle" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editContent">Content</label>
                        <textarea id="editContent" class="form-control" rows="10" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab switching
        const tabBtns = document.querySelectorAll('.tab-btn');
        const writeSection = document.getElementById('writeSection');
        const myJournalsSection = document.getElementById('myJournalsSection');
        const archiveSection = document.getElementById('archiveSection');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.getAttribute('data-tab');
                tabBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                writeSection.style.display = tab === 'write' ? 'block' : 'none';
                myJournalsSection.style.display = tab === 'my-journals' ? 'block' : 'none';
                archiveSection.style.display = tab === 'archive' ? 'block' : 'none';

                if (tab === 'archive') {
                    loadArchive();
                }
            });
        });

        // Image upload handling
        let selectedImages = [];
        const imageInput = document.getElementById('imageInput');
        const imagePreviewGrid = document.getElementById('imagePreviewGrid');

        imageInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            files.forEach(file => {
                selectedImages.push(file);
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'image-preview-item';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="remove-image-btn" onclick="removeImage(${selectedImages.length - 1})">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    imagePreviewGrid.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });

        function removeImage(index) {
            selectedImages.splice(index, 1);
            imagePreviewGrid.innerHTML = '';
            selectedImages.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'image-preview-item';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="remove-image-btn" onclick="removeImage(${idx})">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    imagePreviewGrid.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        // Save journal
        document.getElementById('journalForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const title = document.getElementById('title').value;
            const content = document.getElementById('content').value;
            const isPublic = document.getElementById('makePublic').checked;

            const formData = new FormData();
            formData.append('title', title);
            formData.append('content', content);
            formData.append('is_public', isPublic ? '1' : '0');
            
            selectedImages.forEach((image, index) => {
                formData.append(`images[${index}]`, image);
            });

            try {
                const response = await fetch('/user/journal', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                const data = await response.json();
                
                if (data.success) {
                    showNotification('Journal saved successfully!', 'success');
                    document.getElementById('title').value = '';
                    document.getElementById('content').value = '';
                    document.getElementById('makePublic').checked = false;
                    selectedImages = [];
                    imagePreviewGrid.innerHTML = '';
                    
                    // If journal was made public, refresh the public journals section
                    if (isPublic) {
                        refreshPublicJournals();
                    }
                    
                    // Reload page after a short delay to show changes
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            } catch (error) {
                console.error('Error saving journal:', error);
                showNotification('Error saving journal. Please try again.', 'error');
            }
        });

        // Toggle content
        function toggleContent(id) {
            const preview = document.getElementById('preview-' + id);
            const btn = event.target;
            
            if (preview.classList.contains('expanded')) {
                preview.classList.remove('expanded');
                btn.textContent = 'See more';
            } else {
                preview.classList.add('expanded');
                btn.textContent = 'See less';
            }
        }

        // Edit journal
        const editModal = document.getElementById('editModal');
        const closeModalBtns = document.querySelectorAll('.close-modal');

        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                editModal.style.display = 'none';
            });
        });

        // Function to edit journal
        async function editJournal(id) {
            // Get journal data and populate modal
            try {
                const response = await fetch(`/user/journal/${id}`);
                const journal = await response.json();
                
                document.getElementById('editTitle').value = journal.title;
                document.getElementById('editContent').value = journal.content;
                document.getElementById('editJournalId').value = id;
                
                editModal.style.display = 'flex';
            } catch (error) {
                console.error('Error loading journal:', error);
                showNotification('Error loading journal for editing.', 'error');
            }
        }

        // Save edited journal
        document.getElementById('saveEditBtn').addEventListener('click', async () => {
            const id = document.getElementById('editJournalId').value;
            const title = document.getElementById('editTitle').value;
            const content = document.getElementById('editContent').value;

            try {
                const response = await fetch(`/user/journal/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ title, content })
                });

                const data = await response.json();
                
                if (data.success) {
                    showNotification('Journal updated successfully!', 'success');
                    editModal.style.display = 'none';
                    location.reload();
                }
            } catch (error) {
                console.error('Error updating journal:', error);
                showNotification('Error updating journal. Please try again.', 'error');
            }
        });

        // View journal (for future expansion - currently not needed as content is shown)
        function viewJournal(id) {
            // This function is reserved for future modal/detail view
            // For now, journals are displayed inline
            console.log('View journal:', id);
        }

        // Archive journal
        async function archiveJournal(id) {
            console.log('archiveJournal called with id:', id);
            try {
                console.log('Archive button clicked for journal:', id);
                const confirmed = await showConfirmModal('Archive Journal', 'Are you sure you want to archive this journal?', 'Archive');
                console.log('Modal result:', confirmed);
                if (!confirmed) {
                    console.log('User cancelled archive');
                    return;
                }

                console.log('User confirmed archive, making API call...');
                const response = await fetch(`/user/journal/${id}/archive`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                console.log('API response:', response.status, response.ok);
                if (response.ok) {
                    showNotification('Journal archived successfully!', 'success');
                    console.log('About to reload page after archive');
                    location.reload();
                } else {
                    const errorData = await response.text();
                    console.error('API error:', errorData);
                    showNotification('Failed to archive journal', 'error');
                }
            } catch (error) {
                console.error('Error in archiveJournal:', error);
                showNotification('Error archiving journal', 'error');
            }
        }

        // Post journal
        async function postJournal(id) {
            const confirmed = await showConfirmModal('Post Journal', 'Are you sure you want to post this journal to the public feed? Everyone will be able to see it.', 'Post');
            if (!confirmed) return;

            try {
                const response = await fetch(`/user/journal/${id}/post`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    showNotification(data.message, 'success');
                    location.reload();
                } else {
                    showNotification('Failed to post journal', 'error');
                }
            } catch (error) {
                console.error('Error posting journal:', error);
                showNotification('Error posting journal. Please try again.', 'error');
            }
        }        // Load archive
        async function loadArchive() {
            try {
                const response = await fetch('/user/journal-archive');
                const journals = await response.json();
                const archiveContent = document.getElementById('archiveContent');
                
                if (journals.length === 0) {
                    archiveContent.innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-archive"></i>
                            <h3>No Archived Journals</h3>
                            <p>Archived journals will appear here.</p>
                        </div>
                    `;
                    return;
                }

                archiveContent.innerHTML = journals.map(journal => `
                    <div class="journal-card">
                        <div class="journal-header">
                            <div>
                                <div class="journal-title">${journal.title}</div>
                                <div class="journal-date">${new Date(journal.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</div>
                            </div>
                            <div class="journal-actions">
                                <button class="action-btn" onclick="unarchiveJournal(${journal.id})" title="Unarchive">
                                    <i class="fas fa-box-open"></i>
                                </button>
                                <button class="action-btn" onclick="deleteJournal(${journal.id})" title="Delete" style="color: #e74c3c;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="journal-content-preview">${journal.content}</div>
                    </div>
                `).join('');
            } catch (error) {
                console.error('Error loading archive:', error);
            }
        }

        // Unarchive journal
        async function unarchiveJournal(id) {
            console.log('unarchiveJournal called with id:', id);
            const confirmed = await showConfirmModal('Unarchive Journal', 'Are you sure you want to unarchive this journal?', 'Unarchive');
            console.log('unarchiveJournal modal result:', confirmed);
            if (!confirmed) return;

            try {
                const response = await fetch(`/user/journal/${id}/unarchive`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.ok) {
                    showNotification('Journal unarchived successfully!', 'success');
                    console.log('About to reload page after unarchive');
                    location.reload();
                } else {
                    showNotification('Failed to unarchive journal', 'error');
                }
            } catch (error) {
                console.error('Error unarchiving journal:', error);
                showNotification('Error unarchiving journal', 'error');
            }
        }

        // Delete journal
        async function deleteJournal(id) {
            console.log('deleteJournal called with id:', id);
            const confirmed = await showConfirmModal('Delete Journal', 'Are you sure you want to delete this journal permanently? This action cannot be undone.', 'Delete', true);
            console.log('deleteJournal modal result:', confirmed);
            if (!confirmed) return;

            try {
                const response = await fetch(`/user/journal/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.ok) {
                    showNotification('Journal deleted successfully!', 'success');
                    console.log('About to reload page after delete');
                    location.reload();
                } else {
                    showNotification('Failed to delete journal', 'error');
                }
            } catch (error) {
                console.error('Error deleting journal:', error);
                showNotification('Error deleting journal', 'error');
            }
        }

        // Load public journals
        async function loadPublicJournals(force = false) {
            const container = document.getElementById('publicJournalsContainer');
            
            // Show loading state immediately
            container.innerHTML = `
                <div style="text-align: center; padding: 20px; color: var(--text-muted);">
                    <i class="fas fa-spinner fa-spin" style="font-size: 24px; margin-bottom: 10px;"></i>
                    <p>Loading public journals...</p>
                </div>
            `;
            
            try {
                const startTime = Date.now();
                
                // Add cache-busting parameter if forced
                const url = force ? '/user/journal-public?t=' + Date.now() : '/user/journal-public';
                
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Cache-Control': force ? 'no-cache' : 'default'
                    }
                });
                
                const loadTime = Date.now() - startTime;
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                const journals = await response.json();
                
                if (!Array.isArray(journals) || journals.length === 0) {
                    container.innerHTML = `
                        <div style="text-align: center; padding: 20px; color: var(--text-muted);">
                            <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 10px;"></i>
                            <p>No public journals yet</p>
                            <p style="font-size: 12px; margin-top: 5px;">Mark journals as public to see them here</p>
                        </div>
                    `;
                    return;
                }
                
                // Render journals quickly
                const renderStart = Date.now();
                container.innerHTML = journals.map(journal => {
                    // Truncate content if too long
                    const maxLength = 300;
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
                            <button class="action-button ${journal.is_liked ? 'liked' : ''}" onclick="likePublicJournal(${journal.id})">
                                <i class="fas fa-heart"></i>
                                <span id="like-count-${journal.id}">${journal.likes_count || 0}</span>
                            </button>
                            <button class="action-button" onclick="toggleComments(${journal.id})">
                                <i class="fas fa-comment"></i>
                                <span>${journal.comments_count || 0}</span>
                            </button>
                        </div>
                        <div class="comments-section" id="comments-${journal.id}" style="display: none;">
                            <div id="comments-list-${journal.id}">
                                ${Array.isArray(journal.comments) ? journal.comments.map(comment => `
                                    <div class="comment-item">
                                        <span class="comment-author">${comment.user_name || 'User'}</span>
                                        <span class="comment-text">${comment.comment || ''}</span>
                                        <span class="comment-time">${comment.created_at || ''}</span>
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
                }).join('');
            } catch (error) {
                console.error('Error loading public journals:', error);
                container.innerHTML = `
                    <div style="text-align: center; padding: 20px; color: #e74c3c;">
                        <i class="fas fa-exclamation-circle" style="font-size: 32px; margin-bottom: 10px;"></i>
                        <p>Error loading public journals</p>
                        <p style="font-size: 12px; margin-top: 5px;">${error.message}</p>
                        <button onclick="loadPublicJournals()" style="margin-top: 10px; padding: 8px 16px; background: var(--accent); color: white; border: none; border-radius: 8px; cursor: pointer;">Retry</button>
                    </div>
                `;
            }
        }

        // Toggle journal public status
        async function toggleJournalPublic(journalId, event) {
            try {
                const response = await fetch(`/user/journal/${journalId}/toggle-public`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    showNotification(data.message, 'success');
                    
                    // Update the button icon and tooltip for this specific journal
                    const button = event.target.closest('.action-btn');
                    if (button) {
                        const icon = button.querySelector('i');
                        const newIcon = data.is_public ? 'globe' : 'lock';
                        const newTitle = data.is_public ? 'Make Private' : 'Make Public';
                        icon.className = `fas fa-${newIcon}`;
                        button.title = newTitle;
                    }
                    
                    // Update the status badge in the journal header
                    const journalCard = button.closest('.journal-card');
                    if (journalCard) {
                        const statusBadgeContainer = journalCard.querySelector('.journal-header > div:first-child');
                        if (statusBadgeContainer) {
                            // Remove existing badge
                            const existingBadge = statusBadgeContainer.querySelector('.posted-badge');
                            if (existingBadge) {
                                existingBadge.remove();
                            }
                            
                            // Add new badge if public
                            if (data.is_public) {
                                const newBadge = document.createElement('span');
                                newBadge.className = 'posted-badge';
                                newBadge.style.cssText = 'background: #27ae60; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 15px; text-align: center; min-width: 80px; border: 1px solid #27ae60;';
                                newBadge.innerHTML = '<i class="fas fa-globe" style="color: #fff; margin-right: 6px;"></i><span style="width:100%;text-align:center; color: #fff;">Public</span>';
                                statusBadgeContainer.appendChild(newBadge);
                            }
                        }
                    }
                    
                    // Refresh public journals section immediately
                    await refreshPublicJournals();
                }
            } catch (error) {
                console.error('Error toggling public status:', error);
                showNotification('Error toggling public status', 'error');
            }
        }

        // Like public journal
        async function likePublicJournal(journalId) {
            try {
                const response = await fetch(`/user/journal/${journalId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    const likeBtn = event.target.closest('.action-button');
                    const likeCount = document.getElementById(`like-count-${journalId}`);
                    
                    if (data.liked) {
                        likeBtn.classList.add('liked');
                    } else {
                        likeBtn.classList.remove('liked');
                    }
                    
                    likeCount.textContent = data.likes_count;
                }
            } catch (error) {
                console.error('Error liking journal:', error);
            }
        }

        // Toggle comments section
        function toggleComments(journalId) {
            const commentsSection = document.getElementById(`comments-${journalId}`);
            commentsSection.style.display = commentsSection.style.display === 'none' ? 'block' : 'none';
        }

        // Add comment
        async function addComment(journalId) {
            const input = document.getElementById(`comment-input-${journalId}`);
            const comment = input.value.trim();
            if (!comment) return;

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
                    newComment.innerHTML = `
                        <span class="comment-author">${data.comment.user_name}</span>
                        <span class="comment-text">${data.comment.comment}</span>
                        <span class="comment-time">${data.comment.created_at}</span>
                    `;
                    commentsList.appendChild(newComment);
                    input.value = '';
                }
            } catch (error) {
                console.error('Error adding comment:', error);
                showNotification('Error adding comment', 'error');
            }
        }

        // Load public journals on page load - called immediately
        document.addEventListener('DOMContentLoaded', function() {
            loadPublicJournals();

            // Fallback: If still loading after 5 seconds, force refresh
            setTimeout(() => {
                const container = document.getElementById('publicJournalsContainer');
                if (container && container.innerHTML.includes('Loading public journals')) {
                    loadPublicJournals(true);
                }
            }, 5000);
        });
        
        // Function to refresh public journals (can be called after toggling)
        function refreshPublicJournals() {
            loadPublicJournals(true); // Force refresh with cache busting
        }

    </script>
    
    <!-- Confirm Modal -->
    <div id="confirmModal" class="confirm-modal" style="display: none;">
        <div class="confirm-modal-overlay"></div>
        <div class="confirm-modal-content">
            <div class="confirm-modal-header">
                <i class="fas fa-exclamation-circle confirm-modal-icon"></i>
                <h3 id="confirmModalTitle">Confirm Action</h3>
            </div>
            <div class="confirm-modal-body">
                <p id="confirmModalMessage">Are you sure you want to proceed?</p>
            </div>
            <div class="confirm-modal-footer">
                <button type="button" class="confirm-modal-btn confirm-modal-btn-cancel" onclick="closeConfirmModal()">Cancel</button>
                <button type="button" class="confirm-modal-btn confirm-modal-btn-confirm" id="confirmModalBtn">Confirm</button>
            </div>
        </div>
    </div>

    <style>
        .confirm-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .confirm-modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 1;
        }
        
        .confirm-modal-content {
            position: relative;
            background: linear-gradient(135deg, #6bb3ff 0%, #4a90e2 100%);
            border-radius: 12px;
            width: 90%;
            max-width: 450px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            animation: modalSlideIn 0.3s ease-out;
            z-index: 2;
            pointer-events: auto;
        }
        
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .confirm-modal-header {
            padding: 25px 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .confirm-modal-icon {
            font-size: 28px;
            color: #f39c12;
        }
        
        .confirm-modal-header h3 {
            margin: 0;
            font-size: 20px;
            color: #e6f0f7;
            font-weight: 600;
        }
        
        .confirm-modal-body {
            padding: 25px;
        }
        
        .confirm-modal-body p {
            margin: 0;
            font-size: 15px;
            color: #b8d0e0;
            line-height: 1.6;
        }
        
        .confirm-modal-footer {
            padding: 20px 25px 25px;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }
        
        .confirm-modal-btn {
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .confirm-modal-btn-cancel {
            background: rgba(255, 255, 255, 0.1);
            color: #e6f0f7;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .confirm-modal-btn-cancel:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }
        
        .confirm-modal-btn-confirm {
            background: linear-gradient(90deg, #4a90e2, #6bb3ff);
            color: white;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
        }
        
        .confirm-modal-btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.6);
        }
        
        .confirm-modal-btn-confirm.danger {
            background: linear-gradient(90deg, #e74c3c, #c0392b);
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
        }
        
        .confirm-modal-btn-confirm.danger:hover {
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.6);
        }
    </style>
    
    <script>
        let confirmModalCallback = null;
        
        function showConfirmModal(title, message, confirmText = 'Confirm', isDanger = false) {
            return new Promise((resolve) => {
                console.log('showConfirmModal called with:', { title, message, confirmText, isDanger });
                const modal = document.getElementById('confirmModal');
                const titleEl = document.getElementById('confirmModalTitle');
                const messageEl = document.getElementById('confirmModalMessage');
                const confirmBtn = document.getElementById('confirmModalBtn');
                
                if (!modal || !titleEl || !messageEl || !confirmBtn) {
                    console.error('Confirm modal elements not found');
                    resolve(false);
                    return;
                }
                
                titleEl.textContent = title;
                messageEl.textContent = message;
                confirmBtn.textContent = confirmText;
                
                if (isDanger) {
                    confirmBtn.classList.add('danger');
                } else {
                    confirmBtn.classList.remove('danger');
                }
                
                modal.style.display = 'flex';
                modal.classList.add('show');
                console.log('Modal displayed');
                
                // Reset any previous event handlers
                confirmBtn.onclick = null;
                
                confirmModalCallback = (confirmed) => {
                    console.log('Confirm modal callback called with:', confirmed);
                    closeConfirmModal(false); // Don't call callback again
                    resolve(confirmed);
                };
                
                // Set up confirm button
                confirmBtn.onclick = () => {
                    console.log('Confirm button clicked');
                    confirmModalCallback(true);
                };
            });
        }
        
        function closeConfirmModal(shouldCallCallback = true) {
            console.log('closeConfirmModal called, shouldCallCallback:', shouldCallCallback);
            const modal = document.getElementById('confirmModal');
            const confirmBtn = document.getElementById('confirmModalBtn');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
                console.log('Modal hidden');
            }
            // Reset button event handler
            if (confirmBtn) {
                confirmBtn.onclick = null;
            }
            if (confirmModalCallback && shouldCallCallback) {
                console.log('Calling callback with false');
                confirmModalCallback(false);
            }
            confirmModalCallback = null; // Always clean up
        }
        
        // Close on overlay click
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('confirmModal');
            if (modal) {
                modal.querySelector('.confirm-modal-overlay').addEventListener('click', closeConfirmModal);
            }
        });
        
        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('confirmModal');
                if (modal && modal.style.display === 'flex') {
                    closeConfirmModal();
                }
            }
        });
        
        // Simple notification function
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : '#3498db'};
                color: white;
                padding: 12px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                z-index: 10000;
                font-weight: 500;
                max-width: 300px;
                animation: slideInRight 0.3s ease;
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
        
        // Add animation styles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>

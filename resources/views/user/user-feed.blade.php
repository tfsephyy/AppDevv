<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <title>MindEase — Feed</title>
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
            word-break: break-word;
            overflow-wrap: break-word;
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
            word-break: break-word;
            overflow-wrap: break-word;
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
            padding: 4px 0;
            width: max-content;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.18);
            z-index: 1500;
            display: none;
            backdrop-filter: blur(10px);
            overflow: hidden;
            white-space: nowrap;
        }

        .context-menu-item {
            padding: 8px 10px;
            color: var(--text);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            min-width: 0;
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

        /* Chat-style modal (reused from public chat) */
        .chat-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .chat-modal-overlay.active { display: flex; }

        .chat-modal-box {
            background: var(--card-bg);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            width: 100%;
            max-width: 680px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(8px);
        }

        .chat-modal-header {
            padding: 14px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .chat-modal-body { padding: 14px 18px; }

        .chat-modal-footer {
            padding: 12px 16px;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            border-top: 1px solid rgba(255,255,255,0.04);
        }

        .chat-btn { padding: 8px 14px; border-radius: 8px; cursor: pointer; border: none; }
        .chat-btn-primary { background: linear-gradient(90deg,var(--accent),var(--accent-light)); color: white; }
        .chat-btn-cancel { background: rgba(255,255,255,0.06); color: var(--text); }

        .chat-edit-textarea { width: 100%; min-height: 100px; padding: 10px 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.03); color: var(--text); }

        /* Toast styles moved to toast-notification component */

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
            z-index: 1000;
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

        /* =====================================================
           MOBILE STYLES — feed page only (≤ 768px)
           ===================================================== */
        @media (max-width: 768px) {

            body { overflow-x: hidden !important; }

            .main-content {
                overflow: visible !important;
                height: auto !important;
                flex: 1 0 auto !important;
                min-height: calc(100vh - 60px);
            }

            .feed-content {
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

            /* Post card */
            .post-card {
                padding: 14px !important;
            }

            /* Stack comment form on very small screens */
            .comment-form {
                flex-wrap: wrap !important;
            }

            .comment-input {
                min-width: 0 !important;
                flex: 1 1 100% !important;
            }

            .comment-btn {
                flex-shrink: 0 !important;
            }

            /* Reduce reply indent so text stays inside card */
            .comment.reply {
                margin-left: 24px !important;
            }

            .comment-text {
                margin-left: 36px !important;
            }

            .comment-actions {
                margin-left: 36px !important;
            }

            /* Stack post images in single column */
            .post-images.double,
            .post-images.triple,
            .post-images.multiple {
                grid-template-columns: 1fr !important;
            }

            .post-image-wrapper {
                height: 200px !important;
            }

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
                justify-content: center !important;
            }
        }
    </style>
</head>
<body>
    <x-user-navigation />

    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>Community Feed</h1>
                <p>See what's happening in the MindEase community</p>
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
                    <button class="tab-btn active" data-tab="posts">Posts</button>
                </div>
            </div>

            <div id="postsSection">
                @forelse($posts as $post)
                <div class="post-card" data-post-id="{{ $post->id }}">
                    <div class="post-header">
                        <div class="post-author">
                            <div class="author-avatar">AD</div>
                            <div class="author-info">
                                <h3>Admin</h3>
                                <p>{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="post-content">
                        {{ $post->content }}
                    </div>

                    @if($post->images && count($post->images) > 0)
                    <div class="post-images {{ count($post->images) === 1 ? 'single' : (count($post->images) === 2 ? 'double' : (count($post->images) === 3 ? 'triple' : 'multiple')) }}" data-post-id="{{ $post->id }}">
                        @php
                            $displayImages = array_slice($post->images, 0, 3);
                            $remainingCount = count($post->images) - 3;
                        @endphp
                        @foreach($displayImages as $index => $image)
                        <div class="post-image-wrapper" onclick="openImageViewer({{ $post->id }}, {{ $index }})">
                            <img src="{{ asset('storage/' . $image) }}" alt="Post image" class="post-image">
                            @if($index === 2 && $remainingCount > 0)
                            <div class="more-images-overlay">
                                +{{ $remainingCount }}
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="post-actions">
                        <button class="action-btn like-btn {{ $post->user_has_liked ? 'liked' : '' }}" onclick="toggleLike({{ $post->id }})">
                            <i class="{{ $post->user_has_liked ? 'fas' : 'far' }} fa-heart"></i>
                            <span class="likes-count">{{ $post->likes_count }}</span>
                        </button>
                        <button class="action-btn" onclick="toggleComments({{ $post->id }})">
                            <i class="far fa-comment"></i>
                            <span>{{ $post->all_comments_count }}</span>
                        </button>
                    </div>

                    <div class="comments-section" id="comments-{{ $post->id }}" style="display: none;">
                        <div class="comment-form">
                            <input type="text" class="comment-input" placeholder="Write a comment..." id="comment-input-{{ $post->id }}" onkeypress="if(event.key==='Enter'){addComment({{ $post->id }}); return false;}">
                            <button class="comment-btn" onclick="addComment({{ $post->id }})">Post</button>
                        </div>
                        <div id="comments-list-{{ $post->id }}"></div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-newspaper"></i>
                    <h3>No Posts Yet</h3>
                    <p>Be the first to share something!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Image Viewer Modal -->
    <div class="image-viewer-modal" id="imageViewerModal">
        <div class="viewer-close" onclick="closeImageViewer()">&times;</div>
        <button class="viewer-nav viewer-prev" onclick="previousImage()"><i class="fas fa-chevron-left"></i></button>
        <div class="image-viewer-content">
            <img src="" alt="Full size image" class="viewer-image" id="viewerImage">
            <div class="viewer-counter" id="viewerCounter"></div>
        </div>
        <button class="viewer-nav viewer-next" onclick="nextImage()"><i class="fas fa-chevron-right"></i></button>
    </div>

    <!-- Comment Context Menu -->
    <div class="comment-context-menu" id="commentContextMenu">
        <div class="context-menu-item" onclick="replyToComment()">
            <i class="fas fa-reply"></i> Reply
        </div>
        <div class="context-menu-item" onclick="editComment()">
            <i class="fas fa-edit"></i> Edit
        </div>
        <div class="context-menu-item delete" onclick="deleteComment()">
            <i class="fas fa-trash"></i> Delete
        </div>
    </div>

    <!-- Edit Comment Modal -->
    <div class="chat-modal-overlay" id="editCommentModal">
        <div class="chat-modal-box">
            <div class="chat-modal-header">
                <h3><i class="fas fa-edit" style="margin-right:8px;color:var(--primary)"></i>Edit Comment</h3>
                <button class="chat-modal-close" id="editCommentModalClose">&times;</button>
            </div>
            <div class="chat-modal-body">
                <textarea class="chat-edit-textarea" id="editCommentTextarea" placeholder="Edit your comment..."></textarea>
            </div>
            <div class="chat-modal-footer">
                <button class="chat-btn chat-btn-cancel" id="editCommentCancel">Cancel</button>
                <button class="chat-btn chat-btn-primary" id="editCommentSave"><i class="fas fa-check" style="margin-right:6px"></i>Save</button>
            </div>
        </div>
    </div>

    <script>
        // Store all post images for viewer
        const postImages = {
            @foreach($posts as $post)
                @if($post->images && count($post->images) > 0)
                {{ $post->id }}: {!! json_encode(array_map(fn($img) => asset('storage/' . $img), $post->images)) !!},
                @endif
            @endforeach
        };

        let currentPostId = null;
        let currentImageIndex = 0;
        let contextMenuCommentId = null;
        let contextMenuPostId = null;
        const currentUserId = '{{ $currentUserId ?? '' }}';

        // Comment context menu
        function showCommentMenu(event, commentId, postId) {
            event.preventDefault();
            showCommentMenuAt(event.pageX, event.pageY, commentId, postId);
        }

        function showCommentMenuAt(pageX, pageY, commentId, postId) {
            contextMenuCommentId = commentId;
            contextMenuPostId = postId;
            const menu = document.getElementById('commentContextMenu');

            // Show/hide options based on ownership
            // menu items: Reply (0), Edit (1), Delete (2)
            const editItem = menu.querySelectorAll('.context-menu-item')[1];
            const deleteItem = menu.querySelectorAll('.context-menu-item')[2];
            const replyItem = menu.querySelectorAll('.context-menu-item')[0];

            // Determine ownership by comparing comment's data-user-id attribute if present
            const commentEl = document.querySelector(`[data-comment-id="${commentId}"]`);
            const messageUserId = commentEl ? commentEl.getAttribute('data-user-id') : null;
            const isOwn = messageUserId && (String(messageUserId) === String(currentUserId));

            if (isOwn) {
                editItem.style.display = 'flex';
                deleteItem.style.display = 'flex';
                replyItem.style.display = 'none';
            } else {
                editItem.style.display = 'none';
                deleteItem.style.display = 'none';
                replyItem.style.display = 'flex';
            }

            menu.style.display = 'block';
            // clamp menu to viewport
            const vw = window.innerWidth;
            const vh = window.innerHeight;
            const menuW = menu.offsetWidth;
            const menuH = menu.offsetHeight;
            const x = Math.min(Math.max(8, pageX), vw - menuW - 8);
            let y = Math.min(Math.max(8, pageY), vh - menuH - 8);
            menu.style.left = x + 'px';
            menu.style.top = y + 'px';
        }

        function hideCommentMenu() {
            document.getElementById('commentContextMenu').style.display = 'none';
        }

        // Close context menu when clicking anywhere else
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.comment-context-menu')) {
                hideCommentMenu();
            }
        });

        // Mobile: long-press or tap to open comment menu
        (function() {
            let touchTimer = null;
            let touchMoved = false;
            let startX = 0, startY = 0;
            let suppressNextClick = false;

            document.addEventListener('touchstart', function(e) {
                const commentEl = e.target.closest('.comment');
                if (!commentEl) return;
                touchMoved = false;
                startX = e.touches[0].pageX;
                startY = e.touches[0].pageY;

                touchTimer = setTimeout(function() {
                    if (!touchMoved) {
                        const commentId = commentEl.getAttribute('data-comment-id');
                        const postEl = commentEl.closest('.post-card');
                        const postId = postEl ? postEl.getAttribute('data-post-id') : null;
                        showCommentMenuAt(startX, startY, commentId, postId);
                        suppressNextClick = true;
                    }
                }, 500);
            }, { passive: true });

            document.addEventListener('touchmove', function(e) {
                const dx = Math.abs(e.touches[0].pageX - startX);
                const dy = Math.abs(e.touches[0].pageY - startY);
                if (dx > 8 || dy > 8) {
                    touchMoved = true;
                    clearTimeout(touchTimer);
                }
            }, { passive: true });

            document.addEventListener('touchend', function(e) {
                clearTimeout(touchTimer);
                if (touchMoved) return;
                // if tap (not long press), open menu briefly
                const commentEl = e.target.closest('.comment');
                if (commentEl) {
                    const commentId = commentEl.getAttribute('data-comment-id');
                    const postEl = commentEl.closest('.post-card');
                    const postId = postEl ? postEl.getAttribute('data-post-id') : null;
                    showCommentMenuAt(startX || e.changedTouches[0].pageX, startY || e.changedTouches[0].pageY, commentId, postId);
                    suppressNextClick = true;
                }
            });

            // ignore synthetic click after touch
            document.addEventListener('click', function(e) {
                if (suppressNextClick) { suppressNextClick = false; e.preventDefault(); return; }
            }, true);
        })();

        function replyToComment() {
            hideCommentMenu();
            showReplyForm(contextMenuCommentId, contextMenuPostId);
        }

        // --- Toast helper (unified) ---
        function showChatToast(message, isError = false) {
            showToast(message, isError ? 'error' : 'success');
        }

        // --- Edit comment modal ---
        const editCommentModal = document.getElementById('editCommentModal');
        const editCommentTextarea = document.getElementById('editCommentTextarea');
        const editCommentModalClose = document.getElementById('editCommentModalClose');
        const editCommentCancel = document.getElementById('editCommentCancel');
        const editCommentSave = document.getElementById('editCommentSave');
        let editingCommentId = null;

        function openEditCommentModal(commentId, currentText) {
            editingCommentId = commentId;
            editCommentTextarea.value = currentText;
            editCommentModal.classList.add('active');
            setTimeout(() => { editCommentTextarea.focus(); editCommentTextarea.select(); }, 50);
        }
        function closeEditCommentModal() {
            editingCommentId = null;
            editCommentModal.classList.remove('active');
            editCommentTextarea.value = '';
        }
        editCommentModalClose.addEventListener('click', closeEditCommentModal);
        editCommentCancel.addEventListener('click', closeEditCommentModal);
        editCommentModal.addEventListener('click', function(e) { if (e.target === editCommentModal) closeEditCommentModal(); });
        editCommentSave.addEventListener('click', async function() {
            const newText = editCommentTextarea.value.trim();
            if (!newText) return;
            if (!editingCommentId) return closeEditCommentModal();
            // Capture IDs BEFORE closeEditCommentModal() nulls editingCommentId
            const commentIdToEdit = editingCommentId;
            const postIdToReload = contextMenuPostId;
            closeEditCommentModal();
            try {
                const response = await fetch(`/user/feed/comment/${commentIdToEdit}`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    body: JSON.stringify({ comment: newText })
                });

                if (response.ok) {
                    showChatToast('Comment updated successfully.');
                    await loadComments(postIdToReload);
                } else {
                    const errData = await response.json().catch(() => ({}));
                    showChatToast('Failed to update comment: ' + (errData.error || response.status), true);
                }
            } catch (err) {
                console.error('Error updating comment:', err);
                showChatToast('Failed to update comment.', true);
            }
        });

        function editComment() {
            hideCommentMenu();
            const commentEl = document.querySelector(`[data-comment-id="${contextMenuCommentId}"]`);
            if (!commentEl) return;
            const txt = commentEl.querySelector('.comment-text') ? commentEl.querySelector('.comment-text').textContent.trim() : '';
            openEditCommentModal(contextMenuCommentId, txt);
        }

        async function deleteComment() {
            hideCommentMenu();
            const confirmed = await showConfirmModal('Delete Comment', 'Are you sure you want to delete this comment?', 'Delete', true);
            if (!confirmed) return;

            try {
                const response = await fetch(`/user/feed/comment/${contextMenuCommentId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.ok) {
                    // Reload comments
                    await loadComments(contextMenuPostId);
                    // Update comment count
                    const postCard = document.querySelector(`[data-post-id="${contextMenuPostId}"]`);
                    const commentCountSpan = postCard.querySelector('.post-actions .action-btn:nth-child(2) span');
                    if (commentCountSpan) {
                        const currentCount = parseInt(commentCountSpan.textContent) || 0;
                        commentCountSpan.textContent = Math.max(0, currentCount - 1);
                    }
                    showChatToast('Comment deleted successfully.');
                } else {
                    showChatToast('Failed to delete comment.', true);
                }
            } catch (error) {
                console.error('Error deleting comment:', error);
                showChatToast('Failed to delete comment.', true);
            }
        }

        // Image viewer functions
        function openImageViewer(postId, imageIndex) {
            currentPostId = postId;
            currentImageIndex = imageIndex;
            const modal = document.getElementById('imageViewerModal');
            const img = document.getElementById('viewerImage');
            const counter = document.getElementById('viewerCounter');
            
            const images = postImages[postId];
            img.src = images[imageIndex];
            counter.textContent = `${imageIndex + 1} / ${images.length}`;
            modal.style.display = 'flex';
        }

        function closeImageViewer() {
            document.getElementById('imageViewerModal').style.display = 'none';
        }

        function previousImage() {
            const images = postImages[currentPostId];
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            document.getElementById('viewerImage').src = images[currentImageIndex];
            document.getElementById('viewerCounter').textContent = `${currentImageIndex + 1} / ${images.length}`;
        }

        function nextImage() {
            const images = postImages[currentPostId];
            currentImageIndex = (currentImageIndex + 1) % images.length;
            document.getElementById('viewerImage').src = images[currentImageIndex];
            document.getElementById('viewerCounter').textContent = `${currentImageIndex + 1} / ${images.length}`;
        }

        // Close viewer with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageViewer();
            } else if (e.key === 'ArrowLeft' && document.getElementById('imageViewerModal').style.display === 'flex') {
                previousImage();
            } else if (e.key === 'ArrowRight' && document.getElementById('imageViewerModal').style.display === 'flex') {
                nextImage();
            }
        });

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

        // Logout confirmation
        // Like functionality
        async function toggleLike(postId) {
            try {
                const response = await fetch(`/user/feed/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                const postCard = document.querySelector(`[data-post-id="${postId}"]`);
                const likeBtn = postCard.querySelector('.like-btn');
                const likesCount = likeBtn.querySelector('.likes-count');

                likesCount.textContent = data.likes_count;
                
                if (data.liked) {
                    likeBtn.classList.add('liked');
                    likeBtn.querySelector('i').className = 'fas fa-heart';
                } else {
                    likeBtn.classList.remove('liked');
                    likeBtn.querySelector('i').className = 'far fa-heart';
                }
            } catch (error) {
                console.error('Error toggling like:', error);
            }
        }

        // Comments
        async function toggleComments(postId) {
            const commentsSection = document.getElementById(`comments-${postId}`);
            
            if (commentsSection.style.display === 'none') {
                commentsSection.style.display = 'block';
                await loadComments(postId);
            } else {
                commentsSection.style.display = 'none';
            }
        }

        async function loadComments(postId) {
            try {
                const response = await fetch(`/user/feed/${postId}/comments`);
                const comments = await response.json();
                const commentsList = document.getElementById(`comments-list-${postId}`);
                commentsList.innerHTML = '';

                comments.forEach(comment => {
                    renderComment(comment, commentsList, postId);
                });
            } catch (error) {
                console.error('Error loading comments:', error);
            }
        }

        function renderComment(comment, container, postId, isReply = false) {
            const commentDiv = document.createElement('div');
            commentDiv.className = isReply ? 'comment reply' : 'comment';
            commentDiv.setAttribute('data-comment-id', comment.id);
            // attach user id for ownership checks
            if (comment.user_id) commentDiv.setAttribute('data-user-id', comment.user_id);

            const authorName = comment.author_name || 'Unknown User';
            const initials = comment.author_initials || authorName.split(' ').map(s => s[0] || '').slice(0,2).join('').toUpperCase() || 'US';

            commentDiv.innerHTML = `
                <div class="comment-header">
                    <div class="comment-avatar">${initials}</div>
                    <span class="comment-author">${escapeHtml(authorName)}</span>
                    <span class="comment-time">${timeAgo(comment.created_at)}</span>
                </div>
                <div class="comment-text" oncontextmenu="showCommentMenu(event, ${comment.id}, ${postId}); return false;">${escapeHtml(comment.comment)}</div>
                <div class="comment-actions">
                    <button class="comment-reply-btn" onclick="showReplyForm(${comment.id}, ${postId})">Reply</button>
                </div>
                <div id="reply-form-${comment.id}" style="display: none; margin: 10px 0 10px 42px;">
                    <div class="comment-form">
                        <input type="text" class="comment-input" placeholder="Write a reply..." id="reply-input-${comment.id}" onkeypress="if(event.key==='Enter'){addComment(${postId}, ${comment.id}); return false;}">
                        <button class="comment-btn" onclick="addComment(${postId}, ${comment.id})">Reply</button>
                    </div>
                </div>
                <div id="replies-${comment.id}"></div>
            `;
            container.appendChild(commentDiv);

            if (comment.replies && comment.replies.length > 0) {
                const repliesContainer = commentDiv.querySelector(`#replies-${comment.id}`);
                comment.replies.forEach(reply => {
                    renderComment(reply, repliesContainer, postId, true);
                });
            }
        }

        // simple HTML escape to avoid XSS
        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function showReplyForm(commentId, postId) {
            const replyForm = document.getElementById(`reply-form-${commentId}`);
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        }

        async function addComment(postId, parentId = null) {
            const inputId = parentId ? `reply-input-${parentId}` : `comment-input-${postId}`;
            const input = document.getElementById(inputId);
            
            if (!input) {
                console.error('Input element not found:', inputId);
                return;
            }
            
            const comment = input.value.trim();

            if (!comment) {
                alert('Please enter a comment');
                return;
            }

            try {
                const response = await fetch(`/user/feed/${postId}/comment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        comment: comment,
                        parent_id: parentId
                    })
                });

                if (response.ok) {
                    input.value = '';
                    if (parentId) {
                        document.getElementById(`reply-form-${parentId}`).style.display = 'none';
                    }
                    
                    // Ensure comments section is visible
                    const commentsSection = document.getElementById(`comments-${postId}`);
                    if (commentsSection.style.display === 'none') {
                        commentsSection.style.display = 'block';
                    }
                    
                    // Reload comments to show the new one
                    await loadComments(postId);
                    
                    // Update comment count
                    const postCard = document.querySelector(`[data-post-id="${postId}"]`);
                    const commentCountSpan = postCard.querySelector('.post-actions .action-btn:nth-child(2) span');
                    if (commentCountSpan) {
                        const currentCount = parseInt(commentCountSpan.textContent) || 0;
                        commentCountSpan.textContent = currentCount + 1;
                    }
                } else {
                    const data = await response.json();
                    if (data.error === 'toxic_content') {
                        showToast(data.message || 'Your comment contains inappropriate content.', 'error');
                    } else {
                        showToast('Failed to post comment', 'error');
                    }
                }
            } catch (error) {
                console.error('Error adding comment:', error);
                alert('Error posting comment');
            }
        }

        function timeAgo(date) {
            const seconds = Math.floor((new Date() - new Date(date)) / 1000);
            
            let interval = seconds / 31536000;
            if (interval > 1) return Math.floor(interval) + " years ago";
            
            interval = seconds / 2592000;
            if (interval > 1) return Math.floor(interval) + " months ago";
            
            interval = seconds / 86400;
            if (interval > 1) return Math.floor(interval) + " days ago";
            
            interval = seconds / 3600;
            if (interval > 1) return Math.floor(interval) + " hours ago";
            
            interval = seconds / 60;
            if (interval > 1) return Math.floor(interval) + " minutes ago";
            
            return Math.floor(seconds) + " seconds ago";
        }
    </script>
    @include('components.confirm-modal')
    @include('components.toast-notification')
</body>
</html>

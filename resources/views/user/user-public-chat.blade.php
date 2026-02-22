<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MindEase — Public Chat</title>
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
        
        /* Public Chat Content */
        .chat-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
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
        
        .btn-danger {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
        }
        
        .btn-danger:hover {
            background: rgba(231, 76, 60, 0.3);
        }
        
        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }
        
        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .message {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            position: relative;
            word-wrap: break-word;
        }
        
        .message.received {
            align-self: flex-start;
            background: rgba(255, 255, 255, 0.1);
            border-bottom-left-radius: 4px;
        }
        
        .message.sent {
            align-self: flex-end;
            background: rgba(74, 144, 226, 0.3);
            border-bottom-right-radius: 4px;
        }
        
        .message.admin {
            align-self: center;
            background: rgba(46, 204, 113, 0.2);
            max-width: 85%;
            text-align: center;
            font-style: italic;
        }
        
        .message-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 5px;
        }
        
        .user-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(74, 144, 226, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            color: var(--accent-light);
        }
        
        .user-name {
            font-weight: 600;
            font-size: 14px;
        }
        
        .message-time {
            font-size: 11px;
            color: var(--text-muted);
        }
        
        .message-content {
            font-size: 14px;
            line-height: 1.4;
        }
        
        .reported-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            margin-left: 8px;
        }
        
        .chat-input-container {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
        }
        
        .chat-input {
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }
        
        .message-input {
            flex: 1;
            padding: 12px 16px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.15);
            color: var(--text);
            font-size: 14px;
            resize: none;
            min-height: 44px;
            max-height: 120px;
            font-family: inherit;
        }
        
        .message-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .message-input:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }
        
        .send-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--accent);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .send-btn:hover {
            background: var(--accent-light);
            transform: scale(1.05);
        }
        
        .send-btn:disabled {
            background: var(--text-muted);
            cursor: not-allowed;
            transform: none;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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
        
        /* Context Menu */
        .context-menu {
            position: fixed;
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 8px 0;
            backdrop-filter: blur(10px);
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            display: none;
        }
        
        .context-menu-item {
            padding: 10px 16px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        
        .context-menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .context-menu-item.delete {
            color: #e74c3c;
        }
        
        .context-menu-item.report {
            color: #f39c12;
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
            max-width: 500px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            overflow: hidden;
            position: relative;
            z-index: 1001;
            pointer-events: auto;
        }
        
        .toxic-modal {
            z-index: 99999 !important;
            pointer-events: auto !important;
        }
        
        .toxic-modal .modal-content {
            z-index: 100000 !important;
            pointer-events: auto !important;
            position: relative;
        }
        
        .toxic-modal .close-modal,
        .toxic-modal .btn {
            pointer-events: auto !important;
            cursor: pointer !important;
            z-index: 100001 !important;
            position: relative !important;
        }
        
        .toxic-modal .btn-primary {
            background: var(--primary) !important;
            color: white !important;
            border: none !important;
            padding: 10px 20px !important;
            border-radius: var(--radius) !important;
            font-weight: 500 !important;
        }
        
        .toxic-modal .btn-primary:hover {
            background: var(--primary-hover) !important;
            transform: translateY(-1px) !important;
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
        
        .reported-chat-list {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .reported-chat-item {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
        }
        
        .reported-chat-item:last-child {
            border-bottom: none;
        }
        
        .reported-chat-content {
            flex: 1;
        }
        
        .reported-chat-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 5px;
        }
        
        .reported-chat-actions {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            font-size: 12px;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .ignore-btn {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
        }
        
        .ignore-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .delete-btn {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
        }
        
        .delete-btn:hover {
            background: rgba(231, 76, 60, 0.3);
        }
        
        .modal-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        /* Custom scrollbar */
        .chat-content::-webkit-scrollbar,
        .chat-messages::-webkit-scrollbar,
        .reported-chat-list::-webkit-scrollbar {
            width: 6px;
        }
        
        .chat-content::-webkit-scrollbar-track,
        .chat-messages::-webkit-scrollbar-track,
        .reported-chat-list::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        
        .chat-content::-webkit-scrollbar-thumb,
        .chat-messages::-webkit-scrollbar-thumb,
        .reported-chat-list::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 3px;
        }
        
        .chat-content::-webkit-scrollbar-thumb:hover,
        .chat-messages::-webkit-scrollbar-thumb:hover,
        .reported-chat-list::-webkit-scrollbar-thumb:hover {
            background: var(--accent-light);
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
            max-width: 500px;
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
            font-size: 20px;
        }

        .close-modal {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 20px;
            cursor: pointer;
            transition: var(--transition);
            z-index: 100001;
            position: relative;
        }

        .close-modal:hover {
            color: white;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Button Styles */
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
            z-index: 100001;
            position: relative;
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
    </style>
</head>
<body>
    <x-user-navigation />
        
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="page-title">
                <h1>Public Chat</h1>
                <p>Connect with the community</p>
            </div>
        </div>
        
        <!-- Chat Content -->
        <div class="chat-content">
            <div class="content-header">
                <div class="content-tabs">
                    <button class="tab-btn active">Live Chat</button>
                </div>
            </div>
                    <!-- Toast Notification -->
                    <div id="toast" class="toast"></div>
                    <!-- Toast Notification -->
                    <div id="toast" class="toast"></div>
            
            <!-- Live Chat Section -->
            <div class="chat-container" id="liveChat">
                <div class="chat-messages" id="chatMessages">
                    <div class="message admin">
                        <div class="message-content">
                            Welcome to the MindEase Public Chat! This is a safe space for students to share experiences and support each other.
                        </div>
                    </div>
                    @foreach($chats as $chat)
                    @php
                        // Check if this message was sent by current user (compare as strings)
                        $isSent = (string)$chat->user_id === (string)$currentUserId;
                        
                        // Determine display name
                        if ($isSent) {
                            $userName = session('user_name', 'You');
                        } elseif ($chat->is_admin) {
                            $userName = 'ADMIN';
                        } else {
                            $userName = $chat->userAccount ? $chat->userAccount->name : 'Unknown User';
                        }
                        
                        // Determine avatar
                        if ($chat->is_admin) {
                            $avatar = 'AD';
                        } elseif ($chat->userAccount && $chat->userAccount->name) {
                            $avatar = strtoupper(substr($chat->userAccount->name, 0, 2));
                        } else {
                            $avatar = 'US';
                        }
                    @endphp
                    
                    <div class="message {{ $isSent ? 'sent' : 'received' }}" 
                         data-message-id="{{ $chat->id }}" 
                         data-user-id="{{ $chat->user_id }}" 
                         data-is-admin="{{ $chat->is_admin ? '1' : '0' }}">
                        <div class="message-header">
                            <div class="user-avatar">{{ $avatar }}</div>
                            <div class="user-name">{{ $userName }}</div>
                            <div class="message-time">{{ $chat->created_at->format('g:i A') }}</div>
                        </div>
                        <div class="message-content">{{ $chat->message }}</div>
                    </div>
                    @endforeach
                </div>
                
                <div class="chat-input-container">
                    <div class="chat-input">
                        <textarea class="message-input" id="messageInput" placeholder="Type your message..." rows="1"></textarea>
                        <button class="send-btn" id="sendBtn">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Context Menu -->
    <div class="context-menu" id="contextMenu">
        <div class="context-menu-item" id="editOption">
            <i class="fas fa-edit"></i> Edit
        </div>
        <div class="context-menu-item delete" id="deleteOption">
            <i class="fas fa-trash"></i> Delete
        </div>
        <div class="context-menu-item report" id="reportOption">
            <i class="fas fa-flag"></i> Report
        </div>
    </div>

    <!-- Error Modal for Toxic Content -->
    <div class="modal toxic-modal" id="toxicContentModal" style="display: none;" onclick="closeToxicModal()">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2 style="color: #dc3545;"><i class="fas fa-exclamation-triangle"></i> Message Blocked</h2>
                <button class="close-modal" onclick="event.stopPropagation(); console.log('X clicked'); closeToxicModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p id="toxicContentMessage" style="color: var(--text); font-size: 16px;">Your message contains toxic words and cannot be sent.</p>
                <p style="color: var(--text-muted); font-size: 14px; margin-top: 10px;">Please revise your message to maintain a respectful environment.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="event.stopPropagation(); console.log('I Understand clicked'); closeToxicModal()">I Understand</button>
            </div>
        </div>
    </div>

    <script>
        // Global variables and functions for toxic modal
        let toxicContentModal;

        // Function to show toxic content modal
        function showToxicModal(message) {
            console.log('showToxicModal called with message:', message);
            if (!toxicContentModal) {
                toxicContentModal = document.getElementById('toxicContentModal');
                console.log('toxicContentModal found:', toxicContentModal);
            }
            if (!toxicContentModal) {
                console.error('Toxic modal element not found!');
                alert('Error: Modal not found');
                return;
            }
            const modalMessage = document.getElementById('toxicContentMessage');
            if (modalMessage) {
                modalMessage.textContent = message || 'Your message contains toxic words and cannot be sent.';
            }
            toxicContentModal.style.display = 'flex';
            console.log('Toxic modal shown');
            
            // Focus on the I Understand button for accessibility
            setTimeout(() => {
                const understandBtn = toxicContentModal.querySelector('.btn-primary');
                if (understandBtn) {
                    understandBtn.focus();
                }
            }, 100);
            
            // Add ESC key listener
            document.addEventListener('keydown', handleEscapeKey);
        }

        // Function to close toxic content modal
        function closeToxicModal() {
            console.log('closeToxicModal called');
            if (!toxicContentModal) {
                toxicContentModal = document.getElementById('toxicContentModal');
                console.log('toxicContentModal found on close:', toxicContentModal);
            }
            if (!toxicContentModal) {
                console.error('Toxic modal element not found on close!');
                return;
            }
            toxicContentModal.style.display = 'none';
            console.log('Toxic modal closed');
            
            // Remove ESC key listener
            document.removeEventListener('keydown', handleEscapeKey);
        }

        // Handle ESC key to close modal
        function handleEscapeKey(event) {
            if (event.key === 'Escape' || event.keyCode === 27) {
                closeToxicModal();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize toxic modal
            toxicContentModal = document.getElementById('toxicContentModal');
            console.log('Toxic modal initialized:', toxicContentModal);
            
            // DOM Elements
            const messageInput = document.getElementById('messageInput');
            const sendBtn = document.getElementById('sendBtn');
            const chatMessages = document.getElementById('chatMessages');
            
            console.log('Elements found:', {
                messageInput: !!messageInput,
                sendBtn: !!sendBtn,
                chatMessages: !!chatMessages
            });
        const contextMenu = document.getElementById('contextMenu');
        const editOption = document.getElementById('editOption');
        const deleteOption = document.getElementById('deleteOption');
        const reportOption = document.getElementById('reportOption');
        // toxicContentModal is now defined globally
        
        console.log('Public Chat Initialized');
        console.log('Message Input:', messageInput);
        console.log('Send Button:', sendBtn);
        console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.content);
        
        let selectedMessageId = null;

        // Tagalog toxic words deny list (500+ words including hate speech)
        const tagalogDenyList = ['putangina','puta','pota','tangina','tanga','gago','gaga','ogag','ulol','lintik','lecheng','leche','bwisit','bobo','boba','bubu','inutil','demonyo','demonyita','kupal','punyeta','punieta','hindot','kantot','kantutan','chupa','tsupa','burat','titi','puke','puki','pekpek','bayag','bayagan','tae','taena','bilat','tarantado','tarantada','pakshet','paksit','pakyo','yna','yowa','yawa','buang','buangon','bakakon','giatay','amaw','kagwang','sira ulo','siraulo','tonto','aswang','halimaw','kaladkarin','salot','walang kwenta','walang utak','bungal','maldita','pasaway','burara','wawa','kawawa','utak tanga','isip tanga','sira utak','utak malikot','talunan','putangena','petangina','tangen','tengina','tenga','tenge','gegu','gego','gugu','ulul','elol','ulel','bebe','bobu','bweset','bwesit','bwusit','kupel','kapal','kapat','hendut','hondot','kentot','kontot','kantut','tsope','chupe','tsape','puky','peke','tarantadu','tarentado','pakshit','pekshot','yowe','yawe','bueng','baang','buong','siraulu','seraulo','tuntu','tento','tanga ka','gago ka','bobo ka','ulol ka','bwisit ka','hayop ka','demonyo ka','kupal ka','tarantado ka','yawa ka','buang ka','bakakon ka','giatay ka','amaw ka','kagwang ka','siraulo ka','pikon ka','asiwa ka','aswang ka','halimaw ka','kaladkarin ka','salot ka','sira utak ka','utak malikot ka','talunan ka','walang kwenta ka','bungal ka','maldita ka','pasaway ka','burara ka','wawa ka','kawawa ka','inutil ka','bubu ka','looser ka','tae ka','leche ka','utal ka','walang utak ka','tenge ka','gegu ka','gego ka','bebe ka','ulul ka','ulel ka','bweset ka','kupel ka','tarantadu ka','yawe ka','yowe ka','bueng ka','siraulu ka','tuntu ka','tangina mo','tanga mo','gago mo','bobo mo','leche mo','tae mo','taena mo','bilat mo','punyeta mo','hindot mo','kantot mo','kantutan mo','tsupa mo','burat mo','titi mo','puke mo','puki mo','pekpek mo','bayag mo','pakshet mo','pakyo mo','yna mo','yowa mo','yawa mo','buang mo','bakakon mo','giatay mo','amaw mo','kagwang mo','siraulo mo','tarantado mo','pikon mo','asiwa mo','aswang mo','halimaw mo','kaladkarin mo','salot mo','sira utak mo','utak malikot mo','talunan mo','walang kwenta mo','bungal mo','maldita mo','pasaway mo','burara mo','wawa mo','kawawa mo','inutil mo','bubu mo','utal mo','demonyo mo','kupal mo','hayop mo','looser mo','tengina mo','tenge mo','gegu mo','gego mo','bebe mo','ulul mo','ulel mo','bweset mo','kupel mo','hendut mo','kentot mo','kontot mo','kantut mo','tsope mo','chupe mo','puky mo','peke mo','tarantadu mo','tarentado mo','pakshit mo','pekshot mo','yawe mo','yowe mo','bueng mo','siraulu mo','tuntu mo','bwakang ina','bwakang ina mo','putang ina','putang ina mo','lecheng ina','yawa nimo','tanga n\'ya','salot n\'ya','inutil n\'ya','utak ng tanga','ptangina','p_ta','p0ta','t4ng1n4','t@ngina','tngn','g@g0','g4go','t@e','p_k3','pk3','p0tangina','p0t4','t1ti','t!ti','p3kpek','pkpk','b4yag','b@yag','put@ngina','t4ng1na','g4g0','pk3','ptangina mo','p0ta mo','t4ng1n4 mo','tngn mo','g@g0 mo','g4go mo','t@e mo','p_k3 mo','pk3 mo','t1ti mo','t!ti mo','p3kpek mo','b4yag mo','b@yag mo','ptanginamo','p0tanginamo','t1tititi','t!titi','p3kpekk','b4yagb4yag','p*tanginamo','p*tanginamo mo','p0tanginamo mo','t1tititi mo','t!titi mo','p3kpekk mo','b4yagb4yag mo','gagooo','putaaa','uloloo','bwbwisit','tanginaa','tangtang','ogago','tanginamo','gagaga','putanginamo','bububu','puhye','hindooo','kantutanmo','tsupatsupa','burattiti','pekpekk','bayagbayag','taetae','bilatbilat','tarantadotarantado','pakshetpakshet','pakyoputangina','y@wa','buangbuang','bakakonmo','giataymo','amawmo','kagwangmo','bwakanginamo','lechemo','taemo','sirauloo','gagooo ka','putaaa ka','uloloo ka','tanginaa ka','tangtang ka','ogago ka','tanginamo ka','gagaga ka','putanginamo ka','bububu ka','demonyita ka','puhye ka','hindooo ka','kantutanmo ka','tsupatsupa ka','burattiti ka','pekpekk ka','bayagbayag ka','taetae ka','bilatbilat ka','tarantadotarantado ka','pakshetpakshet ka','pakyoputangina ka','buangbuang ka','bakakonmo ka','giataymo ka','amawmo ka','kagwangmo ka','bwakanginamo ka','lechemo ka','ptanginamo ka','p0tanginamo ka','t1tititi ka','t!titi ka','p3kpekk ka','b4yagb4yag ka','taemo ka','gagooo mo','putaaa mo','uloloo mo','tanginaa mo','tangtang mo','ogago mo','tanginamo mo','gagaga mo','putanginamo mo','bububu mo','demonyita mo','puhye mo','hindooo mo','kantutanmo mo','tsupatsupa mo','burattiti mo','pekpekk mo','bayagbayag mo','taetae mo','bilatbilat mo','tarantadotarantado mo','pakshetpakshet mo','pakyoputangina mo','buangbuang mo','bakakonmo mo','giataymo mo','amawmo mo','kagwangmo mo','bwakanginamo mo','lechemo mo','gago\'n','gago\'n ka','tanga\'n','tanga\'n ka','bobo\'n','bobo\'n ka','ulol\'n','ulol\'n ka','gago\'t ulol','gago\'t bobo','bobo\'t tanga','ulol\'t gago','tanga\'t ulol','tarantado\'t gago','tanga\'t bobo','ulol\'t bobo','bobo\'t ulol','gago\'t tanga','gago\'t utal','gago\'t maldita','tanga\'t maldita','bobo\'t maldita','ulol\'t maldita','tarantado\'t maldita','gago\'t burara','tanga\'t burara','bobo\'t burara','ulol\'t burara','tanga\'t wawa','bobo\'t wawa','ulol\'t wawa','gago\'t wawa','gago\'t inutil','tanga\'t inutil','bobo\'t inutil','ulol\'t inutil','tanga\'t utak malikot','bobo\'t utak malikot','ulol\'t utak malikot','gago\'t utak malikot','tanga\'t walang kwenta','bobo\'t walang kwenta','ulol\'t walang kwenta','gago\'t walang kwenta','tanga\'t talunan','bobo\'t talunan','ulol\'t talunan','gago\'t talunan','tanga\'t pasaway','bobo\'t pasaway','ulol\'t pasaway','gago\'t pasaway','tanga\'t kaladkarin','bobo\'t kaladkarin','ulol\'t kaladkarin','gago\'t kaladkarin','bakla','tomboy','bading','bakla ka','tomboy ka','bading ka','bakla mo','tomboy mo','bading mo','bakla n\'ya','tomboy n\'ya','bakla\'t gago','tomboy\'t gago','bading\'t gago','bakla\'t tanga','tomboy\'t tanga','bading\'t tanga','putang ina ng mga bakla','putang ina ng mga tomboy','gay ka','lesbian ka','queer ka','lgbt ka','bakla sa isip','bakla sa ugali','tomboy sa ugali','bading sa ugali','putang ina sa mga bakla','putang ina sa mga tomboy','putang ina sa bading','bakla sa lipunan','tomboy sa lipunan','bading sa lipunan','bakla sa pangkat','tomboy sa pangkat','bading sa pangkat','ibang lahi ka','dayuhan ka','putang ina ng dayuhan','putang ina ng ibang lahi','taga ibang bansa','taga ibang lahi','tanga sa lahi','gago sa lahi','bobo sa lahi','ulol sa lahi','walang kwenta sa lahi','hindi karapat-dapat sa lahi','ibang kulay ka','iba ka sa lahat','kakaibang lahi','kakaibang etnisidad','kakaibang kulay','kakaibang lahi mo','kakaibang etnisidad mo','kakaibang kulay mo','hindi normal','hindi tama','kakaibang tao','kakaibang sekswalidad','kakaibang kasarian','hindi karaniwan','kakaibang ugali','kakaibang relihiyon','kakaibang kultura','hindi kabilang','hindi karapat-dapat','ibang grupo','pangit sa lipunan','hindi tanggap','hindi dapat kasama','hindi dapat kausapin','kakaibang pag-uugali','kakaibang pananaw','kakaibang paniniwala','kakaibang komunidad','kakaibang kauri','kakaibang pangkat','kakaibang identity','hindi ka normal','hindi ka karaniwan','hindi ka tanggap','hindi ka katanggap-tanggap','kakaibang orientation','kakaibang sexual orientation','kakaibang gender','kakaibang identity sa lipunan','kakaibang ugali sa lipunan','kakaibang kilos sa lipunan','kakaibang pamumuhay sa lipunan','hindi karapat-dapat sa klase','hindi tanggap sa klase','kakaibang anyo sa klase','kakaibang pag-uugali sa klase','kakaibang kilos sa klase','kakaibang pamumuhay sa klase','kakaibang personalidad sa klase','kakaibang karakter sa klase','kakaibang pananaw sa klase','kakaibang paniniwala sa klase','hindi ka nararapat sa komunidad','hindi ka kabilang sa komunidad','kakaibang anyo sa komunidad','kakaibang pag-uugali sa komunidad','kakaibang kilos sa komunidad','kakaibang pamumuhay sa komunidad','kakaibang personalidad sa komunidad','kakaibang karakter sa komunidad','kakaibang pananaw sa komunidad','kakaibang paniniwala sa komunidad','hindi mo nararapat sa lipunan','hindi ka nararapat sa pangkat','hindi ka nararapat sa komunidad','hindi mo tanggap sa lipunan','hindi mo tanggap sa pangkat','hindi mo tanggap sa komunidad','pangit ka sa lipunan','pangit ka sa pangkat','pangit ka sa klase','pangit ka sa komunidad','walang kwenta ka sa lipunan','walang kwenta ka sa pangkat','walang kwenta ka sa klase','walang kwenta ka sa komunidad','hindi karapat-dapat sa lipunan','hindi karapat-dapat sa grupo','hindi tanggap sa komunidad','pangit ka sa grupo','hindi pangkaraniwan','hindi ayon sa pamantayan','kakaibang ugali ng tao','kakaibang asal ng tao','kakaibang kilos ng tao','kakaibang paniniwala ng tao','kakaibang pananaw ng tao','hindi karapat-dapat sa pangkat','hindi karapat-dapat sa komunidad','kakaibang grupong kinabibilangan','kakaibang pangkat ng tao','kakaibang uri','kakaibang identity ng tao','kakaibang pagkakakilanlan','kakaibang anyo','kakaibang hitsura','kakaibang katawan','kakaibang pananampalataya','kakaibang pamumuhay','kakaibang asal','kakaibang kilos','kakaibang lipunan','kakaibang mukha','kakaibang itsura','kakaibang ugali mo','kakaibang pananaw mo','kakaibang paniniwala mo','kakaibang kultura mo','kakaibang pamumuhay sa lipunan','hindi ka karapat-dapat sa lipunan mo','hindi ka katanggap-tanggap sa lipunan mo','hindi ka nararapat sa pangkat mo','hindi ka nararapat sa komunidad mo','kakaibang personalidad','kakaibang karakter','kakaibang pagkatao','kakaibang sekswalidad mo','kakaibang kasarian mo','kakaibang identity mo','kakaibang orientation mo','kakaibang gender mo','kakaibang sexual orientation mo','kakaibang pag-uugali mo','kakaibang kilos mo','kakaibang asal mo','kakaibang anyo mo','kakaibang itsura mo','kakaibang katawan mo','kakaibang relihiyon mo','kakaibang pananampalataya mo'];
        
        const threatPatterns = ['patayin','saktan','pukulin','i-eliminate','wasakin','bugbugin','patayin kita','saktan kita','pukulin kita','bugbugin kita','patayin ang','saktan ang','pukulin ang','mamatay','patay','sabunot','tadyak','suntok','sipain','suntukin','tadyakan','sabunotin','paluin','sumuntok','tadyakin','sasaktan','papatayin','babarilin','sasaksak','susugurin','dadahasin','papatay','baril','kutsilyo','patalsikin','gawing patay','sunugin','patayin mo','patayin siya','papatayin kita','papatayin mo','papatayin siya','sugatan','hampasin','pasabugin','sumugod','gawing masama','pasakitan','durugin','sugod','atake','saksak','bala','pambubugbog','hampas','suntukan','pamiminsala','patayan','pagpatay','panghihimasok','pambobomba','pagsaksak','pagpalo','pamumura','pamumulot','paghalik','panggugulo','pagsuntok','pamamaril','paninira','pagpahirap','pagkasugat','pagpindot','pagtulak','pagpabagsak','pagbugbog','panghihila','paghampas','sipa','sapak','pagputok','pamumutol','pamumugot','pamimura','pagbomba','pagbaril','pagsabog','pananakot','panggigipit','paghihiganti','pamimugot','pagsunog','panghaharang','paghahagis','pagpunit','pang-aabuso','pagsipa','pagtadyak','pambabaril','pagsiksik','pagnanakaw'];
        
        const harassmentPatterns = ['ipakita','isend','ibigay','send nudes','send pics','ipakita puke','ipakita titi','ipakita pekpek','isend larawan','ibigay larawan'];
        
        // Toxic content patterns for client-side validation (English)
        const toxicPatterns = {
            // General English profanity structure
            profanity_en: /\b(f+[\W_]*u+[\W_]*c+[\W_]*k+|s+[\W_]*h+[\W_]*i+[\W_]*t+|b+[\W_]*i+[\W_]*t+[\W_]*c+[\W_]*h+)\b/i,

            // English Leetspeak / obfuscation
            leetspeak_en: /\b([a@4][s$5]+h[o0]l[e3]|[fph][\W_]*[uúùu][\W_]*[kqc]+)\b/i,

            // Repeated-letter insults (works for both languages)
            repeated_insults: /\b([a-z])\1{3,}[a-z]*\b/i,

            // English threats
            threats_en: /\b(i[' ]?m\s+going\s+to\s+(kill|hurt|beat)|you(?:'re| are)\s+dead)\b/i,

            // English sexual harassment requests
            sexual_harassment_en: /\b(show|send|give)\s+(me\s+)?(pics?|pictures?|body|nudes?)\b/i,

            // Hate-speech pattern
            hate_speech: /\b(kill|eliminate|erase|remove|hate|destroy|get rid of)\s+(all\s+)?(the\s+)?(group|race|religion|orientation|community|people)\b/i,
        };

        // Allow list for common false positives
        const allowList = [
            'bass', 'class', 'mass', 'pass', 'sass', 'glass', 'grass', 'brass',
            'butt', 'butts', 'but', 'butter', 'button', 'butcher', 'butler',
            'assess', 'assist', 'asset', 'assignment', 'associate',
            'hell', 'hello', 'helmet', 'help', 'helpful', 'helping',
            'damn', 'dame', 'dance', 'danger', 'dangle', 'daring',
            'pussy', 'pussycat', 'push', 'pushed', 'pushes', 'pushing',
            'cock', 'cockpit', 'cocktail', 'cockerel', 'cocksure',
            'bitch', 'bitchy', 'bitching', 'bitches', 'bitchin',
            'fucking', 'fucker', 'fucked', 'fucks', 'fuckers'
        ];

        // Function to check for toxic content using regex patterns and deny list
        function containsToxicContent(text) {
            if (!text || text.trim() === '') {
                return { isToxic: true, message: 'Message cannot be empty.' };
            }

            const textLower = text.toLowerCase().trim();

            // Check allow list first - if message contains only allowed words, allow it
            if (isAllowedMessage(textLower)) {
                return { isToxic: false };
            }

            // Check Tagalog deny list
            for (const toxicWord of tagalogDenyList) {
                const regex = new RegExp('\\b' + toxicWord.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '\\b', 'i');
                if (regex.test(textLower)) {
                    return {
                        isToxic: true,
                        message: 'Your message contains inappropriate Tagalog profanity and cannot be sent.'
                    };
                }
            }
            
            // Check threat patterns
            for (const threat of threatPatterns) {
                if (textLower.includes(threat)) {
                    return {
                        isToxic: true,
                        message: 'Your message contains threatening content and cannot be sent.'
                    };
                }
            }
            
            // Check harassment patterns
            for (const harassment of harassmentPatterns) {
                if (textLower.includes(harassment)) {
                    return {
                        isToxic: true,
                        message: 'Your message contains inappropriate sexual content and cannot be sent.'
                    };
                }
            }

            // Check English regex patterns
            for (const [type, pattern] of Object.entries(toxicPatterns)) {
                if (pattern.test(textLower)) {
                    return {
                        isToxic: true,
                        message: getErrorMessage(type)
                    };
                }
            }

            return { isToxic: false };
        }

        // Check if message contains only allowed words
        function isAllowedMessage(message) {
            const words = message.split(/\s+/);
            for (const word of words) {
                const cleanWord = word.replace(/[^\w]/g, ''); // Remove punctuation
                if (cleanWord && !allowList.includes(cleanWord)) {
                    return false;
                }
            }
            return true;
        }

        // Get appropriate error message for toxic content type
        function getErrorMessage(type) {
            const messages = {
                profanity_en: 'Your message contains inappropriate profanity and cannot be sent.',
                profanity_tl: 'Your message contains inappropriate profanity and cannot be sent.',
                leetspeak_en: 'Your message contains obfuscated inappropriate content and cannot be sent.',
                leetspeak_tl: 'Your message contains obfuscated inappropriate content and cannot be sent.',
                repeated_insults: 'Your message contains inappropriate repeated insults and cannot be sent.',
                threats_en: 'Your message contains threatening content and cannot be sent.',
                threats_tl: 'Your message contains threatening content and cannot be sent.',
                sexual_harassment_en: 'Your message contains inappropriate sexual content and cannot be sent.',
                sexual_harassment_tl: 'Your message contains inappropriate sexual content and cannot be sent.',
                hate_speech: 'Your message contains hate speech and cannot be sent.',
            };
            return messages[type] || 'Your message contains inappropriate content and cannot be sent.';
        }

        let selectedMessageElement = null;
        const currentUserId = '{{ $currentUserId }}';
        
        // Initialize send button state
        sendBtn.disabled = true;
        
        // Scroll to bottom on load
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        // Auto-resize textarea
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
            
            // Enable/disable send button based on content
            const hasContent = this.value.trim() !== '';
            sendBtn.disabled = !hasContent;
        });
        
        // Send message on Enter (without Shift)
        messageInput.addEventListener('keydown', function(e) {
            console.log('Keydown event:', e.key, 'Shift pressed:', e.shiftKey);
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                const hasContent = messageInput.value.trim() !== '';
                console.log('Enter pressed, has content:', hasContent);
                if (hasContent) {
                    sendMessage();
                }
            }
        });
        
        // Send button click
        sendBtn.addEventListener('click', function(e) {
            console.log('Send button clicked');
            e.preventDefault();
            sendMessage();
        });
        
        // Context menu on right-click
        document.addEventListener('contextmenu', function(e) {
            const messageElement = e.target.closest('.message');
            
            if (messageElement && !messageElement.classList.contains('admin')) {
                e.preventDefault();
                selectedMessageElement = messageElement;
                selectedMessageId = messageElement.getAttribute('data-message-id');
                const messageUserId = messageElement.getAttribute('data-user-id');
                const isAdminMessage = messageElement.getAttribute('data-is-admin') === '1';
                
                // Determine which options to show
                const isOwnMessage = messageUserId === currentUserId;
                
                if (isOwnMessage) {
                    // Own messages: show Edit and Delete
                    editOption.style.display = 'flex';
                    deleteOption.style.display = 'flex';
                    reportOption.style.display = 'none';
                } else {
                    // Other users' or admin messages: show Report only
                    editOption.style.display = 'none';
                    deleteOption.style.display = 'none';
                    reportOption.style.display = 'flex';
                }
                
                contextMenu.style.left = e.pageX + 'px';
                contextMenu.style.top = e.pageY + 'px';
                contextMenu.style.display = 'block';
            }
        });
        
        // Hide context menu on click
        document.addEventListener('click', function() {
            contextMenu.style.display = 'none';
        });
        
        // Edit message
        editOption.addEventListener('click', function(e) {
            e.stopPropagation();
            contextMenu.style.display = 'none';
            
            if (selectedMessageElement) {
                const messageContent = selectedMessageElement.querySelector('.message-content');
                const currentText = messageContent.textContent.trim();
                
                const newText = prompt('Edit your message:', currentText);
                if (newText !== null && newText.trim() !== '' && newText !== currentText) {
                    updateMessage(selectedMessageId, newText.trim());
                }
            }
        });
        
        // Delete message
        deleteOption.addEventListener('click', async function(e) {
            e.stopPropagation();
            contextMenu.style.display = 'none';
            
            if (!selectedMessageId) {
                return;
            }
            
            try {
                const response = await fetch(`/public-chat/${selectedMessageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (response.ok) {
                    window.location.reload();
                } else {
                    console.error('Failed to delete message. Status: ' + response.status);
                }
            } catch (error) {
                console.error('Failed to delete message: ' + error.message);
            }
        });
        
        // Report message
        reportOption.addEventListener('click', async function(e) {
            e.stopPropagation();
            contextMenu.style.display = 'none';
            
            if (!selectedMessageId) {
                return;
            }
            
            try {
                const response = await fetch(`/public-chat/${selectedMessageId}/report`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (response.ok) {
                    alert('Message reported successfully');
                    window.location.reload();
                } else {
                    console.error('Failed to report message. Status: ' + response.status);
                }
            } catch (error) {
                console.error('Failed to report message: ' + error.message);
            }
        });
        
        // Send message function
        async function sendMessage() {
            console.log('sendMessage function called');
            const content = messageInput.value.trim();
            console.log('Message content:', content);
            if (content === '') {
                console.log('Empty message, not sending');
                return;
            }
            
            // Disable send button to prevent double sending
            sendBtn.disabled = true;
            
            // Client-side validation for toxic content
            const validation = containsToxicContent(content);
            if (validation.isToxic) {
                showToxicModal(validation.message);
                sendBtn.disabled = false;
                return;
            }
            
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    alert('CSRF token not found. Please refresh the page.');
                    sendBtn.disabled = false;
                    return;
                }
                
                console.log('Sending message:', content);
                
                const response = await fetch('{{ route("chat.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.content
                    },
                    body: JSON.stringify({ message: content })
                });
                
                console.log('Response status:', response.status);
                
                if (response.ok) {
                    const data = await response.json();
                    console.log('Message sent successfully:', data);
                    messageInput.value = '';
                    messageInput.style.height = 'auto';
                    window.location.reload();
                } else {
                    const data = await response.json();
                    console.error('Server error:', data);
                    if (data.error === 'toxic_content') {
                        showToxicModal(data.message);
                    } else {
                        alert('Failed to send message. Server error: ' + response.status);
                    }
                    sendBtn.disabled = false;
                }
            } catch (error) {
                console.error('Error sending message:', error);
                alert('Failed to send message. Please check your connection and try again.');
                sendBtn.disabled = false;
            }
        }
        
        // Update message function
        async function updateMessage(messageId, newMessage) {
            // Client-side validation for toxic content
            const validation = containsToxicContent(newMessage);
            if (validation.isToxic) {
                showToxicModal(validation.message);
                return;
            }
            
            try {
                const response = await fetch(`/public-chat/${messageId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message: newMessage })
                });
                
                if (response.ok) {
                    window.location.reload();
                } else {
                    const data = await response.json();
                    if (data.error === 'toxic_content') {
                        showToxicModal(data.message);
                    } else {
                        alert('Failed to update message.');
                    }
                }
            } catch (error) {
                console.error('Error updating message:', error);
                alert('Failed to update message.');
            }
        }
        
        // Scroll to bottom on load
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        }); // End of DOMContentLoaded
    </script>
</body>
</html>

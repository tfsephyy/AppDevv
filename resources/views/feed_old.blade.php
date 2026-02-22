<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        
        /* Feed Content */
        .feed-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .feed-header {
            width: 100%;
            max-width: 700px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .feed-tabs {
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
        
        .create-post-btn {
            padding: 12px 24px;
            border-radius: 8px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
        }
        
        .create-post-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.6);
        }
        
        .posts-container {
            width: 100%;
            max-width: 700px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .post-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .post-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .post-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(74, 144, 226, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-light);
            font-weight: 600;
        }
        
        .user-info h3 {
            font-size: 16px;
            margin-bottom: 2px;
        }
        
        .user-info p {
            font-size: 12px;
            color: var(--text-muted);
        }
        
        .post-actions {
            display: flex;
            gap: 10px;
        }
        
        .post-action-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .post-action-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .post-content {
            margin-bottom: 15px;
        }
        
        .post-caption {
            margin-bottom: 15px;
            line-height: 1.6;
        }
        
        .post-images {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .post-image {
            width: 100%;
            height: 150px;
            border-radius: 8px;
            object-fit: cover;
        }
        
        .post-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .post-stats {
            display: flex;
            gap: 15px;
            color: var(--text-muted);
            font-size: 14px;
        }
        
        .post-stat {
            display: flex;
            align-items: center;
            gap: 5px;
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
        
        .caption-input {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
            font-size: 15px;
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }
        
        .caption-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }
        
        .image-upload {
            border: 2px dashed rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .image-upload:hover {
            border-color: var(--accent);
        }
        
        .image-upload i {
            font-size: 36px;
            margin-bottom: 10px;
            color: var(--text-muted);
        }
        
        .image-preview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }
        
        .preview-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .preview-image {
            width: 100%;
            height: 100px;
            object-fit: cover;
        }
        
        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
        }
        
        .modal-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .btn-primary {
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
        }
        
        /* Custom scrollbar */
        .feed-content::-webkit-scrollbar {
            width: 6px;
        }
        
        .feed-content::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        
        .feed-content::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 3px;
        }
        
        .feed-content::-webkit-scrollbar-thumb:hover {
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
                <h1>Community Feed</h1>
                <p>Share updates and connect with students</p>
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
        
        <!-- Feed Content -->
        <div class="feed-content">
            <div class="feed-header">
                <div class="feed-tabs">
                    <button class="tab-btn active" data-tab="feed">Feed</button>
                    <button class="tab-btn" data-tab="archive">Archive</button>
                </div>
                <button class="create-post-btn" id="createPostBtn">
                    <i class="fas fa-plus"></i>
                    Create Post
                </button>
            </div>
            
            <div class="posts-container" id="feedPosts">
                <!-- Posts will be dynamically added here -->
                <div class="post-card">
                    <div class="post-header">
                        <div class="post-user">
                            <div class="user-avatar">AJ</div>
                            <div class="user-info">
                                <h3>Admin Johnson</h3>
                                <p>2 hours ago</p>
                            </div>
                        </div>
                        <div class="post-actions">
                            <button class="post-action-btn archive-btn" title="Archive">
                                <i class="fas fa-archive"></i>
                            </button>
                            <button class="post-action-btn edit-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                    <div class="post-content">
                        <p class="post-caption">Welcome to MindEase! We're excited to launch our new community feed where students can share their experiences and support each other. Remember, your mental health matters and you're not alone in this journey.</p>
                        <div class="post-images">
                            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Students collaborating" class="post-image">
                        </div>
                    </div>
                    <div class="post-footer">
                        <div class="post-stats">
                            <div class="post-stat">
                                <i class="fas fa-heart"></i>
                                <span>24</span>
                            </div>
                            <div class="post-stat">
                                <i class="fas fa-comment"></i>
                                <span>8</span>
                            </div>
                            <div class="post-stat">
                                <i class="fas fa-share"></i>
                                <span>3</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="post-card">
                    <div class="post-header">
                        <div class="post-user">
                            <div class="user-avatar">AJ</div>
                            <div class="user-info">
                                <h3>Admin Johnson</h3>
                                <p>1 day ago</p>
                            </div>
                        </div>
                        <div class="post-actions">
                            <button class="post-action-btn archive-btn" title="Archive">
                                <i class="fas fa-archive"></i>
                            </button>
                            <button class="post-action-btn edit-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                    <div class="post-content">
                        <p class="post-caption">Mindfulness tip of the day: Take 5 minutes to focus on your breathing. Inhale for 4 seconds, hold for 4, exhale for 6. This simple exercise can help reduce stress and improve focus.</p>
                    </div>
                    <div class="post-footer">
                        <div class="post-stats">
                            <div class="post-stat">
                                <i class="fas fa-heart"></i>
                                <span>42</span>
                            </div>
                            <div class="post-stat">
                                <i class="fas fa-comment"></i>
                                <span>15</span>
                            </div>
                            <div class="post-stat">
                                <i class="fas fa-share"></i>
                                <span>7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="posts-container" id="archivePosts" style="display: none;">
                <!-- Archived posts will be dynamically added here -->
                <div class="empty-state">
                    <i class="fas fa-archive"></i>
                    <h3>No Archived Posts</h3>
                    <p>When you archive posts, they will appear here.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Create Post Modal -->
    <div class="modal" id="createPostModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create New Post</h2>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="postCaption">Caption</label>
                    <textarea id="postCaption" class="caption-input" placeholder="What's on your mind?"></textarea>
                </div>
                <div class="form-group">
                    <label>Add Images (Optional)</label>
                    <div class="image-upload" id="imageUpload">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Click to upload images or drag and drop</p>
                        <p class="small">PNG, JPG, GIF up to 5MB each</p>
                    </div>
                    <input type="file" id="imageInput" multiple accept="image/*" style="display: none;">
                    <div class="image-preview" id="imagePreview"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelPost">Cancel</button>
                <button class="btn btn-primary" id="publishPost">Publish</button>
            </div>
        </div>
    </div>
    
    <!-- Edit Post Modal -->
    <div class="modal" id="editPostModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Post</h2>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="editPostCaption">Caption</label>
                    <textarea id="editPostCaption" class="caption-input"></textarea>
                </div>
                <div class="form-group">
                    <label>Images</label>
                    <div class="image-preview" id="editImagePreview"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelEdit">Cancel</button>
                <button class="btn btn-primary" id="saveEdit">Save Changes</button>
            </div>
        </div>
    </div>

    <script>
        // Sample data for posts
        let posts = [
            {
                id: 1,
                user: "Admin Johnson",
                avatar: "AJ",
                time: "2 hours ago",
                caption: "Welcome to MindEase! We're excited to launch our new community feed where students can share their experiences and support each other. Remember, your mental health matters and you're not alone in this journey.",
                images: ["https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"],
                likes: 24,
                comments: 8,
                shares: 3,
                archived: false
            },
            {
                id: 2,
                user: "Admin Johnson",
                avatar: "AJ",
                time: "1 day ago",
                caption: "Mindfulness tip of the day: Take 5 minutes to focus on your breathing. Inhale for 4 seconds, hold for 4, exhale for 6. This simple exercise can help reduce stress and improve focus.",
                images: [],
                likes: 42,
                comments: 15,
                shares: 7,
                archived: false
            }
        ];
        
        let archivedPosts = [];
        let currentEditPostId = null;
        
        // DOM Elements
        const createPostBtn = document.getElementById('createPostBtn');
        const createPostModal = document.getElementById('createPostModal');
        const editPostModal = document.getElementById('editPostModal');
        const closeModalBtns = document.querySelectorAll('.close-modal');
        const cancelPostBtn = document.getElementById('cancelPost');
        const publishPostBtn = document.getElementById('publishPost');
        const cancelEditBtn = document.getElementById('cancelEdit');
        const saveEditBtn = document.getElementById('saveEdit');
        const imageUpload = document.getElementById('imageUpload');
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const editImagePreview = document.getElementById('editImagePreview');
        const feedPosts = document.getElementById('feedPosts');
        const archivePosts = document.getElementById('archivePosts');
        const tabBtns = document.querySelectorAll('.tab-btn');
        
        // Event Listeners
        createPostBtn.addEventListener('click', () => {
            createPostModal.style.display = 'flex';
        });
        
        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                createPostModal.style.display = 'none';
                editPostModal.style.display = 'none';
                resetCreatePostForm();
            });
        });
        
        cancelPostBtn.addEventListener('click', () => {
            createPostModal.style.display = 'none';
            resetCreatePostForm();
        });
        
        cancelEditBtn.addEventListener('click', () => {
            editPostModal.style.display = 'none';
        });
        
        publishPostBtn.addEventListener('click', createPost);
        
        saveEditBtn.addEventListener('click', saveEditPost);
        
        imageUpload.addEventListener('click', () => {
            imageInput.click();
        });
        
        imageInput.addEventListener('change', handleImageUpload);
        
        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.getAttribute('data-tab');
                tabBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                if (tab === 'feed') {
                    feedPosts.style.display = 'flex';
                    archivePosts.style.display = 'none';
                } else {
                    feedPosts.style.display = 'none';
                    archivePosts.style.display = 'flex';
                    renderArchivedPosts();
                }
            });
        });
        
        document.querySelector('.logout-btn').addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = '/';
            }
        });
        
        // Functions
        function handleImageUpload(e) {
            const files = e.target.files;
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (!file.type.match('image.*')) continue;
                
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'preview-item';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'preview-image';
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'remove-image';
                    removeBtn.innerHTML = '&times;';
                    removeBtn.addEventListener('click', () => {
                        previewItem.remove();
                    });
                    
                    previewItem.appendChild(img);
                    previewItem.appendChild(removeBtn);
                    imagePreview.appendChild(previewItem);
                }
                
                reader.readAsDataURL(file);
            }
            
            // Reset input to allow uploading same file again
            imageInput.value = '';
        }
        
        function createPost() {
            const caption = document.getElementById('postCaption').value.trim();
            if (!caption) {
                alert('Please enter a caption for your post');
                return;
            }
            
            const previewImages = imagePreview.querySelectorAll('.preview-image');
            const images = Array.from(previewImages).map(img => img.src);
            
            const newPost = {
                id: Date.now(),
                user: "Admin Johnson",
                avatar: "AJ",
                time: "Just now",
                caption: caption,
                images: images,
                likes: 0,
                comments: 0,
                shares: 0,
                archived: false
            };
            
            posts.unshift(newPost);
            renderPosts();
            createPostModal.style.display = 'none';
            resetCreatePostForm();
            
            // Switch to feed tab if not already there
            document.querySelector('[data-tab="feed"]').click();
        }
        
        function saveEditPost() {
            const caption = document.getElementById('editPostCaption').value.trim();
            if (!caption) {
                alert('Please enter a caption for your post');
                return;
            }
            
            const postIndex = posts.findIndex(post => post.id === currentEditPostId);
            if (postIndex !== -1) {
                posts[postIndex].caption = caption;
                renderPosts();
            }
            
            editPostModal.style.display = 'none';
            currentEditPostId = null;
        }
        
        function archivePost(postId) {
            const postIndex = posts.findIndex(post => post.id === postId);
            if (postIndex !== -1) {
                const post = posts[postIndex];
                post.archived = true;
                archivedPosts.push(post);
                posts.splice(postIndex, 1);
                renderPosts();
                renderArchivedPosts();
            }
        }
        
        function unarchivePost(postId) {
            const postIndex = archivedPosts.findIndex(post => post.id === postId);
            if (postIndex !== -1) {
                const post = archivedPosts[postIndex];
                post.archived = false;
                posts.push(post);
                archivedPosts.splice(postIndex, 1);
                renderPosts();
                renderArchivedPosts();
            }
        }
        
        function deletePost(postId) {
            const postIndex = archivedPosts.findIndex(post => post.id === postId);
            if (postIndex !== -1) {
                archivedPosts.splice(postIndex, 1);
                renderArchivedPosts();
            }
        }
        
        function editPost(postId) {
            const post = posts.find(post => post.id === postId);
            if (post) {
                currentEditPostId = postId;
                document.getElementById('editPostCaption').value = post.caption;
                
                // Clear previous images in edit preview
                editImagePreview.innerHTML = '';
                
                // Add current images to edit preview
                post.images.forEach(imageSrc => {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'preview-item';
                    
                    const img = document.createElement('img');
                    img.src = imageSrc;
                    img.className = 'preview-image';
                    
                    previewItem.appendChild(img);
                    editImagePreview.appendChild(previewItem);
                });
                
                editPostModal.style.display = 'flex';
            }
        }
        
        function renderPosts() {
            feedPosts.innerHTML = '';
            
            if (posts.length === 0) {
                feedPosts.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-newspaper"></i>
                        <h3>No Posts Yet</h3>
                        <p>Be the first to share something with the community!</p>
                    </div>
                `;
                return;
            }
            
            posts.forEach(post => {
                if (!post.archived) {
                    const postElement = createPostElement(post);
                    feedPosts.appendChild(postElement);
                }
            });
        }
        
        function renderArchivedPosts() {
            archivePosts.innerHTML = '';
            
            if (archivedPosts.length === 0) {
                archivePosts.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-archive"></i>
                        <h3>No Archived Posts</h3>
                        <p>When you archive posts, they will appear here.</p>
                    </div>
                `;
                return;
            }
            
            archivedPosts.forEach(post => {
                const postElement = createArchivedPostElement(post);
                archivePosts.appendChild(postElement);
            });
        }
        
        function createPostElement(post) {
            const postElement = document.createElement('div');
            postElement.className = 'post-card';
            postElement.setAttribute('data-id', post.id);
            
            let imagesHTML = '';
            if (post.images.length > 0) {
                imagesHTML = `
                    <div class="post-images">
                        ${post.images.map(img => `<img src="${img}" alt="Post image" class="post-image">`).join('')}
                    </div>
                `;
            }
            
            postElement.innerHTML = `
                <div class="post-header">
                    <div class="post-user">
                        <div class="user-avatar">${post.avatar}</div>
                        <div class="user-info">
                            <h3>${post.user}</h3>
                            <p>${post.time}</p>
                        </div>
                    </div>
                    <div class="post-actions">
                        <button class="post-action-btn archive-btn" title="Archive">
                            <i class="fas fa-archive"></i>
                        </button>
                        <button class="post-action-btn edit-btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>
                <div class="post-content">
                    <p class="post-caption">${post.caption}</p>
                    ${imagesHTML}
                </div>
                <div class="post-footer">
                    <div class="post-stats">
                        <div class="post-stat">
                            <i class="fas fa-heart"></i>
                            <span>${post.likes}</span>
                        </div>
                        <div class="post-stat">
                            <i class="fas fa-comment"></i>
                            <span>${post.comments}</span>
                        </div>
                        <div class="post-stat">
                            <i class="fas fa-share"></i>
                            <span>${post.shares}</span>
                        </div>
                    </div>
                </div>
            `;
            
            // Add event listeners to action buttons
            const archiveBtn = postElement.querySelector('.archive-btn');
            const editBtn = postElement.querySelector('.edit-btn');
            
            archiveBtn.addEventListener('click', () => archivePost(post.id));
            editBtn.addEventListener('click', () => editPost(post.id));
            
            return postElement;
        }
        
        function createArchivedPostElement(post) {
            const postElement = document.createElement('div');
            postElement.className = 'post-card';
            postElement.setAttribute('data-id', post.id);
            
            let imagesHTML = '';
            if (post.images.length > 0) {
                imagesHTML = `
                    <div class="post-images">
                        ${post.images.map(img => `<img src="${img}" alt="Post image" class="post-image">`).join('')}
                    </div>
                `;
            }
            
            postElement.innerHTML = `
                <div class="post-header">
                    <div class="post-user">
                        <div class="user-avatar">${post.avatar}</div>
                        <div class="user-info">
                            <h3>${post.user}</h3>
                            <p>${post.time}</p>
                        </div>
                    </div>
                    <div class="post-actions">
                        <button class="post-action-btn unarchive-btn" title="Unarchive">
                            <i class="fas fa-box-open"></i>
                        </button>
                        <button class="post-action-btn delete-btn" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="post-content">
                    <p class="post-caption">${post.caption}</p>
                    ${imagesHTML}
                </div>
                <div class="post-footer">
                    <div class="post-stats">
                        <div class="post-stat">
                            <i class="fas fa-heart"></i>
                            <span>${post.likes}</span>
                        </div>
                        <div class="post-stat">
                            <i class="fas fa-comment"></i>
                            <span>${post.comments}</span>
                        </div>
                        <div class="post-stat">
                            <i class="fas fa-share"></i>
                            <span>${post.shares}</span>
                        </div>
                    </div>
                </div>
            `;
            
            // Add event listeners to action buttons
            const unarchiveBtn = postElement.querySelector('.unarchive-btn');
            const deleteBtn = postElement.querySelector('.delete-btn');
            
            unarchiveBtn.addEventListener('click', () => unarchivePost(post.id));
            deleteBtn.addEventListener('click', () => deletePost(post.id));
            
            return postElement;
        }
        
        function resetCreatePostForm() {
            document.getElementById('postCaption').value = '';
            imagePreview.innerHTML = '';
        }
        
        // Initial render
        renderPosts();
    </script>
</body>
</html>

<!-- ===== MOBILE TOP BAR ===== -->
<div class="mobile-topbar" id="mobileTopbar">
    <div class="mobile-topbar-brand">
        <div class="mobile-topbar-logo">ME</div>
        <div class="mobile-topbar-text">
            <h1>MindEase</h1>
            <p>Student Portal</p>
        </div>
    </div>
    <div class="mobile-topbar-actions">
        <button class="mobile-icon-btn" id="mobileNotifBtn" aria-label="Notifications">
            <i class="fas fa-bell"></i>
            <span class="mobile-notif-badge" id="mobileNotifBadge" style="display:none;">0</span>
        </button>
        <button class="mobile-icon-btn" id="mobileMenuBtn" aria-label="Open menu">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
    </div>
</div>

<!-- Mobile Notification Dropdown -->
<div class="mobile-notif-dropdown" id="mobileNotifDropdown" style="display:none;">
    <div class="notification-header">
        <h4>Notifications</h4>
        <button onclick="markAllAsRead()" style="background:none;border:none;color:#4a90e2;cursor:pointer;font-size:12px;">Mark all as read</button>
    </div>
    <div class="notification-list" id="mobileNotificationList">
        <div style="text-align:center;padding:20px;color:#b8d0e0;">Loading notifications...</div>
    </div>
</div>

<div class="sidebar">
    <div class="brand">
        <div class="logo">
            ME
        </div>
        <div class="brand-text">
            <h1>MindEase</h1>
            <p>Student Portal</p>
        </div>
    </div>

    <div class="nav-links">
        <a href="{{ route('user.schedules') }}" class="nav-item {{ request()->routeIs('user.schedules') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Schedules</span>
        </a>

        <a href="{{ route('user.journal') }}" class="nav-item {{ request()->routeIs('user.journal') ? 'active' : '' }}">
            <i class="fas fa-book"></i>
            <span>Journal</span>
        </a>

        <a href="{{ route('user.sessions') }}" class="nav-item {{ request()->routeIs('user.sessions') ? 'active' : '' }}">
            <i class="fas fa-comments"></i>
            <span>Sessions</span>
        </a>

        <a href="{{ route('user.public.chat') }}" class="nav-item {{ request()->routeIs('user.public.chat') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Public Chat</span>
        </a>

        <a href="{{ route('user.feed') }}" class="nav-item {{ request()->routeIs('user.feed') ? 'active' : '' }}">
            <i class="fas fa-newspaper"></i>
            <span>Feed</span>
        </a>

        <a href="{{ route('user.information') }}" class="nav-item {{ request()->routeIs('user.information') ? 'active' : '' }}">
            <i class="fas fa-info-circle"></i>
            <span>Information</span>
        </a>

    </div>

    <div class="admin-profile" style="position: relative;">
        <div class="admin-avatar" id="profileAvatar" style="cursor: pointer;">
            @if(session('user_picture'))
                <img src="{{ asset('storage/' . session('user_picture')) }}" alt="Profile" style="width:40px;height:40px;border-radius:10px;object-fit:cover;">
            @else
                {{ strtoupper(substr(session('user_name', 'Student'), 0, 2)) }}
            @endif
        </div>
        <div class="admin-info">
            <div style="display: flex; align-items: center; gap: 8px;">
                <h3>{{ session('user_name', 'Student') }}</h3>
                <div class="notification-bell" id="notificationBell" style="position: relative; cursor: pointer;">
                    <i class="fas fa-bell" style="font-size: 14px; color: #b8d0e0;"></i>
                    <span class="notification-badge" id="notificationBadge" style="position: absolute; top: -4px; right: -6px; background: #e74c3c; color: white; border-radius: 50%; width: 14px; height: 14px; font-size: 9px; display: none; align-items: center; justify-content: center;">0</span>
                </div>
            </div>
            <p>Student</p>
        </div>
        
        <!-- Notification Dropdown -->
        <div id="notificationDropdown" class="notification-dropdown" style="display: none;">
            <div class="notification-header">
                <h4>Notifications</h4>
                <button onclick="markAllAsRead()" style="background: none; border: none; color: #4a90e2; cursor: pointer; font-size: 12px;">Mark all as read</button>
            </div>
            <div class="notification-list" id="notificationList">
                <div style="text-align: center; padding: 20px; color: #b8d0e0;">
                    Loading notifications...
                </div>
            </div>
        </div>
        
        <!-- Profile Dropdown -->
        <div id="profileDropdown" class="profile-dropdown" style="display: none;">
            <div class="dropdown-item" onclick="openProfileModal()">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </div>
            <div class="dropdown-item" onclick="logout()">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </div>
        </div>
        
        <!-- Hidden logout form -->
        <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>
    </div>
</div>

<!-- ===== MOBILE MENU OVERLAY ===== -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

<!-- ===== MOBILE SLIDE-IN MENU ===== -->
<div class="mobile-menu-panel" id="mobileMenuPanel">

    <!-- Panel Header -->
    <div class="mobile-menu-header">
        <div class="mobile-topbar-brand">
            <div class="mobile-topbar-logo">ME</div>
            <div class="mobile-topbar-text">
                <h1>MindEase</h1>
                <p>Student Portal</p>
            </div>
        </div>
        <button class="mobile-menu-close" id="mobileMenuClose" aria-label="Close menu">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Navigation Links -->
    <div class="mobile-menu-nav">
        <a href="{{ route('user.schedules') }}" class="{{ request()->routeIs('user.schedules') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i><span>Schedules</span>
        </a>
        <a href="{{ route('user.journal') }}" class="{{ request()->routeIs('user.journal') ? 'active' : '' }}">
            <i class="fas fa-book"></i><span>Journal</span>
        </a>
        <a href="{{ route('user.sessions') }}" class="{{ request()->routeIs('user.sessions') ? 'active' : '' }}">
            <i class="fas fa-comments"></i><span>Sessions</span>
        </a>
        <a href="{{ route('user.public.chat') }}" class="{{ request()->routeIs('user.public.chat') ? 'active' : '' }}">
            <i class="fas fa-users"></i><span>Public Chat</span>
        </a>
        <a href="{{ route('user.feed') }}" class="{{ request()->routeIs('user.feed') ? 'active' : '' }}">
            <i class="fas fa-newspaper"></i><span>Feed</span>
        </a>
        <a href="{{ route('user.information') }}" class="{{ request()->routeIs('user.information') ? 'active' : '' }}">
            <i class="fas fa-info-circle"></i><span>Information</span>
        </a>
    </div>

    <!-- Profile Section -->
    <div class="mobile-menu-profile">
        <div class="mobile-menu-avatar">
            @if(session('user_picture'))
                <img src="{{ asset('storage/' . session('user_picture')) }}" alt="Profile">
            @else
                {{ strtoupper(substr(session('user_name', 'Student'), 0, 2)) }}
            @endif
        </div>
        <div class="mobile-menu-profile-info">
            <div class="mobile-menu-profile-name">{{ session('user_name', 'Student') }}</div>
            <div class="mobile-menu-profile-role">Student</div>
        </div>
    </div>

    <!-- Profile Actions -->
    <div class="mobile-menu-profile-actions">
        <button class="mobile-menu-action-btn" onclick="openProfileModal(); closeMobileMenu();">
            <i class="fas fa-user"></i> Profile
        </button>
        <button class="mobile-menu-action-btn mobile-menu-logout-btn" onclick="logout()">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </div>
</div>

<!-- Confirm Modal (outside sidebar so it stays visible on mobile) -->
@include('components.confirm-modal')

<!-- Profile Modal -->
<div id="profileModal" class="profile-modal" style="display: none;">
    <div class="profile-modal-content">
        <div class="profile-modal-header">
            <h2>My Profile</h2>
            <div class="profile-modal-actions">
                <button class="profile-icon-btn" id="editProfileBtn" onclick="toggleEditMode()">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="profile-icon-btn" onclick="closeProfileModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="profile-modal-body">
            <form id="profileForm" enctype="multipart/form-data">
                <div class="profile-picture-section">
                    <div class="profile-picture-wrapper">
                        <img id="profilePicture" src="" alt="Profile Picture" style="display: none;">
                        <div id="profileInitials" class="profile-initials">{{ strtoupper(substr(session('user_name', 'ST'), 0, 2)) }}</div>
                    </div>
                    <input type="file" id="pictureInput" accept="image/*" style="display: none;" disabled>
                    <button type="button" class="btn-change-picture" onclick="document.getElementById('pictureInput').click()">
                        Change Picture
                    </button>
                </div>

                <div class="profile-form-group">
                    <label>Name</label>
                    <input type="text" id="profileName" class="profile-input" readonly>
                </div>

                <div class="profile-form-group">
                    <label>School ID</label>
                    <input type="text" id="profileSchoolId" class="profile-input" readonly disabled>
                </div>

                <div class="profile-form-group">
                    <label>Email</label>
                    <input type="email" id="profileEmail" class="profile-input" readonly>
                </div>

                <div class="profile-form-group">
                    <label>Program</label>
                    <input type="text" id="profileProgram" class="profile-input" readonly>
                </div>

                <div class="profile-form-row">
                    <div class="profile-form-group">
                        <label>Year</label>
                        <input type="text" id="profileYear" class="profile-input" readonly>
                    </div>
                    <div class="profile-form-group">
                        <label>Section</label>
                        <input type="text" id="profileSection" class="profile-input" readonly>
                    </div>
                </div>

                <div class="profile-form-actions" style="display: none;">
                    <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.profile-dropdown {
    position: absolute;
    bottom: 100%;
    left: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 8px;
    margin-bottom: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
}

.dropdown-item {
    padding: 12px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #e6f0f7;
}

.dropdown-item:hover {
    background: rgba(255, 255, 255, 0.1);
}

.dropdown-item i {
    width: 20px;
    text-align: center;
}

.profile-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-modal-content {
    background: linear-gradient(135deg, #6bb3ff 0%, #4a90e2 100%);
    border-radius: 12px;
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.profile-modal-header {
    padding: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.profile-modal-header h2 {
    color: #e6f0f7;
    font-size: 24px;
    margin: 0;
}

.profile-modal-actions {
    display: flex;
    gap: 10px;
}

.profile-icon-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    background: rgba(255, 255, 255, 0.1);
    color: #e6f0f7;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-icon-btn:hover {
    background: rgba(255, 255, 255, 0.2);
}

.profile-modal-body {
    padding: 30px;
}

.profile-picture-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 30px;
}

.profile-picture-wrapper {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    margin-bottom: 15px;
    border: 3px solid rgba(255, 255, 255, 0.2);
}

.profile-picture-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-initials {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #4a90e2, #6bb3ff);
    color: white;
    font-size: 48px;
    font-weight: 700;
}

.btn-change-picture {
    padding: 8px 20px;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.1);
    color: #e6f0f7;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-change-picture:hover {
    background: rgba(255, 255, 255, 0.2);
}

.profile-form-group {
    margin-bottom: 20px;
}

.profile-form-group label {
    display: block;
    margin-bottom: 8px;
    color: #b8d0e0;
    font-weight: 500;
    font-size: 14px;
}

.profile-input {
    width: 100%;
    padding: 12px 15px;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    background: rgba(255, 255, 255, 0.1);
    color: #e6f0f7;
    font-size: 15px;
}

.profile-input:read-only {
    cursor: default;
    background: rgba(255, 255, 255, 0.05);
}

.profile-input:focus:not(:read-only) {
    outline: none;
    border-color: #4a90e2;
    box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
}

.profile-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.profile-form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(90deg, #4a90e2, #6bb3ff);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 144, 226, 0.6);
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.1);
    color: #e6f0f7;
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.2);
}

/* Custom Scrollbar for Profile Modal */
.profile-modal-content::-webkit-scrollbar {
    width: 6px;
}

.profile-modal-content::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
}

.profile-modal-content::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #4a90e2, #6bb3ff);
    border-radius: 3px;
}

.profile-modal-content::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #6bb3ff, #4a90e2);
}

/* Firefox scrollbar */
.profile-modal-content {
    scrollbar-width: thin;
    scrollbar-color: #4a90e2 rgba(255, 255, 255, 0.1);
}

/* Notification Dropdown */
.notification-dropdown {
    position: absolute;
    bottom: 100%;
    left: 0;
    right: 0;
    margin-bottom: 10px;
    background: linear-gradient(135deg, rgba(26, 60, 94, 0.98) 0%, rgba(42, 92, 138, 0.98) 100%);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
    max-height: 400px;
    overflow: hidden;
    z-index: 1000;
}

.notification-header {
    padding: 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.notification-header h4 {
    margin: 0;
    font-size: 16px;
    color: #e6f0f7;
}

.notification-list {
    max-height: 350px;
    overflow-y: auto;
}

.notification-item {
    padding: 12px 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    cursor: pointer;
    transition: background 0.2s;
}

.notification-item:hover {
    background: rgba(255, 255, 255, 0.05);
}

.notification-item.unread {
    background: rgba(74, 144, 226, 0.1);
}

.notification-title {
    font-weight: 600;
    color: #e6f0f7;
    margin-bottom: 4px;
    font-size: 14px;
}

.notification-message {
    color: #b8d0e0;
    font-size: 13px;
    margin-bottom: 4px;
}

.notification-time {
    color: #7a9db8;
    font-size: 11px;
}

.notification-list::-webkit-scrollbar {
    width: 6px;
}

.notification-list::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.notification-list::-webkit-scrollbar-thumb {
    background: #4a90e2;
    border-radius: 3px;
}

/* ============================================================
   MOBILE STYLES — Only applied on screens ≤ 768px
   ============================================================ */

/* Hide the desktop sidebar on mobile */
@media (max-width: 768px) {
    .sidebar { display: none !important; }

    /* Push main content below the fixed topbar */
    .sidebar ~ * {
        padding-top: 60px !important;
        width: 100% !important;
    }

    /* Fix body for mobile scrolling */
    body {
        flex-direction: column !important;
        overflow-y: auto !important;
        height: auto !important;
        min-height: 100vh !important;
    }
}

/* === Mobile Top Bar === */
.mobile-topbar {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(135deg, #1a3c5e 0%, #2a5c8a 100%);
    z-index: 900;
    align-items: center;
    justify-content: space-between;
    padding: 0 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.35);
}

@media (max-width: 768px) {
    .mobile-topbar { display: flex; }
}

.mobile-topbar-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
}

.mobile-topbar-logo {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: linear-gradient(135deg, #4a90e2, #6bb3ff);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(74, 144, 226, 0.4);
}

.mobile-topbar-text {
    min-width: 0;
}

.mobile-topbar-text h1 {
    font-size: 15px;
    font-weight: 700;
    color: white;
    margin: 0;
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.mobile-topbar-text p {
    font-size: 11px;
    color: #b8d0e0;
    margin: 0;
    line-height: 1.2;
}

.mobile-topbar-actions {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}

/* Icon buttons (bell + hamburger) */
.mobile-icon-btn {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #e6f0f7;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
    transition: background 0.2s;
    flex-direction: column;
    gap: 4px;
}

.mobile-icon-btn:hover {
    background: rgba(255, 255, 255, 0.2);
}

/* Hamburger lines */
.hamburger-line {
    display: block;
    width: 18px;
    height: 2px;
    background: #e6f0f7;
    border-radius: 2px;
    transition: all 0.25s ease;
}

/* Notification badge on mobile bell */
.mobile-notif-badge {
    position: absolute;
    top: 5px;
    right: 5px;
    background: #e74c3c;
    color: white;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    font-size: 9px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
}

/* === Mobile Notification Dropdown === */
.mobile-notif-dropdown {
    position: fixed;
    top: 60px;
    right: 14px;
    left: 14px;
    background: linear-gradient(135deg, #1e4d7b 0%, #2a5c8a 100%);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    z-index: 1050;
    max-height: 360px;
    overflow: hidden;
}

/* === Mobile Menu Overlay === */
.mobile-menu-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    z-index: 1100;
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
}

.mobile-menu-overlay.open {
    display: block;
}

/* === Mobile Slide-In Panel === */
.mobile-menu-panel {
    position: fixed;
    top: 0;
    right: -100%;
    width: min(300px, 85vw);
    height: 100%;
    background: linear-gradient(160deg, #1a3c5e 0%, #2a5c8a 60%, #1a3c5e 100%);
    border-left: 1px solid rgba(255, 255, 255, 0.12);
    z-index: 1200;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: -6px 0 30px rgba(0, 0, 0, 0.4);
}

.mobile-menu-panel.open {
    right: 0;
}

/* Panel header (logo + close btn) */
.mobile-menu-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    flex-shrink: 0;
}

.mobile-menu-close {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #e6f0f7;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s;
    flex-shrink: 0;
}

.mobile-menu-close:hover { background: rgba(255, 255, 255, 0.2); }

/* Nav links inside panel */
.mobile-menu-nav {
    flex: 1;
    padding: 8px 0;
    overflow-y: auto;
}

.mobile-menu-nav a {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 13px 20px;
    color: #b8d0e0;
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    transition: all 0.2s;
    border-left: 3px solid transparent;
}

.mobile-menu-nav a:hover {
    background: rgba(255, 255, 255, 0.07);
    color: white;
    border-left-color: rgba(255, 255, 255, 0.3);
}

.mobile-menu-nav a.active {
    background: rgba(74, 144, 226, 0.2);
    color: white;
    border-left-color: #4a90e2;
}

.mobile-menu-nav a i {
    width: 20px;
    text-align: center;
    font-size: 16px;
}

/* Profile row in panel */
.mobile-menu-profile {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    flex-shrink: 0;
}

.mobile-menu-avatar {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: linear-gradient(135deg, #4a90e2, #6bb3ff);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    color: white;
    flex-shrink: 0;
    overflow: hidden;
}

.mobile-menu-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.mobile-menu-profile-info {
    flex: 1;
    min-width: 0;
}

.mobile-menu-profile-name {
    color: white;
    font-weight: 600;
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.mobile-menu-profile-role {
    color: #b8d0e0;
    font-size: 12px;
}

/* Profile / Logout buttons in panel */
.mobile-menu-profile-actions {
    display: flex;
    gap: 8px;
    padding: 0 16px 20px;
    flex-shrink: 0;
}

.mobile-menu-action-btn {
    flex: 1;
    padding: 10px 8px;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    background: rgba(255, 255, 255, 0.08);
    color: #e6f0f7;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    transition: background 0.2s;
}

.mobile-menu-action-btn:hover { background: rgba(255, 255, 255, 0.15); }

.mobile-menu-logout-btn {
    border-color: rgba(231, 76, 60, 0.4);
    color: #ff8a80;
}

.mobile-menu-logout-btn:hover { background: rgba(231, 76, 60, 0.15); }

/* Prevent body scroll when mobile menu is open */
body.mobile-menu-open {
    overflow: hidden !important;
}
</style>

<script>
// Profile dropdown toggle
document.getElementById('profileAvatar').addEventListener('click', function(e) {
    e.stopPropagation();
    const dropdown = document.getElementById('profileDropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
});

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('profileDropdown');
    const avatar = document.getElementById('profileAvatar');
    if (!avatar.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.style.display = 'none';
    }
});

// Open profile modal
async function openProfileModal() {
    document.getElementById('profileDropdown').style.display = 'none';
    
    try {
        const response = await fetch('/user/profile');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const user = await response.json();
        
        // Check if we got an error response
        if (user.error) {
            throw new Error(user.error);
        }
        
        console.log('User data loaded:', user);
        
        // Populate form fields
        document.getElementById('profileName').value = user.name || '';
        document.getElementById('profileSchoolId').value = user.schoolId || '';
        document.getElementById('profileEmail').value = user.email || '';
        document.getElementById('profileProgram').value = user.program || '';
        document.getElementById('profileYear').value = user.year || '';
        document.getElementById('profileSection').value = user.section || '';
        
        // Handle profile picture
        if (user.picture) {
            document.getElementById('profilePicture').src = '/storage/' + user.picture;
            document.getElementById('profilePicture').style.display = 'block';
            document.getElementById('profileInitials').style.display = 'none';
        } else {
            document.getElementById('profilePicture').style.display = 'none';
            document.getElementById('profileInitials').style.display = 'flex';
        }
        
        // Show modal
        document.getElementById('profileModal').style.display = 'flex';
    } catch (error) {
        console.error('Error loading profile:', error);
        alert('Error loading profile: ' + error.message + '. Please try again.');
    }
}

// Close profile modal
function closeProfileModal() {
    document.getElementById('profileModal').style.display = 'none';
    cancelEdit();
}

// Toggle edit mode
function toggleEditMode() {
    const inputs = document.querySelectorAll('.profile-input:not(#profileSchoolId)');
    const editBtn = document.getElementById('editProfileBtn');
    const actions = document.querySelector('.profile-form-actions');
    const changePictureBtn = document.querySelector('.btn-change-picture');
    const pictureInput = document.getElementById('pictureInput');
    
    const isReadOnly = inputs[0].hasAttribute('readonly');
    
    inputs.forEach(input => {
        if (isReadOnly) {
            input.removeAttribute('readonly');
        } else {
            input.setAttribute('readonly', true);
        }
    });
    
    if (isReadOnly) {
        pictureInput.removeAttribute('disabled');
        changePictureBtn.style.display = 'block';
        actions.style.display = 'flex';
        editBtn.innerHTML = '<i class="fas fa-times"></i>';
    } else {
        pictureInput.setAttribute('disabled', true);
        changePictureBtn.style.display = 'none';
        actions.style.display = 'none';
        editBtn.innerHTML = '<i class="fas fa-edit"></i>';
    }
}

// Cancel edit
function cancelEdit() {
    const inputs = document.querySelectorAll('.profile-input:not(#profileSchoolId)');
    inputs.forEach(input => input.setAttribute('readonly', true));
    
    document.getElementById('pictureInput').setAttribute('disabled', true);
    document.querySelector('.btn-change-picture').style.display = 'none';
    document.querySelector('.profile-form-actions').style.display = 'none';
    document.getElementById('editProfileBtn').innerHTML = '<i class="fas fa-edit"></i>';
}

// Handle picture change
document.getElementById('pictureInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profilePicture').src = e.target.result;
            document.getElementById('profilePicture').style.display = 'block';
            document.getElementById('profileInitials').style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
});

// Handle profile form submission
document.getElementById('profileForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('name', document.getElementById('profileName').value);
    formData.append('email', document.getElementById('profileEmail').value);
    formData.append('program', document.getElementById('profileProgram').value);
    formData.append('year', document.getElementById('profileYear').value);
    formData.append('section', document.getElementById('profileSection').value);
    
    const pictureFile = document.getElementById('pictureInput').files[0];
    if (pictureFile) {
        formData.append('picture', pictureFile);
    }
    
    try {
        const response = await fetch('/user/profile', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Profile updated successfully!');
            closeProfileModal();
            location.reload();
        } else {
            alert('Error updating profile. Please try again.');
        }
    } catch (error) {
        console.error('Error updating profile:', error);
        alert('Error updating profile. Please try again.');
    }
});

// Toast logic
function showToast(message, duration = 3000) {
    let toast = document.getElementById('toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'toast';
        toast.className = 'toast';
        document.body.appendChild(toast);
    }
    toast.textContent = message;
    toast.classList.add('show');
    setTimeout(() => {
        toast.classList.remove('show');
    }, duration);
}

// Logout function
async function logout() {
    try {
        const confirmed = await showConfirmModal('Logout', 'Are you sure you want to logout?', 'Logout');
        if (confirmed) {
            console.log('Logout confirmed, submitting form...');
            const form = document.getElementById('logoutForm');
            if (form) {
                console.log('Form found, submitting to:', form.action);
                form.submit();
            } else {
                console.error('Logout form not found!');
                alert('Logout form not found. Redirecting to login page.');
                window.location.href = '/login';
            }
        }
    } catch (error) {
        console.error('Logout error:', error);
        alert('An error occurred during logout. Redirecting to login page.');
        window.location.href = '/login';
    }
}

// Notification functions
async function toggleNotifications() {
    const dropdown = document.getElementById('notificationDropdown');
    const profileDropdown = document.getElementById('profileDropdown');
    
    if (profileDropdown.style.display === 'block') {
        profileDropdown.style.display = 'none';
    }
    
    if (dropdown.style.display === 'none') {
        dropdown.style.display = 'block';
        await loadNotifications();
    } else {
        dropdown.style.display = 'none';
    }
}

async function loadNotifications() {
    try {
        const response = await fetch('/user/notifications');
        const notifications = await response.json();
        const notificationList = document.getElementById('notificationList');
        
        if (notifications.length === 0) {
            notificationList.innerHTML = '<div style="text-align: center; padding: 30px; color: #b8d0e0;"><i class="fas fa-bell-slash" style="font-size: 32px; margin-bottom: 10px; opacity: 0.5;"></i><p>No notifications yet</p></div>';
        } else {
            notificationList.innerHTML = notifications.map(notif => `
                <div class="notification-item ${!notif.read ? 'unread' : ''}" onclick="markNotificationAsRead(${notif.id})">
                    <div class="notification-title">${notif.title}</div>
                    <div class="notification-message">${notif.message}</div>
                    <div class="notification-time">${timeAgo(notif.created_at)}</div>
                </div>
            `).join('');
        }
        
        updateNotificationBadge();
    } catch (error) {
        console.error('Error loading notifications:', error);
    }
}

async function markNotificationAsRead(notificationId) {
    try {
        await fetch(`/user/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        await loadNotifications();
    } catch (error) {
        console.error('Error marking notification as read:', error);
    }
}

async function markAllAsRead() {
    try {
        await fetch('/user/notifications/read-all', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        await loadNotifications();
    } catch (error) {
        console.error('Error marking all as read:', error);
    }
}

async function updateNotificationBadge() {
    try {
        const response = await fetch('/user/notifications/unread-count');
        const data = await response.json();

        // Desktop sidebar badge
        const badge = document.getElementById('notificationBadge');
        // Mobile topbar badge
        const mobileBadge = document.getElementById('mobileNotifBadge');

        if (data.count > 0) {
            if (badge) { badge.textContent = data.count; badge.style.display = 'flex'; }
            if (mobileBadge) { mobileBadge.textContent = data.count; mobileBadge.style.display = 'flex'; }
        } else {
            if (badge) { badge.style.display = 'none'; }
            if (mobileBadge) { mobileBadge.style.display = 'none'; }
        }
    } catch (error) {
        console.error('Error updating badge:', error);
    }
}

function timeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);
    
    if (seconds < 60) return 'Just now';
    if (seconds < 3600) return Math.floor(seconds / 60) + ' minutes ago';
    if (seconds < 86400) return Math.floor(seconds / 3600) + ' hours ago';
    if (seconds < 604800) return Math.floor(seconds / 86400) + ' days ago';
    return date.toLocaleDateString();
}

// CRITICAL: Attach notification bell click handler in DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
    // Notification bell click handler
    const notificationBell = document.getElementById('notificationBell');
    if (notificationBell) {
        notificationBell.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleNotifications();
        });
    }
    
    // Close notification dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const notifBell = document.getElementById('notificationBell');
        const notifDropdown = document.getElementById('notificationDropdown');
        if (notifBell && notifDropdown && !notifBell.contains(e.target) && !notifDropdown.contains(e.target)) {
            notifDropdown.style.display = 'none';
        }
    });
    
    // Load initial notification count
    updateNotificationBadge();

    // Refresh badge every 30 seconds
    setInterval(updateNotificationBadge, 30000);

    // ── Mobile top bar buttons ──────────────────────────────
    const mobileMenuBtn  = document.getElementById('mobileMenuBtn');
    const mobileMenuClose = document.getElementById('mobileMenuClose');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    const mobileNotifBtn = document.getElementById('mobileNotifBtn');

    if (mobileMenuBtn)    mobileMenuBtn.addEventListener('click', openMobileMenu);
    if (mobileMenuClose)  mobileMenuClose.addEventListener('click', closeMobileMenu);
    if (mobileMenuOverlay) mobileMenuOverlay.addEventListener('click', closeMobileMenu);
    if (mobileNotifBtn)   mobileNotifBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleMobileNotifications();
    });

    // Close mobile notification dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const mnd = document.getElementById('mobileNotifDropdown');
        const mnb = document.getElementById('mobileNotifBtn');
        if (mnd && mnb && !mnb.contains(e.target) && !mnd.contains(e.target)) {
            mnd.style.display = 'none';
        }
    });
});

// ── Mobile menu open / close ────────────────────────────────
function openMobileMenu() {
    document.getElementById('mobileMenuPanel').classList.add('open');
    document.getElementById('mobileMenuOverlay').classList.add('open');
    document.body.classList.add('mobile-menu-open');
}

function closeMobileMenu() {
    document.getElementById('mobileMenuPanel').classList.remove('open');
    document.getElementById('mobileMenuOverlay').classList.remove('open');
    document.body.classList.remove('mobile-menu-open');
}

// ── Mobile notification dropdown ────────────────────────────
async function toggleMobileNotifications() {
    const dropdown = document.getElementById('mobileNotifDropdown');
    if (!dropdown) return;

    if (dropdown.style.display === 'none' || dropdown.style.display === '') {
        dropdown.style.display = 'block';
        await loadMobileNotifications();
    } else {
        dropdown.style.display = 'none';
    }
}

async function loadMobileNotifications() {
    try {
        const response = await fetch('/user/notifications');
        const notifications = await response.json();
        const list = document.getElementById('mobileNotificationList');
        if (!list) return;

        if (notifications.length === 0) {
            list.innerHTML = '<div style="text-align:center;padding:30px;color:#b8d0e0;"><i class="fas fa-bell-slash" style="font-size:28px;margin-bottom:8px;opacity:0.5;"></i><p>No notifications yet</p></div>';
        } else {
            list.innerHTML = notifications.map(n => `
                <div class="notification-item ${!n.read ? 'unread' : ''}" onclick="markNotificationAsRead(${n.id}); loadMobileNotifications();">
                    <div class="notification-title">${n.title}</div>
                    <div class="notification-message">${n.message}</div>
                    <div class="notification-time">${timeAgo(n.created_at)}</div>
                </div>
            `).join('');
        }
    } catch (err) {
        console.error('Error loading mobile notifications:', err);
    }
}

// Welcome Motivational Modal
@if(session('show_welcome_motivational') && session('welcome_motivational_message'))
    @php
        $welcomeMsg = session('welcome_motivational_message');
        session()->forget('show_welcome_motivational');
        session()->forget('welcome_motivational_message');
    @endphp
    (function() {
        const msg = @json($welcomeMsg);
        const overlay = document.createElement('div');
        overlay.id = 'welcomeMotivationalModal';
        overlay.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);z-index:9999;display:flex;align-items:center;justify-content:center;';
        overlay.innerHTML = `
            <div style="background:linear-gradient(135deg,#1a3c5e,#2a5c8a);border-radius:16px;padding:40px;max-width:500px;width:90%;text-align:center;border:1px solid rgba(255,255,255,0.15);box-shadow:0 20px 60px rgba(0,0,0,0.5);backdrop-filter:blur(10px);">
                <div style="font-size:48px;margin-bottom:15px;">✨</div>
                <h2 style="color:#e6f0f7;font-size:22px;margin-bottom:8px;">Welcome Back!</h2>
                <p style="color:#b8d0e0;font-size:13px;margin-bottom:20px;">Here's a motivational message for you today</p>
                <div style="background:rgba(255,255,255,0.08);border-radius:12px;padding:25px;margin-bottom:25px;border-left:4px solid #4a90e2;">
                    <p style="color:#e6f0f7;font-size:16px;line-height:1.7;font-style:italic;">"${msg}"</p>
                </div>
                <button onclick="document.getElementById('welcomeMotivationalModal').remove()" style="padding:12px 32px;border-radius:8px;border:none;background:linear-gradient(90deg,#4a90e2,#6bb3ff);color:white;font-weight:600;cursor:pointer;font-size:14px;transition:transform 0.2s;">
                    <i class="fas fa-heart" style="margin-right:8px;"></i>Thank You!
                </button>
            </div>
        `;
        document.body.appendChild(overlay);
        overlay.addEventListener('click', function(e) { if (e.target === overlay) overlay.remove(); });
    })();
@endif
</script>

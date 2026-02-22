<div class="sidebar">
    <div class="brand">
        <div class="logo">ME</div>
        <div class="brand-text">
            <h1>MindEase</h1>
            <p>Admin Dashboard</p>
        </div>
    </div>

    <div class="nav-links">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('scheduling') }}" class="nav-item {{ request()->routeIs('scheduling') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Scheduling</span>
        </a>

        <a href="{{ route('counceling') }}" class="nav-item {{ request()->routeIs('counceling') ? 'active' : '' }}">
            <i class="fas fa-comments"></i>
            <span>Counseling</span>
        </a>

        <a href="{{ route('public.chat') }}" class="nav-item {{ request()->routeIs('public.chat') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Public Chat</span>
        </a>

        <a href="{{ route('feed') }}" class="nav-item {{ request()->routeIs('feed') ? 'active' : '' }}">
            <i class="fas fa-newspaper"></i>
            <span>Feed</span>
        </a>

        <a href="{{ route('motivational') }}" class="nav-item {{ request()->routeIs('motivational') || request()->routeIs('motivational.archive') ? 'active' : '' }}">
            <i class="fas fa-lightbulb"></i>
            <span>Motivational</span>
        </a>
    </div>

    <div class="admin-profile" style="position: relative;">
        <div class="admin-avatar" id="profileAvatar" style="cursor: pointer;">
            @if(session('admin_picture'))
                <img src="{{ asset('storage/' . session('admin_picture')) }}" alt="Profile" style="width:40px;height:40px;border-radius:10px;object-fit:cover;">
            @else
                {{ strtoupper(substr(session('admin_name', 'AD'), 0, 2)) }}
            @endif
        </div>
        <div class="admin-info">
            <h3>{{ session('admin_name', 'Admin') }}</h3>
            <p>Administrator</p>
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
    </div>
</div>

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
                        <div id="profileInitials" class="profile-initials">{{ strtoupper(substr(session('admin_name', 'AD'), 0, 2)) }}</div>
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
        const response = await fetch('/admin/profile');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const admin = await response.json();
        
        // Check if we got an error response
        if (admin.error) {
            throw new Error(admin.error);
        }
        
        console.log('Admin data loaded:', admin);
        
        // Populate form fields
        document.getElementById('profileName').value = admin.name || '';
        document.getElementById('profileSchoolId').value = admin.schoolId || '';
        document.getElementById('profileEmail').value = admin.email || '';
        
        // Handle profile picture
        if (admin.picture) {
            document.getElementById('profilePicture').src = '/storage/' + admin.picture;
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
    
    const pictureFile = document.getElementById('pictureInput').files[0];
    if (pictureFile) {
        formData.append('picture', pictureFile);
    }
    
    try {
        const response = await fetch('/admin/profile', {
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

// Logout function
async function logout() {
    const confirmed = await showConfirmModal('Logout', 'Are you sure you want to logout?', 'Logout');
    if (confirmed) {
        try {
            const response = await fetch('/logout', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            
            // Clear local session and redirect
            window.location.href = '/';
        } catch (error) {
            console.error('Logout error:', error);
            // Redirect anyway
            window.location.href = '/';
        }
    }
}
</script>
@include('components.confirm-modal')

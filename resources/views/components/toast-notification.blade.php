<div id="toastNotification" class="toast-notification" style="display: none;">
    <i class="fas fa-check-circle toast-icon"></i>
    <span class="toast-message"></span>
</div>

<style>
    .toast-notification {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: #2ecc71;
        color: #fff;
        padding: 14px 28px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 500;
        z-index: 999999;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease, transform 0.3s ease;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
        max-width: 90%;
    }
    
    .toast-notification.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
        display: flex;
    }
    
    .toast-notification.error {
        background: #e74c3c;
    }
    
    .toast-notification.success {
        background: #2ecc71;
    }
    
    .toast-notification.info {
        background: #3498db;
    }
    
    .toast-notification.warning {
        background: #f39c12;
    }
    
    .toast-icon {
        font-size: 16px;
    }
    
    .toast-message {
        flex: 1;
    }
    
    @media (max-width: 768px) {
        .toast-notification {
            bottom: 20px;
            padding: 12px 20px;
            font-size: 13px;
            border-radius: 25px;
        }
    }
</style>

<script>
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toastNotification');
        const icon = toast.querySelector('.toast-icon');
        const messageEl = toast.querySelector('.toast-message');
        
        if (!toast || !icon || !messageEl) {
            console.error('Toast elements not found');
            return;
        }
        
        // Set message
        messageEl.textContent = message;
        
        // Set icon and color based on type
        toast.className = 'toast-notification ' + type;
        
        switch(type) {
            case 'error':
                icon.className = 'fas fa-times-circle toast-icon';
                break;
            case 'success':
                icon.className = 'fas fa-check-circle toast-icon';
                break;
            case 'info':
                icon.className = 'fas fa-info-circle toast-icon';
                break;
            case 'warning':
                icon.className = 'fas fa-exclamation-circle toast-icon';
                break;
            default:
                icon.className = 'fas fa-check-circle toast-icon';
        }
        
        // Show toast
        toast.classList.add('show');
        toast.style.display = 'flex';
        
        // Hide after 3 seconds
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.style.display = 'none';
            }, 300);
        }, 3000);
    }
</script>

<!-- Notification System Component -->
<div id="notification-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; max-width: 400px;"></div>

<!-- Confirmation Modal -->
<div id="confirm-modal-overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.6); z-index: 10000; backdrop-filter: blur(4px); animation: fadeIn 0.2s ease;">
    <div id="confirm-modal" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: linear-gradient(135deg, #6bb3ff 0%, #4a90e2 100%); border-radius: 16px; padding: 30px; max-width: 450px; width: 90%; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5); border: 1px solid rgba(255, 255, 255, 0.1); animation: slideIn 0.3s ease;">
        <h3 id="confirm-modal-title" style="margin: 0 0 15px 0; color: white; font-size: 20px; font-weight: 600;"></h3>
        <p id="confirm-modal-message" style="margin: 0 0 25px 0; color: #b8d0e0; font-size: 15px; line-height: 1.5;"></p>
        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <button id="confirm-modal-cancel" style="padding: 10px 20px; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.3); background: rgba(255, 255, 255, 0.1); color: white; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 14px;">Cancel</button>
            <button id="confirm-modal-confirm" style="padding: 10px 20px; border-radius: 8px; border: none; background: linear-gradient(90deg, #4a90e2, #6bb3ff); color: white; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 14px; box-shadow: 0 4px 12px rgba(74, 144, 226, 0.4);">Confirm</button>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideIn {
        from { 
            opacity: 0;
            transform: translate(-50%, -45%);
        }
        to { 
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(120%);
        }
    }
    
    .notification-toast {
        padding: 16px 20px;
        border-radius: 12px;
        background: linear-gradient(135deg, #6bb3ff 0%, #4a90e2 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideInRight 0.3s ease;
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }
    
    .notification-toast.removing {
        animation: slideOutRight 0.3s ease;
    }
    
    .notification-toast::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
    }
    
    .notification-toast.success::before {
        background: #4ade80;
    }
    
    .notification-toast.error::before {
        background: #f87171;
    }
    
    .notification-toast.warning::before {
        background: #fbbf24;
    }
    
    .notification-toast.info::before {
        background: #60a5fa;
    }
    
    .notification-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    
    .notification-toast.success .notification-icon {
        background: rgba(74, 222, 128, 0.2);
        color: #4ade80;
    }
    
    .notification-toast.error .notification-icon {
        background: rgba(248, 113, 113, 0.2);
        color: #f87171;
    }
    
    .notification-toast.warning .notification-icon {
        background: rgba(251, 191, 36, 0.2);
        color: #fbbf24;
    }
    
    .notification-toast.info .notification-icon {
        background: rgba(96, 165, 250, 0.2);
        color: #60a5fa;
    }
    
    .notification-message {
        flex: 1;
        color: white;
        font-size: 14px;
        line-height: 1.4;
    }
    
    .notification-close {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: rgba(255, 255, 255, 0.6);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    
    .notification-close:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    #confirm-modal-cancel:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-1px);
    }
    
    #confirm-modal-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 144, 226, 0.6);
    }
    
    @media (max-width: 576px) {
        #notification-container {
            left: 10px;
            right: 10px;
            max-width: none;
        }
        
        #confirm-modal {
            width: 95%;
            padding: 20px;
        }
    }
</style>

<script>
    // Notification System
    const NotificationSystem = {
        container: null,
        queue: [],
        
        init() {
            this.container = document.getElementById('notification-container');
        },
        
        show(message, type = 'info') {
            if (!this.container) this.init();
            
            const icons = {
                success: '✓',
                error: '✕',
                warning: '⚠',
                info: 'ℹ'
            };
            
            const notification = document.createElement('div');
            notification.className = `notification-toast ${type}`;
            notification.innerHTML = `
                <div class="notification-icon">${icons[type] || icons.info}</div>
                <div class="notification-message">${message}</div>
                <button class="notification-close" onclick="NotificationSystem.remove(this.parentElement)">×</button>
            `;
            
            this.container.appendChild(notification);
            this.queue.push(notification);
            
            // Auto-dismiss after 3 seconds
            setTimeout(() => {
                this.remove(notification);
            }, 3000);
        },
        
        remove(notification) {
            if (!notification || !notification.parentElement) return;
            
            notification.classList.add('removing');
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.parentElement.removeChild(notification);
                }
                const index = this.queue.indexOf(notification);
                if (index > -1) {
                    this.queue.splice(index, 1);
                }
            }, 300);
        }
    };
    
    // Confirmation Modal System
    const ConfirmModal = {
        overlay: null,
        modal: null,
        title: null,
        message: null,
        confirmBtn: null,
        cancelBtn: null,
        callback: null,
        
        init() {
            this.overlay = document.getElementById('confirm-modal-overlay');
            this.modal = document.getElementById('confirm-modal');
            this.title = document.getElementById('confirm-modal-title');
            this.message = document.getElementById('confirm-modal-message');
            this.confirmBtn = document.getElementById('confirm-modal-confirm');
            this.cancelBtn = document.getElementById('confirm-modal-cancel');
            
            this.confirmBtn.addEventListener('click', () => this.confirm());
            this.cancelBtn.addEventListener('click', () => this.cancel());
            this.overlay.addEventListener('click', (e) => {
                if (e.target === this.overlay) this.cancel();
            });
            
            // Keyboard support
            document.addEventListener('keydown', (e) => {
                if (this.overlay.style.display === 'block') {
                    if (e.key === 'Escape') this.cancel();
                    if (e.key === 'Enter') this.confirm();
                }
            });
        },
        
        show(message, title = 'Confirm Action', callback) {
            if (!this.overlay) this.init();
            
            this.title.textContent = title;
            this.message.textContent = message;
            this.callback = callback;
            this.overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
        },
        
        confirm() {
            this.hide();
            if (this.callback) {
                this.callback(true);
            }
        },
        
        cancel() {
            this.hide();
            if (this.callback) {
                this.callback(false);
            }
        },
        
        hide() {
            this.overlay.style.display = 'none';
            document.body.style.overflow = '';
            this.callback = null;
        }
    };
    
    // Global helper functions
    function showNotification(message, type = 'info') {
        NotificationSystem.show(message, type);
    }
    
    function showConfirmModal(message, title = 'Confirm Action', callback) {
        ConfirmModal.show(message, title, callback);
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', () => {
        NotificationSystem.init();
        ConfirmModal.init();
    });
</script>

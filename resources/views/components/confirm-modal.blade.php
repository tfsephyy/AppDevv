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
</script>

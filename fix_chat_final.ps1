# Read the corrupted file
$content = Get-Content 'resources\views\publicChat.blade.php' -Raw

# Find the last occurrence of "async function sendMessage()" and get everything before it
if ($content -match '(?s)(.*?async function sendMessage\(\) \{.*?console\.log\(''Response status:'', response\.status\);[\r\n\s]+if \(response\.ok\) \{[\r\n\s]+console\.log\(''Message sent successfully, reloading\.\.\.''\);[\r\n\s]+// Reload page to show new message[\r\n\s]+window\.location\.reload\(\);[\r\n\s]+\} else \{)') {
    $beforeError = $matches[1]
    
    # Add the fixed error handling
    $fixed = $beforeError + @'

                    try {
                        const errorData = await response.json();
                        if (errorData.error === 'toxic_content') {
                            showToxicWordModal();
                            messageInput.focus();
                            return;
                        }
                        alert('Failed to send message: ' + (errorData.message || 'Unknown error'));
                    } catch (jsonError) {
                        alert('Failed to send message. Server error: ' + response.status);
                    }
                }
            } catch (error) {
                console.error('Error sending message:', error);
                alert('Failed to send message.');
            }
        }
        
        // Functions for reported messages
        async function unreportMessage(messageId) {
            try {
                const response = await fetch(`/public-chat/${messageId}/unreport`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (response.ok) {
                    viewReportsBtn.click();
                } else {
                    alert('Failed to dismiss report');
                }
            } catch (error) {
                console.error('Error dismissing report:', error);
                alert('Failed to dismiss report');
            }
        }
        
        async function deleteReportedMessage(messageId) {
            if (confirm('Are you sure you want to delete this message?')) {
                try {
                    const response = await fetch(`/public-chat/${messageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    if (response.ok) {
                        viewReportsBtn.click();
                    } else {
                        alert('Failed to delete message');
                    }
                } catch (error) {
                    console.error('Error deleting message:', error);
                    alert('Failed to delete message');
                }
            }
        }
        
        // Toxic Word Modal Functions
        function showToxicWordModal() {
            document.getElementById('toxicWordModal').style.display = 'flex';
        }
        
        function closeToxicModal() {
            document.getElementById('toxicWordModal').style.display = 'none';
        }
    </script>
    
    <!-- Toxic Word Modal -->
    <div id="toxicWordModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 3000; align-items: center; justify-content: center;">
        <div style="background: linear-gradient(135deg, #1a3c5e 0%, #2a5c8a 100%); border-radius: 12px; padding: 30px; max-width: 400px; text-align: center;">
            <div style="font-size: 48px;">⚠️</div>
            <h3 style="color: #e6f0f7; margin: 15px 0;">Inappropriate Content Detected</h3>
            <p style="color: #b8d0e0; margin-bottom: 25px;">Please refrain from using toxic words or offensive language.</p>
            <button onclick="closeToxicModal()" style="background: linear-gradient(90deg, #4a90e2, #6baef0); color: white; border: none; padding: 12px 30px; border-radius: 8px; cursor: pointer;">Understood</button>
        </div>
    </div>
</body>
</html>
'@
    
    Set-Content 'resources\views\publicChat.blade.php' -Value $fixed -NoNewline
    Write-Host "SUCCESS: File fixed!" -ForegroundColor Green
} else {
    Write-Host "ERROR: Could not find the pattern to fix" -ForegroundColor Red
}

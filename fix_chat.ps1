$file = 'resources\views\publicChat.blade.php'
$content = Get-Content $file -Raw

# Remove all the corrupted duplicate content after line with "Handle message sending with toxic word check"
$content = $content -replace '(?s)(// Handle message sending with toxic word check.*?)\}\s*\}\s*\</script\>.*$', '$1}
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
</html>'

Set-Content $file -Value $content -NoNewline
Write-Host "File cleaned successfully!"

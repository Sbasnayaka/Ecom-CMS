<!-- Admin Global Loader Partial -->
<style>
    /* Loader CSS (Scoped to Admin) */
    .admin-loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.5); /* Semi-transparent white */
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 9999;
        display: none; /* Hidden by default */
        align-items: center;
        justify-content: center;
        flex-direction: column;
        pointer-events: all; /* Blocks interactions */
    }

    .admin-loader-spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #e0e0e0;
        border-top: 5px solid #000; /* Black for Admin to match styling */
        border-radius: 50%;
        animation: admin-spin 1s linear infinite;
    }

    .admin-loader-text {
        margin-top: 20px;
        font-weight: 600;
        color: #000;
        font-size: 14px;
        letter-spacing: 1px;
    }

    @keyframes admin-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div id="adminLoader" class="admin-loader-overlay">
    <div class="admin-loader-spinner"></div>
    <div class="admin-loader-text">Loading...</div>
</div>

<script>
    // Global Loader Controls
    let adminLoaderTimeout;

    function showGlobalLoader(message = 'Loading...') {
        // Update text if provided
        const txt = document.querySelector('.admin-loader-text');
        if(txt) txt.innerText = message;

        // Clear existing timer
        clearTimeout(adminLoaderTimeout);
        
        // Small delay to prevent flicker on instant actions
        adminLoaderTimeout = setTimeout(() => {
            const loader = document.getElementById('adminLoader');
            if(loader) loader.style.display = 'flex';
        }, 300);
    }

    function hideGlobalLoader() {
        clearTimeout(adminLoaderTimeout);
        const loader = document.getElementById('adminLoader');
        if(loader) loader.style.display = 'none';
    }

    // Auto-hide on page show (fixes Back button caching issues)
    window.addEventListener('pageshow', function(event) {
        hideGlobalLoader();
    });

    // Attach to all Forms automatically
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                // Check if form is valid before showing loader
                if(form.reportValidity()) {
                    showGlobalLoader('Processing...');
                }
            });
        });

        // Attach to Delete Links (with confirmation)
        const deleteLinks = document.querySelectorAll('a[onclick*="confirm"]');
        deleteLinks.forEach(link => {
            // Hijack the click to show loader AFTER confirmation
            const originalClick = link.onclick;
            link.onclick = function(e) {
                // If the original confirmation returns true
                // We show loader. If false, we do nothing.
                // Note: This relies on the inline onclick returning true/false
                // Standard pattern: return confirm('Msg');
                // We can't easily wrap inline events safely without parsing.
                // Simpler strategy: Use a global click listener for specific links.
            };
        });
    });

    // Global Link Interceptor for Delete Actions
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if(!link) return;

        // Check if it's a delete link
        if(link.href.includes('/delete') || link.href.includes('delete_all')) {
            // We assume the inline 'onclick' (confirm) happens first.
            // If that passes, the bracket navigation starts. 
            // We can show loader immediately.
            // However, if user cancels confirm, we shouldn't show loader.
            // Since inline handlers run before addEventListener, 
            // if strict execution order holds, if the user clicked "Cancel", 
            // the event might have been prevented? 
            // Actually, `return confirm()` prevents default if false.
            // So if we reach here, and default wasn't prevented?
            
            // Safer manual check if needed, but let's stick to Forms first for safety.
            // We will manually call showGlobalLoader() on specific critical links if needed in Step B.3.2.
        }
    });

</script>

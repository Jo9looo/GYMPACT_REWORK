document.addEventListener('DOMContentLoaded', () => {
    console.log('Gym Website Loaded');

    // Example feature: close alert messages
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.addEventListener('click', () => {
            alert.style.display = 'none';
        });
    });

    // Smooth Scrolling for Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // --- User Dropdown Click Logic ---
    const dropdown = document.querySelector('.user-dropdown');
    const profileBtn = document.querySelector('.profile-btn');

    if (dropdown && profileBtn) {
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent immediate closing
            dropdown.classList.toggle('active');
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', () => {
    console.log('Gym Website Loaded');

    // Example feature: close alert messages
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.addEventListener('click', () => {
            alert.style.display = 'none';
        });
    });
});

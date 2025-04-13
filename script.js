document.querySelectorAll('.book-now-btn').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const targetUrl = button.getAttribute('href');
        window.open(targetUrl, '_blank');
    });
});

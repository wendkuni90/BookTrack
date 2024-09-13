document.getElementById('search').addEventListener('input', function() {
    const query = this.value.toLowerCase();
    const items = document.querySelectorAll('.library-item');

    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(query) ? '' : 'none';
    });
});
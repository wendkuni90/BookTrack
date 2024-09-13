document.addEventListener('DOMContentLoaded', () => {
    const images = document.querySelectorAll('.image-item img');

    images.forEach((img, index) => {
        setTimeout(() => {
            img.style.opacity = '1';
            img.style.transform = 'translateY(0)';
        }, index * 200); // Délai basé sur l'index pour l'animation
    });
});
document.querySelectorAll('.social-icons a').forEach(icon => {
    icon.addEventListener('mouseover', () => {
        icon.style.color = '#007BFF'; // Change la couleur au survol
    });

    icon.addEventListener('mouseout', () => {
        icon.style.color = '#333'; // Restaure la couleur d'origine
    });
});
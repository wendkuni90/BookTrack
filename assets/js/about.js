document.querySelector('.about-button').addEventListener('mouseover', function() {
    this.querySelector('i').style.transform = 'translateX(5px)';
});

document.querySelector('.about-button').addEventListener('mouseout', function() {
    this.querySelector('i').style.transform = 'translateX(0)';
});
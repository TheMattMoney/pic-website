// Minimal vanilla JS parallax for a tiled background
window.addEventListener('scroll', function() {
  const scrolled = window.pageYOffset;
  const bg = document.querySelector('.parallax-background');
  if (bg) {
    // Adjust 0.5 for parallax speed (0.5 = half speed)
    bg.style.backgroundPositionY = `${scrolled * 0.5}px`;
  }
});
// Initial position
window.addEventListener('DOMContentLoaded', function() {
  const bg = document.querySelector('.parallax-background');
  if (bg) {
    bg.style.backgroundPositionY = '0px';
  }
}); 
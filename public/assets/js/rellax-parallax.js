/**
 * Rellax.js Parallax Implementation
 * Alternative to custom parallax - uses the Rellax library
 * Uncomment the Rellax CDN in the HTML to use this instead
 */

// Wait for Rellax to be available
document.addEventListener('DOMContentLoaded', function() {
  if (typeof Rellax !== 'undefined') {
    // Initialize Rellax with custom settings
    var rellax = new Rellax('.parallax-background', {
      speed: -2, // Negative for opposite direction
      vertical: true,
      horizontal: false,
      breakpoints: [576, 768, 1201]
    });
    
    console.log('Rellax parallax initialized');
  } else {
    console.warn('Rellax library not loaded, falling back to custom parallax');
    // Fallback to custom implementation
    loadCustomParallax();
  }
});

function loadCustomParallax() {
  // Simple fallback parallax
  const background = document.querySelector('.parallax-background');
  if (!background) return;
  
  let ticking = false;
  
  function updateParallax() {
    const scrolled = window.pageYOffset;
    const rate = scrolled * -0.5;
    background.style.transform = `translateY(${rate}px)`;
    ticking = false;
  }
  
  window.addEventListener('scroll', () => {
    if (!ticking) {
      requestAnimationFrame(updateParallax);
      ticking = true;
    }
  }, { passive: true });
} 
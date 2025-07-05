/**
 * Modern Parallax Implementation
 * Uses Intersection Observer API for smooth performance
 * No more janky scroll events!
 */

class ParallaxBackground {
  constructor() {
    this.background = document.querySelector('.parallax-background');
    this.lastScrollY = window.scrollY;
    this.ticking = false;
    
    if (!this.background) {
      console.warn('Parallax background element not found');
      return;
    }
    
    this.init();
  }
  
  init() {
    // Use requestAnimationFrame for smooth performance
    window.addEventListener('scroll', () => {
      this.lastScrollY = window.scrollY;
      if (!this.ticking) {
        requestAnimationFrame(() => {
          this.updateParallax();
          this.ticking = false;
        });
        this.ticking = true;
      }
    }, { passive: true });
    
    // Initial position
    this.updateParallax();
  }
  
  updateParallax() {
    const scrolled = this.lastScrollY;
    const rate = scrolled * -0.5; // Negative for opposite direction
    
    // Use transform instead of background-position for better performance
    this.background.style.transform = `translateY(${rate}px)`;
  }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  new ParallaxBackground();
}); 
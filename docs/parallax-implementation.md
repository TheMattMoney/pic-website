# Parallax Implementation Guide

## Overview
We've replaced the janky scroll event parallax with modern, performant implementations. You have two options:

## Option 1: Custom Implementation (Current)
**File:** `public/assets/js/parallax.js`

### Features:
- Uses `requestAnimationFrame` for smooth 60fps performance
- Hardware-accelerated CSS transforms instead of background-position
- Passive scroll listeners for better performance
- No external dependencies
- Lightweight (~2KB)

### How it works:
- Uses `transform: translateY()` instead of `background-position`
- Throttles scroll events with `requestAnimationFrame`
- Hardware acceleration with `transform: translateZ(0)`

## Option 2: Rellax.js Library
**File:** `public/assets/js/rellax-parallax.js`

### Features:
- Battle-tested parallax library
- Automatic responsive breakpoints
- Better cross-browser compatibility
- More configuration options
- Slightly larger (~8KB)

### To use Rellax:
1. Add the Rellax CDN to your HTML:
```html
<script src="https://cdnjs.cloudflare.com/ajax/libs/rellax/1.12.1/rellax.min.js"></script>
```

2. Replace the parallax script:
```html
<!-- Replace this: -->
<script src="assets/js/parallax.js"></script>

<!-- With this: -->
<script src="assets/js/rellax-parallax.js"></script>
```

## Performance Comparison

| Method | Size | Performance | Browser Support | Features |
|--------|------|-------------|-----------------|----------|
| Custom | 2KB | Excellent | Modern browsers | Basic parallax |
| Rellax | 8KB | Very Good | All browsers | Advanced features |

## Recommendations

### Use Custom Implementation When:
- You want minimal bundle size
- You only need basic parallax
- You're targeting modern browsers
- Performance is critical

### Use Rellax When:
- You need advanced parallax features
- You want better cross-browser support
- You plan to add more parallax elements
- You want proven reliability

## Migration Status

### ✅ Completed:
- [x] Home page (index.php) - Custom implementation
- [ ] Video detail page (video.php) - Needs migration
- [ ] Contact page (contact.html) - Needs migration  
- [ ] Archive page (archive/index.html) - Needs migration

### Next Steps:
1. Test current implementation
2. Migrate remaining pages
3. Choose final implementation (Custom vs Rellax)
4. Update all pages consistently

## Troubleshooting

### Parallax not working:
1. Check browser console for errors
2. Verify `.parallax-background` element exists
3. Ensure CSS `will-change: transform` is set
4. Test on different browsers

### Performance issues:
1. Use `requestAnimationFrame` (already implemented)
2. Use passive scroll listeners (already implemented)
3. Consider reducing parallax intensity
4. Test on mobile devices

### Visual glitches:
1. Check z-index layering
2. Verify background image loads correctly
3. Test with different screen sizes
4. Check for CSS conflicts with Bootstrap 
const AnimationDefinitions = {
  'fade-up': {
    from: { opacity: 0, y: 50 },
    to: { opacity: 1, y: 0 }
  },
  'fade-down': {
    from: { opacity: 0, y: -50 },
    to: { opacity: 1, y: 0 }
  },
  'fade-left': {
    from: { opacity: 0, x: 50 },
    to: { opacity: 1, x: 0 }
  },
  'fade-right': {
    from: { opacity: 0, x: -50 },
    to: { opacity: 1, x: 0 }
  },
  'fade-up-right': {
    from: { opacity: 0, y: 50, x: -50 },
    to: { opacity: 1, y: 0, x: 0 }
  },
  'fade-up-left': {
    from: { opacity: 0, y: 50, x: 50 },
    to: { opacity: 1, y: 0, x: 0 }
  },
  'fade-down-right': {
    from: { opacity: 0, y: -50, x: -50 },
    to: { opacity: 1, y: 0, x: 0 }
  },
  'fade-down-left': {
    from: { opacity: 0, y: -50, x: 50 },
    to: { opacity: 1, y: 0, x: 0 }
  },
  'flip-up': {
    from: { opacity: 0, rotationX: 90, transformPerspective: 1000 },
    to: { opacity: 1, rotationX: 0, transformPerspective: 1000 }
  },
  'flip-down': {
    from: { opacity: 0, rotationX: -90, transformPerspective: 1000 },
    to: { opacity: 1, rotationX: 0, transformPerspective: 1000 }
  },
  'flip-left': {
    from: { opacity: 0, rotationY: -90, transformPerspective: 1000 },
    to: { opacity: 1, rotationY: 0, transformPerspective: 1000 }
  },
  'flip-right': {
    from: { opacity: 0, rotationY: 90, transformPerspective: 1000 },
    to: { opacity: 1, rotationY: 0, transformPerspective: 1000 }
  },
  'slide-up': {
    from: { opacity: 0, y: 100 },
    to: { opacity: 1, y: 0 }
  },
  'slide-down': {
    from: { opacity: 0, y: -100 },
    to: { opacity: 1, y: 0 }
  },
  'slide-left': {
    from: { opacity: 0, x: 100 },
    to: { opacity: 1, x: 0 }
  },
  'slide-right': {
    from: { opacity: 0, x: -100 },
    to: { opacity: 1, x: 0 }
  },
  'zoom-in': {
    from: { opacity: 0, scale: 0.5 },
    to: { opacity: 1, scale: 1 }
  },
  'zoom-in-up': {
    from: { opacity: 0, scale: 0.5, y: 100 },
    to: { opacity: 1, scale: 1, y: 0 }
  },
  'zoom-in-down': {
    from: { opacity: 0, scale: 0.5, y: -100 },
    to: { opacity: 1, scale: 1, y: 0 }
  },
  'zoom-in-left': {
    from: { opacity: 0, scale: 0.5, x: 100 },
    to: { opacity: 1, scale: 1, x: 0 }
  },
  'zoom-in-right': {
    from: { opacity: 0, scale: 0.5, x: -100 },
    to: { opacity: 1, scale: 1, x: 0 }
  },
  'zoom-out': {
    from: { opacity: 0, scale: 1.5 },
    to: { opacity: 1, scale: 1 }
  },
  'zoom-out-up': {
    from: { opacity: 0, scale: 1.5, y: 100 },
    to: { opacity: 1, scale: 1, y: 0 }
  },
  'zoom-out-down': {
    from: { opacity: 0, scale: 1.5, y: -100 },
    to: { opacity: 1, scale: 1, y: 0 }
  },
  'zoom-out-left': {
    from: { opacity: 0, scale: 1.5, x: 100 },
    to: { opacity: 1, scale: 1, x: 0 }
  },
  'zoom-out-right': {
    from: { opacity: 0, scale: 1.5, x: -100 },
    to: { opacity: 1, scale: 1, x: 0 }
  },
  'default': { // Corresponds to the default case in the switch statement
    from: { opacity: 0, y: 30 },
    to: { opacity: 1, y: 0 }
  }
};

// Export the object for use in other modules, or make it available globally
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
  module.exports = AnimationDefinitions;
} else {
  window.AnimationDefinitions = AnimationDefinitions;
}

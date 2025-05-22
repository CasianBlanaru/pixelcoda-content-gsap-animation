// Wait for all scripts to fully load, especially GSAP
document.addEventListener('DOMContentLoaded', () => {
    // Wait a moment to ensure GSAP is fully loaded
    setTimeout(() => {
        // Get global GSAP references
        const gsap = window.gsap;

        // Check if GSAP is globally available
        if (!gsap) {
            console.error('GSAP is not loaded. Please include the GSAP library.');
            return;
        }

        // Get ScrollTrigger reference and register it if available
        const ScrollTrigger = window.ScrollTrigger || gsap?.plugins?.ScrollTrigger || gsap.ScrollTrigger;

        if (ScrollTrigger) {
            // Make sure ScrollTrigger is registered
            if (typeof gsap.registerPlugin === 'function') {
                gsap.registerPlugin(ScrollTrigger);
            }
        }

        /**
         * GSAP Animation for content elements
         */

        // Create observer for animations
        const createScrollTrigger = (element) => {
            if (!gsap) return;

            const animationType = element.getAttribute('data-gsap-anim');
            const animationDuration = Number.parseFloat(element.getAttribute('data-gsap-duration') || 0.8);
            const delay = Number.parseFloat(element.getAttribute('data-gsap-delay') || 0);
            const ease = element.getAttribute('data-gsap-easing') || 'power2.out';
            const once = element.getAttribute('data-gsap-once') === 'true';

            // Create animation based on type
            let animation;

            switch(animationType) {
                case 'fade-up':
                    animation = {
                        y: 50,
                        opacity: 0,
                        duration: animationDuration / 1000,
                        ease: ease
                    };
                    break;
                case 'fade-down':
                    animation = {
                        y: -50,
                        opacity: 0,
                        duration: animationDuration / 1000,
                        ease: ease
                    };
                    break;
                case 'fade-left':
                    animation = {
                        x: -50,
                        opacity: 0,
                        duration: animationDuration / 1000,
                        ease: ease
                    };
                    break;
                case 'fade-right':
                    animation = {
                        x: 50,
                        opacity: 0,
                        duration: animationDuration / 1000,
                        ease: ease
                    };
                    break;
                case 'fade':
                    animation = {
                        opacity: 0,
                        duration: animationDuration / 1000,
                        ease: ease
                    };
                    break;
                case 'zoom-in':
                    animation = {
                        scale: 0.5,
                        opacity: 0,
                        duration: animationDuration / 1000,
                        ease: ease
                    };
                    break;
                case 'zoom-out':
                    animation = {
                        scale: 1.5,
                        opacity: 0,
                        duration: animationDuration / 1000,
                        ease: ease
                    };
                    break;
                case 'flip-up':
                    animation = {
                        rotationX: 90,
                        opacity: 0,
                        transformOrigin: 'center bottom',
                        duration: animationDuration / 1000,
                        ease: ease
                    };
                    break;
                case 'flip-down':
                    animation = {
                        rotationX: -90,
                        opacity: 0,
                        transformOrigin: 'center top',
                        duration: animationDuration / 1000,
                        ease: ease
                    };
                    break;
                case 'slide-left':
                    animation = {
                        x: -100,
                        opacity: 0,
                        duration: animationDuration / 1000,
                        ease: ease
                    };
                    break;
                case 'slide-right':
                    animation = {
                        x: 100,
                        opacity: 0,
                        duration: animationDuration / 1000,
                        ease: ease
                    };
                    break;
                default:
                    // Fall back to fade-up
                    animation = {
                        y: 30,
                        opacity: 0,
                        duration: animationDuration / 1000,
                        ease: ease
                    };
            }

            // Add delay if present
            if (delay > 0) {
                animation.delay = delay / 1000;
            }

            // Use ScrollTrigger if available, otherwise fall back to simple animation
            if (ScrollTrigger) {
                const scrollTrigger = {
                    trigger: element,
                    start: 'top 80%',
                    // Modified toggleActions for better animations in both directions
                    // First value: onEnter, Second: onLeave, Third: onEnterBack, Fourth: onLeaveBack
                    toggleActions: once ? 'play none none none' : 'play none play none'
                };

                // Start GSAP animation with ScrollTrigger
                gsap.from(element, {
                    ...animation,
                    scrollTrigger: scrollTrigger
                });
            } else {
                // Fall back without ScrollTrigger
                gsap.from(element, animation);
            }
        };

        // Find all elements to animate and create animations
        const initGSAPAnimations = () => {
            if (!gsap) return;

            const animatedElements = document.querySelectorAll('[data-gsap-anim]');

            for (const element of animatedElements) {
                createScrollTrigger(element);
            }
        };

        // Initialization
        initGSAPAnimations();

    }, 100);
});

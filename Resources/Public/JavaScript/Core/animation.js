// Wait for all scripts to fully load, especially GSAP
document.addEventListener('DOMContentLoaded', () => {
    // Wait a moment to ensure GSAP is fully loaded
    setTimeout(() => {
        // ES6 imports are replaced by global variables
        const gsap = window.gsap;
        const ScrollTrigger = window.gsap?.ScrollTrigger;

        // Check if GSAP is globally available
        if (!gsap) {
            console.error('GSAP is not loaded. Please include GSAP library.');
            return;
        }

        // Register ScrollTrigger if available
        if (ScrollTrigger) {
            gsap.registerPlugin(ScrollTrigger);
            console.log('GSAP ScrollTrigger registered successfully.');
        } else {
            console.warn('GSAP ScrollTrigger is not loaded. Fallback to simple animations.');
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
                    // Fallback to fade-up
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

            console.log('Applying animation to', element, 'with type', animationType, 'duration', animationDuration, 'delay', delay);

            // ScrollTrigger configuration, if available
            if (ScrollTrigger) {
                const scrollTrigger = {
                    trigger: element,
                    start: 'top 80%',
                    // Modified toggleActions to trigger animations on scrolling up and down
                    toggleActions: once ? 'play none none none' : 'play reverse play reverse'
                };

                // Start GSAP animation with ScrollTrigger
                gsap.from(element, {
                    ...animation,
                    scrollTrigger: scrollTrigger
                });
            } else {
                // Fallback without ScrollTrigger
                gsap.from(element, animation);
            }
        };

        // Find all elements to animate and create animations
        const initGSAPAnimations = () => {
            if (!gsap) return;

            const animatedElements = document.querySelectorAll('[data-gsap-anim]');
            console.log('Found', animatedElements.length, 'elements to animate');

            for (const element of animatedElements) {
                createScrollTrigger(element);
            }
        };

        // Initialization
        initGSAPAnimations();

    }, 100);
});

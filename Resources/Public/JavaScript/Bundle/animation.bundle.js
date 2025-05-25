var contentAnimations = (function () {
	'use strict';

	function getDefaultExportFromCjs (x) {
		return x && x.__esModule && Object.prototype.hasOwnProperty.call(x, 'default') ? x['default'] : x;
	}

	var animation$1 = {};

	var hasRequiredAnimation;

	function requireAnimation () {
		if (hasRequiredAnimation) return animation$1;
		hasRequiredAnimation = 1;
		// Wait for all scripts to fully load, especially GSAP
		document.addEventListener('DOMContentLoaded', () => {
		    // Wait a moment to ensure GSAP and AnimationDefinitions are fully loaded
		    setTimeout(() => {
		        // Get global GSAP references
		        const gsap = window.gsap;
		        const AnimationDefinitions = window.AnimationDefinitions;

		        // Check if GSAP is globally available
		        if (!gsap) {
		            console.error('GSAP is not loaded. Please include the GSAP library.');
		            return;
		        }

		        // Check if AnimationDefinitions is available
		        if (!AnimationDefinitions) {
		            console.error('AnimationDefinitions not loaded. Please ensure animation-definitions.js is loaded before this script.');
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
		            const animationDuration = Number.parseFloat(element.getAttribute('data-gsap-duration') || 800); // Default duration from TYPO3 field
		            const delay = Number.parseFloat(element.getAttribute('data-gsap-delay') || 0);
		            const ease = element.getAttribute('data-gsap-easing') || 'power2.out';
		            const once = element.getAttribute('data-gsap-once') === 'true';

		            // Fetch animation definition
		            let animDef = AnimationDefinitions[animationType];

		            if (!animDef) {
		                console.warn(`Animation type "${animationType}" not found. Falling back to "default".`);
		                animDef = AnimationDefinitions['default'];
		            }

		            if (!animDef) {
		                console.error(`Default animation definition not found. Cannot apply GSAP animation to element:`, element);
		                // Fallback to a very basic fade-in if default is also missing
		                animDef = { from: { opacity: 0, y: 20 }, to: { opacity: 1, y: 0 } };
		            }

		            // Prepare GSAP variables using animDef.from
		            let gsapVars = {
		                ...animDef.from, // Spread the 'from' variables from shared definitions
		                duration: animationDuration / 1000, // Convert ms to s
		                ease: ease
		            };

		            // Add delay if present
		            if (delay > 0) {
		                gsapVars.delay = delay / 1000; // Convert ms to s
		            }

		            // Use ScrollTrigger if available, otherwise fall back to simple animation
		            if (ScrollTrigger) {
		                const scrollTriggerOptions = {
		                    trigger: element,
		                    start: 'top 80%',
		                    toggleActions: once ? 'play none none none' : 'play none play none',
		                    // Consider adding 'end' and 'scrub' for more advanced scenarios if needed later
		                };

		                gsap.from(element, {
		                    ...gsapVars,
		                    scrollTrigger: scrollTriggerOptions
		                });
		            } else {
		                // Fall back without ScrollTrigger (e.g. for elements visible in viewport on load)
		                gsap.from(element, gsapVars);
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

		    }, 100); // setTimeout delay
		});
		return animation$1;
	}

	var animationExports = requireAnimation();
	var animation = /*@__PURE__*/getDefaultExportFromCjs(animationExports);

	return animation;

})();
//# sourceMappingURL=animation.bundle.js.map

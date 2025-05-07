(function () {
    'use strict';

    // Warte auf das vollständige Laden aller Skripte, insbesondere GSAP
    document.addEventListener('DOMContentLoaded', () => {
        // Warte einen kurzen Moment, um sicherzustellen, dass GSAP vollständig geladen ist
        setTimeout(() => {
            // Die ES6-Imports werden durch globale Variablen ersetzt
            const gsap = window.gsap;
            const ScrollTrigger = window.gsap?.ScrollTrigger;

            // Prüfen, ob GSAP global verfügbar ist
            if (!gsap) {
                console.error('GSAP is not loaded. Please include GSAP library.');
                return;
            }

            // Registriere ScrollTrigger, wenn verfügbar
            if (ScrollTrigger) {
                gsap.registerPlugin(ScrollTrigger);
                console.log('GSAP ScrollTrigger registered successfully.');
            } else {
                console.warn('GSAP ScrollTrigger is not loaded. Fallback to simple animations.');
            }

            /**
             * GSAP Animation für Content-Elemente
             */

            // Observer für Animationen erstellen
            const createScrollTrigger = (element) => {
                if (!gsap) return;

                const animationType = element.getAttribute('data-gsap-anim');
                const animationDuration = Number.parseFloat(element.getAttribute('data-gsap-duration') || 0.8);
                const delay = Number.parseFloat(element.getAttribute('data-gsap-delay') || 0);
                const ease = element.getAttribute('data-gsap-easing') || 'power2.out';
                const once = element.getAttribute('data-gsap-once') === 'true';

                // Animation basierend auf dem Typ erstellen
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
                        // Fallback zum fade-up
                        animation = {
                            y: 30,
                            opacity: 0,
                            duration: animationDuration / 1000,
                            ease: ease
                        };
                }

                // Verzögerung hinzufügen, falls vorhanden
                if (delay > 0) {
                    animation.delay = delay / 1000;
                }

                console.log('Applying animation to', element, 'with type', animationType, 'duration', animationDuration, 'delay', delay);

                // ScrollTrigger-Konfiguration, wenn verfügbar
                if (ScrollTrigger) {
                    const scrollTrigger = {
                        trigger: element,
                        start: 'top 80%',
                        toggleActions: once ? 'play none none none' : 'play reverse restart reset'
                    };

                    // GSAP-Animation mit ScrollTrigger starten
                    gsap.from(element, {
                        ...animation,
                        scrollTrigger: scrollTrigger
                    });
                } else {
                    // Fallback ohne ScrollTrigger
                    gsap.from(element, animation);
                }
            };

            // Alle zu animierenden Elemente finden und Animationen erstellen
            const initGSAPAnimations = () => {
                if (!gsap) return;

                const animatedElements = document.querySelectorAll('[data-gsap-anim]');
                console.log('Found', animatedElements.length, 'elements to animate');

                for (const element of animatedElements) {
                    createScrollTrigger(element);
                }
            };

            // Initialisierung
            initGSAPAnimations();

        }, 100);
    });

})();
//# sourceMappingURL=animation.bundle.js.map

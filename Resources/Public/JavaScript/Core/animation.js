const initializeContentGsapAnimations = () => {
    if (window.__contentGsapAnimationInitialized === true) {
        return;
    }

    const animatedElements = Array.from(document.querySelectorAll('[data-gsap-anim]'));
    if (animatedElements.length === 0) {
        return;
    }
    window.__contentGsapAnimationInitialized = true;

    window.requestAnimationFrame(() => {
        const gsap = window.gsap;
        const AnimationDefinitions = window.AnimationDefinitions;
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (!gsap || !AnimationDefinitions) {
            return;
        }

        if (prefersReducedMotion) {
            animatedElements.forEach((element) => {
                element.removeAttribute('data-gsap-anim');
                element.style.removeProperty('opacity');
                element.style.removeProperty('transform');
                element.style.removeProperty('will-change');
            });
            return;
        }

        const ScrollTrigger = window.ScrollTrigger || gsap?.plugins?.ScrollTrigger || gsap.ScrollTrigger;

        if (ScrollTrigger && typeof gsap.registerPlugin === 'function') {
            gsap.registerPlugin(ScrollTrigger);
        }

        const toSeconds = (value, fallback) => {
            const parsedValue = Number.parseFloat(value);
            return Number.isFinite(parsedValue) && parsedValue >= 0 ? parsedValue / 1000 : fallback;
        };

        const containsReadableText = (element) => {
            return (element.textContent || '').replace(/\s+/g, ' ').trim().length > 0;
        };

        const keepTextVisible = (vars, element) => {
            if (!containsReadableText(element)) {
                return vars;
            }
            const safeVars = { ...vars };
            delete safeVars.opacity;
            return safeVars;
        };

        const createAnimation = (element) => {
            const animationType = element.getAttribute('data-gsap-anim') || 'default';
            const animationDefinition = AnimationDefinitions[animationType] || AnimationDefinitions.default || {
                from: { opacity: 0, y: 30 },
                to: { opacity: 1, y: 0 },
            };
            const duration = toSeconds(element.getAttribute('data-gsap-duration'), 0.8);
            const delay = toSeconds(element.getAttribute('data-gsap-delay'), 0);
            const ease = element.getAttribute('data-gsap-easing') || 'power2.out';
            const once = element.getAttribute('data-gsap-once') !== 'false';
            const mirror = element.getAttribute('data-gsap-mirror') === 'true';
            const offset = Number.parseInt(element.getAttribute('data-gsap-offset') || '0', 10);
            const anchorPlacement = element.getAttribute('data-gsap-anchor-placement') || 'top-bottom';
            const start = anchorPlacement.replace('-', ' ');

            const fromVars = {
                ...keepTextVisible(animationDefinition.from, element),
                immediateRender: false,
                willChange: 'transform',
            };
            const toVars = {
                ...keepTextVisible(animationDefinition.to, element),
                duration,
                delay,
                ease,
                clearProps: 'transform,opacity,visibility,willChange',
            };

            if (ScrollTrigger) {
                toVars.scrollTrigger = {
                    trigger: element,
                    start: offset ? `${start}-=${offset}` : start,
                    once,
                    toggleActions: mirror ? 'play reverse play reverse' : 'play none none none',
                };
            }

            gsap.fromTo(element, fromVars, toVars);
        };

        const gsapContext = typeof gsap.context === 'function'
            ? gsap.context(() => animatedElements.forEach(createAnimation))
            : null;

        if (!gsapContext) {
            animatedElements.forEach(createAnimation);
        }

        window.addEventListener('pagehide', () => {
            if (gsapContext && typeof gsapContext.revert === 'function') {
                gsapContext.revert();
                return;
            }
            animatedElements.forEach((element) => gsap.killTweensOf(element));
        }, { once: true });
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeContentGsapAnimations, { once: true });
} else {
    initializeContentGsapAnimations();
}

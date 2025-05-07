define([], () => {
    /**
     * @exports TYPO3/CMS/ContentAnimations/AnimationPreview
     */
    const AnimationPreview = {
        previewLabel: document.querySelector('#preview-content-animation .preview-label'),
        previewElement: document.querySelector('#preview-content-animation .ce-preview'),
        animationSelectField: document.querySelector('[name*="[tx_content_gsap_animation_animation]"]'),
        durationInputField: document.querySelector('[data-formengine-input-name*="[tx_content_gsap_animation_duration]"]'),
        durationValueInputField: document.querySelector('[name*="[tx_content_gsap_animation_duration]"]'),
        defaultPreviewDuration: 800,
        defaultPreviewDelay: 1000,
        currentAnimation: null,
        currentTimeline: null
    };

    /**
     * change the preview animation
     * @private
     */
    AnimationPreview.changeAnimation = (duration, delay, removeAnimation) => {
        // Kill any existing GSAP animations
        if (AnimationPreview.currentAnimation) {
            AnimationPreview.currentAnimation.kill();
            AnimationPreview.currentAnimation = null;
        }

        if (removeAnimation) {
            gsap.set(AnimationPreview.previewElement, { clearProps: "all" });
        } else {
            const animationType = AnimationPreview.animationSelectField.value;
            const animationDuration = Number.parseInt(duration) / 1000; // convert to seconds for GSAP

            AnimationPreview.currentAnimation = AnimationPreview.createGsapAnimation(
                animationType,
                animationDuration
            );
        }

        AnimationPreview.defaultPreviewDuration = Number.parseInt(duration);
        AnimationPreview.defaultPreviewDelay = Number.parseInt(delay);
    };

    /**
     * Create GSAP animation based on animation type
     * @private
     */
    AnimationPreview.createGsapAnimation = (type, duration) => {
        const element = AnimationPreview.previewElement;
        let animation;

        switch(type) {
            case 'fade-up':
                animation = gsap.from(element, {
                    opacity: 0,
                    y: 50,
                    duration: duration,
                    ease: "power2.out"
                });
                break;
            case 'fade-down':
                animation = gsap.from(element, {
                    opacity: 0,
                    y: -50,
                    duration: duration,
                    ease: "power2.out"
                });
                break;
            case 'fade-right':
                animation = gsap.from(element, {
                    opacity: 0,
                    x: -50,
                    duration: duration,
                    ease: "power2.out"
                });
                break;
            case 'fade-left':
                animation = gsap.from(element, {
                    opacity: 0,
                    x: 50,
                    duration: duration,
                    ease: "power2.out"
                });
                break;
            case 'fade':
                animation = gsap.from(element, {
                    opacity: 0,
                    duration: duration,
                    ease: "power2.out"
                });
                break;
            case 'zoom-in':
                animation = gsap.from(element, {
                    opacity: 0,
                    scale: 0.5,
                    duration: duration,
                    ease: "power2.out"
                });
                break;
            case 'zoom-out':
                animation = gsap.from(element, {
                    opacity: 0,
                    scale: 1.5,
                    duration: duration,
                    ease: "power2.out"
                });
                break;
            case 'flip-up':
                animation = gsap.from(element, {
                    opacity: 0,
                    rotationX: 90,
                    transformOrigin: "center bottom",
                    duration: duration,
                    ease: "power2.out"
                });
                break;
            case 'flip-down':
                animation = gsap.from(element, {
                    opacity: 0,
                    rotationX: -90,
                    transformOrigin: "center top",
                    duration: duration,
                    ease: "power2.out"
                });
                break;
            default:
                animation = gsap.from(element, {
                    opacity: 0,
                    y: 30,
                    duration: duration,
                    ease: "power2.out"
                });
        }

        return animation;
    };

    /**
     * resets the preview animation
     * @private
     */
    AnimationPreview.restartAnimation = () => {
        // Kill any existing GSAP animations
        if (AnimationPreview.currentAnimation) {
            AnimationPreview.currentAnimation.kill();
            AnimationPreview.currentAnimation = null;
        }

        // Reset element
        gsap.set(AnimationPreview.previewElement, { clearProps: "all" });

        AnimationPreview.defaultPreviewDuration = 250;
        AnimationPreview.defaultPreviewDelay = 0;

        clearInterval(AnimationPreview.defaultInterval);
        AnimationPreview.playAnimationLoop();
    };

    /**
     * start the animation preview
     * @private
     */
    AnimationPreview.playAnimationLoop = () => {
        AnimationPreview.defaultInterval = setInterval(() => {
            if (AnimationPreview.currentAnimation) {
                // remove animation
                AnimationPreview.changeAnimation(250, 0, true);
            } else {
                // add animation
                AnimationPreview.changeAnimation(Number.parseInt(AnimationPreview.durationValueInputField.value), 1000, false);
            }
            // clearInterval and restart previewLoop
            clearInterval(AnimationPreview.defaultInterval);
            AnimationPreview.playAnimationLoop();
        }, AnimationPreview.defaultPreviewDuration + AnimationPreview.defaultPreviewDelay);
    };

    /**
     * handle if animation changed
     * @private
     * @param event
     */
    AnimationPreview.handleAnimationChange = (event) => {
        if (!event) return;
        AnimationPreview.previewLabel.setAttribute('data-show-preview', 'true');
        AnimationPreview.restartAnimation();
    };

    /**
     * handle if duration changed
     * @private
     * @param event
     */
    AnimationPreview.handleDurationChange = (event) => {
        if (!event) return;
        AnimationPreview.defaultPreviewDuration = Number.parseInt(event.target.value);
        AnimationPreview.restartAnimation();
    };

    /**
     * Initialize AnimationPreview
     */
    AnimationPreview.initialize = () => {
        // Check if GSAP is available
        if (typeof gsap === 'undefined') {
            console.error('GSAP is not loaded. Please include GSAP library.');
            return;
        }

        // if animationField is found in this form
        if (AnimationPreview.animationSelectField) {
            AnimationPreview.animationSelectField.addEventListener('change', AnimationPreview.handleAnimationChange);
        }

        // if durationField is found in this form
        if (AnimationPreview.durationInputField && AnimationPreview.durationValueInputField) {
            AnimationPreview.durationInputField.addEventListener('change', AnimationPreview.handleDurationChange);
            AnimationPreview.defaultPreviewDuration = Number.parseInt(AnimationPreview.durationValueInputField.value);
        }

        // initialize preview and start previewLoop
        AnimationPreview.playAnimationLoop();
    };

    // call init
    AnimationPreview.initialize();

    return AnimationPreview;
});

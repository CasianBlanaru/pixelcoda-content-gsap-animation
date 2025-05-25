(function () {
  'use strict';

  // GSAP Animation Preview
  document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
      const previewElement = document.querySelector('.ce-preview');
      const animationSelectField = document.querySelector('[name*="[tx_content_gsap_animation_animation]"]');
      const durationInputField = document.querySelector('[data-formengine-input-name*="[tx_content_gsap_animation_duration]"]');
      const durationValueInputField = document.querySelector('[name*="[tx_content_gsap_animation_duration]"]');
      const easingField = document.querySelector('[name*="[tx_content_gsap_animation_easing]"]');
      const delayField = document.querySelector('[name*="[tx_content_gsap_animation_delay]"]');

      const gsap = window.gsap;
      const AnimationDefinitions = window.AnimationDefinitions;

      if (!gsap) {
        console.error('GSAP not loaded. Please add GSAP library.');
        return;
      }
      if (!AnimationDefinitions) {
        console.error('AnimationDefinitions not loaded. Please ensure animation-definitions.js is loaded before this script.');
        return;
      }

      let defaultPreviewDuration = 800; // in ms
      const pauseBetweenLoops = 1000; // in ms, this was defaultPreviewDelay
      let animationInterval = null;

      function playGSAPPreview() {
        if (!previewElement || typeof gsap === 'undefined' || !AnimationDefinitions) return;

        const animType = animationSelectField?.value || 'default';
        const animDef = AnimationDefinitions[animType] || AnimationDefinitions['default'];

        if (!animDef) {
          console.error(`Animation definition for "${animType}" not found.`);
          return;
        }

        // Kill any existing tweens on the element to prevent conflicts
        gsap.killTweensOf(previewElement);

        const currentDurationSec = defaultPreviewDuration / 1000;
        const currentDelaySec = delayField && delayField.value ? parseFloat(delayField.value) / 1000 : 0;
        const currentEasing = easingField && easingField.value ? easingField.value : 'power2.out';

        gsap.fromTo(previewElement,
          { ...animDef.from },
          {
            ...animDef.to,
            duration: currentDurationSec,
            delay: currentDelaySec,
            ease: currentEasing,
            clearProps: "all", // Clears all inline styles set by GSAP upon completion or overwrite
            onStart: () => {
              // Ensure the element is visible at the start of the animation if opacity is involved
              if (animDef.from.hasOwnProperty('opacity')) {
                 gsap.set(previewElement, {opacity: animDef.from.opacity});
              } else if (animDef.to.hasOwnProperty('opacity') && animDef.to.opacity > 0) {
                 // If only 'to' has opacity and it's > 0, ensure it's initially visible if from doesn't specify
                 gsap.set(previewElement, {opacity: 0}); // Default to 0 if not specified in from
              }
            },
            onComplete: () => {
              setTimeout(() => {
                // Simple fade out after the main animation completes and pause
                gsap.to(previewElement, { opacity: 0, duration: 0.3 });
              }, pauseBetweenLoops);
            }
          }
        );
      }

      function startPreviewLoop() {
        if (animationInterval) clearInterval(animationInterval);
        playGSAPPreview(); // Play immediately
        // Calculate total cycle time: animation duration + delay + pause + fadeout time
        const totalCycleTime = (defaultPreviewDuration) +
                               (delayField && delayField.value ? parseFloat(delayField.value) : 0) +
                               pauseBetweenLoops + 300; // 300ms for the fade-out
        animationInterval = setInterval(playGSAPPreview, totalCycleTime);
      }

      function handleParameterChange() {
        // This function will be called by animation, duration, easing, or delay changes
        console.log('Animation parameters changed, restarting preview loop.');
        if (durationValueInputField) { // Update duration from the correct field
            defaultPreviewDuration = Number.parseInt(durationValueInputField.value) || 800;
        }
        startPreviewLoop();
      }

      function initialize() {
        console.log('GSAP Preview initialize');
        if (previewElement) {
          previewElement.classList.add('gsap-preview');
        }

        if (animationSelectField) {
          animationSelectField.addEventListener('change', handleParameterChange);
        }
        if (durationInputField) { // This is the slider
          durationInputField.addEventListener('change', (event) => {
              // Update the visible number input when slider changes
              if(durationValueInputField) durationValueInputField.value = event.target.value;
              handleParameterChange();
          });
        }
         if (durationValueInputField) { // This is the number input
             defaultPreviewDuration = Number.parseInt(durationValueInputField.value) || 800;
             // Also listen for direct changes to the number input if any
             durationValueInputField.addEventListener('change', (event) => {
                 defaultPreviewDuration = Number.parseInt(event.target.value) || 800;
                 // Optional: update slider if it exists and is separate
                 if(durationInputField && durationInputField !== event.target) durationInputField.value = event.target.value;
                 handleParameterChange();
             });
         }


        if (easingField) {
          easingField.addEventListener('change', handleParameterChange);
        }
        if (delayField) {
          delayField.addEventListener('change', handleParameterChange);
        }

        // Initial call to setup and start the animation loop
        if (previewElement) {
          startPreviewLoop();
        }
      }

      initialize();
    }, 100); // Short delay for initialization
  });

})();
//# sourceMappingURL=preview.bundle.js.map

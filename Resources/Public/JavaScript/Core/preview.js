console.log('preview.js: Script loaded.');

// GSAP Availability Check (early)
if (typeof gsap === 'undefined') {
    console.error('preview.js: GSAP library is NOT available globally!');
} else {
    console.log('preview.js: GSAP library is available (version:', gsap.version, ').');
}

// AnimationDefinitions Availability Check (early)
if (typeof window.AnimationDefinitions === 'undefined') {
    console.error('preview.js: window.AnimationDefinitions is NOT available!');
} else {
    console.log('preview.js: window.AnimationDefinitions is available.');
    console.log('preview.js: Found animation definitions keys:', Object.keys(window.AnimationDefinitions));
}

document.addEventListener('DOMContentLoaded', () => {
  console.log('preview.js: DOMContentLoaded event fired.');
  console.log('preview.js: Setting timeout for initialization.');
  setTimeout(() => {
    console.log('preview.js: Timeout callback reached. Ready to initialize.');
    const previewElement = document.querySelector('.ce-preview');
    const animationSelectField = document.querySelector('[name*="[tx_content_gsap_animation_animation]"]');
    const durationInputField = document.querySelector('[data-formengine-input-name*="[tx_content_gsap_animation_duration]"]');
    const durationValueInputField = document.querySelector('[name*="[tx_content_gsap_animation_duration]"]');
    const easingField = document.querySelector('[name*="[tx_content_gsap_animation_easing]"]');
    const delayField = document.querySelector('[name*="[tx_content_gsap_animation_delay]"]');

    const gsap = window.gsap; // Re-check in this scope if necessary, or rely on global
    const AnimationDefinitions = window.AnimationDefinitions; // Re-check in this scope

    if (!gsap) {
      console.error('preview.js: GSAP not loaded within setTimeout. Please add GSAP library.');
      return;
    }
    if (!AnimationDefinitions) {
      console.error('preview.js: AnimationDefinitions not loaded within setTimeout. Please ensure animation-definitions.js is loaded before this script.');
      return;
    }

    let defaultPreviewDuration = 800; // in ms
    const pauseBetweenLoops = 1000; // in ms
    let animationInterval = null;

    function playGSAPPreview() {
      console.log('preview.js: playGSAPPreview() called.');
      if (!previewElement || typeof gsap === 'undefined' || !AnimationDefinitions) {
        console.error('preview.js: playGSAPPreview() - critical prerequisites missing (previewElement, gsap, or AnimationDefinitions).');
        return;
      }

      const animType = animationSelectField?.value || 'default';
      const currentDurationMs = defaultPreviewDuration;
      const currentEase = easingField ? easingField.value : 'power2.out'; // Default from field or hardcoded
      const currentDelayMs = delayField && delayField.value ? parseFloat(delayField.value) : 0;

      console.log('preview.js: animType =', animType, '; duration =', currentDurationMs, 'ms; ease =', currentEase, '; delay =', currentDelayMs + 'ms');

      const animDef = AnimationDefinitions[animType] || AnimationDefinitions['default'];
      console.log('preview.js: Retrieved animDef =', animDef);

      if (!animDef) {
        console.error('preview.js: Animation definition NOT FOUND for type:', animType);
        return;
      }

      try {
        console.log('preview.js: Killing existing tweens of previewElement.');
        gsap.killTweensOf(previewElement);
      } catch (e) {
        console.error('preview.js: GSAP error during killTweensOf:', e);
      }

      const currentDurationSec = currentDurationMs / 1000;
      const currentDelaySec = currentDelayMs / 1000;

      console.log('preview.js: Animation params for GSAP: durationSec =', currentDurationSec, ', delaySec =', currentDelaySec, ', currentEase =', currentEase);

      try {
        console.log('preview.js: Applying gsap.fromTo() with fromVars:', animDef.from, 'and toVars:', animDef.to);
        gsap.fromTo(previewElement,
          { ...animDef.from },
          {
            ...animDef.to,
            duration: currentDurationSec,
            delay: currentDelaySec,
            ease: currentEase,
            clearProps: "all",
            onStart: () => {
              console.log('preview.js: GSAP onStart callback fired.');
              try {
                if (animDef.from.hasOwnProperty('opacity')) {
                  gsap.set(previewElement, {opacity: animDef.from.opacity});
                } else if (animDef.to.hasOwnProperty('opacity') && animDef.to.opacity > 0) {
                  gsap.set(previewElement, {opacity: 0});
                }
              } catch (e_onStart) {
                console.error('preview.js: GSAP error during onStart set:', e_onStart);
              }
            },
            onComplete: () => {
              console.log('preview.js: GSAP onComplete callback fired.');
              setTimeout(() => {
                console.log('preview.js: Fading out previewElement after pauseBetweenLoops.');
                try {
                  gsap.to(previewElement, { opacity: 0, duration: 0.3 });
                } catch (e_onComplete) {
                  console.error('preview.js: GSAP error during onComplete fadeOut:', e_onComplete);
                }
              }, pauseBetweenLoops);
            }
          }
        );
      } catch (e) {
        console.error('preview.js: GSAP error during fromTo animation:', e);
      }
    }

    function startPreviewLoop() {
      console.log('preview.js: startPreviewLoop() called. Current interval cleared:', animationInterval);
      if (animationInterval) clearInterval(animationInterval);
      playGSAPPreview();
      console.log('preview.js: First preview played in startPreviewLoop.');
      
      const currentDelayValue = delayField && delayField.value ? parseFloat(delayField.value) : 0;
      const totalCycleTime = defaultPreviewDuration + currentDelayValue + pauseBetweenLoops + 300; // 300ms for the fade-out

      console.log('preview.js: Setting interval with totalCycleTime:', totalCycleTime, 'ms (duration:', defaultPreviewDuration, 'ms, input delay:', currentDelayValue, 'ms, pause:', pauseBetweenLoops, 'ms, fadeOut: 300ms)');
      animationInterval = setInterval(playGSAPPreview, totalCycleTime);
    }

    function handleParameterChange() {
      console.log('preview.js: handleParameterChange() called.');
      if (durationValueInputField) {
          const newDuration = Number.parseInt(durationValueInputField.value);
          if (!isNaN(newDuration) && newDuration > 0) {
            defaultPreviewDuration = newDuration;
            console.log('preview.js: Updated defaultPreviewDuration to:', defaultPreviewDuration, 'ms');
          } else {
            console.warn('preview.js: Invalid duration value:', durationValueInputField.value, '. Keeping previous:', defaultPreviewDuration);
          }
      } else {
        console.warn('preview.js: durationValueInputField not found, cannot update duration.');
      }
      startPreviewLoop();
    }

    function initialize() {
      console.log('preview.js: initialize() called.');
      console.log('preview.js: previewElement =', previewElement);
      console.log('preview.js: animationSelectField =', animationSelectField);
      console.log('preview.js: durationInputField (slider) =', durationInputField);
      console.log('preview.js: durationValueInputField (number) =', durationValueInputField);
      console.log('preview.js: easingField =', easingField);
      console.log('preview.js: delayField =', delayField);

      if (!previewElement) console.error('preview.js: Preview element NOT FOUND in DOM.');
      if (!animationSelectField) console.warn('preview.js: Animation select field NOT FOUND in DOM.');
      if (!durationInputField) console.warn('preview.js: Duration input field (slider) NOT FOUND in DOM.');
      if (!durationValueInputField) console.warn('preview.js: Duration value input field (number) NOT FOUND in DOM.');
      if (!easingField) console.warn('preview.js: Easing field NOT FOUND in DOM.');
      if (!delayField) console.warn('preview.js: Delay field NOT FOUND in DOM.');


      if (previewElement) {
        previewElement.classList.add('gsap-preview');
      }

      if (animationSelectField) {
        animationSelectField.addEventListener('change', handleParameterChange);
      }
      if (durationInputField) {
        durationInputField.addEventListener('change', (event) => {
            console.log('preview.js: Duration slider changed to:', event.target.value);
            if(durationValueInputField) durationValueInputField.value = event.target.value;
            handleParameterChange(); // This will parse from durationValueInputField
        });
      }
       if (durationValueInputField) {
           const initialDuration = Number.parseInt(durationValueInputField.value);
            if (!isNaN(initialDuration) && initialDuration > 0) {
                defaultPreviewDuration = initialDuration;
            } else {
                console.warn('preview.js: Invalid initial duration from field:', durationValueInputField.value, '. Using default:', defaultPreviewDuration);
                durationValueInputField.value = defaultPreviewDuration; // Set to default if invalid
            }
           console.log('preview.js: Initial defaultPreviewDuration set to:', defaultPreviewDuration, 'ms from durationValueInputField.');
           durationValueInputField.addEventListener('change', (event) => {
               console.log('preview.js: Duration number input changed to:', event.target.value);
               // handleParameterChange will be called, which reads this field's value.
               // Optional: update slider if it exists and is separate
               if(durationInputField && durationInputField.value !== event.target.value) durationInputField.value = event.target.value;
               handleParameterChange();
           });
       }


      if (easingField) {
        easingField.addEventListener('change', handleParameterChange);
      }
      if (delayField) {
        delayField.addEventListener('change', handleParameterChange);
      }

      if (previewElement) {
        console.log('preview.js: Initializing preview loop.');
        startPreviewLoop();
      } else {
        console.error('preview.js: Cannot start preview loop, previewElement is missing.');
      }
    }

    initialize();
  }, 100); 
});

document.addEventListener('DOMContentLoaded', () => {
  setTimeout(() => {
    const previewElement = document.querySelector('.ce-preview');
    const animationSelectField = document.querySelector('[name*="[tx_content_gsap_animation_animation]"]');
    const durationInputField = document.querySelector('[data-formengine-input-name*="[tx_content_gsap_animation_duration]"]');
    const durationValueInputField = document.querySelector('[name*="[tx_content_gsap_animation_duration]"]');
    const easingField = document.querySelector('[name*="[tx_content_gsap_animation_easing]"]');
    const delayField = document.querySelector('[name*="[tx_content_gsap_animation_delay]"]');
    const delayRangeField = document.querySelector('[data-formengine-input-name*="[tx_content_gsap_animation_delay]"]');
    const previewLabel = document.querySelector('#preview-content-animation .preview-label');
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const gsap = window.gsap;
    const AnimationDefinitions = window.AnimationDefinitions;

    if (!previewElement || !gsap || !AnimationDefinitions) {
      return;
    }

    let defaultPreviewDuration = 800;
    const pauseBetweenLoops = 1000;
    let animationInterval = null;

    function playGSAPPreview() {
      if (prefersReducedMotion) {
        previewElement.style.opacity = '1';
        previewElement.style.transform = 'none';
        return;
      }

      const animType = animationSelectField?.value || 'default';
      const currentDurationMs = defaultPreviewDuration;
      const currentEase = easingField?.value || 'power2.out';
      const currentDelayMs = delayField && delayField.value ? parseFloat(delayField.value) : 0;
      const animDef = AnimationDefinitions[animType] || AnimationDefinitions.default;

      if (!animDef) {
        return;
      }

      gsap.killTweensOf(previewElement);

      const currentDurationSec = currentDurationMs / 1000;
      const currentDelaySec = currentDelayMs / 1000;

      if (previewLabel) {
        previewLabel.dataset.showPreview = 'true';
      }

      gsap.fromTo(previewElement,
        { ...animDef.from },
        {
          ...animDef.to,
          duration: currentDurationSec,
          delay: currentDelaySec,
          ease: currentEase,
          clearProps: 'all',
          onComplete: () => {
            setTimeout(() => {
              gsap.to(previewElement, { opacity: 0, duration: 0.3 });
            }, pauseBetweenLoops);
          }
        }
      );
    }

    function startPreviewLoop() {
      if (animationInterval) clearInterval(animationInterval);
      playGSAPPreview();

      const currentDelayValue = delayField && delayField.value ? parseFloat(delayField.value) : 0;
      const totalCycleTime = defaultPreviewDuration + currentDelayValue + pauseBetweenLoops + 300;

      if (!prefersReducedMotion) {
        animationInterval = setInterval(playGSAPPreview, totalCycleTime);
      }
    }

    function handleParameterChange() {
      if (durationValueInputField) {
          const newDuration = Number.parseInt(durationValueInputField.value);
          if (!isNaN(newDuration) && newDuration > 0) {
            defaultPreviewDuration = newDuration;
          }
      }
      startPreviewLoop();
    }

    function initialize() {
      previewElement.classList.add('gsap-preview');

      if (animationSelectField) {
        animationSelectField.addEventListener('change', handleParameterChange);
      }
      if (durationInputField) {
        durationInputField.addEventListener('change', (event) => {
            if(durationValueInputField) durationValueInputField.value = event.target.value;
            handleParameterChange();
        });
      }
       if (durationValueInputField) {
           const initialDuration = Number.parseInt(durationValueInputField.value);
            if (!isNaN(initialDuration) && initialDuration > 0) {
                defaultPreviewDuration = initialDuration;
            } else {
                durationValueInputField.value = defaultPreviewDuration;
            }
           durationValueInputField.addEventListener('change', (event) => {
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
      if (delayRangeField) {
        delayRangeField.addEventListener('change', (event) => {
          if (delayField) delayField.value = event.target.value;
          handleParameterChange();
        });
      }

      startPreviewLoop();
    }

    initialize();
  }, 100); 
});

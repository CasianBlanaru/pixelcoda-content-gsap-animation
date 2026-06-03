const initializeContentAnimationPreview = () => {
  const previewRoot = document.querySelector('#preview-content-animation');
  if (!previewRoot || previewRoot.dataset.initialized === 'true') {
    return;
  }
  previewRoot.dataset.initialized = 'true';

  window.requestAnimationFrame(() => {
    const previewElement = previewRoot.querySelector('.ce-preview');
    const animationSelectField = document.querySelector('[name*="[tx_content_gsap_animation_animation]"]');
    const durationInputField = document.querySelector('[data-pc-animation-range="tx_content_gsap_animation_duration"]');
    const durationValueInputField = document.querySelector('[data-pc-animation-number="tx_content_gsap_animation_duration"]');
    const easingField = document.querySelector('[name*="[tx_content_gsap_animation_easing]"]');
    const delayField = document.querySelector('[data-pc-animation-number="tx_content_gsap_animation_delay"]');
    const delayRangeField = document.querySelector('[data-pc-animation-range="tx_content_gsap_animation_delay"]');
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
    let pauseTimeout = null;

    function clearPreviewTimers() {
      if (animationInterval) {
        clearInterval(animationInterval);
        animationInterval = null;
      }
      if (pauseTimeout) {
        clearTimeout(pauseTimeout);
        pauseTimeout = null;
      }
    }

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
            pauseTimeout = setTimeout(() => {
              gsap.to(previewElement, { opacity: 0, duration: 0.3 });
            }, pauseBetweenLoops);
          }
        }
      );
    }

    function startPreviewLoop() {
      clearPreviewTimers();
      playGSAPPreview();

      const currentDelayValue = delayField && delayField.value ? parseFloat(delayField.value) : 0;
      const totalCycleTime = defaultPreviewDuration + currentDelayValue + pauseBetweenLoops + 300;

      if (!prefersReducedMotion && document.visibilityState !== 'hidden') {
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

    function syncFieldValue(targetField, value) {
      if (!targetField || targetField.value === value) {
        return;
      }
      targetField.value = value;
      targetField.dispatchEvent(new Event('input', { bubbles: true }));
      targetField.dispatchEvent(new Event('change', { bubbles: true }));
    }

    function addLiveListener(field, callback) {
      if (!field) {
        return;
      }
      field.addEventListener('input', callback);
      field.addEventListener('change', callback);
    }

    function initialize() {
      previewElement.classList.add('gsap-preview');

      if (animationSelectField) {
        animationSelectField.addEventListener('change', handleParameterChange);
      }
      if (durationInputField) {
        addLiveListener(durationInputField, (event) => {
            syncFieldValue(durationValueInputField, event.target.value);
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
           addLiveListener(durationValueInputField, (event) => {
               syncFieldValue(durationInputField, event.target.value);
               handleParameterChange();
           });
       }


      if (easingField) {
        easingField.addEventListener('change', handleParameterChange);
      }
      if (delayField) {
        addLiveListener(delayField, (event) => {
          syncFieldValue(delayRangeField, event.target.value);
          handleParameterChange();
        });
      }
      if (delayRangeField) {
        addLiveListener(delayRangeField, (event) => {
          syncFieldValue(delayField, event.target.value);
          handleParameterChange();
        });
      }

      document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'hidden') {
          clearPreviewTimers();
          gsap.killTweensOf(previewElement);
          return;
        }
        startPreviewLoop();
      });
      window.addEventListener('pagehide', () => {
        clearPreviewTimers();
        gsap.killTweensOf(previewElement);
      }, { once: true });

      startPreviewLoop();
    }

    initialize();
  });
};

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initializeContentAnimationPreview, { once: true });
} else {
  initializeContentAnimationPreview();
}

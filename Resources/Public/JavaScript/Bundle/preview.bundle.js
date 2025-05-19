(function () {
  'use strict';

  // GSAP Animation Preview
  document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
      const previewElement = document.querySelector('.ce-preview');
      const animationSelectField = document.querySelector('[name*="[tx_content_gsap_animation_animation]"]');
      const durationInputField = document.querySelector('[data-formengine-input-name*="[tx_content_gsap_animation_duration]"]');
      const durationValueInputField = document.querySelector('[name*="[tx_content_gsap_animation_duration]"]');
      const gsap = window.gsap;

      console.log('GSAP Preview loaded', typeof gsap, previewElement, animationSelectField);

      if (!gsap) {
        console.error('GSAP not loaded. Please add GSAP library.');
        return;
      }

      let defaultPreviewDuration = 800;
      const defaultPreviewDelay = 1000;
      let defaultInterval = null;

      function playGSAPPreview() {
        const animType = animationSelectField?.value || 'fade-up';
        console.log('playGSAPPreview called', animType, previewElement);
        if (!previewElement || typeof gsap === 'undefined') return;
        gsap.set(previewElement, { clearProps: "all" });

        const fromVars = { opacity: 0 };
        const toVars = { opacity: 1, duration: defaultPreviewDuration / 1000 };

        switch (animType) {
          case 'fade-up': fromVars.y = 50; toVars.y = 0; break;
          case 'fade-down': fromVars.y = -50; toVars.y = 0; break;
          case 'fade-left': fromVars.x = 50; toVars.x = 0; break;
          case 'fade-right': fromVars.x = -50; toVars.x = 0; break;
          case 'fade-up-right': fromVars.y = 50; fromVars.x = -50; toVars.y = 0; toVars.x = 0; break;
          case 'fade-up-left': fromVars.y = 50; fromVars.x = 50; toVars.y = 0; toVars.x = 0; break;
          case 'fade-down-right': fromVars.y = -50; fromVars.x = -50; toVars.y = 0; toVars.x = 0; break;
          case 'fade-down-left': fromVars.y = -50; fromVars.x = 50; toVars.y = 0; toVars.x = 0; break;
          case 'flip-up': fromVars.rotationX = 90; fromVars.transformPerspective = 1000; toVars.rotationX = 0; toVars.transformPerspective = 1000; break;
          case 'flip-down': fromVars.rotationX = -90; fromVars.transformPerspective = 1000; toVars.rotationX = 0; toVars.transformPerspective = 1000; break;
          case 'flip-left': fromVars.rotationY = -90; fromVars.transformPerspective = 1000; toVars.rotationY = 0; toVars.transformPerspective = 1000; break;
          case 'flip-right': fromVars.rotationY = 90; fromVars.transformPerspective = 1000; toVars.rotationY = 0; toVars.transformPerspective = 1000; break;
          case 'slide-up': fromVars.y = 100; toVars.y = 0; break;
          case 'slide-down': fromVars.y = -100; toVars.y = 0; break;
          case 'slide-left': fromVars.x = 100; toVars.x = 0; break;
          case 'slide-right': fromVars.x = -100; toVars.x = 0; break;
          case 'zoom-in': fromVars.scale = 0.5; toVars.scale = 1; break;
          case 'zoom-in-up': fromVars.scale = 0.5; fromVars.y = 100; toVars.scale = 1; toVars.y = 0; break;
          case 'zoom-in-down': fromVars.scale = 0.5; fromVars.y = -100; toVars.scale = 1; toVars.y = 0; break;
          case 'zoom-in-left': fromVars.scale = 0.5; fromVars.x = 100; toVars.scale = 1; toVars.x = 0; break;
          case 'zoom-in-right': fromVars.scale = 0.5; fromVars.x = -100; toVars.scale = 1; toVars.x = 0; break;
          case 'zoom-out': fromVars.scale = 1.5; toVars.scale = 1; break;
          case 'zoom-out-up': fromVars.scale = 1.5; fromVars.y = 100; toVars.scale = 1; toVars.y = 0; break;
          case 'zoom-out-down': fromVars.scale = 1.5; fromVars.y = -100; toVars.scale = 1; toVars.y = 0; break;
          case 'zoom-out-left': fromVars.scale = 1.5; fromVars.x = 100; toVars.scale = 1; toVars.x = 0; break;
          case 'zoom-out-right': fromVars.scale = 1.5; fromVars.x = -100; toVars.scale = 1; toVars.x = 0; break;
          default: fromVars.y = 30; toVars.y = 0;
        }

        gsap.set(previewElement, fromVars);
        gsap.to(previewElement, {
          ...toVars,
          onComplete: () => {
            setTimeout(() => {
              gsap.to(previewElement, { opacity: 0, y: 30, duration: 0.3 });
            }, defaultPreviewDelay);
          }
        });
      }

      function startPreviewLoop() {
        if (defaultInterval) clearInterval(defaultInterval);
        playGSAPPreview();
        defaultInterval = setInterval(playGSAPPreview, defaultPreviewDuration + defaultPreviewDelay + 300);
      }

      function handleAnimationChange(event) {
        console.log('Animation dropdown changed');
        startPreviewLoop();
      }

      function handleDurationChange(event) {
        defaultPreviewDuration = Number.parseInt(event.target.value);
        startPreviewLoop();
      }

      function initialize() {
        console.log('GSAP Preview initialize');
        if (previewElement) {
          previewElement.classList.add('gsap-preview');
          startPreviewLoop();
        }
        if (animationSelectField) {
          animationSelectField.addEventListener('change', handleAnimationChange);
        }
        if (durationInputField && durationValueInputField) {
          durationInputField.addEventListener('change', handleDurationChange);
          defaultPreviewDuration = Number.parseInt(durationValueInputField.value);
        }
      }

      initialize();
    }, 100); // Short delay for initialization
  });

})();
//# sourceMappingURL=preview.bundle.js.map

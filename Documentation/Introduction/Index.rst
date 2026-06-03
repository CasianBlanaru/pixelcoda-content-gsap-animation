.. include:: ../Includes.txt


.. _introduction:

============
Introduction
============


.. _what-it-does:

What Does This Extension Do?
================

Content GSAP Animation adds GSAP ScrollTrigger animations to TYPO3 content elements. Editors can choose ready-made fade, slide, zoom and flip animation presets directly in the content element form.

The animations are based on the GSAP library (GreenSock Animation Platform) with the ScrollTrigger plugin, which provides smooth, high-performance scroll animations that work when scrolling both down and up.

The extension supports classic TYPO3 rendering with Fluid Styled Content or Bootstrap Package and also exposes structured animation data for headless renderers, APIs and custom frontend integrations.


.. _screenshots:

Screenshot
==========

.. figure:: ../Images/Settings/backend-settings-animation-flow.gif
   :width: 900px
   :alt: TYPO3 backend animation settings flow

   TYPO3 backend animation settings flow with live preview and timing controls

.. _features:

Features
=========

* Animate TYPO3 content elements on scroll
* GSAP ScrollTrigger animation presets for fade, slide, zoom and flip effects
* Configurable duration, delay, and easing
* Animations trigger when scrolling down and up
* High-performance GSAP-based frontend implementation
* Responsive and accessible animation behavior
* Respects the visitor's ``prefers-reduced-motion`` setting
* Full TYPO3 backend integration with live preview
* Full-width premium backend preview with readable dark-mode styling and GIF preset examples
* Compatible with Bootstrap Package and Fluid Styled Content
* Automatic headless-ready structured animation settings via ``animationSettingsData``

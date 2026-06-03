.. include:: ../Includes.txt


.. _changelog:

=========
ChangeLog
=========

All notable changes to this project will be documented in this file.

The format is based on `Keep a Changelog <https://keepachangelog.com/en/1.0.0/>`_,
and this project adheres to `Semantic Versioning <https://semver.org/spec/v2.0.0.html>`_.

3.5.14 - 2026-06-03
===================

Changed
-------

* Improved Composer, TER, documentation and backend description texts for better TYPO3 extension discoverability.

3.5.13 - 2026-06-03
===================

Changed
-------

* Added styled frontend demo and updated Lighthouse 100 documentation screenshots.

3.5.12 - 2026-06-03
===================

Changed
-------

* Optimized frontend GSAP initialization to bail out on pages without animated elements and clean up animation contexts on page unload.
* Added a TYPO3 v13 Site Set for modern project integration with Fluid Styled Content.
* Reduced backend preview work with scoped initialization, timer cleanup, cached asset paths and a smaller minified stylesheet.
* Improved backend form accessibility with explicit labels for extended select controls and stable image dimensions in the preview.
* Documented TYPO3 14 compatibility and Site Set setup for modern TYPO3 projects.

Fixed
-----

* Improved backend dark-mode contrast for the two-column animation settings UI.
* Restored live synchronization for backend duration and delay sliders in TYPO3 14.

3.5.11 - 2026-06-03
===================

Changed
-------

* Rebuilt the backend Animation tab as a stable two-column layout with the preview on the left and settings on the right.

3.5.10 - 2026-06-03
===================

Changed
-------

* Moved the backend preview into a right-hand column while keeping the regular TYPO3 animation fields on the left.

3.5.9 - 2026-06-03
==================

Changed
-------

* Kept the normal TYPO3 backend fields and refined the preview itself into a two-column layout.
* Added the GSAP GreenSock SVG logo to the backend preview and documentation GIF.

3.5.8 - 2026-06-03
==================

Changed
-------

* Kept the backend animation preview in a two-column layout for TYPO3 editor workspaces.

Fixed
-----

* Restored the visible animation select label in the custom backend form element.

3.5.7 - 2026-06-03
==================

Fixed
-----

* Removed stale documentation references to the deleted backend preview GIF.
* Kept ``backend-settings-animation-flow.gif`` as the primary README and documentation animation media.

3.5.6 - 2026-06-03
==================

Changed
-------

* Swapped README and documentation hero media to the original TYPO3 backend settings-flow GIF.
* Moved the static premium preview behind the animated backend GIF as fallback media.

3.5.5 - 2026-06-03
==================

Changed
-------

* Reduced backend preview height and visual dominance in the Animation tab.
* Made the preview copy more concise and compact.

Fixed
-----

* Aligned the animation select icon inside the input group.

3.5.4 - 2026-06-03
==================

Changed
-------

* Regenerated the original TYPO3 backend settings-flow GIF with slower timing and more animation frames.

3.5.3 - 2026-06-03
==================

Added
-----

* Added an original TYPO3 backend settings-flow GIF showing the animation tab, preset changes, preview and timing controls.

3.5.2 - 2026-06-03
==================

Fixed
-----

* Replaced the cramped preview logo area with a clear GSAP wordmark badge.
* Tightened documentation preview spacing for a cleaner premium screenshot.

Added
-----

* Added an animated backend preview GIF for README, documentation and releases.
* Added GIF preset examples to the TYPO3 backend preview so editors can compare animation possibilities.

3.5.1 - 2026-06-03
==================

Fixed
-----

* Shortened backend preview copy so text cannot leave the preview panel.
* Reduced the top GSAP branding to a compact logo label.
* Regenerated documentation and release preview images without clipped text.

3.5.0 - 2026-06-03
==================

Changed
-------

* Improved backend preview readability in TYPO3 dark mode.
* Clarified in the backend preview that headless output is automatic via ``animationSettingsData``.
* Updated README and documentation to explain that there is no editor-side headless toggle.

Fixed
-----

* Prevented low-contrast preview title text and cramped dark-mode spacing.

3.4.0 - 2026-06-03
==================

Added
-----

* Added GreenSock logo branding to the TYPO3 backend animation preview.
* Added refreshed wide premium preview assets for README, documentation and releases.

Changed
-------

* Expanded the premium preview to use the full available backend form width.
* Improved preview copy for GSAP, reduced-motion and headless-ready usage.
* Updated README and documentation links while docs.typo3.org is not yet rendering the package page.

Fixed
-----

* Constrained GreenSock logo rendering and responsive text wrapping in the TYPO3 backend preview.

3.3.0 - 2026-06-03
==================

Added
-----

* Added premium backend preview layout with motion and headless-state indicators.
* Added generated premium preview screenshot for README, documentation and release notes.

Changed
-------

* Improved backend preview spacing, contrast, dark-mode rendering and visual hierarchy.
* Updated documentation to highlight the premium preview and headless-ready output.

3.2.0 - 2026-06-03
==================

Added
-----

* Added TYPO3 14.3 compatibility.
* Added structured ``animationSettingsData`` for headless and API renderers.
* Added test coverage for extended animation settings and structured data output.

Changed
-------

* Modernized backend preview UI.
* Frontend animations now respect ``prefers-reduced-motion``.
* Updated TCA to modern TYPO3 number fields and array item format.
* Replaced obsolete PageTS registration with a PageTSConfig file.
* Updated README and documentation with screenshots, accessibility and headless notes.

3.0.1 - 2025-05-07
===================

Features
-------

* Initial release of the GSAP Animation extension for TYPO3
* Support for scroll-triggered animations using GSAP and ScrollTrigger
* Animation support for scrolling both up and down (toggleActions: 'play reverse restart reset')
* Comprehensive backend preview functionality
* Optimized performance through efficient JavaScript bundle structure
* Advanced error detection and handling for missing libraries
* Full documentation with examples for all animation types

Technical Details
----------------

* Organized JavaScript directory structure with Core, Bundle, Module, and Vendor folders
* Data attributes with data-gsap-* prefixes for animation configuration
* Configurable animation options: duration, delay, easing, and more
* Compatible with TYPO3 v12 and v13

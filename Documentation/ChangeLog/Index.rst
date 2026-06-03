.. include:: ../Includes.txt


.. _changelog:

=========
ChangeLog
=========

All notable changes to this project will be documented in this file.

The format is based on `Keep a Changelog <https://keepachangelog.com/en/1.0.0/>`_,
and this project adheres to `Semantic Versioning <https://semver.org/spec/v2.0.0.html>`_.

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

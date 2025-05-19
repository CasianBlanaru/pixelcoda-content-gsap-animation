.. include:: ../Includes.txt


.. _changelog:

=========
ChangeLog
=========

All notable changes to this project will be documented in this file.

The format is based on `Keep a Changelog <https://keepachangelog.com/en/1.0.0/>`_,
and this project adheres to `Semantic Versioning <https://semver.org/spec/v2.0.0.html>`_.

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

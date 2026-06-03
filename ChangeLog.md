# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 3.5.0 - 2026-06-03
### Changed
- [IMPROVEMENT] Improved backend preview readability in TYPO3 dark mode.
- [IMPROVEMENT] Clarified in the backend preview that headless output is automatic via `animationSettingsData`.
- [IMPROVEMENT] Updated README and documentation to explain that there is no editor-side headless toggle.

### Fixed
- [FIX] Prevented low-contrast preview title text and cramped dark-mode spacing.

## 3.4.0 - 2026-06-03
### Added
- [FEATURE] Added GreenSock logo branding to the TYPO3 backend animation preview.
- [FEATURE] Added refreshed wide premium preview assets for README, documentation and releases.

### Changed
- [IMPROVEMENT] Expanded the premium preview to use the full available backend form width.
- [IMPROVEMENT] Improved preview copy for GSAP, reduced-motion and headless-ready usage.
- [IMPROVEMENT] Updated README and documentation links while docs.typo3.org is not yet rendering the package page.

### Fixed
- [FIX] Constrained GreenSock logo rendering and responsive text wrapping in the TYPO3 backend preview.

## 3.3.0 - 2026-06-03
### Added
- [FEATURE] Added premium backend preview layout with motion and headless-state indicators.
- [FEATURE] Added generated premium preview screenshot for README, documentation and release notes.

### Changed
- [IMPROVEMENT] Improved backend preview spacing, contrast, dark-mode rendering and visual hierarchy.
- [IMPROVEMENT] Updated documentation to highlight the premium preview and headless-ready output.

## 3.2.0 - 2026-06-03
### Added
- [FEATURE] Added TYPO3 14.3 compatibility.
- [FEATURE] Added structured `animationSettingsData` for headless/API renderers.
- [FEATURE] Added tests for extended GSAP settings and structured animation data.

### Changed
- [IMPROVEMENT] Modernized backend preview UI and language labels.
- [IMPROVEMENT] Frontend animations now respect `prefers-reduced-motion`.
- [IMPROVEMENT] Updated TCA to modern TYPO3 number fields and array item format.
- [IMPROVEMENT] Removed obsolete PageRenderer hook workaround and registered PageTS via file.
- [IMPROVEMENT] Updated README and TYPO3 documentation with screenshots, accessibility and headless notes.

## 3.0.5 - 2024-06-25
### Changed
- [IMPROVEMENT] Improved language consistency in JavaScript comments and error messages
- [FIX] Fixed various grammar issues in animation.js

## 3.0.4 - 2024-06-25
### Changed
- [IMPROVEMENT] Stable release version for TYPO3 Extension Repository (TER)
- [IMPROVEMENT] Final code cleanup and performance optimizations

## 3.0.3 - 2024-06-25
### Changed
- [IMPROVEMENT] Enhanced README.md with detailed description
- [IMPROVEMENT] Reorganized README.md structure for better readability

## 3.0.2 - 2024-06-25
### Changed
- [IMPROVEMENT] Updated extension to use local GSAP files instead of CDN
- [IMPROVEMENT] Removed fallback to CDN resources
- [IMPROVEMENT] Translated all code comments from German to English
- [IMPROVEMENT] Added extension icon to README.md for better visual identification

## 1.0.0 - 2025-05-07
### RELEASE
- [FEATURE] initial release of the GSAP Animation extension for TYPO3
- [FEATURE] support for scroll-triggered animations using GSAP and ScrollTrigger
- [FEATURE] animation support for scrolling both up and down (toggleActions: 'play reverse restart reset')
- [FEATURE] comprehensive backend preview functionality
- [FEATURE] optimized performance through efficient JavaScript bundle structure
- [FEATURE] advanced error detection and handling for missing libraries
- [FEATURE] full documentation with examples for all animation types

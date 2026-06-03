# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 3.5.14 - 2026-06-03
### Changed
- [IMPROVEMENT] Improved Composer, TER, documentation and backend description texts for better TYPO3 extension discoverability.

## 3.5.13 - 2026-06-03
### Changed
- [IMPROVEMENT] Added styled frontend demo and updated Lighthouse 100 documentation screenshots.

## 3.5.12 - 2026-06-03
### Changed
- [IMPROVEMENT] Optimized frontend GSAP initialization to bail out on pages without animated elements and clean up animation contexts on page unload.
- [IMPROVEMENT] Added a TYPO3 v13 Site Set for modern project integration with Fluid Styled Content.
- [IMPROVEMENT] Reduced backend preview work with scoped initialization, timer cleanup, cached asset paths and a smaller minified stylesheet.
- [IMPROVEMENT] Improved backend form accessibility with explicit labels for extended select controls and stable image dimensions in the preview.
- [IMPROVEMENT] Documented TYPO3 14 compatibility and Site Set setup for modern TYPO3 projects.

### Fixed
- [FIX] Improved backend dark-mode contrast for the two-column animation settings UI.
- [FIX] Restored live synchronization for backend duration and delay sliders in TYPO3 14.

## 3.5.11 - 2026-06-03
### Changed
- [IMPROVEMENT] Rebuilt the backend Animation tab as a stable two-column layout with the preview on the left and settings on the right.

## 3.5.10 - 2026-06-03
### Changed
- [IMPROVEMENT] Moved the backend preview into a right-hand column while keeping the regular TYPO3 animation fields on the left.

## 3.5.9 - 2026-06-03
### Changed
- [IMPROVEMENT] Kept the normal TYPO3 backend fields and refined the preview itself into a two-column layout.
- [IMPROVEMENT] Added the GSAP GreenSock SVG logo to the backend preview and documentation GIF.

## 3.5.8 - 2026-06-03
### Changed
- [IMPROVEMENT] Kept the backend animation preview in a two-column layout for TYPO3 editor workspaces.

### Fixed
- [FIX] Restored the visible animation select label in the custom backend form element.

## 3.5.7 - 2026-06-03
### Fixed
- [FIX] Removed stale documentation references to the deleted backend preview GIF.
- [FIX] Kept `backend-settings-animation-flow.gif` as the primary README and documentation animation media.

## 3.5.6 - 2026-06-03
### Changed
- [IMPROVEMENT] Swapped README and documentation hero media to the original TYPO3 backend settings-flow GIF.
- [IMPROVEMENT] Moved the static premium preview behind the animated backend GIF as fallback media.

## 3.5.5 - 2026-06-03
### Changed
- [IMPROVEMENT] Reduced backend preview height and visual dominance in the Animation tab.
- [IMPROVEMENT] Made the preview copy more concise and compact.

### Fixed
- [FIX] Aligned the animation select icon inside the input group.

## 3.5.4 - 2026-06-03
### Changed
- [IMPROVEMENT] Regenerated the original TYPO3 backend settings-flow GIF with slower timing and more animation frames.

## 3.5.3 - 2026-06-03
### Added
- [FEATURE] Added an original TYPO3 backend settings-flow GIF showing the animation tab, preset changes, preview and timing controls.

## 3.5.2 - 2026-06-03
### Fixed
- [FIX] Replaced the cramped preview logo area with a clear GSAP wordmark badge.
- [FIX] Tightened documentation preview spacing for a cleaner premium screenshot.

### Added
- [FEATURE] Added an animated backend preview GIF for README, documentation and releases.
- [FEATURE] Added GIF preset examples to the TYPO3 backend preview so editors can compare animation possibilities.

## 3.5.1 - 2026-06-03
### Fixed
- [FIX] Shortened backend preview copy so text cannot leave the preview panel.
- [FIX] Reduced the top GSAP branding to a compact logo label.
- [FIX] Regenerated documentation and release preview images without clipped text.

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

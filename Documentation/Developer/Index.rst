.. include:: ../Includes.txt


.. _developer:

================
Developer Corner
================

Content GSAP Animation comes with out-of-the-box support for **bootstrap_package v15, v14 and v13** as well as **fluid_styled_content**. Simply include the static TypoScript template of your used extension (e.g. Bootstrap Package) in the site template and you're ready to go.
This extension extends the **default Fluid layout** with the necessary data attributes to get the animations running in the frontend.


Constants
=========

The following global TypoScript constants are available:

+----------------------------------------------+---------------+-------------------------------------------------------------------+---------------+
| Parameter                                    | Data Type     | Description                                                       | Default       |
+==============================================+===============+===================================================================+===============+
| plugin.tx_content_gsap_animation.gsap-easing     | option        | Global easing for all animations                                  | power2.out    |
+----------------------------------------------+---------------+-------------------------------------------------------------------+---------------+
| plugin.tx_content_gsap_animation.gsap-once       | boolean       | Should the animation play only once                              | true          |
+----------------------------------------------+---------------+-------------------------------------------------------------------+---------------+
| plugin.tx_content_gsap_animation.gsap-duration   | integer       | Default duration of the animation in milliseconds                 | 800           |
+----------------------------------------------+---------------+-------------------------------------------------------------------+---------------+


Example
=======

Here's an example of how the rendered HTML should look:

.. code-block:: html

  <div id="c21563" class="frame frame-default frame-type-textpic ..." data-gsap-anim="fade-up" data-gsap-duration="800" data-gsap-delay="0" data-gsap-once="true" data-gsap-easing="power2.out">
      ...
  </div>


Headless Rendering
==================

Headless is not an editor-side setting. Editors choose the animation in the content element form; integrators decide how structured animation data is exposed in APIs, JSON responses or custom frontend adapters.

The data processor exposes both raw HTML attributes and structured data. Classic Fluid layouts can use the raw string, while headless renderers can use the structured array.

The backend preview also surfaces headless readiness visually, but does not force a frontend implementation. The structured output stays framework-agnostic.

Available processed variables:

* ``animationSettings``: raw HTML attribute string for Fluid layouts.
* ``gsapAnimationSettings``: legacy raw HTML attribute string.
* ``animationSettingsData``: structured animation data for APIs and headless renderers.
* ``gsapAnimationSettingsData``: legacy structured data alias.

Example structured data:

.. code-block:: json

   {
     "animation": "fade-up",
     "duration": 800,
     "delay": 0,
     "easing": "power2.out",
     "offset": 120,
     "anchorPlacement": "top-center",
     "once": true,
     "mirror": false
   }

Headless frontends should use this data to decide how animations are implemented. They can use GSAP, CSS transitions, native framework animations or no animation at all. Keep the reduced-motion decision in the frontend so API responses stay presentation-neutral.

In short: there is no additional backend toggle for headless mode. Use ``animationSettingsData`` from the processed content element data.


Extension
=========

If you use your own layouts and want to support content_gsap_animation, make sure that `Content GSAP Animation: Basic Configuration` is included in your TS template and that the snippet is included in the outer HTML tag of your content elements. This adds all necessary attributes and settings to the HTML tag.

.. code-block:: php

   {f:if(condition: animationSettings, then: '{animationSettings -> f:format.raw()}')}


LayoutRootPath
==============

Content GSAP Animation extends the layoutRootPaths with the key **100** in all TypoScript includes except `Content GSAP Animation: Basic Configuration`.

If you don't want this, override or delete it via ``lib.contentElement.layoutRootPaths.100 >`` in your template.


JavaScript Structure
==========

Content GSAP Animation uses the GSAP library (GreenSock Animation Platform) with ScrollTrigger plugin for powerful, smooth animations. The JavaScript files are organized as follows:

.. code-block:: bash

   JavaScript/
   ├── Bundle/             # Bundled JavaScript files
   │   ├── animation.bundle.js
   │   └── preview.bundle.js
   ├── Core/               # Source JavaScript files
   │   ├── animation.js
   │   └── preview.js
   ├── Module/             # Helper modules and classes
   │   └── AnimationPreview.js
   └── Vendor/             # External libraries
       └── gsap/
           ├── gsap.min.js
           └── ScrollTrigger.min.js

The files are used as follows:

- **Core/animation.js**: Contains the frontend animation logic with GSAP and ScrollTrigger
- **Core/preview.js**: Contains the backend preview animation logic for the TYPO3 backend
- **Bundle/**: Contains the compiled and optimized versions of the core files
- **Vendor/gsap/**: Contains the GSAP library and ScrollTrigger plugin

The JS files are automatically included in the page via TypoScript in the correct order:

.. code-block:: typoscript

   page {
       includeJSFooter {
           # GSAP main library
           gsap = EXT:content_gsap_animation/Resources/Public/JavaScript/Vendor/gsap/gsap.min.js
           gsap.defer = 1

           # ScrollTrigger plugin
           gsap_scrolltrigger = EXT:content_gsap_animation/Resources/Public/JavaScript/Vendor/gsap/ScrollTrigger.min.js
           gsap_scrolltrigger.defer = 1
           gsap_scrolltrigger.depends = gsap

           # Animation initialization file
           animations = EXT:content_gsap_animation/Resources/Public/JavaScript/Bundle/animation.bundle.js
           animations.defer = 1
           animations.depends = gsap_scrolltrigger
       }
   }

Available Animation Types
==================

The following animation types are available:

- fade-up
- fade-down
- fade-left
- fade-right
- fade
- zoom-in
- zoom-out
- flip-up
- flip-down
- slide-left
- slide-right

You can use these in your own layouts with the corresponding data attributes.

Accessibility
=============

The frontend JavaScript checks ``prefers-reduced-motion``. When reduced motion is active, animation attributes are ignored and no opacity or transform animation is applied.

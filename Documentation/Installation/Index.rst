.. include:: ../Includes.txt



.. _installation:

============
Installation
============

The extension must be installed like any other TYPO3 CMS extension.

If you use Composer, require this extension via:

.. code-block:: bash

   composer require pixelcoda/content-gsap-animation

Then run the TYPO3 extension setup:

.. code-block:: bash

   vendor/bin/typo3 extension:setup

Compatibility
=============

Version 3.5 supports TYPO3 12.4, TYPO3 13.4 and TYPO3 14.3+ within the TYPO3 14 release line.

Setup
=====

TYPO3 13 and TYPO3 14 Site Sets
-------------------------------

For projects using Site Sets, add the provided dependency to your site configuration:

.. code-block:: yaml

   dependencies:
     - pixelcoda/content-gsap-animation

Classic TypoScript templates
----------------------------

If your project still uses classic TypoScript template includes, add the matching **static TypoScript** to your site template.

.. note::

  You need to choose between these static includes of ``content_gsap_animation``:
   - Content GSAP Animation: Bootstrap Package v15.x
   - Content GSAP Animation: Fluid Styled Content

.. hint::

  Please note that the version information in the include itself is not based on the TYPO3 version. It is the major version of e.g. the Bootstrap Package itself. You can find this information in the composer.json or in the extension manager.

  **Example:** If you use the Bootstrap Package in version 15.0.x in your project, you need to include ``Content GSAP Animation: Bootstrap Package v15.x``. If it's version 14, then ``Content GSAP Animation: Bootstrap Package v14.x`` and so on.

JavaScript Dependencies
============

The extension uses GSAP (GreenSock Animation Platform) with ScrollTrigger for powerful, smooth animations. These libraries are automatically included via TypoScript.

If you want to use your own GSAP versions, you can override the TypoScript settings:

.. code-block:: typoscript

   page.includeJSFooter {
      gsap >
      gsap = EXT:your_extension/Resources/Public/JavaScript/gsap.min.js

      gsap_scrolltrigger >
      gsap_scrolltrigger = EXT:your_extension/Resources/Public/JavaScript/ScrollTrigger.min.js
   }

Lighthouse verification
=======================

The extension has been verified on a local TYPO3 test page with an animated content element and bundled GSAP assets:

.. image:: ../Images/Reports/frontend-styled.png
   :alt: Styled frontend demo for Pixelcoda Content GSAP Animation

.. image:: ../Images/Reports/lighthouse-100.png
   :alt: Lighthouse report with 100 scores for Performance, Accessibility, Best Practices and SEO

Measured values:

* Performance: 100
* Accessibility: 100
* Best Practices: 100
* SEO: 100
* First Contentful Paint: 1.2 s
* Largest Contentful Paint: 1.7 s
* Total Blocking Time: 20 ms
* Cumulative Layout Shift: 0

.. include:: ../Includes.txt



.. _installation:

============
Installation
============

The extension must be installed like any other TYPO3 CMS extension.

If you use Composer, you can simply require this extension via ``composer req pixelcoda/content-gsap-animation``.

Setup
=====

Once the extension is installed and activated, simply add the **static TypoScript** to your site template and you're ready to go.

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

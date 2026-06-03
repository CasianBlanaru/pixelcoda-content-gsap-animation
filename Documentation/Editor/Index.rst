.. include:: ../Includes.txt


.. _editor:

=============
Editor Corner
=============

As an editor, you can set an animation for your content elements by going to the **Animation** tab.

The screenshot below shows how you can set up an animation. You have the option to individually adjust the animation speed and delay of the content element.

.. tip::

   Please check your animation in the frontend to ensure a pleasant appearance for your users when they scroll through your page!

   Elements animating in different directions can be very distracting.

.. note::

   The animations are implemented with GSAP (GreenSock Animation Platform), which provides smooth animations and better performance. The animations are triggered when scrolling both down and up.

Accessibility
=============

Animations are automatically disabled for visitors who enabled reduced motion in their operating system or browser. This keeps the content visible and avoids motion that can be distracting or uncomfortable.


Backend Preview
===============

.. figure:: ../Images/Settings/backend-settings-animation-flow.gif
   :width: 900px
   :alt: Original TYPO3 backend animation settings flow

   Original TYPO3 backend flow showing animation settings, preset changes, preview and timing controls

.. figure:: ../Images/Settings/premium-preview.png
   :width: 900px
   :alt: Static premium preview of the animation in the TYPO3 backend

   Static fallback preview for documentation and release pages

The backend preview also shows GIF examples for common presets such as fade, slide, zoom and flip. Editors can compare the animation possibilities directly in the content element form.

Available Animation Types
==========================

The following animation types are available:

- **fade-up**: Element appears from below and fades in
- **fade-down**: Element appears from above and fades in
- **fade-left**: Element appears from the left and fades in
- **fade-right**: Element appears from the right and fades in
- **fade**: Element only fades in, without movement
- **zoom-in**: Element becomes larger and fades in
- **zoom-out**: Element becomes smaller and fades in
- **flip-up**: Element flips in from below
- **flip-down**: Element flips in from above
- **slide-left**: Element slides in from the left
- **slide-right**: Element slides in from the right

Extended Settings
=================

Administrators can enable extended animation settings in the extension configuration. Editors can then adjust:

- **Offset**: Starts the animation earlier or later relative to the viewport.
- **Anchor placement**: Defines where the trigger starts.
- **Play animation once**: Keeps an animation from replaying.
- **Mirror**: Reverses animation behavior when scrolling back.

.. figure:: ../Images/Settings/extended-settings.png
   :width: 860px
   :alt: Extended animation settings in the TYPO3 backend

   Extended animation settings for advanced editorial control

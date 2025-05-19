# Content GSAP Animation

<img src="ext_icon.svg" alt="Content GSAP Animation Icon" width="100" height="100"/>

`content_gsap_animation` is an extension for the TYPO3 content management system.

### What does it do
It allows you to set frontend animations to your content if its scrolled into the browsers viewport with bidirectional animation support (animations play in reverse when scrolling back up).\

### Dependencies
The extension is developed and tested with TYPO3 12.4 until 13.4 LTS. It has an out of the box `bootstrap_package v13, v14 and v15` and `fluid_styled_content` support.

### Configuration
Include the static TypoScript for `Content GSAP Animation: bootstrap_package v13, v14 or v15` or `Content GSAP Animation: fluid_styled_content` to your template and you can start animating.

### Extending
`content_gsap_animation` comes with an extended `Default` fluid layout which adds the necessary markup to get the animations working. If you want to extend the layout just copy it to your extension, remove or update the content elements `layoutRootPaths` and you're good to go.

## More Informations
See the [official documentation](https://docs.typo3.org/p/pixelcoda/content-gsap-animation/main/en-us/) for more details how to implement content_gsap_animation

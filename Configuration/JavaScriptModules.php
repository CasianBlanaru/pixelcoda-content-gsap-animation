<?php

return [
    'dependencies' => [
        'core',
    ],
    'tags' => [
        'backend.form',
    ],
    'imports' => [
        '@pixelcoda/content-gsap-animation/gsap' => 'EXT:content_animations/Resources/Public/JavaScript/Vendor/gsap/gsap.min.js',
        '@pixelcoda/content-gsap-animation/scrolltrigger' => 'EXT:content_animations/Resources/Public/JavaScript/Vendor/gsap/ScrollTrigger.min.js',
        '@pixelcoda/content-gsap-animation/preview' => 'EXT:content_animations/Resources/Public/JavaScript/Bundle/preview.bundle.js',
    ],
];

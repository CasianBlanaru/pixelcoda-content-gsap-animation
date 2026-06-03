<?php

/************************************************************************
 * Extension Manager/Repository config file for ext: "content_gsap_animation"
 ***********************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'Content GSAP Animation',
    'description' => 'Adds GSAP ScrollTrigger animations to TYPO3 content elements. Editors can choose fade, slide, zoom and flip presets in the Animation tab, preview the result in the backend and fine-tune duration, delay, easing, offset and scroll behavior. Supports Fluid Styled Content, Bootstrap Package, reduced-motion visitors and headless-ready animation data.',
    'category' => 'fe',
    'author' => 'Casian Blanaru',
    'author_email' => 'casianus@me.com',
    'author_company' => 'Pixelcoda',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '3.5.14',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-14.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

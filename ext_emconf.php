<?php

/************************************************************************
 * Extension Manager/Repository config file for ext: "content_gsap_animation"
 ***********************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'Content GSAP Animation',
    'description' => 'This extension allows you to set smooth GSAP-powered animations to your content elements when they are scrolled into the browser\'s viewport. Simply include the static typoscript of content_gsap_animation to your template and you\'re ready to go. Animations work when scrolling both up and down!',
    'category' => 'fe',
    'author' => 'Casian Blanaru',
    'author_email' => 'casianus@me.com',
    'author_company' => 'Pixelcoda',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '3.0.3',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

$tempColumns = [
    'tx_content_gsap_animation_animation' => [
        'exclude' => true,
        'label' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:label.animation',
        'config' => [
            'items' => [
                ['label' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:item.no-animation', 'value' => ''],
                ['label' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:item.fade-animations', 'value' => '--div--'],
                ['label' => 'fade', 'value' => 'fade', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/fade.gif'],
                ['label' => 'fade-up', 'value' => 'fade-up', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/fade-up.gif'],
                ['label' => 'fade-down', 'value' => 'fade-down', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/fade-down.gif'],
                ['label' => 'fade-right', 'value' => 'fade-right', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/fade-right.gif'],
                ['label' => 'fade-left', 'value' => 'fade-left', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/fade-left.gif'],
                ['label' => 'fade-up-right', 'value' => 'fade-up-right', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/fade-up-right.gif'],
                ['label' => 'fade-up-left', 'value' => 'fade-up-left', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/fade-up-left.gif'],
                ['label' => 'fade-down-right', 'value' => 'fade-down-right', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/fade-down-right.gif'],
                ['label' => 'fade-down-left', 'value' => 'fade-down-left', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/fade-down-left.gif'],
                ['label' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:item.flip-animations', 'value' => '--div--'],
                ['label' => 'flip-up', 'value' => 'flip-up', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/flip-up.gif'],
                ['label' => 'flip-down', 'value' => 'flip-down', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/flip-down.gif'],
                ['label' => 'flip-left', 'value' => 'flip-left', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/flip-left.gif'],
                ['label' => 'flip-right', 'value' => 'flip-right', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/flip-right.gif'],
                ['label' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:item.slide-animations', 'value' => '--div--'],
                ['label' => 'slide-up', 'value' => 'slide-up', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/slide-up.gif'],
                ['label' => 'slide-down', 'value' => 'slide-down', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/slide-down.gif'],
                ['label' => 'slide-right', 'value' => 'slide-right', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/slide-right.gif'],
                ['label' => 'slide-left', 'value' => 'slide-left', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/slide-left.gif'],
                ['label' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:item.zoom-animations', 'value' => '--div--'],
                ['label' => 'zoom-in', 'value' => 'zoom-in', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/zoom-in.gif'],
                ['label' => 'zoom-in-up', 'value' => 'zoom-in-up', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/zoom-in-up.gif'],
                ['label' => 'zoom-in-down', 'value' => 'zoom-in-down', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/zoom-in-down.gif'],
                ['label' => 'zoom-in-right', 'value' => 'zoom-in-right', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/zoom-in-right.gif'],
                ['label' => 'zoom-in-left', 'value' => 'zoom-in-left', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/zoom-in-left.gif'],
                ['label' => 'zoom-out', 'value' => 'zoom-out', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/zoom-out.gif'],
                ['label' => 'zoom-out-up', 'value' => 'zoom-out-up', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/zoom-out-up.gif'],
                ['label' => 'zoom-out-down', 'value' => 'zoom-out-down', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/zoom-out-down.gif'],
                ['label' => 'zoom-out-right', 'value' => 'zoom-out-right', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/zoom-out-right.gif'],
                ['label' => 'zoom-out-left', 'value' => 'zoom-out-left', 'icon' => 'EXT:content_gsap_animation/Resources/Public/Images/zoom-out-left.gif'],
            ],
            'renderType' => 'animationPreview',
            'type' => 'select',
            'size' => 1,
        ],
    ],
    'tx_content_gsap_animation_duration' => [
        'exclude' => true,
        'label' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:label.duration',
        'config' => [
            'type' => 'number',
            'size' => 5,
            'range' => [
                'lower' => 400,
                'upper' => 3000,
            ],
            'default' => 800,
            'slider' => [
                'step' => 50,
                'width' => 200,
            ],
        ],
    ],
    'tx_content_gsap_animation_delay' => [
        'exclude' => true,
        'label' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:label.delay',
        'config' => [
            'type' => 'number',
            'size' => 5,
            'range' => [
                'lower' => 0,
                'upper' => 3000,
            ],
            'default' => 0,
            'slider' => [
                'step' => 50,
                'width' => 200,
            ],
        ],
    ],

    'tx_content_gsap_animation_offset' => [
        'exclude' => true,
        'label' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:label.offset',
        'config' => [
            'type' => 'number',
            'size' => 5,
            'default' => 0,
        ],
    ],

    'tx_content_gsap_animation_anchor_placement' => [
        'exclude' => true,
        'label' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:label.anchor-placement',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            //'size' => 1,
            'items' => [
                ['label' => '', 'value' => ''],
                ['label' => 'top-bottom', 'value' => 'top-bottom'],
                ['label' => 'top-center', 'value' => 'top-center'],
                ['label' => 'top-top', 'value' => 'top-top'],
                ['label' => 'center-bottom', 'value' => 'center-bottom'],
                ['label' => 'center-center', 'value' => 'center-center'],
                ['label' => 'center-top', 'value' => 'center-top'],
                ['label' => 'bottom-bottom', 'value' => 'bottom-bottom'],
                ['label' => 'bottom-center', 'value' => 'bottom-center'],
                ['label' => 'bottom-top', 'value' => 'bottom-top'],
            ],
        ],
    ],
    'tx_content_gsap_animation_once' => [
        'exclude' => true,
        'label' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:label.once',
        'description' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:desc.once',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'default' => 1,
        ],
    ],
    'tx_content_gsap_animation_mirror' => [
        'exclude' => true,
        'label' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:label.mirror',
        'description' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:desc.mirror',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'default' => 0,
        ],
    ],
    'tx_content_gsap_animation_easing' => [
        'exclude' => true,
        'label' => 'LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:label.easing',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['label' => '', 'value' => ''],
                ['label' => 'linear', 'value' => 'linear'],
                ['label' => 'power1.out', 'value' => 'power1.out'],
                ['label' => 'power2.out', 'value' => 'power2.out'],
                ['label' => 'power3.out', 'value' => 'power3.out'],
                ['label' => 'power4.out', 'value' => 'power4.out'],
                ['label' => 'back.out', 'value' => 'back.out'],
                ['label' => 'bounce.out', 'value' => 'bounce.out'],
                ['label' => 'circ.out', 'value' => 'circ.out'],
                ['label' => 'expo.out', 'value' => 'expo.out'],
                ['label' => 'sine.out', 'value' => 'sine.out'],
            ],
        ],
    ],
];

// Add animation palettes
$GLOBALS['TCA']['tt_content']['palettes']['tx_content_gsap_animation_animation'] = [
    'showitem' => 'tx_content_gsap_animation_animation',
];

// Add animation timing palette
$GLOBALS['TCA']['tt_content']['palettes']['tx_content_gsap_animation_timing'] = [
    'showitem' => '
        tx_content_gsap_animation_duration,
        tx_content_gsap_animation_delay
    ',
];

// Add extended animations palette
$GLOBALS['TCA']['tt_content']['palettes']['tx_content_gsap_animation_extended'] = [
    'showitem' => '
        tx_content_gsap_animation_once,
        tx_content_gsap_animation_mirror,
        --linebreak--,
        tx_content_gsap_animation_easing,
        --linebreak--,
        tx_content_gsap_animation_anchor_placement,
        --linebreak--,
        tx_content_gsap_animation_offset
    ',
];

// Add all fields to tt_content
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns);

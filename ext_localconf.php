<?php

if (!defined('TYPO3_MODE') && !defined('TYPO3')) {
    die ('Access denied.');
}

// Register custom renderType
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1552428667] = [
    'nodeName' => 'animationPreview',
    'priority' => '40',
    'class' => \Pixelcoda\ContentGsapAnimation\Form\Elements\AnimationPreviewField::class
];

// Register custom typoscript FILECONTENT cObject (can be removed once v11 support is dropped)
if(!isset($GLOBALS['TYPO3_CONF_VARS']['FE']['ContentObjects']['FILECONTENT'])) {
	$GLOBALS['TYPO3_CONF_VARS']['FE']['ContentObjects'] = array_merge(
		$GLOBALS['TYPO3_CONF_VARS']['FE']['ContentObjects'] ?? [],
		['FILECONTENT' => \Pixelcoda\ContentGsapAnimation\ContentObject\FileContentContentObject::class]
	);
}

// Get extension configuration for 'content_gsap_animation'
$extensionManagementUtility = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class);
$extensionConfiguration = $extensionManagementUtility->get('content_gsap_animation');

// Register footer preview to tt_content_drawFooter hook if this feature is active
if (empty($extensionConfiguration['hideFooterAnimationLabel']) || !$extensionConfiguration['hideFooterAnimationLabel']) {
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('templates.typo3/cms-backend.partialsRootPaths = pixelcoda/content-gsap-animation:Resources/Private/TemplateOverrides/typo3/cms-backend');
}

// Workaround for TYPO3 v13 compatibility issue with JavaScriptRenderer
// Add the necessary JavaScript files directly to the page renderer
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess']['content_gsap_animation'] = function (&$params) {
    // We only need to check if PageRenderer is available
    if (isset($params['pageRenderer'])) {

        $gsapPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName(
            'EXT:content_gsap_animation/Resources/Public/JavaScript/Vendor/gsap/gsap.min.js'
        );

        $scrollTriggerPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName(
            'EXT:content_gsap_animation/Resources/Public/JavaScript/Vendor/gsap/ScrollTrigger.min.js'
        );

        $gsapWebPath = \TYPO3\CMS\Core\Utility\PathUtility::getAbsoluteWebPath($gsapPath);
        $scrollTriggerWebPath = \TYPO3\CMS\Core\Utility\PathUtility::getAbsoluteWebPath($scrollTriggerPath);

        // GSAP und ScrollTrigger
        $params['pageRenderer']->addJsFooterFile(
            $gsapWebPath,
            'text/javascript',
            false,
            false,
            '',
            false
        );

        $params['pageRenderer']->addJsFooterFile(
            $scrollTriggerWebPath,
            'text/javascript',
            false,
            false,
            '',
            false
        );

        // Animation
        $bundlePath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName(
            'EXT:content_gsap_animation/Resources/Public/JavaScript/Bundle/animation.bundle.js'
        );

        if (@file_exists($bundlePath)) {
            $params['pageRenderer']->addJsFooterFile(
                \TYPO3\CMS\Core\Utility\PathUtility::getAbsoluteWebPath($bundlePath),
                'text/javascript',
                false,
                false,
                '',
                false
            );
        }
    }
};

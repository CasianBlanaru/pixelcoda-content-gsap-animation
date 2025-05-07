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

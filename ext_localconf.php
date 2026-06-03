<?php

if (!defined('TYPO3')) {
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

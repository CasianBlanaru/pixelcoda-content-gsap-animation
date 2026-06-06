<?php

if (!defined('TYPO3')) {
    die ('Access denied.');
}

// get typo3 version
$typo3Version = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class);

// get extensionConfiguration for 'content_gsap_animation'
$extensionManagementUtility = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class);
$extensionConfiguration = $extensionManagementUtility->get('content_gsap_animation');
$toBoolean = static fn (mixed $value, bool $default = false): bool => $value === null
    ? $default
    : filter_var($value, FILTER_VALIDATE_BOOLEAN);
$disableAddAnimationsTab = $toBoolean($extensionConfiguration['disableAddAnimationsTab'] ?? null);
$extendedAnimationSettings = $toBoolean($extensionConfiguration['extendedAnimationSettings'] ?? null, true);
$hideFooterAnimationLabel = $toBoolean($extensionConfiguration['hideFooterAnimationLabel'] ?? null);

// add animation tab to all CTypes if not disabled via extension settings
if (!$disableAddAnimationsTab && !$extendedAnimationSettings) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '
    --div--;LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:tab.animation,
    --palette--;LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:palette.animation-settings;
        tx_content_gsap_animation_animation
	'
    );
}

// extended animation settings for all CTypes
if (!$disableAddAnimationsTab && $extendedAnimationSettings) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '
	--div--;LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:tab.animation,
	--palette--;LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:palette.animation-settings;
		tx_content_gsap_animation_animation
	'
    );
}

// add own footer partial to containerConfiguration if TYPO3 > v11 and ext: container is installed and used
if ($typo3Version->getMajorVersion() > 11) {
    if (!$hideFooterAnimationLabel) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
            'content_gsap_animation',
            'Configuration/page.tsconfig',
            'Content GSAP Animation'
        );

        $containerConfiguration = &$GLOBALS['TCA']['tt_content']['containerConfiguration'] ?? null;
        if ($containerConfiguration) {
            foreach (array_keys($containerConfiguration) as $cType) {
                $containerConfiguration[$cType]['gridPartialPaths'][] = 'EXT:content_gsap_animation/Resources/Private/TemplateOverrides/typo3/cms-backend/Partials';
            }
        }
    }
}

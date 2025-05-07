<?php
if (!defined('TYPO3_MODE') && !defined('TYPO3')) {
    die('Access denied.');
}

// add static typoscript includes
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('content_gsap_animation', 'Configuration/TypoScript', 'Content Animations: Basic Configuration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('content_gsap_animation', 'Configuration/TypoScript/BootstrapPackage/v15', 'Content Animations: Bootstrap Package v15.x');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('content_gsap_animation', 'Configuration/TypoScript/FluidStyledContent', 'Content Animations: Fluid Styled Content');

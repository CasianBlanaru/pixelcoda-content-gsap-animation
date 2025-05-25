<?php

declare(strict_types=1);

namespace Pixelcoda\ContentGsapAnimation\Form\Elements;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Backend\Form\Utility\FormEngineUtility;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\ConsumableNonce;

/**
 * This file is part of the "content_gsap_animation" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2025 Casian Blanaru <casianus@me.com>
 *
 * Class AnimationPreviewField
 */


class AnimationPreviewField extends AbstractFormElement
{
    /**
     * @var array
     */
    protected $defaultFieldInformation = [
        'tcaDescription' => [
            'renderType' => 'tcaDescription',
        ],
    ];

    /**
     * @var array
     */
    protected $defaultFieldWizard = [
        'localizationStateSelector' => [
            'renderType' => 'localizationStateSelector',
        ],
        'otherLanguageContent' => [
            'renderType' => 'otherLanguageContent',
            'after' => [
                'localizationStateSelector',
            ],
        ],
        'defaultLanguageDifferences' => [
            'renderType' => 'defaultLanguageDifferences',
            'after' => [
                'otherLanguageContent',
            ],
        ],
    ];

    /**
     * Get the TYPO3 PageRenderer instance
     *
     * @return PageRenderer
     */
    protected function getPageRenderer(): PageRenderer
    {
        return GeneralUtility::makeInstance(PageRenderer::class);
    }

    /**
     * This will render a checkbox or an array of checkboxes
     *
     * @return array As defined in initializeResultArray() of AbstractNode
     */
    public function render(): array
    {
        $parameterArray = $this->data['parameterArray'];
        $config = $parameterArray['fieldConf']['config'];
        $fieldInformationResult = $this->renderFieldInformation();
        $fieldInformationHtml = $fieldInformationResult['html'];

        // Initialization:
        $selectId = StringUtility::getUniqueId('tceforms-select-');
        $selectItems = $parameterArray['fieldConf']['config']['items'] ?? [];
        $selectedIcon = '';
        $size = isset($config['size']) ? (int) $config['size'] : 1;

        // Style set on <select/>
        $options = '';
        $disabled = isset($config['readOnly']) && $config['readOnly'] !== false;

        // Prepare groups
        $selectItemCounter = 0;
        $selectItemGroupCount = 0;
        $selectItemGroups = [];
        $selectedValue = '';
        $hasIcons = false;

        if (isset($parameterArray['itemFormElValue'][0])) {
            $selectedValue = (string) $parameterArray['itemFormElValue'][0];
        }

        foreach ($selectItems as $item) {
            $itemValue = $item['value'] ?? null;
            $itemLabel = $item['label'] ?? null;

            if ($itemValue === '--div--') {
                // IS OPTGROUP
                if ($selectItemCounter !== 0) {
                    $selectItemGroupCount++;
                }
                $selectItemGroups[$selectItemGroupCount]['header'] = [
                    'title' => $itemLabel ?? '',
                ];
            } else {
                // IS ITEM
                $itemIcon = $item['icon'] ?? null;
                if ($itemIcon !== null && $itemIcon !== '') {
                    $icon = FormEngineUtility::getIconHtml($itemIcon, (string) $itemLabel, (string) $itemLabel);
                } else {
                    $icon = '';
                }

                $selected = $selectedValue === (string) $itemValue;

                if ($selected) {
                    $selectedIcon = $icon;
                }

                $selectItemGroups[$selectItemGroupCount]['items'][] = [
                    'title' => $this->appendValueToLabelInDebugMode((string) $itemLabel, (string) $itemValue),
                    'value' => $itemValue,
                    'icon' => $icon,
                    'selected' => $selected,
                ];
                $selectItemCounter++;
            }
        }

        // Fallback icon
        if ($selectedIcon === '' && isset($selectItemGroups[0]['items'][0]['icon'])) {
            $selectedIcon = $selectItemGroups[0]['items'][0]['icon'];
        }

        // Process groups
        foreach ($selectItemGroups as $selectItemGroup) {
            if (!isset($selectItemGroup['items']) || $selectItemGroup['items'] === []) {
                continue;
            }

            $optionGroup = isset($selectItemGroup['header']) && is_array($selectItemGroup['header']);
            $groupTitle = $optionGroup ? ($selectItemGroup['header']['title'] ?? '') : '';
            $options .= $optionGroup ? '<optgroup label="' . htmlspecialchars($groupTitle, ENT_COMPAT, 'UTF-8', false) . '">' : '';

            foreach ($selectItemGroup['items'] as $item) {
                $options .= sprintf(
                    '<option value="%s" data-icon="%s"%s>%s</option>',
                    htmlspecialchars((string) $item['value']),
                    htmlspecialchars($item['icon']),
                    $item['selected'] ? ' selected="selected"' : '',
                    htmlspecialchars($item['title'], ENT_COMPAT, 'UTF-8', false)
                );
                $hasIcons = $item['icon'] !== '';
            }

            $options .= $optionGroup ? '</optgroup>' : '';
        }

        $selectAttributes = [
            'id' => $selectId,
            'name' => $parameterArray['itemFormElName'],
            'data-formengine-validation-rules' => $this->getValidationDataAsJsonString($config),
            'class' => 'form-control form-control-adapt',
        ];
        if ($size > 1) {
            $selectAttributes['size'] = (string) $size;
        }
        if ($disabled) {
            $selectAttributes['disabled'] = 'disabled';
        }

        $fieldWizardResult = $this->renderFieldWizard();
        $fieldWizardHtml = $fieldWizardResult['html'];

        $html = [];
        $html[] = '<div class="formengine-field-item t3js-formengine-field-item">';
        $html[] = $fieldInformationHtml;
        $html[] = '<div class="form-control-wrap">';
        $html[] = '<div class="form-wizards-wrap">';
        $html[] = '<div class="form-wizards-element">';
        if ($hasIcons) {
            $html[] = '<div class="input-group">';
            $html[] = '<span class="input-group-addon input-group-icon">';
            $html[] = $selectedIcon;
            $html[] = '</span>';
        }
        $html[] = '<select ' . GeneralUtility::implodeAttributes($selectAttributes, true) . '>';
        $html[] = $options;
        $html[] = '</select>';
        if ($hasIcons) {
            $html[] = '</div>';
        }
        $html[] = '</div>';
        if (!$disabled && $fieldWizardHtml !== '') {
            $html[] = '<div class="form-wizards-items-bottom">';
            $html[] = $fieldWizardHtml;
            $html[] = '</div>';
        }
        $html[] = '</div>';
        $html[] = '</div>';
        $html[] = '</div>';

        $html[] = '<div id="preview-content-animation">';
        $previewLabel = LocalizationUtility::translate('LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:preview-label');
        $html[] = '<div class="preview-label" data-show-preview="false">' . ($previewLabel ?? '') . '</div>';
        $html[] = '<div class="ce-preview">';
        $html[] = '<div class="ce-preview__visual-placeholder"></div>';
        $html[] = '<div class="ce-preview__text-line"></div>';
        $html[] = '<div class="ce-preview__text-line ce-preview__text-line--short"></div>';
        $html[] = '</div>';
        $html[] = '</div>';

        $result = [
            'html' => implode(LF, $html),
            'additionalInlineLanguageLabelFiles' => [],
            'stylesheetFiles' => [
                'EXT:content_gsap_animation/Resources/Public/Styles/animation-preview.min.css',            ],
        ];

        // Load GSAP and ScrollTrigger
        $pageRenderer = $this->getPageRenderer();

        // Get file paths for local GSAP resources
        $gsapPath = GeneralUtility::getFileAbsFileName(
            'EXT:content_gsap_animation/Resources/Public/JavaScript/Vendor/gsap/gsap.min.js'
        );
        $scrollTriggerPath = GeneralUtility::getFileAbsFileName(
            'EXT:content_gsap_animation/Resources/Public/JavaScript/Vendor/gsap/ScrollTrigger.min.js'
        );

        // Get web paths for GSAP resources
        $gsapWebPath = PathUtility::getAbsoluteWebPath($gsapPath);
        $scrollTriggerWebPath = PathUtility::getAbsoluteWebPath($scrollTriggerPath);

        // Load GSAP
        $pageRenderer->addJsFooterLibrary(
            'gsap',
            $gsapWebPath,
            'text/javascript',
            false,
            false,
            '',
            true
        );

        // Load ScrollTrigger
        $pageRenderer->addJsFooterLibrary(
            'gsap_scrolltrigger',
            $scrollTriggerWebPath,
            'text/javascript',
            false,
            false,
            '',
            true,
            '|defer',
            false,
            '',
            'gsap'
        );

        // Load Animation Definitions
        $animationDefinitionsPath = GeneralUtility::getFileAbsFileName(
            'EXT:content_gsap_animation/Resources/Public/JavaScript/Core/animation-definitions.js'
        );
        $animationDefinitionsWebPath = PathUtility::getAbsoluteWebPath($animationDefinitionsPath);

        $pageRenderer->addJsFooterLibrary(
            'content_gsap_animation_definitions', // Key
            $animationDefinitionsWebPath,          // Path
            'text/javascript',
            false,  // $compress
            false,  // $forceOnTop
            '',     // $allWrap
            true,   // $typo3PageModuleRelevant
            '|defer', // $additionalAttributes
            false,  // $enableAsyncInES6Modules
            'gsap_scrolltrigger' // $dependencies
        );

        // Load Preview-Bundle
        $previewPath = GeneralUtility::getFileAbsFileName(
            'EXT:content_gsap_animation/Resources/Public/JavaScript/Bundle/preview.bundle.js'
        );
        $previewWebPath = PathUtility::getAbsoluteWebPath($previewPath);

        $pageRenderer->addJsFooterLibrary(
            'content_gsap_animation_preview_bundle', // Key
            $previewWebPath,                         // Path
            'text/javascript',
            false, // $compress
            false, // $forceOnTop
            '',    // $allWrap
            true,  // $typo3PageModuleRelevant
            '|defer', // $additionalAttributes
            false, // $enableAsyncInES6Modules
            'content_gsap_animation_definitions' // $dependencies
        );

        return $result;
    }

    /**
     * @param array $config
     */
    protected function getValidationDataAsJsonString(array $config): string
    {
        $validationRules = [];

        if (isset($config['eval']) && $config['eval'] !== '') {
            $evalList = GeneralUtility::trimExplode(',', $config['eval'], true);
            foreach ($evalList as $evalType) {
                $validationRules[] = ['type' => $evalType];
            }
        }

        if (isset($config['range']) && $config['range'] !== []) {
            $newValidationRule = ['type' => 'range'];
            if (isset($config['range']['lower'])) {
                $newValidationRule['lower'] = $config['range']['lower'];
            }
            if (isset($config['range']['upper'])) {
                $newValidationRule['upper'] = $config['range']['upper'];
            }
            $validationRules[] = $newValidationRule;
        }

        if (isset($config['maxitems']) || isset($config['minitems'])) {
            $minItems = isset($config['minitems']) ? (int) $config['minitems'] : 0;
            $maxItems = isset($config['maxitems']) ? (int) $config['maxitems'] : 99999;
            $type = isset($config['type']) ? $config['type'] : 'range';
            $validationRules[] = [
                'type' => $type,
                'minItems' => $minItems,
                'maxItems' => $maxItems
            ];
        }

        if (isset($config['required']) && $config['required'] !== false) {
            $validationRules[] = ['type' => 'required'];
        }

        return json_encode($validationRules) ?: '[]';
    }

    protected function renderFieldInformation(): array
    {
        $options = $this->data;
        $fieldInformation = $this->defaultFieldInformation;
        $fieldInformationFromTca = $options['parameterArray']['fieldConf']['config']['fieldInformation'] ?? [];
        ArrayUtility::mergeRecursiveWithOverrule($fieldInformation, $fieldInformationFromTca);
        $options['renderType'] = 'fieldInformation';
        $options['renderData']['fieldInformation'] = $fieldInformation;

        /** @var array{html: string} */
        return $this->nodeFactory->create($options)->render();
    }
}

<?php

declare(strict_types=1);

namespace Pixelcoda\ContentGsapAnimation\Form\Elements;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Backend\Form\Utility\FormEngineUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
     * @var array<string, string>
     */
    private static array $assetWebPathCache = [];

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

        // Fallback to the first real option icon when "No animation" is selected.
        if ($selectedIcon === '') {
            foreach ($selectItemGroups as $selectItemGroup) {
                foreach (($selectItemGroup['items'] ?? []) as $item) {
                    if (($item['icon'] ?? '') !== '') {
                        $selectedIcon = (string) $item['icon'];
                        break 2;
                    }
                }
            }
        }

        // Process groups
        foreach ($selectItemGroups as $selectItemGroup) {
            $groupItems = $selectItemGroup['items'] ?? [];
            if ($groupItems === []) {
                continue;
            }

            $groupTitle = (string)($selectItemGroup['header']['title'] ?? '');
            $optionGroup = $groupTitle !== '';
            $options .= $optionGroup ? '<optgroup label="' . htmlspecialchars($groupTitle, ENT_COMPAT, 'UTF-8', false) . '">' : '';

            foreach ($groupItems as $item) {
                $options .= sprintf(
                    '<option value="%s" data-icon="%s"%s>%s</option>',
                    htmlspecialchars((string) $item['value']),
                    htmlspecialchars($item['icon']),
                    $item['selected'] ? ' selected="selected"' : '',
                    htmlspecialchars($item['title'], ENT_COMPAT, 'UTF-8', false)
                );
                if ($item['icon'] !== '') {
                    $hasIcons = true;
                }
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
        $fieldLabel = (string)($parameterArray['fieldConf']['label'] ?? '');
        $languageService = $GLOBALS['LANG'] ?? null;
        $translatedFieldLabel = $fieldLabel;
        if (is_object($languageService) && method_exists($languageService, 'sL')) {
            $resolvedFieldLabel = $languageService->sL($fieldLabel);
            $translatedFieldLabel = $resolvedFieldLabel !== '' ? $resolvedFieldLabel : $fieldLabel;
        }

        $extendedAnimationSettings = (bool)(
            GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('content_gsap_animation')['extendedAnimationSettings'] ?? false
        );

        $html = [];
        $html[] = '<div class="pc-animation-editor-layout">';
        $html[] = '<div class="pc-animation-preview-column">';
        $html = array_merge($html, $this->renderAnimationPreviewHtml());
        $html[] = '</div>';
        $html[] = '<div class="pc-animation-fields-column">';
        $html[] = '<div class="formengine-field-item t3js-formengine-field-item">';
        $html[] = $fieldInformationHtml;
        if ($translatedFieldLabel !== '') {
            $html[] = '<label class="form-label t3js-formengine-label pc-animation-select-label" for="' . htmlspecialchars($selectId, ENT_COMPAT, 'UTF-8', false) . '">';
            $html[] = htmlspecialchars($translatedFieldLabel, ENT_COMPAT, 'UTF-8', false);
            $html[] = '</label>';
        }
        $html[] = '<div class="form-control-wrap">';
        $html[] = '<div class="form-wizards-wrap">';
        $html[] = '<div class="form-wizards-element">';
        if ($hasIcons) {
            $html[] = '<div class="input-group pc-animation-select">';
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
        $html[] = $this->renderNumberControl(
            'Timing settings',
            'Duration in milliseconds',
            $this->buildSiblingFieldName($parameterArray['itemFormElName'], 'tx_content_gsap_animation_duration'),
            $this->getDatabaseRowValue('tx_content_gsap_animation_duration', '800'),
            400,
            3000,
            50,
            'tx_content_gsap_animation_duration',
            $disabled
        );
        $html[] = $this->renderNumberControl(
            '',
            'Delay in milliseconds',
            $this->buildSiblingFieldName($parameterArray['itemFormElName'], 'tx_content_gsap_animation_delay'),
            $this->getDatabaseRowValue('tx_content_gsap_animation_delay', '0'),
            0,
            3000,
            50,
            'tx_content_gsap_animation_delay',
            $disabled
        );
        if ($extendedAnimationSettings) {
            $html[] = '<div class="pc-animation-settings-section">';
            $html[] = '<h4>Extended animation settings</h4>';
            $html[] = '<div class="pc-animation-toggle-grid">';
            $html[] = $this->renderCheckboxControl(
                'Play animation once',
                'Whether animation should happen only once - while scrolling down',
                $this->buildSiblingFieldName($parameterArray['itemFormElName'], 'tx_content_gsap_animation_once'),
                $this->getDatabaseRowValue('tx_content_gsap_animation_once', '1'),
                $disabled
            );
            $html[] = $this->renderCheckboxControl(
                'Mirror',
                'Animations animate out while scrolling past them',
                $this->buildSiblingFieldName($parameterArray['itemFormElName'], 'tx_content_gsap_animation_mirror'),
                $this->getDatabaseRowValue('tx_content_gsap_animation_mirror', '0'),
                $disabled
            );
            $html[] = '</div>';
            $html[] = $this->renderSelectControl('Easing', $this->buildSiblingFieldName($parameterArray['itemFormElName'], 'tx_content_gsap_animation_easing'), $this->getDatabaseRowValue('tx_content_gsap_animation_easing', ''), [
                '' => '',
                'linear' => 'linear',
                'power1.out' => 'power1.out',
                'power2.out' => 'power2.out',
                'power3.out' => 'power3.out',
                'power4.out' => 'power4.out',
                'back.out' => 'back.out',
                'bounce.out' => 'bounce.out',
                'circ.out' => 'circ.out',
                'expo.out' => 'expo.out',
                'sine.out' => 'sine.out',
            ], $disabled);
            $html[] = $this->renderSelectControl('Anchor placement', $this->buildSiblingFieldName($parameterArray['itemFormElName'], 'tx_content_gsap_animation_anchor_placement'), $this->getDatabaseRowValue('tx_content_gsap_animation_anchor_placement', ''), [
                '' => '',
                'top-bottom' => 'top-bottom',
                'top-center' => 'top-center',
                'top-top' => 'top-top',
                'center-bottom' => 'center-bottom',
                'center-center' => 'center-center',
                'center-top' => 'center-top',
                'bottom-bottom' => 'bottom-bottom',
                'bottom-center' => 'bottom-center',
                'bottom-top' => 'bottom-top',
            ], $disabled);
            $html[] = $this->renderNumberControl(
                '',
                'Offset in pixels',
                $this->buildSiblingFieldName($parameterArray['itemFormElName'], 'tx_content_gsap_animation_offset'),
                $this->getDatabaseRowValue('tx_content_gsap_animation_offset', '0'),
                -1000,
                1000,
                10,
                'tx_content_gsap_animation_offset',
                $disabled
            );
            $html[] = '</div>';
        }
        $html[] = '</div>';
        $html[] = '</div>';

        $result = [
            'html' => implode(LF, $html),
            'additionalInlineLanguageLabelFiles' => [],
            'stylesheetFiles' => [
                'EXT:content_gsap_animation/Resources/Public/Styles/animation-preview.min.css',
            ],
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
            '|',
            false,
            '',
            true
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
            '|',
            false,
            '',
            true
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
            '|',
            false,
            '',
            true
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

        $validationRulesJson = json_encode($validationRules);
        return is_string($validationRulesJson) ? $validationRulesJson : '[]';
    }

    /**
     * @return list<string>
     */
    private function renderAnimationPreviewHtml(): array
    {
        $previewLabel = LocalizationUtility::translate('LLL:EXT:content_gsap_animation/Resources/Private/Language/locallang_be.xlf:preview-label');
        $gsapLogoWebPath = $this->getAssetWebPath('EXT:content_gsap_animation/Resources/Public/Images/gsap-greensock.svg');
        $animationPreviewImages = [
            'fade-up' => 'Fade up',
            'slide-left' => 'Slide left',
            'zoom-in' => 'Zoom in',
            'flip-up' => 'Flip up',
        ];

        $html = [];
        $html[] = '<div id="preview-content-animation" role="group" aria-label="' . htmlspecialchars((string)($previewLabel ?? ''), ENT_COMPAT, 'UTF-8', false) . '">';
        $html[] = '<div class="preview-topline">';
        $html[] = '<span class="preview-label" data-show-preview="false">' . htmlspecialchars((string)($previewLabel ?? ''), ENT_COMPAT, 'UTF-8', false) . '</span>';
        $html[] = '<span class="preview-brand" aria-label="GreenSock GSAP">';
        $html[] = '<img src="' . htmlspecialchars($gsapLogoWebPath, ENT_COMPAT, 'UTF-8', false) . '" alt="" width="22" height="22" aria-hidden="true" loading="lazy" decoding="async" />';
        $html[] = '<span>GSAP</span>';
        $html[] = '</span>';
        $html[] = '</div>';
        $html[] = '<div class="preview-shell">';
        $html[] = '<div class="preview-stage">';
        $html[] = '<div class="preview-stage__rail" aria-hidden="true"></div>';
        $html[] = '<div class="ce-preview" aria-hidden="true">';
        $html[] = '<div class="ce-preview__media">';
        $html[] = '<span class="ce-preview__spark ce-preview__spark--one"></span>';
        $html[] = '<span class="ce-preview__spark ce-preview__spark--two"></span>';
        $html[] = '</div>';
        $html[] = '<div class="ce-preview__content">';
        $html[] = '<div class="ce-preview__eyebrow"></div>';
        $html[] = '<div class="ce-preview__text-line"></div>';
        $html[] = '<div class="ce-preview__text-line ce-preview__text-line--short"></div>';
        $html[] = '</div>';
        $html[] = '</div>';
        $html[] = '</div>';
        $html[] = '<div class="preview-copy" aria-hidden="true">';
        $html[] = '<span class="preview-kicker">ScrollTrigger</span>';
        $html[] = '<span class="preview-title">Animation preview</span>';
        $html[] = '<span class="preview-description">Live GSAP preview with reduced-motion support.</span>';
        $html[] = '<span class="preview-headless-note">Headless data: automatic</span>';
        $html[] = '<div class="preview-meta" aria-hidden="true">';
        $html[] = '<span>GSAP</span>';
        $html[] = '<span>Reduced motion</span>';
        $html[] = '<span>Headless automatic</span>';
        $html[] = '</div>';
        $html[] = '<div class="preview-gallery" aria-label="Animation GIF examples">';
        foreach ($animationPreviewImages as $animationKey => $animationLabel) {
            $animationPreviewWebPath = $this->getAssetWebPath(
                'EXT:content_gsap_animation/Resources/Public/Images/' . $animationKey . '.gif'
            );
            $html[] = '<figure class="preview-gallery__item">';
            $html[] = '<img src="' . htmlspecialchars($animationPreviewWebPath, ENT_COMPAT, 'UTF-8', false) . '" alt="' . htmlspecialchars($animationLabel, ENT_COMPAT, 'UTF-8', false) . ' animation preview" width="120" height="28" loading="lazy" decoding="async" />';
            $html[] = '<figcaption>' . htmlspecialchars($animationLabel, ENT_COMPAT, 'UTF-8', false) . '</figcaption>';
            $html[] = '</figure>';
        }
        $html[] = '</div>';
        $html[] = '</div>';
        $html[] = '</div>';
        $html[] = '</div>';

        return $html;
    }

    private function getAssetWebPath(string $assetPath): string
    {
        if (!isset(self::$assetWebPathCache[$assetPath])) {
            self::$assetWebPathCache[$assetPath] = PathUtility::getAbsoluteWebPath(
                GeneralUtility::getFileAbsFileName($assetPath)
            );
        }

        return self::$assetWebPathCache[$assetPath];
    }

    private function buildSiblingFieldName(string $currentFieldName, string $targetFieldName): string
    {
        $fieldName = preg_replace(
            '/\[tx_content_gsap_animation_animation\](\[\])?$/',
            '[' . $targetFieldName . ']',
            $currentFieldName
        );

        return is_string($fieldName) ? $fieldName : $currentFieldName;
    }

    private function getDatabaseRowValue(string $fieldName, string $default): string
    {
        $databaseRow = $this->data['databaseRow'] ?? [];
        $value = is_array($databaseRow) ? ($databaseRow[$fieldName] ?? $default) : $default;
        if (is_array($value)) {
            $firstValue = reset($value);
            $value = $firstValue !== false ? $firstValue : $default;
        }

        return (string)$value;
    }

    private function renderNumberControl(
        string $headline,
        string $label,
        string $name,
        string $value,
        int $min,
        int $max,
        int $step,
        string $fieldName,
        bool $disabled
    ): string {
        $disabledAttribute = $disabled ? ' disabled="disabled"' : '';
        $html = [];
        $html[] = '<div class="pc-animation-settings-section">';
        if ($headline !== '') {
            $html[] = '<h4>' . htmlspecialchars($headline, ENT_COMPAT, 'UTF-8', false) . '</h4>';
        }
        $html[] = '<label class="form-label" for="' . htmlspecialchars($fieldName, ENT_COMPAT, 'UTF-8', false) . '">' . htmlspecialchars($label, ENT_COMPAT, 'UTF-8', false) . '</label>';
        $html[] = '<div class="pc-animation-range-control">';
        $html[] = '<input id="' . htmlspecialchars($fieldName, ENT_COMPAT, 'UTF-8', false) . '" class="form-control" type="number" name="' . htmlspecialchars($name, ENT_COMPAT, 'UTF-8', false) . '" value="' . htmlspecialchars($value, ENT_COMPAT, 'UTF-8', false) . '" min="' . $min . '" max="' . $max . '" step="' . $step . '" data-pc-animation-number="' . htmlspecialchars($fieldName, ENT_COMPAT, 'UTF-8', false) . '"' . $disabledAttribute . ' />';
        $html[] = '<input class="form-range" type="range" value="' . htmlspecialchars($value, ENT_COMPAT, 'UTF-8', false) . '" min="' . $min . '" max="' . $max . '" step="' . $step . '" aria-label="' . htmlspecialchars($label, ENT_COMPAT, 'UTF-8', false) . '" data-pc-animation-range="' . htmlspecialchars($fieldName, ENT_COMPAT, 'UTF-8', false) . '"' . $disabledAttribute . ' />';
        $html[] = '</div>';
        $html[] = '</div>';

        return implode(LF, $html);
    }

    /**
     * @param array<string, string> $options
     */
    private function renderSelectControl(string $label, string $name, string $value, array $options, bool $disabled): string
    {
        $disabledAttribute = $disabled ? ' disabled="disabled"' : '';
        $fieldId = StringUtility::getUniqueId('pc-animation-select-');
        $html = [];
        $html[] = '<div class="pc-animation-settings-field">';
        $html[] = '<label class="form-label" for="' . htmlspecialchars($fieldId, ENT_COMPAT, 'UTF-8', false) . '">' . htmlspecialchars($label, ENT_COMPAT, 'UTF-8', false) . '</label>';
        $html[] = '<select id="' . htmlspecialchars($fieldId, ENT_COMPAT, 'UTF-8', false) . '" class="form-control form-control-adapt" name="' . htmlspecialchars($name, ENT_COMPAT, 'UTF-8', false) . '"' . $disabledAttribute . '>';
        foreach ($options as $optionValue => $optionLabel) {
            $html[] = '<option value="' . htmlspecialchars($optionValue, ENT_COMPAT, 'UTF-8', false) . '"' . ($value === $optionValue ? ' selected="selected"' : '') . '>' . htmlspecialchars($optionLabel, ENT_COMPAT, 'UTF-8', false) . '</option>';
        }
        $html[] = '</select>';
        $html[] = '</div>';

        return implode(LF, $html);
    }

    private function renderCheckboxControl(string $label, string $description, string $name, string $value, bool $disabled): string
    {
        $disabledAttribute = $disabled ? ' disabled="disabled"' : '';
        $checkedAttribute = $value === '1' ? ' checked="checked"' : '';

        return '<label class="pc-animation-toggle">'
            . '<input type="hidden" name="' . htmlspecialchars($name, ENT_COMPAT, 'UTF-8', false) . '" value="0" />'
            . '<input type="checkbox" name="' . htmlspecialchars($name, ENT_COMPAT, 'UTF-8', false) . '" value="1"' . $checkedAttribute . $disabledAttribute . ' />'
            . '<span><strong>' . htmlspecialchars($label, ENT_COMPAT, 'UTF-8', false) . '</strong><small>' . htmlspecialchars($description, ENT_COMPAT, 'UTF-8', false) . '</small></span>'
            . '</label>';
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

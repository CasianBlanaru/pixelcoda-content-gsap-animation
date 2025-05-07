<?php

declare(strict_types=1);

namespace Pixelcoda\ContentGsapAnimation\DataProcessing;

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * This file is part of the "content_gsap_animation" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2025 Casian Blanaru <casianus@me.com>
 *
 * DataProcessor to generate GSAP animation settings
 */

class AnimationSettingsProcessor implements DataProcessorInterface
{
    private const GSAP_ATTRIBUTE_MAP = [
        'animation' => 'data-gsap-anim',
        'duration' => 'data-gsap-duration',
        'delay' => 'data-gsap-delay',
        'easing' => 'data-gsap-easing',
    ];
    private const DATA_COLUMN_PREFIX = 'tx_content_gsap_animation_';

    /**
     * @var array<string>
     */
    protected array $availableAosSettings = [
        'animation',
        'duration',
        'easing',
        'once',
        'mirror',
        'offset',
        'delay',
        'anchor-placement',
    ];

    /**
     * @var array<string>
     */
    protected array $fallbackAosSettings = [
        'easing',
        'once',
        'mirror',
    ];

    /**
     * @var array<string>
     */
    protected array $aosBooleanSettings = [
        'disable',
        'useClassNames',
        'disableMutationObserver',
        'aos-once',
        'aos-mirror',
    ];

    /**
     * Process data for content animations
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        $dataObj = $processedData['data'] ?? [];
        $gsapSettingsArray = $this->mapFieldsToGsapAttributes($dataObj);
        $completeGsapSettings = $this->generateGsapAttributeString($gsapSettingsArray);
        $this->setSettingsToProcessedData($cObj, $processorConfiguration, $processedData, $completeGsapSettings);
        return $processedData;
    }

    private function mapFieldsToGsapAttributes(array $dataObj): array
    {
        $gsapOptions = [];
        foreach (self::GSAP_ATTRIBUTE_MAP as $field => $attr) {
            $value = $dataObj[self::DATA_COLUMN_PREFIX . $field] ?? '';
            if ($value !== null && $value !== '') {
                $gsapOptions[$attr] = (string)$value;
            }
        }
        return $gsapOptions;
    }

    private function generateGsapAttributeString(array $gsapSettingsArray): string
    {
        $gsapSettings = '';
        foreach ($gsapSettingsArray as $key => $value) {
            $gsapSettings .= ' ' . $key . '="' . htmlspecialchars($value, ENT_QUOTES) . '"';
        }
        return $gsapSettings;
    }

    /**
     * @param array<string, mixed> $processorConfiguration
     * @param array<string, mixed> $processedData
     */
    private function setSettingsToProcessedData(
        ContentObjectRenderer $cObj,
        array $processorConfiguration,
        array &$processedData,
        string $completeGsapSettings
    ): void {
        $variableName = $cObj->stdWrapValue('as', $processorConfiguration);
        if (is_string($variableName) && $variableName !== '') {
            $processedData[$variableName] = $completeGsapSettings;
        } else {
            $processedData['gsapAnimationSettings'] = $completeGsapSettings;
        }
    }
}

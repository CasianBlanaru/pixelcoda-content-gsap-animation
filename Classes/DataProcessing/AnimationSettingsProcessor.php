<?php

declare(strict_types=1);

namespace Pixelcoda\ContentGsapAnimation\DataProcessing;

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
        'offset' => 'data-gsap-offset',
        'anchor_placement' => 'data-gsap-anchor-placement',
    ];
    private const GSAP_BOOLEAN_ATTRIBUTE_MAP = [
        'once' => 'data-gsap-once',
        'mirror' => 'data-gsap-mirror',
    ];
    private const DATA_COLUMN_PREFIX = 'tx_content_gsap_animation_';
    private const INTEGER_FIELDS = ['duration', 'delay', 'offset'];
    private const TRUE_VALUES = [1, '1', true, 'true'];

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
        [$gsapSettingsArray, $structuredGsapSettings] = $this->buildAnimationSettings(is_array($dataObj) ? $dataObj : []);
        $completeGsapSettings = $this->generateGsapAttributeString($gsapSettingsArray);
        $this->setSettingsToProcessedData(
            $cObj,
            $processorConfiguration,
            $processedData,
            $completeGsapSettings,
            $structuredGsapSettings
        );
        return $processedData;
    }

    /**
     * @param array<string, mixed> $dataObj
     * @return array{array<string, string>, array<string, bool|int|string>}
     */
    private function buildAnimationSettings(array $dataObj): array
    {
        if ((string)($dataObj[self::DATA_COLUMN_PREFIX . 'animation'] ?? '') === '') {
            return [[], []];
        }

        $gsapOptions = [];
        $structuredSettings = [];
        foreach (self::GSAP_ATTRIBUTE_MAP as $field => $attr) {
            $value = $dataObj[self::DATA_COLUMN_PREFIX . $field] ?? '';
            if ($value !== '') {
                $gsapOptions[$attr] = (string)$value;
                $structuredSettings[$this->normalizeSettingKey($field)] = $this->normalizeSettingValue($field, $value);
            }
        }
        foreach (self::GSAP_BOOLEAN_ATTRIBUTE_MAP as $field => $attr) {
            if (array_key_exists(self::DATA_COLUMN_PREFIX . $field, $dataObj)) {
                $value = $dataObj[self::DATA_COLUMN_PREFIX . $field];
                $isEnabled = in_array($value, self::TRUE_VALUES, true);
                $gsapOptions[$attr] = $isEnabled ? 'true' : 'false';
                $structuredSettings[$field] = $isEnabled;
            }
        }

        return [$gsapOptions, $structuredSettings];
    }

    private function normalizeSettingKey(string $field): string
    {
        return $field === 'anchor_placement' ? 'anchorPlacement' : $field;
    }

    private function normalizeSettingValue(string $field, mixed $value): int|string
    {
        if (in_array($field, self::INTEGER_FIELDS, true)) {
            return (int)$value;
        }

        return (string)$value;
    }

    private function generateGsapAttributeString(array $gsapSettingsArray): string
    {
        $gsapSettings = '';
        foreach ($gsapSettingsArray as $key => $value) {
            $gsapSettings .= ' ' . $key . '="' . htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '"';
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
        string $completeGsapSettings,
        array $structuredGsapSettings
    ): void {
        $variableName = $cObj->stdWrapValue('as', $processorConfiguration);
        if (is_string($variableName) && $variableName !== '') {
            $processedData[$variableName] = $completeGsapSettings;
            $processedData[$variableName . 'Data'] = $structuredGsapSettings;
        } else {
            $processedData['animationSettings'] = $completeGsapSettings;
            $processedData['gsapAnimationSettings'] = $completeGsapSettings;
            $processedData['animationSettingsData'] = $structuredGsapSettings;
            $processedData['gsapAnimationSettingsData'] = $structuredGsapSettings;
        }
    }
}

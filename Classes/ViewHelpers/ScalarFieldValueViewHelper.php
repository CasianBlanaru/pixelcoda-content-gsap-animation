<?php

declare(strict_types=1);

namespace Pixelcoda\ContentGsapAnimation\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

final class ScalarFieldValueViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('field', 'mixed', 'TYPO3 backend field value', true);
    }

    public function render(): string
    {
        return $this->extractScalarValue($this->arguments['field']);
    }

    private function extractScalarValue(mixed $field): string
    {
        if (is_scalar($field)) {
            return (string)$field;
        }

        if (!is_array($field)) {
            return '';
        }

        foreach (['value', 'raw', 'rendered', 'title', 'label'] as $key) {
            if (isset($field[$key]) && is_scalar($field[$key])) {
                return (string)$field[$key];
            }
        }

        foreach ($field as $value) {
            if (is_scalar($value)) {
                return (string)$value;
            }
        }

        return '';
    }
}

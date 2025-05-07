<?php

namespace Pixelcoda\ContentGsapAnimation\Tests\Unit\DataProcessing;

use PHPUnit\Framework\TestCase;
use Pixelcoda\ContentGsapAnimation\DataProcessing\AnimationSettingsProcessor;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class AnimationSettingsProcessorTest extends TestCase
{
    /**
     * @var AnimationSettingsProcessor
     */
    protected $subject;

    protected function setUp(): void
    {
        $this->subject = new AnimationSettingsProcessor();
    }

    /**
     * @test
     */
    public function processSetsGsapAnimationSettingsIfNoVariableNameIsGiven(): void
    {
        // Create mock for ContentObjectRenderer
        $contentObjectRenderer = $this->createMock(ContentObjectRenderer::class);
        $contentObjectRenderer->method('stdWrapValue')->willReturn('');

        // Set up test data
        $data = [
            'tx_content_gsap_animation_animation' => 'fade-up',
            'tx_content_gsap_animation_duration' => '800',
            'tx_content_gsap_animation_delay' => '0',
            'tx_content_gsap_animation_easing' => 'power2.out',
        ];

        $processedData = ['data' => $data];

        // Execute the method
        $result = $this->subject->process(
            $contentObjectRenderer,
            [],
            [],
            $processedData
        );

        // Assert that gsapAnimationSettings is set
        $this->assertArrayHasKey('gsapAnimationSettings', $result);
        $this->assertStringContainsString('data-gsap-anim="fade-up"', $result['gsapAnimationSettings']);
        $this->assertStringContainsString('data-gsap-duration="800"', $result['gsapAnimationSettings']);
        $this->assertStringContainsString('data-gsap-delay="0"', $result['gsapAnimationSettings']);
        $this->assertStringContainsString('data-gsap-easing="power2.out"', $result['gsapAnimationSettings']);
    }

    /**
     * @test
     */
    public function processSetsCustomVariableNameIfGiven(): void
    {
        // Create mock for ContentObjectRenderer
        $contentObjectRenderer = $this->createMock(ContentObjectRenderer::class);
        $contentObjectRenderer->method('stdWrapValue')->willReturn('customVar');

        // Set up test data
        $data = [
            'tx_content_gsap_animation_animation' => 'fade-up',
            'tx_content_gsap_animation_duration' => '800',
        ];

        $processedData = ['data' => $data];

        // Execute the method
        $result = $this->subject->process(
            $contentObjectRenderer,
            [],
            [],
            $processedData
        );

        // Assert that customVar is set
        $this->assertArrayHasKey('customVar', $result);
        $this->assertStringContainsString('data-gsap-anim="fade-up"', $result['customVar']);
        $this->assertStringContainsString('data-gsap-duration="800"', $result['customVar']);
    }

    /**
     * @test
     */
    public function processHandlesEmptyData(): void
    {
        // Create mock for ContentObjectRenderer
        $contentObjectRenderer = $this->createMock(ContentObjectRenderer::class);
        $contentObjectRenderer->method('stdWrapValue')->willReturn('');

        $processedData = [];

        // Execute the method
        $result = $this->subject->process(
            $contentObjectRenderer,
            [],
            [],
            $processedData
        );

        // Assert that gsapAnimationSettings is set but empty
        $this->assertArrayHasKey('gsapAnimationSettings', $result);
        $this->assertEquals('', $result['gsapAnimationSettings']);
    }
}
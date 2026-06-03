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
    public function testProcessSetsGsapAnimationSettingsIfNoVariableNameIsGiven(): void
    {
        // Create mock for ContentObjectRenderer
        $contentObjectRenderer = $this->createStub(ContentObjectRenderer::class);
        $contentObjectRenderer->method('stdWrapValue')->willReturn('');

        // Set up test data
        $data = [
            'tx_content_gsap_animation_animation' => 'fade-up',
            'tx_content_gsap_animation_duration' => '800',
            'tx_content_gsap_animation_delay' => '0',
            'tx_content_gsap_animation_easing' => 'power2.out',
            'tx_content_gsap_animation_offset' => '120',
            'tx_content_gsap_animation_anchor_placement' => 'top-center',
            'tx_content_gsap_animation_once' => '1',
            'tx_content_gsap_animation_mirror' => '0',
        ];

        $processedData = ['data' => $data];

        // Execute the method
        $result = $this->subject->process(
            $contentObjectRenderer,
            [],
            [],
            $processedData
        );

        // Assert that both the legacy and layout variable names are set.
        $this->assertArrayHasKey('animationSettings', $result);
        $this->assertArrayHasKey('gsapAnimationSettings', $result);
        $this->assertSame($result['animationSettings'], $result['gsapAnimationSettings']);
        $this->assertSame([
            'animation' => 'fade-up',
            'duration' => 800,
            'delay' => 0,
            'easing' => 'power2.out',
            'offset' => 120,
            'anchorPlacement' => 'top-center',
            'once' => true,
            'mirror' => false,
        ], $result['animationSettingsData']);
        $this->assertSame($result['animationSettingsData'], $result['gsapAnimationSettingsData']);
        $this->assertStringContainsString('data-gsap-anim="fade-up"', $result['gsapAnimationSettings']);
        $this->assertStringContainsString('data-gsap-duration="800"', $result['gsapAnimationSettings']);
        $this->assertStringContainsString('data-gsap-delay="0"', $result['gsapAnimationSettings']);
        $this->assertStringContainsString('data-gsap-easing="power2.out"', $result['gsapAnimationSettings']);
        $this->assertStringContainsString('data-gsap-offset="120"', $result['gsapAnimationSettings']);
        $this->assertStringContainsString('data-gsap-anchor-placement="top-center"', $result['gsapAnimationSettings']);
        $this->assertStringContainsString('data-gsap-once="true"', $result['gsapAnimationSettings']);
        $this->assertStringContainsString('data-gsap-mirror="false"', $result['gsapAnimationSettings']);
    }

    /**
     * @test
     */
    public function testProcessSetsCustomVariableNameIfGiven(): void
    {
        // Create mock for ContentObjectRenderer
        $contentObjectRenderer = $this->createStub(ContentObjectRenderer::class);
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
        $this->assertArrayHasKey('customVarData', $result);
        $this->assertStringContainsString('data-gsap-anim="fade-up"', $result['customVar']);
        $this->assertStringContainsString('data-gsap-duration="800"', $result['customVar']);
        $this->assertSame([
            'animation' => 'fade-up',
            'duration' => 800,
        ], $result['customVarData']);
    }

    /**
     * @test
     */
    public function testProcessHandlesEmptyData(): void
    {
        // Create mock for ContentObjectRenderer
        $contentObjectRenderer = $this->createStub(ContentObjectRenderer::class);
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
        $this->assertSame([], $result['animationSettingsData']);
    }

    /**
     * @test
     */
    public function testProcessSkipsTimingAttributesWithoutSelectedAnimation(): void
    {
        $contentObjectRenderer = $this->createStub(ContentObjectRenderer::class);
        $contentObjectRenderer->method('stdWrapValue')->willReturn('');

        $processedData = [
            'data' => [
                'tx_content_gsap_animation_animation' => '',
                'tx_content_gsap_animation_duration' => '800',
                'tx_content_gsap_animation_delay' => '0',
            ],
        ];

        $result = $this->subject->process(
            $contentObjectRenderer,
            [],
            [],
            $processedData
        );

        $this->assertSame('', $result['gsapAnimationSettings']);
        $this->assertSame('', $result['animationSettings']);
        $this->assertSame([], $result['gsapAnimationSettingsData']);
    }
}

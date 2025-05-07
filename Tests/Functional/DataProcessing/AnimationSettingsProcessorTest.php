<?php

namespace Pixelcoda\ContentGsapAnimation\Tests\Functional\DataProcessing;

use Pixelcoda\ContentGsapAnimation\DataProcessing\AnimationSettingsProcessor;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class AnimationSettingsProcessorTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'typo3conf/ext/content_gsap_animation',
    ];

    /**
     * @var AnimationSettingsProcessor
     */
    protected $subject;

    /**
     * @var ContentObjectRenderer
     */
    protected $contentObjectRenderer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new AnimationSettingsProcessor();
        $this->contentObjectRenderer = new ContentObjectRenderer();
    }

    /**
     * @test
     */
    public function processorGeneratesCorrectDataAttributes(): void
    {
        $data = [
            'tx_content_animations_animation' => 'fade-up',
            'tx_content_animations_duration' => '800',
            'tx_content_animations_delay' => '0',
            'tx_content_animations_easing' => 'power2.out',
        ];

        $processedData = ['data' => $data];

        $result = $this->subject->process(
            $this->contentObjectRenderer,
            [],
            [],
            $processedData
        );

        $this->assertArrayHasKey('gsapAnimationSettings', $result);
        $this->assertStringContainsString('data-gsap-anim="fade-up"', $result['gsapAnimationSettings']);
        $this->assertStringContainsString('data-gsap-duration="800"', $result['gsapAnimationSettings']);
        $this->assertStringContainsString('data-gsap-delay="0"', $result['gsapAnimationSettings']);
        $this->assertStringContainsString('data-gsap-easing="power2.out"', $result['gsapAnimationSettings']);
    }

    /**
     * @test
     */
    public function processorHandlesPartialDataAttributes(): void
    {
        $data = [
            'tx_content_animations_animation' => 'fade-up',
            // duration and delay intentionally left out
            'tx_content_animations_easing' => 'power2.out',
        ];

        $processedData = ['data' => $data];

        $result = $this->subject->process(
            $this->contentObjectRenderer,
            [],
            [],
            $processedData
        );

        $this->assertArrayHasKey('gsapAnimationSettings', $result);
        $this->assertStringContainsString('data-gsap-anim="fade-up"', $result['gsapAnimationSettings']);
        $this->assertStringContainsString('data-gsap-easing="power2.out"', $result['gsapAnimationSettings']);
        $this->assertStringNotContainsString('data-gsap-duration', $result['gsapAnimationSettings']);
        $this->assertStringNotContainsString('data-gsap-delay', $result['gsapAnimationSettings']);
    }

    /**
     * @test
     */
    public function processorSetsCustomVariableNameIfConfigured(): void
    {
        $data = [
            'tx_content_animations_animation' => 'fade-up',
        ];

        $processedData = ['data' => $data];
        $processorConfiguration = ['as' => 'customVariable'];

        $result = $this->subject->process(
            $this->contentObjectRenderer,
            [],
            $processorConfiguration,
            $processedData
        );

        $this->assertArrayHasKey('customVariable', $result);
        $this->assertStringContainsString('data-gsap-anim="fade-up"', $result['customVariable']);
    }

    /**
     * @test
     */
    public function processorEscapesHtmlSpecialChars(): void
    {
        $data = [
            'tx_content_animations_animation' => 'fade-up',
            'tx_content_animations_easing' => 'power2.out"><script>alert("XSS")</script>',
        ];

        $processedData = ['data' => $data];

        $result = $this->subject->process(
            $this->contentObjectRenderer,
            [],
            [],
            $processedData
        );

        $this->assertArrayHasKey('gsapAnimationSettings', $result);
        $this->assertStringContainsString('data-gsap-easing="power2.out&quot;&gt;&lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;"', $result['gsapAnimationSettings']);
        $this->assertStringNotContainsString('<script>', $result['gsapAnimationSettings']);
    }
}

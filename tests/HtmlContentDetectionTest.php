<?php

declare(strict_types=1);

namespace ui\controls\tests;

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use ui\controls\web\{HtmlDiv, HtmlSpan, HtmlH1, HtmlH2, HtmlH3, HtmlP};

/**
 * Tests for the new smart HTML content detection and rendering system
 */
class HtmlContentDetectionTest extends TestCase
{
    public function testAutoDetectHtmlContent(): void
    {
        $div = new HtmlDiv('<h3>Auto-detected Heading</h3>', 'test-id', 'test-class');
        $html = $div->toHtml();
        
        // Should contain the actual h3 tag, not escaped
        $this->assertStringContainsString('<h3>Auto-detected Heading</h3>', $html);
        $this->assertStringNotContainsString('&lt;h3&gt;', $html);
    }

    public function testAutoEscapePlainText(): void
    {
        $div = new HtmlDiv('Plain text with <script>alert("xss")</script>', 'test-id', 'test-class');
        $html = $div->toHtml();
        
        // Should escape dangerous script tags
        $this->assertStringContainsString('&lt;script&gt;', $html);
        $this->assertStringNotContainsString('<script>', $html);
    }

    public function testExplicitHtmlAllowed(): void
    {
        $div = new HtmlDiv('<strong>Bold Text</strong>', 'test-id', 'test-class', true);
        $html = $div->toHtml();
        
        // Should contain actual strong tag
        $this->assertStringContainsString('<strong>Bold Text</strong>', $html);
        $this->assertStringNotContainsString('&lt;strong&gt;', $html);
    }

    public function testExplicitHtmlDisabled(): void
    {
        $div = new HtmlDiv('<em>Italic Text</em>', 'test-id', 'test-class', false);
        $html = $div->toHtml();
        
        // Should escape the em tag
        $this->assertStringContainsString('&lt;em&gt;', $html);
        $this->assertStringNotContainsString('<em>', $html);
    }

    public function testDangerousHtmlSanitized(): void
    {
        $div = new HtmlDiv('<div onclick="alert(\'xss\')">Click me</div>', 'test-id', 'test-class');
        $html = $div->toHtml();
        
        // Should escape dangerous onclick attribute
        $this->assertStringContainsString('onclick', $html);
        $this->assertStringContainsString('&', $html); // Should be escaped
    }

    public function testSafeHtmlTagsAllowed(): void
    {
        $testCases = [
            '<h1>Heading 1</h1>',
            '<h2>Heading 2</h2>',
            '<h3>Heading 3</h3>',
            '<p>Paragraph</p>',
            '<strong>Bold</strong>',
            '<em>Italic</em>',
            '<span>Span</span>'
        ];

        foreach ($testCases as $htmlContent) {
            $div = new HtmlDiv($htmlContent, '', 'test-class');
            $html = $div->toHtml();
            
            $this->assertStringContainsString($htmlContent, $html, 
                "Safe HTML '$htmlContent' should be rendered as-is");
        }
    }

    public function testNestedHtmlSafety(): void
    {
        $div = new HtmlDiv('<p>Safe paragraph with <script>dangerous script</script></p>', 'test-id', 'test-class');
        $html = $div->toHtml();
        
        // Complex nested content should be escaped for safety
        $this->assertStringContainsString('&lt;', $html);
    }

    public function testHeadingControlsWork(): void
    {
        $h1 = new HtmlH1('Main Title', 'main-title', 'title-class');
        $h2 = new HtmlH2('Subtitle', 'subtitle', 'subtitle-class');
        $h3 = new HtmlH3('Section Title', 'section', 'section-class');
        
        $this->assertStringContainsString('<h1', $h1->toHtml());
        $this->assertStringContainsString('Main Title', $h1->toHtml());
        
        $this->assertStringContainsString('<h2', $h2->toHtml());
        $this->assertStringContainsString('Subtitle', $h2->toHtml());
        
        $this->assertStringContainsString('<h3', $h3->toHtml());
        $this->assertStringContainsString('Section Title', $h3->toHtml());
    }

    public function testParagraphControl(): void
    {
        $p = new HtmlP('This is a paragraph with <strong>bold text</strong>.', 'para-id', 'para-class');
        $html = $p->toHtml();
        
        $this->assertStringContainsString('<p', $html);
        $this->assertStringContainsString('<strong>bold text</strong>', $html);
        $this->assertStringContainsString('id="para-id"', $html);
        $this->assertStringContainsString('class="para-class"', $html);
    }

    public function testJsonSerialization(): void
    {
        $div = new HtmlDiv('<h3>JSON Test</h3>', 'json-test', 'json-class');
        $json = $div->toJson();
        $decoded = json_decode($json, true);
        
        $this->assertIsArray($decoded);
        $this->assertEquals('div', $decoded['element']);
        $this->assertEquals('<h3>JSON Test</h3>', $decoded['content']);
        $this->assertEquals('json-test', $decoded['id']);
        $this->assertEquals('json-class', $decoded['cssClass']);
    }
}
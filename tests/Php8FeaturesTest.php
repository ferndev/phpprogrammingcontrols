<?php

declare(strict_types=1);

namespace ui\controls\tests;

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use ui\controls\web\{HtmlDiv, HtmlSpan, HtmlButton, HtmlInput};
use ui\controls\HtmlCtrl;

/**
 * Tests for PHP 8.0+ features and type safety
 */
class Php8FeaturesTest extends TestCase
{
    public function testStrictTypesEnforced(): void
    {
        // Test that strict types are working - this should not throw errors
        $div = new HtmlDiv('test content', 'test-id', 'test-class');
        $this->assertIsString($div->toHtml());
    }

    public function testFluentInterface(): void
    {
        $div = new HtmlDiv('', 'container', 'main-container');
        $result = $div->addElement(new HtmlSpan('Content'))
                     ->addElement(new HtmlButton('Click', '', 'Button'));
        
        // Fluent interface should return the same object
        $this->assertSame($div, $result);
        
        $html = $div->toHtml();
        $this->assertStringContainsString('Content', $html);
        $this->assertStringContainsString('Click', $html);
    }

    public function testJsonSerializable(): void
    {
        $div = new HtmlDiv('JSON Test Content', 'json-id', 'json-class');
        
        // Test that the control implements JsonSerializable
        $this->assertInstanceOf(\JsonSerializable::class, $div);
        
        // Test JSON encoding
        $json = json_encode($div);
        $this->assertIsString($json);
        
        $decoded = json_decode($json, true);
        $this->assertIsArray($decoded);
        $this->assertEquals('div', $decoded['element']);
        $this->assertEquals('JSON Test Content', $decoded['content']);
    }

    public function testMatchExpressionInToHtml(): void
    {
        // Test that match expressions work in the toHtml method
        $ctrl = new HtmlCtrl('span', null, 'test', true);
        $ctrl->addFlag(1);
        
        $html1 = $ctrl->toHtml();
        $html2 = $ctrl->toHtml(2);
        
        $this->assertIsString($html1);
        $this->assertIsString($html2);
        $this->assertStringContainsString('<span', $html1);
        $this->assertStringContainsString('<span', $html2);
    }

    public function testNullableTypeHandling(): void
    {
        // Test nullable type parameters work correctly
        $input = new HtmlInput('text', null, 'test-value');
        $html = $input->toHtml();
        
        $this->assertStringContainsString('type="text"', $html);
        $this->assertStringContainsString('value="test-value"', $html);
    }

    public function testMixedTypeParameters(): void
    {
        $div = new HtmlDiv('test content');
        
        // Test that toHtml accepts mixed parameters
        $html1 = $div->toHtml(null);
        $html2 = $div->toHtml(1);
        $html3 = $div->toHtml(true);
        $html4 = $div->toHtml('string');
        
        $this->assertIsString($html1);
        $this->assertIsString($html2);
        $this->assertIsString($html3);
        $this->assertIsString($html4);
    }

    public function testStaticReturnTypes(): void
    {
        $div = new HtmlDiv();
        $span = new HtmlSpan();
        
        // Test that fluent methods return static (the actual class instance)
        $result1 = $div->addElement($span);
        $this->assertInstanceOf(HtmlDiv::class, $result1);
        
        $result2 = $div->addProperty('data-test', 'value');
        $this->assertInstanceOf(HtmlDiv::class, $result2);
    }

    public function testTypeDeclarations(): void
    {
        // Test that all parameters have proper type declarations
        $reflection = new \ReflectionClass(HtmlDiv::class);
        $constructor = $reflection->getConstructor();
        
        $this->assertNotNull($constructor);
        
        $parameters = $constructor->getParameters();
        $this->assertGreaterThan(0, count($parameters));
        
        // All parameters should have type declarations
        foreach ($parameters as $param) {
            $this->assertTrue($param->hasType(), "Parameter {$param->getName()} should have a type declaration");
        }
    }

    public function testExceptionHandling(): void
    {
        // Test that InvalidArgumentException is properly thrown for invalid inputs
        $this->expectException(\InvalidArgumentException::class);
        
        $div = new HtmlDiv();
        // This should throw an exception if we try to set an invalid property
        $div->addProperty('', 'value'); // Empty property name should be invalid
    }

    public function testArraySyntax(): void
    {
        // Test that modern array syntax [] is used internally
        $div = new HtmlDiv();
        $div->addElement(new HtmlSpan('Item 1'))
            ->addElement(new HtmlSpan('Item 2'))
            ->addElement(new HtmlSpan('Item 3'));
        
        $elements = $div->getElements();
        $this->assertIsArray($elements);
        $this->assertCount(3, $elements);
    }

    public function testStringInterpolation(): void
    {
        // Test that string interpolation works correctly
        $testId = 'dynamic-id';
        $testClass = 'dynamic-class';
        
        $div = new HtmlDiv('Content', $testId, $testClass);
        $html = $div->toHtml();
        
        $this->assertStringContainsString("id=\"{$testId}\"", $html);
        $this->assertStringContainsString("class=\"{$testClass}\"", $html);
    }
}
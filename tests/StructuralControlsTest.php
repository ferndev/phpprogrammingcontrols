<?php

declare(strict_types=1);

namespace ui\controls\tests;

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use ui\controls\web\{
    HtmlTable, HtmlTr, HtmlTd, HtmlTh, HtmlUl, HtmlOl, HtmlLi, 
    HtmlDiv, HtmlSpan, HtmlPanel
};

/**
 * Tests for structural HTML controls (tables, lists, containers)
 */
class StructuralControlsTest extends TestCase
{
    public function testHtmlTable(): void
    {
        $table = new HtmlTable('100%', '', 'data-table', 'table table-striped');
        $html = $table->toHtml();
        
        $this->assertStringContainsString('<table', $html);
        $this->assertStringContainsString('width="100%"', $html);
        $this->assertStringContainsString('id="data-table"', $html);
        $this->assertStringContainsString('class="table table-striped"', $html);
        $this->assertStringContainsString('</table>', $html);
    }

    public function testTableWithRows(): void
    {
        $table = new HtmlTable('100%', '', 'test-table', 'table');
        
        // Add header row
        $headerRow = new HtmlTr(true);
        $headerRow->addElement(new HtmlTh())->addElement(new HtmlSpan('Name'));
        $headerRow->addElement(new HtmlTh())->addElement(new HtmlSpan('Email'));
        $table->addElement($headerRow);
        
        // Add data row
        $dataRow = new HtmlTr();
        $dataRow->addElement(new HtmlTd())->addElement(new HtmlSpan('John Doe'));
        $dataRow->addElement(new HtmlTd())->addElement(new HtmlSpan('john@example.com'));
        $table->addElement($dataRow);
        
        $html = $table->toHtml();
        
        $this->assertStringContainsString('<table', $html);
        $this->assertStringContainsString('<tr', $html);
        $this->assertStringContainsString('<th', $html);
        $this->assertStringContainsString('<td', $html);
        $this->assertStringContainsString('Name', $html);
        $this->assertStringContainsString('John Doe', $html);
    }

    public function testHtmlUl(): void
    {
        $ul = new HtmlUl('list-id', 'list-unstyled');
        $ul->addElement(new HtmlLi('First item'))
           ->addElement(new HtmlLi('Second item'))
           ->addElement(new HtmlLi('Third item'));
        
        $html = $ul->toHtml();
        
        $this->assertStringContainsString('<ul', $html);
        $this->assertStringContainsString('id="list-id"', $html);
        $this->assertStringContainsString('<li', $html);
        $this->assertStringContainsString('First item', $html);
        $this->assertStringContainsString('Second item', $html);
        $this->assertStringContainsString('Third item', $html);
        $this->assertStringContainsString('</ul>', $html);
    }

    public function testHtmlOl(): void
    {
        $ol = new HtmlOl('ordered-list', 'numbered-list', '1');
        $ol->addElement(new HtmlLi('Step one'))
           ->addElement(new HtmlLi('Step two'))
           ->addElement(new HtmlLi('Step three'));
        
        $html = $ol->toHtml();
        
        $this->assertStringContainsString('<ol', $html);
        $this->assertStringContainsString('type="1"', $html);
        $this->assertStringContainsString('<li', $html);
        $this->assertStringContainsString('Step one', $html);
        $this->assertStringContainsString('</ol>', $html);
    }

    public function testHtmlPanel(): void
    {
        $panel = new HtmlPanel('Panel Title', 'Panel content goes here', 'panel-id', 'panel panel-default');
        $html = $panel->toHtml();
        
        $this->assertStringContainsString('<div', $html);
        $this->assertStringContainsString('Panel Title', $html);
        $this->assertStringContainsString('Panel content goes here', $html);
        $this->assertStringContainsString('panel-heading', $html);
        $this->assertStringContainsString('panel-body', $html);
    }

    public function testNestedContainers(): void
    {
        $outerDiv = new HtmlDiv('', 'outer-container', 'container');
        $innerDiv = new HtmlDiv('Inner content', 'inner-container', 'row');
        $outerDiv->addElement($innerDiv);
        
        $html = $outerDiv->toHtml();
        
        $this->assertStringContainsString('<div', $html);
        $this->assertStringContainsString('id="outer-container"', $html);
        $this->assertStringContainsString('id="inner-container"', $html);
        $this->assertStringContainsString('Inner content', $html);
    }

    public function testComplexStructure(): void
    {
        // Create a complex nested structure
        $container = new HtmlDiv('', 'main-container', 'container');
        
        $header = new HtmlDiv('<h2>Data Table</h2>', 'header', 'header');
        $container->addElement($header);
        
        $table = new HtmlTable('100%', '', 'data-table', 'table');
        $headerRow = new HtmlTr(true);
        $headerRow->addElement(new HtmlTh())->addElement(new HtmlSpan('ID'));
        $headerRow->addElement(new HtmlTh())->addElement(new HtmlSpan('Name'));
        $table->addElement($headerRow);
        
        $dataRow = new HtmlTr();
        $dataRow->addElement(new HtmlTd())->addElement(new HtmlSpan('1'));
        $dataRow->addElement(new HtmlTd())->addElement(new HtmlSpan('Test User'));
        $table->addElement($dataRow);
        
        $container->addElement($table);
        
        $html = $container->toHtml();
        
        // Verify the complex structure
        $this->assertStringContainsString('<h2>Data Table</h2>', $html);
        $this->assertStringContainsString('<table', $html);
        $this->assertStringContainsString('<th', $html);
        $this->assertStringContainsString('<td', $html);
        $this->assertStringContainsString('Test User', $html);
    }
}
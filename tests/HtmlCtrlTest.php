<?php

declare(strict_types=1);

/**
 *
 * MIT License
 *
 * Copyright 2025 Fernando M. (https://github.com/ferndev)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * HtmlCtrlTest.php
 * Description: PHPUnit tests for HtmlCtrl
 *
 */
namespace ui\controls;

require __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use ui\controls\web\HtmlInput;
use ui\controls\web\HtmlDiv;
use ui\controls\web\HtmlLabel;

class HtmlCtrlTest extends TestCase
{
    public function testToHtml(): void
    {
        $ctrl = new HtmlCtrl('br', null, '', false);
        $html = $ctrl->toHtml();
        echo('html:' . $html);
        $this->assertEquals('<br  />', $html);
        error_log('test completed');
    }

    public function testProperties(): void
    {
        $input = new HtmlInput('text', 'username', 'gandalf');
        $this->assertEquals('text', $input->getProperty('type'));
        $this->assertEquals('username', $input->getProperty('name'));
        $this->assertEquals('gandalf', $input->getProperty('value'));
    }

    public function testChildElements(): void
    {
        $div = new HtmlDiv();
        $div->addElement(new HtmlLabel('', 'age'))->addElement(new HtmlInput('text', 'age'));
        $children = $div->getElements();
        $this->assertCount(2, $children);
        $this->assertTrue($children[0]->getTagName() === 'label');
    }
}

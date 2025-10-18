<?php

declare(strict_types=1);

namespace ui\controls\web;

use ui\controls\HtmlCtrl;
use ui\controls\HtmlBase;

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
 * HtmlPage.php
 * Description: Represents an html page, ie, from <html> ... </html>.
 * it provides functionality to add elements to the page's head and body.
 * it makes use of other html controls, which must be provided (included) by the caller:
 * requires: HtmlCtrl, HtmlLink
 *
 */
class HtmlPage extends HtmlCtrl
{
    private HtmlCtrl $header;
    private HtmlCtrl $body;
    private array $footer = [];

    /**
     * creates an html page as in <html><head>...</head><body>...</body></html>
     * @param string $element
     * @param string $head
     * @param string $body
     */
    public function __construct(string $element = 'html', string $head = 'head', string $body = 'body')
    {
        parent::__construct($element, null, '', true, '', '');
        $this->header = new HtmlCtrl($head);
        $this->body = new HtmlCtrl($body);
        $this->addElement($this->header)->addElement($this->body);
    }

    public function addHeader(HtmlBase $element): void
    {
        $this->header->addElement($element);
    }

    public function addBody(HtmlBase $element): void
    {
        $this->body->addElement($element);
    }

    /**
     * @param HtmlBase $element element to add at the end of the body, just before the </body> tag
     */
    public function addFooter(HtmlBase $element): void
    {
        $this->footer[] = $element;
    }

    public function toHtml(mixed $flag = null): string
    {
        if (!empty($this->footer)) {
            foreach ($this->footer as $element) {
                $this->addBody($element);
            }
        }
        return parent::toHtml($flag);
    }
}
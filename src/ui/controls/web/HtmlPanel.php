<?php

declare(strict_types=1);

namespace ui\controls\web;

use ui\controls\HtmlCtrl;

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
 * HtmlPanel.php
 * Description: Represents an html panel, ie, a window with a title and a content section, similar to bootstrap's panel.
 *
 */
class HtmlPanel extends HtmlDiv
{
    private string $title;
    private string $content;
    private string $hdrClass;
    private string $titleClass;
    private string $contentClass;

    public function __construct(
        string $title,
        string $value = '',
        string $cssId = '',
        string $cssClass = 'panel panel-default',
        string $hdrClass = 'panel-heading',
        string $titleClass = 'panel-title',
        string $contentClass = 'panel-body'
    ) {
        parent::__construct('', $cssId, $cssClass);
        $this->content = $value;
        $this->title = $title;
        $this->hdrClass = $hdrClass;
        $this->titleClass = $titleClass;
        $this->contentClass = $contentClass;
        $this->createPanel();
    }

    /**
     * @param string $content additional content for this panel
     */
    public function addContent(string $content): void
    {
        $this->content .= $content;
    }

    private function createPanel(): void
    {
        $this->addElement(
            (new HtmlDiv('', '', $this->hdrClass))->addElement(
                new HtmlCtrl('h3', null, $this->title, true, '', $this->titleClass)
            )
        );
        $this->addElement(new HtmlDiv($this->content, '', $this->contentClass));
    }

    public function toHtml(mixed $parms = null): string
    {
        return parent::toHtml($parms);
    }
}
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
 * HtmlTable.php
 * Description: Represents an html table element (<table>)
 *
 */
class HtmlTable extends HtmlCtrl
{
    public function __construct(
        string $width = '',
        string $height = '',
        string $cssId = '',
        string $cssClass = ''
    ) {
        parent::__construct('table', null, '', true, $cssId, $cssClass);
        $this->addProperty('width', $width);
        $this->addProperty('height', $height);
        $this->addAllowed('ui\controls\web\HtmlTr');
    }
}
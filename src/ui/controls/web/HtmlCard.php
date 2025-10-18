<?php

declare(strict_types=1);

namespace ui\controls\web;

use ui\controls\HtmlCtrl;

/**
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
 * HtmlCard.php
 * Description: A card like the Bootstrap card component
 */
class HtmlCard extends HtmlDiv
{
    private ?HtmlDiv $body = null;
    private ?HtmlImg $topImg = null;
    private ?HtmlCtrl $title = null;
    private ?HtmlCtrl $subtitle = null;
    private ?HtmlDiv $header = null;
    private ?HtmlDiv $footer = null;
    private array $text = [];
    private array $link = [];
    private bool $prepared = false;
    private string $framework = 'bootstrap';
    private array $cfg = [
        'containerClass' => 'card',
        'bodyClass' => 'card-body',
        'headerClass' => 'card-header',
        'footerClass' => 'card-footer text-muted',
        'titleClass' => 'card-title',
        'subtitleClass' => 'card-subtitle mb-2 text-muted',
        'textClass' => 'card-text',
        'linkClass' => 'card-link',
        'imgTopClass' => 'card-img-top',
    ];

    /**
     * HtmlCard constructor.
     * @param string $cssId
     * @param string $cssClass
     * @param string $cssBodyClass
     */
    public function __construct(string $cssId = '', string $cssClass = 'card', string $cssBodyClass = 'card-body')
    {
        // HtmlDiv signature: (value, id, class)
        parent::__construct('', $cssId, $cssClass);
        $this->body = new HtmlDiv('', '', $cssBodyClass);
    }

    public function addTopImage(string $src, string $alt, string $cssClass = 'card-img-top'): static
    {
        if ($cssClass === 'card-img-top') { $cssClass = $this->cfg['imgTopClass']; }
        $this->topImg = new HtmlImg($src, $alt, '', $cssClass);
        return $this;
    }

    public function addTitle(string $title, string $cssClass = 'card-title'): static
    {
        if ($cssClass === 'card-title') { $cssClass = $this->cfg['titleClass']; }
        $this->title = new HtmlCtrl('h5', null, $title, true, '', $cssClass);
        return $this;
    }

    public function addSubTitle(string $subtitle, string $cssClass = 'card-subtitle mb-2 text-muted'): static
    {
        if ($cssClass === 'card-subtitle mb-2 text-muted') { $cssClass = $this->cfg['subtitleClass']; }
        $this->subtitle = new HtmlCtrl('h6', null, $subtitle, true, '', $cssClass);
        return $this;
    }

    public function addText(string $text, string $cssClass = 'card-text'): static
    {
        if ($cssClass === 'card-text') { $cssClass = $this->cfg['textClass']; }
        $this->text[] = new HtmlCtrl('p', null, $text, true, '', $cssClass);
        return $this;
    }

    public function addLink(string $href, string $childContent, string $cssClass = 'card-link', string $onclick = '', string $title = ''): static
    {
        if ($cssClass === 'card-link') { $cssClass = $this->cfg['linkClass']; }
        $this->link[] = new HtmlHyperLink($childContent, $href, $onclick, $title, '', $cssClass);
        return $this;
    }

    public function addHeader(string $header, string $cssClass = 'card-header'): static
    {
        if ($cssClass === 'card-header') { $cssClass = $this->cfg['headerClass']; }
        $this->header = new HtmlDiv($header, '', $cssClass);
        return $this;
    }

    public function addFooter(string $footer, string $cssClass = 'card-footer text-muted'): static
    {
        if ($cssClass === 'card-footer text-muted') { $cssClass = $this->cfg['footerClass']; }
        $this->footer = new HtmlDiv($footer, '', $cssClass);
        return $this;
    }

    /**
     * Returns an html representation of the control, including properties and children elements
     * @param null $flag
     * @return string
     * @throws \Exception
     */
    public function toHtml(mixed $flag = null): string
    {
        // Auto-inject React CSS shim once per request if using react mapping
        $prefix = '';
        if ($this->framework === 'react' && !self::$reactCssInjected) {
            $css = $this->getReactCss();
            if ($css !== '') {
                $style = new \ui\controls\HtmlCtrl('style', null, $css, true);
                $style->setAllowHtml(true);
                $prefix = $style->toHtml();
                self::$reactCssInjected = true;
            }
        }
        $this->prepareCard();
        return $prefix . parent::toHtml($flag);
    }

    private function prepareCard(): void
    {
        if ($this->prepared) { return; }
        // Ensure container/body classes reflect current framework
        $this->cssClass = $this->labelField('class', $this->cfg['containerClass']);
        if ($this->body !== null) {
            // Access protected property via subclass; safe within this context
            $this->body->cssClass = $this->labelField('class', $this->cfg['bodyClass']);
        }

        if ($this->topImg !== null) { $this->addElement($this->topImg); }
        if ($this->header !== null) { $this->addElement($this->header); }
        if ($this->title !== null) { $this->body->addElement($this->title); }
        if ($this->subtitle !== null) { $this->body->addElement($this->subtitle); }
        $this->addCollection($this->text);
        $this->addCollection($this->link);
        $this->addElement($this->body);
        if ($this->footer !== null) { $this->addElement($this->footer); }
        $this->prepared = true;
    }

    private function addCollection(array $collection): void
    {
        if (!empty($collection)) {
            foreach ($collection as $element) {
                $this->body->addElement($element);
            }
        }
    }

    private static bool $reactCssInjected = false;

    /** CSS for React framework mapping (rc-* classes). Injected once per request. */
    private function getReactCss(): string
    {
        return <<<CSS
.rc-card { background:#fff; border-radius: 12px; box-shadow: 0 6px 20px rgba(0,0,0,.08); overflow:hidden; border: 1px solid rgba(0,0,0,.06); }
.rc-card-img-top { display:block; width:100%; height:auto; }
.rc-card-header { padding: .75rem 1rem; border-bottom: 1px solid rgba(0,0,0,.08); color:#374151; font-weight:600; }
.rc-card-body { padding: 1rem; }
.rc-card-title { margin: 0 0 .25rem; font-size: 1.25rem; font-weight: 600; }
.rc-card-subtitle { margin: 0 0 .5rem; font-size: .875rem; color:#6b7280; }
.rc-card-text { margin: .5rem 0; color:#374151; }
.rc-card-footer { padding: .5rem 1rem; border-top: 1px solid rgba(0,0,0,.08); color:#6b7280; font-size:.875rem; }
.rc-card-link { color:#4f46e5; text-decoration:none; margin-right: 1rem; }
.rc-card-link:hover { text-decoration: underline; }
CSS;
    }

    /**
     * Configure framework-specific classes.
     * Supported: 'bootstrap' (default), 'tailwind', 'react', 'vanilla'
     */
    public function setFramework(string $framework): static
    {
        $this->framework = strtolower($framework);
        switch ($this->framework) {
            case 'bootstrap':
                $this->cfg = [
                    'containerClass' => 'card',
                    'bodyClass' => 'card-body',
                    'headerClass' => 'card-header',
                    'footerClass' => 'card-footer text-muted',
                    'titleClass' => 'card-title',
                    'subtitleClass' => 'card-subtitle mb-2 text-muted',
                    'textClass' => 'card-text',
                    'linkClass' => 'card-link',
                    'imgTopClass' => 'card-img-top',
                ];
                break;
            case 'tailwind':
                $this->cfg = [
                    'containerClass' => 'bg-white rounded-xl shadow overflow-hidden',
                    'bodyClass' => 'p-4',
                    'headerClass' => 'px-4 py-2 border-b text-gray-700 font-medium',
                    'footerClass' => 'px-4 py-2 border-t text-gray-500 text-sm',
                    'titleClass' => 'text-xl font-semibold',
                    'subtitleClass' => 'text-sm text-gray-500',
                    'textClass' => 'text-gray-700',
                    'linkClass' => 'text-indigo-600 hover:underline',
                    'imgTopClass' => 'w-full h-auto',
                ];
                break;
            case 'react':
                // React-friendly default classes (no external CSS framework)
                $this->cfg = [
                    'containerClass' => 'rc-card',
                    'bodyClass' => 'rc-card-body',
                    'headerClass' => 'rc-card-header',
                    'footerClass' => 'rc-card-footer',
                    'titleClass' => 'rc-card-title',
                    'subtitleClass' => 'rc-card-subtitle',
                    'textClass' => 'rc-card-text',
                    'linkClass' => 'rc-card-link',
                    'imgTopClass' => 'rc-card-img-top',
                ];
                break;
            case 'vanilla':
            default:
                $this->cfg = [
                    'containerClass' => 'card',
                    'bodyClass' => 'card-body',
                    'headerClass' => 'card-header',
                    'footerClass' => 'card-footer',
                    'titleClass' => 'card-title',
                    'subtitleClass' => 'card-subtitle',
                    'textClass' => 'card-text',
                    'linkClass' => 'card-link',
                    'imgTopClass' => 'card-img-top',
                ];
                break;
        }
        // Reset prepared so classes are applied on next render
        $this->prepared = false;
        return $this;
    }

    /** Override any of the class defaults. */
    public function setClasses(array $overrides): static
    {
        $this->cfg = array_merge($this->cfg, $overrides);
        $this->prepared = false;
        return $this;
    }
}
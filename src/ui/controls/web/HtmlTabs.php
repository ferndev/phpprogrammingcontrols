<?php

declare(strict_types=1);

namespace ui\controls\web;

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
 * HtmlTabs.php
 * Description: Represents an html tabs control, implemented here as a list, similar to bootstrap's tabs.
 * The classes default to bootstrap classes, but you can pass different ones if using a different frontend library
 *
 */
class HtmlTabs extends HtmlUl
{
    private ?HtmlDiv $contentParent = null;
    private string $framework = 'bootstrap';
    private array $cfg = [
        'ulClass' => 'nav nav-tabs',
        'liClass' => 'nav-item',
        'linkClass' => 'nav-link',
        'linkActiveClass' => 'active',
        'contentContainerClass' => 'tab-content',
        'paneClass' => 'tab-pane fade',
        'paneActiveClass' => 'show active',
        'paneHiddenClass' => ''
    ];
    private bool $injectScript = false; // only for non-bootstrap frameworks
    private array $tabs = []; // [ ['id' => 'paneId', 'active' => bool] ]
    private ?string $generatedId = null;

    public function __construct(string $cssId = '', string $cssClass = 'nav nav-tabs')
    {
        parent::__construct('', $cssId, $cssClass);
        // Ensure we have a predictable id to scope any client-side behavior
        if (trim($cssId) === '') {
            try {
                $this->generatedId = 'tabs-' . bin2hex(random_bytes(4));
            } catch (\Throwable) {
                $this->generatedId = uniqid('tabs-', false);
            }
            // HtmlBase::labelField is protected, but available via inheritance
            $this->cssId = $this->labelField('id', $this->generatedId);
        } else {
            // Extract id value from formatted attribute string
            $id = trim(str_replace(['id="', 'id="', '"'], '', $cssId));
            $this->generatedId = $id;
        }
        // Tablist role for accessibility
        $this->addProperty('role', 'tablist');
    }

    /**
     * Configure framework-specific classes and behavior.
     * Supported: 'bootstrap' (default), 'tailwind', 'vanilla'
     */
    public function setFramework(string $framework): static
    {
        $framework = strtolower($framework);
        $this->framework = $framework;
        if ($framework === 'bootstrap') {
            $this->cfg = [
                'ulClass' => 'nav nav-tabs',
                'liClass' => 'nav-item',
                'linkClass' => 'nav-link',
                'linkActiveClass' => 'active',
                'contentContainerClass' => 'tab-content',
                'paneClass' => 'tab-pane fade',
                'paneActiveClass' => 'show active',
                'paneHiddenClass' => ''
            ];
            $this->injectScript = false;
            // Clean helper data attributes if previously set
            $this->removeProperty('data-active-classes');
            $this->removeProperty('data-hidden-class');
        } elseif ($framework === 'react') { // react binder will handle toggling
            $this->cfg = [
                'ulClass' => 'flex space-x-2 border-b',
                'liClass' => '',
                'linkClass' => 'px-3 py-2 text-gray-600',
                'linkActiveClass' => 'border-b-2 border-indigo-600 text-indigo-700',
                'contentContainerClass' => '',
                'paneClass' => '',
                'paneActiveClass' => '',
                'paneHiddenClass' => 'hidden'
            ];
            $this->injectScript = false;
            // Expose classes to the binder
            $this->addProperty('data-active-classes', $this->cfg['linkActiveClass']);
            $this->addProperty('data-hidden-class', $this->cfg['paneHiddenClass']);
        } else { // tailwind or vanilla (with built-in toggling)
            $this->cfg = [
                'ulClass' => 'flex space-x-2 border-b',
                'liClass' => '',
                'linkClass' => 'px-3 py-2 text-gray-600',
                'linkActiveClass' => 'border-b-2 border-indigo-600 text-indigo-700',
                'contentContainerClass' => '',
                'paneClass' => '',
                'paneActiveClass' => '',
                'paneHiddenClass' => 'hidden'
            ];
            $this->injectScript = true;
            // Expose classes (harmless if unused)
            $this->addProperty('data-active-classes', $this->cfg['linkActiveClass']);
            $this->addProperty('data-hidden-class', $this->cfg['paneHiddenClass']);
        }
        // Apply UL classes according to framework unless user already set a custom class explicitly later
        $this->cssClass = $this->labelField('class', $this->cfg['ulClass']);
        return $this;
    }

    /**
     * Allow overriding default classes used by the control.
     */
    public function setClasses(array $config): static
    {
        $this->cfg = array_merge($this->cfg, $config);
        if (isset($config['ulClass'])) {
            $this->cssClass = $this->labelField('class', $this->cfg['ulClass']);
        }
        return $this;
    }

    /** Enable/disable client-side toggling script (for non-Bootstrap). */
    public function enableClientToggle(bool $enable): static
    {
        $this->injectScript = $enable;
        return $this;
    }

    /**
     * @param string $title tab title
     * @param string $contentLink hyperlink to this tab's content, as in #tab1content, where tab1content could be the id of a div
     * @param bool $isActiveTab boolean, true if this tab is the active tab
     * @param string $role for bootstrap use the default value below, for other libraries either ignore, use null, or a recommended value as per the library's docs
     */
    public function addTab(string $title, string $contentLink, bool $isActiveTab = false, string $role = 'presentation'): static
    {
        // Normalize the content id (strip leading '#')
        $paneId = ltrim($contentLink, '#');
        $this->tabs[] = ['id' => $paneId, 'active' => $isActiveTab];

        // Build link with framework-appropriate attributes
        $link = new HtmlHyperLink($title, '#' . $paneId);
        $link->addProperty('class', trim($this->cfg['linkClass'] . ($isActiveTab && $this->cfg['linkActiveClass'] !== '' ? ' ' . $this->cfg['linkActiveClass'] : '')));

        if ($this->framework === 'bootstrap') {
            $link
                ->addProperty('data-bs-toggle', 'tab')
                ->addProperty('role', 'tab')
                ->addProperty('aria-controls', $paneId)
                ->addProperty('aria-selected', $isActiveTab ? 'true' : 'false');
        } else {
            // Generic button role for non-Bootstrap
            $link->addProperty('role', 'button');
        }

        // Each tab item
        $li = (new HtmlLi('', '', $this->cfg['liClass']))
            ->addProperty('role', $role)
            ->addElement($link);

        parent::addElement($li);
        return $this;
    }

    public function setTabContent(string $contentLink, object $element): void
    {
        if ($this->contentParent === null) {
            $this->contentParent = new HtmlDiv('', '', $this->cfg['contentContainerClass']);
        }
        // Normalize the content id (strip leading '#')
        $paneId = ltrim($contentLink, '#');
        $isActive = false;
        foreach ($this->tabs as $t) {
            if ($t['id'] === $paneId) { $isActive = (bool)$t['active']; break; }
        }
        $paneClasses = trim($this->cfg['paneClass'] . ' ' . ($isActive ? $this->cfg['paneActiveClass'] : $this->cfg['paneHiddenClass']));
        $div = (new HtmlDiv('', $paneId, $paneClasses))->addElement($element);
        $this->contentParent->addElement($div);
    }

    public function toHtml(mixed $parms = null): string
    {
        $content = '';
        if (isset($this->contentParent)) {
            $content = $this->contentParent->toHtml($parms);
        }
        $html = parent::toHtml($parms) . $content;
        if ($this->injectScript && !empty($this->generatedId)) {
            // Build a small, scoped script to toggle panes by id and active classes
            $activeClasses = array_values(array_filter(explode(' ', $this->cfg['linkActiveClass'])));
            $hiddenClasses = array_values(array_filter(explode(' ', $this->cfg['paneHiddenClass'])));
            $activeClassesJs = json_encode($activeClasses, JSON_THROW_ON_ERROR);
            $hiddenClassesJs = json_encode($hiddenClasses, JSON_THROW_ON_ERROR);
            $id = $this->generatedId;
                        $script = <<<JS
<script>(function(){
    var tablist = document.getElementById('$id');
    if(!tablist) return;
    var links = Array.prototype.slice.call(tablist.querySelectorAll('a,button'));
    var activeClasses = $activeClassesJs;
    var hiddenClasses = $hiddenClassesJs;
    function getTarget(el){
        var href = el.getAttribute('href');
        if(href && href.indexOf('#') === 0){ return href.substring(1); }
        return el.getAttribute('data-target') || el.getAttribute('aria-controls');
    }
    var panes = links.map(function(l){ return getTarget(l); }).filter(Boolean).map(function(pid){ return document.getElementById(pid); }).filter(Boolean);
    function setActive(link){
        var targetId = getTarget(link);
        panes.forEach(function(p){
            var isTarget = p && p.id === targetId;
            hiddenClasses.forEach(function(cls){ if(!cls) return; if(isTarget){ p.classList.remove(cls);} else { p.classList.add(cls);} });
        });
        links.forEach(function(a){ activeClasses.forEach(function(cls){ if(!cls) return; a.classList.remove(cls); }); });
        activeClasses.forEach(function(cls){ if(!cls) return; link.classList.add(cls); });
    }
    var initial = null;
    // Prefer the link already marked active by server-side, else first link
    links.some(function(a){ if(activeClasses.length && a.classList && a.classList.contains(activeClasses[0])){ initial = a; return true; } return false; });
    if(!initial) initial = links[0] || null;
    if(initial) setActive(initial);
    links.forEach(function(a){ a.addEventListener('click', function(e){ e.preventDefault(); setActive(a); }); });
})();</script>
JS;
            $html .= $script;
        }
        return $html;
    }
}
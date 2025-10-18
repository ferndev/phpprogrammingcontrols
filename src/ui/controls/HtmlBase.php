<?php

declare(strict_types=1);

namespace ui\controls;

use JsonSerializable;
use InvalidArgumentException;

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
 * HtmlBase.php
 * Description: Base class for Html Elements
 *
 */
abstract class HtmlBase implements JsonSerializable
{
    protected array $events = [];
    protected ?string $element = null;
    protected array $children = [];
    private array $allowedChildren = [];
    protected ?string $type = null;
    protected string $value = '';
    protected string $cssId = '';
    protected string $cssClass = '';
    protected array $properties = [];

    /**
     * creates a new instance of this control
     * @param string|null $name name of the control, for instance the 'name' field in an <input type="text" name="" value="" />
     * @param string $cssId css id of this control
     * @param string $cssClass css class of this control
     */
    protected function __construct(?string $name, string $cssId = '', string $cssClass = '')
    {
        $this->addProperty('name', $name);
        $this->cssId = $this->labelField('id', $cssId);
        $this->cssClass = $this->labelField('class', $cssClass);
    }

    /**
     * adds an event handler to this control
     * @param string $evName event name
     * @param string $evHandler event handler
     */
    public function addEvent(string $evName, string $evHandler): void
    {
        if (!empty($evName) && !empty($evHandler)) {
            $this->events[] = $this->labelField($evName, $evHandler);
        }
    }

    /**
     * adds $element as a child of this control
     * @param HtmlBase $element a control that extends HtmlBase
     * @return static
     */
    public function addElement(HtmlBase $element): static
    {
        $this->children[] = $element;
        return $this;
    }

    /**
     * adds a property to this control
     * @param string $name property name
     * @param mixed $value property value
     * @return static
     */
    public function addProperty(string $name, mixed $value): static
    {
        if ($name === '') {
            throw new InvalidArgumentException('Property name cannot be empty');
        }
        if (isset($value)) {
            $this->properties[$name] = $value;
        }
        return $this;
    }

    /**
     * removes a property from this control
     * @param string $name property name
     * @return static
     */
    public function removeProperty(string $name): static
    {
        unset($this->properties[$name]);
        return $this;
    }

    /**
     * @return array the child elements of this html control
     */
    public function getElements(): array
    {
        return $this->children;
    }

    /**
     * @return array this element's properties
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param string $name property name
     * @return mixed the value of the specified property, or null if none found
     */
    public function getProperty(string $name): mixed
    {
        return $this->properties[$name] ?? null;
    }

    /**
     * @return array data for json representation of this control
     */
    public function jsonSerialize(): array
    {
        $data = ['element' => $this->element];
        
        if (!empty($this->properties)) {
            $data['properties'] = $this->properties;
        }
        
        if (!empty($this->children)) {
            $data['children'] = $this->children;
        }
        
        return $data;
    }

    /**
     * @return string a json representation of this control
     */
    public function toJson(): string
    {
        return json_encode($this, JSON_THROW_ON_ERROR);
    }

    /**
     * @return string|null element's tag name, as in div, img, form, input, etc
     */
    public function getTagName(): ?string
    {
        return $this->element;
    }

    /**
     * Abstract method that must be implemented by concrete classes
     * @param mixed $parms optional parameters passed to child elements
     * @return string html representation of this element
     */
    abstract public function toHtml(mixed $parms = null): string;

    protected function childrenToHtml(mixed $parms = null): string
    {
        $html = '';
        foreach ($this->children as $child) {
            if (!$child instanceof HtmlBase) {
                $className = get_class($child);
                error_log('@' . get_class($this) . ': One html child element is invalid:' . $className);
                throw new InvalidArgumentException('Invalid html child:' . $className . ' found in ' . get_class($this));
            }
            if (!empty($this->allowedChildren)) {
                $isAllowed = false;
                foreach ($this->allowedChildren as $allowed) {
                    if ($child instanceof $allowed) {
                        $isAllowed = true;
                        break;
                    }
                }
                if (!$isAllowed) {
                    $childClass = get_class($child);
                    $parentClass = get_class($this);
                    throw new InvalidArgumentException("Illegal child element:{$childClass} not allowed in {$parentClass}");
                }
            }
            $html .= $child->toHtml($parms);
        }
        return $html;
    }
    protected function propertiesToHtml(): string
    {
        $html = '';
        if (!empty($this->properties)) {
            foreach ($this->properties as $k => $v) {
                $html .= $this->labelField($k, $v);
            }
        }
        return $html;
    }

    protected function eventsToHtml(): string
    {
        $html = '';
        if (!empty($this->events)) {
            foreach ($this->events as $ev) {
                $html .= $ev . ' ';
            }
        }
        return $html;
    }

    protected function labelField(string $label, mixed $value): string
    {
        if ($value !== null && $value !== '') {
            return ' ' . $label . '="' . htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') . '" ';
        }
        return '';
    }

    protected function addAllowed(string $className): void
    {
        $this->allowedChildren[] = $className;
    }
}
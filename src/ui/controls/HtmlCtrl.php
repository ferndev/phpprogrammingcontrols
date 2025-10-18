<?php

declare(strict_types=1);

namespace ui\controls;

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
 * HtmlCtrl.php
 * Description: Base class of PHP controls for UI/Html rendering. It provides the essential logic that makes easy
 * creating other more complex components/controls
 *
 */
class HtmlCtrl extends HtmlBase
{
    private bool $hasClosingTag;
    private mixed $flag = null;
    private bool $allowHtml = false;

    /**
     * creates a new instance of this control
     * @param string $element the element tag, such as div, input, etc (see other controls that extend HtmlCtrl for examples
     * @param string|null $name name of the control, as in the 'name' field in an element, ex. <input type="text" name="" value="" />
     * @param string $value value of the control, as in the 'value' field in an element, ex. <input type="text" name="" value="" />
     * @param bool $hasClosingTag indicates whether the element has a closing tag (like in <h3>...</h3> or not
     * @param string $cssId the css id of this element
     * @param string $cssClass the css class of this element
     * @param bool $allowHtml whether to allow HTML in the value (auto-detected if not specified)
     */
    public function __construct(
        string $element = '',
        ?string $name = null,
        string $value = '',
        bool $hasClosingTag = true,
        string $cssId = '',
        string $cssClass = '',
        ?bool $allowHtml = null
    ) {
        parent::__construct($name, $cssId, $cssClass);
        
        // Auto-detect HTML content if not explicitly specified
        $this->allowHtml = $allowHtml ?? $this->containsHtmlTags($value);
        
        if ($hasClosingTag) {
            $this->value = $value;
        } else {
            $this->addProperty('value', $value);
        }
        
        $this->element = $element;
        $this->hasClosingTag = $hasClosingTag;
    }

    /**
     * Detects if the content contains HTML tags
     * @param string $content the content to check
     * @return bool true if HTML tags are detected
     */
    private function containsHtmlTags(string $content): bool
    {
        // Check for common HTML tag patterns
        return preg_match('/<[a-z][\s\S]*>/i', $content) === 1;
    }

    /**
     * Sets whether HTML is allowed in the content
     * @param bool $allow whether to allow HTML
     * @return static
     */
    public function setAllowHtml(bool $allow): static
    {
        $this->allowHtml = $allow;
        return $this;
    }

    /**
     * Renders the content safely based on HTML allowance
     * @param string $content the content to render
     * @return string the safely rendered content
     */
    private function renderContent(string $content): string
    {
        if ($this->allowHtml) {
            // For HTML content, we still want to validate it's not malicious
            // Allow common safe HTML tags but escape potentially dangerous attributes
            return $this->sanitizeHtmlContent($content);
        } else {
            // Escape all HTML for plain text content
            return htmlspecialchars($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
    }

    /**
     * Basic HTML sanitization for trusted content
     * @param string $html the HTML content
     * @return string sanitized HTML
     */
    private function sanitizeHtmlContent(string $html): string
    {
        // For trusted HTML content, we allow safe tags embedded in text
        
        // List of allowed safe tags (headings, formatting, etc.)
        $safeTags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'br', 'hr', 'strong', 'b', 'em', 'i', 'u', 'span', 'div'];
        
        // List of dangerous tags that should never be allowed
        $dangerousTags = ['script', 'iframe', 'object', 'embed', 'form', 'input', 'button', 'link', 'meta', 'style'];
        
        // Check for dangerous tags
        foreach ($dangerousTags as $tag) {
            if (preg_match("/<\/?$tag\b/i", $html)) {
                return htmlspecialchars($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }
        }
        
        // Check for dangerous attributes across the entire string
        if (preg_match('/\bon\w+\s*=|javascript\s*:|data\s*:|vbscript\s*:/i', $html)) {
            // Dangerous attributes found, escape the whole thing
            return htmlspecialchars($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
        
        // Split content into tags and text, process each part
        $processedContent = preg_replace_callback(
            '/<(\/?)(' . implode('|', $safeTags) . ')(\s[^>]*)?>/i',
            function($matches) {
                $isClosing = !empty($matches[1]);
                $tagName = $matches[2];
                $attributes = $matches[3] ?? '';
                
                // Build the safe tag
                return $isClosing ? "</{$tagName}>" : "<{$tagName}{$attributes}>";
            },
            $html
        );
        
        // If content was successfully processed and contains only safe patterns, allow it
        if ($processedContent !== null) {
            return $processedContent;
        }
        
        // If processing failed, escape for safety
        return htmlspecialchars($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * @param mixed $flag used to pass a boolean or int value to child elements (see HtmlTr and HtmlTd for an example of its application). See also addFlag method
     * @return string html representation of this element
     */
    public function toHtml(mixed $flag = null): string
    {
        if ($this->hasClosingTag) {
            $currentFlag = match (true) {
                isset($flag) && isset($this->flag) => $flag | $this->flag,
                isset($this->flag) => $this->flag,
                default => $flag
            };
            
            $html = '<' . $this->element . ' ' . $this->cssId . $this->cssClass . $this->propertiesToHtml() . $this->eventsToHtml() . '>';
            $html .= $this->renderContent($this->value) . $this->childrenToHtml($currentFlag) . '</' . $this->element . '>';
        } else {
            $html = '<' . $this->element . ' ' . $this->value . $this->cssId . $this->propertiesToHtml() . $this->cssClass . $this->eventsToHtml() . ' />';
        }
        return $html;
    }

    /**
     * @return array data for json representation of this control
     */
    public function jsonSerialize(): array
    {
        $data = parent::jsonSerialize();
        
        // Add content/value for HTML controls
        if ($this->hasClosingTag && !empty($this->value)) {
            $data['content'] = $this->value;
        }
        
        // Add CSS ID and Class if they exist
        if (!empty($this->cssId)) {
            $data['id'] = trim(str_replace(['id="', '"'], '', $this->cssId));
        }
        
        if (!empty($this->cssClass)) {
            $data['cssClass'] = trim(str_replace(['class="', '"'], '', $this->cssClass));
        }
        
        return $data;
    }

    /**
     * @param mixed $flag a simple (boolean or int) flag to pass down to children elements
     * for instance, in a certain table layout, a <tr> could pass information to its <td> elements this way, to indicate it is a header row
     */
    public function addFlag(mixed $flag): void
    {
        $this->flag = $flag;
    }
}
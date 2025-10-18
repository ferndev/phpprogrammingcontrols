<?php

declare(strict_types=1);

namespace ui\controls\tests;

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use ui\controls\web\{
    HtmlForm, HtmlInput, HtmlCheckbox, HtmlRadio, HtmlSelect, HtmlOption, 
    HtmlTextArea, HtmlButton, HtmlLabel
};

/**
 * Tests for form controls and input elements
 */
class FormControlsTest extends TestCase
{
    public function testHtmlFormCreation(): void
    {
        $form = new HtmlForm('test-form', 'post', 'submit.php');
        $html = $form->toHtml();
        
        $this->assertStringContainsString('<form', $html);
        $this->assertStringContainsString('name="test-form"', $html);
        $this->assertStringContainsString('method="post"', $html);
        $this->assertStringContainsString('action="submit.php"', $html);
        $this->assertStringContainsString('</form>', $html);
    }

    public function testHtmlInputTypes(): void
    {
        $textInput = new HtmlInput('text', 'username', 'defaultValue', 'user-id', 'form-control');
        $passwordInput = new HtmlInput('password', 'password', '', 'pass-id', 'form-control');
        $emailInput = new HtmlInput('email', 'email', '', 'email-id', 'form-control');
        
        $textHtml = $textInput->toHtml();
        $this->assertStringContainsString('type="text"', $textHtml);
        $this->assertStringContainsString('name="username"', $textHtml);
        $this->assertStringContainsString('value="defaultValue"', $textHtml);
        
        $passHtml = $passwordInput->toHtml();
        $this->assertStringContainsString('type="password"', $passHtml);
        
        $emailHtml = $emailInput->toHtml();
        $this->assertStringContainsString('type="email"', $emailHtml);
    }

    public function testHtmlCheckbox(): void
    {
        $uncheckedBox = new HtmlCheckbox('agree', 'yes', false, 'agree-cb', 'checkbox-class');
        $checkedBox = new HtmlCheckbox('newsletter', 'subscribe', true, 'newsletter-cb', 'checkbox-class');
        
        $uncheckedHtml = $uncheckedBox->toHtml();
        $this->assertStringContainsString('type="checkbox"', $uncheckedHtml);
        $this->assertStringContainsString('name="agree"', $uncheckedHtml);
        $this->assertStringContainsString('value="yes"', $uncheckedHtml);
        $this->assertStringNotContainsString('checked="checked"', $uncheckedHtml);
        
        $checkedHtml = $checkedBox->toHtml();
        $this->assertStringContainsString('checked="checked"', $checkedHtml);
    }

    public function testHtmlRadio(): void
    {
        $radio1 = new HtmlRadio('gender', 'male', false, 'male-radio', 'radio-class');
        $radio2 = new HtmlRadio('gender', 'female', true, 'female-radio', 'radio-class');
        
        $radio1Html = $radio1->toHtml();
        $this->assertStringContainsString('type="radio"', $radio1Html);
        $this->assertStringContainsString('name="gender"', $radio1Html);
        $this->assertStringContainsString('value="male"', $radio1Html);
        $this->assertStringNotContainsString('checked="checked"', $radio1Html);
        
        $radio2Html = $radio2->toHtml();
        $this->assertStringContainsString('value="female"', $radio2Html);
        $this->assertStringContainsString('checked="checked"', $radio2Html);
    }

    public function testCheckboxSetChecked(): void
    {
        $checkbox = new HtmlCheckbox('test', 'value', false);
        
        // Initially unchecked
        $this->assertStringNotContainsString('checked="checked"', $checkbox->toHtml());
        
        // Set checked
        $checkbox->setChecked(true);
        $this->assertStringContainsString('checked="checked"', $checkbox->toHtml());
        
        // Set unchecked
        $checkbox->setChecked(false);
        $this->assertStringNotContainsString('checked="checked"', $checkbox->toHtml());
    }

    public function testRadioSetChecked(): void
    {
        $radio = new HtmlRadio('test', 'value', false);
        
        // Initially unchecked
        $this->assertStringNotContainsString('checked="checked"', $radio->toHtml());
        
        // Set checked
        $radio->setChecked(true);
        $this->assertStringContainsString('checked="checked"', $radio->toHtml());
        
        // Set unchecked
        $radio->setChecked(false);
        $this->assertStringNotContainsString('checked="checked"', $radio->toHtml());
    }

    public function testHtmlSelect(): void
    {
        $select = new HtmlSelect('country', '', 'country-select', 'form-select');
        $select->addElement(new HtmlOption('us', 'us', 'United States'))
               ->addElement(new HtmlOption('ca', 'ca', 'Canada', '', '', true));
        
        $html = $select->toHtml();
        $this->assertStringContainsString('<select', $html);
        $this->assertStringContainsString('name="country"', $html);
        $this->assertStringContainsString('<option', $html);
        $this->assertStringContainsString('United States', $html);
        $this->assertStringContainsString('selected="selected"', $html); // Canada should be selected
    }

    public function testHtmlTextArea(): void
    {
        $textarea = new HtmlTextArea('comments', '5', '40', 'Default content', 'comment-area', 'form-textarea');
        $html = $textarea->toHtml();
        
        $this->assertStringContainsString('<textarea', $html);
        $this->assertStringContainsString('name="comments"', $html);
        $this->assertStringContainsString('rows="5"', $html);
        $this->assertStringContainsString('cols="40"', $html);
        $this->assertStringContainsString('Default content', $html);
        $this->assertStringContainsString('</textarea>', $html);
    }

    public function testComplexForm(): void
    {
        $form = new HtmlForm('user-form', 'post', 'process.php');
        $form->addElement(new HtmlLabel('Username:', 'username'))
             ->addElement(new HtmlInput('text', 'username', '', 'username', 'form-control'))
             ->addElement(new HtmlCheckbox('agree', 'yes', false, 'agree', 'form-check'))
             ->addElement(new HtmlButton('Submit', '', 'Submit Form', 'submit-btn', 'btn btn-primary'));
        
        $html = $form->toHtml();
        
        // Verify all elements are present
        $this->assertStringContainsString('<form', $html);
        $this->assertStringContainsString('<label', $html);
        $this->assertStringContainsString('<input', $html);
        $this->assertStringContainsString('type="checkbox"', $html);
        $this->assertStringContainsString('<button', $html);
        $this->assertStringContainsString('</form>', $html);
    }
}
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
 * HtmlLoginForm.php
 * Description: Creates a simple html <form> with username, password and other related fields
 *
 */
class HtmlLoginForm extends HtmlForm
{
    /**
     * @param string $name
     * @param string $method post or get
     * @param string $action where must the form data be sent to
     * @param string $recoveryUrl password recovery url
     * @param string $registerUrl new user registration url
     * @param string $cssId
     * @param string $cssClass
     */
    public function __construct(
        string $name,
        string $method,
        string $action = '',
        string $recoveryUrl = 'index.php/recpass',
        string $registerUrl = 'index.php/register',
        string $cssId = '',
        string $cssClass = ''
    ) {
        parent::__construct($name, $method, $action, $cssId, $cssClass);

        // Card wrapper (Bootstrap 5 look)
        $card = new HtmlDiv('', '', 'card shadow-lg border-0 rounded-4');
        $cardHeader = new HtmlDiv('', '', 'card-header bg-white border-0 pb-0');
        $cardHeader->addElement(new HtmlCtrl('h5', null, 'Enter Login Details', true, '', 'card-title mb-0 fw-semibold'));
        $cardBody = new HtmlDiv('', '', 'card-body p-4');

        // Intro icon + subtitle
        $intro = new HtmlDiv('', '', 'text-center mb-3');
        $lockIcon = new HtmlDiv('<i class="fas fa-lock fa-2x text-primary"></i>');
        $lockIcon->setAllowHtml(true);
        $intro->addElement($lockIcon)
              ->addElement(new HtmlCtrl('div', null, 'Sign in to your account', true, '', 'text-muted small'));

        // Username field
        $usernameGroup = new HtmlDiv('', '', 'mb-3');
        $usernameGroup->addElement(new HtmlLabel('', 'username', 'Username', '', 'form-label'));
        $usernameInputGroup = new HtmlDiv('', '', 'input-group');
        $usernamePrepend = new HtmlCtrl('span', null, '<i class="fas fa-user"></i>', true, '', 'input-group-text');
        $usernamePrepend->setAllowHtml(true);
        $usernameInput = (new HtmlInput('text', 'username', '', '', 'form-control'))->addProperty('id', 'username')->addProperty('placeholder', 'Enter your username');
        $usernameInputGroup->addElement($usernamePrepend)->addElement($usernameInput);
        $usernameHelp = new HtmlCtrl('div', null, 'Use your registered username or email', true, '', 'form-text');
        $usernameGroup->addElement($usernameInputGroup)->addElement($usernameHelp);

        // Password field
        $passwordGroup = new HtmlDiv('', '', 'mb-3');
        $passwordGroup->addElement(new HtmlLabel('', 'password', 'Password', '', 'form-label'));
        $passwordInputGroup = new HtmlDiv('', '', 'input-group');
        $passwordPrepend = new HtmlCtrl('span', null, '<i class="fas fa-key"></i>', true, '', 'input-group-text');
        $passwordPrepend->setAllowHtml(true);
        $passwordInput = (new HtmlInput('password', 'password', '', '', 'form-control'))->addProperty('id', 'password')->addProperty('placeholder', 'Enter your password');
        $toggleBtn = new HtmlButton('<i class="fas fa-eye"></i>', '', 'Show password', 'toggle-password', 'btn btn-outline-secondary');
        $toggleBtn->addProperty('type', 'button')->setAllowHtml(true);
        $passwordInputGroup->addElement($passwordPrepend)->addElement($passwordInput)->addElement($toggleBtn);
        $passwordHelp = new HtmlCtrl('div', null, 'Minimum 6 characters', true, '', 'form-text');
        $passwordGroup->addElement($passwordInputGroup)->addElement($passwordHelp);

        // Remember + actions row
        $actionsRow = new HtmlDiv('', '', 'd-flex justify-content-between align-items-center mb-3');
    $rememberWrap = new HtmlDiv('', '', 'form-check');
    $rememberInput = new HtmlInput('checkbox', 'remember', '1', 'remember', 'form-check-input');
    // HtmlLabel(name, for, value, cssId, cssClass) -> visible text must be the 3rd arg
    $rememberLabel = new HtmlLabel('', 'remember', 'Remember me', '', 'form-check-label');
        $rememberWrap->addElement($rememberInput)->addElement($rememberLabel);
        $forgot = new HtmlHyperLink('Forgot password?', $recoveryUrl, '', '', '', 'link-primary');
        $register = new HtmlHyperLink('Create account', $registerUrl, '', '', '', 'link-secondary');
        $actionsRow->addElement($rememberWrap)->addElement($forgot)->addElement($register);

        // Submit button (full width)
        $submitBtn = new HtmlButton('Sign in', '', 'Sign in', 'submit-btn', 'btn btn-primary w-100 btn-lg');
        $submitBtn->addProperty('type', 'submit');

        // Divider
        $divider = new HtmlDiv('', '', 'd-flex align-items-center my-4');
        $divider->addElement(new HtmlCtrl('hr', null, '', false, '', 'flex-grow-1 me-3'))
                ->addElement(new HtmlCtrl('div', null, 'Or continue with', true, '', 'text-muted small'))
                ->addElement(new HtmlCtrl('hr', null, '', false, '', 'flex-grow-1 ms-3'));

        // Social buttons
        $socialRow = new HtmlDiv('', '', 'row g-2');
        $googleCol = new HtmlDiv('', '', 'col-6');
        $githubCol = new HtmlDiv('', '', 'col-6');
        $googleBtn = new HtmlButton('<i class="fab fa-google me-2"></i> Google', '', 'Sign in with Google', 'google-btn', 'btn btn-outline-secondary w-100');
        $googleBtn->setAllowHtml(true);
        $githubBtn = new HtmlButton('<i class="fab fa-github me-2"></i> GitHub', '', 'Sign in with GitHub', 'github-btn', 'btn btn-outline-secondary w-100');
        $githubBtn->setAllowHtml(true);
        $googleCol->addElement($googleBtn);
        $githubCol->addElement($githubBtn);
        $socialRow->addElement($googleCol)->addElement($githubCol);

        // Assemble card body
        $cardBody->addElement($intro)
                 ->addElement($usernameGroup)
                 ->addElement($passwordGroup)
                 ->addElement($actionsRow)
                 ->addElement($submitBtn)
                 ->addElement($divider)
                 ->addElement($socialRow);

        // Assemble card and add to form
        $card->addElement($cardHeader)->addElement($cardBody);
        $this->addElement($card);
    }
}
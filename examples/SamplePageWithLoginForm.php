<?php
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
 * SamplePageWithLoginForm.php
 * Description: Simple sample of HtmlPage with a HtmlLoginForm php component.
 * These components are not dependent on any php framework, but can be used with any framework, either directly or easily adapted to fit any special usage requirement of any framework.
 * They are not dependent on a particular frontend framework either, but in this sample bootstrap is used. You can easily use them with any frontend library.
 *
 */
require __DIR__ . '/../vendor/autoload.php';

use ui\controls\HtmlCtrl;
use ui\controls\web\HtmlPage;
use ui\controls\web\HtmlLink;
use ui\controls\web\HtmlDiv;
use ui\controls\web\HtmlScript;
use ui\controls\web\HtmlLoginForm;
use ui\controls\web\HtmlHyperLink;
use ui\controls\web\HtmlButton;
use ui\controls\web\HtmlSpan;

$page = new HtmlPage(); // first create the html control representing the page
// Head: title, viewport, and Bootstrap 5 CSS (CDN)
$page->addHeader(new HtmlCtrl('title', null, 'Bootstrap Login Demo - PHP PROGRAMMING Controls'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));
$bsCss = new HtmlLink('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
$bsCss->addProperty('integrity','sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN')->addProperty('crossorigin','anonymous');
$page->addHeader($bsCss);
// Icons for input groups and social buttons
$faCss = new HtmlLink('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');
$faCss->addProperty('integrity','sha384-PPIZEGYM1v8zp5Py7UjFb79S58UeqCL9pYVnVPURKEqvioPROaVAJKKLzvH2rDnI')->addProperty('crossorigin','anonymous');
$page->addHeader($faCss);

// Slim page styles (background + header typography)
$customCss = <<<CSS
body { background: linear-gradient(135deg, #e7f0ff 0%, #f5ecff 100%); }
.login-shell { min-height: 100vh; }
.login-header h3 { font-weight: 700; letter-spacing: .2px; }
.login-subtitle { color: #6c757d; }
CSS;
$styleTag = new HtmlCtrl('style', null, $customCss);
$styleTag->setAllowHtml(true);
$page->addHeader($styleTag);

// Top navbar for cross-demo navigation
$topNav = new HtmlDiv('', '', 'navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4 rounded');
$navContainer = new HtmlDiv('', '', 'container');
$brand = new HtmlHyperLink('PHP PROGRAMMING Controls', 'landing.php', '', '', '', 'navbar-brand');
$toggler = new HtmlButton('', '', '', '', 'navbar-toggler');
$toggler->addProperty('type', 'button')
		->addProperty('data-bs-toggle', 'collapse')
		->addProperty('data-bs-target', '#loginNav')
		->addElement(new HtmlSpan('', '', 'navbar-toggler-icon'));
$navCollapse = new HtmlDiv('', 'loginNav', 'collapse navbar-collapse');
$navList = new HtmlDiv('', '', 'navbar-nav ms-auto');
$navItems = [
	['SamplePageWithLoginForm.php', 'Bootstrap', true],
	['SamplePageWithLoginFormTailwind.php', 'Tailwind', false],
	['SamplePageWithLoginFormReact.php', 'React', false],
];
foreach ($navItems as [$href, $text, $active]) {
	$li = new HtmlDiv('', '', 'nav-item');
	$cls = 'nav-link' . ($active ? ' active fw-semibold' : '');
	$link = new HtmlHyperLink($text, $href, '', '', '', $cls);
	$li->addElement($link);
	$navList->addElement($li);
}
$navCollapse->addElement($navList);
$navContainer->addElement($brand)->addElement($toggler)->addElement($navCollapse);
$topNav->addElement($navContainer);

// Elegant centered layout
$shell = new HtmlDiv('', '', 'login-shell d-flex align-items-center justify-content-center py-4');
$container = new HtmlDiv('', '', 'container');
$row = new HtmlDiv('', '', 'row justify-content-center');
$page->addBody($topNav);
$page->addBody($shell);

// Header text
$headerWrap = new HtmlDiv('', '', 'text-center mb-4 login-header');
$headerWrap->addElement(new HtmlCtrl('h3', null, 'Welcome Back'))
		   ->addElement(new HtmlDiv('Sign in to your account using Bootstrap', '', 'login-subtitle'));

// Column that holds the login form
$colForForm = new HtmlDiv('', '', 'col-12 col-md-8 col-lg-6 col-xl-5');
$colForForm->addElement(new HtmlLoginForm('loginform','post','index.php','','form-horizontal'));

$row->addElement($colForForm);
$container->addElement($headerWrap)->addElement($row);
$shell->addElement($container);

// finally add the scripts to the bottom of the body (Bootstrap 5 bundle, no jQuery needed)
$bsJs = new HtmlScript('');
$bsJs->addProperty('src','https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js')
	->addProperty('integrity','sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL')
	->addProperty('crossorigin','anonymous');
$page->addFooter($bsJs);

echo($page->toHtml());
?>

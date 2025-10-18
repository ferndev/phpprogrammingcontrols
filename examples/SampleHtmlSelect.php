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
 * SampleHtmlSelect.php
 * Description: Simple sample of HtmlSelect php component (<select>), modernized to match the side-by-side layout used in SampleDataTable.
 */
require __DIR__ . '/../vendor/autoload.php';

use ui\controls\HtmlCtrl;
use ui\controls\web\{ HtmlPage, HtmlLink, HtmlScript };
use ui\controls\web\{ HtmlDiv, HtmlSpan, HtmlSelect, HtmlOption };

// Page head (Bootstrap 5 + SRI), consistent with SampleDataTable
$page = new HtmlPage();
$page->addHeader(new HtmlCtrl('title', null, 'PHP PROGRAMMING Controls — HtmlSelect (Bootstrap)'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));
$bsCss = new HtmlLink('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
$bsCss->addProperty('integrity','sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN')->addProperty('crossorigin','anonymous');
$page->addHeader($bsCss);
$faCss = new HtmlLink('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');
$faCss->addProperty('integrity','sha384-PPIZEGYM1v8zp5Py7UjFb79S58UeqCL9pYVnVPURKEqvioPROaVAJKKLzvH2rDnI')->addProperty('crossorigin','anonymous');
$page->addHeader($faCss);
// Light styles and panel shim -> card look
$shimCss = <<<CSS
body { background: linear-gradient(135deg, #eef4ff 0%, #f9f6ff 100%); }
.section-card { border: 1px solid rgba(0,0,0,.06); border-radius: 1rem; box-shadow: 0 8px 24px rgba(0,0,0,.06); background: #fff; }
.code { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace; background: #f8f9fa; padding: .75rem; border-radius: .5rem; display: block; }
/* Bootstrap 3 panel shim */
.panel { background: #fff; border: 1px solid rgba(0,0,0,.08); border-radius: .75rem; box-shadow: 0 6px 18px rgba(0,0,0,.06); }
.panel-heading { padding: .75rem 1rem; border-bottom: 1px solid rgba(0,0,0,.06); background: #ffffff; }
.panel-title { margin: 0; font-size: 1.1rem; font-weight: 600; }
.panel-body { padding: 1rem; }
CSS;
$style = new HtmlCtrl('style', null, $shimCss);
$style->setAllowHtml(true);
$page->addHeader($style);
// Container shell and header (aligns with SampleDataTable)
$container = new HtmlDiv('', '', 'container py-5');
$topNav = new HtmlDiv('', '', 'navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4 rounded');
$navContainer = new HtmlDiv('', '', 'container');
$topNav->addElement($navContainer);
$header = new HtmlDiv('', '', 'text-center mb-5');
$header->addElement(new HtmlCtrl('h2', null, 'PHP PROGRAMMING Controls — HtmlSelect (Bootstrap)', true, '', 'fw-bold'))
	->addElement(new HtmlCtrl('p', null, 'HtmlSelect control with a few options', true, '', 'text-muted'));
$page->addBody($topNav);
$page->addBody($container->addElement($header));

// Build the HtmlSelect (left) and code (right)
$select = new HtmlSelect('select1', '', '', 'form-select');
$select->addElement(new HtmlOption('', 'choose', 'Choose an option'))
	->addElement(new HtmlOption('option1', 'option1', 'Option 1'))
	->addElement(new HtmlOption('option2', 'option2', 'Option 2', '', '', true))
	->addElement(new HtmlOption('option3', 'option3', 'Option 3'));

$code = <<<'EOD'
$select = new HtmlSelect('select1','','','form-select');<br>
$select->addElement(new HtmlOption('','choose','Choose an option'))<br>
&nbsp;&nbsp;->addElement(new HtmlOption('option1','option1','Option 1'))<br>
&nbsp;&nbsp;->addElement(new HtmlOption('option2','option2','Option 2','','',true))<br>
&nbsp;&nbsp;->addElement(new HtmlOption('option3','option3','Option 3'));<br>
<br>
echo $select->toHtml();<br>
EOD;

$row = new HtmlDiv('', '', 'row');
$row->addElement((new HtmlDiv('', '', 'col-md-5 col-lg-4'))->addElement($select))
	->addElement((new HtmlDiv('', '', 'col-md-7 col-lg-8'))->addElement((new HtmlDiv('', '', 'section-card p-3'))
	->addElement(new HtmlSpan('HtmlSelect populated with a few options'))
	->addElement(new HtmlSpan($code, '', 'code'))));

$rowSection = (new HtmlDiv('', '', 'row'))->addElement((new HtmlDiv('', '', 'col-12'))->addElement(new HtmlCtrl('h3', null, 'Select', true, '', 'mb-3')));
// Assemble into container
$container->addElement($rowSection)->addElement($row);

// Footer scripts
$bsJs = new HtmlScript('');
$bsJs->addProperty('src','https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js')
	->addProperty('integrity','sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL')
	->addProperty('crossorigin','anonymous');
$page->addFooter($bsJs);

echo $page->toHtml();


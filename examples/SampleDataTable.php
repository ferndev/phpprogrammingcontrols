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
 * Description: Simple sample of HtmlSelect php component (<select>).
 * These components are not dependent on any php framework, but can be used with any framework, either directly or easily adapted to fit any special usage requirement of any framework.
 * They are not dependent on a particular frontend framework either, but in this sample bootstrap is used. You can easily use them with any frontend library.
 *
 */
require __DIR__ . '/../vendor/autoload.php';

use ui\controls\HtmlCtrl;
use ui\controls\web\{ HtmlPage, HtmlLink, HtmlScript };
use ui\controls\web\HtmlSpan;
use ui\controls\web\HtmlTable, ui\controls\web\HtmlTr, ui\controls\web\HtmlTd;
use ui\controls\web\HtmlDiv;

$page = new HtmlPage();
$page->addHeader(new HtmlCtrl('title', null, 'Web Controls Demo - Bootstrap'));
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

// Container shell
$container = new HtmlDiv('', '', 'container py-5');
$topNav = new HtmlDiv('', '', 'navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4 rounded');
$navContainer = new HtmlDiv('', '', 'container');

$topNav->addElement($navContainer);
$header = new HtmlDiv('', '', 'text-center mb-5');
$header->addElement(new HtmlCtrl('h2', null, 'PHP PROGRAMMING Controls — HtmlTable (Bootstrap)', true, '', 'fw-bold'));

$page->addBody($topNav);
$page->addBody($container->addElement($header));

// <--------- This section demonstrate how to use HtmlTable --------->
$table = new HtmlTable("100%","","","table table-striped table-hover align-middle");
$scoredata = array_map('str_getcsv', str_getcsv(file_get_contents('scores.txt'),"\n"));
$first = true; // to make the first row a header
foreach($scoredata as $score) {
    $table->addElement((new HtmlTr($first))
        ->addElement((new HtmlTd())->addElement(new HtmlSpan($score[0])))
        ->addElement((new HtmlTd())->addElement(new HtmlSpan($score[1])))
        ->addElement((new HtmlTd())->addElement(new HtmlSpan($score[2]))));
    $first = false;
}

$tablecode = <<<'EOD'
$table = new HtmlTable("100%","","","table");<br>
$scoredata = array_map('str_getcsv', str_getcsv(file_get_contents('scores.txt'),"\n"));<br>
$first = true; // to make the first row a header<br>
foreach($scoredata as $score) {<br>
&nbsp;&nbsp;$table->addElement((new HtmlTr($first))<br>
&nbsp;&nbsp;->addElement((new HtmlTd())->addElement(new HtmlSpan($score[0])))<br>
&nbsp;&nbsp;->addElement((new HtmlTd())->addElement(new HtmlSpan($score[1])))<br>
&nbsp;&nbsp;->addElement((new HtmlTd())->addElement(new HtmlSpan($score[2]))));<br>
&nbsp;&nbsp;$first = false;<br>
}<br>
EOD;

$row3 = new HtmlDiv('', '', 'row');
$row3->addElement((new HtmlDiv('', '', 'col-md-5 col-lg-4'))->addElement($table))
    ->addElement((new HtmlDiv('', '', 'col-md-7 col-lg-8'))->addElement((new HtmlDiv('', '', 'section-card p-3'))
        ->addElement(new HtmlSpan('HtmlTable populated from data in a csv file'))->addElement(new HtmlSpan($tablecode,'','code'))));
$rowTableSection = (new HtmlDiv('', '', 'row'))->addElement((new HtmlDiv('', '', 'col-12'))->addElement(new HtmlCtrl('h3', null, 'Tables', true, '', 'mb-3')));

// Assemble into container
$container->addElement($rowTableSection)->addElement($row3);

// Footer scripts
$bsJs = new HtmlScript('');
$bsJs->addProperty('src','https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js')
    ->addProperty('integrity','sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL')
    ->addProperty('crossorigin','anonymous');
$page->addFooter($bsJs);

echo $page->toHtml();
<?php
/*
 * TabsExample.php
 * Copyright 2025 Fernando M. (https://github.com/ferndev)
 *
 * Description: Sample usage of HtmlTabs with a modern layout: control on left, code on right.
 */
require __DIR__ . '/../vendor/autoload.php';

use ui\controls\HtmlCtrl;
use ui\controls\web\{ HtmlPage, HtmlLink, HtmlScript };
use ui\controls\web\{ HtmlDiv, HtmlSpan, HtmlTabs };

$page = new HtmlPage();
$page->addHeader(new HtmlCtrl('title', null, 'PHP PROGRAMMING Controls — HtmlTabs (Bootstrap)'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));
$bsCss = new HtmlLink('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
$bsCss->addProperty('integrity','sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN')->addProperty('crossorigin','anonymous');
$page->addHeader($bsCss);
$faCss = new HtmlLink('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');
$faCss->addProperty('integrity','sha384-PPIZEGYM1v8zp5Py7UjFb79S58UeqCL9pYVnVPURKEqvioPROaVAJKKLzvH2rDnI')->addProperty('crossorigin','anonymous');
$page->addHeader($faCss);

$shimCss = <<<CSS
body { background: linear-gradient(135deg, #eef4ff 0%, #f9f6ff 100%); }
.section-card { border: 1px solid rgba(0,0,0,.06); border-radius: 1rem; box-shadow: 0 8px 24px rgba(0,0,0,.06); background: #fff; }
.code { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace; background: #f8f9fa; padding: .75rem; border-radius: .5rem; display: block; }
CSS;
$style = new HtmlCtrl('style', null, $shimCss);
$style->setAllowHtml(true);
$page->addHeader($style);

$container = new HtmlDiv('', '', 'container py-5');
$header = new HtmlDiv('', '', 'text-center mb-5');
$header->addElement(new HtmlCtrl('h2', null, 'PHP PROGRAMMING Controls — HtmlTabs (Bootstrap)', true, '', 'fw-bold'))
       ->addElement(new HtmlCtrl('p', null, 'Tab navigation control', true, '', 'text-muted'));
$page->addBody($container->addElement($header));

// Left: tabs; Right: code
$row = new HtmlDiv('', '', 'row');
$left = new HtmlDiv('', '', 'col-md-5 col-lg-4');
$tabs = (new HtmlTabs())->setFramework('bootstrap');
$tabs->addTab('Tab1', '#tab1content', true)->addTab('Tab2', '#tab2content')->addTab('Tab3', '#tab3content');
$tabs->setTabContent('tab1content', new HtmlDiv('Tab1 content...'));
$tabs->setTabContent('tab2content', new HtmlDiv('Tab2 content...'));
$tabs->setTabContent('tab3content', new HtmlDiv('Tab3 content...'));
$left->addElement($tabs);

$code = <<<'EOD'
$tabs = new HtmlTabs();<br>
$tabs->addTab('Tab1', '#tab1content', true)->addTab('Tab2', '#tab2content')->addTab('Tab3', '#tab3content');<br>
<br>
// Then render the tab panes:<br>
<div class="tab-content">... panes here ...</div>
EOD;

$right = new HtmlDiv('', '', 'col-md-7 col-lg-8');
$rightCard = new HtmlDiv('', '', 'section-card p-3');
$rightCard->addElement(new HtmlSpan('HtmlTabs control with three tabs'))
          ->addElement(new HtmlSpan($code,'','code'));
$right->addElement($rightCard);

$row->addElement($left)->addElement($right);
$rowSection = (new HtmlDiv('', '', 'row'))->addElement((new HtmlDiv('', '', 'col-12'))->addElement(new HtmlCtrl('h3', null, 'Tabs', true, '', 'mb-3')));
$container->addElement($rowSection)->addElement($row);

$bsJs = new HtmlScript('');
$bsJs->addProperty('src','https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js')
     ->addProperty('integrity','sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL')
     ->addProperty('crossorigin','anonymous');
$page->addFooter($bsJs);

echo $page->toHtml();

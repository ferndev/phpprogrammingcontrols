<?php
/*
 * TabsExampleTailwind.php
 * Tailwind variant: Tabs with left control/right code layout
 */
require __DIR__ . '/../vendor/autoload.php';

use ui\controls\HtmlCtrl;
use ui\controls\web\{ HtmlPage, HtmlScript };
use ui\controls\web\{ HtmlDiv, HtmlSpan, HtmlTabs };

$page = new HtmlPage();
$page->addHeader(new HtmlCtrl('title', null, 'PHP PROGRAMMING Controls — HtmlTabs (Tailwind)'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));
$page->addHeader(new HtmlScript('https://cdn.tailwindcss.com'));

$shimCss = <<<CSS
.code { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace; }
CSS;
$style = new HtmlCtrl('style', null, $shimCss);
$style->setAllowHtml(true);
$page->addHeader($style);

$main = new HtmlDiv('', '', 'min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-8');
$container = new HtmlDiv('', '', 'container mx-auto');
$header = new HtmlDiv('', '', 'text-center mb-12');
$header->addElement(new HtmlCtrl('h2', null, 'PHP PROGRAMMING Controls — HtmlTabs (Tailwind)', true, '', 'font-bold text-2xl md:text-3xl text-gray-800'))
       ->addElement(new HtmlCtrl('p', null, 'Tab navigation control', true, '', 'text-gray-600'));

$row = new HtmlDiv('', '', 'grid grid-cols-12 gap-6');
$left = new HtmlDiv('', '', 'col-span-12 md:col-span-5 lg:col-span-4');
$tabs = (new HtmlTabs())->setFramework('tailwind');
$tabs->addTab('Tab1', '#tab1content', true)->addTab('Tab2', '#tab2content')->addTab('Tab3', '#tab3content');
$tabs->setTabContent('tab1content', new HtmlDiv('Tab1 content...'));
$tabs->setTabContent('tab2content', new HtmlDiv('Tab2 content...'));
$tabs->setTabContent('tab3content', new HtmlDiv('Tab3 content...'));
$left->addElement($tabs);

$code = <<<'EOD'
$tabs = new HtmlTabs();\n$tabs->addTab('Tab1', '#tab1content', true)->addTab('Tab2', '#tab2content')->addTab('Tab3', '#tab3content');\n\n<div class="tab-content">... panes here ...</div>
EOD;

$right = new HtmlDiv('', '', 'col-span-12 md:col-span-7 lg:col-span-8');
$rightCard = new HtmlDiv('', '', 'bg-white rounded-xl shadow p-4');
$rightCard->addElement(new HtmlSpan('HtmlTabs control with three tabs'))
          ->addElement(new HtmlSpan($code,'','code block whitespace-pre-wrap bg-gray-50 rounded p-3 mt-3 text-sm'));
$right->addElement($rightCard);

$container->addElement($header)->addElement($row->addElement($left)->addElement($right));
$main->addElement($container);
$page->addBody($main);

echo $page->toHtml();

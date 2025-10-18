<?php
/*
 * SamplePageWithImgAndHtmlAreaTailwind.php
 * Tailwind variant: Image + Textarea with left control/right code layout
 */
require __DIR__ . '/../vendor/autoload.php';

use ui\controls\HtmlCtrl;
use ui\controls\web\{ HtmlPage, HtmlScript };
use ui\controls\web\{ HtmlDiv, HtmlImg, HtmlSpan };

$page = new HtmlPage();
$page->addHeader(new HtmlCtrl('title', null, 'PHP PROGRAMMING Controls — Image + Text Area (Tailwind)'));
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
$header->addElement(new HtmlCtrl('h2', null, 'PHP PROGRAMMING Controls — Image + Text Area (Tailwind)', true, '', 'font-bold text-2xl md:text-3xl text-gray-800'))
       ->addElement(new HtmlCtrl('p', null, 'A simple image and textarea demo', true, '', 'text-gray-600'));

$row = new HtmlDiv('', '', 'grid grid-cols-12 gap-6');
$left = new HtmlDiv('', '', 'col-span-12 md:col-span-5 lg:col-span-4');
$img = new HtmlImg('img/buddy-face-small.png', 'The nicest friend :)', '', 'rounded shadow-md mb-3 max-w-full');
$ta = new \ui\controls\web\HtmlTextArea('about','5','80');
$ta->addProperty('class','w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500');
$ta->addProperty('placeholder','Write about your dog');
$left->addElement($img)->addElement($ta);

$code = <<<'EOD'
$img = new HtmlImg('img/buddy-face-small.png','The nicest friend :)','', 'rounded shadow-md mb-3 max-w-full');\n
$ta = new HtmlTextArea('about','5','80');\n$ta->addProperty('class','w-full px-3 py-2 border border-gray-300 rounded')\n   ->addProperty('placeholder','Write about your dog');
EOD;

$right = new HtmlDiv('', '', 'col-span-12 md:col-span-7 lg:col-span-8');
$rightCard = new HtmlDiv('', '', 'bg-white rounded-xl shadow p-4');
$rightCard->addElement(new HtmlSpan('HtmlImg with a Tailwind-styled HtmlTextArea'))
          ->addElement(new HtmlSpan($code,'','code block whitespace-pre-wrap bg-gray-50 rounded p-3 mt-3 text-sm'));
$right->addElement($rightCard);

$container->addElement($header)->addElement($row->addElement($left)->addElement($right));
$main->addElement($container);
$page->addBody($main);

echo $page->toHtml();

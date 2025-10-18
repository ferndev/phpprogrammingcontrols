<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use ui\controls\HtmlCtrl;
use ui\controls\web\{ HtmlPage, HtmlScript };
use ui\controls\web\{ HtmlDiv, HtmlSpan, HtmlCard };

$page = new HtmlPage();
$page->addHeader(new HtmlCtrl('title', null, 'PHP PROGRAMMING Controls — HtmlCard (Tailwind)'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));
$page->addHeader(new HtmlScript('https://cdn.tailwindcss.com'));

$main = new HtmlDiv('', '', 'min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-8');
$container = new HtmlDiv('', '', 'container mx-auto');
$header = new HtmlDiv('', '', 'text-center mb-12');
$header->addElement(new HtmlCtrl('h2', null, 'PHP PROGRAMMING Controls — HtmlCard (Tailwind)', true, '', 'font-bold text-2xl md:text-3xl text-gray-800'))
       ->addElement(new HtmlCtrl('p', null, 'Tailwind-styled card control', true, '', 'text-gray-600'));

$row = new HtmlDiv('', '', 'grid grid-cols-12 gap-6');
$left = new HtmlDiv('', '', 'col-span-12 md:col-span-5 lg:col-span-4');

$card = (new HtmlCard())->setFramework('tailwind');
$card
  ->addTopImage('https://picsum.photos/seed/twcard/600/300', 'Random image')
  ->addHeader('Featured')
  ->addTitle('HtmlCard Title')
  ->addSubTitle('Card subtitle')
  ->addText('Some quick example text to build on the card title and make up the bulk of the card content.')
  ->addLink('#', 'Card link')
  ->addLink('#', 'Another link')
  ->addFooter('2 days ago');

$left->addElement($card);

$code = <<<'EOD'
$card = (new HtmlCard())->n  setFramework('tailwind');<br>
$card->addTopImage('https://picsum.photos/seed/twcard/600/300', 'Random image')<br>
     ->addHeader('Featured')<br>
     ->addTitle('HtmlCard Title')<br>
     ->addSubTitle('Card subtitle')<br>
     ->addText('Some quick example text...')<br>
     ->addLink('#', 'Card link')<br>
     ->addLink('#', 'Another link')<br>
     ->addFooter('2 days ago');
EOD;

$right = new HtmlDiv('', '', 'col-span-12 md:col-span-7 lg:col-span-8');
$rightCard = new HtmlDiv('', '', 'bg-white rounded-xl shadow p-4');
$rightCard->addElement(new HtmlSpan('HtmlCard control example (Tailwind)'))
          ->addElement(new HtmlSpan($code,'','block whitespace-pre-wrap bg-gray-50 rounded p-3 mt-3 text-sm'));
$right->addElement($rightCard);

$container->addElement($header)->addElement($row->addElement($left)->addElement($right));
$main->addElement($container);
$page->addBody($main);

echo $page->toHtml();

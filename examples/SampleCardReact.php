<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use ui\controls\HtmlCtrl;
use ui\controls\web\{ HtmlPage, HtmlScript };
use ui\controls\web\{ HtmlDiv, HtmlSpan, HtmlCard };

$page = new HtmlPage();
$page->addHeader(new HtmlCtrl('title', null, 'PHP PROGRAMMING Controls — HtmlCard (React)'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));

// No external CSS framework for React demo; we inject a small CSS shim instead
$reactJs = new HtmlScript('');
$reactJs->addProperty('src','https://unpkg.com/react@18/umd/react.development.js')
        ->addProperty('integrity','sha384-hD6/rw4ppMLGNu3tX5cjIb+uRZ7UkRJ6BPkLpg4hAu/6onKUg4lLsHAs9EBPT82L')
        ->addProperty('crossorigin','anonymous');
$page->addHeader($reactJs);
$reactDomJs = new HtmlScript('');
$reactDomJs->addProperty('src','https://unpkg.com/react-dom@18/umd/react-dom.development.js')
           ->addProperty('integrity','sha384-u6aeetuaXnQ38mYT8rp6sbXaQe3NL9t+IBXmnYxwkUI2Hw4bsp2Wvmx4yRQF1uAm')
           ->addProperty('crossorigin','anonymous');
$page->addHeader($reactDomJs);
$babelJs = new HtmlScript('');
$babelJs->addProperty('src','https://unpkg.com/@babel/standalone/babel.min.js')
        ->addProperty('integrity','sha384-tL0JdJBWAk5nHKZhc/dtWf7bZRpYP13x4HjH85NrwCr/JkBnrZ7RNBOAdDzJlpof')
        ->addProperty('crossorigin','anonymous');
$page->addHeader($babelJs);

// Minimal page styling for layout only (not card), tiny CSS
$pageCss = <<<CSS
body { background: linear-gradient(135deg, #eef4ff 0%, #f9f6ff 100%); margin:0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, sans-serif; }
.rc-container { max-width: 1000px; margin: 0 auto; padding: 2rem; }
.rc-header { text-align: center; margin-bottom: 2rem; }
.rc-title { font-weight: 700; font-size: clamp(1.5rem, 2vw, 2rem); color: #1f2937; }
.rc-subtitle { color: #6b7280; }
.rc-row { display: grid; grid-template-columns: 1fr; gap: 1.5rem; }
@media (min-width: 768px){ .rc-row { grid-template-columns: 2fr 3fr; } }
.rc-panel { background: #fff; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,.06); padding: 1rem; }
CSS;
$style = new HtmlCtrl('style', null, $pageCss);
$style->setAllowHtml(true);
$page->addHeader($style);

$outer = new HtmlDiv('', '', '');
$container = new HtmlDiv('', '', 'rc-container');
$header = new HtmlDiv('', '', 'rc-header');
$header->addElement(new HtmlCtrl('h2', null, 'PHP PROGRAMMING Controls — HtmlCard (React)', true, '', 'rc-title'))
  ->addElement(new HtmlCtrl('p', null, 'React-friendly card control (no CSS framework)', true, '', 'rc-subtitle'));

$row = new HtmlDiv('', '', 'rc-row');
$left = new HtmlDiv('', '', '');

// Server-rendered HtmlCard using React-friendly (Tailwind-like) classes
$card = (new HtmlCard())->setFramework('react');
$card
  ->addTopImage('https://picsum.photos/seed/reactcard/600/300', 'Random image')
  ->addHeader('Featured')
  ->addTitle('HtmlCard Title')
  ->addSubTitle('Card subtitle')
  ->addText('Some quick example text to build on the card title and make up the bulk of the card content.')
  ->addLink('#', 'Card link')
  ->addLink('#', 'Another link')
  ->addFooter('2 days ago');

$left->addElement($card);

$right = new HtmlDiv('', '', '');
$rightCard = new HtmlDiv('', '', 'rc-panel');
$code = <<<'EOD'
$card = (new HtmlCard())
  ->setFramework('react')
  ->addTopImage('https://picsum.photos/seed/reactcard/600/300', 'Random image')
  ->addHeader('Featured')
  ->addTitle('HtmlCard Title')
  ->addSubTitle('Card subtitle')
  ->addText('Some quick example text...')
  ->addLink('#', 'Card link')
  ->addLink('#', 'Another link')
  ->addFooter('2 days ago');
EOD;
$rightCard->addElement(new HtmlSpan('HtmlCard control example (React-friendly classes, server-rendered)'))
          ->addElement(new HtmlSpan($code,'','block whitespace-pre-wrap bg-gray-50 rounded p-3 mt-3 text-sm', false));
$right->addElement($rightCard);

$container->addElement($header)->addElement($row->addElement($left)->addElement($right));
$outer->addElement($container);
$page->addBody($outer);

echo $page->toHtml();

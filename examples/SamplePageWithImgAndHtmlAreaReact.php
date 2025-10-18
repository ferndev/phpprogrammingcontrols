<?php
/*
 * SamplePageWithImgAndHtmlAreaReact.php
 * React variant: Image + Textarea with left control/right code layout
 */
require __DIR__ . '/../vendor/autoload.php';

use ui\controls\HtmlCtrl;
use ui\controls\web\{ HtmlPage, HtmlScript };
use ui\controls\web\{ HtmlDiv };

$page = new HtmlPage();
$page->addHeader(new HtmlCtrl('title', null, 'PHP PROGRAMMING Controls — Image + Text Area (React)'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));

// CDN: Tailwind + React 18 + Babel
$page->addHeader(new HtmlScript('https://cdn.tailwindcss.com'));
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

// Root container
$top = new HtmlDiv('', '', 'min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-8');
$root = new HtmlDiv('<noscript>Please enable JavaScript to view the app.</noscript>', 'react-img-text', 'container mx-auto');
$root->setAllowHtml(true);
$page->addBody($top->addElement($root));

// External JSX
$jsx = new HtmlCtrl('script', null, '', true);
$jsx->addProperty('type','text/babel');
$jsx->addProperty('data-presets','react');
$jsx->addProperty('src','js/img-text.jsx');
$page->addFooter($jsx);

echo $page->toHtml();

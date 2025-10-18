<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use ui\controls\web\{
    HtmlPage, HtmlDiv, HtmlScript, HtmlLink
};
use ui\controls\HtmlCtrl;

// Create page with React setup
$page = new HtmlPage();
// Head: title and meta
$page->addHeader(new HtmlCtrl('title', null, 'React Login Demo - PHP PROGRAMMING Controls'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));

// Add React, ReactDOM, Babel
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

// Tailwind (CDN script)
$page->addHeader(new HtmlScript('https://cdn.tailwindcss.com'));

// React application container inside <body>
$topNav = new HtmlDiv('', '', 'bg-white/90 backdrop-blur sticky top-0 z-10 shadow-sm');
$navInner = new HtmlDiv('', '', 'container mx-auto px-4');
$navBar = new HtmlDiv('', '', 'flex items-center justify-between h-14');
$brand = new HtmlCtrl('a', null, 'PHP PROGRAMMING Controls', true, '', 'font-semibold text-gray-800');
$brand->addProperty('href', 'landing.php');
$navLinks = new HtmlDiv('', '', 'flex items-center gap-4');
foreach ([
    ['SamplePageWithLoginForm.php','Bootstrap',false],
    ['SamplePageWithLoginFormTailwind.php','Tailwind',false],
    ['SamplePageWithLoginFormReact.php','React',true],
] as [$href,$text,$active]) {
    $a = new HtmlCtrl('a', null, $text, true, '', 'text-sm px-3 py-1 rounded '.($active?'bg-indigo-600 text-white':'text-gray-700 hover:bg-gray-100'));
    $a->addProperty('href', $href);
    $navLinks->addElement($a);
}
$navBar->addElement($brand)->addElement($navLinks);
$navInner->addElement($navBar);
$topNav->addElement($navInner);

// React application container inside <body>
$reactContainer = new HtmlDiv('<noscript>Please enable JavaScript to view the app.</noscript>', 'react-app', '');
$reactContainer->setAllowHtml(true);
$page->addBody($topNav);
$page->addBody($reactContainer);

// Load JSX from external file so it can be compiled by Babel in the browser
$jsxScript = new HtmlScript('js/react-login.jsx');
$jsxScript->addProperty('type', 'text/babel')->addProperty('data-presets', 'env,react');
$page->addFooter($jsxScript);

echo $page->toHtml();
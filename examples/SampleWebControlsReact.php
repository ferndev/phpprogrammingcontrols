<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use ui\controls\web\{ HtmlPage, HtmlDiv, HtmlScript, HtmlLink };
use ui\controls\HtmlCtrl;

// Create page with React + Tailwind via CDN
$page = new HtmlPage();
$page->addHeader(new HtmlCtrl('title', null, 'Web Controls Demo - React'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));

// Tailwind (for styling the React components)
$page->addHeader(new HtmlScript('https://cdn.tailwindcss.com'));

// React 18 UMD + ReactDOM + Babel for in-browser JSX transform
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

// App mount node
$root = new HtmlDiv('', 'react-root', 'min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-8');
$topNav = new HtmlDiv('', '', 'bg-white/90 backdrop-blur sticky top-0 z-10 shadow-sm rounded mb-0');
$navInner = new HtmlDiv('', '', 'container mx-auto px-4');
$navBar = new HtmlDiv('', '', 'flex items-center justify-between h-14');
$brand = new HtmlCtrl('a', null, 'PHP PROGRAMMING Controls', true, '', 'font-semibold text-gray-800');
$brand->addProperty('href', 'landing.php');
$navLinks = new HtmlDiv('', '', 'flex items-center gap-4');
foreach ([
	['SampleWebControls.php','Bootstrap',false],
	['SampleWebControlsTailwind.php','Tailwind',false],
	['SampleWebControlsReact.php','React',true],
] as [$href,$text,$active]) {
	$a = new HtmlCtrl('a', null, $text, true, '', 'text-sm px-3 py-1 rounded '.($active?'bg-indigo-600 text-white':'text-gray-700 hover:bg-gray-100'));
	$a->addProperty('href', $href);
	$navLinks->addElement($a);
}
$navBar->addElement($brand)->addElement($navLinks);
$navInner->addElement($navBar);
$topNav->addElement($navInner);
$container = new HtmlDiv('', '', 'container mx-auto');
$hero = new HtmlCtrl('div', null, '', true, '', 'text-center mb-12');
$hero->addElement(new HtmlCtrl('h1', null, 'PHP PROGRAMMING Controls — Web Controls (React)', true, '', 'text-4xl font-bold text-gray-800 mb-4'));
$hero->addElement(new HtmlCtrl('p', null, 'Rendered with React 18 + Tailwind CSS', true, '', 'text-xl text-gray-600'));
$container->addElement($hero);
$root->addElement($container);
// Place navbar outside React root so it persists after React mounts
$page->addBody($topNav);
$page->addBody($root);

// Add external JSX so Babel compiles it without our PHP sanitizer touching inline content
$babelScript = new HtmlCtrl('script', null, '', true);
$babelScript->addProperty('type', 'text/babel');
$babelScript->addProperty('data-presets', 'react');
$babelScript->addProperty('src', 'js/web-controls.jsx');
$page->addFooter($babelScript);

echo $page->toHtml();

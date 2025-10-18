<?php
/*
 * TabsExampleReact.php
 * React variant: Tabs with left control/right code layout
 */
require __DIR__ . '/../vendor/autoload.php';

use ui\controls\HtmlCtrl;
use ui\controls\web\{ HtmlPage, HtmlScript };
use ui\controls\web\{ HtmlDiv, HtmlSpan, HtmlTabs };

$page = new HtmlPage();
$page->addHeader(new HtmlCtrl('title', null, 'PHP PROGRAMMING Controls — HtmlTabs (React)'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));

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

// Outer layout
$outer = new HtmlDiv('', '', 'min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-8');
$container = new HtmlDiv('', '', 'container mx-auto');
$header = new HtmlDiv('', '', 'text-center mb-12');
$header->addElement(new HtmlCtrl('h2', null, 'PHP PROGRAMMING Controls — HtmlTabs (React)', true, '', 'font-bold text-2xl md:text-3xl text-gray-800'))
          ->addElement(new HtmlCtrl('p', null, 'Tab navigation control (HtmlTabs with React binder)', true, '', 'text-gray-600'));

// Grid
$row = new HtmlDiv('', '', 'grid grid-cols-12 gap-6');
$left = new HtmlDiv('', '', 'col-span-12 md:col-span-5 lg:col-span-4');

// HtmlTabs rendered server-side; React will bind behavior
$tabs = new HtmlTabs('react-tabs');
$tabs->setFramework('react');
$tabs->addTab('Tab1', '#tab1content', true)
        ->addTab('Tab2', '#tab2content')
        ->addTab('Tab3', '#tab3content');
$tabs->setTabContent('tab1content', new HtmlDiv('Tab1 content...'));
$tabs->setTabContent('tab2content', new HtmlDiv('Tab2 content...'));
$tabs->setTabContent('tab3content', new HtmlDiv('Tab3 content...'));
$left->addElement($tabs);

$right = new HtmlDiv('', '', 'col-span-12 md:col-span-7 lg:col-span-8');
$rightCard = new HtmlDiv('', '', 'bg-white rounded-xl shadow p-4');
$code = <<<'CODE'
$tabs = (new HtmlTabs('react-tabs'))
        ->setFramework('react');
$tabs
        ->addTab('Tab1', '#tab1content', true)
        ->addTab('Tab2', '#tab2content')
        ->addTab('Tab3', '#tab3content');

$tabs
        ->setTabContent('tab1content', new HtmlDiv('Tab1 content...'))
        ->setTabContent('tab2content', new HtmlDiv('Tab2 content...'))
        ->setTabContent('tab3content', new HtmlDiv('Tab3 content...'));
CODE;
$rightCard->addElement(new HtmlSpan('HtmlTabs control with three tabs (React binder)'))
                                        ->addElement(new HtmlSpan($code, '', 'block whitespace-pre-wrap bg-gray-50 rounded p-3 mt-3 text-sm'));
$right->addElement($rightCard);

$container->addElement($header)->addElement($row->addElement($left)->addElement($right));
$outer->addElement($container);

// Hidden root just to mount the binder (no visual content)
$binderRoot = new HtmlDiv('', 'react-tabs-root', 'hidden');
$page->addBody($outer->addElement($binderRoot));

// Binder JSX that wires up HtmlTabs using data-* attributes
$jsx = new HtmlCtrl('script', null, '', true);
$jsx->addProperty('type','text/babel');
$jsx->addProperty('data-presets','react');
$jsx->addProperty('src','js/react-tabs-binder.jsx');
$page->addFooter($jsx);

echo $page->toHtml();

<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use ui\controls\HtmlCtrl;
use ui\controls\web\{ HtmlPage, HtmlDiv, HtmlForm, HtmlInput, HtmlButton, HtmlTable, HtmlTr, HtmlTd, HtmlSpan, HtmlUl, HtmlLi, HtmlScript, HtmlPanel, HtmlHr };

// Page head
$page = new HtmlPage();
$page->addHeader(new HtmlCtrl('title', null, 'Web Controls Demo - Tailwind'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));
$page->addHeader(new HtmlScript('https://cdn.tailwindcss.com'));

// Styles: section card, code and panel shim to render HtmlPanel nicely
$shimCss = <<<CSS
body { background: linear-gradient(135deg, #eef4ff 0%, #f9f6ff 100%); }
.section-card { border: 1px solid rgba(0,0,0,.06); border-radius: 1rem; box-shadow: 0 8px 24px rgba(0,0,0,.06); background: #fff; }
.code { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace; background: #f8f9fa; padding: .75rem; border-radius: .5rem; display: block; }
.panel { background: #fff; border: 1px solid rgba(0,0,0,.08); border-radius: .75rem; box-shadow: 0 6px 18px rgba(0,0,0,.06); }
.panel-heading { padding: .75rem 1rem; border-bottom: 1px solid rgba(0,0,0,.06); background: #ffffff; }
.panel-title { margin: 0; font-size: 1.1rem; font-weight: 600; }
.panel-body { padding: 1rem; }
CSS;
$style = new HtmlCtrl('style', null, $shimCss);
$style->setAllowHtml(true);
$page->addHeader($style);

// Container + header
$container = new HtmlDiv('', '', 'container mx-auto py-5');
// Top navigation (Tailwind)
$topNav = new HtmlDiv('', '', 'bg-white/90 backdrop-blur sticky top-0 z-10 shadow-sm rounded mb-4');
$navInner = new HtmlDiv('', '', 'container mx-auto px-4');
$navBar = new HtmlDiv('', '', 'flex items-center justify-between h-14');
$brand = new HtmlCtrl('a', null, 'PHP PROGRAMMING Controls', true, '', 'font-semibold text-gray-800');
$brand->addProperty('href', 'landing.php');
$navLinks = new HtmlDiv('', '', 'flex items-center gap-4');
foreach ([
  ['SampleWebControls.php','Bootstrap',false],
  ['SampleWebControlsTailwind.php','Tailwind',true],
  ['SampleWebControlsReact.php','React',false],
] as [$href,$text,$active]) {
  $a = new HtmlCtrl('a', null, $text, true, '', 'text-sm px-3 py-1 rounded '.($active?'bg-indigo-600 text-white':'text-gray-700 hover:bg-gray-100'));
  $a->addProperty('href', $href);
  $navLinks->addElement($a);
}
$navBar->addElement($brand)->addElement($navLinks);
$navInner->addElement($navBar);
$topNav->addElement($navInner);
$header = new HtmlDiv('', '', 'text-center mb-5');
$header->addElement(new HtmlCtrl('h2', null, 'PHP PROGRAMMING Controls — Web Controls (Tailwind)', true, '', 'font-bold text-2xl md:text-3xl'))
       ->addElement(new HtmlCtrl('p', null, 'Buttons, lists, panels, and tables styled with Tailwind CSS', true, '', 'text-gray-600'));
$page->addBody($topNav);
$page->addBody($container->addElement($header));

// Simple Controls section
$rowSimple = new HtmlDiv('', '', 'grid grid-cols-12 gap-6');
$rowSimple->addElement((new HtmlDiv('', '', 'col-span-12'))->addElement(new HtmlCtrl('h3', null, 'Simple Controls', true, '', 'mb-3 font-semibold text-lg')));

$leftCol = new HtmlDiv('', '', 'col-span-12 md:col-span-5 lg:col-span-4');
$simpleCard = new HtmlDiv('', '', 'section-card p-4');

$btnLong = new HtmlButton('Long','','long button','longBtn','px-5 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 mr-2 mb-2');
$btnLong2 = new HtmlButton('Long','','long button','longBtn','px-5 py-3 rounded-lg text-white bg-blue-600 hover:bg-blue-700 mr-2 mb-2');
$btn1 = new HtmlButton('Regular','','regular button','longBtn','px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 mb-2');

$list1 = new HtmlUl('');
$list1->addElement(new HtmlLi('Item1'))
      ->addElement(new HtmlLi('Item2'))
      ->addElement(new HtmlLi('Item3'))
      ->addElement(new HtmlLi('Item4'));

$list2 = new HtmlUl('');
$list2->addElement(new HtmlLi('Item1','','block px-4 py-2 border rounded-t-lg'))
      ->addElement(new HtmlLi('Item2','','block px-4 py-2 border-t-0 border rounded-none'))
      ->addElement(new HtmlLi('Item3','','block px-4 py-2 border-t-0 border rounded-none'))
      ->addElement(new HtmlLi('Item4','','block px-4 py-2 border-t-0 border rounded-b-lg'));

$simpleCard->addElement(new HtmlCtrl('h5', null, 'Buttons', true, '', 'mb-3'))
           ->addElement($btnLong)->addElement($btnLong2)->addElement($btn1)
           ->addElement(new HtmlHr())
           ->addElement(new HtmlCtrl('h5', null, 'Lists', true, '', 'mt-3 mb-2'))
           ->addElement($list1)->addElement($list2);
$leftCol->addElement($simpleCard);

$simpleCtrlsCode = <<<'EOD'
A button is created like this: <br>
$btn1 = new HtmlButton('Regular','','regular button','longBtn','btn btn-default');<br>
The button parameters are: button label, onclick event, button title, button id ,css class<br><br><br>
Lists are created with: <br>
$listvar = new HtmlUl('','','list-group'); // assign a new <ul> control to $listvar, and use list-group as css class<br>
Then use ->addElement to add <li> elements to the list, like this: $listvar->addElement(new HtmlLi('Item1','','list-group-item'));
EOD;

$rightCol = new HtmlDiv('', '', 'col-span-12 md:col-span-7 lg:col-span-8');
$rightCol->addElement((new HtmlDiv('', '', 'section-card p-4'))->addElement(new HtmlSpan($simpleCtrlsCode,'','code')));
$rowSimple->addElement($leftCol)->addElement($rightCol);

// Panels section
$rowPanelsHead = new HtmlDiv('', '', 'grid grid-cols-12 gap-6 mt-6');
$rowPanelsHead->addElement((new HtmlDiv('', '', 'col-span-12'))->addElement(new HtmlCtrl('h3', null, 'Panels', true, '', 'mb-3 font-semibold text-lg')));
$row1 = new HtmlDiv('', '', 'grid grid-cols-12 gap-6');
$row2 = new HtmlDiv('', '', 'grid grid-cols-12 gap-6');

$panel = new HtmlPanel('My Panel Title', 'My Panel text content, Simple text content, but html controls can be added as well as seen below', '');
$panelcode = '$panel = new HtmlPanel(\'My Panel Title\', "Simple text content, but html controls can be added as well as seen below", \'\');<br>Above we created a HtmlPanel with a given title and content';

$panel2 = new HtmlPanel('Panel with text content as well as html controls', 'Complete the form below', '','panel panel-success');
$form = (new HtmlForm('form1','post'))->addElement((new HtmlInput('text','input1','','','border rounded px-3 py-2 w-full'))->addProperty('placeholder','Please enter your name'));
$form->addElement(new HtmlInput('submit','submit','Submit','','px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white mt-2'));
$panel2->addElement($form);

$panel2code = '$panel2 = new HtmlPanel(\'Panel with text content as well as html controls\', "Complete the form below", \'\',\'panel panel-success\');<br>';
$panel2code .= '$form = (new HtmlForm(\'form1\',\'post\'))->addElement((new HtmlInput(\'text\',\'input1\',\'\',\'\',\'form-control\'))->addProperty(\'placeholder\',\'Please enter your name\'));<br>';
$panel2code .= '$form->addElement(new HtmlInput(\'submit\',\'submit\',\'Submit\',\'\',\'btn btn-success\'));<br>';
$panel2code .= '$panel2->addElement($form);<br>';

$row1->addElement((new HtmlDiv('', '', 'col-span-12 md:col-span-5 lg:col-span-4'))->addElement($panel))
     ->addElement((new HtmlDiv('', '', 'col-span-12 md:col-span-7 lg:col-span-8'))->addElement((new HtmlDiv('', '', 'section-card p-4'))
       ->addElement(new HtmlSpan('Panel with default style, created like this: <br>'))->addElement(new HtmlSpan($panelcode,'','code'))));

$row2->addElement((new HtmlDiv('', '', 'col-span-12 md:col-span-5 lg:col-span-4'))->addElement($panel2))
     ->addElement((new HtmlDiv('', '', 'col-span-12 md:col-span-7 lg:col-span-8'))->addElement((new HtmlDiv('', '', 'section-card p-4'))
       ->addElement(new HtmlSpan('Panel with success style, and html controls, created like this: <br>'))->addElement(new HtmlSpan($panel2code,'','code'))));

// Tables section
$tableHead = new HtmlDiv('', '', 'grid grid-cols-12 gap-6 mt-6');
$tableHead->addElement((new HtmlDiv('', '', 'col-span-12'))->addElement(new HtmlCtrl('h3', null, 'Tables', true, '', 'mb-3 font-semibold text-lg')));

$table = new HtmlTable("100%","","","min-w-full bg-white rounded shadow-sm");
$scoredata = array_map('str_getcsv', str_getcsv(file_get_contents('scores.txt'),"\n"));
$first = true; // to make the first row a header
foreach($scoredata as $score) {
    $table->addElement((new HtmlTr($first))
        ->addElement((new HtmlTd())->addElement(new HtmlSpan($score[0])))
        ->addElement((new HtmlTd())->addElement(new HtmlSpan($score[1])))
        ->addElement((new HtmlTd())->addElement(new HtmlSpan($score[2]))));
    $first = false;
}

$tableCode = <<<'EOD'
$table = new HtmlTable("100%","","","table");<br>
$scoredata = array_map('str_getcsv', str_getcsv(file_get_contents('scores.txt'),"\n"));<br>
$first = true; // to make the first row a header<br>
foreach($scoredata as $score) { ... }<br>
EOD;

$tableRow = new HtmlDiv('', '', 'grid grid-cols-12 gap-6');
$tableRow->addElement((new HtmlDiv('', '', 'col-span-12 md:col-span-5 lg:col-span-4'))->addElement($table))
         ->addElement((new HtmlDiv('', '', 'col-span-12 md:col-span-7 lg:col-span-8'))->addElement((new HtmlDiv('', '', 'section-card p-4'))
           ->addElement(new HtmlSpan('HtmlTable populated from data in a csv file'))->addElement(new HtmlSpan($tableCode,'','code'))));

// Assemble all sections
$container->addElement($rowSimple)
          ->addElement($rowPanelsHead)->addElement($row1)->addElement($row2)
          ->addElement($tableHead)->addElement($tableRow);

$page->addBody($container);

echo $page->toHtml();
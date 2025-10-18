<?php
/**
 *
 * MIT License
 *
 * Copyright 2025 Fernando M. (https://github.com/ferndev)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * SampleWebControls.php
 * Description: Sample of some php html controls.
 * These components are not dependent on any php framework, but can be used with any framework, either directly or easily adapted to fit any special usage requirement of any framework.
 * They are not dependent on a particular frontend framework either, but in this sample bootstrap is used. You can easily use them with any frontend library.
 *
 */
require __DIR__ . '/../vendor/autoload.php';

use ui\controls\HtmlCtrl;
use ui\controls\web\{ HtmlPage, HtmlLink, HtmlScript, HtmlHyperLink };
use ui\controls\web\HtmlTable, ui\controls\web\HtmlTr, ui\controls\web\HtmlTd;
use ui\controls\web\HtmlForm;
use ui\controls\web\HtmlInput, ui\controls\web\HtmlSpan;
use ui\controls\web\HtmlDiv, ui\controls\web\HtmlPanel;
use ui\controls\web\HtmlHr, ui\controls\web\HtmlButton, ui\controls\web\HtmlUl, ui\controls\web\HtmlLi;

// Build page head with Bootstrap 5
$page = new HtmlPage();
$page->addHeader(new HtmlCtrl('title', null, 'Web Controls Demo - Bootstrap'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));
$bsCss = new HtmlLink('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
$bsCss->addProperty('integrity','sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN')->addProperty('crossorigin','anonymous');
$page->addHeader($bsCss);
$faCss = new HtmlLink('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');
$faCss->addProperty('integrity','sha384-PPIZEGYM1v8zp5Py7UjFb79S58UeqCL9pYVnVPURKEqvioPROaVAJKKLzvH2rDnI')->addProperty('crossorigin','anonymous');
$page->addHeader($faCss);

// Light styles and panel shim -> card look
$shimCss = <<<CSS
body { background: linear-gradient(135deg, #eef4ff 0%, #f9f6ff 100%); }
.section-card { border: 1px solid rgba(0,0,0,.06); border-radius: 1rem; box-shadow: 0 8px 24px rgba(0,0,0,.06); background: #fff; }
.code { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace; background: #f8f9fa; padding: .75rem; border-radius: .5rem; display: block; }
/* Bootstrap 3 panel shim */
.panel { background: #fff; border: 1px solid rgba(0,0,0,.08); border-radius: .75rem; box-shadow: 0 6px 18px rgba(0,0,0,.06); }
.panel-heading { padding: .75rem 1rem; border-bottom: 1px solid rgba(0,0,0,.06); background: #ffffff; }
.panel-title { margin: 0; font-size: 1.1rem; font-weight: 600; }
.panel-body { padding: 1rem; }
CSS;
$style = new HtmlCtrl('style', null, $shimCss);
$style->setAllowHtml(true);
$page->addHeader($style);

// Container shell
$container = new HtmlDiv('', '', 'container py-5');
$topNav = new HtmlDiv('', '', 'navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4 rounded');
$navContainer = new HtmlDiv('', '', 'container');
$brand = new HtmlHyperLink('<i class="fas fa-code me-2"></i> PHP PROGRAMMING Controls', 'landing.php', '', '', '', 'navbar-brand');
$brand->setAllowHtml(true);
$toggler = new HtmlButton('', '', '', '', 'navbar-toggler');
$toggler->addProperty('type', 'button')
        ->addProperty('data-bs-toggle', 'collapse')
        ->addProperty('data-bs-target', '#wcNav')
        ->addElement(new HtmlSpan('', '', 'navbar-toggler-icon'));
$navCollapse = new HtmlDiv('', 'wcNav', 'collapse navbar-collapse');
$navList = new HtmlDiv('', '', 'navbar-nav ms-auto');
$navItems = [
    ['SampleWebControls.php', 'Bootstrap', true],
    ['SampleWebControlsTailwind.php', 'Tailwind', false],
    ['SampleWebControlsReact.php', 'React', false],
];
foreach ($navItems as [$href, $text, $active]) {
    $li = new HtmlDiv('', '', 'nav-item');
    $cls = 'nav-link' . ($active ? ' active fw-semibold' : '');
    $link = new HtmlHyperLink($text, $href, '', '', '', $cls);
    $li->addElement($link);
    $navList->addElement($li);
}
$navCollapse->addElement($navList);
$navContainer->addElement($brand)->addElement($toggler)->addElement($navCollapse);
$topNav->addElement($navContainer);
$header = new HtmlDiv('', '', 'text-center mb-5');
$header->addElement(new HtmlCtrl('h2', null, 'PHP PROGRAMMING Controls — Web Controls (Bootstrap)', true, '', 'fw-bold'))
       ->addElement(new HtmlCtrl('p', null, 'Buttons, lists, panels, and tables with Bootstrap 5', true, '', 'text-muted'));
$page->addBody($topNav);
$page->addBody($container->addElement($header));
// <--------- This section demonstrate how to use a few simple Html Controls --------->

// Simple Controls Section
$rowSimpleCtrlsSection = new HtmlDiv('', '', 'row');
$rowSimpleCtrlsSection->addElement((new HtmlDiv('', '', 'col-12'))->addElement(new HtmlCtrl('h3', null, 'Simple Controls', true, '', 'mb-3')));
$rowCtrls1 = new HtmlDiv('', '', 'row');
$rowCtrls2 = new HtmlDiv('', '', 'row');
$divMd4 = new HtmlDiv('', '', 'col-md-5 col-lg-4'); // container for simple controls
// buttons
$btnLong = new HtmlButton('Long','','long button','longBtn','btn btn-lg btn-outline-secondary me-2 mb-2');
$btnLong2 = new HtmlButton('Long','','long button','longBtn','btn btn-lg btn-primary me-2 mb-2');
$btn1 = new HtmlButton('Regular','','regular button','longBtn','btn btn-outline-secondary mb-2');
// lists
$list1 = new HtmlUl('');
  // add 4 <li> items to the list
$list1->addElement(new HtmlLi('Item1'))->addElement(new HtmlLi('Item2'))->addElement(new HtmlLi('Item3'))->addElement(new HtmlLi('Item4'));
$list2 = new HtmlUl('','','list-group'); // specify the css class to use on this second list
 // add 4 <li> items to this second list, and also specify the css class to use
$list2->addElement(new HtmlLi('Item1','','list-group-item'))
    ->addElement(new HtmlLi('Item2','','list-group-item'))
    ->addElement(new HtmlLi('Item3','','list-group-item'))
    ->addElement(new HtmlLi('Item4','','list-group-item'));
// add the above controls to the div
$simpleCard = new HtmlDiv('', '', 'section-card p-3 mb-4');
$simpleCard->addElement(new HtmlCtrl('h5', null, 'Buttons', true, '', 'mb-3'))
                     ->addElement($btnLong)->addElement($btnLong2)->addElement($btn1)
                     ->addElement(new HtmlHr())
                     ->addElement(new HtmlCtrl('h5', null, 'Lists', true, '', 'mt-3 mb-2'))
                     ->addElement($list1)->addElement($list2);
$divMd4->addElement($simpleCard);

$simpleCtrlsCode = <<<'EOD'
A button is created like this: <br>
$btn1 = new HtmlButton('Regular','','regular button','longBtn','btn btn-default');<br>
The button parameters are: button label, onclick event, button title, button id ,css class<br><br><br>
Lists are created with: <br>
$listvar = new HtmlUl('','','list-group'); // assign a new <ul> control to $listvar, and use list-group as css class<br>
Then use ->addElement to add <li> elements to the list, like this: $listvar->addElement(new HtmlLi('Item1','','list-group-item'));
EOD;
$rowCtrls1->addElement($divMd4)->addElement((new HtmlDiv('', '', 'col-md-7 col-lg-8'))
    ->addElement((new HtmlDiv('', '', 'section-card p-3'))->addElement(new HtmlSpan($simpleCtrlsCode,'','code'))));
// <--------- This section demonstrate how to use HtmlPanel --------->
// Panels have a title and content. Their content can be simple text or one or more html controls (children)
$panel = new HtmlPanel('My Panel Title', "My Panel text content, Simple text content, but html controls can be added as well as seen below", '');
$panelcode = '$panel = new HtmlPanel(\'My Panel Title\', "Simple text content, but html controls can be added as well as seen below", \'\');<br>Above we created a HtmlPanel with a given title and content';

$rowPanelSection = (new HtmlDiv('', '', 'row'))->addElement((new HtmlDiv('', '', 'col-12'))->addElement(new HtmlCtrl('h3', null, 'Panels', true, '', 'mb-3')));
$row1 = new HtmlDiv('', '', 'row');
$row2 = new HtmlDiv('', '', 'row');
$panel2 = new HtmlPanel('Panel with text content as well as html controls', "Complete the form below", '','panel panel-success');
$form = (new HtmlForm('form1','post'))->addElement((new HtmlInput('text','input1','','','form-control'))->addProperty('placeholder','Please enter your name'));
$form->addElement(new HtmlInput('submit','submit','Submit','','btn btn-success'));
$panel2->addElement($form);
$panel2code = '$panel2 = new HtmlPanel(\'Panel with text content as well as html controls\', "Complete the form below", \'\',\'panel panel-success\');<br>';
$panel2code .= '$form = (new HtmlForm(\'form1\',\'post\'))->addElement((new HtmlInput(\'text\',\'input1\',\'\',\'\',\'form-control\'))->addProperty(\'placeholder\',\'Please enter your name\'));<br>';
$panel2code .= '$form->addElement(new HtmlInput(\'submit\',\'submit\',\'Submit\',\'\',\'btn btn-success\'));<br>';
$panel2code .= '$panel2->addElement($form);<br><hr>';
$panel2code .= 'Notice above how we have chained the creation of the form and its elements. This makes the code more compact but perhaps more difficult to understand and hence, maintain.<br>';
$panel2code .= 'You can also achieve the same in several steps:<br>';
$panel2code .= '$form = new HtmlForm(\'form1\',\'post\');<br>';
$panel2code .= '$input = new HtmlInput(\'text\',\'input1\',\'\',\'\',\'form-control\');<br>';
$panel2code .= '$input->addProperty(\'placeholder\',\'Please enter your name\');<br>';
$panel2code .= '$form->addElement($input);<br>';
$panel2code .= '$submit = new HtmlInput(\'submit\',\'submit\',\'Submit\',\'\',\'btn btn-success\');<br>';
$panel2code .= '$form->addElement($submit);<br>';
$panel2code .= '$panel2->addElement($form);<br><br>';
$panel2code .= 'When you create a form and its elements or other composite of elements such as HtmlDiv elements inside other HtmlDiv elements (like in the HtmlPanel control) you are first building or preparing them, but not executing or rendering them.<br>';
$panel2code .= 'In order to actually send this as output to the browser, you call the ->toHtml() method in your outermost element, which in the code above would be $panel2.<br>';
$panel2code .= 'If, for instance, your form or panel were, in turn, inside a HtmlDiv, HtmlPanel, HtmlTable or other control, then you would just call the toHtml() method on that control, and the form will still be displayed in the browser<br>';
$row1->addElement((new HtmlDiv('', '', 'col-md-5 col-lg-4'))->addElement($panel))
         ->addElement((new HtmlDiv('', '', 'col-md-7 col-lg-8'))->addElement((new HtmlDiv('', '', 'section-card p-3'))
             ->addElement(new HtmlSpan('Panel with default style, created like this: <br>'))->addElement(new HtmlSpan($panelcode,'','code'))));
$row2->addElement((new HtmlDiv('', '', 'col-md-5 col-lg-4'))->addElement($panel2))
         ->addElement((new HtmlDiv('', '', 'col-md-7 col-lg-8'))->addElement((new HtmlDiv('', '', 'section-card p-3'))
             ->addElement(new HtmlSpan('Panel with bootstrap\'s success style, and html controls, created like this: <br>'))->addElement(new HtmlSpan($panel2code,'','code'))));


// <--------- This section demonstrate how to use HtmlTable --------->
$table = new HtmlTable("100%","","","table table-striped table-hover align-middle");
$scoredata = array_map('str_getcsv', str_getcsv(file_get_contents('scores.txt'),"\n"));
$first = true; // to make the first row a header
foreach($scoredata as $score) {
    $table->addElement((new HtmlTr($first))
        ->addElement((new HtmlTd())->addElement(new HtmlSpan($score[0])))
        ->addElement((new HtmlTd())->addElement(new HtmlSpan($score[1])))
        ->addElement((new HtmlTd())->addElement(new HtmlSpan($score[2]))));
    $first = false;
}

$tablecode = <<<'EOD'
$table = new HtmlTable("100%","","","table");<br>
$scoredata = array_map('str_getcsv', str_getcsv(file_get_contents('scores.txt'),"\n"));<br>
$first = true; // to make the first row a header<br>
foreach($scoredata as $score) {<br>
    $table->addElement((new HtmlTr($first))<br>
        ->addElement((new HtmlTd())->addElement(new HtmlSpan($score[0])))<br>
        ->addElement((new HtmlTd())->addElement(new HtmlSpan($score[1])))<br>
        ->addElement((new HtmlTd())->addElement(new HtmlSpan($score[2]))));<br>
    $first = false;<br>
}<br>
EOD;

$row3 = new HtmlDiv('', '', 'row');
$row3->addElement((new HtmlDiv('', '', 'col-md-5 col-lg-4'))->addElement($table))
         ->addElement((new HtmlDiv('', '', 'col-md-7 col-lg-8'))->addElement((new HtmlDiv('', '', 'section-card p-3'))
             ->addElement(new HtmlSpan('HtmlTable populated from data in a csv file'))->addElement(new HtmlSpan($tablecode,'','code'))));
$rowTableSection = (new HtmlDiv('', '', 'row'))->addElement((new HtmlDiv('', '', 'col-12'))->addElement(new HtmlCtrl('h3', null, 'Tables', true, '', 'mb-3')));

// Assemble into container
$container->addElement($rowSimpleCtrlsSection)->addElement($rowCtrls1)
                    ->addElement($rowPanelSection)->addElement($row1)->addElement($row2)
                    ->addElement($rowTableSection)->addElement($row3);

// Footer scripts
$bsJs = new HtmlScript('');
$bsJs->addProperty('src','https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js')
    ->addProperty('integrity','sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL')
    ->addProperty('crossorigin','anonymous');
$page->addFooter($bsJs);

echo $page->toHtml();

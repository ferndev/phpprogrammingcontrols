<?php
/*
 * SamplePageWithImgAndHtmlArea.php
 * Copyright 2025 Fernando M. (https://github.com/ferndev)
 *
 * Description: HtmlPage with an image and a textarea, modernized to show the control on the left and the code on the right.
 */
require __DIR__ . '/../vendor/autoload.php';

use ui\controls\HtmlCtrl;
use ui\controls\web\{ HtmlPage, HtmlLink, HtmlScript };
use ui\controls\web\{ HtmlDiv, HtmlImg, HtmlSpan };

$page = new HtmlPage();
$page->addHeader(new HtmlCtrl('title', null, 'PHP PROGRAMMING Controls — Image + Text Area (Bootstrap)'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));

// Bootstrap 5 CSS + Font Awesome (SRI)
$bsCss = new HtmlLink('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
$bsCss->addProperty('integrity','sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN')->addProperty('crossorigin','anonymous');
$page->addHeader($bsCss);
$faCss = new HtmlLink('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');
$faCss->addProperty('integrity','sha384-PPIZEGYM1v8zp5Py7UjFb79S58UeqCL9pYVnVPURKEqvioPROaVAJKKLzvH2rDnI')->addProperty('crossorigin','anonymous');
$page->addHeader($faCss);

// Light styles and card shim
$shimCss = <<<CSS
body { background: linear-gradient(135deg, #eef4ff 0%, #f9f6ff 100%); }
.section-card { border: 1px solid rgba(0,0,0,.06); border-radius: 1rem; box-shadow: 0 8px 24px rgba(0,0,0,.06); background: #fff; }
.code { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace; background: #f8f9fa; padding: .75rem; border-radius: .5rem; display: block; }
CSS;
$style = new HtmlCtrl('style', null, $shimCss);
$style->setAllowHtml(true);
$page->addHeader($style);

// Container and header
$container = new HtmlDiv('', '', 'container py-5');
$header = new HtmlDiv('', '', 'text-center mb-5');
$header->addElement(new HtmlCtrl('h2', null, 'PHP PROGRAMMING Controls — Image + Text Area (Bootstrap)', true, '', 'fw-bold'))
       ->addElement(new HtmlCtrl('p', null, 'A simple image and textarea demo', true, '', 'text-muted'));

$page->addBody($container->addElement($header));

// Left: image + textarea; Right: code explanation
$row = new HtmlDiv('', '', 'row');

$left = new HtmlDiv('', '', 'col-md-5 col-lg-4');
$img = new HtmlImg('img/buddy-face-small.png', 'The nicest friend :)', '', 'img-fluid rounded shadow-sm mb-3');

// Textarea control with Bootstrap styles
$ta = new \ui\controls\web\HtmlTextArea('about','5','80');
$ta->addProperty('class','form-control')->addProperty('placeholder','Write about your dog');

$left->addElement($img)->addElement($ta);

$code = <<<'EOD'
$img = new HtmlImg('img/buddy-face-small.png','The nicest friend :)','', 'img-fluid rounded shadow-sm mb-3');<br>
$ta = new HtmlTextArea('about','5','80');<br>
$ta->addProperty('class','form-control')->addProperty('placeholder','Write about your dog');<br>
EOD;

$right = new HtmlDiv('', '', 'col-md-7 col-lg-8');
$rightCard = new HtmlDiv('', '', 'section-card p-3');
$rightCard->addElement(new HtmlSpan('HtmlImg with a Bootstrap-styled HtmlTextArea'))
          ->addElement(new HtmlSpan($code,'','code'));
$right->addElement($rightCard);

$row->addElement($left)->addElement($right);
$rowSection = (new HtmlDiv('', '', 'row'))->addElement((new HtmlDiv('', '', 'col-12'))->addElement(new HtmlCtrl('h3', null, 'Image + Text Area', true, '', 'mb-3')));

$container->addElement($rowSection)->addElement($row);

// Footer scripts (Bootstrap bundle)
$bsJs = new HtmlScript('');
$bsJs->addProperty('src','https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js')
     ->addProperty('integrity','sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL')
     ->addProperty('crossorigin','anonymous');
$page->addFooter($bsJs);

echo $page->toHtml();
?>

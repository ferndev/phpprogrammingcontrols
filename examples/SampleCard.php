<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use ui\controls\HtmlCtrl;
use ui\controls\web\{ HtmlPage, HtmlLink, HtmlScript };
use ui\controls\web\{ HtmlDiv, HtmlSpan, HtmlCard };

$page = new HtmlPage();
$page->addHeader(new HtmlCtrl('title', null, 'PHP PROGRAMMING Controls — HtmlCard (Bootstrap)'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));
$bsCss = new HtmlLink('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
$bsCss->addProperty('integrity','sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN')->addProperty('crossorigin','anonymous');
$page->addHeader($bsCss);
$faCss = new HtmlLink('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');
$faCss->addProperty('integrity','sha384-PPIZEGYM1v8zp5Py7UjFb79S58UeqCL9pYVnVPURKEqvioPROaVAJKKLzvH2rDnI')->addProperty('crossorigin','anonymous');
$page->addHeader($faCss);

$shimCss = <<<CSS
body { background: linear-gradient(135deg, #eef4ff 0%, #f9f6ff 100%); }
.section-card { border: 1px solid rgba(0,0,0,.06); border-radius: 1rem; box-shadow: 0 8px 24px rgba(0,0,0,.06); background: #fff; }
.code { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace; background: #f8f9fa; padding: .75rem; border-radius: .5rem; display: block; }
CSS;
$style = new HtmlCtrl('style', null, $shimCss);
$style->setAllowHtml(true);
$page->addHeader($style);

$container = new HtmlDiv('', '', 'container py-5');
$header = new HtmlDiv('', '', 'text-center mb-5');
$header->addElement(new HtmlCtrl('h2', null, 'PHP PROGRAMMING Controls — HtmlCard (Bootstrap)', true, '', 'fw-bold'))
       ->addElement(new HtmlCtrl('p', null, 'Bootstrap-like card control', true, '', 'text-muted'));
$page->addBody($container->addElement($header));

// Left: card; Right: code snippet
$row = new HtmlDiv('', '', 'row');
$left = new HtmlDiv('', '', 'col-md-5 col-lg-4');

$card = new HtmlCard();
$card
  ->addTopImage('https://picsum.photos/seed/phpcontrols/600/300', 'Random image')
  ->addHeader('Featured')
  ->addTitle('HtmlCard Title')
  ->addSubTitle('Card subtitle')
  ->addText('Some quick example text to build on the card title and make up the bulk of the card \ncontent.')
  ->addLink('#', 'Card link')
  ->addLink('#', 'Another link')
  ->addFooter('2 days ago');

$left->addElement($card);

$code = <<<'EOD'
$card = new HtmlCard();<br>
$card->addTopImage('https://picsum.photos/seed/phpcontrols/600/300', 'Random image')<br>
     ->addHeader('Featured')<br>
     ->addTitle('HtmlCard Title')<br>
     ->addSubTitle('Card subtitle')<br>
     ->addText('Some quick example text...')<br>
     ->addLink('#', 'Card link')<br>
     ->addLink('#', 'Another link')<br>
     ->addFooter('2 days ago');
EOD;

$right = new HtmlDiv('', '', 'col-md-7 col-lg-8');
$rightCard = new HtmlDiv('', '', 'section-card p-3');
$rightCard->addElement(new HtmlSpan('HtmlCard control example'))
          ->addElement(new HtmlSpan($code,'','code'));
$right->addElement($rightCard);

$row->addElement($left)->addElement($right);
$rowSection = (new HtmlDiv('', '', 'row'))->addElement((new HtmlDiv('', '', 'col-12'))->addElement(new HtmlCtrl('h3', null, 'Card', true, '', 'mb-3')));
$container->addElement($rowSection)->addElement($row);

$bsJs = new HtmlScript('');
$bsJs->addProperty('src','https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js')
     ->addProperty('integrity','sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL')
     ->addProperty('crossorigin','anonymous');
$page->addFooter($bsJs);

echo $page->toHtml();

<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use ui\controls\web\{
    HtmlPage, HtmlDiv, HtmlH1, HtmlH2, HtmlH3, HtmlP, HtmlButton, 
    HtmlLink, HtmlScript, HtmlImg, HtmlSpan, HtmlUl, HtmlLi,
    HtmlPanel, HtmlTable, HtmlTr, HtmlTd, HtmlHyperLink, HtmlHr
};
use ui\controls\HtmlCtrl; // For inline <style> and <script> elements

// Create the main page structure
$page = new HtmlPage();

// Add Bootstrap 5 CSS from CDN (aligns with Bootstrap JS below) and dependencies
$bsCss = new HtmlLink('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
$bsCss->addProperty('integrity','sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN')->addProperty('crossorigin','anonymous');
$page->addHeader($bsCss);
$faCss = new HtmlLink('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');
$faCss->addProperty('integrity','sha384-PPIZEGYM1v8zp5Py7UjFb79S58UeqCL9pYVnVPURKEqvioPROaVAJKKLzvH2rDnI')->addProperty('crossorigin','anonymous');
$page->addHeader($faCss);
// Viewport meta for responsive layouts
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));
// Page title
$page->addHeader(new HtmlCtrl('title', null, 'PHP PROGRAMMING Controls - Landing'));
// Bootstrap bundle JS
$bsJs = new HtmlScript('');
$bsJs->addProperty('src','https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js')
    ->addProperty('integrity','sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL')
    ->addProperty('crossorigin','anonymous');
$page->addFooter($bsJs);

// Custom styles for the landing page
// Custom styles for the landing page (inline <style>)
$customCss = <<<CSS
/* Layout helpers */
body { padding-top: 70px; }
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 100px 0 80px;
    text-align: center;
}
.feature-card { transition: transform .3s ease; height: 100%; }
.feature-card:hover { transform: translateY(-5px); }
.demo-card { border: none; box-shadow: 0 4px 6px rgba(0,0,0,.08); transition: all .25s ease; }
.demo-card:hover { box-shadow: 0 10px 28px rgba(0,0,0,.12); transform: translateY(-3px); }
.control-showcase { background: #f8f9fa; padding: 60px 0; }
.framework-section { background: #fff; padding: 80px 0; }
.navbar-brand { font-weight: 700; font-size: 1.25rem; letter-spacing: .2px; }
.btn-gradient { background: linear-gradient(45deg, #667eea, #764ba2); border: none; color: #fff; }
.btn-gradient:hover { background: linear-gradient(45deg, #5a6fd8, #6a4190); color: #fff; }
CSS;

$styleTag = new HtmlCtrl('style', null, $customCss);
$styleTag->setAllowHtml(true);
$page->addHeader($styleTag);

// Navigation Bar
$navbar = new HtmlDiv('', '', 'navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm');
// Build navbar structure to avoid sanitizer limitations
$navbarContainer = new HtmlDiv('', '', 'container');
$brand = new \ui\controls\web\HtmlHyperLink('<i class="fas fa-code me-2"></i> PHP PROGRAMMING Controls', '#', '', '', '', 'navbar-brand');
$brand->setAllowHtml(true);
$toggler = new HtmlButton('', '', '', '', 'navbar-toggler');
$toggler->addProperty('type', 'button')->addProperty('data-bs-toggle', 'collapse')->addProperty('data-bs-target', '#navbarNav')->addElement(new HtmlSpan('', '', 'navbar-toggler-icon'));
$navCollapse = new HtmlDiv('', 'navbarNav', 'collapse navbar-collapse');
$navUl = new HtmlDiv('', '', 'navbar-nav ms-auto');
// Create nav items
foreach ([
    ['#features', 'Features'],
    ['#demos', 'Demos'],
    ['#frameworks', 'Frameworks'],
    ['#getting-started', 'Get Started']
] as [$href, $text]) {
    $li = new HtmlDiv('', '', 'nav-item');
    $link = new \ui\controls\web\HtmlHyperLink($text, $href, '', '', '', 'nav-link');
    $li->addElement($link);
    $navUl->addElement($li);
}
$navCollapse->addElement($navUl);
$navbarContainer->addElement($brand)->addElement($toggler)->addElement($navCollapse);
$navbar->addElement($navbarContainer);

// Hero Section
$heroSection = new HtmlDiv('', '', 'hero-section');
$heroContent = new HtmlDiv('', '', 'container');
$heroContent->addElement(new HtmlH1('PHP PROGRAMMING Controls Library', '', 'display-4 fw-bold mb-4'))
           ->addElement(new HtmlP('Modern, secure, and flexible HTML control library for PHP 8.0+', '', 'lead mb-5'));
// Proper row/col nesting for CTA buttons
$row = new HtmlDiv('', '', 'row justify-content-center');
$col = new HtmlDiv('', '', 'col-md-8');
$cta = new HtmlDiv('<a href="#demos" class="btn btn-gradient btn-lg me-3"><i class="fas fa-rocket"></i> View Demos</a>
<a href="https://github.com/ferndev/phpprogrammingcontrols" class="btn btn-outline-light btn-lg"><i class="fab fa-github"></i> GitHub</a>', '', '');
$cta->setAllowHtml(true);
$col->addElement($cta);
$row->addElement($col);
$heroContent->addElement($row);
$heroSection->addElement($heroContent);

// Features Section
$featuresSection = new HtmlDiv('', 'features', 'container py-5');
$featuresSection->addElement(new HtmlDiv('', '', 'text-center mb-5'))
               ->addElement(new HtmlH2('Key Features', '', 'display-5 fw-bold'))
               ->addElement(new HtmlP('Everything you need for modern web development', '', 'lead text-muted'));

$featuresRow = new HtmlDiv('', '', 'row g-4');

$features = [
    [
        'icon' => 'fas fa-shield-alt',
        'title' => 'XSS Protection',
        'description' => 'Automatic HTML sanitization and XSS protection built-in. Smart detection of safe HTML vs dangerous content.'
    ],
    [
        'icon' => 'fas fa-code',
        'title' => 'PHP 8.0+ Ready',
        'description' => 'Modern PHP features: strict types, match expressions, named parameters, and more.'
    ],
    [
        'icon' => 'fas fa-mobile-alt',
        'title' => 'Framework Agnostic',
        'description' => 'Works with Bootstrap, Tailwind CSS, or any CSS framework. Flexible and customizable.'
    ],
    [
        'icon' => 'fas fa-puzzle-piece',
        'title' => 'Fluent Interface',
        'description' => 'Chain method calls for cleaner, more readable code. Object-oriented design patterns.'
    ],
    [
        'icon' => 'fas fa-database',
        'title' => 'JSON Serializable',
        'description' => 'All controls can be exported to JSON for API responses or client-side rendering.'
    ],
    [
        'icon' => 'fas fa-check-circle',
        'title' => 'Type Safe',
        'description' => 'Full type declarations throughout. Catch errors at development time, not runtime.'
    ]
];

foreach ($features as $feature) {
    $featureCard = new HtmlDiv('', '', 'col-md-4');
    $card = new HtmlDiv('', '', 'card feature-card h-100 border-0 shadow-sm');
    $cardBody = new HtmlDiv('', '', 'card-body text-center p-4');
    $icon = new HtmlDiv('<i class="' . $feature['icon'] . ' fa-3x text-primary"></i>', '', 'mb-3');
    $icon->setAllowHtml(true);
    $cardBody->addElement($icon)
             ->addElement(new HtmlH3($feature['title'], '', 'h5 card-title fw-bold'))
             ->addElement(new HtmlP($feature['description'], '', 'card-text text-muted'));
    $card->addElement($cardBody);
    $featureCard->addElement($card);
    $featuresRow->addElement($featureCard);
}

$featuresSection->addElement($featuresRow);

// Control Showcase Section
$showcaseSection = new HtmlDiv('', '', 'control-showcase');
$showcaseContainer = new HtmlDiv('', '', 'container');
$showcaseContainer->addElement(new HtmlDiv('', '', 'text-center mb-5'))
                 ->addElement(new HtmlH2('Live Control Showcase', '', 'display-5 fw-bold'))
                 ->addElement(new HtmlP('See the controls in action', '', 'lead text-muted'));

// Create a live demo panel
$demoPanel = new HtmlPanel('Interactive Demo', 'Try out our controls right here!', '', 'panel panel-primary');
$demoPanel->addElement(new HtmlDiv('', '', 'mt-3'))
          ->addElement(new HtmlButton('Primary Button', 'alert("Button clicked!")', 'Demo Button', 'demo-btn', 'btn btn-primary me-2'))
          ->addElement(new HtmlButton('Success', '', 'Success Button', '', 'btn btn-success me-2'))
          ->addElement(new HtmlButton('Warning', '', 'Warning Button', '', 'btn btn-warning'));

$showcaseContainer->addElement($demoPanel);
$showcaseSection->addElement($showcaseContainer);

// Demos Section
$demosSection = new HtmlDiv('', 'demos', 'container py-5');
$demosSection->addElement(new HtmlDiv('', '', 'text-center mb-5'))
            ->addElement(new HtmlH2('Interactive Demos', '', 'display-5 fw-bold'))
            ->addElement(new HtmlP('Explore our comprehensive examples', '', 'lead text-muted'));

$demosRow = new HtmlDiv('', '', 'row g-4');

$demos = [
    [
        'title' => 'Form Controls',
        'description' => 'Complete form with validation, inputs, selects, and checkboxes',
        'icon' => 'fas fa-wpforms',
        'file' => 'SamplePageWithLoginForm.php',
        'color' => 'primary'
    ],
    [
        'title' => 'Data Tables',
        'description' => 'Responsive tables with sorting and interactive elements',
        'icon' => 'fas fa-table',
        'file' => 'SampleDataTable.php',
        'color' => 'success'
    ],
    [
        'title' => 'UI Components',
        'description' => 'Panels, navigation, images, and layout components',
        'icon' => 'fas fa-cubes',
        'file' => 'SampleWebControls.php',
        'color' => 'info'
    ],
    [
        'title' => 'Select Controls',
        'description' => 'Dropdown menus and selection components',
        'icon' => 'fas fa-list',
        'file' => 'SampleHtmlSelect.php',
        'color' => 'warning'
    ]
];

foreach ($demos as $demo) {
    $demoCard = new HtmlDiv('', '', 'col-md-6 col-lg-3');
    $card = new HtmlDiv('', '', 'card demo-card h-100');
    $cardBody = new HtmlDiv('', '', 'card-body text-center');
    $iconDiv = new HtmlDiv('<i class="' . $demo['icon'] . ' fa-3x text-' . $demo['color'] . '"></i>', '', 'mb-3');
    $iconDiv->setAllowHtml(true);
    $cardBody->addElement($iconDiv)
             ->addElement(new HtmlH3($demo['title'], '', 'h5 card-title'))
             ->addElement(new HtmlP($demo['description'], '', 'card-text text-muted'));
    $viewLink = new HtmlHyperLink('<i class="fas fa-eye"></i> View Demo', $demo['file'], '', '', '', 'btn btn-' . $demo['color'] . ' btn-sm');
    $viewLink->setAllowHtml(true);
    $cardBody->addElement($viewLink);
    $card->addElement($cardBody);
    $demoCard->addElement($card);
    $demosRow->addElement($demoCard);
}

$demosSection->addElement($demosRow);

// Framework Versions Section
$frameworkSection = new HtmlDiv('', 'frameworks', 'framework-section');
$frameworkContainer = new HtmlDiv('', '', 'container');
$frameworkContainer->addElement(new HtmlDiv('', '', 'text-center mb-5'))
                  ->addElement(new HtmlH2('Multi-Framework Support', '', 'display-5 fw-bold'))
                  ->addElement(new HtmlP('Same demos, different frameworks', '', 'lead text-muted'));

$frameworkTable = new HtmlTable('100%', '', 'framework-table', 'table table-striped table-hover');
$headerRow = new HtmlTr(true);
$headerRow->addElement((new HtmlTd(false, '', '', '', '', 'fw-bold'))->addElement(new HtmlSpan('Demo')))
          ->addElement((new HtmlTd(false, '', '', '', '', 'fw-bold'))->addElement(new HtmlSpan('Bootstrap 5')))
          ->addElement((new HtmlTd(false, '', '', '', '', 'fw-bold'))->addElement(new HtmlSpan('Tailwind CSS')))
          ->addElement((new HtmlTd(false, '', '', '', '', 'fw-bold'))->addElement(new HtmlSpan('React.js')));
$frameworkTable->addElement($headerRow);

$frameworkDemos = [
    ['name' => 'Login Form', 'base' => 'SamplePageWithLoginForm'],
    ['name' => 'Web Controls', 'base' => 'SampleWebControls'],
    ['name' => 'Tabs Example', 'base' => 'TabsExample'],
    ['name' => 'Image and HtmlArea', 'base' => 'SamplePageWithImgAndHtmlArea']

];

foreach ($frameworkDemos as $demo) {
    $row = new HtmlTr();
    $row->addElement((new HtmlTd(false, '', '', '', '', 'fw-medium'))->addElement(new HtmlSpan($demo['name'])))
        ->addElement((new HtmlTd())->addElement(new HtmlSpan('<a href="' . $demo['base'] . '.php" class="btn btn-primary btn-sm"><i class="fab fa-bootstrap"></i> View</a>', '', '', true)))
        ->addElement((new HtmlTd())->addElement(new HtmlSpan('<a href="' . $demo['base'] . 'Tailwind.php" class="btn btn-cyan btn-sm"><i class="fas fa-wind"></i> View</a>', '', '', true)))
        ->addElement((new HtmlTd())->addElement(new HtmlSpan('<a href="' . $demo['base'] . 'React.php" class="btn btn-info btn-sm"><i class="fab fa-react"></i> View</a>', '', '', true)));
    $frameworkTable->addElement($row);
}

$frameworkContainer->addElement($frameworkTable);
$frameworkSection->addElement($frameworkContainer);

// Getting Started Section
$gettingStartedSection = new HtmlDiv('', 'getting-started', 'container py-5');
$gettingStartedSection->addElement(new HtmlDiv('', '', 'text-center mb-5'))
                     ->addElement(new HtmlH2('Getting Started', '', 'display-5 fw-bold'))
                     ->addElement(new HtmlP('Quick setup in just a few steps', '', 'lead text-muted'));

$stepsRow = new HtmlDiv('', '', 'row g-4');
$steps = [
    ['number' => '1', 'title' => 'Install', 'code' => 'composer require ferndev/phpprogrammingcontrols'],
    ['number' => '2', 'title' => 'Include', 'code' => "require 'vendor/autoload.php';"],
    ['number' => '3', 'title' => 'Create', 'code' => '$div = new HtmlDiv("Hello World");']
];

foreach ($steps as $step) {
    $stepCard = new HtmlDiv('', '', 'col-md-4');
    $stepContent = '
    <div class="text-center">
        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
            <h4 class="mb-0">' . $step['number'] . '</h4>
        </div>
        <h5>' . $step['title'] . '</h5>
        <code class="bg-light p-2 rounded d-block">' . $step['code'] . '</code>
    </div>';
    $stepCard->addElement(new HtmlDiv($stepContent));
    $stepsRow->addElement($stepCard);
}

$gettingStartedSection->addElement($stepsRow);

// Footer
$footer = new HtmlDiv('', '', 'bg-dark text-white py-5 mt-5');
$footerInner = new HtmlDiv('', '', 'container text-center');
$footerInner->addElement(new HtmlH3('PHP PROGRAMMING Controls', '', 'h5'))
            ->addElement(new HtmlP('Modern HTML control library for PHP 8.0+', '', 'text-muted'));
$social = new HtmlDiv('', '', 'mt-3');
$social->addElement((new \ui\controls\web\HtmlHyperLink('<i class="fab fa-github fa-2x"></i>', 'https://github.com/ferndev/phpprogrammingcontrols', '', '', '', 'text-white me-3'))->setAllowHtml(true))
       ->addElement((new \ui\controls\web\HtmlHyperLink('<i class="fas fa-book fa-2x"></i>', '#', '', '', '', 'text-white me-3'))->setAllowHtml(true));
$footerInner->addElement($social);
$divider = new HtmlDiv('', '', 'my-4');
$divider->addElement(new HtmlHr());
$footerInner->addElement($divider)
            ->addElement(new HtmlP('© 2025 PHP PROGRAMMING Controls. Licensed under the MIT license', '', 'mb-0'));
$footer->addElement($footerInner);

// Assemble the complete page
// Add sections to page body
$page->addBody($navbar);
$page->addBody($heroSection);
$page->addBody($featuresSection);
$page->addBody($showcaseSection);
$page->addBody($demosSection);
$page->addBody($frameworkSection);
$page->addBody($gettingStartedSection);
$page->addBody($footer);

// Add smooth scrolling script as inline <script>
$smoothScrollJs = <<<JS
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
JS;
$inlineScript = new HtmlCtrl('script', null, $smoothScrollJs);
$inlineScript->setAllowHtml(true);
$page->addFooter($inlineScript);

echo $page->toHtml();
# phpprogrammingcontrols (PHP 8.0+ Edition)
This project makes common html controls easily available from PHP, for you to use on any website.
They provide a way to create php-based compact, re-usable and easier to maintain code for your web projects.<br>
It also provides a simple mechanism to easily create new html controls in PHP.<br>
These controls do not depend on any PHP Framework, or frontend library, but can be used
with any of them, or standalone on a website or script created from scratch.<br>

## New in PHP 8.0+ Edition
- **Strict types** for improved performance and error detection
- **Complete type safety** with parameter and return type declarations
- **XSS protection** with automatic HTML escaping
- **JSON serialization** support with JsonSerializable interface
- **Modern PHP 8.0+ syntax** including match expressions and nullable types
- **Enhanced security** with proper input validation
- **Improved error handling** with specific exception types

# License
PHPProgrammingControls is licensed under the MIT License.

# Installation and usage
The controls require PHP 8.0 or higher. To get started, simply clone this folder and run composer install in your local environment,
or use <a href="https://getcomposer.org/">Composer</a> to download and install
the library. Then execute index.php in your local server/browser and take a look at the provided samples.<br>

## Adding the library to your own project
You can add the library to your own project with composer, by adding the following entries to your composer.json file:<br>
"require": {<br>
    "php": ">=8.0",<br>
    "ferndev/phpprogrammingcontrols": "*"<br>
  },<br>
If composer gives you an error or warning about stability, add the following as well:<br>
"minimum-stability": "dev".<br>
If you are not using composer then you will need to add the source folder: "src" to your own project,
and "use" the controls you need (look at the code of the provided examples).<br>
You can then start creating instances of the controls.<br>

## Migration from earlier versions
See `UPGRADE_PHP8.md` for detailed migration instructions and breaking changes.

## Features
- **Type-safe** HTML control creation
- **XSS protection** built-in
- **Fluent interface** for method chaining
- **JSON serialization** support
- **Framework agnostic** - works with any PHP framework
- **Frontend agnostic** - works with any CSS framework

## HtmlTabs quick guide

HtmlTabs renders a tab strip and associated panes using framework-agnostic APIs. Choose your frontend mode and the control will emit appropriate classes and behavior.

Key API:
- addTab(string $title, string $contentLink, bool $isActive = false): adds a tab targeting a pane id like `#pane1`.
- setTabContent(string $paneId, HtmlBase $content): registers the content for the given pane id (without `#`).
- setFramework('bootstrap' | 'tailwind' | 'react' | 'vanilla'): selects sensible defaults for each mode.
- setClasses(array $overrides): override any defaults (ulClass, liClass, linkClass, linkActiveClass, contentContainerClass, paneClass, paneActiveClass, paneHiddenClass).
- enableClientToggle(bool): enable/disable the built-in tiny toggler (used in tailwind/vanilla; not used in bootstrap/react modes).

Bootstrap example:
```php
$tabs = (new HtmlTabs())->setFramework('bootstrap');
$tabs->addTab('Tab1', '#p1', true)->addTab('Tab2', '#p2');
$tabs->setTabContent('p1', new HtmlDiv('Tab1 content...'));
$tabs->setTabContent('p2', new HtmlDiv('Tab2 content...'));
// include Bootstrap CSS/JS
```

Tailwind example (no Bootstrap JS):
```php
$tabs = (new HtmlTabs())->setFramework('tailwind'); // includes tiny built-in toggler
$tabs->addTab('Tab1', '#p1', true)->addTab('Tab2', '#p2');
$tabs->setTabContent('p1', new HtmlDiv('Tab1 content...'));
$tabs->setTabContent('p2', new HtmlDiv('Tab2 content...'));
```

React example (server renders HtmlTabs, React binder wires toggling):
```php
$tabs = (new HtmlTabs('react-tabs'))->setFramework('react');
$tabs->addTab('Tab1', '#p1', true)->addTab('Tab2', '#p2');
$tabs->setTabContent('p1', new HtmlDiv('Tab1 content...'));
$tabs->setTabContent('p2', new HtmlDiv('Tab2 content...'));
// load examples/js/react-tabs-binder.jsx with React + Babel
```

Vanilla example (no frameworks, your classes):
```php
$tabs = (new HtmlTabs('my-tabs'))->setFramework('vanilla')->setClasses([
  'ulClass' => 'tabs',
  'linkClass' => 'tab',
  'linkActiveClass' => 'tab--active',
  'paneHiddenClass' => 'hidden'
]);
$tabs->addTab('One', '#p1', true)->addTab('Two', '#p2');
$tabs->setTabContent('p1', new HtmlDiv('One'));
$tabs->setTabContent('p2', new HtmlDiv('Two'));
```

See examples:
- Bootstrap: `examples/TabsExample.php`
- Tailwind: `examples/TabsExampleTailwind.php`
- React: `examples/TabsExampleReact.php` + `examples/js/react-tabs-binder.jsx`

## Examples and assets
- All examples now use CDN-hosted assets (Bootstrap 5, Tailwind CSS, React 18, Babel) with integrity and crossorigin where applicable.
- Legacy local assets under `examples/css` and `examples/fonts` have been removed. Examples no longer depend on local Bootstrap 3 or Glyphicons.
- Entry point `index.php` redirects to `examples/landing.php`, which links to all demos (Bootstrap/Tailwind/React variants).
- React examples load JSX from `examples/js/*.jsx` and rely on in-browser Babel transform for convenience.

### Try the demos locally
- Serve the project with your PHP web server (Apache, Nginx, or PHP’s built-in server) and open:
  - `examples/landing.php` for the main showcase
  - Or directly: `examples/SampleWebControls.php`, `examples/SampleWebControlsTailwind.php`, `examples/SampleWebControlsReact.php`, etc.

### Run tests
- Requires Composer dependencies installed.
- From the project root, run:

```powershell
composer install
vendor\bin\phpunit.bat --colors=never tests
```

All tests should pass (40 tests, 152 assertions).
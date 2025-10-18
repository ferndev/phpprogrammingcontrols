<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use ui\controls\web\{
    HtmlPage, HtmlDiv, HtmlH1, HtmlH2, HtmlH3, HtmlH4, HtmlForm, 
    HtmlInput, HtmlButton, HtmlLabel, HtmlLink, HtmlScript, HtmlP
};
use ui\controls\HtmlCtrl;

// Create page with Tailwind CSS
$page = new HtmlPage();

// Head: title and responsive viewport
$page->addHeader(new HtmlCtrl('title', null, 'Tailwind Login Demo - PHP PROGRAMMING Controls'));
$page->addHeader((new HtmlCtrl('meta', null, '', false))->addProperty('name', 'viewport')->addProperty('content', 'width=device-width, initial-scale=1'));

// Load Tailwind via CDN script (correct way for CDN usage)
$page->addHeader(new HtmlScript('https://cdn.tailwindcss.com'));

// Add custom Tailwind configuration
$tailwindConfig = <<<JS
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#eff6ff',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                },
            }
        }
    }
}
JS;
$tailwindConfigScript = new HtmlCtrl('script', null, $tailwindConfig);
$tailwindConfigScript->setAllowHtml(true);
$page->addHeader($tailwindConfigScript);

// Main container with gradient background
// Top navbar (Tailwind)
$topNav = new HtmlDiv('', '', 'bg-white/90 backdrop-blur sticky top-0 z-10 shadow-sm');
$navInner = new HtmlDiv('', '', 'container mx-auto px-4');
$navBar = new HtmlDiv('', '', 'flex items-center justify-between h-14');
$brand = new HtmlCtrl('a', null, 'PHP PROGRAMMING Controls', true, '', 'font-semibold text-gray-800');
$brand->addProperty('href', 'landing.php');
$navLinks = new HtmlDiv('', '', 'flex items-center gap-4');
foreach ([
    ['SamplePageWithLoginForm.php','Bootstrap',false],
    ['SamplePageWithLoginFormTailwind.php','Tailwind',true],
    ['SamplePageWithLoginFormReact.php','React',false],
] as [$href,$text,$active]) {
    $a = new HtmlCtrl('a', null, $text, true, '', 'text-sm px-3 py-1 rounded '.($active?'bg-indigo-600 text-white':'text-gray-700 hover:bg-gray-100'));
    $a->addProperty('href', $href);
    $navLinks->addElement($a);
}
$navBar->addElement($brand)->addElement($navLinks);
$navInner->addElement($navBar);
$topNav->addElement($navInner);

// Main container with gradient background
$mainContainer = new HtmlDiv('', '', 'min-h-screen bg-gradient-to-br from-blue-400 via-purple-500 to-purple-700 flex items-center justify-center p-4');

// Content wrapper
$contentWrapper = new HtmlDiv('', '', 'w-full max-w-md');

// Header section
$headerSection = new HtmlDiv('', '', 'text-center mb-8');
$headerSection->addElement(new HtmlH1('🔐', '', 'text-6xl mb-4'))
              ->addElement(new HtmlH2('Welcome Back', '', 'text-3xl font-bold text-white mb-2'))
              ->addElement(new HtmlP('Sign in to your account', '', 'text-purple-100 text-lg'));

// Login card
$loginCard = new HtmlDiv('', '', 'bg-white/90 backdrop-blur-md border border-white/20 rounded-2xl shadow-xl p-8');

// Card header
$cardHeader = new HtmlDiv('', '', 'text-center mb-8');
$cardHeader->addElement(new HtmlH3('Login to Your Account', '', 'text-2xl font-bold text-gray-800 mb-2'))
           ->addElement(new HtmlP('Enter your credentials to continue', '', 'text-gray-600'));

// Login form
$loginForm = new HtmlForm('loginform', 'post', 'index.php', '', 'space-y-6');

// Username field
$usernameGroup = new HtmlDiv('', '', '');
$usernameLabel = new HtmlLabel('Username', 'username', '', 'block text-sm font-medium text-gray-700 mb-2');
$usernameInput = new HtmlInput(
    'text', 
    'username', 
    '', 
    'username', 
    'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 ease-in-out'
);
$usernameInput->addProperty('placeholder', 'Enter your username');

$usernameGroup->addElement($usernameLabel)
              ->addElement($usernameInput);

// Password field
$passwordGroup = new HtmlDiv('', '', '');
$passwordLabel = new HtmlLabel('Password', 'password', '', 'block text-sm font-medium text-gray-700 mb-2');
$passwordInput = new HtmlInput(
    'password', 
    'password', 
    '', 
    'password', 
    'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 ease-in-out'
);
$passwordInput->addProperty('placeholder', 'Enter your password');

$passwordGroup->addElement($passwordLabel)
              ->addElement($passwordInput);

// Remember me and forgot password
$optionsRow = new HtmlDiv('', '', 'flex items-center justify-between');

$rememberDiv = new HtmlDiv('', '', 'flex items-center');
$rememberCheckbox = new HtmlInput('checkbox', 'remember', '1', 'remember', 'h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded');
$rememberLabel = new HtmlLabel('', 'remember', 'Remember me', '', 'ml-2 block text-sm text-gray-700');
$rememberDiv->addElement($rememberCheckbox)->addElement($rememberLabel);

$forgotLink = new HtmlDiv('<a href="#" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Forgot password?</a>');
$forgotLink->setAllowHtml(true);

$optionsRow->addElement($rememberDiv)->addElement($forgotLink);

// Submit button
$submitButton = new HtmlButton(
    'Sign In', 
    '', 
    'Sign In', 
    'submit-btn', 
    'w-full bg-gradient-to-r from-primary-500 to-purple-600 text-white py-3 px-4 rounded-lg font-medium hover:from-primary-600 hover:to-purple-700 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition duration-200 ease-in-out transform hover:scale-105'
);
$submitButton->addProperty('type', 'submit');

// Register link
$registerSection = new HtmlDiv('', '', 'text-center pt-6 border-t border-gray-200');
$registerText = new HtmlP('Don\'t have an account? ', '', 'text-gray-600 inline');
$registerLink = new HtmlDiv('<a href="#" class="text-primary-600 hover:text-primary-700 font-medium">Create one now</a>', '', 'inline');
$registerLink->setAllowHtml(true);
$registerSection->addElement($registerText)->addElement($registerLink);

// Assemble the form
$loginForm->addElement($usernameGroup)
          ->addElement($passwordGroup)
          ->addElement($optionsRow)
          ->addElement($submitButton);

// Social login section
$socialSection = new HtmlDiv('', '', 'mt-8');
$socialDivider = new HtmlDiv('', '', 'relative');
$socialDividerLine = new HtmlDiv('', '', 'absolute inset-0 flex items-center');
$socialDividerLineSpan = new HtmlDiv('', '', 'w-full border-t border-gray-300');
$socialDividerText = new HtmlDiv('', '', 'relative flex justify-center text-sm');
$socialDividerTextSpan = new HtmlDiv('<span class="px-2 bg-white text-gray-500">Or continue with</span>');
$socialDividerTextSpan->setAllowHtml(true);

$socialDivider->addElement($socialDividerLine)->addElement($socialDividerLineSpan);
$socialDividerText->addElement($socialDividerTextSpan);
$socialDivider->addElement($socialDividerText);

$socialButtons = new HtmlDiv('', '', 'mt-6 grid grid-cols-2 gap-3');
$googleBtn = new HtmlButton(
    '<svg class="w-5 h-5 mr-2" viewBox="0 0 24 24"><path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>Google', 
    '', 
    'Sign in with Google', 
    'google-btn', 
    'w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition duration-200'
);

$githubBtn = new HtmlButton(
    '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>GitHub', 
    '', 
    'Sign in with GitHub', 
    'github-btn', 
    'w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition duration-200'
);

$socialButtons->addElement($googleBtn)->addElement($githubBtn);
$socialSection->addElement($socialDivider)->addElement($socialButtons);

// Assemble the login card
$loginCard->addElement($cardHeader)
          ->addElement($loginForm)
          ->addElement($registerSection)
          ->addElement($socialSection);

// Assemble the content wrapper
$contentWrapper->addElement($headerSection)
               ->addElement($loginCard);

// Add to main container
$mainContainer->addElement($contentWrapper);

// Add to page body
$page->addBody($topNav);
$page->addBody($mainContainer);

// Add some custom JavaScript for enhanced interactions
$customJS = <<<JS
// Add floating label effect
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[type="text"], input[type="password"]');

    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.classList.add('ring-2', 'ring-primary-500', 'border-primary-500');
        });
    
        input.addEventListener('blur', function() {
            this.classList.remove('ring-2', 'ring-primary-500', 'border-primary-500');
        });
    });
  
    // Add form validation
    const form = document.getElementById('loginform');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
      
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
      
            if (!username || !password) {
                alert('Please fill in all fields');
                return;
            }
      
            // Simulate login
            const submitBtn = document.getElementById('submit-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Signing in...';
            submitBtn.disabled = true;
      
            setTimeout(() => {
                alert('Login successful! (This is a demo)');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
    }
});
JS;
$inlineJs = new HtmlCtrl('script', null, $customJS);
$inlineJs->setAllowHtml(true);
$page->addFooter($inlineJs);

echo $page->toHtml();
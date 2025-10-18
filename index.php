<?php
declare(strict_types=1);

// Minimal entry point: redirect to the modern landing page demo.
// This avoids loading any legacy local assets from examples/css, examples/js, or examples/fonts.
header('Location: examples/landing.php', true, 302);
exit;

<?php
/**
 * The main bootstrap file.
 */

session_start();

require __DIR__ . '/../vendor/autoload.php';

use App\Core;
use Dotenv\Dotenv;

$env = new Dotenv(__DIR__ . '/../');
$env->load();

// Load the helpers
require_once __DIR__ . '/../app/helpers.php';

$core = new Core();

$core->run();
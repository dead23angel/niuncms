<?php
/**
 * The main bootstrap file.
 */

session_start();

require __DIR__ . '/../vendor/autoload.php';

use App\Core;

$core = new Core();

$core::run();
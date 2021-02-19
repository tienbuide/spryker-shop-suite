<?php

use Spryker\Zed\Application\Communication\Bootstrap\ZedBootstrap;
use Spryker\Shared\Config\Application\Environment;
use Spryker\Shared\ErrorHandler\ErrorHandlerEnvironment;

define('APPLICATION', 'ZED');
define('APPLICATION_ROOT_DIR', dirname(__DIR__, 2));

// main application have be send by application in the request
putenv('APPLICATION_STORE=DE');

require_once APPLICATION_ROOT_DIR . '/vendor/autoload.php';

Environment::initialize();

$errorHandlerEnvironment = new ErrorHandlerEnvironment();
$errorHandlerEnvironment->initialize();

$bootstrap = new ZedBootstrap();
$bootstrap
    ->boot()
    ->run();

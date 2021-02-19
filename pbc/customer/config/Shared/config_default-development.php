<?php
// >>> Error handler

use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebExceptionErrorRenderer;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebHtmlErrorRenderer;
use Spryker\Shared\Propel\PropelConstants;

$config[ErrorHandlerConstants::DISPLAY_ERRORS] = true;
$config[ErrorHandlerConstants::ERROR_RENDERER] = getenv('SPRYKER_DEBUG_ENABLED') ? WebExceptionErrorRenderer::class : WebHtmlErrorRenderer::class;
$config[ErrorHandlerConstants::IS_PRETTY_ERROR_HANDLER_ENABLED] = (bool)getenv('SPRYKER_DEBUG_ENABLED');
$config[ErrorHandlerConstants::ERROR_LEVEL] = getenv('SPRYKER_DEBUG_DEPRECATIONS_ENABLED') ? E_ALL : $config[ErrorHandlerConstants::ERROR_LEVEL];

$config[ErrorHandlerConstants::IS_PRETTY_ERROR_HANDLER_ENABLED] = true;


// >>> DATABASE
$config[PropelConstants::ZED_DB_USERNAME] = 'development';
$config[PropelConstants::ZED_DB_PASSWORD] = 'mate20mg';
$config[PropelConstants::ZED_DB_DATABASE] = 'PBC_customer';
$config[PropelConstants::USE_SUDO_TO_MANAGE_DATABASE] = true;
$config[PropelConstants::ZED_DB_HOST] = '127.0.0.1';
$config[PropelConstants::ZED_DB_PORT] = 3306;

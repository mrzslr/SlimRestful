<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
session_start();
$settings = require '../src/settings.php';
$app = new \Slim\App($settings);

// Route and Dependencies
require '../src/routes.php';
require '../src/dependencies.php';

$app->run();


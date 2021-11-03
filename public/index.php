<?php

use App\Application;
use App\Application\Http\Request;


require_once __DIR__.'/../vendor/autoload.php';
session_start();
$request = Request::fromGlobals();
$application = new Application();
echo $application->run($request);

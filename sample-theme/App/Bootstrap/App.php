<?php

// load vendor dependencies.
require dirname(__DIR__, 3) . '/vendor/autoload.php';

$app = new \Snape\EcoSystemWP\Application\Application(dirname(__DIR__, 2));

$app->bootstrap();

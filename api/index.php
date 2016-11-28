<?php

require __DIR__ . '/../vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);
$container = $app->getContainer();

// Register middleware
require __DIR__ . '/../src/middleware.php';
require __DIR__ . '/../api/database/DbConn.php';

// Include classes and API methods

require_once'./database/Tests.php';
require_once './method/Tests.php';

// Store Users object in container
$container['tests'] = new Tests($container['db_config']);

require_once'./database/Answers.php';
require_once './method/Answers.php';

// Store Users object in container
$container['answers'] = new Answers($container['db_config']);

require_once'./database/Questions.php';
require_once './method/Questions.php';

// Store Users object in container
$container['questions'] = new Questions($container['db_config']);

require_once'./database/TestQuestions.php';
require_once './method/TestQuestions.php';

// Store Users object in container
$container['testQuestions'] = new TestQuestions($container['db_config']);



// Run app
$app->run();

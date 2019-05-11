<?php

include (__DIR__ . '/vendor/autoload.php');
use Service\QuizClient;
use Service\QuizRegisterUser;

// $requestTest = new QuizClient(1);
// $test = $requestTest->getQuestions();
// echo ($test['results'][0]['category']);

$test = new QuizRegisterUser('testid','testsent');
$test->registerUser();

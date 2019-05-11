<?php

include (__DIR__ . '/vendor/autoload.php');
use Service\ConfigProvider;
use Service\QuizClient;
use Service\QuizRegisterUser;

$configProvider = new ConfigProvider(__DIR__ . '/config.json');
$requestQuestion = new QuizClient(1);

if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    if ($_REQUEST['hub_verify_token'] === $configProvider->getParameter('verify_token')) {
        echo $challenge; die();
    }
}

$input = json_decode(file_get_contents('php://input'), true);

if ($input === null) {
    exit;
}

$message = $input['entry'][0]['messaging'][0]['message']['text'];

$question = $requestQuestion->getQuestion();
$question = $question['results'][0]['question'];
$correctAnswer = $question['results'][0]['correct_answer'];

$sender = $input['entry'][0]['messaging'][0]['sender']['id'];


$registerUser = new QuizRegisterUser($sender, $question);
$registerUser->registerUser();


$fb = new \Facebook\Facebook([
    'app_id' => $configProvider->getParameter('appId'),
    'app_secret' => $configProvider->getParameter('appSecret'),
]);

$data = [
    'messaging_type' => 'RESPONSE',
    'recipient' => [
        'id' => $sender,
    ],
    'message' => [
        'text' => $question,
    ]
];

$response = $fb->post(
  '/me/messages',
  $data,
  $configProvider->getParameter('access_token'));

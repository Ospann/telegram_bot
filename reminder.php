<?php
date_default_timezone_set('Asia/Almaty');

$BOT_TOKEN = getenv('TELEGRAM_TOKEN');
$CHAT_ID = '982824929';

$now = new DateTime();
$hour = $now->format('H');
var_dump($hour);
$ip_address = file_get_contents('https://api.ipify.org');
$hostname = gethostname();

function callFunction($hour) {
    switch ($hour) {
        case 8:
            return "Доброе утро!!\n\nКакой план на сегодня?";
        case 12:
            return "Как настроение?\n\nПриятного аппетита";
        case 18:
            return "Не забудь записать часы!!!\n\nФорма для записи: https://script.google.com/macros/s/AKfycbzvikrrj_mTorzXlQ0sYOp9Dib1YrQt-eTb3B0Tz_FJTbPwcSY9w4nTcQfKCXbUhCYt/exec\n\nПросмотр: https://docs.google.com/spreadsheets/d/1OuRxnYkdwF9Ck5_KWP7AsVkWlCxXxfR4HjdMT3DpzJY/edit#gid=609773702";
        default:
            return "Invalid argument";
    }
}

$message = callFunction($hour);
if($message !=='Invalid argument'){
$url = "https://api.telegram.org/bot$BOT_TOKEN/sendMessage";
$data = array('chat_id' => $CHAT_ID, 'text' => $message);

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
}


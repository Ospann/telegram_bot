<?php
file_put_contents('log.txt', print_r($_REQUEST, true));
$data = json_decode(file_get_contents('php://input'), TRUE);

// Important constants
define('TOKEN', '6170296157:AAGjoKIWQjtMwD_aEE9vYtG0mZSMcZ9toHI');

// Define keyboard
$keyboard = [
  [
    ['text' => 'Events list'],
    ['text' => 'Check my current hours'],
  ],
  [
    ['text' => 'Add Hours'],
  ]
];

// Process message or button press
if (isset($data['callback_query'])) {
  // User clicked on a button in the inline keyboard
  $callback_data = $data['callback_query']['data'];
  switch ($callback_data) {
    case 'project1':
      $method = 'sendMessage';
      $send_data = [
        'text' => 'You clicked on the Fragrancia button'
      ];
      break;
    case 'project2':
      $method = 'sendMessage';
      $send_data = [
        'text' => 'You clicked on the Holten button'
      ];
      break;
    case 'project3':
      $method = 'sendMessage';
      $send_data = [
        'text' => 'You clicked on the ML button'
      ];
      break;
    case 'project4':
      $method = 'sendMessage';
      $send_data = [
        'text' => 'You clicked on the Qamal button'
      ];
      break;
    case 'project5':
      $method = 'sendMessage';
      $send_data = [
        'text' => 'You clicked on the Ecohorica button'
      ];
      break;
    case 'project6':
      $method = 'sendMessage';
      $send_data = [
        'text' => 'You clicked on the SD button'
      ];
      break;
    default:
      $method = 'sendMessage';
      $send_data = [
        'text' => 'Error'
      ];
      break;
  }
} else {
  // User sent a message
  $message = mb_strtolower(($data['text'] ? $data['text'] : $data['data']), 'utf-8');

  switch (strtolower($message)) {
    case 'events list':
      $method = 'sendMessage';
      $send_data = [
        'text' => 'Here are the events:'
        // Add code to fetch and display events
      ];
      break;
    case 'check my current hours':
      $method = 'sendMessage';
      $send_data = [
        'text' => 'Here are your current hours:'
        // Add code to fetch and display hours
      ];
      break;
    case 'add hours':
      $method = 'sendMessage';
      $send_data = [
        'text' => 'Please enter the hours you want to add:'
        // Add code to prompt user for hours input
      ];
      break;
    default:
      $method = 'sendMessage';
      $send_data = [
        'text' => 'Please select an option from the keyboard'
      ];
      break;
  }
}

// Send response to user
$url = 'https://api.telegram.org/bot' . TOKEN . '/' . $method;
$send_data['chat_id'] = $data['message']['chat']['id'];
$send_data['reply_markup'] = json_encode([
  'inline_keyboard' => $keyboard
]);
$options = [
  'http' => [
    'header' => "Content-Type:application/json\r\n",
    'method' => 'POST',
    'content' => json_encode($send_data)
  ]
];
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
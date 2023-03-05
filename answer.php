<?php

$data = json_decode(file_get_contents('php://input'), TRUE);
//file_put_contents('file.txt', '$data: '.print_r($data, 1)."\n", FILE_APPEND);

//webhook есть ж
//https://api.telegram.org/bot6170296157:AAGjoKIWQjtMwD_aEE9vYtG0mZSMcZ9toHI/setwebhook?url=https://test.maxinum.kz/telegrambots/answer.php


# Обрабатываем ручной ввод или нажатие на кнопку
$data = $data['callback_query'] ? $data['callback_query'] : $data['message'];
# Важные константы
define('TOKEN', '6170296157:AAGjoKIWQjtMwD_aEE9vYtG0mZSMcZ9toHI');

# Записываем сообщение пользователя
$message = mb_strtolower(($data['text'] ? $data['text'] : $data['data']), 'utf-8');

$keybord = [
                    [
                        ['text' => 'check'],
                        ['text' => '...'],
                    ],
                    [
                        ['text' => 'check2'],
                    ]
                ];

# Обрабатываем сообщение
switch ($message) {
    case '/start':
        $method = 'sendMessage';
        $send_data = [
            'text'   => 'Menu list:',
            'reply_markup' => [
                'resize_keyboard' => true,
                'keyboard' => $keybord,
            ]
        ];
        break;
    case 'check':
        $method = 'sendMessage';
        $send_data = [
            'text'   => 'Events not exist',
            'reply_markup' => [
                'resize_keyboard' => true,
                'keyboard' => $keybord,
            ]
        ];
        break;
    case '...':
        $method = 'sendMessage';
        $send_data = [
            'text'   => 'in progress',
            'reply_markup' => [
                'resize_keyboard' => true,
                'keyboard' => $keybord,
            ]
        ];
        break;
    case 'check2':
        $method = 'sendMessage';
        $send_data = [
            'text'   => 'Choose your project:',
            'reply_markup' => [
                'inline_keyboard' => [
                    [
                        ['text' => 'Fragrancia', 'callback_data' => 'project1'],
                    ],
                    [
                        ['text' => 'Holten', 'callback_data' => 'project2'],
                    ],
                    [
                        ['text' => 'ML', 'callback_data' => 'project3'],
                    ],
                    [
                        ['text' => 'Qamal', 'callback_data' => 'project4'],
                    ],
                    [
                        ['text' => 'Ecohorica', 'callback_data' => 'project5'],
                    ],
                    [
                        ['text' => 'SD', 'callback_data' => 'project6'],
                    ],
                ]
            ]
        ];
        break;
    default:
        if (empty($data['text'])) {
            $message = $data['data'];
        }
        $method = 'sendMessage';
        $send_data = [
            'text' => 'Нормально пиши!'
        ];
}

if (isset($data['callback_query'])) {
    # User clicked on a button in the inline keyboard
    $callback_data = $data['callback_query']['data'];
    switch ($callback_data) {
        case 'project1':
            # Handle user's response to the 'Fragrancia' button
            $method = 'sendMessage';
            $send_data = [
                'text' => 'You clicked on the Fragrancia button'
            ];
            break;
        case 'project2':
            # Handle user's response to the 'Holten' button
            $method = 'sendMessage';
            $send_data = [
                'text' => 'You clicked on the Holten button'
            ];
            break;
        case 'project3':
            # Handle user's response to the 'ML' button
            $method = 'sendMessage';
            $send_data = [
                'text' => 'You clicked on the ML button'
            ];
            break;
        case 'project4':
            # Handle user's response to the 'Qamal' button
            $method = 'sendMessage';
            $send_data = [
                'text' => 'You clicked on the Qamal button'
            ];
            break;
        case 'project5':
            # Handle user's response to the 'Ecohorica' button
            $method = 'sendMessage';
            $send_data = [
                'text' => 'You clicked on the Ecohorica button'
            ];
            break;
        case 'project6':
            # Handle user's response to the 'SD' button
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
}

# Добавляем данные пользователя
$send_data['chat_id'] = $data['chat']['id'];

$res = sendTelegram($method, $send_data);

function sendTelegram($method, $data, $headers = [])
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://api.telegram.org/bot' . TOKEN . '/' . $method,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"), $headers)
    ]);

    $result = curl_exec($curl);
    curl_close($curl);
    return (json_decode($result, 1) ? json_decode($result, 1) : $result);
}

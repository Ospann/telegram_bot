<?php
require './googleApi.php';
// Set up constants
define('BOT_TOKEN', '6170296157:AAGjoKIWQjtMwD_aEE9vYtG0mZSMcZ9toHI');
define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN . '/');

// Get the incoming message data
$update = json_decode(file_get_contents('php://input'), true);
$projects =  getProjects();
$subProjects = subProjects();
// Check if the message contains text
if (isset($update['message']['text'])) {
    $message = $update['message']['text'];
    $chat_id = $update['message']['chat']['id'];
    $keyboard = array(
        "keyboard" => [
            ["Add hours"],
            ["Events List", "Check hours"]
        ],
        "resize_keyboard" => true
    );
    switch ($message) {
        case 'Add hours':
            $keyboard = [];
            foreach ($projects as $sub) {
                array_push($keyboard, [
                    ["text" => $sub, "callback_data" => $sub]
                ]);
            }
            $projects_keyboard = array(
                "inline_keyboard" => $keyboard
            );
            $text = "Choose your project:";
            sendMessage($chat_id, $text, $projects_keyboard);
            break;
        case 'Events List':
            $text = "Here are the events:";
            sendMessage($chat_id, $text, $keyboard);
            break;
        case 'Check hours':
            $text = "Here are your current hours:";
            sendMessage($chat_id, $text, $keyboard);
            break;
        default:
            $text = "Please select an option from the keyboard";
            sendMessage($chat_id, $text, $keyboard);
            break;
    }
}
// Check if the message contains an inline keyboard callback query
else if (isset($update['callback_query'])) {
    $callback_query = $update['callback_query'];
    $callback_query_id = $callback_query['id'];
    $callback_data = $callback_query['data'];
    $chat_id = $callback_query['message']['chat']['id'];
    foreach ($projects as $row) {
        if ($callback_data === $row) {
            $inline = [];
            foreach ($subProjects as $subarray) {
                if ($subarray[0] == $callback_data) {
                    array_push($inline, [
                        ["text" => $subarray[1], "callback_data" => $subarray[1]]
                    ]);
                }
            }
            $subprojects_keyboard = array(
                "inline_keyboard" => $inline
            );
            $text = "$row \n\nChoose subproject:";
            sendMessage($chat_id, $text, $subprojects_keyboard);
            break;
        }
        foreach ($subProjects as $subarray) {
            if ($callback_data === $subarray[1] && $subarray[0] === $row) {
                $text = "Hours have been added \n\nProject:$row\nSubProject:$subarray[1]";
                sendMessage($chat_id, $text, []);
            }
        }
    }
}

// Function to send messages
function sendMessage($chat_id, $text, $reply_markup = null)
{
    $url = API_URL . 'sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($text);
    if ($reply_markup) {
        $url .= '&reply_markup=' . json_encode($reply_markup);
    }
    file_get_contents($url);
}

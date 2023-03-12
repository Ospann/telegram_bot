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
            $projects_keyboard = array(
                "inline_keyboard" => $projects
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
    // switch ($callback_data) {
    //     case 'Fragrancia':
    //         $subprojects_keyboard = array(
    //             "inline_keyboard" => array(
    //                 array(array("text" => "AKylbek", "callback_data" => "AKylbek")),
    //                 array(array("text" => "Aslan", "callback_data" => "Aslan"))
    //             )
    //         );
    //         $text = "Choose subproject:";
    //         sendMessage($chat_id, $text, $subprojects_keyboard);
    //         break;
    //     case 'MindLogistics':
    //         $text = "ML hours";
    //         sendMessage($chat_id, $text);
    //         break;
    //     case 'Holten Impex':
    //         $text = "Holten hours";
    //         sendMessage($chat_id, $text);
    //         break;
    //     case 'AKylbek':
    //         $text = "Hours been uploaded!";
    //         sendMessage($chat_id, $text);
    //         break;
    //     case 'Aslan':
    //         $text = "Hours been uploaded!";
    //         sendMessage($chat_id, $text);
    //         break;
    //     default:
    //         break;
    // }


    foreach ($projects as $row) {
        try{
            sendMessage($chat_id, $projects[0], []);
            if ($callback_data === $row) {
                $inline = [];
                foreach ($subProjects as $sub) {
                    if ($sub[0] === $row) {
                        array_push($inline, [
                            ["text" => $sub[1], "callback_data"=>$sub[1]]
                        ]);
                    }
                }
                $subprojects_keyboard = array(
                    "inline_keyboard" => $inline
                );
                $text = "Choose subproject:";
                sendMessage($chat_id, $text, $subprojects_keyboard);
                break;
            }
        }catch(Exception $e){
            sendMessage($chat_id, $e, []);
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

<?php
$spreadsheetId = 'https://docs.google.com/spreadsheets/d/1OuRxnYkdwF9Ck5_KWP7AsVkWlCxXxfR4HjdMT3DpzJY/edit#gid=1308834642';

/**
 * function to get All events from googleSheet
 */
function getEvents()
{
}

/**
 * function to get All projects from googleSheet
 */
function getProjects()
{
    // global $spreadsheetId;
    // $range = 'metadata!D:D';
    // $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    // $values = $response->getValues();
    // return $values;
    return  [
        [["text" => "Fragrancia", "callback_data" => "Fragrancia"]],
        [["text" => "MindLogistics", "callback_data" => "MindLogistics"]],
        [["text" => "Holten Impex", "callback_data" => "Holten Impex"]]
    ];
}

/**
 * function to get All subProjects from googleSheet
 */
function subProjects()
{
    global $spreadsheetId;
    $range = 'metadata!A:B';
    // $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    // $values = $response->getValues();
    $values = [
        ["Fragrancia", "Абон. обслуживание"],
        ["Holten Impex", "Абон. обслуживание"],
        ["MindLogistics", "Development"],
    ];
    $subprojects = [];
    if (!empty($values)) {
        foreach ($values as $row) {
            if (isset($row[0]) && isset($row[1])) {
                array_push($subprojects, [
                    $row[0] => $row[1]
                ]);
            }
        }
    }

    return $subprojects;
}

/**
 * function to get users and current hours from googleSheet
 */
function getHours()
{
}

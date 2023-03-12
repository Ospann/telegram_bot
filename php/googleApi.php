<?php
    $spreadsheetId = 'https://docs.google.com/spreadsheets/d/1OuRxnYkdwF9Ck5_KWP7AsVkWlCxXxfR4HjdMT3DpzJY/edit#gid=1308834642';
function getEvents()
{
}

function getProjects()
{
    return  [
        [["text" => "Fragrancia", "callback_data" => "Fragrancia"]],
        [["text" => "ML", "callback_data" => "ML"]],
        [["text" => "Holten", "callback_data" => "Holten"]]
    ];
}

function subProjects()
{
    global $spreadsheetId;
    $range = 'Sheet1!A:B';

    // Retrieve the data from the Google Sheets API
    // $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    // $values = $response->getValues();
    $values =[
        ["Fragrancia", "Абон. обслуживание"],
        ["Holten Impex", "Абон. обслуживание"],
        ["MindLogistics", "Development"],
    ];
    $subprojects=[];
    // Loop through the data and print out the values in the first two columns
    if (!empty($values)) {
        foreach ($values as $row) {
            if (isset($row[0]) && isset($row[1])) {
                array_push($subprojects,[
                    $row[0] => $row[1]
                ]);
            }
        }
    }

    return $subprojects;
}
var_dump(subProjects());

function getHours()
{
}

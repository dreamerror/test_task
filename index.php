<?php

include "convert_data.php";

$jsonData = arrayFromJSON(readJsonAsArray("array.txt"));
$xlsxData = arrayFromXLSX(getSheetItems());

$onlyInJSON = array();
$onlyInXLSX = array();
$differ = array();
$checkedTickets = array();

foreach (array_keys($xlsxData) as $ticket) {
    $checkedTickets[] = $ticket;
    if (!array_key_exists($ticket, $jsonData)) {
        $onlyInXLSX[] = $ticket;
    } else {
        if ($jsonData[$ticket] != $xlsxData[$ticket]) {
            $differ[$ticket]["JSON"] = $jsonData[$ticket];
            $differ[$ticket]["XLSX"] = $xlsxData[$ticket];
        }
    }
}

foreach (array_keys($jsonData) as $ticket) {
    if (!in_array($ticket, $checkedTickets) and !array_key_exists($ticket, $xlsxData)) {
        $onlyInJSON[] = $ticket;
    }
    $checkedTickets[] = $ticket;
}

file_put_contents("result/case1.txt", json_encode($onlyInJSON));
file_put_contents("result/case2.txt", json_encode($onlyInXLSX));
file_put_contents("result/case3.txt", json_encode($differ));

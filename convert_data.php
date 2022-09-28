<?php

function arrayFromXLSX(array $xlsxResult): array {
    $ticketOperationTypeIndex = 2;
    $ticketIdIndex = 4;
    $ticketPriceIndex = 17;
    $possibleTypes = ["Возврат", "Продажа"];
    $result = array();

    foreach ($xlsxResult as $ticketInfo) {
        $ticketID = $ticketInfo[$ticketIdIndex];
        $ticketType = $ticketInfo[$ticketOperationTypeIndex];
        if ($ticketID != -1 and in_array($ticketType, $possibleTypes)) {
            if (!array_key_exists($ticketID, $result)) {
                $result[$ticketID] = floatval($ticketInfo[$ticketPriceIndex]);
            } else {
                $result[$ticketID] += floatval($ticketInfo[$ticketPriceIndex]);
            }
        }
    }
    return $result;
}


function arrayFromJSON(array $jsonResult): array {
    $result = array();

    foreach ($jsonResult as $ticketInfo) {
        $ticketID = explode(" ", strval($ticketInfo["DOC_REG_NO"]))[1];
        $result[$ticketID] = $ticketInfo["TRF"] + $ticketInfo["ZZ"];
    }

    return $result;
}


include "json_read.php";
require "xlsx_read.php";

//print_r(arrayFromXLSX(getSheetItems()));
//print_r(arrayFromJSON(readJsonAsArray("array.txt")));

<?php

$excel = "su1.xlsx";
$unzip_path = "tmp/dir";

$zip = new ZipArchive();
$zip->open($excel);
$zip->extractTo($unzip_path);

$stringsXML = simplexml_load_file($unzip_path . '/xl/sharedStrings.xml');
$sheetXML   = simplexml_load_file($unzip_path . '/xl/worksheets/sheet1.xml');

$sharedStrings = array();
$sharedStrings[-1] = "";
foreach ($stringsXML->children() as $item) {
    $sharedStrings[] = (string)$item->t;
}

$sheetItems = array();

$row = 0;
foreach($sheetXML->sheetData->row as $item) {
    $sheetItems[$row] = array();
    $cell = 0;
    foreach ($item as $child) {
        $attr = $child->attributes();
        $value = isset($child->v)? (string)$child->v: -1;
        $sheetItems[$row][$cell] = isset($attr['t']) ? $sharedStrings[$value] : $value;
        $cell++;
    }
    $row++;
}

function getSheetItems(): array {
    global $sheetItems;
    return $sheetItems;
}
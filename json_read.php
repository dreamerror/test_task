<?php


function readJsonAsArray(string $filename): array
{
    $array = file("array.txt");
    return json_decode(strval($array[0]), true);
}
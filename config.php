<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";

$importedFieldsNames = ["employeeName", "eventName", "date", "price"];

$importedFieldsTypes = [

	"employeeName" => "string",
	"eventName"    => "string",
	"date"         => "string",
	"price"        => "number"

];

define("ImportedFieldsNames", $importedFieldsNames);

define("ImportedFieldsTypes", $importedFieldsTypes);


?>
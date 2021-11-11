<?php
	
require_once("./config.php");

require_once("./validator.php");

require_once("./dbConnector.php");


if(isset($_FILES['upload_file'])) {

	$fileContent = file_get_contents($_FILES['upload_file']['tmp_name']);

	$jsonDecodedResult = json_decode($fileContent);

	foreach($jsonDecodedResult as $record) {

	if(validateFields($record)) {

		$columnFields = implode(", ", ImportedFieldsNames);

		$sql = "INSERT INTO events ($columnFields) VALUES(:employeeName, :eventName, :date, :price)";

		$query = $conn->prepare($sql);

		$query->execute([

			":employeeName" => $record->employeeName,
			":eventName"    => $record->eventName,
			":date"         => $record->date,
			":price"        => $record->price
		]);

		$_SESSION["import_success_message"] = "file Imported successfully";

		echo "uploaded";

		return;
	} 

	}


} else {
	echo "error file not set";

	return;
}


function validateFields($data) {

	foreach (ImportedFieldsNames as $name) {
		// code...

		if(!isset($data->$name)) {
			return false;
		}

		$validatorName = "is" . ucfirst(ImportedFieldsTypes[$name]);

		if(!($validatorName)($data->$name)) {
			return false;
		}

	}

	return true;
}


?> 
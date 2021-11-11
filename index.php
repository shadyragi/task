<?php

require_once("./dbConnector.php");
require_once("./config.php");

$where = "";

if(isset($_GET["filterType"]) && isset($_GET['filterValue']) && in_array($_GET['filterType'], ImportedFieldsNames)) {

	$where = " WHERE " . $_GET['filterType'] . " like '%" . $_GET["filterValue"] . "%'"; 

}

$sql = "SELECT * from events " . $where . " order by id desc";

$query = $conn->query($sql);

$result = $query->fetchAll(PDO::FETCH_ASSOC);



?>


</!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>
<body>


		<div class="container pt-3" >

				<?php if(isset($_SESSION["import_success_message"])) { ?>
				<h2 class="btn btn-success">  <?php echo $_SESSION["import_success_message"] ?> </h2>
				<?php unset($_SESSION["import_success_message"]); } ?>

				<?php if(isset($_SESSION["import_error_message"])) { ?>
				<h2 class="btn btn-danger">  <?php echo $_SESSION["import_error_message"] ?> </h2>
				<?php unset($_SESSION["import_error_message"]); } ?>


				<div class="float-right ">
					<select class="form-control" id="filter">
						
						<option >
							select filter
						</option>

						<?php foreach(ImportedFieldsNames as $fieldName) { ?>
						<option value="<?php echo $fieldName ?>" <?php echo  (isset($_GET["filterType"]) && $_GET["filterType"] == $fieldName) ?  "selected" : "" ?>> 
							<?php echo $fieldName; ?>
						</option>

						<?php } ?>

					</select>

					<input type='text' class='form-control' style="visibility: <?php echo (isset($_GET["filterValue"])) ? "visible;" : "hidden"?>;" id='filterValue'  placeholder='type your search' value="<?php echo (isset($_GET["filterValue"])) ? $_GET["filterValue"] : ""  ?>">

				</div>

				<label for="file" class="btn btn-primary">Import File</label>
				<input id="file" style="visibility: hidden;" type="file" >

				<?php if(count($result) > 0) { ?>
				<div class="row">
				<table style="width:100%;" class="table table-condensed w-100 d-md-table d-block">
					<thead>
					<tr>
						<th scope="col">emplyee name</th>
						<th scope="col">event name</th>
						<th scope="col">date</th>
						<th scope="col">price</th>

					</tr>
				</thead>
				<tbody>

					<?php foreach($result as $record) {  ?>

					<tr>

						<td><?php echo $record["employeeName"] ?></td>
						<td><?php echo $record["eventName"] ?></td>
						<td><?php echo $record["date"] ?></td>
						<td class="price"><?php echo $record["price"] ?></td>

					</tr>

					<?php } ?>

				</tbody>
				</table>
				</div>

				<?php } else { ?>


				<h2 class="btn">No Records Exist</h2>

				<?php  } ?>


		</div>
</body>
</html>

<script>

	$("#file").change(function(event) {


		var formData = new FormData();
		formData.append('upload_file', $('#file')[0].files[0]);

	$.ajax({
       url : 'import.php',
       type : 'POST',
       data : formData,
       processData: false,  // tell jQuery not to process the data
       contentType: false,  // tell jQuery not to set contentType
       success : function(res) {
          if(res == "uploaded") {
          	window.location.href = "index.php";
          }
       }
	});
	});

	$("#filterValue").blur(function(event) {

			var selectedFilter = $("#filter").val();


			location.href = "index.php?filterType=" + selectedFilter + "&filterValue=" + $("#filterValue").val();
	});

	$("#filter").change(function(event) {

		$("#filterValue").css("visibility", "visible").val("");


		var selectedFilter = $("#filter").val();

		if(selectedFilter == "select filter") {

			location.href = "index.php";

		} 
	});

	var totalPrice = 0;

	$('table tbody tr').each(function() {
	    var price = $(this).find(".price").html(); 

    	totalPrice += parseInt(price);   
 	});


$("table tbody").append("<tr><td></td> <td></td> <td></td> <td>" + totalPrice +"</td></tr>")

	</script>>


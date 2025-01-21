<?php

include "../connect.php"; // database connection details stored here

?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery duplifer.js Example</title>
    <link href="css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="css/bootstrap.min.css">
	<script src="js/jquery-1.12.1.min.js"></script>
	<script src="js/jquery-duplifer.js"></script>
    <style>
    body { background-color:#fafafa;}
    </style>
</head>
<body>

<div class="container" style="margin-top:150px;">

	<table class="find-duplicates table table-bordered table-striped">
					<thead>
						<tr>
                        <th class="duplifer-highlightdups">Name</th>
						<th>E-mail</th>
						<th>Username</th>
						<th>User Level</th>
						<th>Code</th>
						<th>Edit</th>
						<th>Delete</th>
						</tr>
					</thead>
				
					<tbody>
						<?php 
						
						$query=mysqli_query($con, "SELECT *  FROM `users` ORDER BY id DESC ")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						?>
						<tr>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['mail']; ?></td>
						<td><?php echo $row['userid']; ?></td>
						<td><?php echo $row['level']; ?></td>
						<td><?php echo $row['code']; ?></td>
						<td><a href="edit_user.php?id=<?php echo $row['id']; ?>"><input type='submit' class="btn btn-success addmore" value='Edit'>	</a></td>
						<td><a href="delete_user.php?id=<?php echo $row['id']; ?>"><input type='submit'  type='submit' onClick="return confirm('Are you sure you want to Delete?');" class="btn btn-danger delete" value='Delete'>	</a></td>
                 
						
						</tr>
						<?php } ?>
					</tbody>
				</table>

	<script>
	
		$(document).ready(function () {
			$(".find-duplicates").duplifer();
		});

	</script>
</div>
</body>
</html>

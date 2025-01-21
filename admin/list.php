<?php
//include_once connection file 
include_once_once("../connect.php");
$sql = "SELECT * FROM `medicine_list` ";
$queryRecords = mysqli_query($con, $sql) or die("error to fetch employees data");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<title>phpflow.com : Simple Example of In-line Editing with HTML5,PHP and MySQL</title>
</head>
<body>
<div class="container" style="padding:50px 250px;">
<h1>Simple Example of Inline Editing with HTML5,PHP and MySQL</h1>
<div id="msg" class="alert"></div>
<table id="" class="table table-condensed table-hover table-striped bootgrid-table" width="60%" cellspacing="0">
   <thead>
      <tr>
         
         <th>Trade name</th>
         <th>Generic name</th>
		 <th>Type</th>
      </tr>
   </thead>
   <tbody id="_editable_table">
      <?php foreach($queryRecords as $res) :?>
      <tr data-row-id="<?php echo $res['sno'];?>">
         <td class="editable-col" contenteditable="true" col-index='0' oldVal ="<?php echo $res['trade_name'];?>"><?php echo $res['trade_name'];?></td>
         <td class="editable-col" contenteditable="true" col-index='1' oldVal ="<?php echo $res['generic_type'];?>"><?php echo $res['generic_name'];?></td>
         <td class="editable-col" contenteditable="true" col-index='2' oldVal ="<?php echo $res['type'];?>"><?php echo $res['type'];?></td>
		
	  
	  </tr>
	  <?php endforeach;?>
   </tbody>
</table>
</div>
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){
	$('td.editable-col').on('focusout', function() {
		data = {};
		data['val'] = $(this).text();
		data['id'] = $(this).parent('tr').attr('data-row-id');
		data['index'] = $(this).attr('col-index');
	    if($(this).attr('oldVal') === data['val'])
		return false;

		$.ajax({   
				  
					type: "POST",  
					url: "server.php",  
					cache:false,  
					data: data,
					dataType: "json",				
					success: function(response)  
					{   
						//$("#loading").hide();
						if(!response.error) {
							$("#msg").removeClass('alert-danger');
							$("#msg").addClass('alert-success').html(response.msg);
						} else {
							$("#msg").removeClass('alert-success');
							$("#msg").addClass('alert-danger').html(response.msg);
						}
					}   
				});
	});
});

</script>
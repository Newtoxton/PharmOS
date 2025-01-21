<?php

include_once "../connect.php"; // database connection details stored here

$queryRecords=mysqli_query($con, "select * FROM medicine_list ORDER BY sno ASC ")or die(mysqli_error());
?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Edit</title>
	<!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../plugins/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  

</head>

<?php include("header.php"); ?>

  <!-- =============================================== -->

  
<?php include("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Prices
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Medicine List</li>
      </ol>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Editable Table</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

<div class="box">
 <div class="box-body">
<div class="table-responsive">
			<div id="msg" class="alert"></div>
              <table id="employee_grid" class="table table-bordered table-hover">
					<thead>
						<tr>
						<th>SNO</th>
                        <th>Trade name</th>
						<th>Generic name</th>
						<th>Type</th>
                        <th>Retail</th>
						<th>W/sale</th>
						<th>Delete</th>
						</tr>
					</thead>
				
					<tbody id="_editable_table">
						
						<?php foreach($queryRecords as $res) :?>
					     <tr data-row-id="<?php echo $res['sno'];?>">
	<td class="editable-col" contenteditable="false" col-index='0' oldVal ="<?php echo $res['sno'];?>"><?php echo $res['sno'];?></td>
	<td class="editable-col" contenteditable="true" col-index='1' oldVal ="<?php echo $res['trade_name'];?>"><?php echo $res['trade_name'];?></td>
	<td class="editable-col" contenteditable="true" col-index='2' oldVal ="<?php echo $res['generic_name'];?>"><?php echo $res['generic_name'];?></td>
	<td class="editable-col" contenteditable="true" col-index='3' oldVal ="<?php echo $res['type'];?>"><?php echo $res['type'];?></td>
	<td class="editable-col" contenteditable="true" col-index='4' oldVal ="<?php echo $res['sell_price'];?>"><?php echo $res['sell_price'];?></td>
	<td class="editable-col" contenteditable="true" col-index='5' oldVal ="<?php echo $res['wsell'];?>"><?php echo $res['wsell'];?></td>
	<td><form  method="post" action="delete_medicine.php<?php echo '?id='.$res['sno']; ?>"><input type='submit' onClick="return confirm('Are you sure you want to Delete?');" class="btn btn-danger delete"  value='Delete'>	</form></td>
   </tr>
	  <?php endforeach;?>
						
					</tbody>
				</table>
</div>
</div>
</div>
  </div>
 
 <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
 

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
					url: "server2.php",  
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

 <?php include("footer.php"); ?>    
 
 
    </body>
</html>
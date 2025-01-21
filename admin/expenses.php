<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Expenses</title>
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
  
     <link href="css/facebox.css" media="screen" rel="stylesheet" type="text/css" />

   <link href="css/chosen.min.css" rel="stylesheet" media="screen">
   
    <style type="text/css">
select.models{
  display:none;
}
select.models.active{
  display:inline-block;
}
    </style>

  
  
  <script type='text/javascript'>
	function validateForm() {
    var x = document.forms["form1"]["name"].value || document.forms["form1"]["description"].value|| document.forms["form1"]["amount"].value || document.forms["form1"]["date"].value;
	
    if (x == null || x == "") {
        alert("Field must be filled out");
        return false;
    }
}
</script>


 <script type="text/javascript">
function confirmDelete() 
{
	var msg = "Are you sure you want to delete?";       
    return confirm(msg);
}
</script>


  
</head>

<?php include_once("header.php"); ?>

  <!-- =============================================== -->

  
<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Expenses
        <small>Add new pharmacy expenses</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Add Expenses</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      
        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">All Fields are required</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

           <form role="form" method="post"  action="expenses.php" >
		   
		   </br>
              <div class="box-body">
                <div class="form-group">
                  <select name="name"  class="chzn-select" style="width:450px; height:15px" >
					<option>Select Expense type</option>

					<?php

					$result3 = $dbo->prepare("SELECT  name FROM expense_category");
						$result3->bindParam(':userid', $res);
						$result3->execute();
						for($i=0; $row = $result3->fetch(); $i++){
					?>
						<option><?php echo $row['name']; ?> </option>
					<?php
					}
					?>

					</select>
                   </div>

             </br>
                <div class="form-group">
				  <select class='main' name="source" style="width:450px; height:40px" >
  <option value='none'>Select Source</option>
  <option value='Cash'> Cash at Hand </option>
  <option value='Bank'>Cash in the Bank</option>

 
</select>

<!-- 

define each sublist as you wish,
 undefined ones wont show

-->
<select name="bank" class='models Bank' style="width:450px; height:40px">
 <option value=''>Select Bank</option>
					
					<?php

					$result3 = $dbo->prepare("SELECT* FROM bank order by ac_name  ASC");
						$result3->bindParam(':userid', $res);
						$result3->execute();
						for($i=0; $row = $result3->fetch(); $i++){
					?>
						<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?> | <?php echo $row['ac_no']; ?></option>
					<?php
					}
					?>

					</select>
</select>


                   </div>
				 <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                  <textarea name="description" cols="40" rows="5" required class="form-control" ></textarea>
                </div>
				
				
				 <div class="form-group">
                  <label for="exampleInputEmail1">Total Bill</label>
                  <input type="text"  name="total_amount"  class="form-control" id="exampleInputEmail1" required>
                </div>
				
				
				 <div class="form-group">
                  <label for="exampleInputEmail1">Amount Paid</label>
                  <input type="text"  name="amount"  class="form-control" id="exampleInputEmail1" required>
                </div>

                  <label for="exampleInputEmail1">Date</label>
                  <input type="text"  name="date"  class="form-control" value="<?php echo date("d/m/Y"); ?>" required>
	<input type="hidden" name="time" value="<?php echo date("g:i a"); ?>" />
                </div>
				  
				  <?Php
					if(isset($_SESSION['userid'])){
									}
						?>
                  <input type="hidden"  name="entrant"  class="form-control" value="<?php echo "$_SESSION[userid]"; ?>"  readonly>
              
				
				
                <div>
                <button type="submit" name="register" class="btn btn-primary">Register</button>
				
              </div>
           </div>
			   
            </form>
			
			<?php
				if (isset($_POST['register'])){
				$name=$_POST['name'];
				$description=$_POST['description'];
				$total_amount=$_POST['total_amount'];
				$amount=$_POST['amount'];
				$date=$_POST['date'];
                                $time=$_POST['time'];
				$source=$_POST['source'];
				$bank=$_POST['bank'];
				
				$entrant=$_POST['entrant'];
				
				
				
				mysqli_query($con,"INSERT INTO bills (name, description, total_amount, amount, date,time,source,bank, entrant)
					VALUES ('$name', '$description', '$total_amount', '$amount', '$date','$time', '$source', '$bank', '$entrant')")or die(mysqli_error());
				
				}
				?>
       
	
<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Recent expenses</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
					<thead>
						<tr>
                        <th>No</th>
						<th>Expense</th>
						<th>Description</th>
						
						<th>Total Bill</th>
						<th>Amount paid</th>
						<th>Payment Type</th>
                        <th>Date</th>
                     
						<th>Entrant</th>
					
						<th>Edit</th>
						<th>Delete</th>
                                                 <th>Print</th>
						</tr>
					</thead>
				
					<tbody>
						<?php 
						
						$query=mysqli_query($con, "SELECT id, name, description, total_amount, amount, source, date, entrant  FROM `bills`  ORDER BY id DESC")or die(mysqli_error());
						while($row=mysqli_fetch_array($query)){
						?>
						<tr>
						<td><?php echo $row[0]; ?></td>
						<td><?php echo $row[1]; ?></td>
					   <td><?php echo $row[2]; ?></td>
						<td><?php echo $row[3]; ?></td>
						<td><?php echo $row[4]; ?></td>
						<td><?php echo $row[5]; ?></td>
						<td><?php echo $row[6]; ?></td>
						<td><?php echo $row[7]; ?></td>
						
						
					    <td><a href="edit_expenses.php?id=<?php echo $row['id']; ?>"><input type='submit' class="btn btn-success addmore" value='Edit'>	</a></td>
						<td><a href="delete_expenses.php?id=<?php echo $row['id']; ?>"><input type='submit'  type='submit' onClick="return confirm('Are you sure you want to Delete?');" class="btn btn-danger delete" value='Delete'>	</a></td>
<td><form  method="post" action="payments.php?invoice=<?php echo $row['id']; ?>&name=<?php echo $row['name']; ?>&description=<?php echo $row['description']; ?>&date=<?php echo $row['date']; ?>&total=<?php echo $row['total_amount']; ?>&entrant=<?php echo $row['entrant']; ?>"><input type='submit'  class="btn btn-primary" value='Print'>	</form></td>
                 
						
						</tr>
						<?php } ?>
					</tbody>
				</table>
    </div>
</div>
</div>
  </div>
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>   
<script src="js/jquery.min.js"></script>   

<script src="js/facebox.js" type="text/javascript"></script>

<script src="js/chosen.jquery.min.js"></script>


        <script>
        $(function() {
<!--             $(".datepicker").datepicker(); -->
<!--             $(".uniform_on").uniform() -->;
            $(".chzn-select").chosen();
   <!--          $('.textarea').wysihtml5(); -->

        });
        </script>


    <script language="javascript">
    $(function(){
  
  $("select.main").on("change", function(){
    //remove active
    $("select.models.active").removeClass("active");
    //check if select vlass exists..if it does show it
    var subList = $("select.models."+$(this).val());
    if (subList.length){
      //it does! show it by adding active class to it
      subList.addClass("active");
    }
  });
  
});
    </script>

 <?php include_once("footer.php"); ?>    
    </body>
</html>
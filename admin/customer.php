<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Customers</title>
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

  <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">

<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="js/DT_bootstrap.js"></script>

</head>

<?php include_once("header.php"); ?>

  <!-- =============================================== -->


<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Customers List
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Customers</li>
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


           <form role="form" method="post" name='form1'  action="customer.php" >
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Customer's Name</label>
                  <input type="text"  name="name" class="form-control" id="skills" placeholder="Enter Name" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Address</label>
                  <textarea class="form-control" name="address" rows="3" placeholder="Enter Address" required></textarea>  </div>
         <div class="form-group">
                  <label for="exampleInputEmail1">Phone Number</label>
                  <input type="text"  name="phone"  class="form-control" id="exampleInputEmail1"  placeholder="Enter Phone No." required>
                </div>
                <div class="form-group">
        <label for="exampleInputEmail1">E-mail Address</label>
                  <input type="text"  name="medicine" class="form-control" id="skills" placeholder="Enter E-mail" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Notes</label>
                  <textarea class="form-control" name="notes" rows="3" placeholder="Enter ..." ></textarea>  </div>
                </br>
                  <button type="submit" name="register" class="btn btn-primary">Register</button>
                  </div>

         </br>

         </br>

            </form>

      <?php
        if (isset($_POST['register'])){
        $name=$_POST['name'];
        $address=$_POST['address'];
        $phone=$_POST['phone'];
        $medicine=$_POST['medicine'];
        $notes=$_POST['notes'];


        mysqli_query($con, "insert into customer (name,address,phone,medicine, notes) values('$name','$address','$phone','$medicine','$notes')")or die(mysqli_error());

        }
        ?>

      </div>

        <div class="box">
         <div class="box-body">


           <?php
require_once("excelwriter.class.php");

$excel=new ExcelWriter("customers.xls");
if($excel==false)
echo $excel->error;
$myArr=array("");
$myArr=array("Customers");
$excel->writeLine($myArr);
$myArr=array("");
$excel->writeLine($myArr);
$myArr=array("Customer Name","Address","Phone No","Email","Notes");
$excel->writeLine($myArr);
$qry=mysqli_query($con, "SELECT *  FROM `customer`");

if($result!=false)
{
$i=1;
while($res=mysqli_fetch_array($qry))
{
$myArr=array($res['name'],$res['address'],$res['phone'],$res['medicine'],$res['notes']);
  $excel->writeLine($myArr);
  $i++;
}
}
?>
                <a href="customers.xls"><button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                <i class="fa fa-download"></i> Download Report
              </button></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->


                        <table class="table table-bordered table-hover" id="example">

                            <thead>
                                <tr>
                                    <th style="text-align:center; background: #0080ff;" ><span class="glyphicon glyphicon-sort-by-alphabet"></span>Name</th>
                                    <th style="text-align:center; background: #0080ff;"><span class="glyphicon glyphicon-sort-by-alphabet"></span> Address</th>
                                    <th style="text-align:center; background: #0080ff;"><span class="glyphicon glyphicon-sort"></span>Phone No.</th>
                                    <th style="text-align:center; background: #0080ff;"><span class="glyphicon glyphicon-sort-by-alphabet"></span>Email</th>
                                    <th style="text-align:center; background: #0080ff;"><span class="glyphicon glyphicon-sort-by-alphabet"></span>Notes</th>
                                    <th style="text-align:center; background: #0080ff;"><span class="glyphicon "></span>Edit</th>
                                    <th style="text-align:center; background: #0080ff;"><span class="glyphicon "></span>Delete</th>

                                </tr>
                            </thead>
                            <tbody>
								<?php


				$result = $dbo->prepare("SELECT *  FROM `customer` ");

				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){

			?>

      <td><?php echo $row[1]; ?></td>
      <td><?php echo $row[2]; ?></td>
      <td><?php echo $row[3]; ?></td>
      <td><?php echo $row[4]; ?></td>
      <td><?php echo $row[5]; ?></td>
      <td><a href="edit_customer.php?id=<?php echo $row['id']; ?>"><input type='submit' class="btn btn-success addmore" value='Edit'>	</a></td>
      <td><a href="delete_customer.php?id=<?php echo $row['id']; ?>"><input type='submit'  type='submit' onClick="return confirm('Are you sure you want to Delete?');" class="btn btn-danger delete" value='Delete'>	</a></td>

			</tr>
			<?php
				}
			?>
                            </tbody>
                        </table>



        </div>
        </div>
        </div>
    </div>


    <script type="text/javascript">
    $(document).ready( function(){
        $('#example').dataTable({
        "iDisplayLength": 5,
        "aLengthMenu": [[5, 10,20, -1], [5, 10,20, "All"]],
         "bDestroy": true
        });
    });
    </script>


<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>

 <?php include_once("footer.php"); ?>
    </body>
</html>

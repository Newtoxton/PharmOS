<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Add Medicine</title>
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

<?php include_once("header.php"); ?>

  <!-- =============================================== -->


<?php include_once("sidebar.php"); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Medicine
        <small>Register New Medicines</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Add Medicine</li>
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
			  <div class="container">

           <form role="form" method="post"  action="medicine_list.php" >

                <div class="row">
                				<div class="col-xs-5">
                          <label for="exampleInputEmail1">Brand Name</label>
                          <input type="text"  name="trade_name" class="form-control" id="skills" placeholder="Enter Trade Name">
                                </div>

                          <div class="row">
                				<div class="col-xs-5">
                          <label for="exampleInputEmail1">Generic Name</label>
                          <input type="text"  name="generic_name"  class="form-control" id="exampleInputEmail1" placeholder="Enter Generic Name">

                                </div>
                				 </div>
 </div>
<br>
 <div class="row">
         <div class="col-xs-4">
           <label>Select Medicine Type</label>
           <select name="type" class="form-control">
             <option>Tablets</option>
             <option>Capsules</option>
             <option>Syrup/Suspension</option>
             <option>Injectables</option>
             <option>Drops</option>
             <option>Medical Suppllies</option>
             <option>Creams and Ointments</option>
             <option>Cosmetics</option>
             <option>Pessary/Suppository</option>
             <option>Others</option>
           required</select>
          </div>

           <div class="row">
         <div class="col-xs-3">
           <label for="exampleInputEmail1">Retail Price</label>
           <input type="text"  name="retail"  class="form-control" id="exampleInputEmail1" placeholder="Enter retail price">

                 </div>

          <div class="row">
        <div class="col-xs-3">
          <label for="exampleInputEmail1">Wholesale Price</label>
          <input type="text"  name="wsale"  class="form-control" id="exampleInputEmail1" placeholder="Enter wholesale price">

                </div>
         </div>
</div>
  </div>
<br>
                <button type="submit" name="register" class="btn btn-primary">Register</button>



            </form>
			</br>
			      </br>
			<a href="medicine_edit.php"><input type='submit' class="btn btn-success addmore" value='Edit List'> </a> </br></br>

			 </br>
			 </div>





			<?php
				if (isset($_POST['register'])){
				$generic_name=$_POST['generic_name'];
				$trade_name=$_POST['trade_name'];
				$type=$_POST['type'];
                $retail=$_POST['retail'];
                $wsale=$_POST['wsale'];


				mysqli_query($con, "insert into medicine_list (trade_name,generic_name,type,sell_price,wsell) values('$trade_name','$generic_name','$type','$retail','$wsale')")or die(mysqli_error());

				}
				?>
          </div>

        </div>
<section class="content">
      <div class="row">
        <div class="col-xs-12">

<div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Type to search Medicine</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

<div ng-controller="customersCrtl">


    <div class="row">
        <div class="col-md-2">PageSize:
            <select ng-model="entryLimit" class="form-control">
				<option>5</option>
                <option>15</option>
                <option>20</option>
                <option>50</option>
                <option>100</option>
            </select>
        </div>
        <div class="col-md-3">Filter:
            <input type="text" ng-model="search" ng-change="filter()" placeholder="Filter" class="form-control" />
        </div>
        <div class="col-md-4">
            <h5>Filtered {{ filtered.length }} of {{ totalItems}} total Medicines</h5>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-12" ng-show="filteredItems > 0">
            <table class="table table-striped table-bordered" >
            <thead>
            <th>Medicine Code&nbsp;<a ng-click="sort_by('sno');"><i class="glyphicon glyphicon-sort"></i></a></th>
            <th>Trade Name&nbsp;<a ng-click="sort_by('trade_name');"><i class="glyphicon glyphicon-sort"></i></a></th>
            <th>Generic Name&nbsp;<a ng-click="sort_by('generic_name');"><i class="glyphicon glyphicon-sort"></i></a></th>
            <th>Medicine Type&nbsp;<a ng-click="sort_by('type');"><i class="glyphicon glyphicon-sort"></i></a></th>
            <th>Retail&nbsp;<a ng-click="sort_by('sell_price');"><i class="glyphicon glyphicon-sort"></i></a></th>
            <th>Wholesale&nbsp;<a ng-click="sort_by('wsell');"><i class="glyphicon glyphicon-sort"></i></a></th>
            </thead>
            <tbody>
                <tr ng-repeat="data in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit">
                    <td>MED0{{data.sno}}</td>
                    <td>{{data.trade_name}}</td>
                    <td>{{data.generic_name}}</td>
					<td>{{data.type}}</td>
                    <td>{{data.sell_price}}</td>
                    <td>{{data.wsell}}</td>

                </tr>
            </tbody>
            </table>
        </div>
        <div class="col-md-12" ng-show="filteredItems == 0">
            <div class="col-md-12">
                <h4>No Medicine found</h4>
            </div>
        </div>
        <div class="col-md-12" ng-show="filteredItems > 0">
            <div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimit" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>


        </div>
    </div>
</div>
</div>
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>
<script src="js/jquery.min.js"></script>
 <?php include_once("footer.php"); ?>
    </body>
</html>

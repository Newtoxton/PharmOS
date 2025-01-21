<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Loans</title>
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

<script type="text/javascript">

$(document).ready(function() {
    $('#example').dataTable( {
        "sPaginationType": "bootstrap",
        "oLanguage": {},
        "aaSorting": [],
        "bDestroy": true
    });
});
</script>

<script type="text/javascript">
$(document).on('change','#check_all',function(){
	$('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
});
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
        Loans
        <small>Pay Loan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Loans</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Type Search to search</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

<div class="box">
 <div class="box-body">
<div class="table-responsive">
                     <form action="loan_pays.php" method="post">	
                        <table class="table table-bordered table-striped" id="example">
                            <thead>
                                <tr>
							
				<th><input id="check_all" class="formcontrol" type="checkbox"/></th>
                <th style="text-align:left;">No</th>
                  <th style="text-align:center;">Loan Date</th>
                  <th style="text-align:center;">Bank Name</th>
                  <th style="text-align:center;">Loan Amount</th>
                  <th style="text-align:center;">Monthly Pay</th>
                  <th style="text-align:center;">Interest Rate</th>
                  <th style="text-align:center;">Payment Period</th>
				  <th style="text-align:center;">Amount Paid</th>
                  <th style="text-align:center;">Balance Due</th>
				  <th style="text-align:center;">Edit</th>
               
				   

                  </tr>
                            </thead>
                            <tbody>
								<?php
								 $n = 0;
								 
								$result= mysqli_query($con, "SELECT l.id,l.name,l.loan,l.installment,l.start_date, l.months, l.rate,
								SUM(p.paid) npaid FROM loans AS l LEFT JOIN loan_pay AS p ON  l.id = p.t_id Group by name ORDER BY l.id ASC ") or die (mysql_error());
								while ($row= mysqli_fetch_array ($result) ){
								$id=$row['id'];
								$tm = $row['loan'];
							    $tp = $row['npaid'];
							    $bal = $tm - $tp ;
								?>
								<td><input name="selector[]" class="case" type="checkbox" value="<?php echo $id; ?>"></td>
						        <td><?php echo ++$n ;  ?> </td>
								<td style="width:100px;"> <?php echo $row ['start_date']; ?></td>
                                <td style="width:200px;"> <?php echo $row ['name']; ?></td>
								<td style="width:100px;"> <?php echo number_format ($row ['loan']) ; ?></td>
								<td style="width:150px;"> <?php echo number_format ($row ['installment']) ; ?></td>
								<td style="width:100px;"> <?php echo $row ['rate']; ?></td>
								<td style="width:100px;"> <?php echo $row ['months']; ?></td>
								<td style="width:150px;"> <?php echo number_format ($row ['npaid']) ; ?></td>
								<td style="width:150px;"> <?php echo number_format ($bal) ; ?></td>
		                        <td><form  method="post" action="#<?php echo '?id='.$row['id']; ?>"><input type='submit'  class="btn btn-success addmore" value='Edit'>	</form></td>
                                </div>
								</div>
								</tr>

								<?php } ?>
                            </tbody>
							
							
                        </table>
<button class="btn btn-success pull-right" name="submit_mult" type="submit">
		Pay Selected
	</button>
</form>


        </div>
        </div>
        </div>
    </div>





<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>

 <?php include_once("footer.php"); ?>
    </body>
</html>

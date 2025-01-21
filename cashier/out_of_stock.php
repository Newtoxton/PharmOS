<?php

include_once "../connect.php"; // database connection details stored here

?>

<!DOCTYPE html>
<html ng-app="myApp" ng-app lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Out of Stock</title>
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
  
  <script>
		(function (w, doc,co) {
			
			var u = {},
				e,
				a = /\+/g,  // Regex for replacing addition symbol with a space
				r = /([^&=]+)=?([^&]*)/g,
				d = function (s) { return decodeURIComponent(s.replace(a, " ")); },
				q = w.location.search.substring(1),
				v = '2.0.3';

			while (e = r.exec(q)) {
				u[d(e[1])] = d(e[2]);
			}
			
			if (!!u.jquery) {
				v = u.jquery;
			}	

			doc.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/'+v+'/jquery.min.js">' + "<" + '/' + 'script>');
			co.log('\nLoading jQuery v' + v + '\n');
		})(window, document, console);
		</script>
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.quicksearch.js"></script>
		<script>
			$(function () {
				/*
				Example 1
				*/
				$('input#id_search').quicksearch('table#table_example tbody tr');
				
				/*
				Example 2 
				*/
				$('input#id_search2').quicksearch('table#table_example2 tbody tr', {
					'delay': 300,
					'selector': 'th',
					'stripeRows': ['odd', 'even'],
					'loader': 'span.loading',
					'bind': 'keyup click input',
					'show': function () {
						this.style.color = '';
					},
					'hide': function () {
						this.style.color = '#ccc';
					},
					'prepareQuery': function (val) {
						return new RegExp(val, "i");
					},
					'testQuery': function (query, txt, _row) {
						return query.test(txt);
					}
				});
				
				/*
				Example 3
				*/
				var qs = $('input#id_search_list').quicksearch('ul#list_example li');
				
				$.ajax({
					'url': 'js/example.json',
					'type': 'GET',
					'dataType': 'json',
					'success': function (data) {
						for (i in data['list_items']) {
							$('ul#list_example').append('<li>' + data['list_items'][i] + '</li>');
						}
						qs.cache();
					}
				});
				
				$('input#add_to_list').click(function () {
					$('ul#list_example').append('<li>Added on click</li>');
					qs.cache();
				});

				/*
				Example 4
				*/

				
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
        Medicine Out of Stock 
        <small>All Medicines</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Out of Stock</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      
        <div class="box-body">
         <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Type medicine name to search</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

          
		
		<form action="#">
		<div class="box-body">
                <div class="form-group">
				<input type="text" name="search" value="" id="id_search" placeholder="Search" autofocus />
			</div>
		</form>

    
	
<table class="table table-bordered table-striped" id="table_example" data-responsive="table" >
	<thead>
		<tr>	
		<th> Trade Name </th>
	
		<th> Quantity Available</th>
			
			
		</tr>
	</thead>
	<tbody>
		
			<?php
				

				$result = $dbo->prepare("select c.trade_name, SUM(GREATEST(i.quantity,0)) AS Qty FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno  GROUP BY i.sno HAVING QTY <= 0");
				
				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){
				
			?>
		
			<td><?php echo $row['trade_name']; ?></td>
		
			<td><?php echo $row['Qty']; ?></td>

			

			</tr>
			<?php
				}
			?>
		
	</tbody>
	
</table>

			
			
          </div>
		  
        </div>

</div>
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>     

 <?php include_once("footer.php"); ?>    
    </body>
</html>
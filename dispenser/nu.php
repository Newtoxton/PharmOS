

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Users</title>


 <script type='text/javascript'>
		function calculate() {
		var myBox1 = document.getElementById('box1').value;	
		var myBox2 = document.getElementById('box2').value;
		var result = document.getElementById('result');	
		var myResult = myBox1 * myBox2;
		result.value = myResult;
	}
</script>

  
</head>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Users
        <small>Create new system users</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Add Users</li>
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
<table width="80%" border="0">
  <tr>
    <th>Box 1</th>
    <th>Box 2</th>
    <th>Result</th>
  </tr>
  <tr>
    <td><input id="box1" type="text" oninput="calculate()" /></td>
    <td><input id="box2" type="text" oninput="calculate()" /></td>
    <td><input id="result" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
      
</div>
</div>
  </div>
  
    </body>
</html>



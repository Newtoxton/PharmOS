<?php

include_once "../connect.php"; // database connection details stored here


	
		$id = 1;
		$stmt_edit = $dbo->prepare('SELECT * FROM settings WHERE id= :userid');
		$stmt_edit->execute(array(':userid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	

	
	if(isset($_POST['register']))
	{
		$id = $_POST['memi'];
		$a = $_POST['name'];
		$b = $_POST['address'];
		$c = $_POST['phone'];
		$d = $_POST['email'];
		$e = $_POST['country'];
		$f = $_POST['address2'];
		$g = $_POST['currency'];
		$h = $_POST['level'];
		$i = $_POST['timezone'];
			
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
					
		if($imgFile)
		{
			$upload_dir = '../uploads/'; // upload directory	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			$userpic = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					unlink($upload_dir.$edit_row['image']);
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else
				{
					$errMSG = "Sorry, your file is too large it should be less then 5MB";
				}
			}
			else
			{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}	
		}
		else
		{
			// if no image selected the old image remain as it is.
			$userpic = $edit_row['logo']; // old image from database
		}	
						
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
		$sql = "UPDATE settings
        SET name=?, address=?, phone=?, email=?, country=?, address2=?, currency=?, level=?, logo=?, timezone=?
		WHERE id=?";
		$q = $dbo->prepare($sql);
		$q->execute(array($a,$b,$c,$d,$e,$f,$g,$h,$userpic,$i,$id));
		header("location: settings.php");
		
		
		}
		
						
	}
	
?>

<!DOCTYPE html>
<html  lang="en">
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rx Tera | Settings</title>
	<!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  
  <link rel="stylesheet" href="../bootstrap/css/select2.css">
  
  <link rel="stylesheet" href="../bootstrap/css/select2-bootstrap.css">
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
        Global settings
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="index.php">Admin</a></li>
        <li class="active">Add Settings</li>
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
			<?php
	$id= 1;
	$result = $dbo->prepare("SELECT * FROM settings WHERE id= :userid");
	$result->bindParam(':userid', $id);
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
		
		?>
		
		<form method="post" enctype="multipart/form-data" class="form-horizontal">
		   
		   <?php
	if(isset($errMSG)){
		?>
        <div class="alert alert-danger">
          <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
        </div>
        <?php
	}
	?>

		   <div class="container">
		   </br>
		   <div class="row">
		   <div class="col-xs-10">
		   
		  <label for="exampleInputEmail1">Pharmacy Name</label>
		  <input type="hidden" name="memi" value="<?php echo $id; ?>" />
          <input type="text"  name="name" class="form-control" id="skills"  value="<?php echo $row['name']; ?>">
          </div>
		  </div>
		   </br>
              <div class="row">
        <div class="col-xs-5">
		
                <label for="exampleInputEmail1">Address Line 1</label>
                  <input type="text"  name="address"  class="form-control" value="<?php echo $row['address']; ?>">
                </div>
                 
               <div class="col-xs-5">
                  <label for="exampleInputEmail1">Address Line 2</label>
                  <input type="text"  name="address2"  class="form-control" value="<?php echo $row['address2']; ?>">
                </div>
				
			</div>
			</br>
				 <div class="row">
        <div class="col-xs-5">
                  <label for="exampleInputEmail1">Phone Number</label>
                  <input type="text"  name="phone"  class="form-control"value="<?php echo $row['phone']; ?>" >
                </div>
				
				<div class="col-xs-5">
                  <label for="exampleInputEmail1">E-mail</label>
                  <input type="text"  name="email"  class="form-control" value="<?php echo $row['email']; ?>" >
                </div>
				</div>
			
				</br>
				
				
			 <div class="row">
				<div class="col-xs-5">
                  <label for="exampleInputEmail1">Currency Symbol</label>
                  <input type="text"  name="currency"  class="form-control" value="<?php echo $row['currency']; ?>" >
                </div>	
				
				<div class="col-xs-5">
                  <label for="exampleInputEmail1">Country</label>
                  <input type="text"  name="country"  class="form-control" value="<?php echo $row['country']; ?>" >
                </div>
				
				</div>
					</br>
				
				 <div class="row">
				<div class="col-xs-5">
                  <label for="exampleInputEmail1">Tagline</label>
                  <input type="text"  name="level"  class="form-control" value="<?php echo $row['level']; ?>" >
                </div>	
				<div class="col-xs-5">
                  <label for="exampleInputEmail1">Time Zone (<a href="http://php.net/manual/en/timezones.php" target='_blank'>Check your Time Zone here</a> )</label>
				 
        	    <input class="form-control"  type="text" name="timezone" value="<?php echo $row['timezone']; ?>" /> 

				  </div>
				</div>	
				</br>
				</br>
				 <div class="row">
				<div class="col-xs-5">
                  <label for="exampleInputEmail1">Logo</label>
				 <p><img src="../uploads/<?php echo $row['logo']; ?>"  width="200" /></p>
				 </br>
        	<input class="input-group" type="file" name="user_image" accept="image/*" /> 

				  </div>
				</div>	
				
				</br>
                <div>
                <button type="submit" name="register" class="btn btn-primary">Submit</button>
				
              </div>
           </div>
			   <?php
}
?> 
            </form>
			</br>
</br>
</br>
</div>
</div>
  </div>
<script src="js/angular.min.js"></script>
<script src="js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="app/app.js"></script>   
<script src="js/jquery.min.js"></script> 
<script src="//select2.github.io/select2/select2-3.4.2/select2.js"></script>
<script>
	$( ".select2" ).select2( { placeholder: "Select a State", maximumSelectionSize: 6 } );

	$( ":checkbox" ).on( "click", function() {
		$( this ).parent().nextAll( "select" ).select2( "enable", this.checked );
	});

	$( "#demonstrations" ).select2( { placeholder: "Select2 version", minimumResultsForSearch: -1 } ).on( "change", function() {
		document.location = $( this ).find( ":selected" ).val();
	} );

	$( "button[data-select2-open]" ).click( function() {
		$( "#" + $( this ).data( "select2-open" ) ).select2( "open" );
	});
</script>

 <script type="text/javascript">
function confirmDelete() 
{
	var msg = "Are you sure you want to delete?";       
    return confirm(msg);
}
</script>  

 <?php include_once("footer.php"); ?>    
    </body>
</html>
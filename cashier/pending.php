<?php
// configuration
include_once('../connect.php');



$id=$_GET['id'];

$N = count($id);

$query = mysqli_query($con, "UPDATE sales_details SET cash='No' WHERE id = '$id'");



if($query)
	{
		?>
        <script>
		alert('<?php echo $N." record marked as Pending !!!"; ?>');
		window.location.href='sales_pending.php';
		</script>
        <?php
	}
	else
	{
		?>
        <script>
		alert('error while returning , TRY AGAIN');
		</script>
        <?php
	}



?>
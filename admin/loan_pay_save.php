<?php
include_once "../connect.php";


$a = $_POST['id'];
$b = $_POST['pay'];
$c = $_POST['entrant'];
$d = $_POST['hand'];
$e = $_POST['bank'];

$N = count($a);
for($i=0; $i < $N; $i++)
{
	$result = mysqli_query($con, "insert into loan_pay (t_id,paid,entrant,hand,bank) values('$a[$i]','$b[$i]','$c[$i]','$d[$i]','$e[$i]')")or die(mysqli_error());

if($result)
	{
		?>
        <script>
		alert('<?php echo $N." Loans Have been Paid"; ?>');
		window.location.href='loan_pay.php';
		</script>
        <?php
	}
	else
	{
		?>
        <script>
		alert('error while Paying, TRY AGAIN');
		</script>
        <?php
	}	
	
	
	
	}

?>
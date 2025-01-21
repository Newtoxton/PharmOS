<?php
include_once "../connect.php";


$a = $_POST['id'];
$b = $_POST['pay'];
$c = $_POST['entrant'];
$d = $_POST['hand'];
$e = $_POST['customer'];

$N = count($a);
for($i=0; $i < $N; $i++)
{
	$result = mysqli_query($con, "insert into credit_pay (t_id,cust,paid,entrant,hand) values('$a[$i]','$e[$i]','$b[$i]','$c[$i]','$d[$i]')")or die(mysqli_error());

if($result)
	{
		?>
        <script>
		alert('<?php echo $N." Invoices Have been Paid"; ?>');
		window.location.href='credit_report.php?d1=0&d2=0&customer=0';
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

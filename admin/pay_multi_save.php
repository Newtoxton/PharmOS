<?php
include_once "../connect.php";


$a = $_POST['id'];
$b = $_POST['pay'];
$c = $_POST['entrant'];
$d = $_POST['hand'];
$e = $_POST['bank'];
$f = $_POST['ck_no'];
$g = $_POST['supplier'];

$N = count($a);
for($i=0; $i < $N; $i++)
{
	$result = mysqli_query($con, "insert into supplier_pay (t_id,paid,entrant,hand,bank,ck_no,supp) values('$a[$i]','$b[$i]','$c[$i]','$d[$i]','$e[$i]','$f[$i]','$g[$i]')")or die(mysqli_error());

if($result)
	{
		?>
        <script>
		alert('<?php echo $N." Invoices Have been Paid"; ?>');
		window.location.href='pay_supplier_mult.php';
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

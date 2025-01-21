<?php

include_once "../connect.php"; // database connection details stored here

?>


        <form action="incoming.php" method="post" >
									<select name="product" style="width:950px; "class="chzn-select" required>
									<option></option>
									<?php
									$result = $dbo->prepare("select p.sno,p.cat,p.name,p.engine,p.vehicle,p.partNo, i.pid,i.quantity FROM `product_list` AS p INNER JOIN `sh_inventory` AS i ON p.sno = i.sno  WHERE quantity > 0;");
									$result->bindParam(':userid', $res);
									$result->execute();
									for($i=0; $row = $result->fetch(); $i++){
									?>
									<option value="<?php echo $row['pid'];?>"> <?php echo $row['cat']; ?>  | <?php echo $row['name']; ?> | Cost @ <?php echo $row['engine']; ?> | Price @ <?php echo $row['vehicle']; ?> | Expires on: <?php echo $row['partNo']; ?> | Qty Left: <?php echo $row['quantity']; ?></option>
									<?php
									 }
									?>
									</select>

								</form>
        

			<?php
	include_once('../connect.php');
	$id=$_GET['id'];
	$result = $db->prepare("SELECT * FROM supplier WHERE id= :userid");
	$result->bindParam(':userid', $id);
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
?>

           <form role="form" method="post"  action="saveeditsupplier.php" >
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Supplier Name</label>
				  <input type="hidden" name="memi" value="<?php echo $id; ?>" />
                  <input type="text"  name="name" class="form-control" id="skills"  value="<?php echo $row['name']; ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Address</label>
                  <textarea class="form-control" name="address" rows="3"  value="<?php echo $row['address']; ?>"></textarea>  </div>
				 <div class="form-group">
                  <label for="exampleInputEmail1">Phone Number</label>
                  <input type="text"  name="phone"  class="form-control" id="exampleInputEmail1"  value="<?php echo $row['phone']; ?>">
                </div>
                <div class="form-group">
				<label for="exampleInputEmail1">Contact Person</label>
                  <input type="text"  name="contact_person" class="form-control" id="skills"  value="<?php echo $row['contact_person']; ?>">
                </div>
				
                <div class="form-group">
                  <label for="exampleInputEmail1">Notes</label>
                  <textarea class="form-control" name="notes" rows="3"  value="<?php echo $row['notes']; ?>"></textarea>  </div>
                  </div>
                <div>
                <button type="submit" name="register" class="btn btn-primary">Register</button>
                </div>
			
         </br>
		 
         </br>
		   
            </form>		   
          <?php
}
?> 
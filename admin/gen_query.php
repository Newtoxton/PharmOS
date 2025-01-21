<?php
if(isset( $_SESSION['Insufficient']))
{

  ?>
  Insufficient stock for the following medicine(s):
          <ol>

  <?php
  foreach ($_SESSION['Insufficient'] as $tab)
  {
    ?>

      <li>
             <?php echo  $tab; ?>

      </li>
            <?php
  }
}

          ?>
    </ol>



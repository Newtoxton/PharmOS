<?php
// ../documentation/index.html
include_once('../connect.php');
				
?>


<!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-center image">
          <img src="../uploads/<?php echo $logo; ?>" class="img-rounded" width="150px" height="150px" />
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="index.php?d1=0">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>

				
	
       
	<li>
				<a href="daily.php?d1=0">
					 <i class="fa fa-money"></i> <span>Transaction Report</span>
				 </a>
			 </li>


             <li><a href="sales_reporta.php?d1=0&d2=0" ><i class="fa fa-money"></i> <span>Sales Report</span></a></li>
			 
			 
			 <li class="treeview">
          <a href="expenses.php">
            <i class="fa fa-pie-chart"></i>
            <span>Expenditures</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
		    <li class="active"><a href="expenses.php"><i class="fa fa-circle-o"></i> Add Expenses</a></li>
			<li><a href="expenses_report.php?d1=0&d2=0"><i class="fa fa-circle-o text-red"></i> <span>Expenses Report</span></a></li>

          </ul>
        </li>
        


            
	
		

        <li><a href="../documentation/index.html" target= "blank"><i class="fa fa-book"></i> <span>Help</span></a></li>
		
		
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

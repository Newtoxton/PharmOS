<?php
// ../documentation/index.html
include_once('../connect.php');


				$result = $dbo->prepare("SELECT * FROM users ");
				$result->execute();
				$rowcount = $result->rowcount();


				$result = $dbo->prepare("SELECT * FROM supplier");
				$result->execute();
				$rowcount123 = $result->rowcount();


				$result = $dbo->prepare("SELECT * FROM customer");
				$result->execute();
				$rowcount1234 = $result->rowcount();


				$result = $dbo->prepare("select c.trade_name, c.generic_name, i.quantity, i.expiry_date , i.batch  FROM `medicine_list` AS c INNER JOIN `inventory` AS i ON c.sno = i.sno WHERE date_format(`expiry_date`, '%Y-%m-%d') < NOW() + INTERVAL 3 MONTH  AND  `quantity` > 0 AND date_format(`expiry_date`, '%Y-%m-%d') > curdate() ORDER BY expiry_date ASC")or die(mysql_error());
				$result->execute();
				$rowcount12345 = $result->rowcount();


				$result = $dbo->prepare("SELECT * FROM bank");
				$result->execute();
				$rowcount123456 = $result->rowcount();


				$result = $dbo->prepare("select
	c.trade_name,
    c.bin,
	SUM(
		GREATEST(i.quantity, 0)
	) AS Qty
FROM
	`medicine_list` AS c
	INNER JOIN `inventory` AS i ON c.sno = i.sno
GROUP BY
	i.sno
HAVING
	Qty < bin");
				$result->execute();
				$rowcount6 = $result->rowcount();


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
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>


				<li>
				 <a href="pos.php">
					<i class="fa fa-money"></i> <span>POS - Retail</span>
				  </a>
				</li>


					<li>
				<a href="posw.php">
					 <i class="fa fa-cart-plus"></i> <span>POS - Wholesale</span>
				 </a>
			 </li>



		<li class="treeview">
          <a href="sales.php">
            <i class="fa fa-search"></i>
            <span>Sales History</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
		  <li class="active"><a href="sales.php"><i class="fa fa-circle-o text-white"></i>Retail</a></li>
		  <li><a href="salesw.php"><i class="fa fa-circle-o text-red"></i>W/sale</a></li>
			 <li><a href="invoice_list.php"><i class="fa fa-circle-o text-yellow"></i>Invoices</a></li>
			<li><a href="sales_search.php"><i class="fa fa-circle-o text-blue"></i>Sales Search</a></li>
          </ul>
        </li>



				<li class="treeview">
	          <a href="signup.php">
	            <i class="fa fa-users"></i>
	            <span>System users</span>
	            <span class="pull-right-container">

	              <small class="label pull-right bg-blue"><?php echo $rowcount;?></small>
	            </span>
	          </a>
	          <ul class="treeview-menu">
			  <li class="active"><a href="signup.php"><i class="fa fa-circle-o text-white"></i>Create User</a></li>
				<li><a href="user_log.php?d1=0&d2=0"><i class="fa fa-circle-o text-red"></i>User Log</a></li>

	          </ul>
	        </li>


<li>
<a href="supplier.php">
            <i class="fa fa-area-chart"></i> <span>Suppliers</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow"><?php echo $rowcount123;?></small>
            </span>
          </a>
        </li>






		<li>
          <a href="customer.php">
            <i class="fa fa-smile-o"></i> <span>Customers</span>
            <span class="pull-right-container">

              <small class="label pull-right bg-green"><?php echo $rowcount1234;?></small>

            </span>
          </a>
        </li>

			<li>
          <a href="deposit.php">
            <i class="fa fa-bank"></i> <span>Bank</span>
            <span class="pull-right-container">

              <small class="label pull-right bg-orange"><?php echo $rowcount123456;?></small>

            </span>
          </a>
        </li>

		<li>
          <a href="expiry.php">
            <i class="fa fa-warning"></i> <span>Soon Expiring</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red"><?php echo $rowcount12345;?></small>
            </span>
          </a>
        </li>


        <li class="treeview active">
          <a href="products.php">
            <i class="fa fa-cubes"></i> <span>Medicine Inventory</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             <li class="active"><a href="products.php"><i class="fa fa-circle-o"></i>Inventory</a></li>
            <li><a href="medicine_list.php"><i class="fa fa-circle-o text-green"></i>Medicine List</a></li>
			<li><a href="add_medicine.php"><i class="fa fa-circle-o text-orange"></i>Add Stock</a></li>
<li><a href="inventory.php"><i class="fa fa-circle-o text-blue"></i>Purchase History</a></li>
<li><a href="purchase_report_all.php?supplier=0&d1=0&d2=0"><i class="fa fa-circle-o text-red"></i>Purchase Report - Supplier</a></li>
<li><a href="purchase_report.php?d1=0&d2=0"><i class="fa fa-circle-o text-blue"></i>Purchase Report - All</a></li>
  <li><a href="stock_card.php?brand=0"><i class="fa fa-circle-o text-orange"></i>Stock Card</a></li>
   <li><a href="inline.php?brand=0"><i class="fa fa-circle-o text-green"></i>Qiuck Edit</a></li>

            <li><a href="expiry.php"><i class="fa fa-circle-o text-yellow"></i>Soon Expiring</a></li>
			 <li><a href="expired.php"><i class="fa fa-circle-o text-red"></i>Expired Medicine</a></li>
          </ul>
        </li>

			<li class="treeview">
          <a href="expenses.php">
            <i class="fa fa-pie-chart"></i>
            <span>Expenditures</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
		  <li class="active"><a href="expenses.php"><i class="fa fa-circle-o text-white"></i>Expenses</a></li>
			<li><a href="expense_category.php"><i class="fa fa-circle-o text-red"></i>Expenses Category</a></li>
			 <li><a href="expenses_report.php?d1=0&d2=0"><i class="fa fa-circle-o"></i>Expenses Report</a></li>

          </ul>
        </li>

		<li class="treeview">
          <a href="loan_pay.php">
            <i class="fa fa-briefcase"></i>
            <span>Loans</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
		  <li class="active"><a href="loan_registration.php"><i class="fa fa-circle-o text-white"></i>Loan Registration</a></li>
			<li><a href="loan_pay.php"><i class="fa fa-circle-o text-yellow"></i>Loan Payments</a></li>


          </ul>
        </li>

		<li class="treeview">
          <a href="daily_report.php?d1=0&d2=0">
            <i class="fa fa-archive"></i>
            <span>Accounts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
	     <li><a href="tpl.php?d1=0&d2=0"><i class="fa fa-circle-o"></i>Trading Profit and Loss Account</a></li>
			 <li><a href="bs.php?d1=0&d2=0"><i class="fa fa-circle-o text-orange"></i>Balance Sheet</a></li>
	      <li><a href="payment_report.php?d1=0&d2=0&customer=0"><i class="fa fa-circle-o"></i>Credit Payments</a></li>
		   <li><a href="supply_report.php?d1=0&d2=0&supplier=0"><i class="fa fa-circle-o text-green"></i>Debit Payments</a></li>
		   <li><a href="credit_report.php?d1=0&d2=0&customer=0"><i class="fa fa-circle-o text-orange"></i>Credit Report</a></li>
		    <li><a href="debt_report.php?d1=0&d2=0&supplier=0"><i class="fa fa-circle-o text-red"></i>Debit Report</a></li>
			<li><a href="debt.php"><i class="fa fa-circle-o text-yellow"></i>Debit Summary</a></li>
			<li><a href="credit.php"><i class="fa fa-circle-o text-blue"></i>Credit Summary</a></li>
	      </ul>



		<li class="treeview">
          <a href="sales_report.php?d1=0&d2=0">
            <i class="fa fa-folder"></i>
            <span>Sales Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                     <li><a href="sale_today.php"><i class="fa fa-circle-o text-green"></i>Today</a></li>
                     <li><a href="sale_yesterday.php"><i class="fa fa-circle-o text-blue"></i>Yesterday</a></li>
                     <li><a href="sale_week.php"><i class="fa fa-circle-o text-white"></i>Last 7 days</a></li>
                     <li><a href="sale_month.php"><i class="fa fa-circle-o text-red"></i>Last Month</a></li>
					  <li><a href="monthly.php"><i class="fa fa-circle-o text-red"></i>Cumulative</a></li>
		     <li><a href="sales_reporta.php?d1=0&d2=0"><i class="fa fa-circle-o text-yellow"></i>Sales Report - All</a></li>
			  <li><a href="sales_report.php?d1=0&d2=0&type=0"><i class="fa fa-circle-o text-blue"></i>Sales Report - Sort</a></li>
<li><a href="daily.php?d1=0"><i class="fa fa-circle-o text-red"></i>Daily Report</a></li>
			 <li><a href="sales_report_customer.php?d1=0&d2=0&name=0"><i class="fa fa-circle-o text-blue"></i>Sales Report - Customer</a></li>
<li><a href="sales_report_dispenser.php?d1=0&d2=0&name=0"><i class="fa fa-circle-o text-green"></i>Sales Report - Dispenser</a></li>
		   <li><a href="sales_report_dru.php?d1=0&d2=0&brand=0"><i class="fa fa-circle-o"></i>Sales Report - Item</a></li>
		    <li><a href="sales_report_cat.php?d1=0&d2=0&brand=0"><i class="fa fa-circle-o"></i>Sales Report - Category</a></li>
        </ul>
        </li>


			 <li class="treeview">
		 			<a href="invoice.php">
		 				<i class="fa fa-credit-card"></i>
		 				<span>Invoice</span>
		 				<span class="pull-right-container">
		 					<i class="fa fa-angle-left pull-right"></i>
		 				</span>
		 			</a>
		 			<ul class="treeview-menu">
		 	<li class="active"><a href="invoice.php"><i class="fa fa-circle-o text-green"></i>Invoice</a></li>
		 	<li><a href="posi.php"><i class="fa fa-circle-o text-yellow"></i>Proforma Invoice</a></li>
		 	<li><a href="proforma_list.php"><i class="fa fa-circle-o text-blue"></i>Proforma History</a></li>
		 			</ul>
		 		</li>


<li class="treeview">
          <a href="procurement.php">
            <i class="fa fa-shopping-cart"></i>
            <span>Procurement</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                          <li><a href="procurement_report.php?d1=0&d2=0"><i class="fa fa-circle-o"></i>Procurement Report</a></li>
	                 <li><a href="sales_report_product.php?d1=0&d2=0"><i class="fa fa-circle-o text-blue"></i>Sales - Amount</a></li>
			 <li><a href="sales_report_amount.php?d1=0&d2=0"><i class="fa fa-circle-o text-green"></i>Sales - Quantity</a></li>

	    <li><a href="out_of_stock.php"><i class="fa fa-circle-o text-yellow"></i>Out of Stock</a></li>
	    <li><a href="order.php"><i class="fa fa-circle-o text-aqua"></i>Below Re-order Level</a></li>
			 <li><a href="procurement.php"><i class="fa fa-circle-o text-orange"></i>Submit Request</a></li>
			 <li><a href="credit_list.php"><i class="fa fa-circle-o text-blue"></i>Credit Notes</a></li>

          </ul>
        </li>



		<li><a href="settings.php"><i class="fa fa-cog fa-fw"></i> <span>Settings</span></a></li>

        <li><a href="../documentation/index.html" target= "blank"><i class="fa fa-book"></i> <span>Help</span></a></li>



      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

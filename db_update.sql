

DROP VIEW IF EXISTS `general_sales`;
CREATE VIEW `general_sales` AS select `c`.`trade_name` AS `trade_name`,`inv`.`pid` AS `pid`,`inv`.`invoice_id` AS `invoice_id`,`inv`.`sno` AS `sno`,`inv`.`batch` AS `batch`,`inv`.`cost_price` AS `cost_price`,`inv`.`quantity` AS `quantity`,`inv`.`qty_sold` AS `qty_sold`,`inv`.`expiry_date` AS `expiry_date`,`inv`.`datetime` AS `datetime`,`c`.`generic_name` AS `generic_name`,`s`.`quantity` AS `sales_qtt` from ((`medicine_list` `c` join `sales_list` `s` on(`c`.`sno` = `s`.`sno`)) join `inventory` `inv` on(`c`.`sno` = `inv`.`sno`)) ;


DROP TABLE IF EXISTS `v_batched_inventory`;
DROP VIEW IF EXISTS `v_batched_inventory`;
CREATE VIEW `v_batched_inventory` AS select `c`.`trade_name` AS `trade_name`,`sd`.`entrant` AS `entrant`,sum(distinct `inv`.`quantity`) AS `batched_quantity`,`inv`.`batch` AS `batch`,`sd`.`customer` AS `customer`,`inv`.`pid` AS `pid`,`inv`.`expiry_date` AS `expiry_date`,`inv`.`quantity` AS `quantity`,`inv`.`sno` AS `sno`,`c`.`generic_name` AS `generic_name`,`sd`.`id` AS `id`,`sd`.`date` AS `date` from (((`medicine_list` `c` join `inventory` `inv` on(`c`.`sno` = `inv`.`sno`)) left join `sales_list` `sl` on(`inv`.`sno` = `sl`.`sno`)) left join `sales_details` `sd` on(`sl`.`invoice` = `sd`.`id`)) group by `inv`.`batch` ;



 DROP TABLE IF EXISTS `v_grouped_sales`;
 DROP VIEW IF EXISTS `v_grouped_sales`;
CREATE VIEW `v_grouped_sales` AS select `general_sales`.`sno` AS `sno`,`general_sales`.`trade_name` AS `trade_name`,`general_sales`.`sales_qtt` AS `sales_qtt`,`general_sales`.`generic_name` AS `generic_name`,sum(`general_sales`.`quantity`) AS `total_quantity` from `general_sales` group by `general_sales`.`sno`;


 DROP TABLE IF EXISTS `v_inventory`;
 DROP VIEW IF EXISTS `v_inventory`;
CREATE VIEW `v_inventory` AS select `c`.`trade_name` AS `trade_name`,`inv`.`pid` AS `pid`,`inv`.`invoice_id` AS `invoice_id`,`inv`.`sno` AS `sno`,`inv`.`batch` AS `batch`,`inv`.`cost_price` AS `cost_price`,`inv`.`quantity` AS `quantity`,`inv`.`qty_sold` AS `qty_sold`,`inv`.`expiry_date` AS `expiry_date`,`inv`.`datetime` AS `datetime`,`c`.`generic_name` AS `generic_name`,sum(distinct `inv`.`quantity`) AS `total_available` from (`medicine_list` `c` join `inventory` `inv` on(`c`.`sno` = `inv`.`sno`)) group by `inv`.`sno` ;

 DROP TABLE IF EXISTS `v_inventory_sales`;
 DROP VIEW IF EXISTS `v_inventory_sales`;
 CREATE VIEW `v_inventory_sales` AS select `c`.`trade_name` AS `trade_name`,`inv`.`pid` AS `pid`,`inv`.`invoice_id` AS `invoice_id`,`inv`.`sno` AS `sno`,`inv`.`batch` AS `batch`,`inv`.`cost_price` AS `cost_price`,`inv`.`quantity` AS `quantity`,`inv`.`qty_sold` AS `qty_sold`,`inv`.`expiry_date` AS `expiry_date`,`inv`.`datetime` AS `datetime`,`c`.`generic_name` AS `generic_name`,sum(`sl`.`quantity`) AS `total_sales_quantity`,sum(distinct `inv`.`quantity`) AS `total_available` from ((`medicine_list` `c` join `inventory` `inv` on(`c`.`sno` = `inv`.`sno`)) join `sales_list` `sl` on(`inv`.`sno` = `sl`.`sno`)) group by `inv`.`sno` ;

<!DOCTYPE html>
<html lang="en">
    <head>

        <title>Graph</title>

    </head>
    <script src="js/jquery.js" type="text/javascript"></script>


    <script type="application/javascript" src="js/awesomechart.js"> </script>

<?php
mysql_select_db('rx_tera',mysql_connect('localhost','root',''))or die(mysql_error());
?>
  
<body>
            
              
                  
                           
                               
                                  
                                    <canvas id="motorcycle_graph" width="300" height="400">
                                        Your web-browser does not support the HTML 5 canvas element.
                                    </canvas>
                             
                       
						



<script type="application/javascript">
    var motorcycle_chart = new AwesomeChart('motorcycle_graph');
    motorcycle_chart.data = [
    <?php
    $query = mysql_query("SELECT entrant, sum(amount) AS Total FROM sales_list  GROUP BY entrant ORDER BY Total DESC") or die(mysql_error());
    while ($row = mysql_fetch_array($query)) {
        ?>
        <?php echo $row['Total'] . ','; ?>	
    <?php }; ?>
    ];

    motorcycle_chart.labels = [
    <?php
    $query = mysql_query("SELECT entrant, sum(amount) AS Total FROM sales_list  GROUP BY entrant ORDER BY Total DESC") or die(mysql_error());
    while ($row = mysql_fetch_array($query)) {
        ?>
        <?php echo "'" . $row['entrant'] . "'" . ','; ?>	
    <?php }; ?>
    ];
    motorcycle_chart.colors = ['green', 'skyblue', '#FF6600', 'black', 'darkblue', 'lightpink', 'green'];
    motorcycle_chart.randomColors = true;
    motorcycle_chart.animate = true;
    motorcycle_chart.animationFrames = 30;
    motorcycle_chart.draw();
</script>
                




   
</body>
</html>



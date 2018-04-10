<?php

include('lib/common.php');
// written by GTusername4
if($showQueries){
    array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");
}
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
// ERROR: demonstrating SQL error handlng, to fix
// replace 'sex' column with 'gender' below:
if( $_SERVER['REQUEST_METHOD'] == 'POST') {

    $enteredType = mysqli_real_escape_string($db, $_POST['tool_type']);
    $enteredKeyword = mysqli_real_escape_string($db, $_POST['custom_search']);
    $sql1="CREATE OR REPLACE VIEW customer_report AS
SELECT DISTINCT(tool.tool_number), tooltype,power_source,sub_option,sub_type,tool_length,width_diameter,tool_weight,manufacturer,purchase_price,purchase_price*0.15 AS rental_price,purchase_price*0.4 AS rental_deposit,
(CASE WHEN COUNT(rent_start_date)>=50 
            THEN 'For_Sale'
      WHEN (
	        service_start_date<=CURDATE()
	        AND
			service_end_date>=CURDATE()
			)
			THEN 'In-Repair'
	  WHEN	sale_date IS NOT NULL 
	        THEN 'Sold'
      WHEN  (
             reservation_start_date<=CURDATE()
             AND
             rent_end_date IS NULL AND reservation_end_date >=CURDATE()
             )
            THEN 'Rented'
	  ELSE  'Available' END ) AS tool_status,
(CASE WHEN (
	        service_start_date<=CURDATE()
	        AND
			service_end_date>=CURDATE()
			)
			THEN service_end_date
	  WHEN	sale_date IS NOT NULL 
	        THEN sale_date
      WHEN  (
            reservation_start_date<=CURDATE()
             AND
             reservation_end_date>= CURDATE()
             AND
             rent_end_date IS NULL
             )
            THEN reservation_end_date
	  ELSE  ' ' END ) AS expected_date,
(CASE WHEN sale_date IS NOT NUll 
            THEN purchase_price/2
     ELSE  0 END )  AS sale_profit,
(CASE WHEN total_service_cost IS NOT NUll 
            THEN total_service_cost+purchase_price
     ELSE  0 END )  AS total_cost,
 (CASE WHEN total_rent_days IS NOT NUll 
            THEN total_rent_days*purchase_price*0.15
     ELSE  0 END )  AS rent_profit,
  (CASE WHEN sale_date IS NOT NUll 
            THEN purchase_price/2
     ELSE  0 END )  -
(CASE WHEN total_service_cost IS NOT NUll 
            THEN total_service_cost+purchase_price
     ELSE  purchase_price END )  +
 (CASE WHEN total_rent_days IS NOT NUll 
            THEN total_rent_days*purchase_price*0.15
     ELSE  0 END )       AS  total_profit   

FROM tool
LEFT JOIN purchaseorderdetail
ON tool.tool_number = purchaseorderdetail.tool_number
LEFT JOIN purchaseOrder
ON purchaseorder.sale_id = purchaseorderdetail.sale_id
LEFT JOIN(SELECT tool.tool_number,SUM(repair_cost) AS total_service_cost
FROM serviceorder INNER JOIN tool
ON serviceorder.tool_number=tool.tool_number
GROUP BY tool_number) AS Totalservicecost
ON tool.tool_number=Totalservicecost.tool_number
LEFT JOIN(SELECT tool_number, SUM(CASE WHEN DATEDIFF(rent_start_date,rent_end_date)=0
            THEN 1
     ELSE  DATEDIFF(rent_start_date,rent_end_date) END )  AS total_rent_days
FROM reservationorder INNER JOIN reservationorderdetail
ON reservationorderdetail.reservation_id=reservationorder.reservation_id
GROUP BY tool_number) AS Totalrentdays
ON tool.tool_number=Totalrentdays.tool_number
LEFT JOIN  serviceorder
on tool.tool_number=serviceorder.tool_number
LEFT JOIN reservationorderdetail
ON tool.tool_number=reservationorderdetail.tool_number
LEFT JOIN reservationorder
ON reservationorder.reservation_id=reservationorderdetail.reservation_id
GROUP BY tool_number,service_start_date,service_end_date,sale_date,rent_start_date,rent_end_date,reservation_start_date,reservation_end_date
ORDER BY tool.tool_number";
    mysqli_query($db, $sql1);
    if ($enteredType == 'all_tools') {
        if ($enteredKeyword == null) {
            $query_all = "SELECT * FROM customer_report ";
        } else {
            $query_all = "SELECT * FROM customer_report WHERE 
             tool_number LIKE '%$enteredKeyword%' OR
             tool_status LIKE '%$enteredKeyword%' OR
             expected_date LIKE '%$enteredKeyword%' OR
            power_source LIKE '%$enteredKeyword%' OR
             sub_option LIKE '%$enteredKeyword%' OR
             sub_type LIKE '%$enteredKeyword%' OR
             tool_length LIKE '%$enteredKeyword%' OR
             width_diameter LIKE '%$enteredKeyword%' OR
             tool_weight LIKE '%$enteredKeyword%' OR
              manufacturer LIKE '%$enteredKeyword%' OR
            purchase_price LIKE '%$enteredKeyword%' ";
        }
    }
    else
        {
            if ($enteredKeyword == null) {
                $query_all = "SELECT * FROM customer_report WHERE tooltype='$enteredType' ";
            } else {
                $query_all = "SELECT * FROM customer_report WHERE tooltype='$enteredType' AND (
             tool_number LIKE '%$enteredKeyword%' OR
             tool_status LIKE '%$enteredKeyword%' OR
             expected_date LIKE '%$enteredKeyword%' OR
            power_source LIKE '%$enteredKeyword%' OR
             sub_option LIKE '%$enteredKeyword%' OR
             sub_type LIKE '%$enteredKeyword%' OR
             tool_length LIKE '%$enteredKeyword%' OR
             width_diameter LIKE '%$enteredKeyword%' OR
             tool_weight LIKE '%$enteredKeyword%' OR
              manufacturer LIKE '%$enteredKeyword%' OR
            purchase_price LIKE '%$enteredKeyword%' )";
            }
        }


    $result_all = mysqli_query($db, $query_all) or die(mysqli_error($db));
}
else{
    $sql1="CREATE OR REPLACE VIEW customer_report AS
SELECT DISTINCT(tool.tool_number), tooltype,power_source,sub_option,sub_type,tool_length,width_diameter,tool_weight,manufacturer,purchase_price,purchase_price*0.15 AS rental_price,purchase_price*0.4 AS rental_deposit,
(CASE WHEN COUNT(rent_start_date)>=50 
            THEN 'For_Sale'
      WHEN (
	        service_start_date<=CURDATE()
	        AND
			service_end_date>=CURDATE()
			)
			THEN 'In-Repair'
	  WHEN	sale_date IS NOT NULL 
	        THEN 'Sold'
      WHEN  (
             reservation_start_date<=CURDATE()
             AND
             rent_end_date IS NULL AND reservation_end_date >=CURDATE()
             )
            THEN 'Rented'
	  ELSE  'Available' END ) AS tool_status,
(CASE WHEN (
	        service_start_date<=CURDATE()
	        AND
			service_end_date>=CURDATE()
			)
			THEN service_end_date
	  WHEN	sale_date IS NOT NULL 
	        THEN sale_date
      WHEN  (
            reservation_start_date<=CURDATE()
             AND
             reservation_end_date>= CURDATE()
             AND
             rent_end_date IS NULL
             )
            THEN reservation_end_date
	  ELSE  ' ' END ) AS expected_date,
(CASE WHEN sale_date IS NOT NUll 
            THEN purchase_price/2
     ELSE  0 END )  AS sale_profit,
(CASE WHEN total_service_cost IS NOT NUll 
            THEN total_service_cost+purchase_price
     ELSE  0 END )  AS total_cost,
 (CASE WHEN total_rent_days IS NOT NUll 
            THEN total_rent_days*purchase_price*0.15
     ELSE  0 END )  AS rent_profit,
  (CASE WHEN sale_date IS NOT NUll 
            THEN purchase_price/2
     ELSE  0 END )  -
(CASE WHEN total_service_cost IS NOT NUll 
            THEN total_service_cost+purchase_price
     ELSE  purchase_price END )  +
 (CASE WHEN total_rent_days IS NOT NUll 
            THEN total_rent_days*purchase_price*0.15
     ELSE  0 END )       AS  total_profit   

FROM tool
LEFT JOIN purchaseorderdetail
ON tool.tool_number = purchaseorderdetail.tool_number
LEFT JOIN purchaseOrder
ON purchaseorder.sale_id = purchaseorderdetail.sale_id
LEFT JOIN(SELECT tool.tool_number,SUM(repair_cost) AS total_service_cost
FROM serviceorder INNER JOIN tool
ON serviceorder.tool_number=tool.tool_number
GROUP BY tool_number) AS Totalservicecost
ON tool.tool_number=Totalservicecost.tool_number
LEFT JOIN(SELECT tool_number, SUM(CASE WHEN DATEDIFF(rent_start_date,rent_end_date)=0
            THEN 1
     ELSE  DATEDIFF(rent_start_date,rent_end_date) END )  AS total_rent_days
FROM reservationorder INNER JOIN reservationorderdetail
ON reservationorderdetail.reservation_id=reservationorder.reservation_id
GROUP BY tool_number) AS Totalrentdays
ON tool.tool_number=Totalrentdays.tool_number
LEFT JOIN  serviceorder
on tool.tool_number=serviceorder.tool_number
LEFT JOIN reservationorderdetail
ON tool.tool_number=reservationorderdetail.tool_number
LEFT JOIN reservationorder
ON reservationorder.reservation_id=reservationorderdetail.reservation_id
GROUP BY tool_number,service_start_date,service_end_date,sale_date,rent_start_date,rent_end_date,reservation_start_date,reservation_end_date
ORDER BY tool.tool_number";
    mysqli_query($db, $sql1);
    $query_all = "SELECT * FROM customer_report ";
    $result_all = mysqli_query($db, $query_all) or die(mysqli_error($db));

}
?>

<?php include("lib/header.php"); ?>
<title>reports</title>
</head>

<body>
<form action="toolreport.php" method="post" enctype="multipart/form-data">
<div id="main_container">
    <?php include("lib/menu_clerk.php"); ?>
    <div class="center_content">
        <div class="center_left">
            <div class="features">
                <div class="profile_section">
                    <div ><a href="reports.php" <?php if($current_filename=='reports.php') echo "class='active'"; ?>>Back to the Report List</a></div>
                    <div class="subtitle">Tool Inventory Report</div>
                    <div action="toolreport.php"  class="login_form_row">
                        Type:
                        <input type="radio" name="tool_type" value="all_tools"  checked />
                        <label class="login_usertype">All</label>
                        <input type="radio" name="tool_type" value="Hand"  />
                        <label class="login_usertype">Hand</label>
                        <input type="radio" name="tool_type" value="Garden" />
                        <label class="login_usertype">Garden</label>
                        <input type="radio" name="tool_type" value="Ladder" />
                        <label class="login_usertype">Ladder</label>
                        <input type="radio" name="tool_type" value="Power" />
                        <label class="login_usertype">Power</label>
                        Custom Search <input type="text" name="custom_search" >
                        <input type="submit" value="Search"/>
                    </div>

                    <?php


                    $result_all = mysqli_query($db, $query_all);

                    if (is_bool($result_all) && (mysqli_num_rows($result_all) == 0) ) {
                        //false positive if no friends
                        array_push($error_msg,  "No tool available " . __FILE__ ." line:". __LINE__ );
                    }
                    if($result_all =mysqli_query($db,$query_all)){
                        if(mysqli_num_rows($result_all)>0){
                            echo "<table>";
                            echo"<tr>";
                            echo"<th>Tool ID</th>";
                            echo"<th>Current Status</th>";
                            echo"<th>Date </th>";
                            echo"<th>Short Description</th>";
                            echo"<th>Full Description</th>";
                            echo"<th>Purchase Price</th>";
                            echo"<th>Rental Price </th>";
                            echo"<th>Rental Deposit </th>";
                            echo"<th>Rental Profit </th>";
                            echo"<th>Sale Profit </th>";
                            echo"<th>Total Cost </th>";
                            echo"<th>Total Profit </th>";
                            echo"</tr>";
                            while($row=mysqli_fetch_array($result_all)) {
                                echo "<tr>";
                                echo "<td>" . $row['tool_number'] . "</td>";
                                echo "<td>" . $row['tool_status'] . "</td>";
                                echo "<td>" . $row['expected_date'] . " </td>";
                                echo "<td>" . $row['power_source'].' '.$row['sub_option'].' '.$row['sub_type'].  "</td>";
                                echo "<td>" . $row['tool_length'] .'in. '. $row['width_diameter'].'in. '.$row['tool_weight'].'lb. '.$row['manufacturer']. "</td>";
                                echo "<td>" . $row['purchase_price'] . " </td>";
                                echo "<td>" . $row['rental_price'] . " </td>";
                                echo "<td>" . $row['rental_deposit'] . " </td>";
                                echo "<td>" . $row['rent_profit'] . " </td>";
                                echo "<td>" . $row['sale_profit'] . " </td>";
                                echo "<td>" . $row['total_cost'] . " </td>";
                                echo "<td>" . $row['total_profit'] . " </td>";
                                echo "</tr>";
                            }
                            echo"</table>";


                        }
                    }
                    $result_all = mysqli_query($db, $query_all);
                    if (is_bool($query_all) && (mysqli_num_rows($result_all) == 0) ) {
                        //false positive if no friends
                        array_push($error_msg, "No report available" . __FILE__ . " line:" . __LINE__);
                    }
                    mysqli_close($db);

                    ?>

                </div>
            </div>
        </div>
        <?php include("lib/error.php"); ?>

        <div class="clear"></div>
    </div>
</form>


</div>

</body>

</html>
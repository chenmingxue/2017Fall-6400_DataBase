
<?php

include('lib/common.php');
// written by Zhenning Tan

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}
// 
    // Get customer information:
    $query = "SELECT first_name, last_name, email, home_phone, work_phone, cell_phone, street_address, city, customer_state, zipcode " .
		 "FROM User INNER JOIN Customer ON User.username=Customer.username " .
		 "WHERE User.username='{$_SESSION['username']}'";
    $result = mysqli_query($db, $query); //or die(mysqli_error($db));
    include('lib/show_queries.php');
 
    if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        array_push($error_msg,  "Query ERROR: Failed to get User profile...<br>" . __FILE__ ." line:". __LINE__ );
    };
    

    //Get reservation information
    $query_reservation= "SELECT reservation_id, reservation_start_date,reservation_end_date, pickup_clerk, dropoff_clerk,datediff(reservation_end_date, reservation_start_date) AS number_of_days \n"
    . "FROM reservationorder WHERE reservationorder.customer = '{$_SESSION['username']}' \n"
    . "ORDER BY rent_start_date DESC";
    $result_reservation = mysqli_query($db, $query_reservation); //or die(mysqli_error($db));
    include('lib/show_queries.php');

    if (is_bool($result_reservation) && (mysqli_num_rows($result_reservation) == 0) ) {
        echo "0 results";
    };


?>

<?php include("lib/header.php"); ?>
<title>view_profile_customer</title>
</head>

<body>
    <div id="main_container">
    <?php include("lib/menu_customer.php"); ?>

    <div class="center_content">
        <div class="center_left">        
            <div class="features">           
                <div class="profile_section">
                    <div class="subtitle">Customer Info</div>   
                    <div class="">E-mail: <?php print $row['email']; ?> </div>
                    <div class="">Full Name: <?php print $row['first_name'] . ' ' . $row['last_name']; ?> </div>
                    <div class="">Home Phone: <?php print $row['home_phone']; ?> </div>
                    <div class="">Work Phone: <?php print $row['work_phone']; ?> </div>
                    <div class="">Cell Phone: <?php print $row['cell_phone']; ?> </div>
                    <div class="">Address: <?php print $row['street_address'].', '.$row['city'].', '.$row['customer_state'].', '.$row['zipcode']; ?> </div>     
                </div>

                <div class="profile_section">
                    <div class="subtitle">Reservations</div>   
                    <table>
                        <tr> 
                                <td class="heading">Reservation ID</td> 
                                <td class="heading">Tools</td>
                                <td class="heading">Start Date</td>
                                <td class="heading">End Date</td>
                                <td class="heading">Pick-up Clerk</td>
                                <td class="heading">Drop-off Clerk</td>
                                <td class="heading">Number of Days</td>
                                <td class="heading">Total Deposit Price</td>
                                <td class="heading">Total Rental Price</td>
                        </tr>

                        <?php
                            while ($row_reservation = mysqli_fetch_array($result_reservation, MYSQLI_ASSOC)){
                                // query reservation tool 
                                $query_tool ="SELECT CASE WHEN power_source = 'manual' THEN CONCAT(sub_option, ' ', sub_type) ELSE  CONCAT(power_source, ' ', sub_option, ' ', sub_type) END AS short_description\n"
                                . "FROM reservationorderdetail INNER JOIN tool \n"
                                . "ON reservationorderdetail.tool_number = tool.tool_number\n"
                                . "WHERE reservation_id = '{$row_reservation["reservation_id"]}'";                               
                                $result_tool = mysqli_query($db, $query_tool);
                                include('lib/show_queries.php');
                                if (is_bool($result_tool) && (mysqli_num_rows($result_tool) == 0) ) {
                                             array_push($error_msg,  "Query ERROR: Failed to get Reservation Tool information..." . __FILE__ ." line:". __LINE__ );
                                        }; 
                                                         
                                $number_of_days = $row_reservation["number_of_days"];                                   

                                //query tool price
                                $query_tool_price ="SELECT SUM(purchase_price)*0.15*{$number_of_days} AS total_rental_price, SUM(purchase_price)*0.4 AS total_deposit_price\n"
                                . "FROM reservationorderdetail INNER JOIN tool \n"
                                . "ON reservationorderdetail.tool_number = tool.tool_number\n"
                                . "WHERE reservation_id = '{$row_reservation["reservation_id"]}'";                               
                                $result_tool_price = mysqli_query($db, $query_tool_price);
                                include('lib/show_queries.php');
                                if (is_bool($result_tool_price) && (mysqli_num_rows($result_tool_price) == 0) ) {
                                             array_push($error_msg,  "Query ERROR: Failed to get Reservation Tool information..." . __FILE__ ." line:". __LINE__ );
                                        };
                                $row_price = mysqli_fetch_array($result_tool_price, MYSQLI_ASSOC);


                                print "<tr>";                                
                                print "<td>".$row_reservation["reservation_id"]."</td>";
                                print "<td>";
                                    while ($row_tool = mysqli_fetch_array($result_tool, MYSQLI_ASSOC)){
                                        print "<small>{$row_tool["short_description"]}<br></small>";
                                    }
                                print "</td>";
                                print "<td>".$row_reservation["reservation_start_date"]."</td>";
                                print "<td>".$row_reservation["reservation_end_date"]."</td>";
                                print "<td>".$row_reservation["pickup_clerk"]."</td>";
                                print "<td>".$row_reservation["dropoff_clerk"]."</td>";
                                print "<td>".$row_reservation["number_of_days"]."</td>";
                                print "<td>".$row_price["total_deposit_price"]."</td>";
                                print "<td>".$row_price["total_rental_price"]."</td>";
                                print "</tr>";
                                }
                        ?>
                    </table>
                    				
                </div>	

            </div> 			
        </div> 

                <?php include("lib/error.php"); ?>
                    
				<div class="clear"></div> 		
			</div>    

               <?php include("lib/footer.php"); ?>
				 
		</div>
	</body>
</html>
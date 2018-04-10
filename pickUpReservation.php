<?php

include('lib/common.php');
// written by jhe321

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}
// ERROR: demonstrating SQL error handlng, to fix
  
    
?>



<?php include("lib/header.php"); ?>
<title>Pick Up</title>
</head>

<body>
    <div id="main_container">
    <?php include("lib/menu_clerk.php"); ?>

    <div class="center_content">
        <div class="center_left">        
            <div class="features">           
                <div class="profile_section">
                    <div class="subtitle">Pickup Reservation</div>   
                    <table>
                        <tr>

                            <td class="heading">Reservation ID </td>
                            <td class="heading">Customer </td>
                            <td class="heading">Start Date </td>
                            <td class="heading">End Date </td>
                        </tr>

                        <?php                               
                                    $query = "SELECT reservation_id, Customer.username, reservation_start_date, reservation_end_date ".
                                               " FROM User INNER JOIN Customer  ON User.username=Customer.username ".
                                                "INNER JOIN reservationorder R ON Customer.username  = R.customer where r.pickup_clerk IS NULL";
                                             
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "SELECT ERROR: find Friendship <br>" . __FILE__ ." line:". __LINE__ );
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print "<tr>";
                                        print "<td><a href='pickUpReservation.php?reservation_id=" . urlencode($row['reservation_id']) . "'>{$row['reservation_id']}</a></td>";
                                        print "<td>{$row['username']}</td>";
                                        print "<td>{$row['reservation_start_date']}</td>";
                                        print "<td>{$row['reservation_end_date']}</td>";
                                        print "</tr>";                          
                                    }                                   
                        ?>

            
                    </table>                        
                    
    <div class="features">           
        <div class="profile_section">
            <form action="pickUpReservation.php" method="post" enctype="multipart/form-data">
            <?php
                if (!empty($_GET['reservation_id'])) {
                    $reservation_id = $_GET['reservation_id'];

                    $query1 = "SELECT reservation_id, full_name, username, sum(rental_price * rental_days) as total_rental_price, sum(deposit_price) as total_deposit FROM (SELECT ROD.*, concat(first_name, ' ', last_name) as full_name, C.username, reservation_start_date, reservation_end_date, DATEDIFF(reservation_end_date,reservation_start_date) as rental_days, T.purchase_price, T.purchase_price * 0.15 AS rental_price, T.purchase_price * 0.4 AS deposit_price FROM User INNER JOIN Customer C ON User.username=C.username INNER JOIN reservationorder R ON C.username = R.customer INNER JOIN reservationorderdetail ROD ON R.reservation_id = ROD.reservation_id INNER JOIN tool T ON T.tool_number = ROD.tool_number WHERE R.reservation_id = '$reservation_id') CALCULATE GROUP BY reservation_id, full_name,username";
                    $result1 = mysqli_query($db, $query1);
                    $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                    
                    $query2 = "SELECT concat(tooltype, ' ', sub_type, ' ', sub_option) as tool_nm FROM tool JOIN  reservationorderdetail ROD ON TOOL.tool_number = ROD.tool_number WHERE ROD.reservation_id = '$reservation_id'";
                    $result2 = mysqli_query($db, $query2);

                    
                if (is_array($row1)){
                        print '<h4>Reservation ID:</h4><br>';
                        print '<p>' . $row1['reservation_id'] . '</p><br>';
                        print '<h4>Customer Name:</h4><br>';
                        print '<p>' . $row1['full_name'] . '</p><br>';
                        print '<h4>Total Deposit:</h4><br>';
                        print '<p>' . $row1['total_deposit'] . '</p><br>';
                        print '<h4>Total Rental Price:</h4><br>';
                        print '<p>' . $row1['total_rental_price'] . '</p><br>';

                        print '<h4>Tool Name:</h4><br>';
                        while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
                                        print "<tr>";
                                        print "<td>{$row2['tool_nm']} </td>";
                                        print "</tr>";                          
                                    }                                  
                    }
                    else {
                        print "None";
                    }
                }
                
//                echo "<pre>";
//                print_r ($row);
              //  
//                echo "</pre>";

            ?>
            </form>
        </div> 
    </div>
                 


                </div>

                <div class="login_form_row">
                <form action="pickUpReservation2.php" method="post" target="_blank">  
                <input type='text' name='pickup' placeholder = 'Enter Reservation ID' id='pickup'/>
                <input type="submit" value="Pick Up"/>
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
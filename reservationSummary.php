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
    //or die(mysqli_error($db));
include('lib/show_queries.php');
    if(!empty($_POST['checkforreservation'])) {
    
    $checked_tool = $_POST['checkforreservation'];
    $_SESSION['checkedtool']=$checked_tool;
//            echo "<pre>";
//            print_r ($_SESSION);
//            echo "</pre>";
    if(empty($checked_tool)){
    array_push($error_msg,  "Please choose the tools for reservation.");
    header(REFRESH_TIME . 'url=makeReservation.php');
    }else{
        $start_date=date('Y-m-d', strtotime($_SESSION['reservation_start_date']));
        $end_date=date('Y-m-d', strtotime($_SESSION['reservation_end_date']));
        $num_days=ceil((strtotime($_SESSION['reservation_end_date'])-strtotime($_SESSION['reservation_start_date']))/24/3600);
        $checked_tool_list = '(' . implode(',', $checked_tool) . ')';
        $query = "SELECT tool_number, tooltype, (CASE WHEN power_source = 'manual'"
                . " THEN concat (sub_option, ' ',sub_type) ELSE concat (power_source ,' ', sub_option , ' ', sub_type) END) AS short_description,"
                . " purchase_price*0.15 AS rental_price, purchase_price*0.40 AS deposit_price"
                . " FROM Tool WHERE Tool.tool_number in $checked_tool_list";
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
        
    }
}
    if (!empty($_POST['confirmation'])){
        $enteredUsername=$_SESSION['username'];
    //            echo "<pre>";
    //            print_r ($_SESSION);
    //            echo "</pre>";
    //            echo $_SESSION['username'];
        $sql_RO = "INSERT INTO ReservationOrder (customer, reservation_start_date, reservation_end_date)  VALUES('$enteredUsername', '{$_SESSION['reservation_start_date']}', '{$_SESSION['reservation_end_date']}')";
        $query_RO = mysqli_query($db, $sql_RO);
        if (!$query_RO){
            array_push($error_msg,  "Insert Reservation Order error"  );
        }else{
            $RO_id = "SELECT reservation_id FROM ReservationOrder WHERE reservation_start_date='{$_SESSION['reservation_start_date']}'";
            $result_RO_id = mysqli_query($db, $RO_id);
            $row_RO_id = mysqli_fetch_array($result_RO_id, MYSQLI_ASSOC);

            foreach($_SESSION['checkedtool'] as $key=>$value){  
            $sql_ROD = "INSERT INTO ReservationOrderDetail (reservation_id, tool_number)  VALUES('{$row_RO_id['reservation_id']}', '$value')";
            $result_ROD = mysqli_query($db, $sql_ROD); 
            }
            if ( !empty($RO_id) )   { 
                header(REFRESH_TIME . 'url=reservationConfirmation.php');
            }else{
                array_push($error_msg,  "No reservation id found" );
            }
        }
    }
    

?>

<?php include("lib/header.php"); ?>
<title>reservation summary</title>
</head>

<body>
    <div id="main_container">
    <?php include("lib/menu_customer.php"); ?>

    <div class="center_content">
        <div class="text-box">        
            <div class="features">           
                
                <div class="profile_section">
                    <div class="subtitle">Reservation Summary</div>  
                    <div class="">Reservation Dates: <?php print $_SESSION['reservation_start_date'].' - '.$_SESSION['reservation_end_date']; ?> </div>
                    <div class="">Number of Days Rented: <?php print $num_days; ?> </div>
                    <div class="">Total Deposit Price: <?php print $row_sum['deposit_total']; ?> </div>
                    <div class="">Total Rental Price: <?php print $row_sum['rental_total']; ?> </div>
                    
                </div>
                <div class="profile_section">
                    <form action="reservationSummary.php" method="post" enctype="multipart/form-data">
                    <div class="subtitle">Tools</div>
                    <table>
                    <tr>
                            <td class="heading">Tool ID</td>
                            <td class="heading">Description</td>
                            <td class="heading">Deposit Price</td>
                            <td class="heading">Rental Price</td>
                    </tr>
                    <?PHP
                   // if (is_array($row)){
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                            print "<tr>";
                            print "<td>{$row['tool_number']}</td>";
                            print "<td>{$row['short_description']}</td>";
                            print "<td>{$row['deposit_price']}</td>";
                            print "<td>{$row['rental_price']}</td>";
                            print "</tr>"; 
                        }
                        $query_sum = "SELECT SUM(purchase_price*0.15*$num_days) as rental_total, SUM(purchase_price*0.40) as deposit_total FROM Tool WHERE tool_number IN $checked_tool_list ";
                        $result_sum = mysqli_query($db, $query_sum) or die(mysqli_error($db));
                        $row_sum = mysqli_fetch_array($result_sum, MYSQLI_ASSOC);
                   // }
                            print "<tr>";
                            print "<td>Totals</td>";
                            print "<td></td>";
                            print "<td>{$row_sum['deposit_total']}</td>";
                            print "<td>{$row_sum['rental_total']}</td>";
                            print "</tr>";                       
                    ?>
                    </table>
                    <input type="submit" name="confirmation" value="Submit"/>
                    <a href="makeReservation.php"><input type="button" value="reset"/></a>
                    </form>

                </div>
                </div>	
            </div> 	
            <?php include("lib/error.php"); ?>
            <div class="clear"></div> 		
        <?php include("lib/footer.php"); ?>	
        </div> 
    	 
        </div>  
    </body>
</html>
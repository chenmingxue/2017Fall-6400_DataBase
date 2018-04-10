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
        $RO_id = "SELECT reservation_id FROM ReservationOrder WHERE reservation_start_date='{$_SESSION['reservation_start_date']}' AND reservation_end_date='{$_SESSION['reservation_end_date']}' AND customer='{$_SESSION['username']}'";

        if (!empty($RO_id)){
    //            echo "<pre>";
    //            print_r ($_SESSION);
    //            echo "</pre>";
        $result_RO_id = mysqli_query($db, $RO_id);
        $row_RO_id = mysqli_fetch_array($result_RO_id, MYSQLI_ASSOC);
        $reservation_id=$row_RO_id['reservation_id'];
        $start_date=date('Y-m-d', strtotime($_SESSION['reservation_start_date']));
        $end_date=date('Y-m-d', strtotime($_SESSION['reservation_end_date']));
        $num_days=ceil((strtotime($_SESSION['reservation_end_date'])-strtotime($_SESSION['reservation_start_date']))/24/3600);
        $checked_tool_list = '(' . implode(',', $_SESSION['checkedtool']) . ')';
        $sql_ROD = "SELECT tool_number, tooltype, (CASE WHEN power_source = 'manual'"
             . " THEN concat (sub_option, ' ',sub_type) ELSE concat (power_source ,' ', sub_option , ' ', sub_type) END) AS short_description,"
             . " purchase_price*0.15*$num_days AS rental_price, purchase_price*0.40 AS deposit_price"
             . " FROM Tool WHERE Tool.tool_number in $checked_tool_list";
        $result_ROD = mysqli_query($db, $sql_ROD); 
        $row_ROD= mysqli_fetch_array($result_ROD, MYSQLI_ASSOC);
        $query_sum = "SELECT SUM(purchase_price*0.15*$num_days) as rental_total, SUM(purchase_price*0.40) as deposit_total FROM Tool WHERE tool_number IN $checked_tool_list ";
        $result_sum = mysqli_query($db, $query_sum) or die(mysqli_error($db));
        $row_sum = mysqli_fetch_array($result_sum, MYSQLI_ASSOC);

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
                    <div class="subtitle">Reservation Confirmation</div>  
                    <div class="">Reservation ID: <?php print $reservation_id; ?> </div>                    
                    <div class="">Reservation Dates: <?php print $_SESSION['reservation_start_date'].' - '.$_SESSION['reservation_end_date']; ?> </div>
                    <div class="">Number of Days Rented: <?php print $num_days; ?> </div>
                    <div class="">Total Deposit Price: <?php print '$'.$row_sum['deposit_total']; ?> </div>
                    <div class="">Total Rental Price: <?php print '$'.$row_sum['rental_total']; ?> </div>
                    
                </div>
                <div class="profile_section">
                    <div class="subtitle">Tools</div>
                    <table>
                    <tr>
                            <td class="heading">Tool ID</td>
                            <td class="heading">Description</td>
                            <td class="heading">Deposit Price</td>
                            <td class="heading">Rental Price</td>
                    </tr>
                    <?PHP
                    if (is_array($row_ROD)){
                            print "<tr>";
                            print "<td>{$row_ROD['tool_number']}</td>";
                            print "<td>{$row_ROD['short_description']}</td>";
                            print "<td>$"."{$row_ROD['deposit_price']}</td>";
                            print "<td>$"."{$row_ROD['rental_price']}</td>";
                            print "</tr>";   
                    }
                            print "<tr>";
                            print "<td>Totals</td>";
                            print "<td></td>";
                            print "<td>$"."{$row_sum['deposit_total']}</td>";
                            print "<td>$"."{$row_sum['rental_total']}</td>";
                            print "</tr>";                       
                    ?>
                    </table>
                </div>
                <div class="login_form_row">
                <input type = "button" value = "Print this Page" onClick = "window.print()">
                </div>
                </div>	
            </div> 	
            <?php include("lib/error.php"); ?>
            <div class="clear"></div> 		
        </div> 
    	 
        </div>  
    </body>
</html>
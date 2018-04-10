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
<title>Drop Off Reservation</title>
</head>


<body>
<div id="main_container">
    <?php include("lib/menu_clerk.php"); ?>

    <div class="center_content">
        <div class="center_left"> 

            <div class="title_name">
                Drop Off Reservation
            </div>   
            <div class="subtitle">
                Reservation Details
            </div> 

            <div class = "features">

            <div class="profile_section">

                <?php
                                    
                $query = "SELECT reservation_id, full_name, username, 
                            sum(rental_price * rental_days) as total_rental_price, 
                            sum(deposit_price) as total_deposit 
                          FROM (
                                SELECT ROD.*, concat(first_name, ' ', last_name) as full_name, C.username, reservation_start_date, reservation_end_date, DATEDIFF(reservation_end_date,reservation_start_date) as rental_days, T.purchase_price, T.purchase_price * 0.15 AS rental_price, T.purchase_price * 0.4 AS deposit_price 
                                FROM User   INNER JOIN Customer C ON User.username=C.username INNER JOIN reservationorder R ON C.username = R.customer 
                                            INNER JOIN reservationorderdetail ROD ON R.reservation_id = ROD.reservation_id 
                                            INNER JOIN tool T ON T.tool_number = ROD.tool_number WHERE R.reservation_id = '{$_POST['dropoff']}'
                                ) CALCULATE 
                            GROUP BY reservation_id, full_name,username";
    
           
                $result = mysqli_query($db, $query); //or die(mysqli_error($db));
                include('lib/show_queries.php');
 
                if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                } else {
                array_push($error_msg,  "Query ERROR: Failed to get the query result...<br>" . __FILE__ ." line:". __LINE__ );
                                    }
                ;
                                            
                ?> 
                      
                    <table>
                        <tr>
                            <td class="item_label">Reservation ID: #</td>
                            <td>
                                <?php print $_POST['dropoff'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Customer Name:</td>
                            <td>
                                <?php print $row['full_name'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Total Deposit:</td>
                            <td>
                                <?php print $row['total_deposit'];?>
                            </td>
                        </tr>
                         <tr>
                            <td class="item_label">Total Rental Price:</td>
                            <td>
                                <?php print $row['total_rental_price'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Total Due:</td>
                            <td>
                                <?php print $row['total_rental_price'] - $row['total_deposit'];?>
                            </td>
                        </tr>

                    </table>

                    <table>
                        <tr>

                            <td class="heading">Tool ID </td>
                            <td class="heading">Tool Name </td>
                            <td class="heading">Deposit Price </td>
                            <td class="heading">Rental Price </td>
                        </tr>

                        <?php                               
                                    $query = "SELECT ROD.tool_number, CONCAT(T.tooltype, ' ', t.sub_type) AS tool_name, T.purchase_price * 0.15 AS single_day_rental_price, T.purchase_price * 0.4 AS deposit_price, DATEDIFF(reservation_end_date,reservation_start_date) as rental_days, T.purchase_price * 0.15 * DATEDIFF(reservation_end_date,reservation_start_date) AS rental_price FROM reservationorderdetail ROD inner join tool T on ROD.tool_number = T.tool_number join reservationorder RO ON ROD.reservation_id=RO.reservation_id where RO.reservation_id = '{$_POST['dropoff']}'";
                                    
                                             
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "SELECT ERROR: Check Query<br>" . __FILE__ ." line:". __LINE__ );
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print "<tr>";
                                        print "<td>{$row['tool_number']} </td>";
                                        print "<td>{$row['tool_name']}</td>";
                                        print "<td>{$row['deposit_price']}</td>";
                                        print "<td>{$row['rental_price']}</td>";
                                        print "</tr>";                          
                                    }                                   
                        ?>

                        <?php                               
                                   $query = 
      
                                    "SELECT reservation_id, full_name, sum(rental_price * rental_days) as total_rental_price, sum(deposit_price) as total_deposit FROM (SELECT ROD.*, concat(first_name, ' ', last_name) as full_name, reservation_start_date, reservation_end_date, DATEDIFF(reservation_end_date,reservation_start_date) as rental_days, T.purchase_price, T.purchase_price * 0.15 AS rental_price, T.purchase_price * 0.4 AS deposit_price FROM User INNER JOIN Customer C ON User.username=C.username INNER JOIN reservationorder R ON C.username = R.customer INNER JOIN reservationorderdetail ROD ON R.reservation_id = ROD.reservation_id INNER JOIN tool T ON T.tool_number = ROD.tool_number WHERE R.reservation_id = '{$_POST['dropoff']}') CALCULATE GROUP BY reservation_id, full_name";

                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "SELECT ERROR: Please Check Query <br>" . __FILE__ ." line:". __LINE__ );
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print "<tr>";
                                        print "<td> Totals </td>";
                                        print "<td>  </td>";
                                        print "<td>{$row['total_deposit']}</td>";
                                        print "<td>{$row['total_rental_price']}</td>";
                                        print "</tr>";                          
                                    }                                   
                        ?>

            
                    </table>  

                    


                                         
             </div>

                

                <form action="dropoff3.php" method="post" target="_blank">
                    <input type="hidden" name="dropoff" value="<?php echo $_POST['dropoff']; ?>">
                    <input type="submit" value = "Drop Off"/><br/>
                </form>



            </div>          
        </div> 

                <?php include("lib/error.php"); ?>
                    
                <div class="clear"></div>       
            </div>    

               <?php include("lib/footer.php"); ?>
                 
            </div>
    </body>
</html>


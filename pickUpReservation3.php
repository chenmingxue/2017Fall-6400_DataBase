<?php

include('lib/common.php');
// written by jhe321

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
// ERROR: demonstrating SQL error handlng, to fix

//if the new credit card radio button is checked -  update customer credit card information

    $answer = $_POST['crd_card'];  
    if ($answer == "new credit card") {          
        
        $sql = "UPDATE customer SET cc_number = '{$_POST['cardnum']}', cc_exp_month = '{$_POST['expmonth']}', cc_exp_year = '{$_POST['expyear']}', CVC = '{$_POST['cvc']}'  where username = '{$_POST['customer']}'";

        if (mysqli_query($db, $sql)) {
         echo "Record updated successfully";
        } else {
        echo "Error updating record: " . mysqli_error($conn);
        }

    }
        

    $sql = "UPDATE reservationorder SET pickup_clerk='{$_SESSION['username']}',rent_start_date= NOW() WHERE reservation_id = '{$_POST['reservation_id']}' ";

       // Prepare statement
    
    if (mysqli_query($db, $sql)) {
    echo "Record updated successfully";
    } else {
    echo "Error updating record: " . mysqli_error($conn);
    }
   
?>


<?php include("lib/header.php"); ?>
<title>Pick Up Confirmation</title>
</head>
$_POST['crd_card']


<style>
.signature {
    border: 0;
    border-bottom: 1px solid #000;
}
</style>

<body>
<div id="main_container">
    <?php include("lib/menu_clerk.php"); ?>

    <div class="center_content">
        <div class="center_left"> 

            <div class="title_name">
                Pickup Reservation
            </div>   
            <div class="subtitle">
                Rental Contact
            </div> 

            <div class = "features">

            <div class="profile_section">

                <?php
                                    $query = "SELECT reservation_id, customer, CONCAT(U1.first_name,' ', U1.last_name) AS customer_name, pickup_clerk, CONCAT(U2.first_name,' ', U2.last_name) as clerk_name, customer.cc_number, reservation_start_date, reservation_end_date 
FROM reservationorder RO left JOIN user U1 ON RO.customer = U1.username INNER JOIN user U2 on pickup_clerk = U2.username JOIN customer on RO.customer = CUSTOMER.username
where reservation_id = '{$_POST['reservation_id']}'";


      
                                            
                                    $result = mysqli_query($db, $query); //or die(mysqli_error($db));
                                    include('lib/show_queries.php');
 
                                    if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) {
                                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                    } else {
                                    array_push($error_msg,  "Query ERROR: Failed to get the query result...<br>" . __FILE__ ." line:". __LINE__ );
                                    }
                ;
                                             // update credit card info if clerk enter the customer credit card info below
                                            
                ?> 
                      
                    <table>
                        <tr>
                            <td class="item_label">Pick-up Clerk:</td>
                            <td>
                                <?php print $row['clerk_name'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Customer Name</td>
                            <td>
                                <?php print $row['customer_name'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Credit Card #:</td>
                            <td>
                                <?php print $row['cc_number'];?>
                            </td>
                        </tr>
                         <tr>
                            <td class="item_label">Start Date:</td>
                            <td>
                                <?php print $row['reservation_start_date'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">End Date:</td>
                            <td>
                                <?php print $row['reservation_end_date'];?>
                            </td>
                        </tr>

                    </table>

                    

                        <div class="subtitle">
                    <table>
                        <tr>

                            <td class="heading">Tool ID </td>
                            <td class="heading">Tool Name </td>
                            <td class="heading">Deposit Price </td>
                            <td class="heading">Rental Price </td>
                        </tr>

                        <?php                               
                                    $query = "SELECT ROD.tool_number, CONCAT(T.tooltype, ' ', t.sub_type) AS tool_name, T.purchase_price * 0.15 AS single_day_rental_price, T.purchase_price * 0.4 AS deposit_price, DATEDIFF(reservation_end_date,reservation_start_date) as rental_days, T.purchase_price * 0.15 * DATEDIFF(reservation_end_date,reservation_start_date) AS rental_price FROM reservationorderdetail ROD inner join tool T on ROD.tool_number = T.tool_number join reservationorder RO ON ROD.reservation_id=RO.reservation_id where RO.reservation_id = '{$_POST['reservation_id']}'";
                                    
                                             
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
      
                                    "SELECT reservation_id, full_name, sum(rental_price * rental_days) as total_rental_price, sum(deposit_price) as total_deposit FROM (SELECT ROD.*, concat(first_name, ' ', last_name) as full_name, reservation_start_date, reservation_end_date, DATEDIFF(reservation_end_date,reservation_start_date) as rental_days, T.purchase_price, T.purchase_price * 0.15 AS rental_price, T.purchase_price * 0.4 AS deposit_price FROM User INNER JOIN Customer C ON User.username=C.username INNER JOIN reservationorder R ON C.username = R.customer INNER JOIN reservationorderdetail ROD ON R.reservation_id = ROD.reservation_id INNER JOIN tool T ON T.tool_number = ROD.tool_number WHERE R.reservation_id = '{$_POST['reservation_id']}') CALCULATE GROUP BY reservation_id, full_name";

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


                 <div class="title_name">
                Signatures
                </div>


                <?php
                                    $query = "SELECT reservation_id, customer, CONCAT(U1.first_name,' ', U1.last_name) AS customer_name, pickup_clerk, CONCAT(U2.first_name,' ', U2.last_name) as clerk_name, customer.cc_number, reservation_start_date, reservation_end_date 
FROM reservationorder RO left JOIN user U1 ON RO.customer = U1.username INNER JOIN user U2 on pickup_clerk = U2.username JOIN customer on RO.customer = CUSTOMER.username
where reservation_id = '{$_POST['reservation_id']}'";


      
                                            
                                    $result = mysqli_query($db, $query); //or die(mysqli_error($db));
                                    include('lib/show_queries.php');
 
                                    if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) {
                                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                    } else {
                                    array_push($error_msg,  "Query ERROR: Failed to get the query result...<br>" . __FILE__ ." line:". __LINE__ );
                                    }
                ;
                                             // update credit card info if clerk enter the customer credit card info below
                                            
                ?> 
                    
                <table>

                    <tr> 
                        <td> <input type="text" class="signature" /> </td>
                        <td> <input type="text" class="signature" /> </td>
                    </tr>
                    <tr>

                        <td> Pickup Clerk - <?php print $row['clerk_name'];?> </td>
                        <td> Date </td>
                    </tr>

                    <tr> 
                        <td> <input type="text" class="signature" /> </td>
                        <td> <input type="text" class="signature" /> </td>
                    </tr>
                    <tr>

                        <td > Customer - <?php print $row['customer_name'];?> </td>
                        <td> Date </td>

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

               <?php include("lib/footer.php"); ?>
                 
            </div>
    </body>
</html>


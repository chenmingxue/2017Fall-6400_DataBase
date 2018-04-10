<?php

include('lib/common.php');
// written by jhe321

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$sql = "UPDATE reservationorder SET dropoff_clerk='{$_SESSION['username']}',rent_end_date= NOW() WHERE reservation_id = '{$_POST['dropoff']}' ";

                     // Prepare statement
    
                    if (mysqli_query($db, $sql)) {
                    echo "Record updated successfully";
                    } else {
                    echo "Error updating record: " . mysqli_error($conn);
                    }    

?>



<?php include("lib/header.php"); ?>
<title>Drop Off</title>
</head>

<body>
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
                    <div class="subtitle">Tool Details</div>   
                    <table>
                        <tr>

                            <td class="heading">Tool ID </td>
                            <td class="heading">Tool Type </td>
                            <td class="heading">Short Description </td>
                            <td class="heading">Full Description </td>
                            <td class="heading">Deposit Price</td>
                            <td class="heading">Rental Price </td>
                        </tr>

                        <?php       
                                    // Show Reservation with no drop off information (drop off clerk is null, drop off date is null)
                                    $query = "SELECT T.tool_number, tooltype, sub_type, CONCAT(width_diameter, ' in W x ', tool_length, ' in W x ', sub_option, ' by ', manufacturer) as full_description, purchase_price* 0.15 as rental_price, purchase_price * 0.4 as deposit_price from reservationorderdetail ROD INNER JOIN tool T ON ROD.tool_number = T.tool_number WHERE ROD.reservation_id = '{$_POST['dropoff']}'" ;
                                             
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "SELECT ERROR: find Friendship <br>" . __FILE__ ." line:". __LINE__ );
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print "<tr>";
                                        print "<td>{$row['tool_number']} </td>";
                                        print "<td>{$row['tooltype']}</td>";
                                        print "<td>{$row['sub_type']}</td>";
                                        print "<td>{$row['full_description']}</td>";
                                        print "<td>{$row['deposit_price']}</td>";
                                        print "<td>{$row['rental_price']}</td>";
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







<?php

include('lib/common.php');
// written by jhe321

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
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
                    <div class="subtitle">Drop Off Reservation</div>   
                    <table>
                        <tr>

                            <td class="heading">Reservation ID </td>
                            <td class="heading">Customer </td>
                            <td class="heading">Start Date </td>
                            <td class="heading">End Date </td>
                        </tr>

                        <?php       
                                    // Show Reservation with no drop off information (drop off clerk is null, drop off date is null)
                                    $query = "SELECT R.reservation_id, C.username, R.reservation_start_date, R.reservation_end_date 
                                            FROM User INNER JOIN Customer C ON User.username=C.username 
                                             INNER JOIN reservationorder R ON C.username  = R.customer
                                              WHERE pickup_clerk is not null and dropoff_clerk is null" ;
                                             
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "SELECT ERROR: find Friendship <br>" . __FILE__ ." line:". __LINE__ );
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print "<tr>";
                                        print "<td>{$row['reservation_id']} </td>";
                                        print "<td>{$row['username']}</td>";
                                        print "<td>{$row['reservation_start_date']}</td>";
                                        print "<td>{$row['reservation_end_date']}</td>";
                                        print "</tr>";                          
                                    }                                   
                            ?>

            
                    </table>                        
                    
                 


                </div>

                <div class="login_form_row">
                <form action="dropoff2.php" method="post" target="_blank">  
                <input type='text' name='dropoff' placeholder = 'Enter Reservation ID' id='dropoff'/>
                <input type="submit" value="Drop Off"/>
                
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
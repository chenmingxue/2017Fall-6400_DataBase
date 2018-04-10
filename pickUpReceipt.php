<?php

include('lib/common.php');
// written by GTusername4

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}
// ERROR: demonstrating SQL error handlng, to fix
    // replace 'sex' column with 'gender' below:
    $query = "SELECT first_name, last_name, email, home_phone, work_phone, cell_phone, street_address, city, customer_state, zipcode " .
		 "FROM User INNER JOIN Customer ON User.username=Customer.username " .
		 "WHERE User.username='{$_SESSION['username']}'";

    $result = mysqli_query($db, $query); //or die(mysqli_error($db));
    include('lib/show_queries.php');
 
    if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        array_push($error_msg,  "Query ERROR: Failed to get User profile...<br>" . __FILE__ ." line:". __LINE__ );
    }
?>

<?php include("lib/header.php"); ?>
<title>view_profile_customer</title>
</head>

<body>
    <div id="main_container">
    <?php include("lib/menu_clerk.php"); ?>

    <div class="center_content">
        <div class="center_left">        
            <div class="features">           
                <div class="profile_section">
                    <div class="subtitle">Pickup Reservation</div>   
                    <div class="">E-mail: <?php print $row['email']; ?> </div>
                    <div class="">Full Name: <?php print $row['first_name'] . ' ' . $row['last_name']; ?> </div>
                    <div class="">Home Phone: <?php print $row['home_phone']; ?> </div>
                    <div class="">Work Phone: <?php print $row['work_phone']; ?> </div>
                    <div class="">Cell Phone: <?php print $row['cell_phone']; ?> </div>
                    <div class="">Address: <?php print $row['street_address'].', '.$row['city'].', '.$row['customer_state'].', '.$row['zipcode']; ?> </div>
                    
                </div>

                
                    <input type="submit" value="Print Contract"/>
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
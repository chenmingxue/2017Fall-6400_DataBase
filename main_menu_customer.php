@@ -0,0 +1,54 @@
<?php

include('lib/common.php');
// written by GTusername4

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}

    // ERROR: demonstrating SQL error handlng, to fix
    // replace 'sex' column with 'gender' below:
$query = "SELECT first_name, last_name " .
		 "FROM User " .
		 "WHERE User.username='{$_SESSION['username']}'";

$result = mysqli_query($db, $query); //or die(mysqli_error($db))
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

?>

<?php include("lib/header.php"); ?>
<title>main_menu_customer</title>
</head>

<body>
    <div id="main_container">
    <?php include("lib/menu_customer.php"); ?>

    <div class="center_content">
            <div class="title_name">
                <p>Welcome!</p>
                <?php print $row['first_name'] . ' ' . $row['last_name']; ?>
            </div>          
            <div class="features">   
            
                <div class="menu_section">
                    <div class="subtitle">View Menu</div>   
                    <div class="menu_section"><a href="view_profile_customer.php" <?php if($current_filename=='view_profile_customer.php') echo "class='active'"; ?>>View Profile</a></div>					
                    <div class="menu_section"><a href="check_tool_avail.php" <?php if($current_filename=='check_tool_avail.php') echo "class='active'"; ?>>Check Tool Availability</a></div>					
                    <div class="menu_section"><a href="makeReservation.php" <?php if($current_filename=='makeReservation.php') echo "class='active'"; ?>>Make Reservation</a></div>		
                </div>
            </div> 	

                <?php include("lib/error.php"); ?>
                    
				<div class="clear"></div> 		
			</div>    

               <?php include("lib/footer.php"); ?>
				 
		</div>
	</body>
</html>
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
    <?php include("lib/menu_clerk.php"); ?>

    <div class="center_content">
            <div class="title_name">
                <p>Welcome!</p>
                <?php print $row['first_name'] . ' ' . $row['last_name']; ?>
            </div>          
            <div class="features">   
            
                <div class="menu_section">
                    <div class="subtitle">View Menu</div>   
                    <div class="menu_section"><a href="pickUpReservation.php" <?php if($current_filename=='pickUpReservation.php') echo "class='active'"; ?>>Pick Up</a></div>					
                    <div class="menu_section"><a href="drop_off_reserv.php" <?php if($current_filename=='drop_off_reserv.php') echo "class='active'"; ?>>Drop off</a></div>		
                    <div class="menu_section"><a href="add_new_tool.php" <?php if($current_filename=='drop_off_reserv.php') echo "class='active'"; ?>>Add New Tool</a></div>		
                    <div class="menu_section"><a href="reports.php" <?php if($current_filename=='reports.php') echo "class='active'"; ?>>Reports</a></div>		
                </div>
            </div> 	   
                <?php include("lib/error.php"); ?>
                    
				<div class="clear"></div> 		
			</div>    

               <?php include("lib/footer.php"); ?>
				 
		</div>
	</body>
</html>
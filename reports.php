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
// ERROR: demonstrating SQL error handlng, to fix
    // replace 'sex' column with 'gender' below:

?>

<?php include("lib/header.php"); ?>
<title>reports</title>
</head>

<body>
    <div id="main_container">
    <?php include("lib/menu_clerk.php"); ?>
    <div class="center_content">
        <div class="center_left">        
            <div class="features">           
                <div class="profile_section">
                    <div class="subtitle">Report</div>

                    <div class="features">

                        <div >
                            <div></div> <a href="clerkreport.php" <?php if($current_filename=='clerkreport.php') echo "class='active'"; ?>>Clerk Report</a></div>
                            <div ><a href="customerreport.php" <?php if($current_filename=='customerreport.php') echo "class='active'"; ?>>Customer Report</a></div>
                            <div ><a href="toolreport.php" <?php if($current_filename=='toolreport.php') echo "class='active'"; ?>>Tool Report</a></div>
                        </div>
        </div>
    </div> 
</div>
                <?php include("lib/error.php"); ?>
                    
				<div class="clear"></div> 		
			</div>    

				 
        
    </div>
</body>
	
</html>
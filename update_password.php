@@ -0,0 +1,73 @@
<?php
include('lib/common.php');
// written by username1
if($showQueries){
  array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");
}
//Note: known issue with _POST always empty using PHPStorm built-in web server: Use *AMP server instead
if( $_SERVER['REQUEST_METHOD'] == 'POST') {
//    $enteredPassword = mysqli_real_escape_string($db, $_POST['password']);
//    $enteredcurrentpassword = $_POST['current_password'];
    $enterednewpassword = $_POST['new_password'];  
    $enteredretrypassword = $_POST['retry_password'];  
    

    if ($enterednewpassword != $enteredretrypassword){
        array_push($error_msg,  "password not match" . __FILE__ ." line:". __LINE__ );
    }else {
        $query = "UPDATE User SET `password` = '$enterednewpassword' WHERE username = '{$_SESSION['username']}'";
        $result = mysqli_query($db, $query);
        array_push($error_msg,  "Updating password" . __FILE__ ." line:". __LINE__ );
        header(REFRESH_TIME . 'url=main_menu_clerk.php');
    } 
}          
?>

<?php include("lib/header.php"); ?>
<title>Clerk update password</title>
</head>
<body>
    <?php include("lib/menu_clerk.php"); ?>
    <div id="main_container">
        <div id="header">
            <div class="logo">
                <img src="img/gtonline_logo.png" style="opacity:0.5;background-color:E9E5E2;" border="0" alt="" title="GT Online Logo"/>
            </div>
        </div>

        <div class="center_content">
            <div class="text_box">

                <form action="update_password.php" method="post" enctype="multipart/form-data">
                    <div class="title">Update password</div>
<!--                    <div class="login_form_row">
                        <label class="login_label">Current Password:</label>
                        <input type="text" name="current_password" value="" class="login_input" required/>
                    </div>-->
                    <div class="login_form_row">
                        <label class="login_label">Enter new password:</label>
                        <input type="password" name="new_password" value="" class="login_input" required/>
                    </div>
                    <div class="login_form_row">
                        <label class="login_usertype">Enter password again:</label>
                        <input type="password" name="retry_password" value="" class="login_input" required=""/>
                    </div> 
                    <input type="submit" class="login" value="submit"/>
                </form>
                
            </div>

                <?php include("lib/error.php"); ?>

                <div class="clear"></div>
        </div>
   
            <!-- 
			<div class="map">
			<iframe style="position:relative;z-index:999;" width="820" height="600" src="https://maps.google.com/maps?q=801 Atlantic Drive, Atlanta - 30332&t=&z=14&ie=UTF8&iwloc=B&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a class="google-map-code" href="http://www.embedgooglemap.net" id="get-map-data">801 Atlantic Drive, Atlanta - 30332</a><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></iframe>
			</div>
             -->

        </div>
</body>
</html>
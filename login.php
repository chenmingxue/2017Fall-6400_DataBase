@@ -0,0 +1,140 @@
<?php
include('lib/common.php');
// written by username1
if($showQueries){
  array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");
}
//Note: known issue with _POST always empty using PHPStorm built-in web server: Use *AMP server instead
if( $_SERVER['REQUEST_METHOD'] == 'POST') {
    $enteredUsername = mysqli_real_escape_string($db, $_POST['username']);
    $enteredPassword = mysqli_real_escape_string($db, $_POST['password']);
    $enteredUsertype = $_POST['usertype'];  
    if (empty($enteredUsername)) {
        array_push($error_msg,  "Please enter a username.");}
    if (empty($enteredPassword)) {
        array_push($error_msg,  "Please enter a password.");}
    if ($enteredUsertype == "customer") {
        //Check if in Customer table
        $query_test = "SELECT cc_name FROM Customer WHERE username='$enteredUsername'";
        $result_test = mysqli_query($db, $query_test);
        $count_test = mysqli_num_rows($result_test); 
        $query_test2 = "SELECT employee_number FROM Clerk WHERE username='$enteredUsername'";
        $result_test2 = mysqli_query($db, $query_test2);
        $count_test2 = mysqli_num_rows($result_test2); 
        if ($count_test <= 0){
                array_push($error_msg,  "Customer not exists");
                if ($count_test2>0){
                    array_push($error_msg,  "It is a Clerk's username");
                }else{                
                    header(REFRESH_TIME . 'url=regist.php');
                }
        }else{
        $query = "SELECT password FROM User WHERE username='$enteredUsername'";
        $result = mysqli_query($db, $query);
        $count = mysqli_num_rows($result); 
        if (!empty($result) && ($count > 0) ) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $storedPassword = $row['password']; 
            $options = [
                'cost' => 8,
            ];
             //convert the plaintext passwords to their respective hashses
             // 'michael123' = $2y$08$kr5P80A7RyA0FDPUa8cB2eaf0EqbUay0nYspuajgHRRXM9SgzNgZO
            $storedHash = password_hash($storedPassword, PASSWORD_DEFAULT , $options);   //may not want this if $storedPassword are stored as hashes (don't rehash a hash)
            $enteredHash = password_hash($enteredPassword, PASSWORD_DEFAULT , $options); 
            
            //depends on if you are storing the hash $storedHash or plaintext $storedPassword 
            if (password_verify($enteredPassword, $storedHash) ) {
                $_SESSION['username'] = $enteredUsername;
                header(REFRESH_TIME . 'url=main_menu_customer.php');		//to view the password hashes and login success/failure
            } else {
                array_push($error_msg,  "Please retry password.");}
        }
        }
        }else{
        //check if in Clerk table
            $query_test = "SELECT employee_number FROM Clerk WHERE username='$enteredUsername'";
            $result_test = mysqli_query($db, $query_test);
            $count_test = mysqli_num_rows($result_test); 
            if ($count_test <= 0){
                    array_push($error_msg,  "Clerk not exists");
            //        header(REFRESH_TIME.'url=login.php');
            }else{
                $query = "SELECT password FROM User WHERE username='$enteredUsername'";
                $result = mysqli_query($db, $query);
                $count = mysqli_num_rows($result); 
                if (!empty($result) && ($count > 0) ) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    if ($row['password'] == 'default'){
                        $_SESSION['username'] = $enteredUsername;
                        header(REFRESH_TIME . 'url=update_password.php');
                    }
                    $storedPassword = $row['password'];    
                    $options = [
                        'cost' => 8,
                    ];
                     //convert the plaintext passwords to their respective hashses
                     // 'michael123' = $2y$08$kr5P80A7RyA0FDPUa8cB2eaf0EqbUay0nYspuajgHRRXM9SgzNgZO
                    $storedHash = password_hash($storedPassword, PASSWORD_DEFAULT , $options);   //may not want this if $storedPassword are stored as hashes (don't rehash a hash)
                    $enteredHash = password_hash($enteredPassword, PASSWORD_DEFAULT , $options); 

                    //depends on if you are storing the hash $storedHash or plaintext $storedPassword 
                    if (password_verify($enteredPassword, $storedHash) ) {
                        $_SESSION['username'] = $enteredUsername;
                        header(REFRESH_TIME . 'url=main_menu_clerk.php');		//to view the password hashes and login success/failure
                    }else {
                        array_push($error_msg,  "Password not match.");
                    }
                }else {
                    array_push($error_msg,  "Clerk not exists.");
                }
            }
    }    
}          
?>

<?php include("lib/header.php"); ?>
<title>Tools-4-Rent Login</title>
</head>
<body>
    <div id="main_container">
        <div id="header">
            <div class="logo">
                <img src="img/gtonline_logo.png" style="opacity:0.5;background-color:E9E5E2;" border="0" alt="" title="GT Online Logo"/>
            </div>
        </div>

        <div class="center_content">
            <div class="text_box">

                <form action="login.php" method="post" enctype="multipart/form-data">
                    <div class="title">Toos-4-Rent! Login</div>
                    <div class="login_form_row">
                        <label class="login_label">Username:</label>
                        <input type="text" name="username" value="" class="login_input"/>
                    </div>
                    <div class="login_form_row">
                        <label class="login_label">Password:</label>
                        <input type="password" name="password" value="" class="login_input"/>
                    </div>
                    <div class="login_form_row">
                        <label class="login_usertype">Customer</label>
                        <input type="radio" name="usertype" value="customer" checked /> 
                        <label class="login_usertype">Clerk</label>
                        <input type="radio" name="usertype" value="clerk" /> 
                    </div> 
                    <input type="image" src="img/login.gif" class="login"/>
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
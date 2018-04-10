@@ -0,0 +1,439 @@
<?php
/**
 * States Dropdown 
 *
 * @uses check_select
 * @param string $post, the one to make "selected"
 * @param string $type, by default it shows abbreviations. 'abbrev', 'name' or 'mixed'
 * @return string
 */
function StateDropdown($post=null, $type='abbrev') {
	$states = array(
		array('AK', 'Alaska'),
		array('AL', 'Alabama'),
		array('AR', 'Arkansas'),
		array('AZ', 'Arizona'),
		array('CA', 'California'),
		array('CO', 'Colorado'),
		array('CT', 'Connecticut'),
		array('DC', 'District of Columbia'),
		array('DE', 'Delaware'),
		array('FL', 'Florida'),
		array('GA', 'Georgia'),
		array('HI', 'Hawaii'),
		array('IA', 'Iowa'),
		array('ID', 'Idaho'),
		array('IL', 'Illinois'),
		array('IN', 'Indiana'),
		array('KS', 'Kansas'),
		array('KY', 'Kentucky'),
		array('LA', 'Louisiana'),
		array('MA', 'Massachusetts'),
		array('MD', 'Maryland'),
		array('ME', 'Maine'),
		array('MI', 'Michigan'),
		array('MN', 'Minnesota'),
		array('MO', 'Missouri'),
		array('MS', 'Mississippi'),
		array('MT', 'Montana'),
		array('NC', 'North Carolina'),
		array('ND', 'North Dakota'),
		array('NE', 'Nebraska'),
		array('NH', 'New Hampshire'),
		array('NJ', 'New Jersey'),
		array('NM', 'New Mexico'),
		array('NV', 'Nevada'),
		array('NY', 'New York'),
		array('OH', 'Ohio'),
		array('OK', 'Oklahoma'),
		array('OR', 'Oregon'),
		array('PA', 'Pennsylvania'),
		array('PR', 'Puerto Rico'),
		array('RI', 'Rhode Island'),
		array('SC', 'South Carolina'),
		array('SD', 'South Dakota'),
		array('TN', 'Tennessee'),
		array('TX', 'Texas'),
		array('UT', 'Utah'),
		array('VA', 'Virginia'),
		array('VT', 'Vermont'),
		array('WA', 'Washington'),
		array('WI', 'Wisconsin'),
		array('WV', 'West Virginia'),
		array('WY', 'Wyoming')
	);
	
	$options = '<option value=""></option>';
	
	foreach ($states as $state) {
		if ($type == 'abbrev') {
    	$options .= '<option value="'.$state[0].'" '. check_select($post, $state[0], false) .' >'.$state[0].'</option>'."\n";
    } elseif($type == 'name') {
    	$options .= '<option value="'.$state[1].'" '. check_select($post, $state[1], false) .' >'.$state[1].'</option>'."\n";
    } elseif($type == 'mixed') {
    	$options .= '<option value="'.$state[0].'" '. check_select($post, $state[0], false) .' >'.$state[1].'</option>'."\n";
    }
	}
		
	echo $options;
}

/**
 * Check Select Element 
 *
 * @param string $i, POST value
 * @param string $m, input element's value
 * @param string $e, return=false, echo=true 
 * @return string 
 */
function check_select($i,$m,$e=true) {
	if ($i != null) { 
		if ( $i == $m ) { 
			$var = ' selected="selected" '; 
		} else {
			$var = '';
		}
	} else {
		$var = '';	
	}
	if(!$e) {
		return $var;
	} else {
		echo $var;
	}
}

?>

<?php
include('lib/common.php');
// written by GTusername1
if($showQueries){
  array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");
}

if( $_SERVER['REQUEST_METHOD'] == 'POST') {
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
	$enteredFirstname = mysqli_real_escape_string($db, $_POST['firstname']);
	$enteredMiddlename = mysqli_real_escape_string($db, $_POST['middlename']);
	$enteredLastname = mysqli_real_escape_string($db, $_POST['lastname']);
    
	$enteredPhonetype = mysqli_real_escape_string($db, $_POST['phonetype']);
    $enteredHomephone = mysqli_real_escape_string($db, $_POST['homephone']);
	$enteredWorkphone = mysqli_real_escape_string($db, $_POST['workphone']);
    $enteredCellphone = mysqli_real_escape_string($db, $_POST['cellphone']);
    
	$enteredUsername = mysqli_real_escape_string($db, $_POST['username']);
    $enteredEmail = mysqli_real_escape_string($db, $_POST['email']);
	$enteredPassword = mysqli_real_escape_string($db, $_POST['password']);
	$enteredRetry_password = $_POST['retry_password'];
	$enteredStreetaddress = mysqli_real_escape_string($db, $_POST['streetaddress']);
	$enteredCity = mysqli_real_escape_string($db, $_POST['city']);
	$enteredState = mysqli_real_escape_string($db, $_POST['state']);
	$enteredZipcode = mysqli_real_escape_string($db, $_POST['zipcode']);
	$enteredCreditcardname = mysqli_real_escape_string($db, $_POST['creditcardname']);
	$enteredCreditcard = mysqli_real_escape_string($db, $_POST['creditcard']);
	$enteredExpiremonth = mysqli_real_escape_string($db, $_POST['expiremonth']);
	$enteredExpireyear = mysqli_real_escape_string($db, $_POST['expireyear']);
	$enteredCVC = mysqli_real_escape_string($db, $_POST['CVC']);
    
    
    if (empty(test_input($enteredFirstname))) {
        array_push($error_msg,  "Please enter a first name.");
    }
    
    if (empty(test_input($enteredLastname))) {
        array_push($error_msg,  "Please enter a last name.");
    }
    
    if (empty(test_input($enteredUsername))) {
        array_push($error_msg,  "Please enter a username.");
    }else{
        $mysql_get_users = mysqli_query("SELECT * FROM User where username='$enteredUsername'");
        $count = mysqli_num_rows($mysql_get_users); 
        if($count >=1){
            array_push($error_msg,  "Please enter a new username.");
        }
    }
    
    if (empty(test_input($enteredEmail))) {
        array_push($error_msg,  "Please enter a email address.");
    }else{  
        $email = test_input($enteredEmail);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($error_msg,  "Please enter a valid email address.");
        }
    }
    
    if (empty(test_input($enteredPassword))) {
        array_push($error_msg,  "Please enter a password.");
    }
    
    if (empty(test_input($enteredRetry_password))) {
        array_push($error_msg,  "Please enter re-enter password.");
    }else{
        if	($enteredRetry_password != $enteredPassword){
            array_push($error_msg,  "Password not match.");
        }
    }   
    
    if (empty(test_input($enteredCreditcardname))) {
        array_push($error_msg,  "Please enter your name for creditcard.");
    }
    
    if (empty(test_input($enteredCreditcard))) {
        array_push($error_msg,  "Please enter creditcard name.");
    }else{
        $arr_cc = str_split($enteredCreditcard);
        foreach ($arr_cc as $element) {
            if (!is_numeric($element)) {
                array_push($error_msg,  "Please enter only number for creditcard.");}
            }
    } 
    
    if (empty(test_input($enteredExpiremonth))) {
        array_push($error_msg,  "Please enter expiration month.");
    }elseif ($enteredExpiremonth == 'Expiration Month'){
        array_push($error_msg,  "Please enter expiration month.");
    }
    
    if (empty(test_input($enteredExpireyear))) {
        array_push($error_msg,  "Please enter expiration year.");
    }elseif ($enteredExpireyear == 'Expiration Year'){
        array_push($error_msg,  "Please enter expiration year.");
    }
    
    if (empty(test_input($enteredCVC))) {
        array_push($error_msg,  "Please enter CVC.");
    }else{
        $arr_CVC = str_split($enteredCVC);
        foreach ($arr_CVC as $element) {
            if (!is_numeric($element)) {
                array_push($error_msg,  "Please enter only number.");
            }   
        }
    }            

    if ($enteredPhonetype == "Home Phone"){
        if (empty($enteredHomephone)) {
            array_push($error_msg,  "Please enter home phone number.");}   
        else{
            if (strlen($enteredHomephone)!=10){
                array_push($error_msg,  "Please enter a 10-digital number.");}   
            $arr1 = str_split($enteredHomephone);
            foreach ($arr1 as $element) {
            if (!is_numeric($element)) {
                array_push($error_msg,  "Please enter only number.");}   
            }
            $primaryPhone = $enteredHomephone;
            if (!empty($enteredWorkphone)) {
                if (strlen($enteredWorkphone)!=10){
                    array_push($error_msg,  "Please enter a 10-digital number.");}   
                $arr1 = str_split($enteredWorkphone);
                foreach ($arr1 as $element) {
                    if (!is_numeric($element)) {
                    array_push($error_msg,  "Please enter only number for Work phone.");}   
                }
            }
            if (!empty($enteredCellphone)) {
                if (strlen($enteredCellphone)!=10){
                    array_push($error_msg,  "Please enter a 10-digital number.");}   
                $arr1 = str_split($enteredCellphone);
                foreach ($arr1 as $element) {
                    if (!is_numeric($element)) {
                    array_push($error_msg,  "Please enter only number for Cell phone.");}   
                }
            }
        }
    }

    if ($enteredPhonetype == "Work Phone"){
        if (empty($enteredWorkphone)) {
            array_push($error_msg,  "Please enter work phone number.");
        }else{
            if (strlen($enteredWorkphone)!=10){
                array_push($error_msg,  "Please enter a 10-digital number.");}   
            $arr1 = str_split($enteredWorkphone);
            foreach ($arr1 as $element) {
                if (!is_numeric($element)) {
                    array_push($error_msg,  "Please enter only number.");}   
                }
            $primaryPhone = $enteredWorkphone;
            if (!empty($enteredHomephone)) {
                if (strlen($enteredHomephone)!=10){
                    array_push($error_msg,  "Please enter a 10-digital number.");}   
                $arr1 = str_split($enteredHomephone);
                foreach ($arr1 as $element) {
                    if (!is_numeric($element)) {
                    array_push($error_msg,  "Please enter only number for Home phone.");}   
                }
            }
            if (!empty($enteredCellphone)) {
                if (strlen($enteredCellphone)!=10){
                    array_push($error_msg,  "Please enter a 10-digital number.");}   
                $arr1 = str_split($enteredCellphone);
                foreach ($arr1 as $element) {
                    if (!is_numeric($element)) {
                    array_push($error_msg,  "Please enter only number for Cell phone.");}   
                }
            }
        }
    }

    if ($enteredPhonetype == "Cell Phone"){
        if (empty($enteredCellphone)) {
            array_push($error_msg,  "Please enter cell phone number.");
        }else{
            if (strlen($enteredCellphone)!=10){
                array_push($error_msg,  "Please enter a 10-digital number.");}   
            $arr1 = str_split($enteredCellphone);
            foreach ($arr1 as $element) {
                if (!is_numeric($element)) {
                    array_push($error_msg,  "Please enter only number.");}   
                }
            $primaryPhone = $enteredCellphone;
            if (!empty($enteredHomephone)) {
                if (strlen($enteredHomephone)!=10){
                    array_push($error_msg,  "Please enter a 10-digital number.");}   
                $arr1 = str_split($enteredHomephone);
                foreach ($arr1 as $element) {
                    if (!is_numeric($element)) {
                    array_push($error_msg,  "Please enter only number for Home phone.");}   
                }
            }
            if (!empty($enteredWorkphone)) {
                if (strlen($enteredWorkphone)!=10){
                    array_push($error_msg,  "Please enter a 10-digital number.");}   
                $arr1 = str_split($enteredWorkphone);
                foreach ($arr1 as $element) {
                    if (!is_numeric($element)) {
                    array_push($error_msg,  "Please enter only number for work phone.");}   
                }
            }
        }
    }
    $enteredMiddlename = !empty($enteredMiddlename) ? $enteredMiddlename : NULL;
    $enteredHomephone = !empty($enteredHomephone) ? $enteredHomephone : NULL;
    $enteredWorkphone = !empty($enteredWorkphone) ? $enteredWorkphone : NULL;
    $enteredCellphone = !empty($enteredCellphone) ? $enteredCellphone : NULL;

     $sql_user = "INSERT INTO User (username, email, first_name, middle_name, last_name, password) VALUES ('$enteredUsername', '$enteredEmail', '$enteredFirstname', '$enteredMiddlename', '$enteredLastname', '$enteredPassword')";   
     $query_user = mysqli_query($db, $sql_user); // or die(mysqli_error($db));
     if (!$query_user){
        array_push($error_msg,  "Insert User error: "."<br>".  __FILE__ ." line:". __LINE__."<br>".$sql_user );
     }

     $sql_customer = "INSERT INTO Customer (username, cc_name, cc_number, cc_exp_month, cc_exp_year, CVC, street_address, city, customer_state, zipcode, primary_phone_type, primary_phone_number, home_phone, work_phone, cell_phone)  VALUES('$enteredUsername', '$enteredCreditcardname', '$enteredCreditcard', '$enteredExpiremonth', '$enteredExpireyear', '$enteredCVC', '$enteredStreetaddress', '$enteredCity', '$enteredState', '$enteredZipcode', '$enteredPhonetype', '$primaryPhone', '$enteredHomephone', '$enteredWorkphone', '$enteredCellphone')";
     $query_customer = mysqli_query($db, $sql_customer);
     if (!$query_customer){
        array_push($error_msg,  "Insert Customer error: "."<br>".  __FILE__ ." line:". __LINE__."<br>".$sql_customer  );
     }else{
        header(REFRESH_TIME . 'url=view_profile_customer.php');
     }
}
?>


<?php include("lib/header.php"); ?>
<title>Register</title>
</head>
<body>
    <div id="main_container">
        <div id="header">
            <div class="logo">
                <img src="img/gtonline_logo.png" style="opacity:0.5;background-color:E9E5E2;" border="0" alt="" title="GT Online Logo"/>
            </div>
        </div>

        <div class="center_content">
            <div class="">
                <p>Customer Registration Form</p>
                <form action="regist.php" method="post" enctype="multipart/form-data">
                    <div class="login_form_row">                       
                        <input type="text" name="firstname" placeholder="First Name" class="login_input" required/>
                        <input type="text" name="middlename" placeholder="Middle Name" class="login_input"/>
                        <input type="text" name="lastname" placeholder="Last Name" class="login_input" required/>
                        <input type="text" name="homephone" placeholder="Home Phone" class="login_input"/>
                        <input type="text" name="workphone" placeholder="Work Phone" class="login_input"/>
                        <input type="text" name="cellphone" placeholder="Cell Phone" class="login_input"/> 
                    </div>
                    <div class="login_form_row">
                        <p>Primary Phone</p>
                        <input type="radio" name="phonetype" value="Home Phone" checked /> 
                        <label class="login_usertype">Home Phone</label>
                        <input type="radio" name="phonetype" value="Work Phone" /> 
                        <label class="login_usertype">Work Phone</label>
                        <input type="radio" name="phonetype" value="Cell Phone" /> 
                        <label class="login_usertype">Cell Phone</label>
                    </div> 
                    <div class="login_form_row">
                        <input type="text" name="username" placeholder="username" class="login_input" required/>
                        <input type="text" name="email" placeholder="Email Address" class="login_input" required/>
                        <input type="password" name="password" placeholder="password" class="login_input" required/>
                        <input type="password" name="retry_password" placeholder="Re-try password" class="login_input" required/>
                        <input type="text" name="streetaddress" placeholder="Street Address" class="login_input"/>
                        <input type="text" name="city" placeholder="City" class="login_input"/> 
                       
                        <select name="state" class="login_input" required>
                        <option value = '' >Choose your state</option>
                        <?php echo StateDropdown(null, 'abbrev'); ?>
                        </select>

                        <input type="text" name="zipcode" placeholder="Zip Code" class="login_input"/>
                    </div>
                    <div class="login_form_row">
                        <p>Credit Card</p>
                        <input type="text" name="creditcardname" placeholder="Name on Credit Card" required/> 
                        <input type="text" name="creditcard" placeholder="Credit Card#" required/> 
                        <select name = "expiremonth" required>
                            <option value = "Expiration Month" >Expiration Month</option>
                            <option value = 01 >January</option>
                            <option value = 02 >February</option>
                            <option value = 03 >March</option>
                            <option value = 04 >April</option> 
                            <option value = 05 >May</option>
                            <option value = 06 >June</option>
                            <option value = 07 >July</option>
                            <option value = 08 >August</option>
                            <option value = 09 >September</option>
                            <option value = 10 >October</option>
                            <option value = 11 >November</option>
                            <option value = 12 >December</option>
                        </select>
                        <select name = "expireyear" required>
                            <option value = "" >Expiration Year</option>
                            <?php 
                                for ($i = date('Y'); $i <= date('Y')+50; $i++) {
                                echo '<option value="'.$i.'">'.$i.'</option>';
                                } 
                            ?>
                        </select>
                        <input type="text" name="CVC" placeholder="CVC" required/> 

                    </div> 
                    <div class="login_form_row">
                    <input type="submit" value="Register">
                    </div>
                </form>
                </div>

                <?php include("lib/error.php"); ?>

                <div class="clear"></div>
            </div>
        </div>
    </body>
</html>
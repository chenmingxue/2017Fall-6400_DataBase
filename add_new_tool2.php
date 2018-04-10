<?php

include('lib/common.php');
// written by ztan63

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}

?>



<?php include("lib/header.php"); ?>
<title>Add New Tool</title>
</head>

<body>
    <div id="main_container">
    <?php include("lib/menu_clerk.php"); ?>

    <div class="center_content">
        <div class="center_left">        
            <div class="features">
            
                <div class="profile_section">
                    <div class="subtitle">Add Tool</div>
                        <p> </p>
                        <?php                            
                            
                            $enteredType = mysqli_real_escape_string($db, $_POST['tooltype']);
                            $enteredSubtype = mysqli_real_escape_string($db, $_POST['subtype']);
                            $enteredSuboption = mysqli_real_escape_string($db, $_POST['suboption']);
                            $enteredPurchase = mysqli_real_escape_string($db, $_POST['purchase_price']);
                            $enteredManufacturer = mysqli_real_escape_string($db, $_POST['manufacturer']);

                            $enteredWidth = mysqli_real_escape_string($db, $_POST['width']);
                            $enteredWidthfraction = mysqli_real_escape_string($db, $_POST['widthfraction']);
                            $enteredWidthunit = mysqli_real_escape_string($db, $_POST['widthunit']);

                            $enteredLength = mysqli_real_escape_string($db, $_POST['length']);
                            $enteredLengthfraction = mysqli_real_escape_string($db, $_POST['lengthfraction']);
                            $enteredLengthunit = mysqli_real_escape_string($db, $_POST['lengthunit']);    

                            $enteredWeight = mysqli_real_escape_string($db, $_POST['weight']);
                            $enteredPowerSource = mysqli_real_escape_string($db, $_POST['power_source']);
                            $addClerk = $_SESSION['username'];
                        

                            // check empty fields
                            if (empty($enteredSubtype)) {
                                array_push($error_msg,  "Please choose a subtype");
                            }

                            if (empty($enteredSuboption)) {
                                array_push($error_msg,  "Please choose a sub-option");
                            }

                            if (empty($enteredManufacturer)) {
                                array_push($error_msg,  "Please choose a manufacturer");
                            }

                            // convert input into number
                            $enteredPurchase = floatval($enteredPurchase);
                            $enteredWidth = floatval($enteredWidth);
                            $enteredWidthfraction = floatval($enteredWidthfraction);
                            $enteredLength = floatval($enteredLength);
                            $enteredLengthfraction = floatval($enteredLengthfraction);
                            $enteredWeight = floatval($enteredWeight);

                            // add up whole number and fraction 
                            if ($enteredWidthunit == "feet"){
                                $totalWidth = ($enteredWidth + $enteredWidthfraction)*12;
                            } else{
                                $totalWidth = ($enteredWidth + $enteredWidthfraction);
                            }

                            if ($enteredLengthunit == "feet"){
                                $totalLength = ($enteredLength + $enteredLengthfraction)*12;
                            } else{
                                $totalLength = ($enteredLength + $enteredLengthfraction);
                            }

                           
                            // insert data if all are filled
                            if (!empty($enteredSubtype) && !empty($enteredSuboption) && !empty($enteredManufacturer)){
                                $query = "INSERT INTO tool (purchase_price, tooltype, sub_type, sub_option, manufacturer, width_diameter, tool_length, tool_weight, power_source, add_by_clerk) VALUES ('$enteredPurchase', '$enteredType', '$enteredSubtype', '$enteredSuboption', '$enteredManufacturer', '$totalWidth', '$totalLength', '$enteredWeight', '$enteredPowerSource', '$addClerk')";

                                $result = mysqli_query($db, $query) or die ('Error adding tool');
                                include('lib/show_queries.php');

                                if ($result == False){
                                    array_push($error_msg, "Add Tool Error... <br>".  __FILE__ ." line:". __LINE__ );
                                } else {
                                    echo "New tool is added into database!";
                                }
                                
                            }
                            
                            
                        ?>
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
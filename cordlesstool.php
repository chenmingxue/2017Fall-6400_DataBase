<?php

include('lib/common.php');
// written by GTusername4

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}
$enteredBattery = mysqli_real_escape_string($db, $_POST['batterytype']);
$enteredBatteryquantity = mysqli_real_escape_string($db, $_POST['batteryquantity']);
$enteredDCvoltrating = mysqli_real_escape_string($db, $_POST['DCvoltrating']);



?>


<script type="text/javascript">
    function subtractBatteryquantity(){
            if(document.getElementById("batteryquantity").value - 1 < 0)
                    return;
            else
                     document.getElementById("batteryquantity").value--;
    }
    
    
</script


<?php include("lib/header.php"); ?>
<title>view_profile_customer</title>
</head>

<body>
    <div id="main_container">
    <?php include("lib/menu_clerk.php"); ?>

    <div class="center_content">
        <div class="center_left">        
            <div class="features">
            <form action="add_new_tool.php" method="post" enctype="multipart/form-data">
                <div class="profile_section">
                    <div class="subtitle">Cordless Tools Only</div>
                    <div class="login_form_row">
                        <p>Battery Type</p>
                        <select name = "batterytype" required>
                                <option value = "Li-ion" >Li-ion</option>
                                <?php 
                                    echo '<option value="'.'NiCd'.'">'.'NiCd'.'</option>';
                                    echo '<option value="'.'NiMH'.'">'.'NiMH'.'</option>';                              
                                ?>
                        </select>
                    </div>
                    <div class="login_form_row">
                        <p>Battery Quantity</p>
                        <form name="">
			<input type='text' name='batteryquantity' value = '1' id='batteryquantity'/>
			<input type='button' name='add' onclick='javascript: document.getElementById("batteryquantity").value++;' value='+'/>                           
			<input type='button' name='subtract' onclick='javascript: subtractBatteryquantity();' value='-'/>
                        </form>
                    </div>
                    <div class="login_form_row">
                        <p>D/C Volt Rating (7.2-80.0 Volts)</p>
                        <form name="">
			<input type='text' name='DCvoltrating' placeholder = '7.2'/>
                        </form>
                    </div>
                    
                </div>                  
                <div class="login_form_row">
                <input type="submit" value="Add Accessory"/>
                </div>
            </form>
            </div>
        </div> 			
    </div> 
    </div>    

               <?php include("lib/footer.php"); ?>
    </div>
</body>
</html>
<?php

include('lib/common.php');
// written by GTusername4

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}
$enteredType = mysqli_real_escape_string($db, $_POST['type']);
$enteredPowersource = mysqli_real_escape_string($db, $_POST['powersource']);
$enteredVoltrating = mysqli_real_escape_string($db, $_POST['voltrating']);
$enteredPurchase = mysqli_real_escape_string($db, $_POST['purchase']);
$enteredPowergenerated = mysqli_real_escape_string($db, $_POST['powergenerated']);
$enteredPowerfraction = mysqli_real_escape_string($db, $_POST['powerfraction']);
$enteredPowerunit = mysqli_real_escape_string($db, $_POST['powerunit']);
$enteredPressuremin = mysqli_real_escape_string($db, $_POST['pressuremin']);
$enteredPressuremax = mysqli_real_escape_string($db, $_POST['pressuremax']);
$enteredGaugehunit = mysqli_real_escape_string($db, $_POST['gaugehunit']);
$enteredCapacityhunit = mysqli_real_escape_string($db, $_POST['capacityunit']);
$enteredAmprating = mysqli_real_escape_string($db, $_POST['amprating']);
$enteredAmpunit = mysqli_real_escape_string($db, $_POST['ampunit']);
$enteredTorquemin = mysqli_real_escape_string($db, $_POST['torquemin']);
$enteredTorquemax = mysqli_real_escape_string($db, $_POST['torquemax']);
$enteredSpeedmin = mysqli_real_escape_string($db, $_POST['speedmin']);
$enteredSpeedmax = mysqli_real_escape_string($db, $_POST['speedmax']);
$enteredAccessoryquantity = mysqli_real_escape_string($db, $_POST['accessoryquantity']);
$enteredAccessorydescription = mysqli_real_escape_string($db, $_POST['accessorydescription']);


$query = "INSERT";


?>


<script type="text/javascript">
    function subtractPowergenerated(){
            if(document.getElementById("powergenerated").value - 1 < 0)
                    return;
            else
                     document.getElementById("powergenerated").value--;
    }
    function subtractPressuremin(){
            if(document.getElementById("pressuremin").value - 1 < 0)
                    return;
            else
                     document.getElementById("pressuremin").value--;
    }
    function subtractPressuremax(){
            if(document.getElementById("pressuremax").value - 1 < 0)
                    return;
            else
                     document.getElementById("pressuremax").value--;
    }
    function subtractTorquemin(){
            if(document.getElementById("torquemin").value - 1 < 0)
                    return;
            else
                     document.getElementById("torquemin").value--;
    }
    function subtractTorquemax(){
            if(document.getElementById("torquemax").value - 1 < 0)
                    return;
            else
                     document.getElementById("torquemax").value--;
    }
    function subtractSpeedmin(){
            if(document.getElementById("speedmin").value - 1 < 0)
                    return;
            else
                     document.getElementById("speedmin").value--;
    }
    function subtractSpeedmax(){
            if(document.getElementById("speedmax").value - 1 < 0)
                    return;
            else
                     document.getElementById("speedmax").value--;
    }
    function subtractAccessoryquantity(){
            if(document.getElementById("accessoryquantity").value - 1 < 0)
                    return;
            else
                     document.getElementById("accessoryquantity").value--;
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
                    <div class="subtitle">Power Tool Only</div>
                    <div class="login_form_row">
                        <p>Power Source</p>
                        <select name = "powersource" required>
                                <option value = "" >All</option>
                                <?php 
                                    echo '<option value="'.'electric'.'">'.'Electric'.'</option>';
                                    echo '<option value="'.'cordless'.'">'.'Cordless'.'</option>';
                                    echo '<option value="'.'gas'.'">'.'Gas'.'</option>';                                  
                                    echo '<option value="'.'manual'.'">'.'Manual'.'</option>';                                  
                                ?>
                        </select>
                    </div>
                    <div class="login_form_row">
                        <p>A/C Volt Rating</p>
                        <select name = "voltrating" required>
                                <option value = "" >All</option>
                                <?php 
                                    echo '<option value="'.'120'.'">'.'120'.'</option>';
                                    echo '<option value="'.'110'.'">'.'110'.'</option>';
                                    echo '<option value="'.'220'.'">'.'220'.'</option>';                                  
                                    echo '<option value="'.'240'.'">'.'240'.'</option>';                                  
                                ?>
                        </select>
                    </div>
                    <div class="login_form_row">
                        <p>Power Generated</p>
                        <form name="">
			<input type='text' name='powergenerated' value = '1.5' id='powergenerated'/>
			<input type='button' name='add' onclick='javascript: document.getElementById("powergenerated").value++;' value='+'/>                           
			<input type='button' name='subtract' onclick='javascript: subtractpPowergenerated();' value='-'/>
                        </form>
                    </div>
                    <div class="login_form_row">
                        <p>Power Fraction</p>
                        <select name = "powerfraction" required>
                                <option value = "" ></option>
                                <?php 
                                    echo '<option value="'.'1/8'.'">'.'1/8'.'</option>';
                                    echo '<option value="'.'1/4'.'">'.'1/4'.'</option>';
                                    echo '<option value="'.'3/8'.'">'.'3/8'.'</option>';
                                    echo '<option value="'.'1/2'.'">'.'1/2'.'</option>';
                                    echo '<option value="'.'5/8'.'">'.'5/8'.'</option>';
                                    echo '<option value="'.'3/4'.'">'.'3/4'.'</option>';
                                    echo '<option value="'.'7/8'.'">'.'7/8'.'</option>';
                                ?>
                        </select>
                    </div>
                    <div class="login_form_row">
                        <p>Power Unit</p>
                        <select name = "powerunit" required>
                                <option value = "" ></option>
                                <?php 
                                    echo '<option value="'.'horsepower'.'">'.'Horsepower'.'</option>';
                                    echo '<option value="'.'walt'.'">'.'Walt'.'</option>';                                  
                                ?>
                        </select>
                    </div>
                    <div class="login_form_row">
                        <p>Pressure Min(psi)</p>
                        <form name="">
			<input type='text' name='pressuremin' value = '1.0' id='pressuremin'/>
			<input type='button' name='add' onclick='javascript: document.getElementById("pressuremin").value++;' value='+'/>                           
			<input type='button' name='subtract' onclick='javascript: subtractPressuremin();' value='-'/>
                        </form>
                    </div>
                    <div class="login_form_row">
                        <p>Pressure Max(psi)</p>
                        <form name="">
			<input type='text' name='pressuremax' value = '1.0' id='pressuremax'/>
			<input type='button' name='add' onclick='javascript: document.getElementById("pressuremax").value++;' value='+'/>                           
			<input type='button' name='subtract' onclick='javascript: subtractPressuremax();' value='-'/>
                        </form>
                    </div>
                    <div class="login_form_row">
                        <p>Gauge Unit(Gun)</p>
                        <select name = "gaugeunit" required>
                                <option value = "" ></option>
                                <?php 
                                    echo '<option value="'.'18G'.'">'.'18G'.'</option>';
                                    echo '<option value="'.'20G'.'">'.'20G'.'</option>';
                                    echo '<option value="'.'22G'.'">'.'22G'.'</option>';
                                    echo '<option value="'.'24G'.'">'.'24G'.'</option>';
                                ?>
                        </select>
                    </div>
                    <div class="login_form_row">
                        <p>Capacity Unit(Gun)</p>
                        <input type="text" name="capacityunit" placeholder="100" />
                    </div>
                    <div class="login_form_row">
                        <p>Amp Rating</p>
                        <input type="text" name="amprating" placeholder="10.0" />
                    </div>
                    <div class="login_form_row">
                        <p>Amp Unit</p>
                        <select name = "ampunit" required>
                                <option value = "" ></option>
                                <?php 
                                    echo '<option value="'.'Amps'.'">'.'Amps'.'</option>';
                                ?>
                        </select>
                    </div>
                    <div class="login_form_row">
                        <p>Torque Min(ft-lb)</p>
                        <form name="">
			<input type='text' name='torquemin' value = '1.0' id='torquemin'/>
			<input type='button' name='add' onclick='javascript: document.getElementById("torquemin").value++;' value='+'/>                           
			<input type='button' name='subtract' onclick='javascript: subtractTorquemin();' value='-'/>
                        </form>
                    </div>
                    <div class="login_form_row">
                        <p>Torque Max(ft-lb)</p>
                        <form name="">
			<input type='text' name='torquemax' value = '2.0' id='torquemax'/>
			<input type='button' name='add' onclick='javascript: document.getElementById("torquemax").value++;' value='+'/>                           
			<input type='button' name='subtract' onclick='javascript: subtractTorquemax();' value='-'/>
                        </form>
                    </div>
                    <div class="login_form_row">
                        <p>Speed Min(RPM)</p>
                        <form name="">
			<input type='text' name='speedmin' value = '1.0' id='speedmin'/>
			<input type='button' name='add' onclick='javascript: document.getElementById("speedmin").value++;' value='+'/>                           
			<input type='button' name='subtract' onclick='javascript: subtractSpeedmin();' value='-'/>
                        </form>
                    </div>
                    <div class="login_form_row">
                        <p>Speed Max(RPM)</p>
                        <form name="">
			<input type='text' name='speedmax' value = '2.0' id='speedmax'/>
			<input type='button' name='add' onclick='javascript: document.getElementById("speedmax").value++;' value='+'/>                           
			<input type='button' name='subtract' onclick='javascript: subtractSpeedmax();' value='-'/>
                        </form>
                    </div>
                    
                    
                    <div class="subtitle">Power Tool Accessory</div>
                    <div class="login_form_row">
                        <p>Accessory Quantity</p>
                        <form name="">
			<input type='text' name='accessoryquantity' value = '1' id='accessoryquantity'/>
			<input type='button' name='add' onclick='javascript: document.getElementById("accessoryquantity").value++;' value='+'/>                           
			<input type='button' name='subtract' onclick='javascript: subtractAccessoryquantity();' value='-'/>
                        </form>
                    </div>
                    
                    <div class="login_form_row">
			<input type='text' name='accessorydescription' placeholder="Enter accessory description" />
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
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
if( $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $enteredType = mysqli_real_escape_string($db, $_POST['tool_type']);
    $enteredPowersource = mysqli_real_escape_string($db, $_POST['power_source']);
    $enteredSub_type = mysqli_real_escape_string($db, $_POST['subtype']);
    $enteredKeyword = mysqli_real_escape_string($db, $_POST['custom_search']); //only for sub options
    $enteredStartdate = mysqli_real_escape_string($db, $_POST['start_date']);
    $enteredEnddate = mysqli_real_escape_string($db, $_POST['end_date']);
    
    if($enteredEnddate<$enteredStartdate ){
        array_push($query_msg, "Please enter a end date not smaller than start date");
    }else{
        if ($enteredType == 'all_tools'){
        $query_all = "SELECT * FROM Tool WHERE power_source = '$enteredPowersource' AND sub_type='$enteredSub_type' AND sub_option LIKE '%$enteredKeyword%'"
            ."AND tool_number NOT IN (SELECT tool_number FROM ReservationOrderDetail ROD NATURAL JOIN ReservationOrder RO "
            ."WHERE NOT (reservation_start_date > '$enteredEnddate' OR reservation_end_date < '$enteredStartdate')) ORDER BY Tool.tool_number";
        }else{
        $query_all = "SELECT * FROM Tool WHERE tooltype='$enteredType' AND power_source = '$enteredPowersource' AND sub_type='$enteredSub_type' AND sub_option LIKE '%$enteredKeyword%'"
            ."AND tool_number NOT IN (SELECT tool_number FROM ReservationOrderDetail ROD NATURAL JOIN ReservationOrder RO "
            ."WHERE NOT (reservation_start_date > '$enteredEnddate' OR reservation_end_date < '$enteredStartdate')) ORDER BY Tool.tool_number";  
        }
        $result_all = mysqli_query($db, $query_all) or die(mysqli_error($db));
        $count_all = mysqli_num_rows($result_all); 
        if ($count_all>10){
            array_push($error_msg,  "Please narrowdown your search.");
        }else if ($count_all==0){
            array_push($error_msg,  "No tools available.");     
        }    
    }
    }
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type = "text/javascript">
    var listA = [
      {name:'Screw Driver', value:'Screw Driver'},
      {name:'Socket', value:'Socket'}, 
      {name:'Ratchet', value:'Ratchet'},
      {name:'Wrench', value:'Wrench'},
      {name:'Gun', value:'Gun'}, 
      {name:'Hammer', value:'Hammer'},
      {name:'Pruner', value:'Pruner'},
      {name:'Striker', value:'Striker'}, 
      {name:'Digger', value:'Digger'},
      {name:'Rake', value:'Rake'},
      {name:'Wheel Barrow', value:'Wheel Barrow'},
      {name:'Straight', value:'Straight'},
      {name:'Step', value:'Step'},
      {name:'Drill', value:'Drill'},
      {name:'Saw', value:'Saw'}, 
      {name:'Sander', value:'Sander'},
      {name:'Air Compressor', value:'Air Compressor'},
      {name:'Mixer', value:'Mixer'},
      {name:'Generator', value:'Generator'} 
    ];
    var listB = [
      {name:'Screw Driver', value:'Screw Driver'},
      {name:'Socket', value:'Socket'}, 
      {name:'Ratchet', value:'Ratchet'},
      {name:'Wrench', value:'Wrench'},
      {name:'Gun', value:'Gun'}, 
      {name:'Hammer', value:'Hammer'}
    ];
    var listC = [
      {name:'Pruner', value:'Pruner'},
      {name:'Striker', value:'Striker'}, 
      {name:'Digger', value:'Digger'},
      {name:'Rake', value:'Rake'},
      {name:'Wheel Barrow', value:'Wheel Barrow'} 
    ];
    var listD = [
      {name:'Straight', value:'Straight'},
      {name:'Step', value:'Step'} 
    ];
    var listE = [
      {name:'Drill', value:'Drill'},
      {name:'Saw', value:'Saw'}, 
      {name:'Sander', value:'Sander'},
      {name:'Air Compressor', value:'Air Compressor'},
      {name:'Mixer', value:'Mixer'},
      {name:'Generator', value:'Generator'} 
    ];
      $(document).ready( function() {
          $("input[name='tool_type']").on('click',function() {

              if($(this).is(':checked') && $(this).val() == 'all_tools')
              {
                $('#subtype').empty()
                $.each(listA, function(index, value) {
                 $('#subtype').append('<option value="'+value.value+'">'+value.name+'</option>');
                });                  
              }
              else if($(this).is(':checked') && $(this).val() == 'Hand')
              {
                $('#subtype').empty()
                $.each(listB, function(index, value) {
                 $('#subtype').append('<option value="'+value.value+'">'+value.name+'</option>');
                }); 
              }
              else if($(this).is(':checked') && $(this).val() == 'Garden')
              {
                $('#subtype').empty()
                $.each(listC, function(index, value) {
                 $('#subtype').append('<option value="'+value.value+'">'+value.name+'</option>');
                }); 
              }
              else if($(this).is(':checked') && $(this).val() == 'Ladder')
              {
                $('#subtype').empty()
                $.each(listD, function(index, value) {
                 $('#subtype').append('<option value="'+value.value+'">'+value.name+'</option>');
                }); 
              }
              else if($(this).is(':checked') && $(this).val() == 'Power')
              {
                $('#subtype').empty()
                $.each(listE, function(index, value) {
                 $('#subtype').append('<option value="'+value.value+'">'+value.name+'</option>');
                }); 
              }
              else
              {

              }

        });
     });  
</script> 
<?php include("lib/header.php"); ?>
<title>check_tool_availability</title>
</head>

<body>
    <div id="main_container">
    <?php include("lib/menu_customer.php"); ?>
        <div class="center_content">
        <div class="text-box">
            <div class="features">
                <div class="profile_section">
                    <div class="subtitle">Check Tool Availability</div>
                    <form action="check_tool_avail.php" method="post" enctype="multipart/form-data">
                    <div class="">
                        <p>Start Date:</p>
                            <input type="date" name="start_date" required>
                    </div>
                    <div class="">
                        <p>End Date:</p>
                            <input type="date" name="end_date" required>
                    </div>
                    <div class="">
                        <p>Customer Search:</p>
                            <input type="text" name="custom_search" >
                    </div>
                    <div class="subtitle">Type</div>   
                        <div class="text-box">
                        <input type="radio" id="All" name="tool_type" value="all_tools" checked>All tools <br/>
                        </div>
                        <br>
                        <div class="text-box">
                        <input type="radio" id="Hand" name="tool_type" value="Hand" >Hand tool<br/>
                        <input type="radio" id="Garden" name="tool_type" value="Garden" >Garden tool <br/>
                        <input type="radio" id="Ladder" name="tool_type" value="Ladder" >Ladder tool<br/>
                        <input type="radio" id="Power" name="tool_type" value="Power" >Power tool<br/>
                        </div>
                        <div class="center-block">
                        <select name = "power_source" required>
                            <option value = "manual" >Manual</option>
                            <option value = "A/C Electric" >A/C</option>
                            <option value = "D/C Electric" >D/C</option>
                            <option value = "gas" >Gas</option>
                        </select>
                       
                        <select id="subtype" name = "subtype">
                        <option value="">Select from above</option>
                        </select>
                        </div>
                    <div>
                    <input type="submit" value="Search"/>
                    </div>
                    </form>
                </div>
            </div> 
           
    <div class="features">           
        <div class="profile_section">
            <div class="subtitle">View Tools</div>   
                <table>
                    <tr>
                            <td class="heading">Tool ID</td>
                            <td class="heading">Description</td>
                            <td class="heading">Rental Price</td>
                            <td class="heading">Deposit Price</td>
                            <td class="heading">Details</td>
                    </tr>

                    <?php
                        while ($row_all = mysqli_fetch_array($result_all, MYSQLI_ASSOC)){
                            print "<tr>";
                            print "<td><a href='check_tool_avail.php?tool_detail=" . urlencode($row_all['tool_number']) . "'>{$row_all['tool_number']}</a></td>";
                            print "<td>{$row_all['sub_option']}"." "."{$row_all['sub_type']}</td>";
                            $num1 = $row_all['purchase_price']*0.15;
                            print "<td>"."$"."$num1</td>";
                            $num2 = $row_all['purchase_price']*0.4;
                            print "<td>"."$"."$num2</td>";
                            print "</tr>";							
                            }									
                    ?>
                </table>						
        </div>	
    </div> 
    
    <div class="features">           
        <div class="profile_section">
            <form action="check_tool_avail.php" method="post" enctype="multipart/form-data">
            <?php
                if (!empty($_GET['tool_detail'])) {
                    $tool_number = mysqli_real_escape_string($db, $_GET['tool_detail']);
                    $query = "SELECT tool_number, tooltype, (CASE WHEN power_source = 'manual'"
                            . " THEN concat (sub_option, ' ',sub_type) ELSE concat (power_source ,' ', sub_option , ' ', sub_type) END)"
                            . " AS short_description, concat (tool_length ,'in. ', width_diameter ,'in. ', tool_weight ,'lb. ', manufacturer)"
                            . " AS full_description, purchase_price*0.15 AS rental_price, purchase_price*0.40 AS deposit_price"
                            . " FROM Tool WHERE Tool.tool_number = '$tool_number'";
                    $result = mysqli_query($db, $query);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                }
//                echo "<pre>";
//                print_r ($row);
//                echo "</pre>";

                if (is_array($row)){
                        print '<h4>Tool ID:</h4><br>';
                        print '<p>' . $row['tool_number'] . '</p><br>';
                        print '<h4>Tool Type:</h4><br>';
                        print '<p>' . $row['tooltype'] . '</p><br>';
                        print '<h4>Short Description:</h4><br>';
                        print '<p>' . $row['short_description'] . '</p><br>';
                        print '<h4>Full Description:</h4><br>';
                        print '<p>' . $row['full_description'] . '</p><br>';
                        print '<h4>Rental Price:</h4><br>';
                        print '<p>$' . $row['rental_price'] . '</p><br>';
                        print '<h4>Deposit Price:</h4><br>';
                        print '<p>$' . $row['deposit_price'] . '</p><br>';
                        if ($enteredPowersource != "manual"){
                        $query_accessory= "SELECT powertoolhasaccessory.*, accessory.* FROM powertoolhasaccessory "
                                . "JOIN accessory ON accessory.accessory_name = powertoolhasaccessory.accessory_name "
                                . "WHERE powertoolhasaccessory.tool_number={$row['tool_number']}";
                        $result_accessory = mysqli_query($db, $query_accessory);
                        print '<h4>Accessories:</h4><br>';
                        $i=1;
                        while ($row_accessory = mysqli_fetch_array($result_accessory, MYSQLI_ASSOC)){   
                            $accessoryname=$row_accessory['accessory_name'];
                            $query_battery= "SELECT voltage, amperage, accessory_name FROM Powertoolhasaccessory"
                                    ." NATURAL JOIN Battery"
                                    ." WHERE Battery.accessory_name = '$accessoryname'";
                            $result_battery = mysqli_query($db, $query_battery);
                            $row_battery=mysqli_fetch_array($result_battery, MYSQLI_ASSOC);
                            if($row_battery['voltage']){
                                print '<p>'.$i++.' '. $row_battery['voltage'].'V '.$row_battery['amperage'].'A '.$row_battery['accessory_name'] . '</p><br>';                                  
                            }else{
                                print '<p>'.$i++.' '. $row_accessory['accessory_name'] . '</p><br>';
                            }
                        }
                    }
                    else {
                        print "None";
                    }
                }
            ?>
            </form>
        </div>
    </div> 

        <?php include("lib/error.php"); ?>
                    
            <div class="clear"></div> 		
            </div>    

        </div>
    </div>
    </body>
</html>
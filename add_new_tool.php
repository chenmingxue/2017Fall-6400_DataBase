<?php
include('lib/common.php');
// written by ztan63
if($showQueries){
  array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");
}

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
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
          $("input[name='tooltype']").on('click',function() {

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
<title>view_profile_customer</title>
</head>

<body>
    <div id="main_container">
    <?php include("lib/menu_clerk.php"); ?>

    <div class="center_content">
        <div class="text-box">        
            <div class="features">
            <div class="subtitle">Add Tool</div>
            <form action="add_new_tool2.php" method="post" enctype="multipart/form-data">
                <div class="profile_section">                    
                    
                    <div class="login_form_row">
                        <p>Type</p>
                        <div class="text-box">
                        <input type="radio" id="All" name="tooltype" value="all_tools" checked>All tools <br/>
                        </div>
                        <br>
                        <input type="radio" name="tooltype" value="Hand" checked = "checked" /> Hand Tool
                        <input type="radio" name="tooltype" value="Garden"  /> Garden Tool 
                        <input type="radio" name="tooltype" value="Ladder"  /> Ladder Tool
                        <input type="radio" name="tooltype" value="Power" /> Power Tool 
                        <br>
                    </div>           
                    <div class="login_form_row">
                     <select id="subtype" name = "subtype">
                        <option value="">Select from above</option>
                     </select>
                    </div>
                    <div class="login_form_row">
                        <p>----------------------------------------</p>
                    </div>

                    <div class="login_form_row">
                        <p>Sub-Option</p>
                        <select name = "suboption" required>
                            <option value = "" >choose Sub-Option</option>
                                <?php 
                                                                 
                                        printf ('<option value = "phillips">phillips</option>');
                                        printf ('<option value = "hex">hex</option>');
                                        printf ('<option value = "torx">torx</option>');
                                        printf ('<option value = "slotted">slotted</option>');
                                        printf ('<option value = "deep">deep</option>');
                                        printf ('<option value = "standard">standard</option>');
                                        printf ('<option value = "adjustable">adjustable</option>');
                                        printf ('<option value = "fixed">fixed</option>');
                                        printf ('<option value = "crescent">crescent</option>');
                                        printf ('<option value = "torque">torque</option>');
                                        printf ('<option value = "pipe">pipe</option>');
                                        printf ('<option value = "needle nose">needle nose</option>');
                                        printf ('<option value = "cutting">cutting</option>');
                                        printf ('<option value = "crimper">crimper</option>');
                                        printf ('<option value = "nail">nail</option>');
                                        printf ('<option value = "staple">staple</option>');
                                        printf ('<option value = "claw">claw</option>');
                                        printf ('<option value = "sledge">sledge</option>');
                                        printf ('<option value = "framing">framing</option>');
                                    
                                        printf ('<option value = "pointed shovel">pointed shovel</option>');
                                        printf ('<option value = "flat shovel">flat shovel</option>');
                                        printf ('<option value = "scoop shovel">scoop shovel</option>');
                                        printf ('<option value = "edger">edger</option>');
                                        printf ('<option value = "sheer">sheer</option>');
                                        printf ('<option value = "loppers">loppers</option>');
                                        printf ('<option value = "hedge">hedge</option>');
                                        printf ('<option value = "leaf">leaf</option>');
                                        printf ('<option value = "landscaping">landscaping</option>');
                                        printf ('<option value = "rock">rock</option>');
                                        printf ('<option value = "1-wheel">1-wheel</option>');
                                        printf ('<option value = "2-wheel">2-wheel</option>');
                                        printf ('<option value = "bar pry">ar pry</option>');
                                        printf ('<option value = "rubber mallet">ubber mallet</option>');
                                        printf ('<option value = "tamper">tamper</option>');
                                        printf ('<option value = "pick axe">ick axe</option>');
                                        printf ('<option value = "single bit axe">single bit axe</option>');
                                    
                                        printf ('<option value = "rigid">rigid</option>');
                                        printf ('<option value = "telescoping">telescoping</option>');
                                        printf ('<option value = "folding">folding</option>');
                                        printf ('<option value = "multi-position">multi-position</option>');
                                    
                                        printf ('<option value = "driver">driver</option>');
                                        printf ('<option value = "hammer">hammer</option>');
                                        printf ('<option value = "circular">circular</option>');
                                        printf ('<option value = "reciprocating">reciprocating</option>');
                                        printf ('<option value = "jig">jig</option>');
                                        printf ('<option value = "finish">finish</option>');
                                        printf ('<option value = "sheet">sheet</option>');
                                        printf ('<option value = "belt">belt</option>');
                                        printf ('<option value = "random orbital">random orbital</option>');
                                        printf ('<option value = "concrete">concrete</option>');
                                        printf ('<option value = "electric">electric</option>');                   
                                                                  
                                ?>
                        </select>
                   
                    </div>

                    <div class="login_form_row">
                        <p>Purchase Price</p>
                        <input type='number' name='purchase_price' value = '100.00' step = '0.01' min = '0' id='amt'/>
                    </div>

                    <div class="login_form_row"> 
                        <p>Manufacturer</p>
                        <input type="text" name="manufacturer" placeholder="Enter tool manufacturer" required/>
                    </div>

                    <div class="login_form_row">
                        <p>Width</p>
                        <input type='number' name='width' value = '5' min ='0' step = '1' id = 'width'>
                    </div>

                    <div class="login_form_row">
                        <p>Width Fraction</p>
                        <select type = "number" name = "widthfraction" step = "any" required>
                            <option value = "0" >0</option>
                                <?php
                                    printf ('<option value = "0.125">1/8</option>'); 
                                    printf ('<option value = "0.25">1/4</option>');
                                    printf ('<option value = "0.375">3/8</option>');
                                    printf ('<option value = "0.5">1/2</option>');
                                    printf ('<option value = "0.625">5/8</option>');
                                    printf ('<option value = "0.75">3/4</option>');
                                    printf ('<option value = "0.875">7/8</option>');                                   
                                ?>
                        </select>
                    </div>

                    <div class="login_form_row">
                        <p>Width Unit</p>
                        <select name = "widthunit" required>
                                <option value = "inches" >inches</option>
                                <?php                                     
                                    echo '<option value="'.'feet'.'">'.'feet'.'</option>';
                                ?>
                        </select>
                    </div>     

                    <div class="login_form_row">
                        <p>Length</p>
                        <input type='number' name='length' value = '6' min = '0' step = '1' id='length'/>
                    </div>

                    <div class="login_form_row">
                        <p>Length Fraction</p>
                        <select name = "lengthfraction" type = "number" step = "any" required>
                            <option value = "0" >0</option>
                                <?php 

                                    printf ('<option value = "0.125">1/8</option>'); 
                                    printf ('<option value = "0.25">1/4</option>');
                                    printf ('<option value = "0.375">3/8</option>');
                                    printf ('<option value = "0.5">1/2</option>');
                                    printf ('<option value = "0.625">5/8</option>');
                                    printf ('<option value = "0.75">3/4</option>');
                                    printf ('<option value = "0.875">7/8</option>');
                                ?>
                        </select>
                    </div>

                    <div class="login_form_row">
                        <p>Length Unit</p>
                        <select name = "lengthunit" required>
                                <option value = "inches" >inches</option>
                                <?php 
                                    echo '<option value="'.'feet'.'">'.'feet'.'</option>';                                 
                                ?>
                        </select>
                    </div>

                    <div class="login_form_row">
                        <p>Weight</p>                        
                    	<input type='number' name='weight' value = '10.0' step = '0.1' min = '0' id='weight'/>                			
                    </div>    
                    

                    <div class="login_form_row">
                        <p>Power Source</p>
                        <select name = "power_source" required>
                                <option value = "manual" >manual</option>
                                <?php                                     
                                    echo '<option value="'.'D/C Electric'.'">'.'D/C Electric'.'</option>';
                                    echo '<option value="'.'A/C Electric'.'">'.'A/C Electric'.'</option>';
                                    echo '<option value="'.'Gas'.'">'.'Gas'.'</option>';
                                ?>
                        </select>
                    </div>

                    <div class="login_form_row">
                        <input type="submit" name = "Confirm" value="Confirm"/>
                    </div>

       
                </div>
            </form>
                            
                
            
            </div>
        </div> 	<div class="clear"></div>  		
    </div> 
                <?php include("lib/error.php"); ?>
                    
                
    </div>    

               <?php include("lib/footer.php"); ?>
    </div>
</body>
</html>
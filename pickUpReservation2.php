<?php

include('lib/common.php');
// written by jhe321

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}
// ERROR: demonstrating SQL error handlng, to fix




    $query = "SELECT reservation_id, full_name, username, sum(rental_price * rental_days) as total_rental_price, sum(deposit_price) as total_deposit FROM (SELECT ROD.*, concat(first_name, ' ', last_name) as full_name, C.username, reservation_start_date, reservation_end_date, DATEDIFF(reservation_end_date,reservation_start_date) as rental_days, T.purchase_price, T.purchase_price * 0.15 AS rental_price, T.purchase_price * 0.4 AS deposit_price FROM User INNER JOIN Customer C ON User.username=C.username INNER JOIN reservationorder R ON C.username = R.customer INNER JOIN reservationorderdetail ROD ON R.reservation_id = ROD.reservation_id INNER JOIN tool T ON T.tool_number = ROD.tool_number WHERE R.reservation_id = '{$_POST['pickup']}') CALCULATE GROUP BY reservation_id, full_name,username";
      
            

    $result = mysqli_query($db, $query); //or die(mysqli_error($db));
    include('lib/show_queries.php');
 
    if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        array_push($error_msg,  "Query ERROR: Failed to get Reservation Information..Check the query.<br>" . __FILE__ ." line:". __LINE__ );
    }
    ;
?>



<?php include("lib/header.php"); ?>
<title>Pick Up Confirmation</title>
</head>


<style>
    .hidden{
        display: none;
    }
</style>


<script type = "text/javascript">

    function showHide(){
        var radio_new = document.getElementById("crd_new");
        var radio_exist = document.getElementById("crd_exist");
        var hiddeninputs = document.getElementsByClassName("hidden");

        for(var i = 0; i !=  hiddeninputs.length; i++){
            if(radio_new.checked){
                hiddeninputs[i].style.display = "block";
            }
            else{
                hiddeninputs[i].style.display = "none";
            }
        }

        for(var i = 0; i !=  hiddeninputs.length; i++){
            if(radio_exist.checked){
                hiddeninputs[i].style.display = "none";
            }
            else{
                hiddeninputs[i].style.display = "block";
            }
        }
    }

</script>


<body>
<div id="main_container">
    <?php include("lib/menu_clerk.php"); ?>

    <div class="center_content">
        <div class="center_left"> 

            <div class="title_name">
                Pickup Reservation
            </div>   

            <div class = "features">

            <div class="profile_section">
                      
                    <table>
                        <tr>
                            <td class="item_label">Reservation ID:</td>
                            <td>
                                <?php print $row['reservation_id'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Customer Name</td>
                            <td>
                                <?php print $row['full_name'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Total Deposit</td>
                            <td>
                                <?php print $row['total_deposit'];?>
                            </td>
                        </tr>
                         <tr>
                            <td class="item_label">Total Rental Price</td>
                            <td>
                                <?php print $row['total_rental_price'];?>
                            </td>
                        </tr>

                    </table>
                                         
                    
                 


                </div>

                <div class="login_form_row">
                <form action="pickUpReservation3.php" method="post" target="_blank">  
                
                <div class="subtitle">Credit Card</div>
                    Existing Credit Card<br>  
                <input type='radio' name='crd_card' id = "crd_exist" value = "existing credit card" checked = "checked" onclick = "showHide()" /> <br>
                    New Credit Card <br>
                <input type="radio" name = 'crd_card' id = "crd_new" value = "new credit card" onclick = "showHide()"/> <br>
                </div>


                <div class="login_form_row">
            
                <div class = "hidden">Enter Credit Card Information</div>   
                <div class = "hidden">** THIS WILL OVERWRITE THE PRIOR CUSTOMERS CREDIT CARD INFORMATION **</div>   
                <input class= "hidden" type='text' name='name' placeholder ="Name on Credit Card" id = 'crd'/>
                <input class= "hidden" type="text" name = 'cardnum' placeholder ="Credit Card #" pattern = "[0-9]{5,16}" /> <br>
                <input class= "hidden" type="text" name = 'cvc' placeholder ="CVC" pattern = "[0-9]{3}" pattern = "[0-9]{3}"/> <br>
                <input class= "hidden" type="number" name = 'expmonth' placeholder ="Expiration Month" min = "1" max = "12" />
                <input class= "hidden" type="number" name = 'expyear' placeholder ="Expiration Year" min = "2017" max = "2027" /><br>
                <input type="hidden" name="reservation_id" value="<?php echo $_POST['pickup']; ?>">
                <input type="hidden" name="clerk" value="<?php echo  $_SESSION['username']; ?>">
                <input type="hidden" name="customer" value="<?php echo  $row['username']; ?>">
                <input type="submit" name = 'submit' placeholder ="Confirm Pick Up"/>
                <p id="demo"></p>
                </div>

            </form>



            </div> 			
        </div> 

                <?php include("lib/error.php"); ?>
                    
				<div class="clear"></div> 		
			</div>    

               <?php include("lib/footer.php"); ?>
				 
		</div>
	</body>
</html>
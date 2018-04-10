<?php

include('lib/common.php');
// written by GTusername4
if( $_SERVER['REQUEST_METHOD'] == 'POST') {

    $enteredType = mysqli_real_escape_string($db, $_POST['viewcus']);


// ERROR: demonstrating SQL error handlng, to fix
// replace 'sex' column with 'gender' below:
    $query = "SELECT first_name, last_name, email, home_phone, work_phone, cell_phone, street_address, city, customer_state, zipcode " .
        "FROM User INNER JOIN Customer ON User.username=Customer.username " .
        "WHERE User.username='$enteredType'";

    $result = mysqli_query($db, $query); //or die(mysqli_error($db));
    include('lib/show_queries.php');

    if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        array_push($error_msg, "Query ERROR: Failed to get User profile...<br>" . __FILE__ . " line:" . __LINE__);
    }

//Get reservation information
    $query_reservation = "SELECT
    reservationorder.reservation_id,
     reservationorderdetail.tool_number,
    reservation_start_date,
    reservation_end_date,
    pickup_clerk,
    dropoff_clerk,
    DATEDIFF(
        reservation_end_date,
        reservation_start_date
    ) AS number_of_days,
    (
        CASE WHEN power_source = 'manual' THEN CONCAT_WS(\",\", sub_option, sub_type) ELSE CONCAT_WS(
            \",\",
            power_source,
            sub_option,
            sub_type
        )
    END
) AS short_description,
SUM(purchase_price * 0.15) *(
    DATEDIFF(
        reservation_end_date,
        reservation_start_date
    )
) AS total_rental_price,
(purchase_price * 0.4) 
 AS total_deposit_price
FROM
    reservationorder
INNER JOIN reservationorderdetail ON reservationorder.reservation_id = reservationorderdetail.reservation_id
INNER JOIN tool ON reservationorderdetail.tool_number = tool.tool_number
WHERE
    reservationorder.customer = '$enteredType'
GROUP BY   
    reservationorder.reservation_id,
    reservationorderdetail.tool_number,
    reservation_start_date,
    reservation_end_date,
    pickup_clerk,
    dropoff_clerk,
    power_source,
    sub_option,
    sub_type,
    rent_start_date
ORDER BY 
    rent_start_date
DESC";


    $result_reservation = mysqli_query($db, $query_reservation); //or die(mysqli_error($db));
//$row_reservation = mysqli_fetch_array($result_reservation, MYSQLI_ASSOC);
}
?>

<?php include("lib/header.php"); ?>
<title>view_profile_customer</title>
</head>

<body>
<div id="main_container">
    <?php include("lib/menu_clerk.php"); ?>

    <div class="center_content">
        <div class="center_left">
            <div class="features">
                <div class="profile_section">
                    <div ><a href="customerreport.php" <?php if($current_filename=='reports.php') echo "class='active'"; ?>>Back to the Customer Report</a></div>
                    <div class="subtitle">Customer Info</div>
                    <div class="">E-mail: <?php print $row['email']; ?> </div>
                    <div class="">Full Name: <?php print $row['first_name'] . ' ' . $row['last_name']; ?> </div>
                    <div class="">Home Phone: <?php print $row['home_phone']; ?> </div>
                    <div class="">Work Phone: <?php print $row['work_phone']; ?> </div>
                    <div class="">Cell Phone: <?php print $row['cell_phone']; ?> </div>
                    <div class="">Address: <?php print $row['street_address'].', '.$row['city'].', '.$row['customer_state'].', '.$row['zipcode']; ?> </div>

                </div>

                <div class="profile_section">
                    <div class="subtitle">Reservations</div>
                    <table>
                        <tr>
                            <td class="heading">Reservation ID</td>
                            <td class="heading">Tools</td>
                            <td class="heading">Short Description</td>
                            <td class="heading">Start Date</td>
                            <td class="heading">End Date</td>
                            <td class="heading">Pick-up Clerk</td>
                            <td class="heading">Drop-off Clerk</td>
                            <td class="heading">Number of Days</td>
                            <td class="heading">Total Deposit Price</td>
                            <td class="heading">Total Rental Price</td>

                        </tr>

                        <?php

                        while ($row_reservation = mysqli_fetch_array($result_reservation, MYSQLI_ASSOC)){
                            echo "<tr>";
                            echo "<td>" . $row_reservation['reservation_id']. "</td>";
                            echo "<td>" . $row_reservation['tool_number']. "</td>";
                            echo "<td>".$row_reservation['short_description']."</td>";
                            echo "<td>" . $row_reservation['reservation_start_date']. "</td>";
                            echo "<td>" . $row_reservation['reservation_end_date']. "</td>";
                            echo "<td>" . $row_reservation['pickup_clerk']. "</td>";
                            echo "<td>" . $row_reservation['dropoff_clerk']. "</td>";
                            echo "<td>" . $row_reservation['number_of_days']. "</td>";
                            echo "<td>" . $row_reservation['total_deposit_price']. "</td>";
                            echo "<td>" . $row_reservation['total_rental_price']. "</td>";



                            echo "</tr>";


                        }
                        ?>
                    </table>

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
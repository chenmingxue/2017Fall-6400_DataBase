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

?>

<?php include("lib/header.php"); ?>
<title>reports</title>
</head>

<body>
<div id="main_container">
    <?php include("lib/menu_clerk.php"); ?>
    <div class="center_content">
        <div class="center_left">
            <div class="features">
                <div class="profile_section">
                    <div ><a href="reports.php" <?php if($current_filename=='reports.php') echo "class='active'"; ?>>Back to the Report List</a></div>
                    <div class="subtitle">Customer Report</div>


                    <?php
                    $sql="SELECT
cc_number,
first_name,
middle_name,
last_name,
email,
primary_phone_number,
total_reservation,
total_tool_rented,
customer.username
FROM `user` 
INNER JOIN customer 
ON `user`.username = customer.username
INNER JOIN
(
SELECT customer, COUNT(reservation_id) AS total_reservation
FROM reservationorder
GROUP BY customer) AS TotalReservation
ON TotalReservation.customer = customer.username
INNER JOIN
(
SELECT customer, COUNT(tool_number) AS total_tool_rented
FROM reservationorder INNER JOIN reservationorderdetail
ON reservationorder.reservation_id=reservationorderdetail.reservation_id
 Group By customer) AS bb
ON TotalReservation.customer=bb.customer";
                    if($result =mysqli_query($db,$sql)){
                        if(mysqli_num_rows($result)>0){
                            echo "<table>";
                            echo"<tr>";
                            echo"<th>Customer ID</th>";
                            echo"<th>View Profile </th>";
                            echo"<th>First Name</th>";
                            echo"<th>Middle Name </th>";
                            echo"<th>Last Name </th>";
                            echo"<th>Email</th>";
                            echo"<th>Primary Phone Number</th>";
                            echo"<th>Total reservation </th>";
                            echo"<th>Total Tool Rented </th>";
                            echo"</tr>";
                            while($row=mysqli_fetch_array($result)) {
                                //$biaoji=$row['username'];
                                echo "<tr>";
                                echo "<td>" . $row['cc_number'] . "</td>";
                                echo "<td>
                                      <form method=\"POST\" action=\"report_customer_view_profile.php\">
                                      <input type=\"hidden\" name=\"viewcus\" value=\"$row[username]\" />
                                      <input type=\"submit\" value=\"View Profile\" />
                                      </form>
                                      </td>";
                                echo "<td>" . $row['first_name'] . "</td>";
                                echo "<td>" . $row['middle_name'] . " </td>";
                                echo "<td>" . $row['last_name'] . " </td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['primary_phone_number'] . "</td>";
                                echo "<td>" . $row['total_reservation'] . " </td>";
                                echo "<td>" . $row['total_tool_rented'] . " </td>";
                                echo "</tr>";
                            }
                            echo"</table>";


                        }
                    }

                    $result = mysqli_query($db, $sql);
                    if (is_bool($sql) && (mysqli_num_rows($result) == 0) ) {
                        //false positive if no friends
                        array_push($error_msg, "No report available" . __FILE__ . " line:" . __LINE__);
                    }
                    mysqli_close($db);
                    ?>
                </div>
            </div>
        </div>
        <?php include("lib/error.php"); ?>

        <div class="clear"></div>
    </div>



</div>
</body>

</html>
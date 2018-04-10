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
                    <div class="subtitle">Clerk Report</div>


                    <?php
                      $sql="SELECT
    employee_number AS 'Clerk ID',
    first_name AS 'First Name',
    middle_name AS 'Middle Name',
    last_name AS 'Last Name',
    email AS 'Email',
    hire_date AS 'Hire Date',
    COALESCE(total_pickup,0) AS 'Number of Pickups',
    COALESCE(total_dropoff,0) AS 'Number of Dropoffs',
    COALESCE(total_pickup,0)+COALESCE(total_dropoff,0) AS 'Combined Total'
    
FROM
    `user`
INNER JOIN clerk ON `user`.`username` = clerk.username
LEFT OUTER JOIN(
    SELECT
        pickup_clerk,0,
        COUNT(reservation_id) AS total_pickup
    FROM
        reservationorder
	where MONTH(CURDATE())=MONTH((rent_start_date))
	AND
	      YEAR(CURDATE())=YEAR((rent_start_date))
    GROUP BY
        pickup_clerk) AS TotalPickup

ON
    TotalPickup.pickup_clerk = clerk.username
LEFT OUTER JOIN(
    SELECT
        dropoff_clerk,
        COUNT(reservation_id) AS total_dropoff
    FROM
        reservationorder
	where MONTH(CURDATE())=MONTH((rent_end_date))
	AND
	      YEAR(CURDATE())=YEAR((rent_end_date))
    GROUP BY
        dropoff_clerk ) AS TotalDropoff
		
ON
    TotalDropoff.dropoff_clerk = clerk.username";
                      if($result =mysqli_query($db,$sql)){
                          if(mysqli_num_rows($result)>0){
                              echo "<table>";
                               echo"<tr>";
                                echo"<th>Clerk ID</th>";
                                echo"<th>First Name</th>";
                                echo"<th>Middle Name </th>";
                                echo"<th>Last Name </th>";
                                echo"<th>Email</th>";
                                echo"<th>Hire Date</th>";
                                echo"<th>Number of Pickups </th>";
                                echo"<th>Number of Dropoffs </th>";
                                echo"<th>Combined Total </th>";
                               echo"</tr>";
                              while($row=mysqli_fetch_array($result)) {
                                  echo "<tr>";
                                  echo "<td>" . $row['Clerk ID'] . "</td>";
                                  echo "<td>" . $row['First Name'] . "</td>";
                                  echo "<td>" . $row['Middle Name'] . " </td>";
                                  echo "<td>" . $row['Last Name'] . " </td>";
                                  echo "<td>" . $row['Email'] . "</td>";
                                  echo "<td>" . $row['Hire Date'] . "</td>";
                                  echo "<td>" . $row['Number of Pickups'] . " </td>";
                                  echo "<td>" . $row['Number of Dropoffs'] . " </td>";
                                  echo "<td>" . $row['Combined Total'] . " </td>";
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
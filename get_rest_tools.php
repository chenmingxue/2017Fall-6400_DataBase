<?php

include ('lib/common.php');

$tool_list = '';
$err_msg = '';

if ($_POST['tool_list']) {
  $tool_list = '(' . $_POST['tool_list'] . ')';
} else {
  $err_msg = 'No POST data available.';
}

$results = array();
// Leave for the real DB connection when you test.
$rest_list_sql = "SELECT * FROM Tool WHERE tool_number NOT IN " . $tool_list;
while ($rows = mysqli_fetch_array($rest_list_sql, MYSQLI_ASSOC)){
  $results[] = [
    'tool_number' => $rows['tool_number'],
    'sub_option' => $rows['sub_option'],
    'sub_type' => $rows['sub_type'],
    'purchase_price' => $rows['purchase_price']
  ];
}

if(count($results) > 0) {
  echo json_encode ($results, TRUE);
} else {
  $err_msg = 'No tools available from system. Please check again!';
}

if(strlen($err_msg) > 0) {
  echo json_encode (array('error' => $err_msg), TRUE);
}


// This is the dummy data for test ONLY.
//$results = [
//  [
//    'tool_number' => 1,
//    'sub_option' => 'Hammer',
//    'sub_type' => 'Rent',
//    'purchase_price' => '$34.00'
//  ],
//  [
//    'tool_number' => 2,
//    'sub_option' => 'Drill',
//    'sub_type' => 'Rent',
//    'purchase_price' => '$314.00'
//  ]
//];

echo json_encode ($results, TRUE);

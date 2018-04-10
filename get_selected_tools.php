<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include('lib/common.php');
if( $_SERVER['REQUEST_METHOD'] == 'POST') {

    $enteredtool_number = mysqli_real_escape_string($db, $_POST['tool_number']);
    
}


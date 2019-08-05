<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

require_once("../system/db.php");
require_once("../../lang/".$_SESSION['lang'].".php");


// weekly sales

//include_once("weekly_sales.php");

include_once("per_rep_sales.php");



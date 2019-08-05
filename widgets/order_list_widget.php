<?php

session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../index.php"); // if not go to login
}
require_once "../modules/system/db.php";  // get pdo connection settings
require_once "../lang/" . $_SESSION['lang'] . ".php"; // get language array
// If a project is selected
if ($_SESSION['project'] != "" && $_SESSION['project'] != 0 && $_SESSION['project'] != "all") {

    // get relevant order stages for project
    $queryStages = "SELECT projectSalesStages FROM " . $projects . " WHERE projectID=:projectID";

    try {
        $stmt = $pdo->prepare($queryStages);
        $stmt->bindParam(':projectID', $_SESSION['project']);
        $stmt->execute();
        $resultStages = $stmt->fetch(PDO::FETCH_ASSOC);
        $RowStages = $resultStages['projectSalesStages'];
    } catch (PDOException $e) {
        echo "1 -Data was not fetched, because: " . $e->getMessage();
    }
    $stageStr = "=" . str_replace(",", " OR orderStatusID=", $RowStages['projectOrderStages']) . "";
    $querys = "SELECT * FROM " . $orderstatus . " WHERE orderStatusID " . $stageStr . " ORDER by orderStatusID";
} else {
    // If a project is not selected
    // get all registered order stages	
    $querys = "SELECT * FROM " . $orderstatus . " ORDER by orderStatusID";
}

try {
    $Results = $pdo->query($querys);
} catch (PDOException $e) {
    echo "2. Data was not fetched, because: " . $e->getMessage();
}

foreach ($Results as $Rows) {

// Loop through order stages	

    if ($_SESSION['project'] != "" && $_SESSION['project'] != 0 && $_SESSION['project'] != "all") {

        // Get number of orders per order stage and project
        $queryn = "SELECT count(orderID) as number  
		FROM " . $orders . " 
		WHERE orderStatusID=" . $Rows['orderStatusID'] . " 
		AND " . $orders . ".productID IN (SELECT productID from " . $products . " WHERE productProjectID=" . $_SESSION['project'] . ")";
    } else {

        // Get number of orders per order stage
        $queryn = "SELECT count(orderID) as number from " . $orders . " WHERE orderStatusID=" . $Rows['orderStatusID'];
    }

    try {
        $stmt = $pdo->prepare($queryn);
        $stmt->execute();
        $RowOrders = $stmt->fetch(PDO::FETCH_ASSOC);
        $number = $RowOrders['number'];
    } catch (PDOException $e) {
        echo "3 - Data was not fetched, because: " . $e->getMessage();
    }
// Print out order stages with link to dsplaying orders in that stage - and total orders registered in that stage in pernthesis
    echo'&nbsp;<a href="show_orders.php?status=' . $Rows['orderStatusID'] . '"><img src="images/folder_blue_22.png" style="border:0px;vertical-align:middle;" alt="" /></a>&nbsp;<a href="show_orders.php?status=' . $Rows['orderStatusID'] . '">' . $Rows['orderStatusName'] . '</a> <span style="color:#777777">(' . $number . ')</span><br>';
}
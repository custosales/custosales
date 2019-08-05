<?php

require_once "modules/system/db.php";
require_once "lang/".$_SESSION['lang'].".php";

$querys = "SELECT * FROM ".$orderstatus." ORDER by orderStatusID";
try {
    $results = $pdo->query($querys);
} catch (PDOException $e) {
    echo "Data was not fetched, because: ".$e->getMessage();
}

foreach($results as $Rows) {


$queryn = "SELECT count(orderID) as number from ".$orders." WHERE orderStatusID=:orderStatus";

try {
    $stmt = $pdo->prepare($queryStages);
    $stmt->bindParam(':orderStatus', $Rows['orderStatusID']);
    $stmt->execute();
    $RowOrders = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Data was not fetched, because: ".$e->getMessage();
}


$number = $RowOrders['number']; 
         
echo'&nbsp;<a href="show_orders.php?status='.$Rows['orderStatusID'].'"><img src="images/folder_blue_22.png" style="border:0px;vertical-align:middle;" alt="" /></a>&nbsp;<a href="show_orders.php?status='.$Rows['orderStatusID'].'">'.$Rows['orderStatusName'].'</a> <span style="color:#777777">('.$number.')</span><br>';

}
?>

<?php
session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/" . $_SESSION['lang'] . ".php";

$formAction = $_GET['formAction'];
$orderID = $_POST['orderID'];
$regNumber = $_POST['regNumber'];
$productID = $_POST['productID'];
$unitPrice = $_POST['unitPrice'];
$orderDate = $_POST['orderDate'];
$customerContact = $_POST['customerContact'];
$creditDays = $_POST['creditDays'];
$otherTerms = $_POST['otherTerms'];
$orderComments = $_POST['comments'];

if ($_POST['orderStatusID'] != "") {
    $orderStatusID = $_POST['orderStatusID'];
} else {
    $orderStatusID = $_SESSION['projectFirstOrderStage'];
}

if ($formAction == "Insert") {
    $queryType = "INSERT INTO";
    $queryEnd = "";
} elseif ($formAction == "Update") {
    $queryType = "UPDATE";
    $queryEnd = "WHERE orderID=" . $orderID . "";
}

$query = $queryType . " " . $orders . " SET 
regNumber=:regNumber, 
productID=:productID,
orderStatusID=:orderStatusID,
salesRepID=:salesRepID,
unitPrice=:unitPrice,
orderDate=:orderDate,
customerContact=:customerContact,
creditDays=:creditDays,
otherTerms=:otherTerms,
orderComments=:orderComments,
regDate=NOW() " . $queryEnd . ";";


try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':regNumber', $regNumber);
    $stmt->bindParam(':productID', $productID);
    $stmt->bindParam(':orderStatusID', $orderStatusID);
    $stmt->bindParam(':salesRepID', $_SESSION['userID']);
    $stmt->bindParam(':unitPrice', $unitPrice);
    $stmt->bindParam(':orderDate', $orderDate);
    $stmt->bindParam(':customerContact', $customerContact);
    $stmt->bindParam(':creditDays', $creditDays);
    $stmt->bindParam(':otherTerms', $otherTerms);
    $stmt->bindParam(':orderComments', $orderComments);
    $stmt->execute();

    $orderID = $stmt->lastInsertId();  //get OrderID 
} catch (PDOException $e) {
    echo "Order was not saved, because: " . $e->getMessage();
}

if ($formAction == "Insert") {   // new sales registered, now get orderID and change companyStatus    	
    $querycs = "UPDATE " . $companies . " SET companyStatus='customer' WHERE regNumber=:regNumber";
    try {
        $stmt = $pdo->prepare($querycs);
        $stmt->bindParam(':regNumber', $regNumber);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Company Status was not changed, because: " . $e->getMessage();
    }
    ?>				
    <script type="text/javascript" >
        document.location = "../sales/register_sale.php?orderID=<?php print $orderID; ?>&productID=<?php print $productID; ?>"
    </script>				
    <?php
}
?>

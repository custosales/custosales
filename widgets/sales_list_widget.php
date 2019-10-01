<?php
session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../index.php");
}
require_once "../modules/system/db.php";
require_once "../lang/" . $_SESSION['lang'] . ".php";

$projectID = $_SESSION['project'];

if ($projectID == "" || $projectID == "all" || $projectID == 0) { // get all salesstages 
    $projectIncstr = "WHERE salesStageID=companyStatus ";
    $customerIncstr = "WHERE " . $companies . ".regNumber = " . $orders . ".regNumber";
} else { // get sales stages for project
    $customerIncstr = "WHERE " . $companies . ".regNumber = " . $orders . ".regNumber AND " . $companies . ".projectID = " . $projectID . "";

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

    $projectIncstr = "WHERE salesStageID=companyStatus && (salesStageID=" . str_replace(",", " OR salesStageID=", $RowStages) . ") AND projectID = " . $projectID . " ";
}


if (isset($_SESSION['admin'])) {  // Check for admin rights

    // Get number of not customers, by sales stage
    $resultQuery = "SELECT count(ID) as number , companyStatus, salesStageIcon as icon, salesStageName as name 
	FROM " . $salesstages . ", " . $companies . "  
	" . $projectIncstr . " 
	AND regNumber not in (SELECT regNumber FROM " . $orders . ") 
	GROUP BY companyStatus";

    try {
        $ResultC = $pdo->query($resultQuery);
    } catch (PDOException $e) {
        echo "4 - Data was not fetched, because: " . $e->getMessage() . $resultQuery;
    }


    // Get number of customers 
    $custQuery = "SELECT count(DISTINCT " . $orders . ".regNumber ) as customers FROM " . $orders . ", " . $companies . " " . $customerIncstr;

    try {
        $stmt = $pdo->prepare($custQuery);
        $stmt->execute();
        $RowCust = $stmt->fetch(PDO::FETCH_ASSOC);
        $customerNumber = $RowCust['customers'];
    } catch (PDOException $e) {
        echo "2 - Data was not fetched, because: " . $e->getMessage();
    }
} else if (isset($_SESSION['supervisor'])) {

    // Check for Supervisor rights and select sales from subordinates and self
    $sales_title = $LANG['sales_per_salesrep'];

    if ($projectID != "all" || $projectID =="") {
        $projectString = "AND projectID = " . $projectID;
    } else {
        $projectString ="";
    }


    // Get number of not customers, by sales stage 
    $resultQuery = "SELECT count(ID) as number, companyStatus, salesStageIcon as icon, salesStageName as name 
	FROM " . $salesstages . ", " . $companies . " 
	WHERE salesStageID=companyStatus 
	AND (salesRepID=" . $_SESSION['userID'] . " 
	OR salesRepID IN (SELECT userID FROM " . $users . " WHERE supervisorID=" . $_SESSION['userID'] . ") ) 
    " . $projectString . "
	AND regNumber not in (SELECT regNumber FROM " . $orders . ")	
	Group by companyStatus";

    try {
        $ResultC = $pdo->query($resultQuery);
    } catch (PDOException $e) {
        echo "4 - Data was not fetched, because: " . $e->getMessage() . $resultQuery;
    }

} else if (isset($_SESSION['salesModule'])) {

    // Get User's sales
    $sales_title = $LANG['my_sales'];
    
    if ($projectID != "all" && $projectID !="") {
        $projectString = "AND " . $companies . ".projectID =".$projectID ;
    } else {
        $projectString ="";
    }

    
    // Get number of not customers	
    $resultQuery = "SELECT count(ID) as number , companyStatus, salesStageIcon as icon, salesStageName as name 
	FROM " . $salesstages . ", " . $companies . "  
    " . $projectIncstr . " 	
    " . $projectString . " 	
    AND regNumber not in (SELECT regNumber FROM " . $orders . ")  
	AND salesRepID=" . $_SESSION['userID'] . " 
	GROUP BY companyStatus";

    try {
        $ResultC = $pdo->query($resultQuery);
    } catch (PDOException $e) {
        echo "5 - Data was not fetched, because: " . $e->getMessage() . $resultQuery;
    }

    // Get number of customers for selected project or all projects 
    $queryOrders = "SELECT count(DISTINCT ".$orders.".regNumber) as number FROM " . $orders . " 
    INNER JOIN ".$companies." ON ".$orders.".regNumber = ".$companies.".regNumber 
    WHERE ".$orders.".salesRepID=:userID " . $projectString;
    try {
        $stmt = $pdo->prepare($queryOrders);
        $stmt->bindParam(':userID', $_SESSION['userID']);
        $stmt->execute();
        $RowOrders = $stmt->fetch(PDO::FETCH_ASSOC);
        $customerNumber = $RowOrders['number'];
    } catch (PDOException $e) {
        echo "Number of Customers was not fetched, because: " . $e->getMessage();
    }
} // End roles and modules sales 
// end sales
?>
<div id="salesListWidgetArea">
    <table class="main_table" style="border:0px;">
        <tr>
            <td valign="top" width="180">
                <?php
                foreach ($ResultC as $Row) {    // List numbers of companies that are not customers, per sales stage
                    ?>
                    <a href="show_companies.php?status=<?php print $Row['companyStatus']; ?>"><img src="images/sales_icons/<?php print str_replace('32', '22', $Row['icon']); ?>" style="border:0px;vertical-align:middle;" alt="" /></a> <a href="show_companies.php?status=<?php print $Row['companyStatus']; ?>"><?php print $Row['name']; ?></a>
                    <span style="color:#777777">(<?php print $Row['number']; ?>)</span>
                    <br>
                <?php
                } // end list numbers of companies that are not customers
                
                // List number of customers  
                ?>
                <a href="show_companies.php?status=<?php print $LANG['customer']; ?>"><img src="images/folder_yellow_22.png" style="border:0px;vertical-align:middle;" alt="" /></a> <a href="show_companies.php?status=<?php print $LANG['customer']; ?>"><?php print $LANG['customers']; ?></a>
                <span style="color:#777777">(<?php print $customerNumber;?>)</span>
                <br>
                <a href="show_callinglists.php"><img src="images/folder_blue_22.png" style="border:0px;vertical-align:middle;" alt="" /></a> <a href="show_callinglists.php"><?php print $LANG['calling_lists']; ?></a>
            </td>
        </tr>
    </table>
</div>
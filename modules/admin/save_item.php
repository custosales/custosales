<?php

session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/" . $_SESSION['lang'] . ".php";

$itemType = $_GET['itemType'];
$action = $_GET['action'];
$itemID = $_GET['itemID'];
$values = str_replace('false', '0', $_GET['values']);
$values = str_replace('true', '1', $values);
$values = str_replace("\\", "", $values);


//print $values;
$valueArray = explode("|", $values);

$values = str_replace('|', ',', $values);


// Get Field Names
$query = "SHOW FIELDS FROM `" . $itemType . "`";

try {
    $result = $pdo->query($query);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

$a = 0;

foreach ($result as $Fields) {

    if ($a == 0) {
        $IDField = $Fields[0];
    } else {
        $fieldStr = $fieldStr . $Fields[0] . ","; // for adding new

        if ($Fields[0] == "pwd") {  // check for password field
            if ($valueArray[$a - 1] != "\"\"") {
                $updateStr = $updateStr . $Fields[0] . "=\"" . md5(str_replace("\"", "", $valueArray[$a - 1])) . "\",";  // md5 password for updating	
            } 
        } else {
            $updateStr = $updateStr . $Fields[0] . "=" . $valueArray[$a - 1] . ",";  // for updating all other fields	
        }
    }
    $a++;
}

$fieldStr = substr($fieldStr, 0, strlen($fieldStr) - 1);
$updateStr = substr($updateStr, 0, strlen($updateStr) - 1);


// Insert new record
if ($action == "save" && $itemID == "") {
    $queryStart = "INSERT INTO `" . $itemType . "` SET " . $updateStr . " ";
    $queryEnd = "";
}


// Update record
if ($action == "save" && $itemID != "") {
    $queryStart = "UPDATE `" . $itemType . "` SET " . $updateStr . " ";
    $queryEnd = "WHERE " . $IDField . "=" . $itemID;
}

// Delete record
if ($action == "delete" && $itemID != "") {
    $queryStart = "DELETE FROM `" . $itemType . "` ";
    $queryEnd = "WHERE " . $IDField . "=" . $itemID;
}


$query = $queryStart . $queryEnd;

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    print $LANG['data_saved'];
} catch (PDOException $e) {
    echo "3 - Data was not saved, because: " . $e->getMessage();
}

if ($itemType == "Users") { // Create User Document Directories if needed 
    if ($itemID == "") {
        $userID = $stmt->lastInsertId();
    } else {
        $userID = $itemID;
    }

    $userDir = "../../documents/users/" . $userID;
// Check if directories exist
    if (!is_dir($userDir)) {  // create User Document Directory if not present
        if (mkdir($userDir, 0777) && mkdir($userDir . "/thumbnails", 0777) && mkdir($userDir . "/jsonfeed", 0777) && mkdir($userDir . "/userphoto", 0777) && mkdir($userDir . "/userphoto/thumbnails", 0777) && copy("../../lib/dashboard/jsonfeed/startupwidgets.json", $userDir . "/jsonfeed/mywidgets.json")) {
            echo "... " . $LANG['user_directories_created'];
        } else {
            echo "Failed to create user directories...";
        }
    }
} // End Create User Document Directories   	
?>
<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}
?>
<head>
<script src="../../lib/jquery/jquery.js" type="text/javascript"></script>
<script src="../../lib/jquery.dd.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../../css/dd.css" />
</head>
<?php
require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$itemType =  $_GET['itemType'];
$action = $_GET['action'];
$itemID = $_GET['itemID'];

// Get Field Names
$query = "SHOW FIELDS FROM `".$itemType."`";

try {
    $result = $pdo->query($query);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

if($action!="add") {
// Determine ID Field Name
foreach ($result as $Fields) {
  $IDField = $Fields[0];
break;
}
}

// Delete Item
if($action =="delete") {
$queryd = "DELETE FROM `".$itemType."` WHERE ".$IDField."=".$itemID;

try {
        $stmt = $pdo->prepare($queryd);
        $stmt->execute();
        print $LANG['data_deleted'];	
    } catch (PDOException $e) {
        echo "2 - Data was not deleted, because: " . $e->getMessage();
    }
    

} // end delete

if($action=="edit" || $action =="add" ) { 

// Edit or Add Item  

if($action=="edit") { 

// Get Data

    $queryd = "SELECT * FROM `".$itemType."` WHERE ".$IDField."=".$itemID;
try {
        $stmt = $pdo->prepare($queryd);
        $stmt->execute();
        $Rowd = $stmt->fetch();
    } catch (PDOException $e) {
        echo "2 - Data was not fetced, because: " . $e->getMessage();
    }
    
}   
?>

<center>
    
<body style="font-size:13px">

<table style="float:left;margin-left:5px;font-size:13px">
<tr>
<th> </th>
<form name="itemForm" id="itemForm">
</tr>
<?php
if($action == "add") {
$i=0;
} else {
$i=1;	
}

foreach ($result as $Row) { 

if($i>0) {	

?>
<tr>
<td><?php 
if($itemType=="Roles" && $itemID==1  && strstr($Row[1], "tinyint")) {  
	// don't display labels for check boxes if listing Admin role
	// do nothing
	} else { // display labels 
print $LANG[$Row[0]].": ";
}
?> </td>
<td>
<?php 
if(strstr($Row[1], "tinyint") ) {  
// display checkbox if field type is tinyint/boolean

	if($itemType=="Roles" && $itemID==1 ) {  
	// don't display checkboxes if listing Admin role
	// do nothing
	} else { // display 
	
		if($Rowd[$i]==1) {
			$checked = "checked";
		} else {
			$checked = "";
		}	
?>
<input type="checkbox" value="1" id="<?php print "value".$i;?>" <?php print $checked; ?> ></input>
<?php 
	} // end if not admin role
} // end boolean


else if(strstr($Row[1], "date") ) {  
// display date picker if field type is date
?>
<input type="text" style="font-size:13px" id="<?php print "value".$i;?>" value="<?php print $Rowd[$i];?>" > </input>
<?php 
} // end date


else if(strstr($Row[1], "text") ) {  
// display text area if field type is text
?>
<textarea style="width:250px;height:100px;font-size:13px;font-family:arial" name="<?php print $Row[0];?>" id="<?php print "value".$i;?>">
<?php print $Rowd[$i];?>
</textarea>

<?php // List currencies
} else if(strstr($Row[0], "currencyID") ) {   
$querycu = "SELECT * FROM ".$currencies;

try {
    $resultcu = $pdo->query($querycu);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
} 
    ?>
<select name="currencyID" id="<?php print "value".$i;?>">
<?php 
foreach ($resultcu as $Rowcu) {
?>
<option value="<?php print $Rowcu['currencyID'];?>"><?php print utf8_decode($Rowcu['currencySymbol']);?></option>
<?php 
} // end Rowcu loop
?>
</select>

<?php // List currencies for Company
} else if(strstr($Row[0], "companyCurrency") ) {   

    $querycu = "SELECT * FROM ".$currencies;

    try {
    $resultcu = $pdo->query($querycu);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
} 
?>
<select name="currency" id="<?php print "value".$i;?>">
<?php 

foreach ($resultcu as $Rowcu) {

    ?>
<option value="<?php print $Rowcu['currencyID'];?>"><?php print utf8_decode($Rowcu['currencySymbol'])?></option>
<?php 
} // end Rowcu loop
?>
</select>



<?php // List Sales Stage Icons
 
} else if(strstr($Row[0], "salesStageIcon") ) {   
?>
<select name="salesStageIcon" id="<?php print "value".$i;?>" onchange="document.getElementById('iconImage').src='images/sales_icons/'+this.value">
<?php 
$iconFolder = "../../images/sales_icons/";
if (is_dir($iconFolder)) {
    if ($dh = opendir($iconFolder)) {

       while (($file = readdir($dh)) !== false) {
   
	if($file!="." && $file!=".." && strstr($file, '32') ) { // get rid of dot files and show only 32 px size icons
	               
	if( strstr($Rowd['salesStageIcon'], $file) ) {
	$selected = "selected";
	} else {
	$selected = "";	
	}	
?>
<option value="<?php print $file;?>" <?php print $selected;?> " ><?php print substr($file,0,strpos($file, '3')-1);?></option>
<?php
	} // end get rid of dots
 	} // end folder listing loop
     closedir($dh);
   // } // end if open_dir  
    } // end if is_dir
} // end if salesStageIcon 
?>
</select>
<img id="iconImage" src="images/sales_icons/<?php print $Rowd['salesStageIcon']; ?>" style="vertical-align:middle;">

<?php // List Sales Stages 
} else if(strstr($Row[0], "projectSalesStages") ) {   
$queryss = "SELECT * FROM ".$salesstages;
try {
    $resultss = $pdo->query($queryss);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
 
?>
<select name="projectSalesStages" multiple="true" id="<?php print "value".$i;?>" size="<?php print mysqli_num_rows($Resultss); ?>">
<?php 
foreach ($resultss as $Rowss) {

if(!strstr($Rowd['projectSalesStages'], ",")) {
		$Stages = $Rowd['projectSalesStages'];
	} else {
		$Stages = explode(",",$Rowd['projectSalesStages']);
		for ($st = 0; $st < count($Stages); $st++) {
			if($Stages[$st]==$Rowss['salesStageID']) {
				$selected = "selected";
			}	
		}
	}	

?>
<option value="<?php print $Rowss['salesStageID'];?>" <?php print $selected;?> ><?php print $Rowss['salesStageName'];?></option>
<?php 
$selected = "";	
} // end Rowss loop
?>
</select>


<?php // List First Sales Stage 
} else if(strstr($Row[0], "projectFirstSalesStage") ) {   
$queryss = "SELECT * FROM ".$salesstages;

try {
    $resultss = $pdo->query($queryss);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

    ?>
<select name="projectFirstSalesStage" id="<?php print "value".$i;?>">
<?php 
foreach($resultss as $Rowss) {

if($Rowd['projectFirstSalesStage']==$Rowss['salesStageID']) {
				$selected = "selected";
			}	
	
?>
<option value="<?php print $Rowss['salesStageID'];?>" <?php print $selected;?> ><?php print $Rowss['salesStageName'];?></option>
<?php 
$selected = "";	
} // end Rowss loop
?>
</select>


<?php // List Order Stages 
} else if(strstr($Row[0], "projectOrderStages") ) {   
    
$queryos = "SELECT * FROM ".$orderstatus;

try {
    $resultos = $pdo->query($queryos);
    $count = $resultos->rowCount();
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

    ?>
<select name="projectOrderStages" multiple="true" id="<?php print "value".$i;?>" size="<?php print $count; ?>">
<?php 
foreach($resultos as $Rowos) {

	if(!strstr($Rowd['projectOrderStages'], ",")) {
		$Stages = $Rowd['projectOrderStages'];
	} else {
		$Stages = explode(",",$Rowd['projectOrderStages']);
		for ($st = 0; $st < count($Stages); $st++) {
			if($Stages[$st]==$Rowos['orderStatusID']) {
				$selected = "selected";
			}	
		}
	}	
?>
<option value="<?php print $Rowos['orderStatusID'];?>" <?php print $selected;?> ><?php print $Rowos['orderStatusName'];?></option>
<?php
$selected = ""; 
} // end Rowcu loop
?>
</select>

<?php // List First Order Stage 
} else if(strstr($Row[0], "projectFirstOrderStage") ) {   
$queryos = "SELECT * FROM ".$orderstatus;

try {
    $resultos = $pdo->query($queryos);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

    ?>
<select name="projectFirstOrderStage" id="<?php print "value".$i;?>">
<?php
foreach($resultos as $Rowos) {

if($Rowd['projectFirstOrderStage']==$Rowos['orderStatusID']) {
				$selected = "selected";
			}	
?>
<option value="<?php print $Rowos['orderStatusID'];?>" <?php print $selected;?> ><?php print $Rowos['orderStatusName'];?></option>
<?php
$selected = ""; 
} // end Rowcu loop
?>
</select>


<?php // List Projects for Companies 
} else if(strstr($Row[0], "projectID") ) {   

    $queryos = "SELECT projectID, projectName FROM ".$projects;
try {
    $resultos = $pdo->query($queryos);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="projectID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['select_project']; ?></option>
<?php 
foreach ($resultos as $$Rowos) {

if( strstr($Rowd['projectID'], $Rowos['projectID']) ) {
	$selected = "selected";
	} else {
	$selected = "";	
		}	
?>
<option value="<?php print $Rowos['projectID'];?>" <?php print $selected;?> ><?php print $Rowos['projectName'];?></option>
<?php 
} // end Rowos loop
?>
</select>

<?php // List Projects for CallingLists 
} else if(strstr($Row[0], "callingListProjectID") ) {   
$queryos = "SELECT projectID, projectName FROM ".$projects;

try {
    $resultos = $pdo->query($queryos);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

    ?>
<select name="callingListProjectID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['select_project']; ?></option>
<?php 
    foreach ($resultos as $key => $Rowos) {

if( strstr($Rowd['callingListProjectID'], $Rowos['projectID']) ) {
	$selected = "selected";
	} else {
	$selected = "";	
		}	
?>
<option value="<?php print $Rowos['projectID'];?>" <?php print $selected;?> ><?php print $Rowos['projectName'];?></option>
<?php 
} // end Rowcu loop
?>
</select>

<?php // List Projects for Roles 
} else if(strstr($Row[0], "roleProjectID") ) {   
$queryos = "SELECT projectID, projectName FROM ".$projects;

try {
    $resultos = $pdo->query($queryos);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

    ?>
<select name="roleProjectID" id="<?php print "value".$i;?>">
<?php 
    foreach ($resultos as $Rowos) {

if( strstr($Rowd['roleProjectID'], $Rowos['projectID']) ) {
	$selected = "selected";
	} else {
	$selected = "";	
		}	
?>
<option value="<?php print $Rowos['projectID'];?>" <?php print $selected;?> ><?php print $Rowos['projectName'];?></option>
<?php 
} // end Rowcu loop
?>
</select>

<?php // List Product Categories for Products 
} else if(strstr($Row[0], "productCategoryID") ) {   

$queryos = "SELECT productCategoryID, productCategoryName FROM ".$productcategories;
try {
    $resultos = $pdo->query($queryos);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="productCategoryID" id="<?php print "value".$i;?>">
<?php 
foreach($resultos as $Rowos) {

if( strstr($Rowd['productCategoryID'], $Rowos['productCategoryID']) ) {
	$selected = "selected";
	} else {
	$selected = "";	
		}	
?>
<option value="<?php print $Rowos['productCategoryID'];?>" <?php print $selected;?> ><?php print $Rowos['productCategoryName'];?></option>
<?php 
} // end Rowcu loop
?>
</select>

<?php // List Product Super Categories  
} else if(strstr($Row[0], "productCategorySuperID") ) {   
	if($action=="edit") { 
	// don't list own category as possible super category
	$queryos = "SELECT productCategoryID, productCategoryName FROM ".$productcategories." WHERE productCategoryID != ".$Rowd['productCategoryID'];
	} else {
	$queryos = "SELECT productCategoryID, productCategoryName FROM ".$productcategories;
	}	

try {
    $resultos = $pdo->query($queryos);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="productCategorySuperID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['none']; ?></option>
<?php 
foreach($resultos as $Rowos) {

if( strstr($Rowd['productCategorySuperID'], $Rowos['productCategoryID']) ) {
	$selected = "selected";
	} else {
	$selected = "";	
		}	
?>
<option value="<?php print $Rowos['productCategoryID'];?>" <?php print $selected;?> ><?php print $Rowos['productCategoryName'];?></option>
<?php 
} // end Rowcu loop
?>
</select>

<?php // List Projects for Products 
} else if(strstr($Row[0], "productProjectID") ) {   
$queryos = "SELECT projectID, projectName FROM ".$projects;
try {
    $resultos = $pdo->query($queryos);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="productProjectID" id="<?php print "value".$i;?>">
<?php 
foreach($resultos as $Rowos) {

if( strstr($Rowd['productProjectID'], $Rowos['projectID']) ) {
	$selected = "selected";
	} else {
	$selected = "";	
		}	
?>
<option value="<?php print $Rowos['projectID'];?>" <?php print $selected;?> ><?php print $Rowos['projectName'];?></option>
<?php 
} // end Rowcu loop
?>
</select>

<?php // List Contact Types 
} else if(strstr($Row[0], "contactType") && $itemType!="ContactTypes" ) {   
$queryos = "SELECT * FROM ".$contacttypes;
try {
    $resultos = $pdo->query($queryos);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="contactType" id="<?php print "value".$i;?>">
<?php 
foreach($resultos as $Rowos) {

if( strstr($Rowd['contactType'], $Rowos['contactTypeID']) ) {
	$selected = "selected";
	} else {
	$selected = "";	
		}	
?>
<option value="<?php print $Rowos['contactTypeID'];?>" <?php print $selected;?> ><?php print $Rowos['contactTypeName'];?></option>
<?php 
} // end Rowcu loop
?>
</select>

<?php // List Project Owners
} else if(strstr($Row[0], "projectOwnerID") ) {
$queryu = "SELECT userID, fullName FROM ".$users;
try {
    $resultu = $pdo->query($queryu);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

?>
<select name="projectOwnerID" id="<?php print "value".$i;?>">
<?php 
foreach($resultu as $Rowu) {
if($Rowu['userID']==$Rowd['projectOwnerID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}

?>
<option value="<?php print $Rowu['userID'];?>" <?php print $selected;?> ><?php print $Rowu['fullName'];?></option>
<?php 
} // end Rowu loop
?>
</select>


<?php // List Product Owners
} else if(strstr($Row[0], "productOwnerID") ) {
$queryu = "SELECT userID, fullName FROM ".$users;

try {
    $resultu = $pdo->query($queryu);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="productOwnerID" id="<?php print "value".$i;?>">
<?php 
foreach($resultu as $Rowu) {

    if($Rowu['userID']==$Rowd['productOwnerID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}

?>
<option value="<?php print $Rowu['userID'];?>" <?php print $selected;?> ><?php print $Rowu['fullName'];?></option>
<?php 
} // end Rowu loop
?>
</select>


<?php // List Product Category Owners
} else if(strstr($Row[0], "productCategoryOwnerID") ) {
$queryu = "SELECT userID, fullName FROM ".$users;

try {
    $resultu = $pdo->query($queryu);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="productCategoryOwnerID" id="<?php print "value".$i;?>">
<?php 
foreach($resultu as $Rowu) {
    
if($Rowu['userID']==$Rowd['productCategoryOwnerID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}

?>
<option value="<?php print $Rowu['userID'];?>" <?php print $selected;?> ><?php print $Rowu['fullName'];?></option>
<?php 
} // end Rowu loop
?>
</select>


<?php // List Calling List Owners
} else if(strstr($Row[0], "callingListOwnerID") ) {
$queryu = "SELECT userID, fullName FROM ".$users;

try {
    $resultu = $pdo->query($queryu);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="callingListOwnerID" id="<?php print "value".$i;?>">
<?php 
foreach($resultu as $Rowu) {
if($Rowu['userID']==$Rowd['callingListOwnerID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}

?>
<option value="<?php print $Rowu['userID'];?>" <?php print $selected;?> ><?php print $Rowu['fullName'];?></option>
<?php 
} // end Rowu loop
?>
</select>


<?php // List users to be selected as salesreps
} else if(strstr($Row[0], "salesRepID") ) { 
$querysu = "SELECT userID, fullName FROM ".$users;

try {
    $resultsu = $pdo->query($querysu);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="salesRepID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['nobody'];?></option>
<?php 
foreach($resultsu as $Rowsu) {
if($Rowsu['userID']==$Rowd['salesRepID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
?>

<option value="<?php print $Rowsu['userID'];?>"  <?php print $selected;?> ><?php print $Rowsu['fullName'];?></option>

<?php 
} // end Rowsu loop
?>
</select>

<?php // List users to be selected as supervisors
} else if(strstr($Row[0], "supervisorID") ) { 
$querysu = "SELECT userID, fullName FROM ".$users;

try {
    $resultsu = $pdo->query($querysu);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="supervisorID" id="<?php print "value".$i;?>">
<option value="0"><?php print $LANG['nobody'];?></option>
<?php 
foreach($resultsu as $Rowsu) {
if($Rowsu['userID']==$Rowd['supervisorID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
?>
<option value="<?php print $Rowsu['userID'];?>"  <?php print $selected;?> ><?php print $Rowsu['fullName'];?></option>
<?php 
} // end Rowsu loop
?>
</select>

<?php // List Companies for contacts
} else if(strstr($Row[0], "contactCompanyID") ) { 
$querysu = "SELECT regNumber, companyName FROM ".$companies." ORDER BY companyName";

try {
    $resultsu = $pdo->query($querysu);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

    ?>
<select name="contactCompanyID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['nobody'];?></option>
<?php 
foreach($resultsu as $Rowsu) {
if($Rowsu['regNumber']==$Rowd['contactCompanyID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
?>
<option value="<?php print $Rowsu['regNumber'];?>"  <?php print $selected;?> ><?php print $Rowsu['companyName'];?></option>
<?php 
} // end Rowsu loop
?>
</select>

<?php // List users to be selected as Link Owners
} else if(strstr($Row[0], "linkOwnerID") ) {  
$querysu = "SELECT userID, fullName FROM ".$users;

try {
    $resultsu = $pdo->query($querysu);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="linkOwnerID" id="<?php print "value".$i;?>">
<?php 
foreach($resultsu as $Rowsu) {

if($action=="add") {
	
	if($Rowsu['userID']==$_SESSION['userID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
	
	} else {

if($Rowsu['userID']==$Rowd['linkOwnerID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}

}
?>
<option value="<?php print $Rowsu['userID'];?>"  <?php print $selected;?> ><?php print $Rowsu['fullName'];?></option>
<?php 
} // end Rowsu loop
?>
</select>

<?php // List users to be selected as Department Managers
} else if(strstr($Row[0], "managerID") ) {  
$querysu = "SELECT userID, fullName FROM ".$users;
try {
    $resultsu = $pdo->query($querysu);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="managerID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['nobody'];?></option>
<?php 
foreach($resultsu as $Rowsu) {
if($Rowsu['userID']==$Rowd['managerID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
?>
<option value="<?php print $Rowsu['userID'];?>"  <?php print $selected;?> ><?php print $Rowsu['fullName'];?></option>
<?php 
} // end Rowsu loop
?>
</select>

<?php   // List contract Types
} else if(strstr($Row[0], "contractID") ) {
$querycon = "SELECT contractID, contractName FROM ".$contracts;

try {
    $resultcon = $pdo->query($querycon);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="contractID" id="<?php print "value".$i;?>">
<option value="0"><?php print $LANG['none'];?></option>
<?php 
foreach($resultcon as $Rowcon) {
if($Rowcon['contractID']==$Rowd['contractID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
?>
<option value="<?php print $Rowcon['contractID'];?>"  <?php print $selected;?> ><?php print $Rowcon['contractName'];?></option>
<?php 
} // end Rowcon loop
?>
</select>

<?php   // List Workplaces
} else if(strstr($Row[0], "workplaceID") ) {
$queryw = "SELECT workplaceID, workplaceName FROM ".$workplaces;

try {
    $resultw = $pdo->query($queryw);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="workplaceID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['none'];?></option>
<?php 
foreach($resultw as $Roww) {
if($Roww['workplaceID']==$Rowd['workplaceID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
?>
<option value="<?php print $Roww['workplaceID'];?>"  <?php print $selected;?> ><?php print $Roww['workplaceName'];?></option>
<?php 
} // end Roww loop
?>
</select>

<?php   // List Company Status
} else if(strstr($Row[0], "companyStatus") ) {
$querystat = "SELECT salesStageID, salesStageName FROM ".$salesstages;

try {
    $resultstat = $pdo->query($querystat);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="companyStatus" id="<?php print "value".$i;?>">
<?php 
foreach($resultstat as $Rowstat) {
if($Rowstat['salesStageID']==$Rowd['companyStatus']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
?>

<option value="<?php print $Rowstat['salesStageID'];?>"  <?php print $selected;?> ><?php print $Rowstat['salesStageName'];?></option>

<?php 
} // end Rowstat loop
?>
</select>

<?php   // List Departments
} else if(strstr($Row[0], "departmentID") ) {
$querydep = "SELECT departmentID, departmentName FROM ".$departments;
try {
    $resultdep = $pdo->query($querydep);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="departmentID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['none'];?></option>
<?php 
foreach($resultdep as $Rowdep) {
if($Rowdep['departmentID']==$Rowd['departmentID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
?>
<option value="<?php print $Rowdep['departmentID'];?>"  <?php print $selected;?> ><?php print $Rowdep['departmentName'];?></option>
<?php 
} // end Rowdep loop
?>
</select>

<?php   // List Super Departments
} else if(strstr($Row[0], "superDepartmentID") ) {
$querydep = "SELECT departmentID, departmentName FROM ".$departments;

try {
    $resultdep = $pdo->query($querydep);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select name="departmentID" id="<?php print "value".$i;?>">
<option value=""><?php print $LANG['none'];?></option>
<?php 
foreach($resultdep as $Rowdep) {
	
if($Rowdep['departmentID']==$Rowd['superDepartmentID']) {
	$selected = " selected ";
	} else {
	$selected = "";
	}
if($Rowdep['departmentID']!=$Rowd['departmentID']) { // don't list own department
?>
<option value="<?php print $Rowdep['departmentID'];?>"  <?php print $selected;?> ><?php print $Rowdep['departmentName'];?></option>
<?php 
} // end if
} // end Rowdep loop
?>
</select>

<?php // List Calling List connected to Role
} else if(strstr($Row[0], "roleCallingLists") ) {
$queryr = "SELECT * FROM ".$callinglists;
try {
    $resultr = $pdo->query($queryr);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<select style="width:250px;font-size:13px" name="roleCallingLists" id="<?php print "value".$i;?>" multiple="multiple" size="<?php print mysql_num_rows($Resultr); ?>">
<?php 
foreach($resultr as $Rowr) {
	
if(!strstr($Rowd['roleCallingLists'], ",")) {
					
			if($Rowd['roleCallingLists']==$Rowr['listID']) {
				$selected = "selected";
			}	
		
	} else {
		$Stages = explode(",",$Rowd['roleCallingLists']);
		for ($st = 0; $st < count($Stages); $st++) {
			if($Stages[$st]==$Rowr['listID']) {
				$selected = "selected";
			}	
		}
	}
?>
<option value="<?php print $Rowr['listID'];?>" <?php print $selected;?>  ><?php print $Rowr['callingListName'];?></option>
<?php 
$selected = "";	
} // end Rowr loop
?>
</select>

<?php 
}  else { // List all other fields as text inputs
if($Rowd[$i]!=$Rowd['pwd']) { // don't lists passwords
$fieldVal = $Rowd[$i];
} else {
$fieldVal = "";
}

if(strstr($Row[0], "userName") && $itemID=="") { 
	// Check if username Exists when registering new user
	$onBlur = "onblur=checkUsername(this.value,'value".$i."');";
} else {
	$onBlur = "";
}

?>
<?php if(strstr($Row[0], "documents") && $itemID!="") { // display document folder icon  ?>
<input type="hidden" id="<?php print "value".$i;?>">
<img src="images/folder_blue_32.png" title="<?php print $LANG['documents'];?>" onclick="showUserDocuments('<?php print $itemID;?>')" >
<?php } else { ?>
<input style="width:250px;font-size:13px" type="text" <?php print $onBlur;?>  <?php print $disabled;?>  name="<?php print $Row[0];?>" id="<?php print "value".$i;?>" value="<?php print $fieldVal;?>">
<?php
}

if(strstr($Row[0], "regNumber") && $itemID=="") { 
print "<img src=\"images/brreg.png\" style=\"vertical-align:middle\" onclick=\"getFromBrreg(document.getElementById('value1').value)\" >";
}	
 ?>
</td>
<?php 
}
} // end if edit
 ?>

</tr>
<?php
$i++;
 }
 ?>

<tr>
</form>
<td></td>
<td>

<?php 
if($itemType=="Products") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['productID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showProducts()" value="<?php print $LANG['cancel'];?>">
<?php 
}
 
if($itemType=="Users") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['userID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showUsers()" value="<?php print $LANG['cancel'];?>">
<?php 
}

if($itemType=="Companies") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['ID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showClients()" value="<?php print $LANG['cancel'];?>">
<?php 
}


if($itemType=="Roles") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['roleID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showRoles()" value="<?php print $LANG['cancel'];?>">
<?php 
}

if($itemType=="Contracts") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['contractID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showContracts()" value="<?php print $LANG['cancel'];?>">
<?php 
}

if($itemType=="Workplaces") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['workplaceID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showWorkplaces()" value="<?php print $LANG['cancel'];?>">
<?php 
}

if($itemType=="Departments") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['departmentID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showDepartments()" value="<?php print $LANG['cancel'];?>">
<?php 
}

if($itemType=="Links") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['linkID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showLinks()" value="<?php print $LANG['cancel'];?>">
<?php 
}


if($itemType=="OrderStatus") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['orderStatusID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showOrderStages()" value="<?php print $LANG['cancel'];?>">
<?php 
}

if($itemType=="SalesStages") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['salesStageID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showSalesStages()" value="<?php print $LANG['cancel'];?>">
<?php 
}


if($itemType=="ContactTypes") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['contactTypeID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showContactTypes()" value="<?php print $LANG['cancel'];?>">
<?php 
}

if($itemType=="Contacts") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['contactID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showContacts()" value="<?php print $LANG['cancel'];?>">
<?php 
}

if($itemType=="ProductCategories") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['productCategoryID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showProductCategories()" value="<?php print $LANG['cancel'];?>">
<?php 
}


if($itemType=="Projects") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['projectID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showProjects()" value="<?php print $LANG['cancel'];?>">
<?php 
}


if($itemType=="Currencies") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['currencyID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showCurrencies()" value="<?php print $LANG['cancel'];?>">
<?php 
}

if($itemType=="CallingLists") {
?>
<input type="button" style="width:100px;" onclick="saveItem('<?php print $itemType; ?>','save','<?php print $Rowd['listID']; ?>','<?php print $i; ?>')" value="<?php print $LANG['save'];?>">
&nbsp;
<input type="button" style="width:100px;" onclick="showCallinglists()" value="<?php print $LANG['cancel'];?>">
<?php 
}
?>


</td>

</tr>

</table>

<?php 
if($itemType=="Users" && $itemID!="") { // Show user photo if available and user roles
// Check if userphoto is present
$dir    = "../../documents/users/".$itemID."/userphoto/thumbnails/";
$files = scandir($dir);
$userPhoto = $files[2]; // select the first file after . and .. 
if(is_file($dir.$userPhoto)) {
?>
<table style="float:center" >
<tr><td style="text-align:center;font-weight:bold"><?php print $LANG['profile_image'];?></td></tr>
<tr><td>
<img src="documents/users/<?php print $itemID; ?>/userphoto/thumbnails/<?php print $userPhoto; ?>" alt="" style="border: solid 6px #CCCCCC;border-radius:7px" >
</td></tr>
</table>
<?php 
} // end if photo present

// List Roles

// Get roles
$queryr = "SELECT * FROM ".$roles;
try {
    $resultr = $pdo->query($queryr);
     $count = $resultr->rowCount();
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>

<table style="float:center" >
<tr><td style="text-align:center;font-weight:bold"><?php print $LANG['roles'];?></td></tr>
<tr><td>
<select style="width:150px;font-size:13px" name="roles" id="<?php print "value".$i;?>" multiple="multiple" size="<?php print $count; ?>">
<?php 



// Loop through roles
foreach($resultr as $Rowr) {

$selected = "";	

// Get ID of users roles
$roleQuery = "SELECT roleID from ".$user_role." WHERE userID = ".$itemID." AND to_date = '9999-01-01'";

try {
	$roleResult = $pdo->query($roleQuery);
} catch (PDOException $e) {
	echo "User roles were not fetched, because: " . $e->getMessage();
}
		foreach($roleResult as $userRole) {
			// echo "<option>".$userRole['roleID']."-".$Rowr['roleID']."</option>";
			if($userRole['roleID'] == $Rowr['roleID']) {
				$selected = "selected";
			}
		}
?>
<option value="<?php print $Rowr['roleID'];?>" <?php print $selected;?>  ><?php print $Rowr['roleName'];?></option>
<?php 
} // end Rowr loop
?>
</select>
</td></tr>
</table>

<?php 
} // end show user photo and roles
?>


<script type="text/javascript" >

</script>

</center>
<?php 
} // end if delete or edit/add
?>
</body>
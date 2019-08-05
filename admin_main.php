<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta charset="utf-8" />
<title></title>

</head>
<?php 
include_once "menu.php";
?>
<script class="code" type="text/javascript">
var already_customer = "<?php print $LANG['already_customer'];  ?>" 
var insert_regnumber = "<?php print $LANG['write_org_number'];  ?>" 

var addProduct = "<?php print $LANG['addProduct'];  ?>"
var editProduct = "<?php print $LANG['editProduct'];  ?>"

var addProductCategorie = "<?php print $LANG['add_product_category'];  ?>"
var editProductCategorie = "<?php print $LANG['edit_product_category'];  ?>"

var addUser = "<?php print $LANG['add_user'];  ?>"
var editUser = "<?php print $LANG['edit_user'];  ?>"

var addRole = "<?php print $LANG['add_role'];  ?>"
var editRole = "<?php print $LANG['edit_role'];  ?>"

var addCallingList = "<?php print $LANG['add_calling_list'];  ?>"
var editCallingList = "<?php print $LANG['edit_calling_list'];  ?>"

var addLink = "<?php print $LANG['add_link'];  ?>"
var editLink = "<?php print $LANG['edit_link'];  ?>"

var addCurrencie = "<?php print $LANG['add_currency'];  ?>"
var editCurrencie = "<?php print $LANG['edit_currency'];  ?>"

var addContract = "<?php print $LANG['add_contract'];  ?>"
var editContract = "<?php print $LANG['edit_contract'];  ?>"

var addSalesStage = "<?php print $LANG['add_sales_stage'];  ?>"
var editSalesStage = "<?php print $LANG['edit_sales_stage'];  ?>"

var addOrderStatu = "<?php print $LANG['add_order_status'];  ?>"
var editOrderStatu = "<?php print $LANG['edit_order_status'];  ?>"

var addWorkplace = "<?php print $LANG['add_workplace'];  ?>"
var editWorkplace = "<?php print $LANG['edit_workplace'];  ?>"

var addDepartment = "<?php print $LANG['add_department'];  ?>"
var editDepartment = "<?php print $LANG['edit_department'];  ?>"

var addProject = "<?php print $LANG['add_project'];  ?>"
var editProject = "<?php print $LANG['edit_project'];  ?>"

var addCompanie = "<?php print $LANG['add_client'];  ?>"
var editCompanie = "<?php print $LANG['edit_client'];  ?>"

var addContactType = "<?php print $LANG['add_contact_type'];  ?>"
var editContactType = "<?php print $LANG['edit_contact_type'];  ?>"

var addContact = "<?php print $LANG['add_contact'];  ?>"
var editContact = "<?php print $LANG['edit_contact'];  ?>"

var addLink = "<?php print $LANG['add_link'];  ?>"
var editLink = "<?php print $LANG['edit_link'];  ?>"

var dataSaved = "<?php print $LANG['data_saved'];  ?>"
</script> 
<script language="javascript" type="text/javascript" src="modules/admin/js/adminFunctions.js"></script> 

<body style="font-size:12px;">
<div id="main_table">
<h1 class="ui-widget-header ui-corner-all" style="padding:3px 3px 3px 10px;margin:0"><span id="heading"><?php print $LANG['administration']; ?></span></h1>

<?php 
if(isset($_SESSION['admin'])) {
?>
<div  style="float:left;width:180px;padding:4px">
<table style="width:100%;font-weight:normal;font-size:12px;margin-bottom:0px;padding;0px" class="ui-widget-content ui-corner-all">

<tr>
<td colspan="2" class="ui-widget-header ui-corner-all">
<h2 style="text-align:center;padding:0;margin:0"><?php print $LANG['content'] ?></h2></td>
</tr>

<tr>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showPreferences()" style="text-decoration:none">
<img src="images/admin_32.png" style="vertical-align:middle" alt="" ><br> 
<?php print $LANG['preferences'];?></a>
</td>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showProjects()" style="text-decoration:none">
<img src="images/projects_32.png" style="vertical-align:middle" alt="" ><br> 
<?php print $LANG['projects'];?></a>
</td>
</tr>

<tr>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showSalesStages()" style="text-decoration:none">
<img src="images/folder_green_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['sales_stages'];?></a>
</td>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showClients()" style="text-decoration:none">
<img src="images/clients_32.png" style="vertical-align:middle" alt="" ><br> 
<?php print $LANG['clients'];?></a>
</td>
</tr>


<tr>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showContactTypes()" style="text-decoration:none">
<img src="images/contact_types_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['contact_types'];?></a>
</td>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showContacts()" style="text-decoration:none">
<img src="images/contacts_32.png" style="vertical-align:middle" alt="" ><br> 
<?php print $LANG['contacts'];?></a>
</td>
</tr>

<tr>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showUsers()" style="text-decoration:none">
<img src="images/users_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['users'];?></a>
</td>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showRoles()" style="text-decoration:none">
<img src="images/roles_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['roles'];?></a>
</td>
</tr>

<tr>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showWorkplaces()" style="text-decoration:none">
<img src="images/home_32.png" style="vertical-align:middle" alt="" ><br> 
<?php print $LANG['workplaces'];?></a>
</td>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showDepartments()" style="text-decoration:none">
<img src="images/departments_32.png" style="vertical-align:middle" alt="" ><br> 
<?php print $LANG['departments'];?></a>
</td>
</tr>

<tr>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showCallingLists()" style="text-decoration:none">
<img src="images/call_start_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['calling_lists'];?></a>
</td>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showOrderStages()" style="text-decoration:none">
<img src="images/folder_lists_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['order_stages'];?></a>
</td>
</tr>

<tr>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showContracts()" style="text-decoration:none">
<img src="images/contracts_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['contracts'];?></a>
</td>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showCurrencies()" style="text-decoration:none">
<img src="images/currencies_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['currencies'];?></a>
</td>
</tr>

<tr>
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showProductCategories()" style="text-decoration:none">
<img src="images/product_categories_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['product_categories'];?></a>
</td> 
<td style="text-align:center;"> 
<a href="#" onclick="JavaScript:showProducts()" style="text-decoration:none">
<img src="images/products_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['products'];?></a>
</td>
</tr>

<tr>
<td style="text-align:center;"> 
<a href="#" onclick="JavaScript:showLinks()" style="text-decoration:none">
<img src="images/links_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['links'];?></a>
</td> 
<td style="text-align:center;">
<a href="#" onclick="JavaScript:showTemplates()" style="text-decoration:none">
<img src="images/folder_txt_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['templates'];?></a>
</td> 
</tr>



</table>		                
<?php 
} 
?>		

</div>

<div id="adminArea" style="width:100%;font-size:12px"></div>

</div>



<script type="text/javascript">


	$(function() {
		$( "#datepicker" ).datepicker();
	});


</script>
</body>
</html>


<?php
$server = "localhost";
$username = "custosales";
$password= "custo432a";
$DBName = "custosales";

try {

 $pdo = new PDO('mysql:host='.$server.';dbname='.$DBName.'',''.$username.'',''.$password.'');
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 $pdo->exec('SET NAMES "utf8"');

} catch (PDOException $e) {

   $output = "Noe gikk galt med tilkoblingen, fordi: ".$e->getMessage();
   //   include("../html/output.html.php");
   exit();
}

//Table Names

$orders = " `Orders`";
$accounts = " `Regnskap`";
$companies = " `Companies`";
$companystatus = " `CompanyStatus`";
$salesreps = " `SalesReps`";
$branchcodes = " `BranchCodes`";
$invoices = " `Invoices`";
$links = " `Links`";
$products = " `Products`";
$productcategories = " `ProductCategories`";
$orderstatus = " `OrderStatus`";
$salesstages = " `SalesStages`";
$contacts = " `Contacts`";
$contacttypes = " `ContactTypes`";
$branches = " `BranchCodes`";
$callinglists = " `CallingLists`";
$callinglistcompanies = " `CallingListCompanies`";
$users = " `Users`";
$preferences = " `Preferences`";
$departments = " `Departments`";
$templates = " `Templates`";
$currencies = " `Currencies`";
$roles = " `Roles`";
$projects = " `Projects`";
$contracts = " `Contracts`";
$workplaces = " `Workplaces`";
$modules = " `modules`";

?>

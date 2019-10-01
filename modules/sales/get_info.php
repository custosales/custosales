<?php
session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../../index.php");
}

include_once "../../lang/" . $_SESSION['lang'] . ".php";
include_once "../system/db.php";
$customer = "";
$orgn = $_GET['regnumber'];
$handle = fopen("http://w2.brreg.no/enhet/sok/detalj.jsp?orgnr=" . $orgn, "r");
if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle, 4096);
        $doc = $doc . $buffer;
    }
    fclose($handle);
}

$startpos = strpos($doc, '<table border="0" width="100%">');
$endpos = strpos($doc, '<td class="liste" colspan="3">', $startpos);
$length = $endpos - $startpos;
$infotable1 = substr($doc, $startpos, $length);
$infotable = str_replace("<br>", ", ", $infotable1);

//echo $infotable;

$dom = new domDocument;

/*** load the html into the object ***/
$dom->loadHTML($infotable);

/*** discard white space ***/
$dom->preserveWhiteSpace = false;

/*** the table by its tag name ***/
$tables = $dom->getElementsByTagName('table');

/*** get all rows from the table ***/
$rows = $tables->item(0)->getElementsByTagName('tr');

echo '<form name="regform" method="POST" action="modules/sales/save_customer.php">';
echo '<input type="hidden" name="companyStatus" value="lead">';
echo '<table class="ui-widget-content ui-corner-all" style="padding:5px;width:1000px;font-size:1.2em;">';
echo '<tr><th>Informasjon fra Br&oslash;nn&oslash;ysundregistrene</td><th>';
echo '<tr><td valign="top"><table align="left" style="padding:5px;font-size:1em;">';
/*** loop over the table rows ***/
$button_value = $LANG['create_lead'];
$i = 0;
foreach ($rows as $row) {
    /*** get each column by tag name ***/
    $cols = $row->getElementsByTagName('td');
    /*** echo the values ***/
    if ($i == 0) { // check if already customer
        $regnumber = str_replace(" ", "", $cols->item(1)->nodeValue);
        $regnumber = trim($regnumber);
        $query = "SELECT companyName, companyStatus, " . $companies . ".salesRepID, userID, fullName
	from " . $companies . " left Join " . $users . " on " . $companies . ".salesRepID=userID WHERE regNumber=" . $regnumber;

        try {
            $stmt = $pdo->prepare($query);
            //    $stmt->bindParam(':userID', $Row['salesRepID']);
            $stmt->execute();
            $Row = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Data was not fetched, because: " . $e->getMessage();
        }

        $customer = $Row['companyName'];
        if ($Row['companyStatus'] == "customer") {
            $button_value = $LANG['already_customer'];
        }
        if ($Row['companyStatus'] == "lead") {
            $button_value = $LANG['already_lead'] . "  (" . $Row['fullName'] . ")";
        }

        $button_status = " disabled ";
        $button_style = "color:red;";

    }

    if ($i == 10) {
        echo '</table><table style="padding:5px;font-size:1em;">';
    }

    if ($i < 17) {

        if (!strstr(trim(utf8_decode($cols->item(0)->nodeValue)), "Forretningsf")) { // omit "Forretningsfører"
            echo '<tr><td style="width:150px;">' . trim(utf8_decode($cols->item(0)->nodeValue)) . '</td>';
        } else {
            $forretningsforer = "yes";
        }

        if ($i == 1) {
            $companyName = trim(utf8_decode($cols->item(1)->nodeValue));
        }

        if ($i == 14 || $i == 15) {
            $value_full = trim($cols->item(1)->nodeValue);
            $pos = strpos($value_full, " ");
            $value = substr($value_full, 0, $pos);
            $value = utf8_decode($value);
            if ($i == 14) {
                $value = substr($value, 0, strlen($value) - 2);
            }

        } elseif ($i == 16) {
            $value_full = trim($cols->item(1)->nodeValue);
            $value = str_replace(",", "", $value_full);
            $value = str_replace(" ", "", $value);
        } else {
            $value = trim(utf8_decode($cols->item(1)->nodeValue));
        }

        if ($i == 8) {
            $companyPhone = trim(utf8_decode($cols->item(1)->nodeValue));

            if ($companyPhone == "-") {

            }

        }

        if ($forretningsforer != "yes") { // omit forrretningsfører data
            echo '<td><input type="text" name="' . $i . '" style="width:300px;font-size:0.9em;" value="' . $value . '"></td></tr>';
        } else {
            $forretningsforer = "";
        }
    }
    $i++;
}

echo '
<tr><td colspan="2" align="right">';

// echo '<input id="but1" style="'.$button_style.'" type="submit" value="'.$button_value.'" '.$button_status.'>';

echo '</td></tr>';

if ($customer != "") {
    echo '<tr><td colspan="2" align="right"><input type="button" onclick="getCustomer(' . $regnumber . ')" value="' . $LANG['show'] . ' ' . $customer . '"></td></tr>';
}
echo '</table>';
echo '</td></tr></table></form>';

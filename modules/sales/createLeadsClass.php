<?php

/**
 * Description of getInfoClass 
 * Getting info needed to create leads etc.
 * @author Terje Berg-Hansen
 */
session_start();

class Leads
{

	// Class variables        

	var $pdo = null;
	var $companies = null;
	var $callingListTable = null;
	var $regNumber = null;
	var $userID = null;
	var $projectFirstSalesStage = null;
	public $saved = null;
	public $unsaved = null;

	// Class Functions

	function createLead($regNumber)
	{


		// Get company data from CallingList
		$query = "SELECT * FROM " . $this->callingListTable . " WHERE Orgnr=" . $regNumber;

		try {
			$stmt = $this->pdo->prepare($query);
			$stmt->execute();
			$Row = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo "Calling List Data was not fetched, because: " . $e->getMessage();
		}

		$companyName = $Row['Firmanavn'];

		if ($Row['Selskapsform'] != "") {
			$companyType = $Row['Selskapsform'];
		}

		if ($Row['E-post'] != "") {
			$companyEmail = $Row['E-post'];
		}

		if ($Row['Telefon'] != "") {
			$companyPhone = $Row['Telefon'];
		}

		if ($Row['Mobil'] != "") {
			$companyMobilePhone = $Row['Mobil'];
		}

		if ($Row['Kontaktperson'] != "") {
			$companyManager = $Row['Kontaktperson'];
		}

		if ($Row['B.adresse'] != "") {
			$companyAddress = $Row['B.adresse'];
		}

		if ($Row['Address'] != "") {
			$companyAddress = $Row['Address'];
		}

		if ($Row['City'] != "") {
			$companyCity = $Row['City'];
		}

		if ($Row['Fylke'] != "") {
			$companyCounty = $Row['Fylke'];
		}

		if ($Row['B.poststed'] != "") {
			$companyCity = $Row['B.poststed'];
		}

		if ($Row['Zip'] != "") {
			$companyZipCode = $Row['Zip'];
		}

		if ($Row['B.postnr'] != "") {
			$companyZipCode = $Row['B.postnr'];
		}

		if ($Row['Bransjekode'] != "") {
			$branchCode = $Row['Bransjekode'];
		}

		if ($Row['Bransjekode'] != "") {
			$branchCode = $Row['Bransjekode'];
		}


		if ($Row['Bransjetekst'] != "") {
			$branchText = $Row['Bransjetekst'];
		}

		if ($Row['Bransjer'] != "") {
			$branchText = $Row['Bransjer'];
		}


		$companyInternet= "";
		$companyFax = "";
		$dateRegistered= null;
		$dateIncorporated=null;

		// store in Database
		$query = "INSERT INTO " . $this->companies . " SET 
				regNumber = '" . $this->regNumber . "',
				companyName = '" . $companyName . "',
				companyType = '" . $companyType . "',
				companyStatus = '" . $this->projectFirstSalesStage . "',
				companyEmail = '" . $companyEmail . "',
				companyInternet = '" . $companyInternet . "',
				companyPhone = '" . $companyPhone . "',
				companyMobilePhone = '" . $companyMobilePhone . "',
				companyFax = '" . $companyFax . "',
				companyAddress = '" . $companyAddress . "',
				companyZipCode = '" . $companyZipCode . "',
				companyCity = '" . $companyCity . "',
				companyCounty = '" . $companyCounty . "',
				companyManager = '" . $companyManager . "',
				branchCode = '" . $branchCode . "',
				branchText = '" . $branchText . "',
				regDate = NOW(),
				lastContacted = null,
				contactAgain = null,
				callingListTable = '" . $this->callingListTable . "',
				projectID = " . $_SESSION['project'] . ",
				salesRepID = '" . $this->userID . "'
				";



		try {
			$stmt = $this->pdo->prepare($query);
			$stmt->execute();
			$saved = true;
		} catch (PDOException $e) {
			echo "Data was not saved, because: " . $e->getMessage();
			$unsaved = true;
		}


		// Update callinglist, to mark as lead				

		$queryl = "UPDATE " . $this->callingListTable . " SET salesRepID=" . $this->userID . " WHERE Orgnr=" . $regNumber;

		try {
			$stmt = $this->pdo->prepare($queryl);
			$stmt->execute();
		} catch (PDOException $e) {
			echo "Calling List not updated, because: " . $e->getMessage();
		}


		return $saved;
		return $unsaved;
	} // end function leads


} // end class

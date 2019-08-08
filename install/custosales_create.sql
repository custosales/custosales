-- MariaDB dump 10.17  Distrib 10.4.7-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: stevia
-- ------------------------------------------------------
-- Server version	10.4.7-MariaDB-1:10.4.7+maria~disco

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `BranchCodes`
--

DROP TABLE IF EXISTS `BranchCodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BranchCodes` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `SN2002` varchar(10) DEFAULT NULL,
  `Tekst_SN2002` varchar(131) DEFAULT NULL,
  `SN2007` varchar(10) DEFAULT NULL,
  `Tekst_SN2007` varchar(121) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1233 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CallingListCompanies`
--

DROP TABLE IF EXISTS `CallingListCompanies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CallingListCompanies` (
  `ID` int(50) NOT NULL AUTO_INCREMENT,
  `regNumber` varchar(255) NOT NULL,
  `companyName` varchar(255) NOT NULL,
  `listID` int(50) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `ownerID` int(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3471 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `CallingLists`
--

DROP TABLE IF EXISTS `CallingLists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CallingLists` (
  `listID` int(50) NOT NULL AUTO_INCREMENT,
  `callingListName` varchar(255) NOT NULL,
  `callingListTableName` varchar(255) NOT NULL,
  `callingListOwnerID` int(50) NOT NULL,
  `callingListComments` text NOT NULL,
  PRIMARY KEY (`listID`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Calls`
--

DROP TABLE IF EXISTS `Calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Calls` (
  `callID` int(50) NOT NULL AUTO_INCREMENT,
  `callRegNumber` varchar(255) NOT NULL,
  `contactID` int(50) NOT NULL,
  `salesRepID` int(50) NOT NULL,
  `contactType` varchar(255) NOT NULL,
  `contactTime` datetime NOT NULL,
  `result` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `listCompanyID` int(11) NOT NULL,
  PRIMARY KEY (`callID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Companies`
--

DROP TABLE IF EXISTS `Companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Companies` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `regNumber` varchar(50) NOT NULL,
  `companyName` varchar(255) NOT NULL,
  `companyStatus` varchar(255) DEFAULT NULL,
  `companyType` varchar(255) DEFAULT NULL,
  `companyEmail` varchar(255) DEFAULT NULL,
  `companyInternet` varchar(255) DEFAULT NULL,
  `companyPhone` varchar(100) DEFAULT NULL,
  `companyMobilePhone` varchar(255) DEFAULT NULL,
  `companyFax` varchar(255) DEFAULT NULL,
  `companyAddress` varchar(255) DEFAULT NULL,
  `companyPostAddress` varchar(255) DEFAULT NULL,
  `companyZipCode` varchar(255) NOT NULL,
  `companyCity` varchar(255) DEFAULT NULL,
  `companyCounty` varchar(255) NOT NULL,
  `dateRegistered` date DEFAULT NULL,
  `dateIncorporated` date DEFAULT NULL,
  `companyManager` varchar(255) DEFAULT NULL,
  `branchCode` varchar(100) DEFAULT NULL,
  `branchText` text DEFAULT NULL,
  `lastContacted` datetime DEFAULT NULL,
  `contactAgain` date NOT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `regDate` datetime DEFAULT NULL,
  `salesRepID` int(50) DEFAULT NULL,
  `callingListTable` varchar(255) NOT NULL,
  `projectID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `org_number` (`regNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=14878 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ContactTypes`
--

DROP TABLE IF EXISTS `ContactTypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ContactTypes` (
  `contactTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `contactTypeName` varchar(255) NOT NULL,
  `contactTypeDescription` text NOT NULL,
  PRIMARY KEY (`contactTypeID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Contacts`
--

DROP TABLE IF EXISTS `Contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Contacts` (
  `contactID` int(100) NOT NULL AUTO_INCREMENT,
  `contactType` int(11) NOT NULL,
  `contactCompanyID` varchar(255) NOT NULL,
  `contactName` varchar(255) NOT NULL,
  `contactPhone` varchar(255) DEFAULT NULL,
  `contactMobilePhone` varchar(255) NOT NULL,
  `contactEmail` varchar(255) DEFAULT NULL,
  `contactEmail2` varchar(255) DEFAULT NULL,
  `contactAddress` varchar(255) DEFAULT NULL,
  `contactCity` varchar(255) DEFAULT NULL,
  `contactZipcode` varchar(255) DEFAULT NULL,
  `salesRepID` int(50) DEFAULT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`contactID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Contracts`
--

DROP TABLE IF EXISTS `Contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Contracts` (
  `contractID` int(11) NOT NULL AUTO_INCREMENT,
  `contractName` varchar(255) NOT NULL,
  `contractDescription` text NOT NULL,
  `contractURL` varchar(255) NOT NULL,
  `contractOwnerID` int(11) NOT NULL,
  PRIMARY KEY (`contractID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Currencies`
--

DROP TABLE IF EXISTS `Currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Currencies` (
  `currencyID` int(11) NOT NULL AUTO_INCREMENT,
  `currencyName` varchar(255) NOT NULL,
  `currencySymbol` varchar(50) NOT NULL,
  `defaultCurrency` tinyint(1) NOT NULL,
  PRIMARY KEY (`currencyID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Departments`
--

DROP TABLE IF EXISTS `Departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Departments` (
  `departmentID` int(11) NOT NULL AUTO_INCREMENT,
  `departmentName` varchar(255) NOT NULL,
  `workplaceID` int(11) NOT NULL,
  `managerID` int(11) NOT NULL,
  `superDepartmentID` int(11) NOT NULL,
  PRIMARY KEY (`departmentID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Invoices`
--

DROP TABLE IF EXISTS `Invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Invoices` (
  `ID` int(200) NOT NULL AUTO_INCREMENT,
  `orderID` int(11) NOT NULL,
  `invoicedDate` date NOT NULL,
  `reminderDate` date NOT NULL,
  `defaultedDate` date NOT NULL,
  `paidDate` date NOT NULL,
  `invoiceSum` int(100) NOT NULL,
  `productIDs` varchar(255) NOT NULL,
  `salesRepID` int(50) NOT NULL,
  `comments` text NOT NULL,
  `invoiceText1` text NOT NULL,
  `invoiceText2` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Links`
--

DROP TABLE IF EXISTS `Links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Links` (
  `linkID` int(11) NOT NULL AUTO_INCREMENT,
  `linkName` varchar(255) CHARACTER SET latin1 NOT NULL,
  `linkURL` varchar(255) CHARACTER SET latin1 NOT NULL,
  `linkDescription` text CHARACTER SET latin1 NOT NULL,
  `linkOwnerID` int(11) NOT NULL,
  `linkPrivate` tinyint(1) NOT NULL,
  PRIMARY KEY (`linkID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `MainBranches`
--

DROP TABLE IF EXISTS `MainBranches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MainBranches` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(1) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `NyeFirmaer`
--

DROP TABLE IF EXISTS `NyeFirmaer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `NyeFirmaer` (
  `Orgnr` int(9) NOT NULL DEFAULT 0,
  `Firmanavn` varchar(90) DEFAULT NULL,
  `Selskapsform` varchar(3) DEFAULT NULL,
  `Kontaktperson` varchar(34) DEFAULT NULL,
  `B.adresse` varchar(80) DEFAULT NULL,
  `B.postnr` int(4) DEFAULT NULL,
  `B.poststed` varchar(20) DEFAULT NULL,
  `Telefon` varchar(11) DEFAULT NULL,
  `Faks` varchar(13) DEFAULT NULL,
  `E-post` varchar(46) DEFAULT NULL,
  `Bransjekode` int(5) DEFAULT NULL,
  `Bransjetekst` varchar(100) DEFAULT NULL,
  `Fylke` varchar(16) DEFAULT NULL,
  `inntekt` varchar(255) NOT NULL,
  `kapital` varchar(255) NOT NULL,
  `salesRepID` int(11) NOT NULL,
  PRIMARY KEY (`Orgnr`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `OrderStatus`
--

DROP TABLE IF EXISTS `OrderStatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OrderStatus` (
  `orderStatusID` int(11) NOT NULL AUTO_INCREMENT,
  `orderStatusName` varchar(255) NOT NULL,
  `orderStatusDescription` varchar(255) NOT NULL,
  `orderStatusComments` text NOT NULL,
  PRIMARY KEY (`orderStatusID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Orders`
--

DROP TABLE IF EXISTS `Orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Orders` (
  `orderID` int(20) NOT NULL AUTO_INCREMENT,
  `regNumber` varchar(255) NOT NULL,
  `orderDate` date NOT NULL,
  `orderStatusID` int(5) NOT NULL,
  `salesRepID` int(10) NOT NULL,
  `customerContact` varchar(255) NOT NULL,
  `unitPrice` int(50) NOT NULL,
  `creditDays` varchar(255) NOT NULL,
  `otherTerms` text NOT NULL,
  `productID` int(11) NOT NULL,
  `orderComments` text NOT NULL,
  `regDate` datetime NOT NULL,
  PRIMARY KEY (`orderID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Preferences`
--

DROP TABLE IF EXISTS `Preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Preferences` (
  `companyID` int(11) NOT NULL AUTO_INCREMENT,
  `companyRegNumber` varchar(255) NOT NULL,
  `companyName` varchar(255) NOT NULL,
  `companyAddress` varchar(255) NOT NULL,
  `companyZip` varchar(255) NOT NULL,
  `companyCity` varchar(255) NOT NULL,
  `companyPhone` varchar(255) NOT NULL,
  `companyEmail` varchar(255) NOT NULL,
  `companyInternet` varchar(255) NOT NULL,
  `companyFax` varchar(255) NOT NULL,
  `companyChatDomain` varchar(255) NOT NULL,
  `defaultCurrency` varchar(255) NOT NULL,
  `defaultCreditDays` int(3) NOT NULL,
  `companyBankAccount` varchar(255) NOT NULL,
  `companyManagerID` int(11) NOT NULL,
  PRIMARY KEY (`companyID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ProductCategories`
--

DROP TABLE IF EXISTS `ProductCategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductCategories` (
  `productCategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `productCategoryName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `productCategoryDescription` text CHARACTER SET utf8 NOT NULL,
  `productCategoryOwnerID` int(11) NOT NULL,
  `productCategorySuperID` int(11) NOT NULL,
  `productCategoryActive` tinyint(1) NOT NULL,
  PRIMARY KEY (`productCategoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Products`
--

DROP TABLE IF EXISTS `Products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Products` (
  `productID` int(10) NOT NULL AUTO_INCREMENT,
  `productName` varchar(255) NOT NULL,
  `productDescription` text DEFAULT NULL,
  `countBased` tinyint(1) NOT NULL,
  `unitPrice` int(11) NOT NULL,
  `currencyID` int(11) NOT NULL,
  `productCategoryID` int(11) NOT NULL,
  `standardTerms` text NOT NULL,
  `departmentID` int(11) NOT NULL,
  `productOwnerID` int(10) DEFAULT NULL,
  `productProjectID` int(11) NOT NULL,
  PRIMARY KEY (`productID`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Projects`
--

DROP TABLE IF EXISTS `Projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Projects` (
  `projectID` int(11) NOT NULL AUTO_INCREMENT,
  `projectName` varchar(255) NOT NULL,
  `projectDescription` text NOT NULL,
  `projectStartDate` date NOT NULL,
  `projectEndDate` date NOT NULL,
  `projectClientID` int(11) NOT NULL,
  `projectOwnerID` int(11) NOT NULL,
  `projectSalesStages` varchar(255) NOT NULL,
  `projectFirstSalesStage` int(11) NOT NULL,
  `projectOrderStages` varchar(255) NOT NULL,
  `projectFirstOrderStage` int(11) NOT NULL,
  PRIMARY KEY (`projectID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `RavnInfo`
--

DROP TABLE IF EXISTS `RavnInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RavnInfo` (
  `Orgnr` int(9) NOT NULL DEFAULT 0,
  `Firmanavn` varchar(72) DEFAULT NULL,
  `Address` varchar(71) DEFAULT NULL,
  `Zip` int(4) DEFAULT NULL,
  `City` varchar(20) DEFAULT NULL,
  `Telefon` varchar(12) DEFAULT NULL,
  `Mobil` bigint(12) DEFAULT NULL,
  `Selskapsform` varchar(3) DEFAULT NULL,
  `Kontaktperson` varchar(27) DEFAULT NULL,
  `Kontaktperson funksjon` varchar(4) DEFAULT NULL,
  `Bransjer` varchar(211) DEFAULT NULL,
  `AccountYear` int(4) DEFAULT NULL,
  `Income` int(9) DEFAULT NULL,
  `Equity` int(8) DEFAULT NULL,
  `Fylke` varchar(22) DEFAULT NULL,
  `salesRepID` int(11) NOT NULL,
  PRIMARY KEY (`Orgnr`),
  UNIQUE KEY `Orgnr` (`Orgnr`),
  UNIQUE KEY `Orgnr_2` (`Orgnr`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Regnskap`
--

DROP TABLE IF EXISTS `Regnskap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Regnskap` (
  `companyID` int(20) NOT NULL,
  `regNumber` varchar(255) NOT NULL,
  `Aar` int(4) DEFAULT NULL,
  `Konsernregnskap` varchar(3) DEFAULT NULL,
  `Startdato` date DEFAULT NULL,
  `Avslutningsdato` date DEFAULT NULL,
  `Valutakode` varchar(3) DEFAULT NULL,
  `Sum_salgsinntekter` int(50) DEFAULT NULL,
  `Annen_driftsinntekt` int(50) DEFAULT NULL,
  `Sum_driftsinntekter` int(50) DEFAULT NULL,
  `Varekostnad` int(50) DEFAULT NULL,
  `Endr_i_beholdn_av_varer_under_tilvirkning_ferdige` int(50) DEFAULT NULL,
  `Beholdningsendringer` int(50) DEFAULT NULL,
  `Endr_i_beholdn_av_varer_under_tilvirkning` int(50) DEFAULT NULL,
  `Endr_i_beholdn_ferdig_tilvirkede_varer` int(50) DEFAULT NULL,
  `Endr_i_beholdn_av_egentilv_anleggsmidler` int(50) DEFAULT NULL,
  `Loennskostnader` int(50) DEFAULT NULL,
  `Herav_kun_loenn` int(50) DEFAULT NULL,
  `Pensjonskostnader` int(50) DEFAULT NULL,
  `Obligatorisk_tjenestepensjon` int(50) DEFAULT NULL,
  `Avskriving_varige_driftsmidler_im_eiend` int(50) DEFAULT NULL,
  `Nedskriving_av_driftsmidler_im_eiend` int(50) DEFAULT NULL,
  `Andre_driftskostnader` int(50) DEFAULT NULL,
  `Sum_driftskostnader` int(50) DEFAULT NULL,
  `Driftsresultat` int(50) DEFAULT NULL,
  `Mottatt_utbytte` int(50) DEFAULT NULL,
  `Inntekt_paa_investering_i_datterselskap` int(50) DEFAULT NULL,
  `Sum_annen_renteinntekt` int(50) DEFAULT NULL,
  `Sum_annen_finansinntekt` int(50) DEFAULT NULL,
  `Sum_finansinntekter` int(50) DEFAULT NULL,
  `Sum_annen_rentekostnad` int(50) DEFAULT NULL,
  `Sum_annen_finanskostnad` int(50) DEFAULT NULL,
  `Sum_finanskostnader` int(50) DEFAULT NULL,
  `Netto_finans` int(50) DEFAULT NULL,
  `Ordinaert_resultat_foer_skattekostnad` int(50) DEFAULT NULL,
  `Skattekostnad_paa_ordinaert_resultat` int(50) DEFAULT NULL,
  `Ordinaert_resultat` int(50) DEFAULT NULL,
  `Ekstraordinaere_inntekter` int(50) DEFAULT NULL,
  `Ekstraordinaere_kostnader` int(50) DEFAULT NULL,
  `Netto_ekstraordinaere_poster` int(50) DEFAULT NULL,
  `Aarsresultat_foer_minoritetsinteresser` int(50) DEFAULT NULL,
  `Skattekostnad_paa_ekstraordinaert_resultat` int(50) DEFAULT NULL,
  `Minoritetens_andel_foer_aarsresultat` int(50) DEFAULT NULL,
  `Aarsresultat` int(50) DEFAULT NULL,
  `Overfoering_til_fra_fond` int(50) DEFAULT NULL,
  `Avsetning_fond_for_vurderingsforskjeller` int(50) DEFAULT NULL,
  `Overfoering_til_fra_fond_for_urealiserte_gevinster` int(50) DEFAULT NULL,
  `Avsatt_utbytte_1` int(50) DEFAULT NULL,
  `Konsernbidrag` int(50) DEFAULT NULL,
  `Aksjonaerbidrag` int(50) DEFAULT NULL,
  `Fondsemisjon` int(50) DEFAULT NULL,
  `Overfoeringer_til_fra_annen_egenkapital` int(50) DEFAULT NULL,
  `Udekket_tap_1` int(50) DEFAULT NULL,
  `Sum_overfoeringer_og_disponeringer` int(50) DEFAULT NULL,
  `BALANSEREGNSKAP` int(50) DEFAULT NULL,
  `Forskning_og_utvikling` int(50) DEFAULT NULL,
  `Konsesjoner_patenter_lisenser` int(50) DEFAULT NULL,
  `Utsatt_skattefordel` int(50) DEFAULT NULL,
  `Goodwill` int(50) DEFAULT NULL,
  `Andre_immatrielle_eiendeler` int(50) DEFAULT NULL,
  `Sum_immaterielle_anleggsmidler` int(50) DEFAULT NULL,
  `Tomter_bygninger_og_annen_fast_eiendom` int(50) DEFAULT NULL,
  `Maskiner_og_anlegg` int(50) DEFAULT NULL,
  `Skip_rigger_fly_og_lignende` int(50) DEFAULT NULL,
  `Driftsloesoere_inventar_verktoey_biler` int(50) DEFAULT NULL,
  `Andre_varige_driftsmidler` int(50) DEFAULT NULL,
  `Sum_varige_driftsmidler` int(50) DEFAULT NULL,
  `Aksjer_Investeringer_i_datterselskap` int(50) DEFAULT NULL,
  `Investeringer_i_aksjer_og_andeler` int(50) DEFAULT NULL,
  `Obligasjoner_og_andre_langsiktige_fordr` int(50) DEFAULT NULL,
  `Obligasjoner` int(50) DEFAULT NULL,
  `Andre_fordringer_1` int(50) DEFAULT NULL,
  `Sum_finansielle_anleggsmidler` int(50) DEFAULT NULL,
  `Sum_anleggsmidler` int(50) DEFAULT NULL,
  `Sum_varelager` int(50) DEFAULT NULL,
  `Kundefordringer` int(50) DEFAULT NULL,
  `Andre_fordringer_2` int(50) DEFAULT NULL,
  `Konsernfordringer` int(50) DEFAULT NULL,
  `Krav_paa_innbetaling_av_selskapskapital` int(50) DEFAULT NULL,
  `Sum_fordringer` int(50) DEFAULT NULL,
  `Aksjer_og_andeler_i_samme_konsern` int(50) DEFAULT NULL,
  `Markedsbaserte_aksjer` int(50) DEFAULT NULL,
  `Markedsbaserte_obligasjoner` int(50) DEFAULT NULL,
  `Andre_markedsbaserte_finansielle_instr` int(50) DEFAULT NULL,
  `Andre_finansielle_instrumenter` int(50) DEFAULT NULL,
  `Sum_investeringer` int(50) DEFAULT NULL,
  `Kasse_Bank_Post` int(50) DEFAULT NULL,
  `Sum_omloepsmidler` int(50) DEFAULT NULL,
  `Sum_eiendeler` int(50) DEFAULT NULL,
  `Aksjekapital_Selskapskapital` int(50) DEFAULT NULL,
  `Egne_aksjer` int(50) DEFAULT NULL,
  `Overkursfond` int(50) DEFAULT NULL,
  `Sum_innskutt_egenkapital` int(50) DEFAULT NULL,
  `Fond_for_vurderingsforskjeller` int(50) DEFAULT NULL,
  `Fond_for_verdiendringer` int(50) DEFAULT NULL,
  `Fond_for_urealiserte_gevinster` int(50) DEFAULT NULL,
  `Fond` int(50) DEFAULT NULL,
  `Avsatt_utbytte_2` int(50) DEFAULT NULL,
  `Annen_egenkapital` int(50) DEFAULT NULL,
  `Udekket_tap` int(50) DEFAULT NULL,
  `Minoritetsinteresser` int(50) DEFAULT NULL,
  `Sum_opptjent_egenkapital` int(50) DEFAULT NULL,
  `Minoritetsinteresser_etter_sum_opptjent_EK` int(50) DEFAULT NULL,
  `Sum_egenkapital` int(50) DEFAULT NULL,
  `Pensjonsforpliktelser` int(50) DEFAULT NULL,
  `Utsatt_skatt` int(50) DEFAULT NULL,
  `Andre_avsetninger_for_forpliktelser` int(50) DEFAULT NULL,
  `Sum_avsetninger_til_forpliktelser` int(50) DEFAULT NULL,
  `Pantegjeld_gjeld_til_kredittinstitusjoner` int(50) DEFAULT NULL,
  `Langsiktig_konserngjeld` int(50) DEFAULT NULL,
  `Ansvarlig_laanekapital` int(50) DEFAULT NULL,
  `Annen_langsiktig_gjeld` int(50) DEFAULT NULL,
  `Sum_annen_langsiktig_gjeld` int(50) DEFAULT NULL,
  `Sum_langsiktig_gjeld` int(50) DEFAULT NULL,
  `Konvertible_laan` int(50) DEFAULT NULL,
  `Sertifikatlaan` int(50) DEFAULT NULL,
  `Gjeld_til_kredittinstitusjoner` int(50) DEFAULT NULL,
  `Leverandoergjeld` int(50) DEFAULT NULL,
  `Betalbar_skatt` int(50) DEFAULT NULL,
  `Skyldige_offentlige_utgifter` int(50) DEFAULT NULL,
  `Utbytte` int(50) DEFAULT NULL,
  `Kortsiktig_konserngjeld` int(50) DEFAULT NULL,
  `Andre_kreditorer` int(50) DEFAULT NULL,
  `Annen_kortsiktig_gjeld` int(50) DEFAULT NULL,
  `Sum_kortsiktig_gjeld` int(50) DEFAULT NULL,
  `Sum_gjeld` int(50) DEFAULT NULL,
  `Sum_egenkapital_og_gjeld` int(50) DEFAULT NULL,
  `OEVRIG_INFORMASJON` text DEFAULT NULL,
  `Antall_aarsverk` int(50) DEFAULT NULL,
  `Ansatte` int(50) DEFAULT NULL,
  `Antall_deltidsansatte` int(50) DEFAULT NULL,
  `Ikke_pliktig_OTP` int(50) DEFAULT NULL,
  `Har_OTP_ikke_tall` int(50) DEFAULT NULL,
  `Lederloenn` int(50) DEFAULT NULL,
  `Diettgodtgjoerelse_leder` int(50) DEFAULT NULL,
  `Bilgodtgjoerelse` int(50) DEFAULT NULL,
  `Styrehonorar_leder` int(10) DEFAULT NULL,
  `Pensjonskostnader_leder` int(50) DEFAULT NULL,
  `Bonus_leder` int(50) DEFAULT NULL,
  `Annen_godtgjoerelse_leder` int(50) DEFAULT NULL,
  `Daglig_leder_loennet_av_annet_selskap` int(50) DEFAULT NULL,
  `Fallskjerm_saerskilt_vederlag` int(50) DEFAULT NULL,
  `Opsjoner_bonuser` int(50) DEFAULT NULL,
  `Revisjonshonorar` int(50) DEFAULT NULL,
  `Annen_revisjonsbistand` int(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Roles`
--

DROP TABLE IF EXISTS `Roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Roles` (
  `roleID` int(11) NOT NULL AUTO_INCREMENT,
  `roleName` varchar(255) NOT NULL,
  `roleDescription` text NOT NULL,
  `roleCallingLists` varchar(255) NOT NULL,
  `roleProjectID` int(11) NOT NULL,
  `salesModule` tinyint(1) NOT NULL,
  `orderModule` tinyint(1) NOT NULL,
  `reportModule` tinyint(1) NOT NULL,
  `supervisorRights` tinyint(1) NOT NULL,
  PRIMARY KEY (`roleID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SalesReps`
--

DROP TABLE IF EXISTS `SalesReps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SalesReps` (
  `ID` int(50) NOT NULL AUTO_INCREMENT,
  `repName` varchar(255) NOT NULL,
  `repPhone1` varchar(255) NOT NULL,
  `repPhone2` varchar(255) DEFAULT NULL,
  `repEmail1` varchar(255) NOT NULL,
  `repEmail2` varchar(255) DEFAULT NULL,
  `repAddress` varchar(255) NOT NULL,
  `repZipcode` varchar(255) NOT NULL,
  `repCity` varchar(255) NOT NULL,
  `supervisorID` int(50) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `staffHatStatus` int(5) DEFAULT NULL,
  `callCenterID` int(5) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `signedContract` tinyint(1) DEFAULT NULL,
  `Pwd` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SalesStages`
--

DROP TABLE IF EXISTS `SalesStages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SalesStages` (
  `salesStageID` int(11) NOT NULL AUTO_INCREMENT,
  `salesStageName` varchar(255) NOT NULL,
  `salesStageDescription` varchar(255) NOT NULL,
  `salesStageIcon` varchar(255) NOT NULL,
  `salesStageComments` text NOT NULL,
  PRIMARY KEY (`salesStageID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Templates`
--

DROP TABLE IF EXISTS `Templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Templates` (
  `templateID` int(11) NOT NULL AUTO_INCREMENT,
  `templateType` varchar(255) NOT NULL,
  `templateContent` text NOT NULL,
  `templateExplanation` text NOT NULL,
  `templateOwnerID` int(11) NOT NULL,
  `regDate` datetime NOT NULL,
  PRIMARY KEY (`templateID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `userID` int(5) NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `jobTitle` varchar(255) NOT NULL,
  `departmentID` int(11) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `roles` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mobilePhone` varchar(255) NOT NULL,
  `address` varchar(55) NOT NULL,
  `zipCode` varchar(100) NOT NULL,
  `city` varchar(255) NOT NULL,
  `skills` text NOT NULL,
  `signedContract` tinyint(1) NOT NULL,
  `contractID` int(11) NOT NULL,
  `documents` varchar(255) NOT NULL,
  `supervisorID` int(11) NOT NULL,
  `workplaceID` int(11) NOT NULL,
  `userComments` text NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `WebHalden`
--

DROP TABLE IF EXISTS `WebHalden`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `WebHalden` (
  `Orgnr` int(9) DEFAULT NULL,
  `Firmanavn` varchar(52) DEFAULT NULL,
  `Selskapsform` varchar(2) DEFAULT NULL,
  `Kontaktperson` varchar(27) DEFAULT NULL,
  `B.adresse` varchar(58) DEFAULT NULL,
  `B.postnr` int(4) DEFAULT NULL,
  `B.poststed` varchar(17) DEFAULT NULL,
  `P.adresse` varchar(58) DEFAULT NULL,
  `P.postnr` varchar(8) DEFAULT NULL,
  `P.poststed` varchar(17) DEFAULT NULL,
  `Telefon` varchar(11) DEFAULT NULL,
  `Faks` varchar(11) DEFAULT NULL,
  `Driftsinntekter` int(7) DEFAULT NULL,
  `Driftresultat` int(7) DEFAULT NULL,
  `Egenkapital` int(7) DEFAULT NULL,
  `Antall ansatte` varchar(27) DEFAULT NULL,
  `E-post` varchar(41) DEFAULT NULL,
  `Bransjekode` varchar(100) DEFAULT NULL,
  `Bransjetekst` varchar(100) DEFAULT NULL,
  `Regnskapsår` int(4) DEFAULT NULL,
  `salesRepID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Workhours`
--

DROP TABLE IF EXISTS `Workhours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Workhours` (
  `ID` int(255) NOT NULL AUTO_INCREMENT,
  `Type` varchar(10) CHARACTER SET latin1 NOT NULL,
  `Stamp` datetime NOT NULL,
  `userID` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Workplaces`
--

DROP TABLE IF EXISTS `Workplaces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Workplaces` (
  `workplaceID` int(11) NOT NULL AUTO_INCREMENT,
  `workplaceName` varchar(255) NOT NULL,
  `workplaceAddress` varchar(255) NOT NULL,
  `workplaceZip` varchar(100) NOT NULL,
  `workplaceCity` varchar(255) NOT NULL,
  `managerID` int(11) NOT NULL,
  `workplaceDescription` text NOT NULL,
  `mainOffice` tinyint(4) NOT NULL,
  PRIMARY KEY (`workplaceID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-07 11:23:42

<?php
require_once('Eco.php');
require_once('User.php');
require_once('Variation.php');
require_once('Line.php');
require_once('DetailsPayment.php');
require_once('Monetization.php');
require_once('Currency.php');
require_once('InterfaceLanguage.php');
require_once('BaseTheory.php');
require_once('BasePractice.php');

class Study {

	public $id;
	public $name;
	public $side;
	public $eco;
	public $dateCreated;
	public $dateUpdated;
	public $author;
	public $authorFullName;
	public $aboutStudy;
	public $active;
	public $monetization;
	public $currencyAndPrice;
	public $detailsPayment;
	public $interfaceLanguage;
	public $baseTheory;
	public $basePractice;
	public $variations;
	public $variationsCount;
	public $linesCount;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_STUDY_ID'];
			$this->name = $array['OPENING_STUDY_NAME'];
			$this->side = $array['OPENING_STUDY_SIDE'];
			$this->dateCreated = $array['OPENING_STUDY_CREATED'];
			$this->dateUpdated = $array['OPENING_STUDY_UPDATED'];
			$this->active = $array['OPENING_STUDY_ACTIVE'];;
			$this->aboutStudy = $array['OPENING_STUDY_ABOUT_STUDY'];

			$this->author = new User($array);
			$this->authorFullName = $this->author->firstName.' '.$this->author->lastName;

			$this->eco = new Eco($array);

			$this->monetization = new Monetization($array);
			$this->currency = new Currency($array);
			$this->detailsPayment = new DetailsPayment($array);
			$this->interfaceLanguage = new InterfaceLanguage($array);

			$this->baseTheory = new BaseTheory($array);

			$this->basePractice = new BasePractice($array);
		}
  }

	public function __destruct(){

	}

	public function getStudyWithID($paramStudy){

		$DB = fnDBConn();

    $SQLISTAESTUDOS = "SELECT OS.ID AS OPENING_STUDY_ID,
       OS.NAME AS OPENING_STUDY_NAME,
       OS.SIDE AS OPENING_STUDY_SIDE,
       OS.ID_USER AS USER_ID,
       OS.ABOUT AS OPENING_STUDY_ABOUT_STUDY,
       OS.DIN_LAST_UPDATE AS OPENING_STUDY_UPDATED,
			 OS.ACTIVE AS OPENING_STUDY_ACTIVE,
       DATE_FORMAT(OS.DIN,'%M %D, %Y') AS OPENING_STUDY_CREATED,
       U.FIRSTNAME AS USER_FIRSTNAME,
       U.LASTNAME AS USER_LASTNAME,
       U.AVATAR AS USER_AVATAR,
       U.ELO_FIDE AS USER_ELO_FIDE,
       OE.ID AS OPENING_STUDY_ECO_ID,
       OE.CODE AS OPENING_STUDY_ECO_CODE,
       OE.NAME AS OPENING_STUDY_ECO_NAME,
       OE.LINE AS OPENING_STUDY_ECO_LINE,
       C.SYMBOL AS CURRENCY_SYMBOL,
       C.ID AS CURRENCY_ID,
       C.CODE AS CURRENCY_CODE,
       C.NAME AS CURRENCY_NAME,
       OSTB.ID AS OPENING_STUDY_BIBLIOGRAPHY_ID,
       OSTB.TEXT AS OPENING_STUDY_BIBLIOGRAPHY_TEXT,
       OSTB.DIN AS OPENING_STUDY_BIBLIOGRAPHY_DATE_CREATED,
       OSGS.ID AS OPENING_THEORY_GAME_STYLE_ID,
       OSGS.TEXT AS OPENING_THEORY_GAME_STYLE_TEXT,
       OSGS.DIN AS OPENING_THEORY_GAME_STYLE_DATE_CREATED,
       OSTH.ID AS OPENING_THEORY_HISTORY_ID,
       OSTH.TEXT AS OPENING_THEORY_HISTORY_TEXT,
       OSTH.DIN AS OPENING_THEORY_HISTORY_DATE_CREATED,
       OSTMG.ID AS OPENING_THEORY_MAIN_GRANDMASTERS_ID,
       OSTMG.TEXT AS OPENING_THEORY_MAIN_GRANDMASTERS_TEXT,
       OSTMG.DIN AS OPENING_THEORY_MAIN_GRANDMASTERS_DATE_CREATED,
       OSDP.TEXT AS OPENING_STUDY_DETAILS_PAYMENT_TEXT,
       OSDP.URL AS OPENING_STUDY_DETAILS_PAYMENT_URL,
       OSDP.ID AS OPENING_STUDY_DETAILS_PAYMENT_ID,
       OSDP.DIN AS OPENING_STUDY_DETAILS_PAYMENT_DATE_CREATED,
       TP.DESC AS PAYMENT_SYSTEM_DESC,
       TP.ID AS PAYMENT_SYSTEM_ID,
       PR.VALUE AS PRICE_VALUE,
       PR.ID AS PRICE_ID,
       IL.ID AS INTERFACE_LANGUAGE_ID,
       IL.CODE AS INTERFACE_LANGUAGE_CODE,
       IL.NAME AS INTERFACE_LANGUAGE_NAME
FROM OPENING_STUDY AS OS
INNER JOIN USER AS U ON U.ID = OS.ID_USER
INNER JOIN OPENING_STUDY_MONETIZATION AS OSM ON OSM.ID = OS.ID
INNER JOIN OPENING_ECO AS OE ON OE.ID = OS.ID_OPENING_ECO
INNER JOIN CURRENCY AS C ON C.ID = OSM.CURRENCY
INNER JOIN OPENING_STUDY_THEORY_BIBLIOGRAPHY AS OSTB ON OSTB.ID = OS.ID
INNER JOIN OPENING_STUDY_THEORY_GAME_STYLE AS OSGS ON OSGS.ID = OS.ID
INNER JOIN OPENING_STUDY_THEORY_HISTORY AS OSTH ON OSTH.ID = OS.ID
INNER JOIN OPENING_STUDY_THEORY_MAIN_GRANDMASTERS AS OSTMG ON OSTMG.ID = OS.ID
INNER JOIN OPENING_STUDY_DETAILS_PAYMENT AS OSDP ON OSDP.ID = OSM.ID_DETAILS_PAYMENT
INNER JOIN TYPE_PAYMENT AS TP ON TP.ID = OSDP.ID_TYPE_PAYMENT
INNER JOIN PRICE AS PR ON PR.ID = OSM.ID_PRICE
INNER JOIN INTERFACE_LANGUAGE AS IL ON IL.ID = OS.ID_INTERFACE_LANGUAGE
WHERE OS.ID = $paramStudy";

     $RESULTLISTAESTUDOS = fnDB_DO_SELECT($DB,$SQLISTAESTUDOS);

		 $study = new Study($RESULTLISTAESTUDOS);

	   $variarion = new Variation();
	   $arrVariations = $variarion->getAllVariationsForStudy($paramStudy);

		 $study->variations = $arrVariations;

		 $study->variationsCount = count($arrVariations);

		 foreach ($arrVariations as $key => $variation) {
		 		$variarionObj = new Variation();
				$variarionObj = $variation;

				foreach ($variation->lines as $key => $line) {
					$lineObj = new Line();
					$lineObj = $line;
					$study->linesCount ++;
				}
		 }

		 return $study;
	}

	public function getAllStudies(){

		$DB = fnDBConn();

    $SQL = "SELECT OS.ID AS OPENING_STUDY_ID,
       OS.NAME AS OPENING_STUDY_NAME,
       OS.SIDE AS OPENING_STUDY_SIDE,
       OS.ID_USER AS USER_ID,
			 OS.ACTIVE AS OPENING_STUDY_ACTIVE,
       OS.ID_OPENING_ECO AS OPENING_STUDY_ECO_ID,
       DATE_FORMAT(OS.DIN,'%M %D, %Y') AS OPENING_STUDY_CREATED,
       DATE_FORMAT(OS.DIN_LAST_UPDATE,'%M %D, %Y') AS OPENING_STUDY_UPDATED,
       U.FIRSTNAME AS USER_FIRSTNAME,
       U.LASTNAME AS USER_LASTNAME
FROM OPENING_STUDY AS OS
INNER JOIN USER AS U ON OS.ID_USER = U.ID
WHERE 1";

   	$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrStudies = [];

		foreach($RESULT as $KEY => $ROW){
	    $study = new Study($ROW);
			array_push($arrStudies, $study);
	  }

		return $arrStudies;
	}

	public function getAllActiveStudies(){

		$DB = fnDBConn();

    $SQL = "SELECT OS.ID AS OPENING_STUDY_ID,
       OS.NAME AS OPENING_STUDY_NAME,
       OS.SIDE AS OPENING_STUDY_SIDE,
       OS.ID_USER AS USER_ID,
			 OS.ACTIVE AS OPENING_STUDY_ACTIVE,
       OS.ID_OPENING_ECO AS OPENING_STUDY_ECO_ID,
       DATE_FORMAT(OS.DIN,'%M %D, %Y') AS OPENING_STUDY_CREATED,
       DATE_FORMAT(OS.DIN_LAST_UPDATE,'%M %D, %Y') AS OPENING_STUDY_UPDATED,
       U.FIRSTNAME AS USER_FIRSTNAME,
       U.LASTNAME AS USER_LASTNAME
FROM OPENING_STUDY AS OS
INNER JOIN USER AS U ON OS.ID_USER = U.ID
WHERE OS.ACTIVE = 1";

   	$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrStudies = [];

		foreach($RESULT as $KEY => $ROW){
	    $study = new Study($ROW);
			array_push($arrStudies, $study);
	  }

		return $arrStudies;
	}

	public function checkIfUserHasStudy($userID, $studyID) {

		$DB = fnDBConn();

		$SQL = "SELECT OSACQ.ACTIVE
FROM OPENING_STUDY_ACQUISITION AS OSACQ
WHERE OSACQ.ID_OPENING_STUDY = $studyID
  AND OSACQ.ID_USER = $userID";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		if ($RESULT == 0) {
			return false;
		}else{
			return true;
		}
	}

	public function getAllStudiesForAuthor($paramStudy){

		$DB = fnDBConn();

    $SQL = "SELECT OS.ID AS OPENING_STUDY_ID,
       OS.NAME AS OPENING_STUDY_NAME,
       OS.SIDE AS OPENING_STUDY_SIDE,
       OS.ID_USER AS USER_ID,
       OS.ID_OPENING_ECO AS OPENING_STUDY_ECO_ID,
       DATE_FORMAT(OS.DIN,'%M %D, %Y') AS OPENING_STUDY_CREATED,
       DATE_FORMAT(OS.DIN_LAST_UPDATE,'%M %D, %Y') AS OPENING_STUDY_UPDATED,
       U.FIRSTNAME AS USER_FIRSTNAME,
       U.LASTNAME AS USER_LASTNAME
FROM OPENING_STUDY AS OS
INNER JOIN USER AS U ON OS.ID_USER = U.ID
WHERE OS.ID_USER = $paramStudy";

   	$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrStudies = [];

		foreach($RESULT as $KEY => $ROW){
	    $study = new Study($ROW);
			array_push($arrStudies, $study);
	  }

		return $arrStudies;
	}

}

?>

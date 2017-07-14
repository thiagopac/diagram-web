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
	public $dateCreated;
	public $dateUpdated;
	public $aboutStudy;
	public $active;
	public $currencyAndPrice;
	public $deleted;
	public $ecoID;
	public $authorID;
	public $interfaceLanguageID;

	//propriedades entidades
	public $eco;
	public $author;
	public $monetization;
	public $interfaceLanguage;
	public $baseTheory;
	public $basePractice;
	public $variations;

	static $showDeleted;
	static $whereDeleted;
	static $orderBy;

	static $showVariationDeleted;
	static $showLineDeleted;

	//construtor da classe
	public function __construct($array){

		self::$whereDeleted = self::$showDeleted == true ? "" : " AND OS.DELETED = 0";

		Variation::$showDeleted = self::$showVariationDeleted;
		Line::$showDeleted = self::$showLineDeleted;

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_STUDY_ID'];
			$this->name = $array['OPENING_STUDY_NAME'];
			$this->side = $array['OPENING_STUDY_SIDE'];
			$this->dateCreated = $array['OPENING_STUDY_CREATED'];
			$this->dateUpdated = $array['OPENING_STUDY_UPDATED'];
			$this->active = $array['OPENING_STUDY_ACTIVE'];;
			$this->aboutStudy = $array['OPENING_STUDY_ABOUT_STUDY'];
			$this->ecoID = $array['OPENING_STUDY_ECO_ID'];
			$this->authorID = $array['USER_ID'];
			$this->interfaceLanguageID = $array['INTERFACE_LANGUAGE_ID'];

//NÃO ESTÁ MAIS POPULANDO AS PROPRIEDADES ENTIDADES POIS ESTAVA IMPACTANDO NA PERFORMANCE
			// $user = new User();
			// $this->author = $user->getUserWithId($array['USER_ID']);
			// $this->authorFullName = $this->author->firstName.' '.$this->author->lastName;
			//
			// $eco = new Eco();
			// $this->eco = $eco->getEcoForStudy($array['OPENING_STUDY_ID']);
			//
			// $monetization = new Monetization();
			// $this->monetization = $monetization->getMonetizationForStudy($array['OPENING_STUDY_ID']);
			//
			// $interfaceLanguage = new InterfaceLanguage();
			// $this->interfaceLanguage = $interfaceLanguage->getInterfaceLanguageWithID($array['INTERFACE_LANGUAGE_ID']);
			//
			// $baseTheory = new BaseTheory();
			// $this->baseTheory = $baseTheory->getBaseTheoryForStudy($array['OPENING_STUDY_ID']);

			$this->deleted = $array['OPENING_STUDY_DELETED'];
		}
  }

	public function __destruct(){

	}

	public function getStudyWithID($paramStudy){

		$DB = fnDBConn();

    $SQL = "SELECT OS.ID AS OPENING_STUDY_ID,
       OS.NAME AS OPENING_STUDY_NAME,
       OS.SIDE AS OPENING_STUDY_SIDE,
       OS.ID_USER AS USER_ID,
       OS.ABOUT AS OPENING_STUDY_ABOUT_STUDY,
			 OS.ID_OPENING_ECO AS OPENING_STUDY_ECO_ID,
       OS.DIN_LAST_UPDATE AS OPENING_STUDY_UPDATED,
			 OS.ACTIVE AS OPENING_STUDY_ACTIVE,
			 OS.ID_INTERFACE_LANGUAGE AS INTERFACE_LANGUAGE_ID,
			 OS.DELETED AS OPENING_STUDY_DELETED,
       DATE_FORMAT(OS.DIN,'%M %D, %Y') AS OPENING_STUDY_CREATED
FROM OPENING_STUDY AS OS
WHERE OS.ID = $paramStudy";

		$SQL = $SQL.self::$whereDeleted;

    $RESULT = fnDB_DO_SELECT($DB,$SQL);

		$study = new Study($RESULT);


//NÃO POPULANDO MAIS DADOS DE VARIATIONS POIS NEM SEMPRE OS DADOS SÃO NECESSÁRIOS E HAVIA IMPACTO NA PERFORMANCE
	  // $variarion = new Variation();
	  // $arrVariations = $variarion->getAllVariationsForStudy($paramStudy);
		//
		// $study->variations = $arrVariations;
		//
		// $study->variationsCount = count($arrVariations);
		//
		// foreach ($arrVariations as $key => $variation) {
		//  	$variarionObj = new Variation();
		// 	$variarionObj = $variation;
		//
		// 	foreach ($variation->lines as $key => $line) {
		// 		$lineObj = new Line();
		// 		$lineObj = $line;
		// 		$study->linesCount ++;
		// 	}
		// }

		return $study;
	}

// 	public function getBasicDataStudyWithID($paramStudy){
//
// 		$DB = fnDBConn();
//
//     $SQL = "SELECT OS.ID AS OPENING_STUDY_ID,
//        OS.NAME AS OPENING_STUDY_NAME,
//        OS.SIDE AS OPENING_STUDY_SIDE,
//        OS.ID_USER AS USER_ID,
//        OS.ABOUT AS OPENING_STUDY_ABOUT_STUDY,
// 			 OS.ID_OPENING_ECO AS OPENING_STUDY_ECO_ID,
//        OS.DIN_LAST_UPDATE AS OPENING_STUDY_UPDATED,
// 			 OS.ACTIVE AS OPENING_STUDY_ACTIVE,
// 			 OS.ID_INTERFACE_LANGUAGE AS INTERFACE_LANGUAGE_ID,
// 			 OS.DELETED AS OPENING_STUDY_DELETED,
//        DATE_FORMAT(OS.DIN,'%M %D, %Y') AS OPENING_STUDY_CREATED
// FROM OPENING_STUDY AS OS
// WHERE OS.ID = $paramStudy";
//
// 		 $SQL = $SQL.self::$whereDeleted;
//
//      $RESULT = fnDB_DO_SELECT($DB,$SQL);
//
// 		 $study = new Study($RESULT);
//
// 		 return $study;
// 	}

	public function getAllStudies(){

		$DB = fnDBConn();

    $SQL = "SELECT OS.ID AS OPENING_STUDY_ID,
       OS.NAME AS OPENING_STUDY_NAME,
       OS.SIDE AS OPENING_STUDY_SIDE,
       OS.ID_USER AS USER_ID,
			 OS.ACTIVE AS OPENING_STUDY_ACTIVE,
			 OS.ID_INTERFACE_LANGUAGE AS INTERFACE_LANGUAGE_ID,
			 OS.DELETED AS OPENING_STUDY_DELETED,
       OS.ID_OPENING_ECO AS OPENING_STUDY_ECO_ID,
       DATE_FORMAT(OS.DIN,'%M %D, %Y') AS OPENING_STUDY_CREATED,
       DATE_FORMAT(OS.DIN_LAST_UPDATE,'%M %D, %Y') AS OPENING_STUDY_UPDATED,
       U.FIRSTNAME AS USER_FIRSTNAME,
       U.LASTNAME AS USER_LASTNAME
FROM OPENING_STUDY AS OS
INNER JOIN USER AS U ON OS.ID_USER = U.ID
WHERE 1";

		$SQL = $SQL.self::$whereDeleted;

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
			 OS.ID_INTERFACE_LANGUAGE AS INTERFACE_LANGUAGE_ID,
			 OS.DELETED AS OPENING_STUDY_DELETED,
       DATE_FORMAT(OS.DIN,'%M %D, %Y') AS OPENING_STUDY_CREATED,
       DATE_FORMAT(OS.DIN_LAST_UPDATE,'%M %D, %Y') AS OPENING_STUDY_UPDATED,
       U.FIRSTNAME AS USER_FIRSTNAME,
       U.LASTNAME AS USER_LASTNAME
FROM OPENING_STUDY AS OS
INNER JOIN USER AS U ON OS.ID_USER = U.ID
WHERE OS.ACTIVE = 1";

		$SQL = $SQL.self::$whereDeleted;

		$SQL = $SQL.self::$orderBy;

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
INNER JOIN OPENING_STUDY AS OS ON OS.ID = OSACQ.ID_OPENING_STUDY
WHERE OSACQ.ID_OPENING_STUDY = $studyID
AND OSACQ.ID_USER = $userID
AND OSACQ.DELETED = 0";

//o usuário que criou o estudo terá ele listado

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
			 OS.ID_INTERFACE_LANGUAGE AS INTERFACE_LANGUAGE_ID,
			 OS.DELETED AS OPENING_STUDY_DELETED,
       DATE_FORMAT(OS.DIN,'%M %D, %Y') AS OPENING_STUDY_CREATED,
       DATE_FORMAT(OS.DIN_LAST_UPDATE,'%M %D, %Y') AS OPENING_STUDY_UPDATED,
       U.FIRSTNAME AS USER_FIRSTNAME,
       U.LASTNAME AS USER_LASTNAME
FROM OPENING_STUDY AS OS
INNER JOIN USER AS U ON OS.ID_USER = U.ID
WHERE OS.ID_USER = $paramStudy";

		$SQL = $SQL.self::$whereDeleted;

   	$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrStudies = [];

		foreach($RESULT as $KEY => $ROW){
	    $study = new Study($ROW);
			array_push($arrStudies, $study);
	  }

		return $arrStudies;
	}

	public function insertStudy($paramStudy){
		$DB = fnDBConn();

		$SQL = "INSERT INTO OPENING_STUDY
		(ID_INTERFACE_LANGUAGE,
		NAME,
		ABOUT,
		SIDE,
		ID_OPENING_ECO,
		ID_USER)
		VALUES('$paramStudy->interfaceLanguageID',
		'$paramStudy->name',
		'$paramStudy->aboutStudy',
		'$paramStudy->side',
		'$paramStudy->ecoID',
		'$paramStudy->authorID')";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		$paramStudy->id = $RET[1]; //esse array retorna na posição 0 o número de linhas afetadas pelo update e na posição 1 o id do regitro inserido

		//Adiciona registro na tabela de auditoria
	  fnDB_LOG_AUDIT_ADD($DB,"Novo estudo criado.");

		return $paramStudy;
	}

	public function editStudyWithStudy($paramStudy){
		$DB = fnDBConn();

		$SQL = "UPDATE OPENING_STUDY AS OS SET
		OS.ID_INTERFACE_LANGUAGE = '$paramStudy->interfaceLanguageID',
		OS.NAME = '$paramStudy->name',
		OS.ABOUT = '$paramStudy->aboutStudy',
		OS.SIDE = '$paramStudy->side',
		OS.ID_OPENING_ECO = '$paramStudy->ecoID',
		OS.ID_USER = '$paramStudy->authorID',
		OS.ACTIVE = '$paramStudy->active',
		OS.DELETED = '$paramStudy->deleted'
WHERE OS.ID = '$paramStudy->id'";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Estudo editado.");
	}

}

?>

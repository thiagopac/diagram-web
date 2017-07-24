<?php
require_once("Eco.php");
require_once("Line.php");

class Variation {

	public $id;
	public $name;
	public $text;
	public $ecoID;
	public $dateCreated;
	public $studyID;
	public $deleted;

	public $eco;
	public $lines;

	static $showDeleted;
	static $whereDeleted;

	static $showLineDeleted;
	static $showPracticeLineDeleted;

	//construtor da classe
	public function __construct($array){

		self::$whereDeleted = self::$showDeleted == true ? "" : " AND OSTV.DELETED = 0";

		Line::$showDeleted = self::$showLineDeleted;
		Line::$showPracticeLineDeleted = self::$showPracticeLineDeleted;

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_VARIATION_ID'];
			$this->name = $array['OPENING_VARIATION_NAME'];
			$this->text = $array['OPENING_VARIATION_TEXT'];
			$this->dateCreated = $array['OPENING_VARIATION_DATE_CREATED'];
			$this->studyID = $array['OPENING_STUDY_ID'];
			$this->deleted = $array['OPENING_VARIATION_DELETED'];
			$this->ecoID = $array['OPENING_STUDY_ECO_ID'];

			$eco = new Eco();
			$this->eco = $eco->getEcoWithID($array['OPENING_STUDY_ECO_ID']);
		}
  }

	public function __destruct(){

	}

	public function getAllVariationsForStudy($paramStudy) {

		$DB = fnDBConn();

		$SQL = "SELECT OSTV.ID AS OPENING_VARIATION_ID,
       OSTV.NAME AS OPENING_VARIATION_NAME,
       OSTV.TEXT AS OPENING_VARIATION_TEXT,
       OSTV.DIN AS OPENING_VARIATION_DATE_CREATED,
       OSTV.ID_OPENING_STUDY AS OPENING_STUDY_ID,
			 OSTV.ID_OPENING_ECO AS OPENING_STUDY_ECO_ID,
			 OSTV.DELETED AS OPENING_VARIATION_DELETED
FROM OPENING_STUDY_THEORY_VARIATION AS OSTV
INNER JOIN OPENING_STUDY AS OS ON OS.ID = OSTV.ID_OPENING_STUDY
WHERE OS.ID = $paramStudy";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrVariations = [];


		foreach($RESULT as $KEY => $ROW){
			$variation = new Variation($ROW);

			$line = new Line();

			$variation->lines = $line->getAllLinesForVariation($variation->id);
			array_push($arrVariations, $variation);

			//limpando o array para iniciar vazio na próxima variation
			$arrLinesForVariation = [];
		}

		// var_dump($arrVariations);

		return $arrVariations;
	}

	public function getVariationWithID($variationID) {

		$DB = fnDBConn();

		$SQL = "SELECT OSTV.ID AS OPENING_VARIATION_ID,
       OSTV.NAME AS OPENING_VARIATION_NAME,
       OSTV.TEXT AS OPENING_VARIATION_TEXT,
       OSTV.DIN AS OPENING_VARIATION_DATE_CREATED,
       OSTV.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       OSTV.ID_OPENING_ECO AS OPENING_STUDY_ECO_ID,
			 OSTV.DELETED AS OPENING_VARIATION_DELETED
FROM OPENING_STUDY_THEORY_VARIATION AS OSTV
INNER JOIN OPENING_ECO AS OE ON OE.ID = OSTV.ID_OPENING_ECO
WHERE OSTV.ID = $variationID";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$variation = new Variation($RESULT);

		return $variation;
	}

	public function insertVariation($paramVariation){
		$DB = fnDBConn();

		$SQL = "INSERT INTO OPENING_STUDY_THEORY_VARIATION
		(NAME,
		TEXT,
		ID_OPENING_STUDY,
		ID_OPENING_ECO)
		VALUES('$paramVariation->name',
		'$paramVariation->text',
		'$paramVariation->studyID',
		'$paramVariation->ecoID')";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		// $paramVariation->id = $RET[1]; //esse array retorna na posição 0 o número de linhas afetadas pelo update e na posição 1 o id do regitro inserido

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Nova Variation criada.");

		return $RET;
	}

	public function editVariationForVariation($paramVariation){
		$DB = fnDBConn();

		$SQL = "UPDATE OPENING_STUDY_THEORY_VARIATION AS OSTV SET
		OSTV.NAME = '$paramVariation->name',
		OSTV.TEXT = '$paramVariation->text',
		OSTV.ID_OPENING_STUDY = '$paramVariation->studyID',
		OSTV.ID_OPENING_ECO = '$paramVariation->ecoID'
WHERE OSTV.ID = '$paramVariation->id'";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Variation editada.");
	}

}

?>

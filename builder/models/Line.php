<?php
require_once('PracticeLine.php');

class Line {

	public $id;
	public $name;
	public $text;
	public $pgn;
	public $dateCreated;
	public $variationID;
	public $nameVariation;
	public $studyID;
	public $practiceLines;
	public $deleted;

	static $showDeleted;
	static $whereDeleted;

	static $orderBy;

	static $showPracticeLineDeleted;

	//construtor da classe
	public function __construct($array){

		self::$whereDeleted = self::$showDeleted == true ? "" : " AND OSTL.DELETED = 0";

		PracticeLine::$showDeleted = self::$showPracticeLineDeleted;

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_LINE_ID'];
			$this->name = $array['OPENING_LINE_NAME'];
			$this->text = $array['OPENING_LINE_TEXT'];
			$this->pgn = $array['OPENING_LINE_PGN'];
			$this->dateCreated = $array['OPENING_LINE_DATE_CREATED'];
			$this->variationID = $array['OPENING_VARIATION_ID'];
			$this->nameVariation = $array['OPENING_VARIATION_NAME'];
			$this->studyID = $array['OPENING_STUDY_ID'];
			$this->deleted = $array['OPENING_LINE_DELETED'];
		}
  }

	public function __destruct(){

	}

	public function getAllLinesForStudy($paramStudy){

		$DB = fnDBConn();

		$SQL = "SELECT OSTL.ID AS OPENING_LINE_ID,
       OSTL.NAME AS OPENING_LINE_NAME,
       OSTL.TEXT AS OPENING_LINE_TEXT,
       OSTL.PGN AS OPENING_LINE_PGN,
       OSTL.DIN AS OPENING_LINE_DATE_CREATED,
       OSTL.DELETED AS OPENING_LINE_DELETED,
       OSTV.NAME AS OPENING_VARIATION_NAME,
       OSTV.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       OSTV.ID AS OPENING_VARIATION_ID
FROM OPENING_STUDY_THEORY_LINE AS OSTL
INNER JOIN OPENING_STUDY_THEORY_VARIATION AS OSTV ON OSTV.ID = OSTL.ID_OPENING_STUDY_THEORY_VARIATION
WHERE OSTV.ID_OPENING_STUDY = $paramStudy";

		$SQL = $SQL.self::$whereDeleted;

		$SQL = $SQL.self::$orderBy;

    $RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrLines = [];

		foreach($RESULT as $KEY => $ROW){
			$line = new Line($ROW);

			$practiceLine = new PracticeLine();
			$arrPracticeLines = $practiceLine->getPracticeLinesForLine($line->id);

			$line->practiceLines = $arrPracticeLines;

			array_push($arrLines, $line);
		}

		return $arrLines;
	}

	public function getAllLinesForVariation($paramVariation){

		$DB = fnDBConn();

		$SQL = "SELECT OSTL.ID AS OPENING_LINE_ID,
       OSTL.NAME AS OPENING_LINE_NAME,
       OSTL.TEXT AS OPENING_LINE_TEXT,
       OSTL.PGN AS OPENING_LINE_PGN,
       OSTL.DIN AS OPENING_LINE_DATE_CREATED,
       OSTL.DELETED AS OPENING_LINE_DELETED,
       OSTV.NAME AS OPENING_VARIATION_NAME,
       OSTV.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       OSTV.ID AS OPENING_VARIATION_ID
FROM OPENING_STUDY_THEORY_LINE AS OSTL
INNER JOIN OPENING_STUDY_THEORY_VARIATION AS OSTV ON OSTV.ID = OSTL.ID_OPENING_STUDY_THEORY_VARIATION
WHERE OSTV.ID = $paramVariation";

		$SQL = $SQL.self::$whereDeleted;

    $RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrLines = [];

		foreach($RESULT as $KEY => $ROW){
			$line = new Line($ROW);

			$practiceLine = new PracticeLine();
			$arrPracticeLines = $practiceLine->getPracticeLinesForLine($line->id);

			$line->practiceLines = $arrPracticeLines;

			array_push($arrLines, $line);
		}

		return $arrLines;
	}

	public function getLineWithID($paramLine){

		$DB = fnDBConn();

		$SQL = "SELECT OSTL.ID AS OPENING_LINE_ID,
       OSTL.NAME AS OPENING_LINE_NAME,
       OSTL.TEXT AS OPENING_LINE_TEXT,
       OSTL.PGN AS OPENING_LINE_PGN,
       OSTL.DIN AS OPENING_LINE_DATE_CREATED,
       OSTL.ID_OPENING_STUDY_THEORY_VARIATION AS OPENING_VARIATION_ID,
       OSTL.DELETED AS OPENING_LINE_DELETED
FROM OPENING_STUDY_THEORY_LINE AS OSTL
WHERE OSTL.ID = $paramLine";

		$SQL = $SQL.self::$whereDeleted;

    $RESULT = fnDB_DO_SELECT($DB,$SQL);

		$line = new Line($RESULT);

		return $line;
	}

	public function insertLine($paramLine){
		$DB = fnDBConn();

		$SQL = "INSERT INTO OPENING_STUDY_THEORY_LINE
		(NAME,
		TEXT,
		ID_OPENING_STUDY_THEORY_VARIATION,
		PGN)
		VALUES('$paramLine->name',
		'$paramLine->text',
		'$paramLine->variationID',
		'$paramLine->pgn')";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		// $paramLine->id = $RET[1]; //esse array retorna na posição 0 o número de linhas afetadas pelo update e na posição 1 o id do regitro inserido

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Nova Line criada.");

		return $RET;
	}

	public function editLineForLine($paramLine){
		$DB = fnDBConn();

		$SQL = "UPDATE OPENING_STUDY_THEORY_LINE AS OSTL SET
		OSTL.NAME = '$paramLine->name',
		OSTL.TEXT = '$paramLine->text',
		OSTL.ID_OPENING_STUDY_THEORY_VARIATION = '$paramLine->variationID',
		OSTL.PGN = '$paramLine->pgn'
WHERE OSTL.ID = '$paramLine->id'";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Linha editada.");
	}

}

?>

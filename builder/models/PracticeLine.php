<?php
require_once('Line.php');

class PracticeLine {

	public $id;
	public $pgn;
	public $practicePGN;
	public $lineID;
	public $dateCreated;
	public $deleted;

	static $showDeleted;
	static $whereDeleted;

	//propriedades usadas somente no modo Prática.. não popular no construtor
	public $lineName;
	public $variationName;

	//construtor da classe
	public function __construct($array){

		self::$whereDeleted = self::$showDeleted == true ? "" : " AND OSPL.DELETED = 0";

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_PRACTICE_LINE_ID'];
			$this->pgn = $array['OPENING_PRACTICE_LINE_PGN'];
			$this->lineID = $array['OPENING_LINE_ID'];
			$this->practicePGN = $this->getPracticePGNfromPGN($this->pgn);
			$this->dateCreated = $array['OPENING_PRACTICE_LINE_DATE_CREATED'];
			$this->deleted = $array['OPENING_PRACTICE_LINE_DELETED'];
		}
  }

	public function __destruct(){

	}

	public function getPracticeLinesForLine($paramLine){

		$DB = fnDBConn();

		$SQL = "SELECT OSPL.ID AS OPENING_PRACTICE_LINE_ID,
       OSPL.PGN AS OPENING_PRACTICE_LINE_PGN,
			 OSPL.ID_OPENING_STUDY_THEORY_LINE AS OPENING_LINE_ID,
       OSPL.DIN AS OPENING_PRACTICE_LINE_DATE_CREATED,
			 OSPL.DELETED AS OPENING_PRACTICE_LINE_DELETED,
       OSTL.ID AS OPENING_LINE_ID,
       OSTL.NAME AS OPENING_LINE_NAME,
       OSTL.TEXT AS OPENING_LINE_TEXT,
       OSTL.PGN AS OPENING_LINE_PGN,
       OSTL.DIN AS OPENING_LINE_DATE_CREATED
FROM OPENING_STUDY_PRACTICE_LINE AS OSPL
INNER JOIN OPENING_STUDY_THEORY_LINE AS OSTL ON OSTL.ID = OSPL.ID_OPENING_STUDY_THEORY_LINE
WHERE OSPL.ID_OPENING_STUDY_THEORY_LINE = $paramLine";

		$SQL = $SQL.self::$whereDeleted;

    $RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrPracticeLines = [];

		foreach($RESULT as $KEY => $ROW){
			$practiceLine = new PracticeLine($ROW);
			array_push($arrPracticeLines, $practiceLine);
		}

		return $arrPracticeLines;
	}

	public function getPracticeLineWithID($paramPracticeLine){

		$DB = fnDBConn();

		$SQL = "SELECT OSPL.ID AS OPENING_PRACTICE_LINE_ID,
       OSPL.PGN AS OPENING_PRACTICE_LINE_PGN,
			 OSPL.ID_OPENING_STUDY_THEORY_LINE AS OPENING_LINE_ID,
       OSPL.DIN AS OPENING_PRACTICE_LINE_DATE_CREATED,
			 OSPL.DELETED AS OPENING_PRACTICE_LINE_DELETED,
       OSTL.ID AS OPENING_LINE_ID,
       OSTL.NAME AS OPENING_LINE_NAME,
       OSTL.TEXT AS OPENING_LINE_TEXT,
       OSTL.PGN AS OPENING_LINE_PGN,
       OSTL.DIN AS OPENING_LINE_DATE_CREATED
FROM OPENING_STUDY_PRACTICE_LINE AS OSPL
INNER JOIN OPENING_STUDY_THEORY_LINE AS OSTL ON OSTL.ID = OSPL.ID_OPENING_STUDY_THEORY_LINE
WHERE OSPL.ID = $paramPracticeLine";

		$SQL = $SQL.self::$whereDeleted;

    $RESULT = fnDB_DO_SELECT($DB,$SQL);

		$practiceLine = new PracticeLine($RESULT);

		return $practiceLine;
	}

	public function getPracticeLineWithPracticePGN($paramPracticePGN){
	//encontra uma determinada PracticeLine a partir de seu PracticePGN (Ex: e4c5Nf3d6d4cxd4Nxd4Nf6Nc3a6 para Najdorf)

		$DB = fnDBConn();

		$SQL = "SELECT OSPL.ID AS OPENING_PRACTICE_LINE_ID,
			 OSPL.PGN AS OPENING_PRACTICE_LINE_PGN,
			 OSPL.ID_OPENING_STUDY_THEORY_LINE AS OPENING_LINE_ID,
			 OSPL.DIN AS OPENING_PRACTICE_LINE_DATE_CREATED,
			 OSPL.DELETED AS OPENING_PRACTICE_LINE_DELETED
FROM OPENING_STUDY_PRACTICE_LINE AS OSPL
WHERE OSPL.PGN = '$paramPracticePGN'";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$practiceLine = new PracticeLine($RESULT);

		return $practiceLine;
	}

	public function insertPracticeLine($paramPracticeLine){
		$DB = fnDBConn();

		$SQL = "INSERT INTO OPENING_STUDY_PRACTICE_LINE
		(ID_OPENING_STUDY_THEORY_LINE,
		PGN)
		VALUES('$paramPracticeLine->lineID',
		'$paramPracticeLine->pgn')";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		// $paramPracticeLine->id = $RET[1]; //esse array retorna na posição 0 o número de linhas afetadas pelo update e na posição 1 o id do regitro inserido

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Nova Practice Line criada.");

		return $RET;
	}

	public function editPracticeLineForPracticeLine($paramPracticeLine){
		$DB = fnDBConn();

		$SQL = "UPDATE OPENING_STUDY_PRACTICE_LINE AS OSPL SET
		OSPL.PGN = '$paramPracticeLine->pgn'
WHERE OSPL.ID = '$paramPracticeLine->id'";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Practice Line editada.");
	}

	public function deletePracticeLineForPracticeLine($paramPracticeLine){
		$DB = fnDBConn();

		$SQL = "UPDATE OPENING_STUDY_PRACTICE_LINE AS OSPL SET
		OSPL.DELETED = 1
WHERE OSPL.ID = '$paramPracticeLine->id'";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Practice Line deletada.");
	}

	//retira os números e espaços de um PGN.. ex 1. e4 c6 2. d4 d5 torna e4c6d4d5
	function getPracticePGNfromPGN($pgn){
		$pgn = preg_replace('(\d+. )', "", $pgn);
		$pgn = str_replace(" ", "", $pgn);

		return $pgn;
	}

}

?>

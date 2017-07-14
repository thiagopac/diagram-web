<?php
require_once('Line.php');

class PracticeLine {

	public $id;
	public $pgn;
	public $practicePGN;
	public $dateCreated;
	public $deleted;

	static $showDeleted;
	static $whereDeleted;

	//construtor da classe
	public function __construct($array){

		self::$whereDeleted = self::$showDeleted == true ? "" : " AND OSPL.DELETED = 0";

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_PRACTICE_LINE_ID'];
			$this->pgn = $array['OPENING_PRACTICE_LINE_PGN'];
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

	//retira os números e espaços de um PGN.. ex 1. e4 c6 2. d4 d5 torna e4c6d4d5
	function getPracticePGNfromPGN($pgn){
		$pgn = preg_replace('(\d+. )', "", $pgn);
		$pgn = str_replace(" ", "", $pgn);

		return $pgn;
	}

}

?>

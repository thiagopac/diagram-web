<?php

class TheoryHistory {

	public $id;
	public $text;
	public $dateCreated;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_THEORY_HISTORY_ID'];
			$this->text = $array['OPENING_THEORY_HISTORY_TEXT'];
			$this->dateCreated = $array['OPENING_THEORY_HISTORY_DATE_CREATED'];
		}
  }

	public function __destruct(){

	}

	public function getTheoryHistoryForStudy($paramStudy){

		$DB = fnDBConn();

		$SQL = "SELECT OSTH.ID AS OPENING_THEORY_HISTORY_ID,
			 OSTH.TEXT AS OPENING_THEORY_HISTORY_TEXT,
			 OSTH.DIN AS OPENING_THEORY_HISTORY_DATE_CREATED
FROM OPENING_STUDY_THEORY_HISTORY AS OSTH
WHERE ID_OPENING_STUDY = $paramStudy";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$theoryHistory = new TheoryHistory($RESULT);

		return $theoryHistory;
	}

}
?>

<?php

class TheoryHistory {

	public $id;
	public $text;
	public $dateCreated;
	public $studyID;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_THEORY_HISTORY_ID'];
			$this->text = $array['OPENING_THEORY_HISTORY_TEXT'];
			$this->dateCreated = $array['OPENING_THEORY_HISTORY_DATE_CREATED'];
			$this->studyID = $array['OPENING_STUDY_ID'];
		}
  }

	public function __destruct(){

	}

	public function getTheoryHistoryForStudy($paramStudy){

		$DB = fnDBConn();

		$SQL = "SELECT OSTH.ID AS OPENING_THEORY_HISTORY_ID,
			 OSTH.TEXT AS OPENING_THEORY_HISTORY_TEXT,
			 OSTH.DIN AS OPENING_THEORY_HISTORY_DATE_CREATED,
			 OSTH.ID_OPENING_STUDY AS OPENING_STUDY_ID
FROM OPENING_STUDY_THEORY_HISTORY AS OSTH
WHERE ID_OPENING_STUDY = $paramStudy";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$theoryHistory = new TheoryHistory($RESULT);

		return $theoryHistory;
	}

	public function insertTheoryHistory($paramTheoryHistory){
		$DB = fnDBConn();

		$SQL = "INSERT INTO OPENING_STUDY_THEORY_HISTORY
		(TEXT,
		ID_OPENING_STUDY)
		VALUES('$paramTheoryHistory->text',
		'$paramTheoryHistory->studyID')";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		// $paramTheoryHistory->id = $RET[1]; //esse array retorna na posição 0 o número de linhas afetadas pelo update e na posição 1 o id do regitro inserido

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Novo Theory History de estudo criado.");

		return $RET;
	}


	public function editTheoryHistoryForTheoryHistory($paramTheoryHistory){
		$DB = fnDBConn();

		$SQL = "UPDATE OPENING_STUDY_THEORY_HISTORY AS OSTH SET
		OSTH.TEXT = '$paramTheoryHistory->text'
WHERE OSTH.ID = '$paramTheoryHistory->id'";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Theory History de estudo editado.");
	}

}
?>

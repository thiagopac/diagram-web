<?php

class TheoryGameStyle {

	public $id;
	public $text;
	public $dateCreated;
	public $studyID;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_THEORY_GAME_STYLE_ID'];
			$this->text = $array['OPENING_THEORY_GAME_STYLE_TEXT'];
			$this->dateCreated = $array['OPENING_THEORY_GAME_STYLE_DATE_CREATED'];
			$this->studyID = $array['OPENING_STUDY_ID'];
		}
  }

	public function __destruct(){

	}

	public function getTheoryGameStyleForStudy($paramStudy){

		$DB = fnDBConn();

		$SQL = "SELECT OSGS.ID AS OPENING_THEORY_GAME_STYLE_ID,
			 OSGS.TEXT AS OPENING_THEORY_GAME_STYLE_TEXT,
			 OSGS.DIN AS OPENING_THEORY_GAME_STYLE_DATE_CREATED,
			 OSGS.ID_OPENING_STUDY AS OPENING_STUDY_ID
FROM OPENING_STUDY_THEORY_GAME_STYLE AS OSGS
WHERE ID_OPENING_STUDY = $paramStudy";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$theoryGameStyle = new TheoryGameStyle($RESULT);

		return $theoryGameStyle;
	}

	public function insertTheoryGameStyle($paramTheoryGameStyle){
		$DB = fnDBConn();

		$SQL = "INSERT INTO OPENING_STUDY_THEORY_GAME_STYLE
		(TEXT,
		ID_OPENING_STUDY)
		VALUES('$paramTheoryGameStyle->text',
		'$paramTheoryGameStyle->studyID')";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		// $paramTheoryGameStyle->id = $RET[1]; //esse array retorna na posição 0 o número de linhas afetadas pelo update e na posição 1 o id do regitro inserido

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Novo Theory Game Style de estudo criado.");

		return $RET;
	}


	public function editTheoryGameStyleForTheoryGameStyle($paramTheoryGameStyle){
		$DB = fnDBConn();

		$SQL = "UPDATE OPENING_STUDY_THEORY_GAME_STYLE AS OSGS SET
		OSGS.TEXT = '$paramTheoryGameStyle->text'
WHERE OSGS.ID = '$paramTheoryGameStyle->id'";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Theory Game Style de estudo editado.");
	}

}
?>

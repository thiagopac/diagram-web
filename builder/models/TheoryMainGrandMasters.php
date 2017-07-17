<?php

class TheoryMainGrandMasters {

	public $id;
	public $text;
	public $dateCreated;
	public $studyID;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_THEORY_MAIN_GRANDMASTERS_ID'];
			$this->text = $array['OPENING_THEORY_MAIN_GRANDMASTERS_TEXT'];
			$this->dateCreated = $array['OPENING_THEORY_MAIN_GRANDMASTERS_DATE_CREATED'];
			$this->studyID = $array['OPENING_STUDY_ID'];
		}
  }

	public function __destruct(){

	}

	public function getTheoryMainGrandMastersForStudy($paramStudy){

		$DB = fnDBConn();

		$SQL = "SELECT OSTMG.ID AS OPENING_THEORY_MAIN_GRANDMASTERS_ID,
			 OSTMG.TEXT AS OPENING_THEORY_MAIN_GRANDMASTERS_TEXT,
			 OSTMG.DIN AS OPENING_THEORY_MAIN_GRANDMASTERS_DATE_CREATED,
			 OSTMG.ID_OPENING_STUDY AS OPENING_STUDY_ID
FROM OPENING_STUDY_THEORY_MAIN_GRANDMASTERS AS OSTMG
WHERE ID_OPENING_STUDY = $paramStudy";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$theoryMainGrandMasters = new TheoryMainGrandMasters($RESULT);

		return $theoryMainGrandMasters;
	}

	public function insertTheoryMainGrandMasters($paramTheoryMainGrandMasters){
		$DB = fnDBConn();

		$SQL = "INSERT INTO OPENING_STUDY_THEORY_MAIN_GRANDMASTERS
		(TEXT,
		ID_OPENING_STUDY)
		VALUES('$paramTheoryMainGrandMasters->text',
		'$paramTheoryMainGrandMasters->studyID')";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		// $paramTheoryMainGrandMasters->id = $RET[1]; //esse array retorna na posição 0 o número de linhas afetadas pelo update e na posição 1 o id do regitro inserido

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Novo Theory Main Grand Masters de estudo criado.");

		return $RET;
	}

	public function editTheoryMainGrandMastersForTheoryMainGrandMasters($paramTheoryMainGrandMasters){
		$DB = fnDBConn();

		$SQL = "UPDATE OPENING_STUDY_THEORY_MAIN_GRANDMASTERS AS OSTMG SET
		OSTMG.TEXT = '$paramTheoryMainGrandMasters->text'
WHERE OSTMG.ID = '$paramTheoryMainGrandMasters->id'";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Theory Main Grand Masters de estudo editado.");
	}

}
?>

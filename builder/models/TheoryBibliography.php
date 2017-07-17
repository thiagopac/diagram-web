<?php

class TheoryBibliography {

	public $id;
	public $text;
	public $dateCreated;
	public $studyID;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_STUDY_BIBLIOGRAPHY_ID'];
			$this->text = $array['OPENING_STUDY_BIBLIOGRAPHY_TEXT'];
			$this->dateCreated = $array['OPENING_STUDY_BIBLIOGRAPHY_DATE_CREATED'];
			$this->studyID = $array['OPENING_STUDY_ID'];
		}
  }

	public function __destruct(){

	}

	public function getTheoryBibliographyForStudy($paramStudy){

		$DB = fnDBConn();

		$SQL = "SELECT OSTB.ID AS OPENING_STUDY_BIBLIOGRAPHY_ID,
       OSTB.TEXT AS OPENING_STUDY_BIBLIOGRAPHY_TEXT,
       OSTB.DIN AS OPENING_STUDY_BIBLIOGRAPHY_DATE_CREATED,
			 OSTB.ID_OPENING_STUDY AS OPENING_STUDY_ID
FROM OPENING_STUDY_THEORY_BIBLIOGRAPHY AS OSTB
WHERE ID_OPENING_STUDY = $paramStudy";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$theoryBibliography = new TheoryBibliography($RESULT);

		return $theoryBibliography;
	}

	public function insertTheoryBibliography($paramTheoryBibliography){
		$DB = fnDBConn();

		$SQL = "INSERT INTO OPENING_STUDY_THEORY_BIBLIOGRAPHY
		(TEXT,
		ID_OPENING_STUDY)
		VALUES('$paramTheoryBibliography->text',
		'$paramTheoryBibliography->studyID')";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		// $paramTheoryBibliography->id = $RET[1]; //esse array retorna na posição 0 o número de linhas afetadas pelo update e na posição 1 o id do regitro inserido

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Novo Theory Bibliography de estudo criado.");

		return $RET;
	}

	public function editTheoryBibliographyForTheoryBibliography($paramTheoryBibliography){
		$DB = fnDBConn();

		$SQL = "UPDATE OPENING_STUDY_THEORY_BIBLIOGRAPHY AS OSTB SET
		OSTB.TEXT = '$paramTheoryBibliography->text'
WHERE OSTB.ID = '$paramTheoryBibliography->id'";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Theory Main Grand Masters de estudo editado.");
	}

}
?>

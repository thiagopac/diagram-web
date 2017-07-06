<?php

class TheoryBibliography {

	public $id;
	public $text;
	public $dateCreated;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_STUDY_BIBLIOGRAPHY_ID'];
			$this->text = $array['OPENING_STUDY_BIBLIOGRAPHY_TEXT'];
			$this->dateCreated = $array['OPENING_STUDY_BIBLIOGRAPHY_DATE_CREATED'];
		}
  }

	public function __destruct(){

	}

	public function getTheoryBibliographyForStudy($paramStudy){

		$DB = fnDBConn();

		$SQL = "SELECT OSTB.ID AS OPENING_STUDY_BIBLIOGRAPHY_ID,
       OSTB.TEXT AS OPENING_STUDY_BIBLIOGRAPHY_TEXT,
       OSTB.DIN AS OPENING_STUDY_BIBLIOGRAPHY_DATE_CREATED
FROM OPENING_STUDY_THEORY_BIBLIOGRAPHY AS OSTB
WHERE ID_OPENING_STUDY = $paramStudy";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$theoryBibliography = new TheoryBibliography($RESULT);

		return $theoryBibliography;
	}

}
?>

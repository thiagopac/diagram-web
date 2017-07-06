<?php

class TheoryMainGrandMasters {

	public $id;
	public $text;
	public $dateCreated;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_THEORY_MAIN_GRANDMASTERS_ID'];
			$this->text = $array['OPENING_THEORY_MAIN_GRANDMASTERS_TEXT'];
			$this->dateCreated = $array['OPENING_THEORY_MAIN_GRANDMASTERS_DATE_CREATED'];
		}
  }

	public function __destruct(){

	}

	public function getTheoryMainGrandMastersForStudy($paramStudy){

		$DB = fnDBConn();

		$SQL = "SELECT OSTMG.ID AS OPENING_THEORY_MAIN_GRANDMASTERS_ID,
			 OSTMG.TEXT AS OPENING_THEORY_MAIN_GRANDMASTERS_TEXT,
			 OSTMG.DIN AS OPENING_THEORY_MAIN_GRANDMASTERS_DATE_CREATED
FROM OPENING_STUDY_THEORY_MAIN_GRANDMASTERS AS OSTMG
WHERE ID_OPENING_STUDY = $paramStudy";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$theoryMainGrandMasters = new TheoryMainGrandMasters($RESULT);

		return $theoryMainGrandMasters;
	}

}
?>

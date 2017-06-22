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

}
?>

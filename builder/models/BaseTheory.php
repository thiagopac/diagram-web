<?php
require_once('TheoryBibliography.php');
require_once('TheoryGameStyle.php');
require_once('TheoryHistory.php');
require_once('TheoryMainGrandMasters.php');

class BaseTheory {

	public $idStudy;
	public $theoryBibliography;
	public $theoryGameStyle;
	public $theoryHistory;
	public $theoryMainGrandMasters;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->idStudy = $array['OPENING_STUDY_ID'];
			$this->theoryBibliography = new TheoryBibliography($array);
			$this->theoryGameStyle = new TheoryGameStyle($array);
			$this->theoryHistory = new TheoryHistory($array);
			$this->theoryMainGrandMasters = new TheoryMainGrandMasters($array);
		}
  }

	public function __destruct(){

	}

}

?>

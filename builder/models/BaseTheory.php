<?php
require_once('TheoryBibliography.php');
require_once('TheoryGameStyle.php');
require_once('TheoryHistory.php');
require_once('TheoryMainGrandMasters.php');

class BaseTheory {

	public $studyID;
	public $theoryBibliography;
	public $theoryGameStyle;
	public $theoryHistory;
	public $theoryMainGrandMasters;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->studyID = $array['OPENING_STUDY_ID'];
			$this->theoryBibliography = new TheoryBibliography($array);
			$this->theoryGameStyle = new TheoryGameStyle($array);
			$this->theoryHistory = new TheoryHistory($array);
			$this->theoryMainGrandMasters = new TheoryMainGrandMasters($array);
		}
  }

	public function __destruct(){

	}

	public function getBaseTheoryForStudy($paramStudy){

		$baseTheory = new BaseTheory();

		$baseTheory->studyID = $paramStudy;

		$theoryBibliography = new TheoryBibliography();
		$baseTheory->theoryBibliography = $theoryBibliography->getTheoryBibliographyForStudy($paramStudy);

		$theoryGameStyle = new TheoryGameStyle();
		$baseTheory->theoryGameStyle = $theoryGameStyle->getTheoryGameStyleForStudy($paramStudy);

		$theoryHistory = new TheoryHistory();
		$baseTheory->theoryHistory = $theoryHistory->getTheoryHistoryForStudy($paramStudy);

		$theoryMainGrandMasters = new TheoryMainGrandMasters();
		$baseTheory->theoryMainGrandMasters = $theoryMainGrandMasters->getTheoryMainGrandMastersForStudy($paramStudy);

		return $baseTheory;
	}

}

?>

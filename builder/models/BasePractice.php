<?php
require_once('Variation.php');
require_once('Eco.php');
require_once('Line.php');
require_once('PracticeLine.php');

class BasePractice {

	public $practicePGNs;

	public $studyID;
	public $diagramLines;
	public $openingBook;

	//construtor da classe
	public function __construct($paramStudy){

		$this->studyID = $paramStudy;

		$line = new Line();
		$arrLines = $line->getAllLinesForStudy($this->studyID);

		$arrPracticePGNs = [];

		foreach($arrLines as $KEY => $line){

			foreach ($line->practiceLines as $key => $PracticeLine) {
				array_push($arrPracticePGNs, $PracticeLine->practicePGN);
			}
		}

		$this->practicePGNs = $arrPracticePGNs;
  }

	public function __destruct(){

	}

}

?>

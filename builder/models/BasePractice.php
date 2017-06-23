<?php
require_once('Variation.php');
require_once('Eco.php');
require_once('Line.php');
require_once('PracticeLine.php');

class BasePractice {

	public $studyEcoPracticeLine;
	public $practicePGNs;

	public $idStudy;
	public $diagramLines;
	public $openingBook;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->idStudy = $array['OPENING_STUDY_ID'];

			// $variarion = new Variation();
			//   	$arrVariations = $variarion->getAllVariationsForStudy($this->idStudy);

			$eco = new Eco();
			$eco = $eco->getEcoForStudy($this->idStudy);
			$this->studyEcoPracticeLine = $eco->ecoPracticeLine;

			$line = new Line();
			$arrLines = $line->getAllLinesForStudy($this->idStudy);

			$arrPracticePGNs = [];

			foreach($arrLines as $KEY => $line){

				foreach ($line->practiceLines as $key => $PracticeLine) {
					array_push($arrPracticePGNs, $PracticeLine->practicePGN);
				}
			}

			$this->practicePGNs = $arrPracticePGNs;

			// var_dump();

			// foreach ($this->variations as $key => $variation) {
			//
			// }
		}
  }

	public function __destruct(){

	}

}

?>

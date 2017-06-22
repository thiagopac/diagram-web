<?php
require_once("Line.php");

class Variation {

	public $id;
	public $name;
	public $text;
	public $dateCreated;
	public $idStudy;
	public $lines;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_VARIATION_ID'];
			$this->name = $array['OPENING_VARIATION_NAME'];
			$this->text = $array['OPENING_VARIATION_TEXT'];
			$this->dateCreated = $array['OPENING_VARIATION_DATE_CREATED'];
			$this->idStudy = $array['OPENING_STUDY_ID'];
		}
  }

	public function __destruct(){

	}

	public function getAllVariationsForStudy($paramStudy) {

		$DB = fnDBConn();

		$SQLLISTAVARIATIONS = "SELECT OSTV.ID AS OPENING_VARIATION_ID, OSTV.NAME AS OPENING_VARIATION_NAME, OSTV.TEXT AS OPENING_VARIATION_TEXT, OSTV.DIN AS OPENING_VARIATION_DATE_CREATED,
						OSTV.ID_OPENING_STUDY AS OPENING_STUDY_ID
						FROM OPENING_STUDY_THEORY_VARIATION AS OSTV
						INNER JOIN OPENING_STUDY AS OS ON OS.ID = OSTV.ID_OPENING_STUDY
						WHERE OS.ID = $paramStudy";

		$RESULTLISTAVARIATIONS = fnDB_DO_SELECT_WHILE($DB,$SQLLISTAVARIATIONS);

		$arrVariations = [];


		foreach($RESULTLISTAVARIATIONS as $KEY => $ROW){
			$variation = new Variation($ROW);

			$line = new Line();

			$variation->lines = $line->getAllLinesForVariation($variation->id);
			array_push($arrVariations, $variation);

			//limpando o array para iniciar vazio na próxima variation
			$arrLinesForVariation = [];
		}

		return $arrVariations;
	}

	public function getVariationWithID($variationID) {

		$DB = fnDBConn();

		$SQL = "SELECT OSTV.ID AS OPENING_VARIATION_ID, OSTV.NAME AS OPENING_VARIATION_NAME, OSTV.TEXT AS OPENING_VARIATION_TEXT, OSTV.DIN AS OPENING_VARIATION_DATE_CREATED,
						OSTV.ID_OPENING_STUDY AS OPENING_STUDY_ID
						FROM OPENING_STUDY_THEORY_VARIATION AS OSTV
						WHERE OSTV.ID = $variationID";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$variation = new Variation($RESULT);

		return $variation;
	}

}
?>

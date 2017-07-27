<?php

class Eco {

	public $id;
	public $code;
	public $name;
	public $line;
	public $ecoPracticeLine;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_STUDY_ECO_ID'];
			$this->code = $array['OPENING_STUDY_ECO_CODE'];
			$this->name = $array['OPENING_STUDY_ECO_NAME'];
			$this->line = $array['OPENING_STUDY_ECO_LINE'];
			$this->ecoPracticeLine = $this->getPracticePGNfromPGN($this->line);
		}
  }

	public function __destruct(){

	}

	public function getEcoWithID($paramEco){

		$DB = fnDBConn();

		$SQL = "SELECT OE.ID AS OPENING_STUDY_ECO_ID,
       OE.CODE AS OPENING_STUDY_ECO_CODE,
       OE.NAME AS OPENING_STUDY_ECO_NAME,
       OE.LINE AS OPENING_STUDY_ECO_LINE
FROM OPENING_ECO AS OE
WHERE OE.ID = $paramEco";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$eco = new Eco($RESULT);

		return $eco;
	}

	public function getAllEcos(){

		$DB = fnDBConn();

		$SQL = "SELECT OE.ID AS OPENING_STUDY_ECO_ID,
       OE.CODE AS OPENING_STUDY_ECO_CODE,
       OE.NAME AS OPENING_STUDY_ECO_NAME,
       OE.LINE AS OPENING_STUDY_ECO_LINE
FROM OPENING_ECO AS OE
WHERE 1";

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrEcos = [];

		foreach($RESULT as $KEY => $ROW){
			$eco = new Eco($ROW);
			array_push($arrEcos, $eco);
		}

		return $arrEcos;
	}

	public function getEcoForVariation($paramVariation){

		$DB = fnDBConn();

		$SQL = "SELECT OE.ID AS OPENING_STUDY_ECO_ID,
       OE.CODE AS OPENING_STUDY_ECO_CODE,
       OE.NAME AS OPENING_STUDY_ECO_NAME,
       OE.LINE AS OPENING_STUDY_ECO_LINE
FROM OPENING_ECO AS OE
INNER JOIN OPENING_STUDY_THEORY_VARIATION AS OSTV ON OSTV.ID_OPENING_ECO = OE.ID
WHERE OSTV.ID = $paramVariation";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$eco = new Eco($RESULT);

		return $eco;
	}

	//retira os números e espaços de um PGN.. ex 1. e4 c6 2. d4 d5 torna e4c6d4d5
	function getPracticePGNfromPGN($pgn){
		$pgn = preg_replace('(\d+. )', "", $pgn);
		$pgn = str_replace(" ", "", $pgn);

		return $pgn;
	}

}
?>

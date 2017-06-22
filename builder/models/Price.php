<?php

class Price {

	public $id;
	public $value;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['PRICE_ID'];
			$this->value = $array['PRICE_VALUE'];
		}
  }

	public function __destruct(){

	}

	public function getAllPrices(){

		$DB = fnDBConn();

		$SQL = "SELECT PR.ID AS PRICE_ID, PR.VALUE AS PRICE_VALUE
						FROM PRICE PR
						WHERE 1";

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrPrices = [];

		foreach($RESULT as $KEY => $ROW){
			$price = new Price($ROW);
			array_push($arrPrices, $price);
		}

		return $arrPrices;
	}

}
?>

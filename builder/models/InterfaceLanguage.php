<?php

class InterfaceLanguage {

	public $id;
	public $code;
	public $name;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['INTERFACE_LANGUAGE_ID'];
			$this->code = $array['INTERFACE_LANGUAGE_CODE'];
			$this->name = $array['INTERFACE_LANGUAGE_NAME'];
		}
  }

	public function __destruct(){

	}

	public function getAllInterfaceLanguages(){

		$DB = fnDBConn();

		$SQL = "SELECT INTLAN.ID AS INTERFACE_LANGUAGE_ID, INTLAN.CODE AS INTERFACE_LANGUAGE_CODE, INTLAN.NAME AS INTERFACE_LANGUAGE_NAME
						FROM INTERFACE_LANGUAGE AS INTLAN
						WHERE 1";

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrInterfaceLanguages = [];

		foreach($RESULT as $KEY => $ROW){
			$interfaceLanguage = new InterfaceLanguage($ROW);
			array_push($arrInterfaceLanguages, $interfaceLanguage);
		}

		return $arrInterfaceLanguages;
	}

}
?>

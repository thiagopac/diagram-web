<?php

class Country {

	public $id;
	public $code;
	public $name;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['COUNTRY_ID'];
			$this->code = $array['COUNTRY_CODE'];
			$this->name = $array['COUNTRY_NAME'];
		}
  }

	public function __destruct(){

	}

}
?>

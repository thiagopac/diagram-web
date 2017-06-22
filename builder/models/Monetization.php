<?php
require_once('DetailsPayment.php');
require_once('Price.php');
require_once('Currency.php');

class Monetization {

	public $id;
	public $currency;
	public $dateCreated;
	public $detailsPayment;
	public $price;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_STUDY_PRICE_ID'];
			$this->value = $array['OPENING_STUDY_PRICE_DATE_CREATED'];

			$this->currency = new Currency($array);

			$this->price = new Price($array);

			$this->detailsPayment = new DetailsPayment($array);
		}
  }

	public function __destruct(){

	}

}
?>

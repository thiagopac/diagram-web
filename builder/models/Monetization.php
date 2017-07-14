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
			$this->id = $array['OPENING_STUDY_MONETIZATION_ID'];
			$this->value = $array['OPENING_STUDY_MONETIZATION_DATE_CREATED'];

			$currency = new Currency();
			$this->currency = $currency->getCurrencyWithID($array['CURRENCY_ID']);

			$price = new Price();
			$this->price = $price->getPriceWithID($array['PRICE_ID']);

			$detailsPayment = new DetailsPayment();
			$this->detailsPayment = $detailsPayment->getDetailsPaymentWithID($array['OPENING_STUDY_DETAILS_PAYMENT_ID']);
		}
  }

	public function __destruct(){

	}

	public function getMonetizationWithID($paramMonetization){

			$DB = fnDBConn();

			$SQL = "SELECT OSM.ID AS OPENING_STUDY_MONETIZATION_ID,
			 OSM.CURRENCY AS CURRENCY_ID,
			 OSM.ID_OPENING_STUDY AS OPENING_STUDY_ID,
			 OSM.DIN AS OPENING_STUDY_MONETIZATION_DATE_CREATED,
			 OSM.ID_DETAILS_PAYMENT AS OPENING_STUDY_DETAILS_PAYMENT_ID,
			 OSM.ID_PRICE AS PRICE_ID
FROM OPENING_STUDY_MONETIZATION AS OSM
WHERE OSM.ID = $paramMonetization";

			$RESULT = fnDB_DO_SELECT($DB,$SQL);

			$monetization = new Monetization($RESULT);

			return $monetization;
	}

	public function getMonetizationForStudy($paramStudy){

			$DB = fnDBConn();

    	$SQL = "SELECT OSM.ID AS OPENING_STUDY_MONETIZATION_ID,
       OSM.CURRENCY AS CURRENCY_ID,
       OSM.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       OSM.DIN AS OPENING_STUDY_MONETIZATION_DATE_CREATED,
       OSM.ID_DETAILS_PAYMENT AS OPENING_STUDY_DETAILS_PAYMENT_ID,
       OSM.ID_PRICE AS PRICE_ID
FROM OPENING_STUDY_MONETIZATION AS OSM
WHERE OSM.ID_OPENING_STUDY = $paramStudy";

			$RESULT = fnDB_DO_SELECT($DB,$SQL);

			$monetization = new Monetization($RESULT);

			return $monetization;
	}

}
?>

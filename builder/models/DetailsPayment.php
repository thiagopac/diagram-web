<?php
require_once('PaymentSystem.php');

class DetailsPayment {

	public $id;
	public $text;
	public $dateCreated;
	public $url;
	public $paymentSystem;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_STUDY_DETAILS_PAYMENT_ID'];
			$this->text = $array['OPENING_STUDY_DETAILS_PAYMENT_TEXT'];
			$this->dateCreated = $array['OPENING_STUDY_DETAILS_PAYMENT_DATE_CREATED'];
			$this->url = $array['OPENING_STUDY_DETAILS_PAYMENT_URL'];

			$paymentSystem = new PaymentSystem();
			$this->paymentSystem = $paymentSystem->getPaymentSystemWithID($array['PAYMENT_SYSTEM_ID']);
		}
  }

	public function __destruct(){

	}

	public function getDetailsPaymentWithID($paramDetailsPayment){

		$DB = fnDBConn();

		$SQL = "SELECT OSDP.ID AS OPENING_STUDY_DETAILS_PAYMENT_ID,
       OSDP.TEXT AS OPENING_STUDY_DETAILS_PAYMENT_TEXT,
       OSDP.DIN AS OPENING_STUDY_DETAILS_PAYMENT_DATE_CREATED,
       OSDP.URL AS OPENING_STUDY_DETAILS_PAYMENT_URL,
       OSDP.ID_TYPE_PAYMENT AS PAYMENT_SYSTEM_ID
FROM OPENING_STUDY_DETAILS_PAYMENT AS OSDP
WHERE OSDP.ID = $paramDetailsPayment";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$detailsPayment = new DetailsPayment($RESULT);

		return $detailsPayment;
	}

	public function getDetailsPaymentForStudy($paramStudy){

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

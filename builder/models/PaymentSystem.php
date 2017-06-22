<?php

class PaymentSystem {

	public $id;
	public $desc;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['PAYMENT_SYSTEM_ID'];
			$this->desc = $array['PAYMENT_SYSTEM_DESC'];
		}
  }

	public function __destruct(){

	}

	public function getAllPaymentSystems(){

		$DB = fnDBConn();

		$SQL = "SELECT PS.ID AS PAYMENT_SYSTEM_ID, PS.DESC AS PAYMENT_SYSTEM_DESC
						FROM TYPE_PAYMENT AS PS
						WHERE 1";

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrPaymentSystems = [];

		foreach($RESULT as $KEY => $ROW){
			$paymentSystem = new PaymentSystem($ROW);
			array_push($arrPaymentSystems, $paymentSystem);
		}

		return $arrPaymentSystems;
	}

}
?>

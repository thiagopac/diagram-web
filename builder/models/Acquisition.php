<?php

class Acquisition {

	public $id;
	public $idStudy;
	public $idUser;
	public $active;
	public $approvingUser;
	public $dateCreated;
	public $idMonetization;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_STUDY_ACQUISITION_ID'];
			$this->idStudy = $array['OPENING_STUDY_ID'];
			$this->idUser = $array['USER_ID'];
			$this->active = $array['OPENING_STUDY_ACQUISITION_ACTIVE'];
			$this->approvingUser = $array['OPENING_STUDY_ACQUISITION_APPROVING_USER_ID'];
			$this->dateCreated = $array['OPENING_STUDY_ACQUISITION_DATE_CREATED'];
			$this->idMonetization = $array['OPENING_STUDY_MONETIZATION_ID'];
		}
  }

	public function __destruct(){

	}

	public function getAcquisitionForUserAndStudy($paramUser, $paramStudy){

		$DB = fnDBConn();

		$SQL = "SELECT OSACQ.ID AS OPENING_STUDY_ACQUISITION_ID,
       OSACQ.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       OSACQ.ID_USER AS USER_ID,
       OSACQ.ACTIVE AS OPENING_STUDY_ACQUISITION_ACTIVE,
       OSACQ.APPROVING_USER AS OPENING_STUDY_ACQUISITION_APPROVING_USER_ID,
       OSACQ.DIN AS OPENING_STUDY_ACQUISITION_DATE_CREATED,
       OSACQ.ID_OPENING_STUDY_MONETIZATION AS OPENING_STUDY_MONETIZATION_ID
FROM OPENING_STUDY_ACQUISITION AS OSACQ
WHERE OSACQ.ID_USER = $paramUser
  AND OSACQ.ID_OPENING_STUDY = $paramStudy";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$acquisition = new Acquisition($RESULT);

		return $acquisition;
	}

}
?>

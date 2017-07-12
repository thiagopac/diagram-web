<?php

class Acquisition {

	public $id;
	public $studyID;
	public $userID;
	public $active;
	public $approvingUser;
	public $dateCreated;
	public $monetizationID;
	public $deleted;

	static $showDeleted;
	static $whereDeleted;

	//construtor da classe
	public function __construct($array){

		self::$whereDeleted = self::$showDeleted == true ? "" : " AND OSACQ.DELETED = 0";

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_STUDY_ACQUISITION_ID'];
			$this->studyID = $array['OPENING_STUDY_ID'];
			$this->userID = $array['USER_ID'];
			$this->active = $array['OPENING_STUDY_ACQUISITION_ACTIVE'];
			$this->approvingUser = $array['OPENING_STUDY_ACQUISITION_APPROVING_USER_ID'];
			$this->dateCreated = $array['OPENING_STUDY_ACQUISITION_DATE_CREATED'];
			$this->monetizationID = $array['OPENING_STUDY_MONETIZATION_ID'];
			$this->deleted = $array['OPENING_STUDY_ACQUISITION_DELETED'];
		}
  }

	public function __destruct(){

	}

	public function getAcquisitionWithID($paramAcquisition){

		$DB = fnDBConn();

		$SQL = "SELECT OSACQ.ID AS OPENING_STUDY_ACQUISITION_ID,
			 OSACQ.ID_OPENING_STUDY AS OPENING_STUDY_ID,
			 OSACQ.ID_USER AS USER_ID,
			 OSACQ.ACTIVE AS OPENING_STUDY_ACQUISITION_ACTIVE,
			 OSACQ.APPROVING_USER AS OPENING_STUDY_ACQUISITION_APPROVING_USER_ID,
			 OSACQ.DIN AS OPENING_STUDY_ACQUISITION_DATE_CREATED,
			 OSACQ.ID_OPENING_STUDY_MONETIZATION AS OPENING_STUDY_MONETIZATION_ID,
			 OSACQ.DELETED AS OPENING_STUDY_ACQUISITION_DELETED
FROM OPENING_STUDY_ACQUISITION AS OSACQ
WHERE OSACQ.ID = $paramAcquisition";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$acquisition = new Acquisition($RESULT);

		return $acquisition;
	}

	public function getAcquisitionForUserAndStudy($paramUser, $paramStudy){

		$DB = fnDBConn();

		$SQL = "SELECT OSACQ.ID AS OPENING_STUDY_ACQUISITION_ID,
       OSACQ.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       OSACQ.ID_USER AS USER_ID,
       OSACQ.ACTIVE AS OPENING_STUDY_ACQUISITION_ACTIVE,
       OSACQ.APPROVING_USER AS OPENING_STUDY_ACQUISITION_APPROVING_USER_ID,
       OSACQ.DIN AS OPENING_STUDY_ACQUISITION_DATE_CREATED,
       OSACQ.ID_OPENING_STUDY_MONETIZATION AS OPENING_STUDY_MONETIZATION_ID,
			 OSACQ.DELETED AS OPENING_STUDY_ACQUISITION_DELETED
FROM OPENING_STUDY_ACQUISITION AS OSACQ
WHERE OSACQ.ID_USER = $paramUser
AND OSACQ.ID_OPENING_STUDY = $paramStudy";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$acquisition = new Acquisition($RESULT);

		return $acquisition;
	}

	public function getAllAcquisitions(){

		$DB = fnDBConn();

		$SQL = "SELECT OSACQ.ID AS OPENING_STUDY_ACQUISITION_ID,
			 OSACQ.ID_OPENING_STUDY AS OPENING_STUDY_ID,
			 OSACQ.ID_USER AS USER_ID,
			 OSACQ.ACTIVE AS OPENING_STUDY_ACQUISITION_ACTIVE,
			 OSACQ.APPROVING_USER AS OPENING_STUDY_ACQUISITION_APPROVING_USER_ID,
			 OSACQ.DIN AS OPENING_STUDY_ACQUISITION_DATE_CREATED,
			 OSACQ.ID_OPENING_STUDY_MONETIZATION AS OPENING_STUDY_MONETIZATION_ID,
			 OSACQ.DELETED AS OPENING_STUDY_ACQUISITION_DELETED
FROM OPENING_STUDY_ACQUISITION AS OSACQ
WHERE 1";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrAcquisition = [];

		foreach ($RESULT as $KEY => $ROW) {
			$acquisition = new Acquisition($ROW);
			array_push($arrAcquisition, $acquisition);
		}

		return $arrAcquisition;
	}

}
?>

<?php
require_once('User.php');
require_once('Study.php');

class StudyAdministration {

	public $id;
	public $message;
	public $dateCreated;
	public $user;
	public $study;
	public $read;
	public $deleted;

	static $showDeleted;
	static $whereDeleted;

	//construtor da classe
	public function __construct($array){

		self::$whereDeleted = self::$showDeleted == true ? "" : " AND OSADM.DELETED = 0";

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_STUDY_ADMINISTRATION_ID'];
			$this->message = $array['OPENING_STUDY_ADMINISTRATION_MESSAGE'];
			$this->dateCreated = $array['OPENING_STUDY_ADMINISTRATION_DATE_CREATED'];

			$user = new User();
			$this->user = $user->getUserWithId($array['USER_ID']);

			$study = new Study();
			$this->study = $study->getBasicDataStudyWithID($array['OPENING_STUDY_ID']);

			$this->read = $array['OPENING_STUDY_ADMINISTRATION_READ'];

			$this->deleted = $array['OPENING_STUDY_ADMINISTRATION_DELETED'];
		}
  }

	public function __destruct(){

	}

	public function getStudyAdministrationWithIDForUser($paramStudyAdministration, $paramUser){

		$DB = fnDBConn();

		$SQL = "SELECT OSADM.ID AS OPENING_STUDY_ADMINISTRATION_ID,
	       OSADM.MESSAGE AS OPENING_STUDY_ADMINISTRATION_MESSAGE,
	       OSADM.DIN AS OPENING_STUDY_ADMINISTRATION_DATE_CREATED,
	       OSADM.ID_USER AS USER_ID,
	       OSADM.ID_OPENING_STUDY AS OPENING_STUDY_ID,
	       OSADM.READ AS OPENING_STUDY_ADMINISTRATION_READ,
				 OSADM.DELETED AS OPENING_STUDY_ADMINISTRATION_DELETED
	FROM OPENING_STUDY_ADMINISTRATION OSADM
	INNER JOIN OPENING_STUDY AS OS ON OS.ID = OSADM.ID_OPENING_STUDY
	WHERE OSADM.ID = $paramStudyAdministration
	AND OS.ID_USER = $paramUser";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$studyAdministration = new StudyAdministration($RESULT);

		return $studyAdministration;
	}

	public function getAllStudyAdministrations(){

		$DB = fnDBConn();

		$SQL = "SELECT OSADM.ID AS OPENING_STUDY_ADMINISTRATION_ID,
       OSADM.MESSAGE AS OPENING_STUDY_ADMINISTRATION_MESSAGE,
       OSADM.DIN AS OPENING_STUDY_ADMINISTRATION_DATE_CREATED,
       OSADM.ID_USER AS USER_ID,
       OSADM.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       OSADM.READ AS OPENING_STUDY_ADMINISTRATION_READ,
			 OSADM.DELETED AS OPENING_STUDY_ADMINISTRATION_DELETED
FROM OPENING_STUDY_ADMINISTRATION OSADM
WHERE 1";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrSturyAdministrations = [];

		foreach($RESULT as $KEY => $ROW){
			$studyAdministration = new StudyAdministration($ROW);
			array_push($arrSturyAdministrations, $studyAdministration);
		}

		return $arrSturyAdministrations;
	}

	public function getAllStudyAdministrationsForAuthor($paramUser){

		$DB = fnDBConn();

		$SQL = "SELECT OSADM.ID AS OPENING_STUDY_ADMINISTRATION_ID,
	       OSADM.MESSAGE AS OPENING_STUDY_ADMINISTRATION_MESSAGE,
	       OSADM.DIN AS OPENING_STUDY_ADMINISTRATION_DATE_CREATED,
	       OSADM.ID_USER AS USER_ID,
	       OSADM.ID_OPENING_STUDY AS OPENING_STUDY_ID,
	       OSADM.READ AS OPENING_STUDY_ADMINISTRATION_READ,
				 OSADM.DELETED AS OPENING_STUDY_ADMINISTRATION_DELETED
FROM OPENING_STUDY_ADMINISTRATION OSADM
INNER JOIN OPENING_STUDY AS OS ON OS.ID = OSADM.ID_OPENING_STUDY
WHERE OS.ID_USER = $paramUser";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrStudyAdministrations = [];

		foreach($RESULT as $KEY => $ROW){
			$studyAdministration = new StudyAdministration($ROW);
			array_push($arrStudyAdministrations, $studyAdministration);
		}

		return $arrStudyAdministrations;
	}

	public function getAllStudyAdministrationsForStudy($paramStudy){

		$DB = fnDBConn();

		$SQL = "SELECT OSADM.ID AS OPENING_STUDY_ADMINISTRATION_ID,
	       OSADM.MESSAGE AS OPENING_STUDY_ADMINISTRATION_MESSAGE,
	       OSADM.DIN AS OPENING_STUDY_ADMINISTRATION_DATE_CREATED,
	       OSADM.ID_USER AS USER_ID,
	       OSADM.ID_OPENING_STUDY AS OPENING_STUDY_ID,
	       OSADM.READ AS OPENING_STUDY_ADMINISTRATION_READ,
				 OSADM.DELETED AS OPENING_STUDY_ADMINISTRATION_DELETED
FROM OPENING_STUDY_ADMINISTRATION OSADM
WHERE OSADM.ID_OPENING_STUDY = $paramStudy";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrSturyAdministrations = [];

		foreach($RESULT as $KEY => $ROW){
			$studyAdministration = new StudyAdministration($ROW);
			array_push($arrSturyAdministrations, $studyAdministration);
		}

		return $arrSturyAdministrations;
	}

}
?>

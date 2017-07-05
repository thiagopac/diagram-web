<?php
require_once('Country.php');
require_once('Language.php');

class User {

	public $id;
	public $login;
	public $firstName;
	public $lastName;
	public $fullName;
	public $avatar;
	public $eloFide;
	public $status;
	public $birthday;
	public $dateCreated;
	public $dateLastLogin;
	public $typeUser;
	public $country;
	public $language;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['USER_ID'];
			$this->login = $array['USER_LOGIN'];
			$this->firstName = $array['USER_FIRSTNAME'];
			$this->lastName = $array['USER_LASTNAME'];
			$this->avatar = $array['USER_AVATAR'];
			$this->eloFide = $array['USER_ELO_FIDE'];
			$this->status = $array['USER_STATUS'];
			$this->birthday = $array['USER_BIRTHDAY'];
			$this->dateCreated = $array['USER_DATE_CREATED'];
			$this->dateLastLogin = $array['USER_LAST_LOGIN'];
			$this->typeUser = $array['USER_TYPE_USER'];

			$this->fullName = $this->firstName." ".$this->lastName;

			$this->country = new Country($array);
			$this->language = new Language($array);
		}
  }

	public function __destruct(){

	}

	public function getAllUsers(){

		$DB = fnDBConn();

		$SQL = "SELECT U.ID AS USER_ID,
       U.LOGIN AS USER_LOGIN,
       U.FIRSTNAME AS USER_FIRSTNAME,
       U.LASTNAME AS USER_LASTNAME,
       U.AVATAR AS USER_AVATAR,
       U.GRANTS AS USER_GRANTS,
       U.ELO_FIDE AS USER_ELO_FIDE,
       U.STATUS AS USER_STATUS,
       U.BIRTHDAY AS USER_BIRTHDAY,
       U.DIN AS USER_DATE_CREATED,
       U.DIN_LAST_LOGIN AS USER_LAST_LOGIN,
       U.ID_TYPE_USER AS USER_TYPE_USER,
       U.ID_COUNTRY AS COUNTRY_ID,
       CNT.CODE AS COUNTRY_CODE,
       CNT.NAME AS COUNTRY_NAME,
       ID_FIRST_LANGUAGE AS LANGUAGE_ID,
       LANG.CODE AS LANGUAGE_CODE,
       LANG.NAME AS LANGUAGE_NAME
FROM USER AS U
INNER JOIN COUNTRY AS CNT ON CNT.ID = U.ID_COUNTRY
INNER JOIN LANGUAGE AS LANG ON LANG.ID = U.ID_FIRST_LANGUAGE
WHERE 1";

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrUsers = [];

		foreach($RESULT as $KEY => $ROW){
	    $user = new User($ROW);
			array_push($arrUsers, $user);
	  }

		return $arrUsers;
	}

	public function getAllActiveUsers(){

		$DB = fnDBConn();

		$SQL = "SELECT U.ID AS USER_ID,
			 U.LOGIN AS USER_LOGIN,
			 U.FIRSTNAME AS USER_FIRSTNAME,
			 U.LASTNAME AS USER_LASTNAME,
			 U.AVATAR AS USER_AVATAR,
			 U.GRANTS AS USER_GRANTS,
			 U.ELO_FIDE AS USER_ELO_FIDE,
			 U.STATUS AS USER_STATUS,
			 U.BIRTHDAY AS USER_BIRTHDAY,
			 U.DIN AS USER_DATE_CREATED,
			 U.DIN_LAST_LOGIN AS USER_LAST_LOGIN,
			 U.ID_TYPE_USER AS USER_TYPE_USER,
			 U.ID_COUNTRY AS COUNTRY_ID,
			 CNT.CODE AS COUNTRY_CODE,
			 CNT.NAME AS COUNTRY_NAME,
			 ID_FIRST_LANGUAGE AS LANGUAGE_ID,
			 LANG.CODE AS LANGUAGE_CODE,
			 LANG.NAME AS LANGUAGE_NAME
FROM USER AS U
INNER JOIN COUNTRY AS CNT ON CNT.ID = U.ID_COUNTRY
INNER JOIN LANGUAGE AS LANG ON LANG.ID = U.ID_FIRST_LANGUAGE
WHERE U.STATUS = 1";

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrUsers = [];

		foreach($RESULT as $KEY => $ROW){
			$user = new User($ROW);
			array_push($arrUsers, $user);
		}

		return $arrUsers;
	}

	public function getAllAdministratorUsers(){

		$DB = fnDBConn();

		$SQL = "SELECT U.ID AS USER_ID,
       U.LOGIN AS USER_LOGIN,
       U.FIRSTNAME AS USER_FIRSTNAME,
       U.LASTNAME AS USER_LASTNAME,
       U.AVATAR AS USER_AVATAR,
       U.GRANTS AS USER_GRANTS,
       U.ELO_FIDE AS USER_ELO_FIDE,
       U.STATUS AS USER_STATUS,
       U.BIRTHDAY AS USER_BIRTHDAY,
       U.DIN AS USER_DATE_CREATED,
       U.DIN_LAST_LOGIN AS USER_LAST_LOGIN,
       U.ID_TYPE_USER AS USER_TYPE_USER,
       U.ID_COUNTRY AS COUNTRY_ID,
       CNT.CODE AS COUNTRY_CODE,
       CNT.NAME AS COUNTRY_NAME,
       ID_FIRST_LANGUAGE AS LANGUAGE_ID,
       LANG.CODE AS LANGUAGE_CODE,
       LANG.NAME AS LANGUAGE_NAME
FROM USER AS U
INNER JOIN COUNTRY AS CNT ON CNT.ID = U.ID_COUNTRY
INNER JOIN LANGUAGE AS LANG ON LANG.ID = U.ID_FIRST_LANGUAGE
WHERE U.ID_TYPE_USER = 1";

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrUsers = [];

		foreach($RESULT as $KEY => $ROW){
	    $user = new User($ROW);
			array_push($arrUsers, $user);
	  }

		return $arrUsers;
	}

	public function getUserWithId($paramUser){

		$DB = fnDBConn();

		$SQL = "SELECT U.ID AS USER_ID,
       U.LOGIN AS USER_LOGIN,
       U.FIRSTNAME AS USER_FIRSTNAME,
       U.LASTNAME AS USER_LASTNAME,
       U.AVATAR AS USER_AVATAR,
       U.GRANTS AS USER_GRANTS,
       U.ELO_FIDE AS USER_ELO_FIDE,
       U.STATUS AS USER_STATUS,
       U.BIRTHDAY AS USER_BIRTHDAY,
       U.DIN AS USER_DATE_CREATED,
       U.DIN_LAST_LOGIN AS USER_LAST_LOGIN,
       U.ID_TYPE_USER AS USER_TYPE_USER,
       U.ID_COUNTRY AS COUNTRY_ID,
       CNT.CODE AS COUNTRY_CODE,
       CNT.NAME AS COUNTRY_NAME,
       ID_FIRST_LANGUAGE AS LANGUAGE_ID,
       LANG.CODE AS LANGUAGE_CODE,
       LANG.NAME AS LANGUAGE_NAME
FROM USER AS U
INNER JOIN COUNTRY AS CNT ON CNT.ID = U.ID_COUNTRY
INNER JOIN LANGUAGE AS LANG ON LANG.ID = U.ID_FIRST_LANGUAGE
WHERE U.ID = $paramUser";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$user = new User($RESULT);

		return $user;
	}

}
?>

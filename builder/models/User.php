<?php
require_once('Country.php');
require_once('Language.php');

class User {

	public $id;
	public $login;
	public $firstName;
	public $lastName;
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

			$this->country = new Country($array);
			$this->language = new Language($array);
		}
  }

	public function __destruct(){

	}

}
?>

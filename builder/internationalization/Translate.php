<?php
require_once('../models/User.php');

class Translate {
	// idioma atual
	public $lang;

	function __construct() {

		$user = new User();
		$interfaceLanguageID = $user->getInterfaceLanguageForUserWithId($_SESSION['USER']['ID']);

		if ($interfaceLanguageID) {

      $this->lang = "en-US";

      if ($interfaceLanguageID == 1) {
        $this->lang = "pt-BR";
      }else if($interfaceLanguageID == 2){
        $this->lang = "en-US";
      }
		}

		$this->_ = json_decode(file_get_contents('../internationalization/'. $this->lang . '.json'), true);
	}

	function __get($text) {
		return isset($this->_[$text]) ? $this->_[$text] : $text;
	}
}
?>

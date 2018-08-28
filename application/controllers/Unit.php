<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends CI_Controller {
    public function __construct() {
        parent::__construct();

        // 語系設定
        $this->language = $this->mod_config->getLanguage();
    }

}

?>

<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Welcome extends CI_Controller {
    public function __construct() {
        parent::__construct();

        // 語系設定
        $this->language = $this->mod_config->getLanguage();
    }

	public function index() {
		$this->load->view('welcome_message');
    }

    function view($page = 'index') {
        if (!file_exists('application/views/pages/'.$page.'.php')) show_404();
	    $pageInfo['title'] = ucfirst($page); // 第一個字母大寫
        $this->load->view('pages/'.$page, $pageInfo);
    }
  
}

?>
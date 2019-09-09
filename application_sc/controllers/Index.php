<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
    
    public function __construct(){	
        parent::__construct();
        $this->load->helper('url');
        $this->load->model(array('MyModel'));
        $this->load->library('session');    
	}

    public function init(){
        $this->controlador = $this->router->fetch_class();
        $this->action = $this->router->fetch_method();
        $this->menu_lista = $this->MyModel->buscar_permisos();
        $this->url = uri_string();      
    }
    
	public function dashboard()
	{
	    $this->init();
		$this->load->view('/common/header');
        $this->load->view('dashboard');
        $this->load->view('/common/footer');
	}

}

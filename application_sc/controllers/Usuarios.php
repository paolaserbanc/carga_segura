<?php
class Usuarios extends CI_Controller {
    
  public function __construct(){	
		parent::__construct();
		$this->load->helper(array('url','form'));
        $this->load->library(array('form_validation','session'));
        $this->load->model(array('Usuario','MyModel'));
        $this->init();
	}
    
  public function init(){
        $this->controlador = $this->router->fetch_class();
        $action = $this->router->fetch_method();
        $this->menu_lista = $this->MyModel->buscar_permisos();    
  }
  
  function logout($mensaje = null){
    $this->session->unset_userdata('cs_usuario');
    $this->session->sess_destroy();
    redirect(base_url().'index.php/usuarios/login','refresh');
  }  
  
  function login(){    
     $user = $this->input->post('usuario');
     $pass = $this->input->post('password');          
     $data = array();     
     if (isset($this->session->userdata['cs_id_usuario'])) {
        redirect(base_url('index.php/index/dashboard')); //cuando la sesion esta activa
     }else{
        if ($this->input->post('usuario')) {
            echo $this->input->post('usuario');
            echo md5($this->input->post('password'));
            $username = $this->input->post('usuario');
            $password = $this->input->post('password');
            $valido = $this->Usuario->login($username,$password);
            if (!empty($valido)) {
                $sessiondata = array(
                  'cs_usuario' => $username,
                  'cs_id_usuario' => $valido[0]['id_usuario'], 
                  'cs_nombre' => $valido[0]['nombre'],
                  'cs_id_rol' => $valido[0]['id_rol'],
                  'cs_mail' => $valido[0]['mail'],
                );
                $this->session->set_userdata($sessiondata);    
                   redirect(base_url('index.php/index/dashboard'));
            } else{
                $data['msg'] = '<div class="alert alert-danger text-center">Datos de sesión invalidos o Usuario inactivo</div>';     
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Nombre de usuario o contraseña inválido</div>');
              }
            }     
            $this->load->view('usuarios/login',$data);       
        }   
    }
    
  }
?>
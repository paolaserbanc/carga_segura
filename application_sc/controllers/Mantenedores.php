<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mantenedores extends CI_Controller {
    
    public function __construct(){	
        parent::__construct();
        $this->load->helper(array('url','form'));
        $this->load->model(array('MyModel'));    
	}

    public function init(){
        $this->controlador = $this->router->fetch_class();
        $this->action = $this->router->fetch_method();
        $this->menu_lista = $this->MyModel->buscar_permisos();    
        $this->url = uri_string();
    }
    
	public function tipo_extraccion()
	{  
        $this->init();
        $data['tipo_extraccion'] = $this->MyModel->buscar_model('tipos_extraccion');
                
        $this->load->view('/common/header');
        $this->load->view('/mantenedores/tipo_extraccion',$data);
        $this->load->view('/common/footer');
	}
    public function roles(){
        $this->init();
        $data['roles'] = $this->MyModel->buscar_model('roles');
                
        $this->load->view('/common/header');
        $this->load->view('/mantenedores/roles',$data);
        $this->load->view('/common/footer');
    }
     public function carteras(){
        $this->init();
        $this->db->select('CC.IDCARTERA,AA.area,CC.NOMBRE,CC.CODIGO')->from('carga_segura.areas_carteras AC')
        ->join('serbanc_gestion.CARTERA CC','CC.IDCARTERA = AC.id_cartera')
        ->join('carga_segura.areas AA','AA.id_area = AC.id_area');
        $query = $this->db->get();      
        $data['carteras'] = $query->result_array();
        
        $this->db->select('CC.IDCARTERA,CC.NOMBRE,CC.CODIGO')->from('serbanc_gestion.CARTERA CC')
        ->join('carga_segura.areas_carteras AC','CC.IDCARTERA = AC.id_cartera','left')
        ->where('CC.ACTIVA ="S"')->where('AC.id_cartera IS NULL');
        $query = $this->db->get();      
        $data['carteras_serbanc'] = $query->result_array();
        $data['areas'] = $this->MyModel->buscar_model('areas');        
        $this->load->view('/common/header');
        $this->load->view('/mantenedores/carteras',$data);
        $this->load->view('/common/footer');
    }
    public function areas(){
        $this->init();
        $data['areas'] = $this->MyModel->buscar_model('areas');
                
        $this->load->view('/common/header');
        $this->load->view('/mantenedores/areas',$data);
        $this->load->view('/common/footer');
    }
    
    public function agregar_cartera_area(){
        $area = $this->input->post('area');
        $cartera = $this->input->post('cartera');
        $fecha = date("Y-m-d");
        $this->db->select('CC.CODIGO')->from('serbanc_gestion.CARTERA CC')->where('CC.IDCARTERA = '.$cartera);
        $query = $this->db->get();      
        $codigo = $query->result_array();
        $codigo = $codigo[0]['CODIGO'];
        $nueva_area_cartera = array(
            'id_area' => $area,
            'id_cartera' => $cartera,
            'codigo_cartera' => $codigo,
            'fecha_creacion' => $fecha            
        );
        
        $this->MyModel->agregar_model('areas_carteras',$nueva_area_cartera);
        redirect(base_url('index.php/mantenedores/carteras'));      
        
    }
}

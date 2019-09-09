<?php
defined('BASEPATH') OR exit('No direct script access allowed');
##funciones comunes para todas las carteras para todas las asignaciones

class Asignacion extends CI_Controller {
    
    public function __construct(){	
        parent::__construct();
        $this->load->helper('url');
        $this->load->model(array('MyModel'));    
	}

    public function init(){
        $this->controlador = $this->router->fetch_class();
        $this->action = $this->router->fetch_method();
        $this->menu_lista = $this->MyModel->buscar_permisos();
        $this->url = uri_string();    
    }
    
	public function asignacion_carteras($id_area)
	{  
        $this->init();
        $this->db->select('CC.CLIENTE,PP.hora_ejecucion,CC.NOMBRE,CC.BASEDATOS,CC.PATH,CC.IDCARTERA,AC.id_area,
        AC.id_cartera,AC.codigo_cartera,PP.id_tipo_proceso,PP.vista,LL.*')
        ->from('carga_segura.areas_carteras AC')
        ->join('serbanc_gestion.CARTERA CC','CC.IDCARTERA = AC.id_cartera')
        ->join('carga_segura.areas AA','AA.id_area = AC.id_area')
        ->join('carga_segura.procesos PP','PP.id_cartera = AC.id_cartera','left')
        ->join('carga_segura.log LL','LL.id_proceso = PP.id_proceso and DATE_FORMAT(LL.fecha_creacion,"%Y-%m-%d") = CURDATE()','left')
        ->where('PP.id_tipo_proceso = 1')
        ->where('AC.id_area ='.$id_area);        
        $query = $this->db->get();      
        $data['carteras'] = $query->result_array();
                
        $this->load->view('/common/header');
        $this->load->view('/asignacion/carteras',$data);
        $this->load->view('/common/footer');
	}
    
    public function ver_log(){
        $id_log = $this->input->post('id_log');
        $log = $this->MyModel->buscar_model('log',array('id_log' => $id_log));
        $data['log'] = $log[0];
        $this->load->view('/asignacion/ver_log',$data);
    }

    public function ver_cuadratura(){
        $id_log = $this->input->post('id_log');
        $cuadratura_archivos = $this->MyModel->buscar_model('cuadratura_archivos',array('id_log' => $id_log));
        $cuadratura_ecoll = $this->MyModel->buscar_model('cuadratura_ecoll',array('id_log' => $id_log));
        $data['cuadratura_archivos'] = $cuadratura_archivos[0];
        $data['cuadratura_ecoll'] = $cuadratura_ecoll[0];
        $this->load->view('/asignacion/ver_cuadratura',$data);
    }
}

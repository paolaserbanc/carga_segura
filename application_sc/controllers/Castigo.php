<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Castigo extends CI_Controller {

	public function __construct(){	
		parent::__construct();
        $this->load->helper(array('url', 'html', 'form'));
        $this->load->model(array('MyModel'));        
        $this->load->library(array('ftp','funciones'));
	}

    public function init(){
        $this->controlador = $this->router->fetch_class();
        $this->action = $this->router->fetch_method();
        $this->menu_lista = $this->MyModel->buscar_permisos();    
        $this->url = uri_string();
    }
    
    public function asignacion_lapolar(){ 
       $this->init();
       //busco el id_proceso para sacar los datos ftp
       $buscar_proceso = $this->MyModel->buscar_model('vista_proceso',array('controlador' => $this->controlador,'vista' => $this->action));
       $id_proceso = $buscar_proceso[0]['id_proceso']; 
       $extension = 'csv';
       $variacion_fecha ='';
       //Creo registro en log, para guardar el momento en que empieza la ejecucion del proceso
       $nuevo_log = array(
                'id_proceso'=>$id_proceso,
                'fecha_hora_inicio' => date('Y-m-d H:i:s'),
                'id_tipo_ejecucion' => 1,
                'fecha_creacion' => date('Y-m-d H:i:s')
                
        );
        $id_log = $this->MyModel->agregar_model('log',$nuevo_log);
        //Busco el resto de datos del proceso
        $proceso = $this->MyModel->buscar_model('procesos',array('id_proceso' => $id_proceso));
        //Extraigo archivo de carga del ftp
        $extrae_archivo_ftp = $this->funciones->traer_archivo_ftp($id_proceso,$extension,$variacion_fecha);
        if($extrae_archivo_ftp[8]['correcto']){ //Si la extraccion fue correcta
            //Cargo en tabla temporal el archivo de carga

            $this->MyModel->truncar('carga_segura_castigo.ASIGNACION_LAPOLAR_CASTIGO_NEW');
            $this->MyModel->carga_archivo_base($extrae_archivo_ftp[8]['archivo'],'carga_segura_castigo.ASIGNACION_LAPOLAR_CASTIGO_NEW',';','1');
            
            $this->MyModel->call_function($proceso[0]['procedimiento_almacenado']);
        } else {
            $msj = 'Error con archivo de asignacion';
            $update_log = array(
                'finalizo_exito' => 'N',
                'observacion' => 'Error en la extracción del archivo de carga'
            );
            $this->MyModel->agregar_model('log',$nuevo_log,$id_log);
        }
        
    }
   
  
  
  }
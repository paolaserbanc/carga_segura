<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Masivas extends CI_Controller {

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
    
    public function asignacion_claro(){ //si podemos hacer la asignacion mas generica, le cambiamos el nombre por asignacion_ftp_masiva
        $this->init();
        
        //busco el id_proceso para sacar los datos ftp
        $buscar_proceso = $this->MyModel->buscar_model('vista_proceso',array('controlador' => $this->controlador,'vista' => $this->action));
        $id_proceso = $buscar_proceso[0]['id_proceso']; 
        $extension = 'txt';
        $variacion_fecha = false;
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
       // print_r($extrae_archivo_ftp);die();
        if($extrae_archivo_ftp['correcto']){ //Si la extraccion fue correcta
            //Cargo en tabla temporal el archivo de carga
            $this->MyModel->truncar('carga_segura_masiva.CLARO_UNIF_ASIGNACION_CONSOLIDADO');
            $this->MyModel->carga_archivo_base($extrae_archivo_ftp['archivo'],'carga_segura_masiva.CLARO_UNIF_ASIGNACION_CONSOLIDADO','|');
            
            $this->db->select('COUNT(DISTINCT CUENTA_CYBER) AS cantidad,  SUM(SCMO_SALDO_VENCIDO) as monto');
            $this->db->from('carga_segura_masiva.CLARO_UNIF_ASIGNACION_CONSOLIDADO');
            $query = $this->db->get(); 
            $cuadratura_consolidada_archivo = $query->result_array();
            
            //Lleno cuadratura de lo que esta en el archivo
            $nueva_cuadratura = array(
                'id_log' => $id_log,
                'cantidad' => $cuadratura_consolidada_archivo[0]['cantidad'],
                'monto' => $cuadratura_consolidada_archivo[0]['monto'],
                'fecha_creacion' => date('Y-m-d')
            );
            $id_cuadratura_archivo = $this->MyModel->agregar_model('cuadratura_archivos',$id_cuadratura_archivo);
            //Llamo al procedimiento almacenado
            $this->MyModel->call_function($proceso[0]['procedimiento_almacenado']);
            $this->MyModel->call_function('carga_segura_masiva.Asignacion_Claro_Unificado');
            $update_log = array(
                'finalizo_exito' => 'S',
                'fecha_hora_fin' => date('Y-m-d H:i:s'),
            );
            
            $this->db->select('COUNT(DISTINCT CUENTA_CYBER) AS cantidad,  SUM(VALOR) as monto');
            $this->db->from('clarounificado_gestion.DOCUMENTOS DC');
            $this->db->where('DC.CUENTA_CYBER IS NOT NULL');
            $this->db->where('DC.ASIGNACION = CURDATE()');
            $query = $this->db->get(); 
            $cuadratura_consolidada_ecoll = $query->result_array();
            
            //Lleno cuadratura de lo que esta en el archivo
            $nueva_cuadratura = array(
                'id_log' => $id_log,
                'cantidad' => $cuadratura_consolidada_ecoll[0]['cantidad'],
                'monto' => $cuadratura_consolidada_ecoll[0]['monto'],
                'fecha_creacion' => date('Y-m-d')
            );
            $id_cuadratura_ecoll = $this->MyModel->agregar_model('cuadratura_ecoll',$id_cuadratura_ecoll);
            
            
            
        } else {
            $msj = 'Error con archivo de asignacion';
            $update_log = array(
                'finalizo_exito' => 'N',
                'observacion' => 'Error en la extracción del archivo de carga'
            );
            $this->MyModel->agregar_model('log',$nuevo_log,$id_log);
        }
        
    }
   
    public function cuadratura_claro(){
            //CUADRATURA CONSOLIDAD DE ARCHIVO TXT       
            $this->db->select('COUNT(DISTINCT CUENTA_CYBER) AS cantidad,  SUM(SCMO_SALDO_VENCIDO) as monto, TRAMO');
            $this->db->from('carga_segura_masiva.CLARO_UNIF_ASIGNACION_CONSOLIDADO');
            $this->db->group_by('TRAMO');
            $query = $this->db->get();
            $cuadratura_consolidada_archivo = $query->result_array();
            
            // CUADRATURA DE DATOS ENVIADOS EN ARCHIVO TXT POR CICLOS      
            $this->db->select('SCMO_CICLO_COBRANZA AS CICLO_CYBER,TRAMO,COUNT(CUENTA_CYBER) AS Cantidad,
            SUM(SCMO_SALDO_VENCIDO) AS Monto');
            $this->db->from('carga_segura_masiva.CLARO_UNIF_ASIGNACION_CONSOLIDADO');
            $this->db->group_by('SCMO_CICLO_COBRANZA,TRAMO');
            $query = $this->db->get();
            $cuadratura_archivo_ciclos = $query->result_array();
            
            //CUADRATURA CONSOLIDAD DE DATOS CARGADOS        
            $this->db->select('DC.UBICADO AS TRAMO,
                COUNT(DISTINCT DC.CUENTA_CYBER) as cantidad,
                SUM(DC.VALOR) AS Monto');
            $this->db->from('clarounificado_gestion.DOCUMENTOS DC');
            $this->db->where('DC.CUENTA_CYBER IS NOT NULL');
            $this->db->where('DC.ASIGNACION = CURDATE()');
            $this->db->group_by('UBICADO');
            $query = $this->db->get();;
            $cuadratura_consolidada_cargado = $query->result_array();
            
            //CUADRATURA CONSOLIDAD DE DATOS CARGADOS  por ciclo     
            $this->db->select('DC.CICLO_CYBER,DC.UBICADO AS TRAMO,COUNT(DISTINCT DC.CUENTA_CYBER) as Cantidad,
            SUM(DC.VALOR) AS Monto');
            $this->db->from('clarounificado_gestion.DOCUMENTOS DC');
            $this->db->where('DC.CUENTA_CYBER IS NOT NULL');
            $this->db->where('DC.ASIGNACION = CURDATE()');
            $this->db->group_by('DC.CICLO_CYBER, UBICADO');
            $query = $this->db->get();
            $cuadratura_consolidada_cargado_ciclo = $query->result_array();
            
    }
  
  }
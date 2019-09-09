<?php if ( ! defined('BASEPATH')) exit('No esta permitido el acceso'); 

class Funciones extends CI_Ftp {
    protected $ci;
    
    public function __construct(){	
        parent::__construct();
		$this->ci =& get_instance();
        $this->ci->load->model(array('MyModel'));  
        date_default_timezone_set('Chile/Continental');
	}

    function traer_archivo_ftp($id_proceso,$extension,$variacion_fecha){ 
        //busco la data del proceso (tipo de extraccion ftp, ticket, etc)
        $proceso = $this->ci->MyModel->buscar_model('procesos',array('id_proceso' => $id_proceso));
        //traigo los datos del ftp (usuario, clave,ruta)
        $extraccion = explode(',',$proceso[0]['id_extraccion']);
        $ftps = $this->ci->MyModel->buscar_model_in('extraccion','id_extraccion',$extraccion);
        $resultado = array();
        foreach($ftps as $ftp){
           
            $config['hostname'] = $ftp['server'];//ip o url del servidor
            $config['username'] = $ftp['usuario']; // usuario
            $config['password'] = $ftp['password']; // pass
            $config['debug']    = TRUE;
            
            if(!empty($variacion_fecha)){
                $fecha_base = date('Y-m-d');
                $fecha = date($ftp['va_fecha'], strtotime("$fecha_base $variacion_fecha")); 
                
            }else{
                $fecha = date($ftp['va_fecha']);   
            }
            
            $ruta = $ftp['ruta'].$ftp['nombre_archivo'].$fecha.'.'.$extension; //ruta del archivo, concatenar con el nombre del archivo tal vez?
            $conexion = $this->connect($config);    
              
            $download = $this->download($ruta,$proceso[0]['ruta_archivo'].$ftp['nombre_archivo'].$fecha.'.'.$extension); //Se guarda archivo en nuestra carpeta local
            
            $this->close();
            
            $resultado[$ftp['id_extraccion']]['correcto'] = false;
            if($download){
                $resultado[$ftp['id_extraccion']]['id_extraccion'] = $ftp['id_extraccion'];
                $resultado[$ftp['id_extraccion']]['correcto'] = true;
                $resultado[$ftp['id_extraccion']]['archivo'] = $proceso[0]['ruta_archivo'].$ftp['nombre_archivo'].$fecha.'.'.$extension;
            }
        }
        return $resultado;
    }
    

 
}
?>
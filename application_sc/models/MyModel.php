<?php
class MyModel extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function agregar_model($tabla,$arreglo,$id = null) {
        if (!empty($id)) {
            $this->db->where('id_'.$tabla, $id);
            $this->db->update($tabla, $arreglo); 
        } else {
            $this->db->insert($tabla, $arreglo);
        }
        return $this->db->insert_id();
    }

    public function buscar_model($tabla, $conditions=null){
        $this->db->from($tabla);
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }  
        
        if ($tabla == 'permisos') {
            $this->db->order_by('id');
        }
        //$this->db->limit(2000);
        $query = $this->db->get();
        // print_r($this->db->last_query());echo '<br>';
        return $query->result_array();
        
    }
    
    public function buscar_model_in($tabla, $campo,$in){
        $this->db->from($tabla);
        
        $this->db->where_in($campo,$in);
        
        if ($tabla == 'permisos') {
            $this->db->order_by('id');
        }
        //$this->db->limit(2000);
        $query = $this->db->get();
        return $query->result_array();
        
    }
    
    public function buscar_select($tabla, $campo,$conditions = null,$id = true, $order = null){
        if (!empty($conditions)) {
            $this->db->where($conditions);
            //print_r($conditions);
        }
        
        if(!empty($order)){
            $this->db->order_by($order);
        }
        $this->db->order_by($campo); 
        $query = $this->db->get($tabla);
        $result = array();
        foreach ($query->result_array() as $value) {
            if ($id) {
                $result[$value['id']] = $value[$campo];
            } else {
                 $result[$value[$campo]] = $value[$campo];
            }  
        }

        return $result;
    }
    
    public function select($tabla, $campo,$conditions = null, $conditions_in = null ,$order = null){
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        if (!empty($conditions_in)) {
            $this->db->where_in("id",$conditions_in);
        }
        if (!empty($order)) {
            $this->db->order_by($order);
        }else{
            $this->db->order_by($campo, 'ASC');
        }
        
        $query = $this->db->get($tabla);
        $result = array();
        foreach ($query->result_array() as $value) {
          $result[$value['id']] = $value[$campo];
        }
        return $result;
    }
    
    public function buscar_permisos(){
        $query = $this->db->query("SELECT * FROM `permisos` WHERE `es_menu` = '1' ORDER BY grupo,id_permiso desc ");
        $permisos_q = $query->result_array();
        $permisos = array();
        foreach ($permisos_q as $p) {
            $permisos[$p['grupo']][] = $p; 
        }
        return $permisos;
    }

     public function agregar($tabla,$id,$data = null) {
        if (!empty($id)) {
            $this->db->where($id);
            $this->db->update($tabla, $data); 
        } else {
            $this->db->insert($tabla, $data);
        }
        
        return $this->db->insert_id();
    }

    public function eliminar($tabla,$id) {
        $this->db->where($id);
        return $this->db->delete($tabla);
    }
    public function eliminar_vacias($tabla){
        $this->db->where('ASCII(TIPO)  =  26');
        return $this->db->delete($tabla);
    }

    function listar($table ,$select = null, $where = null, $order = null){
        
        $this->db->from($table);
        if($select != null){
            $this->db->select($select);
        }
        if($where!= null){
            $this->db->where($where);
        }
        if($order != null){
            $this->db->order_by($order);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    function truncar($tabla){ 
        $this->db->truncate($tabla);
    }
    
    function carga_archivo_base($archivo,$base,$separador){
         $query = "LOAD DATA LOCAL INFILE '" . base_url().$archivo . "'INTO TABLE ".$base." FIELDS TERMINATED BY '".$separador."';";
         return $this->db->query($query);
    
    }
    
    function call_function($procedimiento){
        $query = "CALL ".$procedimiento.'()';
        return $this->db->query($query);
    }
    
}
?>
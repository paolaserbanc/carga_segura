<?php
class Usuario extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function getUsuarios($conditions = null){
        $this->db->from('usuarios');
        //$this->db->where('activo',1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function agregar($usuario,$id = null) {
        //si el id no es null entonces actualizo
        if (!empty($id)) {
            $this->db->where('id', $id);
            $this->db->update('usuarios', $usuario); 
        } else {
            $this->db->insert('usuarios', $usuario);
        }
        return true;
    }
    
    public function eliminar($id) {
        $this->db->delete('usuarios',array('id'=>$id));
        return true;
    }
        
    public function busca_usuario($idusuario){
    	$this->db->from('usuarios');
    	$this->db->where("id_usuario = ".$idusuario);
    	$query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    
  function login($user, $password){
     $this ->db->select('id_usuario,usuario,mail,id_rol,nombre')->from('usuarios')->where('usuario',$user)->where('password',MD5($password))->limit(1);
     $query = $this->db->get();
     $query = $query->result_array();
     return $query;
    }
}
?>
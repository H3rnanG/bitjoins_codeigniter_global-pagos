<?php 
/*
 * Created on 28/09/2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Utilitario_model extends CI_Model {

    var $tabla = 'producto_marca';

    function __construct()
    {
        parent::__construct();
    }

    function modelo(){
        $arrayModelo = array('tabla' => $this->tabla, 
                             'campos' => array(
                                            'tipooperacion' => 'required' //unique|required
                                            )
                            );
        return $arrayModelo;
    }

    

    function modelo(){
        $arrayModelo = array('tabla' => $this->tabla, 
                             'campos' => array(
                                            'nombre' => 'unique|required'
                                            )
                            );
        return $arrayModelo;
    }

    function getarrdatos($tabla='',$campos=array(),$where=array()){

        if(count($campos)){
            $strCampos = '';
            foreach ($campos as $campo) {
                $strCampos.=$campo.','; 
            }
            $strCampos = substr($strCampos, 0, strlen($strCampos)-1);
            $this->db->select($strCampos);
        }

        $this->db->from($tabla);
        $this->db->where($where);
        $query = $this->db->get(); 
        $rs = $query->result();

        /*
        if(array_key_exists('documento', $where)){
            $dni = $where['documento'];
            echo $dni.' <br> ';
            if($dni == '09447811'){
                echo $this->db->last_query();
            }
        }*/
        //echo $this->db->last_query();
        $arrDatos = array();
        if(count($rs) > 0){
            if(count($campos)){
                foreach ($campos as $nc) {
                    $arrDatos[$nc] = $rs[0]->$nc;
                }
            }else{
                foreach ($rs as $key => $fila) {
                    foreach ($fila as $k => $v) {
                        $arrDatos[$k] = $v;
                        //echo '-> horario - '.$k.' => '.$v;
                    }
                }
            }
            
            return $arrDatos; 
        }else{
            return '';
        }
    }

    function getdato($tabla='',$campo='',$where=array()){
        $this->db->from($tabla);
        $this->db->select($campo);
        $this->db->where($where);
        $query = $this->db->get(); 
        $rs = $query->result();
        //die($this->db->last_query());

        if(count($rs) > 0){
            return $rs[0]->$campo;
        }else{
            return '';
        }
    }

    function insert($tabla='', $arrDatos = ''){
        
    	$id = '';
    	if(is_array($arrDatos)){
            $this->db->insert($tabla, $arrDatos);
            $id = $this->db->insert_id();
    	}
    	return $id;
        
    }

    function get_cbo($tabla = '', $arrCampos=array(),$orden=''){
        
        $strCampos = '';
        if(count($arrCampos)>0){
            
        }
        $this->db->select($strCampos);
        $this->db->from($tabla);
        //$this->db->where('estado', ON);
        $this->db->order_by($orden);
        $query = $this->db->get(); 
        $rs = $query->result();
        return $rs;
    }

    function get_vista($id){
        $this->db->from($this->tabla);
        $this->db->where('id', $id);

        $query = $this->db->get(); 
        $rs = $query->result();

        if(count($rs)>0){   
            foreach ($rs[0] as $key => $value) {
                //if($key == 'fecha_reg' || $key == 'fec_prog_llegada' || $key == 'fec_real_llegada'){
                //$value = $this->utilitario->getInvertirFecha($value);
                //}
                $arrRs[$key]=$value;
            }
            return $arrRs;
        }else{
            return array();
        }
    }

    function vista($id=''){
    	$this->db->from($this->tabla);
		$this->db->select('id, codigo, nombre, estado');
        
        if(strlen($id)>0){
            $this->db->where('id',$id);
        }

		$query = $this->db->get(); 
		$rsdatos = $query->result();

		$jsonrs = json_encode($rsdatos);

		return $jsonrs;
    }

    function delete($id){
    	
    	$this->db->where('servicios_id',$id);
    	$totalreg = $this->db->count_all_results('oferta_det');

		if($totalreg > 0){
			$arrDatos['estado'] = ANULADO;
			$this->db->where('id', $id);
    		$this->db->update($this->tabla, $arrDatos);
		}else{
			$this->db->delete($this->tabla,array('id' => $id));	
		}
    	

    }

} // fin clase

?>
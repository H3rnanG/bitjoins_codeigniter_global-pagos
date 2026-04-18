<?php 
/*
 * Created on 28/09/2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Clientes_model extends CI_Model {
	var $id = '';
	var $tabla = 'transfer_cliente';

    var $arrWhere = array();

    var $column_order = array(null,null,'a.documento','a.nombre', 'a.apellido_paterno','a.fechareg');
    var $column_search = array('a.documento','a.nombre', 'a.apellido_paterno','a.fechareg');
    var $order = array('a.nombre'=>'ASC');



	function __construct()
    {
        parent::__construct();
    }

    function modelo(){
        $arrayModelo = array('tabla' => $this->tabla, 
                             'campos' => array(
                                            'id' => array('type'=>'int', 'null'=>false,'length'=>11),
                                            'config_ubigeo_id' => array('type'=>'int', 'null'=>false,'length'=>10),
                                            'calculadora_login_id' => array('type'=>'int', 'null'=>false,'length'=>10),
                                            'tipo_documento' => array('type'=>'int', 'null'=>false,'length'=>10),
                                            'documento' => array('type'=>'char', 'null'=>false,'length'=>15),
                                            'fecha_emision' => array('type'=>'date', 'null'=>true,'length'=>10),
                                            'fecha_caducidad' => array('type'=>'date', 'null'=>true,'length'=>10),
                                            'nombre' => array('type'=>'char', 'null'=>false,'length'=>80),
                                            'nombre2' => array('type'=>'char', 'null'=>false,'length'=>80),
                                            'apellido_paterno' => array('type'=>'char', 'null'=>false,'length'=>80),
                                            'apellido_materno' => array('type'=>'char', 'null'=>false,'length'=>80),
                                            'fecha_nacimiento' => array('type'=>'date', 'null'=>false,'length'=>10),
                                            'pais_nacimiento_id' => array('type'=>'int', 'null'=>true,'length'=>10),
                                            'nacionalidad_id' => array('type'=>'int', 'null'=>true,'length'=>10),
                                            'email' => array('type'=>'char', 'null'=>true,'length'=>150),
                                            'genero' => array('type'=>'char', 'null'=>true,'length'=>1),
                                            'comentarios' => array('type'=>'char', 'null'=>true,'length'=>500),
                                            'direccion1' => array('type'=>'char', 'null'=>false,'length'=>200),
                                            'direccion2' => array('type'=>'char', 'null'=>true,'length'=>200),
                                            'pais_id' => array('type'=>'int', 'null'=>true,'length'=>10),
                                            'estado_id' => array('type'=>'int', 'null'=>false,'length'=>10),
                                            'ciudad_id' => array('type'=>'int', 'null'=>false,'length'=>10),
                                            'codigo_postal' => array('type'=>'char', 'null'=>true,'length'=>15),
                                            'cod_telefono1' => array('type'=>'char', 'null'=>true,'length'=>5),
                                            'num_telefono_1' => array('type'=>'char', 'null'=>true,'length'=>10),
                                            'cod_telefono2' => array('type'=>'char', 'null'=>true,'length'=>5),
                                            'num_telefono_2' => array('type'=>'char', 'null'=>true,'length'=>10),

                                            'sw_tercera_persona' => array('type'=>'int', 'null'=>true,'length'=>3),
                                            'sw_trans_sospechosa' => array('type'=>'int', 'null'=>true,'length'=>3),
                                            'sw_perexp_politicamente' => array('type'=>'int', 'null'=>true,'length'=>3),

                                            'arch_dni1' => array('type'=>'char', 'null'=>true,'length'=>80),
                                            'arch_dni2' => array('type'=>'char', 'null'=>true,'length'=>80),
                                            'arch_declaracion' => array('type'=>'char', 'null'=>true,'length'=>80),

                                            'ocupacion_id' => array('type'=>'int', 'null'=>true,'length'=>10),
                                            'posicion_empleo_id' => array('type'=>'int', 'null'=>true,'length'=>10),
                                            'relacion_beneficiario_id' => array('type'=>'int', 'null'=>true,'length'=>10),
                                            'motivo_transaccion_id' => array('type'=>'int', 'null'=>true,'length'=>10),
                                            'origen_fondos_id' => array('type'=>'int', 'null'=>true,'length'=>10),

                                            'sw_datos_verificados' => array('type'=>'int', 'null'=>true,'length'=>3),

                                            'fechareg' => array('type'=>'date', 'null'=>false,'length'=>10),
                                            'estado' => array('type'=>'int', 'null'=>false,'length'=>3)
                                            )
                            );
        return $arrayModelo;
    }

    function set_where($where = array()){
        array_push($this->arrWhere,$where);
    }

    function get_where(){
        if(count($this->arrWhere)){
            foreach ($this->arrWhere as $where) {
                foreach ($where as $key => $value) {
                    $this->db->where($key, strtoupper($value));
                }
            }
        }
    }

    function clear_where(){
        $this->arrWhere = array();
    }


    function get_datatables_vista()
    {
        $post = $this->input->post();

        $this->db->from($this->tabla.' as a');
        $this->db->select('a.id, a.documento, concat(a.nombre," ",a.nombre2) as nombres, concat(a.apellido_paterno, " ", a.apellido_materno) as apellidos, email, genero, DATE_FORMAT(fechareg,"%d-%m-%Y") as fechareg');
        //$this->db->join('carga_transporte as b', 'b.id = carga_transporte_id', 'left');

        $this->get_where();

        $i = 0;
        foreach ($this->column_search as $item) // loop column 
        {
            if($post['search']['value']) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, strtoupper($post['search']['value']));
                }
                else
                {
                    $this->db->or_like($item, strtoupper($post['search']['value']));
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if(isset($post['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$post['order']['0']['column']], $post['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    function get_datatables(){
        $post = $this->input->post();

        $this->get_datatables_vista();

        if($post['length'] != -1)
        $this->db->limit($post['length'], $post['start']);
        $query = $this->db->get();
        return $query->result();
        //$query->result(); die($this->db->last_query());

    }


    function count_filtered()
    {
        $this->get_datatables_vista();

        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all()
    {
        $this->get_where();

        $this->db->from($this->tabla.' as a');
        return $this->db->count_all_results();
    }

    function insert($arrDatos){
        //var_dump($arrDatos); die();
    	$rs = array();
    	if(is_array($arrDatos)){

    		if($arrDatos['id'] == '' or $arrDatos['id'] == '0'){
    			$this->db->insert($this->tabla, $arrDatos);
    			$lastID = $this->db->insert_id();
    			$arrDatos['id'] = $lastID;
    		}else{
    			$this->db->where('id', $arrDatos['id']);
    			$this->db->update($this->tabla, $arrDatos);
    		}
            $rs = $arrDatos;
    	}
    	return $rs;
    }

    function get_cbo(){
        
        $this->db->from($this->tabla);
        $this->db->select('id as data, nombre as value');

        $this->get_where();
        //$this->db->limit(10);

        $query = $this->db->get(); 
        $rs = $query->result_array();
        //die($this->db->last_query());
        return $rs;
    }

    function get_vista(){
        $this->db->select('DATE_FORMAT(fecha_emision,"%d-%m-%Y") as fecha_emision_f, DATE_FORMAT(fecha_caducidad,"%d-%m-%Y") as fecha_caducidad_f, DATE_FORMAT(fecha_nacimiento,"%d-%m-%Y") as fecha_nacimiento_f, DATE_FORMAT(fechareg,"%d-%m-%Y") as fechareg_f, b.descripcion as pais_nacimiento, c.descripcion as nacionalidad, c.descripcion as pais, c.descripcion as estado_ch, c.descripcion as ciudad, g.descripcion as ocupacion, h.descripcion as posicion_empleo, i.descripcion as relacion_beneficiario, j.descripcion as motivo_transaccion, k.descripcion as origen_fondos, a.*');

        $this->db->from($this->tabla.' as a');
        $this->db->join('config_ubigeo as b', 'b.id = a.pais_nacimiento_id','left');
        $this->db->join('config_ubigeo as c', 'c.id = a.nacionalidad_id','left');

        $this->db->join('config_ubigeo as d', 'd.id = a.pais_id','left');
        $this->db->join('config_ubigeo as e', 'e.id = a.estado_id','left');
        $this->db->join('config_ubigeo as f', 'f.id = a.ciudad_id','left');

        $this->db->join('config_general as g', 'g.id = a.ocupacion_id','left');
        $this->db->join('config_general as h', 'h.id = a.posicion_empleo_id','left');
        $this->db->join('config_general as i', 'i.id = a.relacion_beneficiario_id','left');
        $this->db->join('config_general as j', 'j.id = a.motivo_transaccion_id','left');
        $this->db->join('config_general as k', 'k.id = a.origen_fondos_id','left');

        //$this->db->select('id as ID, DATE_FORMAT(fechareg,"%d-%m-%Y") as fechareg, codigo,alias,nombre,contacto,estado'); 

        $this->get_where();

        $query = $this->db->get(); 
        $rs = $query->result_array();
        return $rs;
    }

    function vista(){
    	$this->db->from($this->tabla);
		//$this->db->select('com.codigocommodity as id, com.descripcion as nombre');
        $this->get_where();
		$query = $this->db->get(); 
		$rsdatos = $query->result_array();
		return $rsdatos;
    }

    function delete($id){

        $arrayIds = explode(',', $id);
        $arrayTablasExistencia = array('comercial_oferta');
        $arrayEvento = array();
        $nroEliminiados = 0; $nroAnulados=0;

        foreach ($arrayIds as $idActual) {
            $nroConsultas = 0; 
            foreach ($arrayTablasExistencia as $tabla) {
                $this->db->where('ingenieria_proyecto_id',$idActual);
                $totalreg = $this->db->count_all_results($tabla);
                $this->db->flush_cache();

                if($totalreg > 0){
                    $nroAnulados++;
                    $arrayEvento['ids'][$idActual] = ANULADO;
                    continue;
                }else{
                    $nroConsultas++;
                    if($nroConsultas == count($arrayTablasExistencia)){
                        $arrayEvento['ids'][$idActual] = '';
                        $nroEliminiados++;
                    }
                }
            }   
        }

        $arrayEvento['eliminados'] = $nroEliminiados;
        $arrayEvento['anulados'] = $nroAnulados;

        if(count($arrayEvento)>0){
            foreach ($arrayEvento as $idEvent => $value) {
                if($value == ANULADO){
                    $arrDatos['estado'] = ANULADO;
                    $this->db->where('id', $idEvent);
                    $this->db->update($this->tabla, $arrDatos);
                }else{
                    $this->db->delete($this->tabla,array('id' => $id)); 
                }
            }
        }

        return $arrayEvento;
    }

} // fin clase

?>
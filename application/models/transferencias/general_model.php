<?php 
/*
 * Created on 28/09/2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class general_model extends CI_Model {
	var $id = '';
	var $tabla = 'config_general';

    var $arrWhere = array();

    var $column_order = array(null,null,'descripcion', 'estado');
    var $column_search = array('descripcion', 'estado');
    var $order = array('id'=>'ASC');

	function __construct()
    {
        parent::__construct();
    }

    function modelo(){
        $arrayModelo = array('tabla' => $this->tabla, 
                             'campos' => array(
                                            'id' => array('type'=>'int', 'null'=>false,'length'=>11),
                                            'codtabla' => array('type'=>'char', 'null'=>false,'length'=>20),
                                            'descripcion' => array('type'=>'char', 'null'=>false,'length'=>80),
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

        $this->db->from($this->tabla);
        $this->db->select('id, descripcion, estado');
        

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

        $this->db->from($this->tabla);
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
        $this->db->select('id as data, descripcion as value');

        $this->get_where();
        //$this->db->limit(10);

        $query = $this->db->get(); 
        $rs = $query->result_array();
        //die($this->db->last_query());
        return $rs;
    }

    function get_vista(){
        $this->db->from($this->tabla);
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
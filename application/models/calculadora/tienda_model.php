<?php 
/*
 * Created on 28/09/2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Tienda_model extends CI_Model {
	var $id = 'id';
	var $tabla = 'calculadora_tienda';
    var $arrWhere = array();

    var $column_order = array(null,null,'nombre','direccion');
    var $column_search = array('nombre','direccion');
    var $order = array('nombre'=>'ASC');

	function __construct()
    {
        parent::__construct();

    }

    function modelo(){
        $arrayModelo = array('tabla' => $this->tabla, 
                             'campos' => array(
                                            //'codigo' => 'unique|required',
                                            'nombre' => 'unique|required'
                                            )
                            );
        return $arrayModelo;
    }

    function count() {
        return $this->db->count_all($this->tabla);
    }

    function set_where($where = array()){
        if(count($where) > 0){
            array_push($this->arrWhere,$where);
        }
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

    function get_datatables_vista()
    {
        $post = $this->input->post();
        $this->db->from($this->tabla);
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

    function get_datatables_venta($fecha = '')
    {
        $post = $this->input->post();

        if(strlen($fecha)==0){
            $fecha = '2000-01-01';
        }


        /* 1- edt_mnt - ing_mnt     2-   CEIL(edt_appago/ing_tcact)-ROUND(edt_appago/ing_tc)  */
        $this->db->select('id, nombre, 
(select sum(edt_tot) from calculadora_transferencias as tra where tra.pais = 1 and tra.calculadora_tienda_id = calculadora_tienda.id and tra.fecha = "'.$fecha.'") as ot_total_venta,
(select sum(utilidad) from calculadora_transferencias as tra where tra.pais = 1 and tra.calculadora_tienda_id = calculadora_tienda.id and tra.fecha = "'.$fecha.'") as ot_utilidad,
(select sum(edt_tot) from calculadora_transferencias as tra where tra.pais = 2 and tra.calculadora_tienda_id = calculadora_tienda.id and tra.fecha = "'.$fecha.'") as co_total_venta,
(select sum(utilidad) from calculadora_transferencias as tra where tra.pais = 2 and tra.calculadora_tienda_id = calculadora_tienda.id and tra.fecha = "'.$fecha.'") as co_utilidad
');
        $this->db->from($this->tabla); 
        $this->get_where();

        /*
        (select sum(ing_mnt) from calculadora_transferencias as tra where tra.pais = 1 and tra.calculadora_tienda_id = calculadora_tienda.id and tra.fecha = "'.$fecha.'") as ot_original,
(select sum(edt_mnt) from calculadora_transferencias as tra where tra.pais = 1 and tra.calculadora_tienda_id = calculadora_tienda.id and tra.fecha = "'.$fecha.'") as ot_modificado,
        */

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

        if($post['length'] != -1)
        $this->db->limit($post['length'], $post['start']);
        $query = $this->db->get();
        return $query->result();
        $query->result(); die($this->db->last_query());
    }

    function fetch($limit, $start){
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->tabla);
        //die($this->db->last_query());

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }

    function insert($arrDatos = ''){
        
    	$rs = array();
    	if(is_array($arrDatos)){

    		if($arrDatos['id'] == '' or $arrDatos['id'] == '0'){
    			$this->db->insert($this->tabla, $arrDatos);
    			$lastID = $this->db->insert_id();
                //die($this->db->last_query());

    			$rs['id'] = $lastID;

    		}else{
    			$this->db->where('id', $arrDatos['id']);
    			$this->db->update($this->tabla, $arrDatos);
    			$rs = $arrDatos;
    		}
    	}
    	return $rs;
        
    }

    function get_cbo(){
        //$this->db->select('id, nombre, direccion, estado');
        $this->db->from($this->tabla);

        $this->db->where('estado', ON);

        $this->get_where();

        $this->db->order_by('nombre');

        $query = $this->db->get(); 
        $rs = $query->result_array();
        return $rs;
    }

    function get_vista(){
        $rs = array();
            $this->db->from($this->tabla);
            
            $this->get_where();

            $query = $this->db->get(); 
            $rs = $query->result();
            //die($this->db->last_query());


        if(count($rs)>0){   
            foreach ($rs[0] as $key => $value) {
                $arrRs[$key]=$value;
            }
            return $arrRs;
        }else{
            return array();
        }
    }

    function vista($swjson = true){
    	$this->db->from($this->tabla);
		$this->db->select('id, nombre, descripcion, estado');
        
		$query = $this->db->get(); 
		$rsdatos = $query->result();

        if($swjson)
        {
            $jsonrs = json_encode($rsdatos);
        }else{
            $jsonrs = $rsdatos;
        }

		return $jsonrs;
    }

    function delete($id){

        $arrayIds = explode(',', $id);


        $arrayTablasExistencia = array('oferta');

        $arrayEvento = array();
        
        $nroEliminiados = 0; $nroAnulados=0;

        foreach ($arrayIds as $idActual) {
            $nroConsultas = 0; 
            foreach ($arrayTablasExistencia as $tabla) {
                $this->db->where('mercados_id',$idActual);
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
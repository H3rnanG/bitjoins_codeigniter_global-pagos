<?php 
/*
 * Created on 28/09/2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Transferencias_model extends CI_Model {
	var $id = 'id';
	var $tabla = 'calculadora_transferencias';
    var $arrWhere = array();

    var $column_order = array(null,null,'log.nombres','ti.nombre','ing_mnt','edt_sbt','edt_tot','edt_tc','edt_appago','edt_mnt','tran.fecha','hora','adjunto');
    var $column_search = array('log.usuario','log.nombres','ing_mnt','ing_crg','ing_tipo','ing_com');
    var $order = array('id'=>'DESC');

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
        $this->db->select('tran.id, concat(log.usuario," - ",log.nombres) as usuario, ti.nombre as tienda, tran.pais, ing_mnt, ing_crg, ing_tipo, ing_com, ing_iva, ing_tiva, edt_mnt, edt_sbt, edt_tot, edt_tc, tran.ing_tc, tran.ing_tcact, edt_appago, adjunto, DATE_FORMAT(tran.fecha,"%d-%m-%Y") as fecha_f, hora, tran.formato, tran.print, tran.utilidad, tran.nroboleta');
        $this->db->from($this->tabla.' as tran');
        $this->db->join('calculadora_login as log','log.id = tran.calculadora_login_id', 'left');
        $this->db->join('calculadora_tienda as ti','ti.id = tran.calculadora_tienda_id', 'left');

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
        $query->result(); die($this->db->last_query());

    }

    function count_filtered()
    {
        $this->get_datatables_vista();

        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all()
    {
        //$this->get_where();

        $this->db->from($this->tabla);
        return $this->db->count_all_results();
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
        //$this->db->select('id, nombre, zona_fdx_ie, zona_dhl_ie');
        $this->db->from($this->tabla);
        $this->db->where('estado', ON);
        $this->db->order_by('usuario');
        $query = $this->db->get(); 
        $rs = $query->result_array();
        return $rs;
    }

    function get_vista(){
        $rs = array();
        $this->db->from($this->tabla);
        
        $this->get_where();

        $query = $this->db->get(); 
        $rs = $query->result_array();
        //die($this->db->last_query());


        if($rs){
            foreach ($rs as $key => $value) {
                $arrRs[$key]=$value;
            }
            return $arrRs;
        }else{
            return array();
        }
    }

    function vista($swjson = true){
    	$this->db->from($this->tabla);
		//$this->db->select('id, nombre, descripcion, estado');
        
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
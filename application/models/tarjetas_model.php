<?php 
/*
 * Created on 28/09/2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Tarjetas_model extends CI_Model {
	var $id = '';
	var $tabla = 'recargas_tarjetas';
    var $arrWhere = array(); 

    var $column_order = array(null,null,'a.monto','a.foto','a.fechareg','a.horareg','d.usuario','c.nroope','fechacomp','horacomp','digitos','estado');
    var $column_search = array('a.digitos','a.monto','d.usuario','c.nroope');
    var $order = array('a.monto, a.fechareg'=>'ASC'); //, a.id

	function __construct()
    {
        parent::__construct();
    }

    function modelo(){
        $arrayModelo = array('tabla' => $this->tabla, 
                             'campos' => array(
                                            //'codigo' => 'unique|required',
                                            'usuario' => 'unique|required',
                                            'password' => 'required',
                                            'nombres' => 'required'
                                            )
                            );
        return $arrayModelo;
    }

    function set_where($where = array()){
        if(count($where) > 0){
            array_push($this->arrWhere,$where);
        }
    }

    function get_where(){
        if(count($this->arrWhere)){
            //var_dump($this->arrWhere); die;
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
        $this->db->select('a.id, a.monto, a.foto, DATE_FORMAT(a.fechareg,"%d-%m-%Y") as fechareg_f, a.horareg, d.usuario, c.nroope, DATE_FORMAT(a.fechacomp,"%d-%m-%Y") as fechacomp_f, a.horacomp, a.digitos, a.estado, a.tipo');
        $this->db->join('recargas_x_tarjetas as b', 'a.id = b.recargas_tarjetas_id','left');
        $this->db->join('recargas as c', 'c.id = b.recargas_id','left');
        $this->db->join('usuario as d', 'd.id = c.usuario_id','left');

        
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
    

    function count() {
        return $this->db->count_all($this->tabla);
    }

    function fetch($limit=12, $start=0){
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
    			$rs['id'] = $lastID;
    		}else{
    			$this->db->where('id', $arrDatos['id']);
    			$this->db->update($this->tabla, $arrDatos);
    			$rs = $arrDatos;
    		}
    	}
        //die($this->db->last_query());
    	return $rs;
    }

    function get_tc_disponible(){
        $this->db->select('id, monto, foto');
        $this->db->from($this->tabla);

        $this->get_where();

        //$this->db->where('estado', ON);
        $this->db->order_by('id','asc');
        $this->db->limit(1);

        $query = $this->db->get(); 
        $rs = $query->result_array();
        return $rs;
    }

    function get_cbo(){
        $this->db->select('id, monto');
        $this->db->from($this->tabla);

        $this->db->where('estado', ON);
        $this->db->order_by('nombre');

        $query = $this->db->get(); 
        $rs = $query->result();
        return $rs;
    }

    function get_tarjeta_recarga(){
        $this->db->select('a.id, a.monto, a.foto, a.digitos, a.tipo, a.nmt as numero, a.nmc as code, a.exp as fecha, a.mon as moneda');
        $this->db->from($this->tabla.' as a');
        $this->db->join('recargas_x_tarjetas as b', 'b.recargas_tarjetas_id = a.id','inner');
        $this->db->join('recargas as c','c.id = b.recargas_id','inner');
        $this->get_where();

        $query = $this->db->get(); 
        $rs = $query->result_array();
        return $rs;
    }

    function get_vista($id){
        $this->db->from($this->tabla);
        //$this->db->select('monto, foto, fechareg, horareg, fechacomp, horacomp, digitos, estado');
        $this->db->where('id', $id);

        $query = $this->db->get(); 
        $rs = $query->result_array();

        /*if(count($rs)>0){   
            foreach ($rs[0] as $key => $value) {
                $arrRs[$key]=$value;
            }
            return $arrRs;
        }else{
            return array();
        }*/
        return $rs;
    }

    function get_inventario(){
        $this->db->from($this->tabla.' as a');
        $this->db->select('a.monto, count(*) as inventario');
        $this->db->where('a.estado', '1');
        $this->db->group_by('a.monto');

        $query = $this->db->get(); 
        $rs = $query->result_array();
        //die($this->db->last_query());
        return $rs;
    }

    function vista($swjson = true){
    	$this->db->from($this->tabla);
		$this->db->select('monto, foto, fechareg, horareg, fechacomp, horacomp, digitos, estado');
        
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
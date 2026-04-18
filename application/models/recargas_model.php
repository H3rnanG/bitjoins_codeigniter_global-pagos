<?php 
/*
 * Created on 28/09/2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Recargas_model extends CI_Model {
	var $id = '';
	var $tabla = 'recargas';
    var $arrWhere = array();

    var $column_order = array(null,null,'a.estado','a.nroope','b.usuario','a.monto_usd','a.monto_clp','a.tipocambio','a.metodopago','a.payment_url','a.fechareg','a.fechamail','a.envio');
    var $column_search = array('a.estado','a.nroope','b.usuario','a.monto_usd','a.monto_clp','a.tipocambio','a.metodopago','a.payment_url','a.fechareg','a.fechamail','a.envio');
    var $order = array('a.fechareg'=>'DESC'); //, a.id

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

    function set_where($where = array()){
        array_push($this->arrWhere,$where);
    }

    function get_where(){
        if(count($this->arrWhere)){
            foreach ($this->arrWhere as $where) {
                foreach ($where as $key => $value) {
                    $this->db->where($key, $value);
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
        $this->db->select('a.estado, a.nroope, b.usuario, a.monto_usd, a.monto_clp, a.tipocambio, a.metodopago, a.payment_url, a.fechareg, a.fechamail, a.envio, d.digitos, d.foto, b.latlon as latlon_u, a.latlon');
        $this->db->join('usuario as b', 'b.id = a.usuario_id','left');
        $this->db->join('recargas_x_tarjetas as c', 'c.recargas_id = a.id','left');
        $this->db->join('recargas_tarjetas as d', 'd.id = c.recargas_tarjetas_id','left');

        
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

    function get_datatables($op = 1){
        $post = $this->input->post();

        if($op == 2){
            $this->get_datatables_rptventa();
        }else{
            $this->get_datatables_vista();
        }

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

    function get_datatables_rptventa()
    {
        $post = $this->input->post();

        $this->db->from($this->tabla.' as a');
        $this->db->select('a.monto_usd as tarjeta, sum(a.monto_clp) as clp, sum(a.monto_usd) as usd');
        $this->db->group_by('a.monto_usd');
        /*
        $this->db->join('usuario as b', 'b.id = a.usuario_id','left');
        $this->db->join('recargas_x_tarjetas as c', 'c.recargas_id = a.id','left');
        $this->db->join('recargas_tarjetas as d', 'd.id = c.recargas_tarjetas_id','left');
        */
        
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
                unset($arrDatos['id']);
    			$this->db->update($this->tabla, $arrDatos);
    			$rs = $arrDatos;
    		}
    	}
    	return $rs;
        
    }

    function get_cbo(){
        $this->db->select('id, nombre, descripcion');
        $this->db->from($this->tabla);

        $this->db->where('estado', ON);
        $this->db->order_by('nombre');

        $query = $this->db->get(); 
        $rs = $query->result();
        return $rs;
    }

    function get_pendientes(){

        $fecact = date('Y-m-d H:i:s');
        //year(sba.fechareg)>'2019' and 
        $this->db->select("TIMESTAMPDIFF(minute, a.fechaconf, '".$fecact."') as dif, TIMESTAMPDIFF(minute, a.fechareg, '".$fecact."') as timereg, '".$fecact."' as fec, (select count(sba.id) from recargas as sba where sba.usuario_id = b.id) as nrorec, a.id, a.nroope, a.monto_usd, a.monto_clp, a.tipocambio, a.fechaconf, a.estado, a.payment_id, b.usuario, b.nombres, b.apellidos, b.direccion, b.distrito, b.celular, b.nacionalidad, b.documento, b.fechareg");
        $this->db->from($this->tabla.' as a');
        $this->db->join('usuario as b','b.id = a.usuario_id');

        $this->db->where('a.metodopago', MP_KHIPU);
        $this->db->where_in('a.estado', array(P_PENDING, P_VALKHIPU));
        //$this->db->limit(5);
        $query = $this->db->get(); 
        $rs = $query->result_array();

        return $rs;
    }

    function get_recarga_data(){
        $rs = array();
            $this->db->from($this->tabla.' as rec');
            $this->db->join('usuario as usu','usu.id = rec.usuario_id');
            //$this->db->where('rec.nroope', $cod);

            $this->get_where();

            $query = $this->db->get(); 
            $rs = $query->result_array();
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

    function get_vista($cod=''){
        $rs = array();

        /* a.tipopago, */
        $this->db->select('a.id, a.nroope, a.usuario_id, a.monto_usd, a.monto_clp, a.tipocambio, a.fechareg, a.fechaconf, a.horaconf, a.fechamail, a.metodopago, a.estado, a.payment_id, a.payment_url, a.envio, b.usuario, b.nombres, b.apellidos, b.celular, b.telefono, b.fechareg, b.sw, b.estado, b.ip, b.pais, b.ciudad, b.latlon, (select count(sba.recargas_id) from recargas_x_tarjetas as sba where sba.recargas_id = a.id) as nrotarjeta');
        $this->db->from($this->tabla.' as a');
        $this->db->join('usuario as b','b.id = a.usuario_id');
        $this->db->where('a.nroope', $cod);

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

    function get_tarjeta(){
        $this->db->select('d.id, d.foto');
        $this->db->from($this->tabla.' as a');
        $this->db->join('usuario as b','b.id = a.usuario_id','left');
        $this->db->join('recargas_x_tarjetas as c','c.recargas_id = a.id','inner');
        $this->db->join('recargas_tarjetas as d','d.id = c.recargas_tarjetas_id','left');

        $this->get_where();
        $query = $this->db->get(); 
        $rs = $query->result_array();
        return $rs;
    }

    function insert_rxt($data=array()){
        $sw = 0;
        if($data){
            $this->db->insert('recargas_x_tarjetas', $data);
            $lastID = $this->db->insert_id();
            if($lastID>0){
                $sw = 1;
            }
        } // fin if
        return $sw;
    }

    function get_ventas(){
        $this->db->from($this->tabla.' as a');
        

        $this->get_where();

        $query = $this->db->get(); 
        $rs = $query->result_array();
        return $rs;
    }

    function get_vista_paymentid(){
        $this->db->select('a.id, a.nroope, a.payment_id, b.usuario');
        $this->db->from($this->tabla.' as a');
        $this->db->join('usuario as b','b.id = a.usuario_id','left');

        $this->get_where();
        $query = $this->db->get(); 
        $rs = $query->result_array();
        return $rs;
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
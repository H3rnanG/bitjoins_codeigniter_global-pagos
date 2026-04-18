<?php 
/*
 * Created on 28/09/2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Usuario_model extends CI_Model {
	var $id = '';
	var $tabla = 'usuario';
    var $arrWhere = array();

    var $column_order = array(null,null,'usuario','nombres','apellidos','direccion','distrito','nrowsp','celular','telefono','nacionalidad','tipodoc','documento','dni1','dni2','DATE_FORMAT(fechareg,"%d-%m-%Y") as fechareg','DATE_FORMAT(fechoraconf,"%d-%m-%Y") as fechoraconf','terminos','estado');
    var $column_search = array('usuario','nombres','apellidos','direccion','distrito','nrowsp','celular','telefono','nacionalidad','tipodoc','documento','dni1','dni2');
    var $order = array('id'=>'ASC');

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
        $this->db->select('*, DATE_FORMAT(fechareg,"%d-%m-%Y") as fechareg, DATE_FORMAT(fechoraconf,"%d-%m-%Y") as fechoraconf');
        //, DATE_FORMAT(fecha_reg,"%d-%m-%Y") as fecha_reg

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
    

    function count() {
        return $this->db->count_all($this->tabla);
    }

    function set_where($where = array()){
        if(count($where) > 0){
            array_push($this->arrWhere,$where);
        }
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

   function updatepass($filtro, $datos){
        if($filtro){
            //$this->db->where('id', $arrDatos['id']);
            $this->db->update($this->tabla, $datos, $filtro);
            //die($this->db->last_query());
        }
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
    	return $rs;
    }

    function insertlog($arrDatos = ''){
        
        $rs = array();
        if(is_array($arrDatos)){

            if($arrDatos['id'] == '' or $arrDatos['id'] == '0'){
                $this->db->insert('usuario_log', $arrDatos);
                $lastID = $this->db->insert_id();
                $rs['id'] = $lastID;
            }else{
                $this->db->where('id', $arrDatos['id']);
                $this->db->update('usuario_log', $arrDatos);
                $rs = $arrDatos;
            }
        }
        return $rs;
        
    }

    function get_login($usu='',$pass=''){
        $datos = array();

        if(strlen($usu) > 0 && strlen($pass) > 0){
            $this->db->from($this->tabla.' as a');
            $this->db->where('usuario', $usu);
            $this->db->where('password', $pass);
            //$this->db->where('sw',ON); 
            $this->db->select("a.id, concat(a.nombres, ' ', a.apellidos) as nombres, a.usuario, a.direccion, a.telefono, a.sw, a.token, a.password as ps, a.celular,
                (select count(sb.id) from recargas as sb where year(sb.fechareg)>'2019' and sb.usuario_id = a.id) as nrorec");
            $query = $this->db->get(); 
            $rs = $query->result();

            if($rs){
                foreach ($rs as $fila) {
                    $datos['id'] = $fila->id;
                    $datos['nombres'] = $fila->nombres;
                    $datos['usuario'] = $fila->usuario;
                    $datos['sw'] = $fila->sw;
                    $datos['ps'] = $fila->ps;
                    $datos['celular'] = $fila->celular;
                    $datos['nrorec'] = $fila->nrorec;
                }
            }
        }

        return $datos;
    }

    function get_existe_usuario($usu=''){
        $nro = 0;

        if(strlen($usu) > 0){
            $this->db->from($this->tabla);
            $this->db->where('usuario', $usu);
            $this->db->select('count(id) as nro');
            $query = $this->db->get(); 
            $rs = $query->result();

            if($rs){
                $nro = $rs[0]->nro;
            }
        }
        
        return $nro;
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

    function get_vista($id){
        $this->db->from($this->tabla.' as usu');
        $this->db->select('usu.*, DATE_FORMAT(fechoraconf,"%Y-%m-%d") as fechoraconf, id as ID, token, celular, password');
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
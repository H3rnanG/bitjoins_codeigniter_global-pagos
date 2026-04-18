<?php 
/*
 * Created on 28/09/2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Constantes_model extends CI_Model {
	var $id = '';
	var $tabla = 'constantes';
    var $arrWhere = array();

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
        if(count($where) > 0){
            array_push($this->arrWhere,$where);
        }
        //var_dump($this->arrWhere);
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

    function fetch($limit, $start){

        //var_dump($this->arrWhere);

        $this->db->select('p.id,p.nombre, p.sku,p.modelo,p.foto,p.urlkey,p.precio,p.precio_especial');
        $this->db->join('producto_x_categoria as pxc','pxc.producto_id = p.id','left');
        $this->db->join('categoria as c','c.id = pxc.categoria_id','left');
        $this->db->group_by('p.id');
        $this->db->limit($limit, $start);
        $this->db->order_by('id');

        if(count($this->arrWhere)){
            foreach ($this->arrWhere as $where) {
                foreach ($where as $key => $value) {
                    $this->db->where($key,$value);
                }
            }
        }
        $query = $this->db->get($this->tabla.' as p');
        //echo $this->db->last_query();

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

    function get_categorias(){
        $this->db->from('categoria');
        $this->db->select('id, nombre, urlkey');
        $this->db->where('estado', ON);
        $this->db->order_by('nombre');

        $query = $this->db->get(); 
        $rs = $query->result();
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

    function get_mas_vendidos(){
        $this->db->from($this->tabla);
        $this->db->select('nombre, foto, urlkey, sku');
        $this->db->where('estado',ON);

        $this->db->order_by('fecha_reg');

        $this->db->limit(12);

        $query = $this->db->get(); 
        $rs = $query->result();
        return $rs;
    }

    function get_fotos($idProd = ''){
        $rs = array();
        if(strlen($idProd) > 0){
            $this->db->from('media as m');
            $this->db->join('producto_x_media as pxm','pxm.media_id = m.id');
            $this->db->where('pxm.producto_id',$idProd);
            $this->db->select('pxm.producto_id as idproducto, m.foto as foto');
            $this->db->group_by('pxm.producto_id, m.foto');
            $this->db->order_by('m.id');
            $query = $this->db->get(); 
            $rs = $query->result();  
        }
        return $rs;
    }

    function get_atributo($idAtr = ''){
        $rs = array();

        if(strlen($idAtr)>0){
            $this->db->from('producto_atributos as pa');
            $this->db->join('producto_x_producto_atributos as pxpa', 'pa.id = pxpa.producto_atributos_id');
            $this->db->where('pa.id',$idAtr);
            $this->db->group_by('pxpa.etiqueta');
            $this->db->order_by('pxpa.etiqueta');
            $this->db->select('pxpa.id, pxpa.etiqueta, pxpa.valor, pxpa.producto_id as idprod, count(pxpa.id) as nroprod');

            $query = $this->db->get();
            $rs = $query->result();
            //die($this->db->last_query());
        }

        return $rs;
    }

    function get_galeria($idProd = '', $idAtr = ''){

        $rs = array();
        if(strlen($idProd) > 0){ //m.foto as foto, 
            //$columnaFoto = '(select foto from  media as m inner join producto_x_producto_atributos as pxpa where m.producto_atributos_id = pxpa.producto_atributos_id and pxpa.producto_id = pxpa.producto_id group by pxpa.producto_atributos_id, pxm.producto_id) as foto';
            //.$columnaFoto
            $this->db->select('pxpa.producto_id as idproducto, pxpa.etiqueta as etiqueta, pxpa.valor as dato, pxpa.tipo as tipo, m.foto as foto');
            $this->db->from('producto_x_producto_atributos as pxpa');
            $this->db->join('media as m','m.producto_atributos_id = pxpa.id','left');
            $this->db->where('pxpa.producto_id',$idProd);
            $this->db->order_by('m.id');

            if(strlen($idAtr) >0){
                $this->db->where('pxpa.producto_atributos_id',$idAtr);
            }

            $query = $this->db->get();
            $rs = $query->result();
            //die($this->db->last_query());

        }
        
        return $rs;
    }

    function get_vista_categoria($urlkey = ''){
        $rs = array();
        if(strlen($urlkey) > 0){
            $this->db->from('categoria');
            $this->db->where('urlkey', $urlkey);
            $query = $this->db->get(); 
            $rs = $query->result();

            if(count($rs)>0){   
                foreach ($rs[0] as $key => $value) {
                    $arrRs[$key]=$value;
                }
                return $arrRs;
            }else{
                return array();
            }
        }
    }

    function get_vista($id){
        $this->db->from($this->tabla);
        $this->db->where('id', $id);

        $query = $this->db->get(); 
        $rs = $query->result();

        if(count($rs)>0){   
            foreach ($rs[0] as $key => $value) {
                $arrRs[$key]=$value;
            }
            return $arrRs;
        }else{
            return array();
        }
    }

    function get_producto($urlkey=''){

        $arrRs = array();

        if(strlen($urlkey) > 0){

            $this->db->select('p.id, p.nombre, p.sku, p.descripcion, p.descripcion_larga, p.foto, p.etiqueta_oferta, p.meta_title, p.meta_descripcion, p.precio, p.precio_especial, pm.foto as logo, p.urlkey, p.accesorios, p.modelo');
            $this->db->from($this->tabla.' as p');
            $this->db->join('producto_marca as pm','p.producto_marca_id = pm.id');

            $this->db->where('p.sw_visible', ON);
            $this->db->where('p.estado', ON);
            $this->db->where('p.urlkey', $urlkey);

            $query = $this->db->get(); 
            $rs = $query->result();
            //die($this->db->last_query());
            
            if(count($rs)>0){   
                foreach ($rs[0] as $key => $value) {
                    $arrRs[$key]=$value;
                }
                return $arrRs;
            }
        }

        return $arrRs;
        
    }

    function get_relacionados($idProd = ''){
        $rs = array();

        if(strlen($idProd) > 0){
            $this->db->from('producto_relacionados');

        }

        return $rs;
    }

    function vista($swjson = true){
    	$this->db->from($this->tabla);
		$this->db->select('*, DATE_FORMAT(fechaact,"%d-%m-%Y") as fechaact');

        $this->get_where();
        
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
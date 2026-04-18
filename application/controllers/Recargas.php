<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Recargas extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 var $idusuario = '';
	 var $arrayEstado = array(1=>'Activo',2=>'Desactivo');
	 var $arrayTipoDoc = array(1=>'DNI', 2=>'PASSAPORTE', 3=>'CARNET DE EXTRANJERIA');
	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('America/Santiago');

		$this->load->library('utilitario');
	} 

	private function login(){
		$idusuario = $this->session->userdata('idusuario');
		$tipousu = $this->session->userdata('tipousu');

		$logout = base_url('login/logout');
		//die(strlen($idusuario));
		if(strlen($idusuario) == 0){
			header('Location: '.$logout);
		}
	}

	public function index(){
		$this->login();

		$this->load->model('recargas_model','recargas');

		$carpeta = 'admin';
		$arr_header['usuario'] = $this->session->userdata('nombre');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);
		$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);

		$this->load->view($carpeta.'/recargas_vista',$data);
	}

	public function ajax_vista_recargas(){

		$this->login();		
		$this->load->model('recargas_model','recargas');

		$filtro = $this->input->post('fil');
		$arrRpFiltro = array();
		if(strlen($filtro)>0){

			$arrFiltro = explode('|', $filtro);
			if($arrFiltro){
				$dt = $arrFiltro[0];
				if($dt){
					$f1 = $dt.' 00:00:00';
					$f2 = $dt.' 23:59:59';
					$this->db->where("a.fechareg >= '".$f1."' and a.fechareg <= '".$f2."'");
					//$this->db->where('a.fechareg <= '.$f2);
					//$arrRpFiltro['a.fechareg'] = $dt;
				}

				$dt = $arrFiltro[1];
				if($dt){
					$arrRpFiltro['a.estado'] = $dt;
				}
			} // fin filtro 

			if($arrRpFiltro){
				$this->recargas->set_where($arrRpFiltro);
			} // fin if 
		} // fin if $filtro
		//var_dump($arrRpFiltro); die;

		$list = $this->recargas->get_datatables();
		$data = array();
        $no = $this->input->post('start'); 
        foreach ($list as $obj) {
            $no++;
            $row = array();

            if($obj->estado == P_VALKHIPU){
            	$estado = 'Khipu: Validando';
            }else if($obj->estado == P_CANCEL){
            	$estado = 'Anulado';
            }else if($obj->estado == P_CONFIRM){
            	$estado = 'Confirmado';
            }else{
            	$estado = 'Pendiente';
            }
	        
            $row[] = $no;
            $row[] = $estado;
            $row[] = $obj->nroope;
            $row[] = $obj->usuario;
            $row[] = '$ '.$obj->monto_usd; // 
            $row[] = 'CLP '.$obj->monto_clp; // 
            $row[] = $obj->tipocambio; // 

            if($obj->metodopago == MP_KHIPU){
            	$metodopago = 'Khipu';
            }else if($obj->metodopago == MP_BANCHILE){
            	$metodopago = 'Transferencia';
            }else{
            	$metodopago = 'Administrador';
            }

            $row[] = $metodopago; // 
            $row[] = '<a href="'.$obj->payment_url.'" target="_blank" ><i class="fa fa-external-link"></i></a>';
            $row[] = '<a data-fancybox="gallery" href="'.base_url('assets/upload/temptc/'.$obj->foto).'"><i class="fa fa-credit-card-alt"></i> '.$obj->digitos.'</a>';

            $row[] = date("d-m-Y H:i:s", strtotime($obj->fechareg)); // 

            if($obj->fechamail){
            	$row[] = date("d-m-Y H:i:s", strtotime($obj->fechamail)); // $obj->fechamail; // 
            }else{
            	$row[] = '';
            }

            $latlon = trim($obj->latlon);
            if(strlen($latlon) == 0){
            	$latlon = $obj->latlon_u;
            }
            $urlMap = 'https://www.google.com/maps/search/'.$latlon.'/17z';
            $row[] = '<a href="'.$urlMap.'" target="_blank"><i class="fa fa-map-marker fa-2x"></i></a>';

            if($obj->envio == 'W'){
            	$envio = 'Sitio Web';
            }else{
            	$envio = 'Robot Server';
            }
            $row[] = $envio; // 
            
            $data[] = $row;
        }

		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->recargas->count_all(),
                "recordsFiltered" => $this->recargas->count_filtered(),
                "data" => $data,
        );

		echo json_encode($output);
	}

	public function ajax_vista_ventas(){

		$this->login();		
		$this->load->model('recargas_model','recargas');

		$filtro = $this->input->post('fil');
		$arrRpFiltro = array();
		if(strlen($filtro)>0){

			$arrFiltro = explode('|', $filtro);
			if($arrFiltro){
				$dt = $arrFiltro[0];
				if($dt){
					//$arrRpFiltro['a.fechareg'] = $dt;
					$f1 = $dt.' 00:00:00';
					$this->db->where("a.fechareg >='".$f1."'");
				}

				$dt = $arrFiltro[1];
				if($dt){
					//$arrRpFiltro['a.fechareg'] = $dt;
					$f2 = $dt.' 23:59:59';
					$this->db->where("a.fechareg <='".$f2."'");
				}

				

			} // fin filtro 

			if($arrRpFiltro){
				$this->recargas->set_where($arrRpFiltro);
			} // fin if 
		} // fin if $filtro

		//var_dump($arrRpFiltro); die;

		$list = $this->recargas->get_datatables(2);
		$data = array();
        $no = $this->input->post('start'); 
        foreach ($list as $obj) {
            $no++;
            $row = array();
	        
            $row[] = $obj->tarjeta;
            $row[] = $obj->usd; // 
            $row[] = $obj->clp; // 
            
            $data[] = $row;
        }


		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->recargas->count_all(),
                "recordsFiltered" => $this->recargas->count_filtered(),
                "data" => $data,
        );

		echo json_encode($output);
	}

	public function get_recargas(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$this->load->model('recargas_model','recargas');

		//$id = $this->uri->segment(3);
		$id = trim($this->input->post('id'));
		$rs = $this->recargas->get_vista($id);
		echo json_encode($rs);
	}

}
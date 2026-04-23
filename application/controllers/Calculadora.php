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

class Calculadora extends CI_Controller {
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
		$idusuario = $this->session->userdata('nro_rut');

		$logout = base_url('calculadora');
		//die(strlen($idusuario));
		if(strlen($idusuario) == 0){
			header('Location: '.$logout);
		}
	}

	public function index(){	
		$idusuario = $this->session->userdata('nro_rut'); //usuario
		$carpeta = 'calculadora';
		$arr_nav = array();
		$this->load->view($carpeta.'/login');
	}

	public function loguear(){
		header('Content-type: application/json; charset=utf-8');
		//
		$this->load->model('calculadora/login_model','usuario');
		$this->load->model('constantes_model','constantes');
		$rut = trim($this->input->post('rut'));
		$pass = trim($this->input->post('pass'));
		$pass = sha1(STRKEY.$pass);  


		//762170272
		$filtro = array('usuario'=>$rut);
		$this->usuario->set_where($filtro);
		$rs = $this->usuario->get_vista();

		//var_dump($rs); die('loguin');
		
		if($rs){
			$passusu = sha1(STRKEY.$rs['password']);

			$user_email = $rs['user_email'];

			if($pass == $passusu){

				$idusu = $rs['id'];
				$this->session->set_userdata('idusuario', $idusu);
				$this->session->set_userdata('nro_rut', $rut);
				$this->session->set_userdata('cargo', $rs['comision_cargo']);
				$this->session->set_userdata('dscto', $rs['tc_dscto']);
				$this->session->set_userdata('formato', $rs['formato']);
				$this->session->set_userdata('idsupervisor', $rs['login_parent']);
				$this->session->set_userdata('idtienda', $rs['calculadora_tienda_id']);

				$rang1 = $this->constantes->get_vista(4);
				$this->session->set_userdata($rang1['constante'], $rang1['variable']);

				$rang2 = $this->constantes->get_vista(5);
				$this->session->set_userdata($rang2['constante'], $rang2['variable']);

				$rang3 = $this->constantes->get_vista(UTILIDAD);
				$this->session->set_userdata($rang3['constante'], $rang3['variable']);

				$ip = $this->utilitario->getRealIP();
				$page = 'https://ipinfo.io/'.$ip;
				$json = @file_get_contents($page);
				$arr = json_decode($json);

				$data_ip = $ip;
				$data_pais = isset($arr->country) ? Locale::getDisplayRegion('-'.$arr->country,'es') : 'Unknown'; 
				$data_ciudad = isset($arr->city) ? $arr->city : 'Unknown';
				$data_latlon = isset($arr->loc) ? $arr->loc : '0,0';
				$fecha_hora = date('Y-m-d G:i:s');

				$arr_login_ses = array('ip' => $data_ip,
										'pais' => $data_pais,
										'ciudad' => $data_ciudad,
										'latlon' => $data_latlon,
										'last_login' => $fecha_hora,
										);

				$this->usuario->update_login($arr_login_ses, $idusu);


				/*
				$token = $this->utilitario->getCodigo();
				//$this->session->set_userdata('temporal', $senio.$idUsuario);
				$this->email_info($user_email, $token, $data_latlon, $data_pais, $data_ciudad, $data_ip);

				$arrayResp = array('status'=>true, 'cd'=>$token, 'mensaje'=>'Se envio un código de acceso al correo para validar su acceso.', 'redirect'=>base_url('calculadora/calc1'));
				//)

				die(json_encode($arrayResp));
				*/
				header('Location: '.base_url('calculadora/calc1'));
			}
		}else{
			/*
			$arrayResp = array('status'=>false, 'mensaje'=>'Acceso denegado.');
			die(json_encode($arrayResp));
			*/
		}
	}

	private function email_info($usuario='', $token = '', $latlong='',$pais='', $ciudad='', $ip=''){ //
		
		$this->load->library('utilitario');
		$this->load->library('email');
		//$this->load->library('turboemail');

		$data['token'] = $token;
		$data['usuario'] = $usuario;
		$data['latlong'] = $latlong;
		$data['pais'] = $pais;
		$data['ciudad'] = $ciudad;
		$data['ip'] = $ip;

		$message = $this->load->view('admin/template_token', $data, TRUE);

		$this->email->from('soporte@astropaycard.cl', 'Global Pagos');
		$this->email->subject('Global Pagos - Token de acceso');
		$this->email->message($message);
		//$this->email->to($usuario);
		$this->email->cc('anthony1585@gmail.com');
		
	    $swSend = 0;
        if($this->email->send()){
        	$swSend = 1;
        }

        echo $swSend;
        
	}

	/**************************CHILE EXPRESS****************************/
	
	public function chileexpress(){
		$this->login();

		$carpeta = 'calculadora';
		$arr_header['usuario'] = $this->session->userdata('nro_rut');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);

		$idsupervisor = $this->session->userdata('idsupervisor');
		if($idsupervisor == 0){
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav_sup', $arr_nav, TRUE);
		}else{
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);
		}

		$data['cargo'] = $this->session->userdata('cargo');
		$data['dscto'] = $this->session->userdata('dscto');
		$data['formato'] = $this->session->userdata('formato');

		$this->load->view($carpeta.'/ticket_chile_express',$data);
	}

	/************************** / CHILE EXPRESS****************************/

	/**************************BILLETERA****************************/
	public function billetera(){
		$this->login();
		
		$carpeta = 'calculadora';
		$arr_header['usuario'] = $this->session->userdata('nro_rut');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);

		$idsupervisor = $this->session->userdata('idsupervisor');
		if($idsupervisor == 0){
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav_sup', $arr_nav, TRUE);
		}else{
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);
		}

		$data['cargo'] = $this->session->userdata('cargo');
		$data['dscto'] = $this->session->userdata('dscto');
		$data['formato'] = 1; //$this->session->userdata('formato');
		$data['v_nro_rut'] = $this->session->userdata('nro_rut');

		$rg1 = $this->session->userdata('CLC_0_60');
		$rg1 = explode('-', $rg1);
		$data['rg1_1'] = $rg1[0];
		$data['rg1_2'] = $rg1[1];

		$rg2 = $this->session->userdata('CLC_61_100');
		$rg2 = explode('-', $rg2);
		$data['rg2_1'] = $rg2[0];
		$data['rg2_2'] = $rg2[1];

		//$data['cargo'] = ;
		$data['dscto'] = $this->session->userdata('dscto');

		$data['v_UTILIDAD'] = $this->session->userdata('UTILIDAD');

		$this->load->view($carpeta.'/ticket_billetera',$data);
	}


	//ticket billetera
	public function ticket_billetera(){
		$this->login();
		$this->load->model('calculadora/transferencias_model','transferencias');

		$formato = $this->input->post('adjunto');
		$data['formato'] = $formato;

		if($formato){
			$monto = $this->input->post('edt_mnt');
			$data['mnt_total'] = str_replace(',', '', $monto);
			
			$edt_sbt = $this->input->post('edt_sbt');
			$data['edt_sbt'] = str_replace(',', '', $edt_sbt);

			$edt_crg = $this->input->post('edt_crg');
			$data['edt_crg'] = str_replace(',', '', $edt_crg);

			$edt_tc = $this->input->post('edt_tc');
			$data['edt_tc'] = str_replace(',', '', $edt_tc);

			$edt_appago = $this->input->post('edt_appago');
			$data['edt_appago'] = str_replace(',', '', $edt_appago);

			$edt_formato = $this->input->post('edt_formato');
			$data['edt_formato'] = $edt_formato;

			$print = $this->input->post('edt_print');
			$data['print'] = $print;
			
			$calculadora_login_id = $this->session->userdata('idusuario');
			$idtienda = $this->session->userdata('idtienda');

			$ing_pais = $this->input->post('ori_pais');
			$ing_mnt = str_replace(',', '', $this->input->post('ori_mnt'));
			$ing_crg = str_replace(',', '', $this->input->post('ori_crg'));
			$ing_crg_2 = str_replace(',', '', $this->input->post('ori_crg_2'));
			$ing_tipo = str_replace(',', '', $this->input->post('ori_tipo'));
			$ing_com = str_replace(',', '', $this->input->post('ori_com'));
			$ing_iva = str_replace(',', '', $this->input->post('ori_iva'));
			$ing_tiva = str_replace(',', '', $this->input->post('ori_tiva'));
			$ing_tiva_2 = str_replace(',', '', $this->input->post('ori_tiva_2'));
			$ing_dct = str_replace(',', '', $this->input->post('ori_dct')); 
			$ing_tc = str_replace(',', '', $this->input->post('ori_tc')); 
			$ing_tcact = str_replace(',', '', $this->input->post('ori_tcact')); 
			$ing_appago = str_replace(',', '', $this->input->post('ori_appago')); 

			$utilidad = str_replace(',', '', $this->input->post('utilidad')); 
			$nroboleta = $this->input->post('nroboleta'); 

			$edt_mnt = str_replace(',', '', $this->input->post('edt_mnt'));
			$edt_sbt = str_replace(',', '', $this->input->post('edt_sbt'));
			$edt_tot = str_replace(',', '', $this->input->post('edt_tot'));
			$edt_tc = str_replace(',', '', $this->input->post('edt_tc'));
			$edt_appago = str_replace(',', '', $this->input->post('edt_appago'));
			$adjunto = $this->input->post('adjunto');
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');

			$datos = array( 'id' => '',
							'calculadora_login_id'=>$calculadora_login_id,
							'calculadora_tienda_id' => $idtienda,
							'pais' => $ing_pais,
							'ing_mnt' => $ing_mnt,
							'ing_crg' => $ing_crg,
							'ing_crg_2' => $ing_crg_2,
							'ing_tipo' => $ing_tipo,
							'ing_com' => $ing_com,
							'ing_iva' => $ing_iva,
							'ing_tiva' => $ing_tiva,
							'ing_tiva_2' => $ing_tiva_2,
							'ing_dct' => $ing_dct,
							'ing_tc' => $ing_tc,
							'ing_tcact' => $ing_tcact,
							'ing_appago' => $ing_appago,
							'edt_mnt' => $edt_mnt,
							'edt_sbt' => $edt_sbt,
							'edt_tot' => $edt_tot,
							'edt_tc' => $edt_tc,
							'edt_appago' => $edt_appago,
							'adjunto' => $adjunto,
							'fecha' => $fecha,
							'hora' => $hora,
							'formato' => $edt_formato,
							'print' => $print,
							'utilidad' => $utilidad,
							);

			if($nroboleta > 0){
				$datos['nroboleta'] = $nroboleta;
			}

			$this->transferencias->insert($datos);
			$carpeta = 'calculadora';
			//die('>>>>>>>> '.$edt_formato);
			if($edt_formato == 1){
				$this->load->view($carpeta.'/ticket_billetera_pdf_1', $data);
			}else if($edt_formato == 2){
				$this->load->view($carpeta.'/ticket_billetera_pdf_2', $data);
			}
		} // fin $formato
	} // fin ticket billetera


	//ticket billetera colombia
	public function ticket_billetera_colombia(){
		$this->login();
		$this->load->model('calculadora/transferencias_model','transferencias');

		$formato = $this->input->post('co_adjunto');
		$data['formato'] = $formato;

		if($formato){
			$monto = $this->input->post('co_edt_mnt');
			$data['mnt_total'] = str_replace(',', '', $monto);
			
			$edt_sbt = $this->input->post('co_edt_sbt');
			$data['edt_sbt'] = str_replace(',', '', $edt_sbt);

			$edt_crg = $this->input->post('co_edt_crg');
			$data['edt_crg'] = str_replace(',', '', $edt_crg);

			$edt_tc = $this->input->post('co_edt_tc');
			$data['edt_tc'] = str_replace(',', '', $edt_tc);

			$edt_appago = $this->input->post('co_edt_appago');
			$data['edt_appago'] = str_replace(',', '', $edt_appago);

			$edt_formato = $this->input->post('co_edt_formato');
			$data['edt_formato'] = $edt_formato;

			$print = $this->input->post('co_edt_print');
			$data['print'] = $print;
			
			$calculadora_login_id = $this->session->userdata('idusuario');
			$idtienda = $this->session->userdata('idtienda');

			$ing_pais = $this->input->post('co_ori_pais');
			$ing_mnt = str_replace(',', '', $this->input->post('co_ori_mnt'));
			$ing_crg = str_replace(',', '', $this->input->post('co_ori_crg'));
			$ing_crg_2 = str_replace(',', '', $this->input->post('co_ori_crg_2'));
			$ing_tipo = str_replace(',', '', $this->input->post('co_ori_tipo'));
			$ing_com = str_replace(',', '', $this->input->post('co_ori_com'));
			$ing_iva = str_replace(',', '', $this->input->post('co_ori_iva'));
			$ing_tiva = str_replace(',', '', $this->input->post('co_ori_tiva'));
			$ing_tiva_2 = str_replace(',', '', $this->input->post('co_ori_tiva_2'));
			$ing_dct = str_replace(',', '', $this->input->post('co_ori_dct')); 
			$ing_tc = str_replace(',', '', $this->input->post('co_ori_tc')); 
			$ing_tcact = str_replace(',', '', $this->input->post('co_ori_tcact')); 
			$ing_appago = str_replace(',', '', $this->input->post('co_ori_appago')); 

			$utilidad = str_replace(',', '', $this->input->post('co_utilidad')); 
			$nroboleta = $this->input->post('co_nroboleta'); 

			$edt_mnt = str_replace(',', '', $this->input->post('co_edt_mnt'));
			$edt_sbt = str_replace(',', '', $this->input->post('co_edt_sbt'));
			$edt_tot = str_replace(',', '', $this->input->post('co_edt_tot'));
			$edt_tc = str_replace(',', '', $this->input->post('co_edt_tc'));
			//$edt_appago = str_replace(',', '', $this->input->post('co_edt_appago'));
			$adjunto = $this->input->post('co_adjunto');
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');

			$datos = array( 'id' => '',
							'calculadora_login_id'=>$calculadora_login_id,
							'calculadora_tienda_id' => $idtienda,
							'pais' => $ing_pais,
							'ing_mnt' => $ing_mnt,
							'ing_crg' => $ing_crg,
							'ing_crg_2' => $ing_crg_2,
							'ing_tipo' => $ing_tipo,
							'ing_com' => $ing_com,
							'ing_iva' => $ing_iva,
							'ing_tiva' => $ing_tiva,
							'ing_tiva_2' => $ing_tiva_2,
							'ing_dct' => $ing_dct,
							'ing_tc' => $ing_tc,
							'ing_tcact' => $ing_tcact,
							'ing_appago' => $ing_appago,
							'edt_mnt' => $edt_mnt,
							'edt_sbt' => $edt_sbt,
							'edt_tot' => $edt_tot,
							'edt_tc' => $edt_tc,
							'edt_appago' => $edt_appago,
							'adjunto' => $adjunto,
							'fecha' => $fecha,
							'hora' => $hora,
							'formato' => $edt_formato,
							'print' => $print,
							'utilidad' => $utilidad,
							);

			if($nroboleta > 0){
				$datos['nroboleta'] = $nroboleta;
			}

			$this->transferencias->insert($datos);
			$carpeta = 'calculadora';
			//die('>>>>>>>> '.$edt_formato);
			if($edt_formato == 1){
				$this->load->view($carpeta.'/ticket_billetera_pdf_1', $data);
			}else if($edt_formato == 2){
				$this->load->view($carpeta.'/ticket_billetera_pdf_2', $data);
			}
		} // fin $formato
	} // fin ticket billetera - Colombia


	/**************************FIN BILLETERA****************************/

	/**************************TICKET****************************/
	public function western(){
		$this->login();

		$carpeta = 'calculadora';
		$arr_header['usuario'] = $this->session->userdata('nro_rut');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);

		$idsupervisor = $this->session->userdata('idsupervisor');
		if($idsupervisor == 0){
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav_sup', $arr_nav, TRUE);
		}else{
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);
		}

		$data['cargo'] = $this->session->userdata('cargo');
		$data['dscto'] = $this->session->userdata('dscto');
		$data['formato'] = $this->session->userdata('formato');

		$this->load->view($carpeta.'/ticket_western',$data);
	}

	public function ticketwestern(){
		$this->login();
		$this->load->model('calculadora/transferencias_model','transferencias');

		$formato = $this->input->post('adjunto');
		$data['formato'] = $formato;

		if($formato){
			$monto = $this->input->post('edt_mnt');
			$data['mnt_total'] = str_replace(',', '', $monto);
			
			$edt_sbt = $this->input->post('edt_sbt');
			$data['edt_sbt'] = str_replace(',', '', $edt_sbt);

			$edt_tc = $this->input->post('edt_tc');
			$data['edt_tc'] = str_replace(',', '', $edt_tc);

			$edt_appago = $this->input->post('edt_appago');
			$data['edt_appago'] = str_replace(',', '', $edt_appago);

			$edt_formato = $this->input->post('edt_formato');
			$data['edt_formato'] = $edt_formato;

			$print = $this->input->post('edt_print');
			$data['print'] = $print;
			
			$calculadora_login_id = $this->session->userdata('idusuario') ;
			$idtienda = $this->session->userdata('idtienda');
			$ing_pais = $this->input->post('ing_pais');
			$ing_mnt = str_replace(',', '', $this->input->post('ing_mnt'));
			$ing_crg = str_replace(',', '', $this->input->post('ing_crg'));
			$ing_tipo = str_replace(',', '', $this->input->post('ing_tipo'));
			$ing_com = str_replace(',', '', $this->input->post('ing_com'));
			$ing_iva = str_replace(',', '', $this->input->post('ing_iva'));
			$ing_tiva = str_replace(',', '', $this->input->post('ing_tiva'));
			$ing_dct = str_replace(',', '', $this->input->post('ing_dct')); 
			$ing_tc = str_replace(',', '', $this->input->post('ing_tc')); 
			$ing_tcact = str_replace(',', '', $this->input->post('ing_tcact')); 
			$ing_appago = str_replace(',', '', $this->input->post('ing_appago')); 
			$edt_mnt = str_replace(',', '', $this->input->post('edt_mnt'));
			$edt_sbt = str_replace(',', '', $this->input->post('edt_sbt'));
			$edt_tot = str_replace(',', '', $this->input->post('edt_tot'));
			$edt_tc = str_replace(',', '', $this->input->post('edt_tc'));
			$edt_appago = str_replace(',', '', $this->input->post('edt_appago'));
			$adjunto = $this->input->post('adjunto');
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');

			$datos = array( 'id' => '',
							'calculadora_login_id'=>$calculadora_login_id,
							'calculadora_tienda_id' => $idtienda,
							'pais' => $ing_pais,
							'ing_mnt' => $ing_mnt,
							'ing_crg' => $ing_crg,
							'ing_tipo' => $ing_tipo,
							'ing_com' => $ing_com,
							'ing_iva' => $ing_iva,
							'ing_tiva' => $ing_tiva,
							'ing_dct' => $ing_dct,
							'ing_tc' => $ing_tc,
							'ing_tcact' => $ing_tcact,
							'ing_appago' => $ing_appago,
							'edt_mnt' => $edt_mnt,
							'edt_sbt' => $edt_sbt,
							'edt_tot' => $edt_tot,
							'edt_tc' => $edt_tc,
							'edt_appago' => $edt_appago,
							'adjunto' => $adjunto,
							'fecha' => $fecha,
							'hora' => $hora,
							'formato' => $edt_formato,
							'print' => $print
							);
			$this->transferencias->insert($datos);
			
			$carpeta = 'calculadora';
			if($edt_formato == 2){
				$this->load->view($carpeta.'/ticket_pdf_2', $data);
			}else{
				$this->load->view($carpeta.'/ticket_pdf', $data);
			}
		} // fin $formato
	}

	public function wuintegrador(){
		$this->login();

		$carpeta = 'calculadora';
		$arr_header['usuario'] = $this->session->userdata('nro_rut');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);

		$idsupervisor = $this->session->userdata('idsupervisor');
		if($idsupervisor == 0){
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav_sup', $arr_nav, TRUE);
		}else{
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);
		}

		$data['cargo'] = $this->session->userdata('cargo');
		$data['dscto'] = $this->session->userdata('dscto');
		$data['formato'] = $this->session->userdata('formato');
		$data['v_nro_rut'] = $this->session->userdata('nro_rut');

		$rg1 = $this->session->userdata('CLC_0_60');
		$rg1 = explode('-', $rg1);
		$data['rg1_1'] = $rg1[0];
		$data['rg1_2'] = $rg1[1];

		$rg2 = $this->session->userdata('CLC_61_100');
		$rg2 = explode('-', $rg2);
		$data['rg2_1'] = $rg2[0];
		$data['rg2_2'] = $rg2[1];

		//$data['cargo'] = ;
		$data['dscto'] = $this->session->userdata('dscto');

		$data['v_UTILIDAD'] = $this->session->userdata('UTILIDAD');

		$this->load->view($carpeta.'/ticket_western_integrado',$data);
	}

	public function ticketwestern_integrado(){
		$this->login();
		$this->load->model('calculadora/transferencias_model','transferencias');

		$formato = $this->input->post('adjunto');
		$data['formato'] = $formato;

		if($formato){
			$monto = $this->input->post('edt_mnt');
			$data['mnt_total'] = str_replace(',', '', $monto);
			
			$edt_sbt = $this->input->post('edt_sbt');
			$data['edt_sbt'] = str_replace(',', '', $edt_sbt);

			$edt_tc = $this->input->post('edt_tc');
			$data['edt_tc'] = str_replace(',', '', $edt_tc);

			$edt_appago = $this->input->post('edt_appago');
			$data['edt_appago'] = str_replace(',', '', $edt_appago);

			$edt_formato = $this->input->post('edt_formato');
			$data['edt_formato'] = $edt_formato;

			$print = $this->input->post('edt_print');
			$data['print'] = $print;
			
			$calculadora_login_id = $this->session->userdata('idusuario');
			$idtienda = $this->session->userdata('idtienda');

			$ing_pais = $this->input->post('ori_pais');
			$ing_mnt = str_replace(',', '', $this->input->post('ori_mnt'));
			$ing_crg = str_replace(',', '', $this->input->post('ori_crg'));
			$ing_crg_2 = str_replace(',', '', $this->input->post('ori_crg_2'));
			$ing_tipo = str_replace(',', '', $this->input->post('ori_tipo'));
			$ing_com = str_replace(',', '', $this->input->post('ori_com'));
			$ing_iva = str_replace(',', '', $this->input->post('ori_iva'));
			$ing_tiva = str_replace(',', '', $this->input->post('ori_tiva'));
			$ing_tiva_2 = str_replace(',', '', $this->input->post('ori_tiva_2'));
			$ing_dct = str_replace(',', '', $this->input->post('ori_dct')); 
			$ing_tc = str_replace(',', '', $this->input->post('ori_tc')); 
			$ing_tcact = str_replace(',', '', $this->input->post('ori_tcact')); 
			$ing_appago = str_replace(',', '', $this->input->post('ori_appago')); 

			$utilidad = str_replace(',', '', $this->input->post('utilidad')); 
			$nroboleta = $this->input->post('nroboleta'); 

			$edt_mnt = str_replace(',', '', $this->input->post('edt_mnt'));
			$edt_sbt = str_replace(',', '', $this->input->post('edt_sbt'));
			$edt_tot = str_replace(',', '', $this->input->post('edt_tot'));
			$edt_tc = str_replace(',', '', $this->input->post('edt_tc'));
			$edt_appago = str_replace(',', '', $this->input->post('edt_appago'));
			$adjunto = $this->input->post('adjunto');
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');

			$datos = array( 'id' => '',
							'calculadora_login_id'=>$calculadora_login_id,
							'calculadora_tienda_id' => $idtienda,
							'pais' => $ing_pais,
							'ing_mnt' => $ing_mnt,
							'ing_crg' => $ing_crg,
							'ing_crg_2' => $ing_crg_2,
							'ing_tipo' => $ing_tipo,
							'ing_com' => $ing_com,
							'ing_iva' => $ing_iva,
							'ing_tiva' => $ing_tiva,
							'ing_tiva_2' => $ing_tiva_2,
							'ing_dct' => $ing_dct,
							'ing_tc' => $ing_tc,
							'ing_tcact' => $ing_tcact,
							'ing_appago' => $ing_appago,
							'edt_mnt' => $edt_mnt,
							'edt_sbt' => $edt_sbt,
							'edt_tot' => $edt_tot,
							'edt_tc' => $edt_tc,
							'edt_appago' => $edt_appago,
							'adjunto' => $adjunto,
							'fecha' => $fecha,
							'hora' => $hora,
							'formato' => $edt_formato,
							'print' => $print,
							'utilidad' => $utilidad,
							);

			if($nroboleta > 0){
				$datos['nroboleta'] = $nroboleta;
			}

			$this->transferencias->insert($datos);
			
			$carpeta = 'calculadora';
			if($edt_formato == 2){
				$this->load->view($carpeta.'/ticket_pdf_2', $data);
			}else if($edt_formato == 1){
				$this->load->view($carpeta.'/ticket_pdf', $data);
			}else if($edt_formato == 3){
				$this->load->view($carpeta.'/ticket_pdf_3', $data);
			}else if($edt_formato == 4){
				$this->load->view($carpeta.'/ticket_pdf_4', $data);
			}
		} // fin $formato
	}

	

	public function facturacion(){
		$this->login();

		$carpeta = 'calculadora';
		$arr_header['usuario'] = $this->session->userdata('nro_rut');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);

		$idsupervisor = $this->session->userdata('idsupervisor');
		if($idsupervisor == 0){
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav_sup', $arr_nav, TRUE);
		}else{
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);
		}

		$this->load->view($carpeta.'/facturacion_vista',$data);
	}

	public function ajax_vista_facturacion(){
		$this->login();
		$this->load->model('calculadora/transferencias_model','transferencias');
		
		$calculadora_login_id = $this->session->userdata('idusuario');
		$fitrar = array();

		$fitrar['calculadora_login_id'] = $calculadora_login_id;
		
		$this->transferencias->set_where($fitrar);

		$this->db->where('nroboleta is NULL');
		$list = $this->transferencias->get_datatables();

		$data = array();
        $no = $this->input->post('start'); //$_POST['start'];
        foreach ($list as $obj) {
            $no++;
            $row = array();
            
            $row[] = '<input type="checkbox" class="chkfact" value="'.$obj->id.'" ><input type="hidden" class="chkuti" value="'.$obj->utilidad.'" >';
            $row[] = $no;
            $row[] = $obj->usuario; 
            $row[] = $obj->fecha_f.' / '.$obj->hora;
            $row[] = $obj->utilidad;

            $data[] = $row;
        }

		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => count($data),
                "recordsFiltered" => count($data),
                "data" => $data,
        );

		echo json_encode($output);
	} // ajax_vista_facturacion

	public function grabar_facturacion(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('calculadora/transferencias_model','transferencias');
		$this->login();
		$carpeta = 'calculadora';
		
		$ids = $this->input->post('idordenes');
		$ids = strlen($ids)>1?explode('-', $ids):array(0=>$ids);
		$nroboleta = $this->input->post('nroboleta');
		$rs = array('status'=>false,'nroids'=>0);
		if($ids){
			//var_dump($ids);
			foreach ($ids as $k => $id) {
				//echo $id.' ---- ';
				if(strlen($id)>0){
					$datos = array('id' => $id,
								'nroboleta' => $nroboleta
								);
					$this->transferencias->insert($datos);
				} // fin id
			} // fin foreach
			$rs = array('status'=>true,'nroids'=>count($ids));
		}
		die( json_encode($rs));
	}

	/**************************CALCULADORA****************************/

	//*************************** UPLOAD *******************************//
	public function upload_ticket()
	{	
		header('Content-type: application/json; charset=utf-8');
		//var_dump($_FILES); die();
		$this->load->library('uploader');
	    $status = "";
	    $msg = "";
	    $archivo = $_FILES['adjticket'];

	    $newfilename = rand(1,99999);
	    $nomarchivo = str_replace('.', '-', $archivo['name']);
	    $path = UPLOAD.'/pdf/';

	    if($archivo){
	    	// 'jpg', 'jpeg', 'png', 'doc', 'docx', , 'ppt', 'pptx', 'xls', 'xlsx'
	    	$data = $this->uploader->upload($archivo, array(
		        'limit' => 1, //Maximum Limit of files. {null, Number}
		        'extensions' => array('pdf'), //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
		        'required' => false, //Minimum one file is required for upload {Boolean}
		        'uploadDir' => $path, //Upload directory {String}
		        'title' => $nomarchivo.'-'.$newfilename, //, '{{random}}' array('auto', 10) //New file name {null, String, Array} *please read documentation in README.md
		        'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
		        'perms' => null, //Uploaded file permisions {null, Number}
		        'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
		        'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
		        'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
		        'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
		        'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
		        //'onRemove' =>  $urlDelete//A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
		    ));
	    } // fin if archivo
	    
	    if($data['isComplete']){
		    $files = $data['data'];
		    //print_r($files);
		    $status = "done";
	    	$msg = 'Archivo subido correctamente!';
	    	$arrDato = $data['data']['metas'][0];
	    	$archivo = ''; $nomarc = '';
	    	if($arrDato){
	    		$archivo = base_url('uploads/'.$arrDato['name']);
	    		$nomarch = $arrDato['name'];
	    	}
		}

		if($data['hasErrors']){
	        $errors = $data['errors'];
	        //print_r($errors);
	        $status = "error";
	    	$msg = $data['errors'];
	    	$archivo = '';
	    }

	    $arch = $files['files'][0];

	    echo json_encode(array('status'=>$status, 'msg' => $msg, 'url'=>$archivo, 'nombre'=>$nomarch));
	}
	//******************************************************************//

	public function calc1(){
		$this->login();

		$this->load->model('calculadora/pais_model','pais');

		$carpeta = 'calculadora';
		$arr_header['usuario'] = $this->session->userdata('nro_rut');
		$arr_nav = array();

		$data['rsPais'] = $this->pais->get_cbo();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);
		//$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);
		$idsupervisor = $this->session->userdata('idsupervisor');
		if($idsupervisor == 0){
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav_sup', $arr_nav, TRUE);
		}else{
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);
		}

		$this->load->view($carpeta.'/calcfdx',$data);
	}

	public function calc2(){
		$this->login();

		$this->load->model('calculadora/pais_model','pais');

		$carpeta = 'calculadora';
		$arr_header['usuario'] = $this->session->userdata('nro_rut');
		$arr_nav = array();

		$data['rsPais'] = $this->pais->get_cbo();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);
		//$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);

		$idsupervisor = $this->session->userdata('idsupervisor');
		if($idsupervisor == 0){
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav_sup', $arr_nav, TRUE);
		}else{
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);
		}

		$this->load->view($carpeta.'/calcdhl',$data);
	}


	public function get_fdx(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$this->load->model('calculadora/agencia_peso_model','tarifario');
		$this->load->library('utilitario');

		$pais = trim($this->input->post('pais'));
		$zona = trim($this->input->post('zona'));
		$peso = trim($this->input->post('peso'));

		$peso = round( $peso, 1, PHP_ROUND_HALF_UP);
		$decimal = $peso - floor($peso);
		$fraccion = 0.5;

		if($decimal > $fraccion){
			$peso = round($peso, 0, PHP_ROUND_HALF_UP);
		}else if($decimal == 0){
			$peso = floor($peso);
		}else if($decimal < $fraccion){
			$peso = floor($peso) + $fraccion;
		}
		//die('PESO: '.$peso);

		$filtro = array('peso' => $peso, 'calculadora_agencia_id' => AG_FDX);
		$this->tarifario->set_where($filtro);
		$rs = $this->tarifario->get_vista();

		$this->tarifario->clear_where();
		$filtro = array('peso' => 10, 'calculadora_agencia_id' => AG_FDX);
		$this->tarifario->set_where($filtro);
		$rs10 = $this->tarifario->get_vista();

		$this->tarifario->clear_where();
		$filtro = array('peso' => 20, 'calculadora_agencia_id' => AG_FDX);
		$this->tarifario->set_where($filtro);
		$rs20 = $this->tarifario->get_vista();

		//var_dump($filtro); die;
		$tc = $this->utilitario->get_tipocambio();
		$factor = $this->utilitario->get_factorfdx();
		$data = array('status' => false, 'mensaje'=>'No existe cotización.');
		$precio = 0; $precio10 = 0; $precio20 = 0;

		if($rs){
			if($zona == 'A'){
				$precio = $rs['zona1'];
				if($rs10){ $precio10 = $rs10['zona1']; }
				if($rs20){ $precio20 = $rs20['zona1']; }
			}else if($zona == 'B'){
				$precio = $rs['zona2'];
				if($rs10){ $precio10 = $rs10['zona2']; }
				if($rs20){ $precio20 = $rs20['zona2']; }
			}else if($zona == 'C'){
				$precio = $rs['zona3'];
				if($rs10){ $precio10 = $rs10['zona3']; }
				if($rs20){ $precio20 = $rs20['zona3']; }
			}else if($zona == 'D'){
				$precio = $rs['zona4'];
				if($rs10){ $precio10 = $rs10['zona4']; }
				if($rs20){ $precio20 = $rs20['zona4']; }
			}else if($zona == 'E'){
				$precio = $rs['zona5'];
				if($rs10){ $precio10 = $rs10['zona5']; }
				if($rs20){ $precio20 = $rs20['zona5']; }
			}else if($zona == 'F'){
				$precio = $rs['zona6'];
				if($rs10){ $precio10 = $rs10['zona6']; }
				if($rs20){ $precio20 = $rs20['zona6']; }
			}

			$cotizacion = ($precio) * $tc; //$peso * 
			$cotizacion = $cotizacion + ($cotizacion * $factor);
			
			$cotizacion10 = ($precio10) * $tc; //10 * 
			$cotizacion10 = $cotizacion10 + ($cotizacion10 * $factor);

			$cotizacion20 = ($precio20) * $tc; //20 * 
			$cotizacion20 = $cotizacion20 + ($cotizacion20 * $factor);

			$data = array('status'=>true,
						  'mensaje' => 'Cotización completada con exito.',
						  'peso' => $peso,
						  'precio'=>$precio,
						  'tc' => $tc,
						  'zona' => $zona,
						  'factor' => $factor,
						  'cotizacion' => round($cotizacion, 0),
						  'cotizacion10' => round($cotizacion10, 0),
						  'cotizacion20' => round($cotizacion20, 0),
						  );
		}
		
		echo json_encode($data);
	}

	public function get_dhl(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$this->load->model('calculadora/agencia_peso_model','tarifario');
		$this->load->library('utilitario');

		$pais = trim($this->input->post('pais'));
		$zona = trim($this->input->post('zona'));
		$peso = trim($this->input->post('peso'));
		$tipo = trim($this->input->post('tipo'));
		$fraccion = 0.5;
		//echo '--> '.$peso.' -- '.$fraccion;

		if($peso <= $fraccion){
			$peso = $fraccion;
		}else if($peso > $fraccion && $peso <= 1){
			$peso = 1;
		}else if($peso >= 1 && $peso <= 2){
			$peso = 2;
		}else if($peso > 2 && $peso <= 5){
			$peso = 5;
		}else if($peso > 5 && $peso <= 10){
			$peso = 10;
		}else if($peso > 10 && $peso <= 15){
			$peso = 15;
		}else if($peso > 15 && $peso <= 20){
			$peso = 20;
		}else if($peso > 20){
			$peso = 25;
		}
		//$peso = round( $peso, 0, PHP_ROUND_HALF_UP);

		$filtro = array('peso' => $peso, 'tipo'=>$tipo, 'calculadora_agencia_id' => AG_DHL);
		$this->tarifario->set_where($filtro);
		$rs = $this->tarifario->get_vista();

		if($tipo == 1){
			$this->tarifario->clear_where();
			$filtro = array('peso' => 10, 'calculadora_agencia_id' => AG_DHL);
			$this->tarifario->set_where($filtro);
			$rs10 = $this->tarifario->get_vista();

			$this->tarifario->clear_where();
			$filtro = array('peso' => 20, 'calculadora_agencia_id' => AG_DHL);
			$this->tarifario->set_where($filtro);
			$rs20 = $this->tarifario->get_vista();
		}else{
			$precio10 = 0; $rs10 = array();
			$precio20 = 0; $rs20 = array();
		} // fin if tipo

		$tc = $this->utilitario->get_tipocambio();
		$data = array('status' => false, 'mensaje'=>'No existe cotización.');
		$precio = 0; $precio10 = 0; $precio20 = 0;

		if($rs){
			if($zona == '1'){
				$precio = $rs['zona1'];
				if($rs10){ $precio10 = $rs10['zona1']; }
				if($rs20){ $precio20 = $rs20['zona1']; }
			}else if($zona == '2'){
				$precio = $rs['zona2'];
				if($rs10){ $precio10 = $rs10['zona2']; }
				if($rs20){ $precio20 = $rs20['zona2']; }
			}else if($zona == '3'){
				$precio = $rs['zona3'];
				if($rs10){ $precio10 = $rs10['zona3']; }
				if($rs20){ $precio20 = $rs20['zona3']; }
			}else if($zona == '4'){
				$precio = $rs['zona4'];
				if($rs10){ $precio10 = $rs10['zona4']; }
				if($rs20){ $precio20 = $rs20['zona4']; }
			}else if($zona == '5'){
				$precio = $rs['zona5'];
				if($rs10){ $precio10 = $rs10['zona5']; }
				if($rs20){ $precio20 = $rs20['zona5']; }
			}else if($zona == '6'){
				$precio = $rs['zona6'];
				if($rs10){ $precio10 = $rs10['zona6']; }
				if($rs20){ $precio20 = $rs20['zona6']; }
			}

			$cotizacion = ($precio) * $tc;  // $peso * 
			$cotizacion10 = ($precio10) * $tc; //10 * 
			$cotizacion20 = ($precio20) * $tc; //20 * 

			$data = array('status'=>true,
						  'mensaje' => 'Cotización completada con exito.',
						  'tipo'=>$tipo,
						  'peso' => $peso,
						  'precio'=>$precio,
						  'tc' => $tc,
						  'zona' => $zona,
						  'cotizacion' => round($cotizacion, 0),
						  'cotizacion10' => round($cotizacion10, 0),
						  'cotizacion20' => round($cotizacion20, 2),
						  );

		} // FIN IF

		echo json_encode($data);
	}

	public function ventaswu(){
		$this->login();
		$this->load->model('calculadora/login_model','usuario');
		$this->load->model('calculadora/tienda_model','tienda');

		$carpeta = 'calculadora';
		$arr_header['usuario'] = $this->session->userdata('nro_rut');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);
		//$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);
		$idusuario = $this->session->userdata('idusuario');
		$idsupervisor = $this->session->userdata('idsupervisor');
		$idtienda = $this->session->userdata('idtienda');

		$filtro_tienda = array('id'=>$idtienda);
		$this->tienda->set_where($filtro_tienda);
		$data['rs_tiendas'] = $this->tienda->get_cbo();

		if($idsupervisor == 0){
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav_sup', $arr_nav, TRUE);

			$filtro_usuario = array('log.login_parent'=>$idusuario);
			$this->usuario->set_where($filtro_usuario);
			$filtro_usuario = array('log.id'=>$idusuario);
			$this->usuario->set_orwhere($filtro_usuario);
			$rs_usuarios = $this->usuario->get_cbo();
			$data['rs_usuarios'] = $rs_usuarios;
			$this->load->view($carpeta.'/ventaswu_vista',$data);

		}else{
			$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);
			$rs_usuarios = array();

			$filtro_usuario = array('log.id'=>$idusuario);
			$this->usuario->set_where($filtro_usuario);
			$rs_usuarios = $this->usuario->get_cbo();
			$data['rs_usuarios'] = $rs_usuarios;
			$this->load->view($carpeta.'/ventaswu_vista_usuario',$data);
		}
	}

	public function ajax_vista_ventaswu(){

		$this->login();
		$this->load->model('calculadora/transferencias_model','transferencias');

		$filtro = $this->input->post('fil');
		$arrPost = explode('|', $filtro);
		//var_dump($arrPost); 

		$fitrar = array();
		if(array_key_exists(0, $arrPost)){
			$dato = $arrPost[0];
			if($dato){ $fitrar['calculadora_login_id'] = $dato; }
		}

		if(array_key_exists(1, $arrPost)){
			$dato = $arrPost[1];
			if($dato){ $fitrar['pais'] = $dato; }
		}

		if(array_key_exists(2, $arrPost)){
			//array_push($fitrar, array('fecha'=>$arrPost[2]));
			$dato = $arrPost[2];
			if($dato){ $fitrar['tran.fecha'] = $dato; }
		}

		$idtienda = $this->session->userdata('idtienda');
		$fitrar['tran.calculadora_tienda_id'] = $idtienda;

		$this->transferencias->set_where($fitrar);
		$list = $this->transferencias->get_datatables();

		$data = array();
        $no = $this->input->post('start'); 
        foreach ($list as $obj) {
            $no++;
            $row = array();
            
            /*$row[] = '<div class="btn-group">
	                    <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false">
	                      <i class="fa fa-cog"></i>
	                      <span class="ace-icon fa fa-caret-down icon-on-right"></span>
	                    </button>
	                  </div>';
	        */
            $row[] = $no;
            $pais = $obj->pais==OTROS?'OTROS':'COLOMBIA';
            $row[] = $pais; // 
            $row[] = $obj->tienda; 
            $row[] = $obj->usuario; //0
            $row[] = $obj->edt_mnt;
            $row[] = $obj->ing_crg;
            $row[] = $obj->ing_tiva;
            $row[] = $obj->edt_sbt; // 
            $row[] = $obj->edt_tot; // 
            $row[] = $obj->edt_tc; // 
            $row[] = $obj->edt_appago; // 

            $utilidad = $obj->utilidad;
            /*if($obj->pais == OTROS){
            	$edt_mnt = floatval($obj->edt_mnt);
	            $ing_mnt = floatval($obj->ing_mnt);
	            $utilidad =  $edt_mnt - $ing_mnt;
            }else if($obj->pais == COLOMBIA){
            	$tcori = floatval($obj->ing_tc);
            	$tcact = floatval($obj->ing_tcact);
            	$mnt_appago = floatval($obj->edt_appago);

            	$mnt_ori = $mnt_appago/$tcori;
            	$mnt_act = $mnt_appago/$tcact;
            	$utilidad = $mnt_act - $mnt_ori;
            }*/

            $row[] = round($utilidad, 2); 
            $row[] = $obj->fecha_f; // 
            $row[] = $obj->hora; // 
            $formato = $obj->adjunto==1?'Formato1':'Formato2';
            $row[] = $formato; // 
            $row[] = '<a href="'.base_url('assets/upload/pdf/'.$obj->adjunto).'" target="_blank" ><i class="ace-icon fa fa-file-pdf-o fa-2x"></i></a>'; // 
            $row[] = '<a href="#" class="btn-pdf" data-mnt="'.$obj->edt_mnt.'" data-sbt="'.$obj->edt_sbt.'" data-tc="'.$obj->edt_tc.'" data-appago="'.$obj->edt_appago.'" data-adjunto="'.$obj->adjunto.'" data-formato="'.$obj->formato.'" data-print="'.$obj->print.'" ><i class="ace-icon fa fa-file-pdf-o fa-2x"></i> </a>'; // 
            $data[] = $row;
        }

		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->transferencias->count_all(),
                "recordsFiltered" => $this->transferencias->count_filtered(),
                "data" => $data,
        );

		echo json_encode($output);
	}

	public function ajax_vista_ventas_tienda(){

		$this->login();
		$this->load->model('calculadora/tienda_model','tienda');

		$filtro = $this->input->post('fil');
		$arrPost = explode('|', $filtro);
		$fitrar = array();

		if(array_key_exists(0, $arrPost)){
			$dato = $arrPost[0];
			if($dato){ $fitrar['id'] = $dato; }
		}

		$fecha = '';
		if(array_key_exists(1, $arrPost)){
			$fecha = $arrPost[1];
		}

		$this->tienda->set_where($fitrar);
		$list = $this->tienda->get_datatables_venta($fecha);

		$data = array();
        $no = $this->input->post('start'); 
        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->nombre; 
            $row[] = number_format($obj->ot_total_venta); 
            $row[] = number_format($obj->ot_utilidad); 
            $row[] = number_format($obj->co_total_venta); 
            $row[] = number_format($obj->co_utilidad); 

            $totalVta = floatval($obj->ot_total_venta) + floatval($obj->co_total_venta);
            $totalUti = floatval($obj->ot_utilidad) + floatval($obj->co_utilidad);
            $row[] = number_format($totalVta);
            $row[] = number_format($totalUti); 
            $data[] = $row;
        }

		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->tienda->count_all(),
                "recordsFiltered" => $this->tienda->count_all(),
                "data" => $data,
        );

		echo json_encode($output);
	}

	public function ajax_vista_ventas_usuario(){

		$this->login();
		$this->load->model('calculadora/login_model','usuario');

		$filtro = $this->input->post('fil');
		$arrPost = explode('|', $filtro);
		$fitrar = array();

		if(array_key_exists(0, $arrPost)){
			$dato = $arrPost[0];
			if($dato){ $fitrar['log.id'] = $dato; }
		}

		if(array_key_exists(1, $arrPost)){
			$dato = $arrPost[1];
			if($dato){ $fitrar['calculadora_tienda_id'] = $dato; }
		}

		$fecha = '';
		if(array_key_exists(2, $arrPost)){
			$fecha = $arrPost[2];
		}

		$this->usuario->set_where($fitrar);

		$list = $this->usuario->get_datatables_venta($fecha);

		$data = array();
        $no = $this->input->post('start'); 
        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->login.' - '.$obj->usuario; 
            $row[] = $obj->tienda; 
            $row[] = number_format($obj->ot_total_venta); 
            $row[] = number_format($obj->ot_utilidad); 
            $row[] = number_format($obj->co_total_venta); 
            $row[] = number_format($obj->co_utilidad); 

            $totalVta = floatval($obj->ot_total_venta) + floatval($obj->co_total_venta);
            $totalUti = floatval($obj->ot_utilidad) + floatval($obj->co_utilidad);
            $row[] = number_format($totalVta);
            $row[] = number_format($totalUti); 
            $data[] = $row;
        }

		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->usuario->count_all(),
                "recordsFiltered" => $this->usuario->count_all(),
                "data" => $data,
        );

		echo json_encode($output);
	}

}
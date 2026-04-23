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

class Login extends CI_Controller {

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
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('America/Santiago');
	}

	public function index()
	{

		$this->session->sess_destroy();
		$this->load->view('admin/login');

	}

	public function logout(){
		$this->load->helper('cookie');

		$this->session->unset_userdata('usuario');
		$this->session->unset_userdata('nombre');
		$this->session->unset_userdata('idusuario');
		$this->session->unset_userdata('tipousu');
		$this->session->sess_destroy();

		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');

		delete_cookie("ci_session");

		$url = base_url();
		header('Location: '.$url);
	}
	
	public function loguear(){

		header('Content-type: application/json; charset=utf-8');
		$this->load->library('utilitario');
		
		$user = trim($this->input->post('email'));
		$pass = trim($this->input->post('pass'));
		
		//$pass = sha1(HASH.$pass);
		if(strlen($pass)>250){
			//$pass = substr($pass,0,250);
		}

		$this->db->from('administrador');
		$this->db->where('usuario',$user);
		$this->db->where('password',$pass);

		$this->db->where('estado',ON);
		$login = $this->db->count_all_results();
		
		if ($login > 0)
		{

			$ip = $this->utilitario->getRealIP();
			$page = 'https://ipinfo.io/'.$ip;
			$json = @file_get_contents($page);
			$arr = json_decode($json);

			$data_ip = $ip;
			$data_pais = isset($arr->country) ? Locale::getDisplayRegion('-'.$arr->country,'es') : 'Unknown'; 
			$data_ciudad = isset($arr->city) ? $arr->city : 'Unknown';
			$data_latlon = isset($arr->loc) ? $arr->loc : '0,0';

			$this->db->from('administrador');
			$this->db->select('id,usuario,nombre,tipo,dash,estado');
			$this->db->where('usuario',$user);
			$query = $this->db->get();
			$rs = $query->result_array();

			$idUsuario = $rs[0]['id'];
			$usuario = $rs[0]['usuario'];
			$nombre = $rs[0]['nombre']; //->nombre;
			$tipousu = $rs[0]['tipo']; //->tipo;
			$dash = $rs[0]['dash']; //->dash;

			$this->session->set_userdata('idusuario', $idUsuario);
			$this->session->set_userdata('usuario', $usuario);
			$this->session->set_userdata('nombre', $nombre);
			$this->session->set_userdata('tipousu', $tipousu);

			$redirect = base_url($dash);
			$arrayResp = array('status' => true, 'redirect'=>$redirect);

			/*
			$senio = $this->utilitario->getCodigo();
			$token = $this->utilitario->getCodigo();

			$arrDatos = array('token'=>$token);
			$this->db->reset_query();
			$this->db->where('id',$idUsuario);
			$this->db->update('administrador', $arrDatos);

			
			$this->session->set_userdata('temporal', $senio.$idUsuario);
			$this->email_info($usuario, $token, $data_latlon, $data_pais, $data_ciudad, $data_ip);
			$arrayResp = array('status' => true, 'redirect'=>'', 'mensaje'=>'Se envio un código de acceso al correo para validar su acceso.');
			*/

			die(json_encode($arrayResp));

		}else{
			$arrayResp = array('status' => false, 'redirect'=>'', 'mensaje'=>'Usuario no encontrado, verifique los datos de acceso ingresados.');
			
		}
			//die(var_dump($arrayResp));
			die(json_encode($arrayResp));
	}

	private function email_info($usuario='', $token = '', $latlong='',$pais='', $ciudad='', $ip=''){ //
		
		$this->load->library('utilitario');
		$this->load->library('email');
		$this->load->library('turboemail');

		$data['token'] = $token;
		$data['usuario'] = $usuario;
		$data['latlong'] = $latlong;
		$data['pais'] = $pais;
		$data['ciudad'] = $ciudad;
		$data['ip'] = $ip;

		$message = $this->load->view('admin/template_token', $data, TRUE);

		$email = new Email();
		$email->setFrom(SOPORTE,'AstroPay card CL');
		$email->setToList($usuario); // anthony1585@gmail.com  -  $usu
		//$email->setCcList("test@domain.com");
		//$email->setBccList(SOPORTE);	// 'loctelonline@gmail.com' - .SOPORTE
		
		$email->setSubject('AstroPay Card - Token de acceso');
		$email->setHtmlContent($message);
		$email->removeCustomHeader('X-Header-da-rimuovere');

		$turboApiClient = new TurboApiClient("soporte@astropaycard.cl", PS_TURBOSMTP);
		$response = $turboApiClient->sendEmail($email);
		$swSend = 0;
		//print_r($response);
		//$response = json_decode($response, true);
        if($response['message'] == "OK"){
        	$swSend = 1;
        }
        return $swSend;
        //$this->load->view('compra/template-confirma',$data);
	}

	public function acceso(){
		header('Content-type: application/json; charset=utf-8');
		
		//die('ACCESO .....');
		$idUsuario = $this->session->userdata('temporal');
		
		$idUsuario = substr($idUsuario, 6, strlen($idUsuario));
		$code = trim($this->input->post('code'));
		//die($idUsuario.' - '.$code);

		$this->db->from('administrador');
		$this->db->where('id',$idUsuario);
		$this->db->where('token',$code);
		$this->db->where('estado',ON);
		$login = $this->db->count_all_results();

		if ($login > 0)
		{
			$this->db->from('administrador');
			$this->db->select('id,nombre,usuario,tipo,dash,estado');
			$this->db->where('id',$idUsuario);
			$query = $this->db->get();
			$rs = $query->result_array();
			
			$idUsuario = $rs[0]['id']; //->id;
			$nombre = $rs[0]['nombre']; //->nombre;
			$usuario = $rs[0]['usuario']; //->usuario;
			$tipousu = $rs[0]['tipo']; //->tipo;
			$dash = $rs[0]['dash']; //->dash;

			$this->session->set_userdata('idusuario', $idUsuario);
			$this->session->set_userdata('usuario', $usuario);
			$this->session->set_userdata('nombre', $nombre);
			$this->session->set_userdata('tipousu', $tipousu);

			$redirect = base_url($dash);
			$arrayResp = array('status' => true, 'redirect'=>$redirect);
		}else{
			$arrayResp = array('status' => false,'mensaje'=>'Usuario no encontrado, verifique los datos de acceso ingresados.');
		}
		die(json_encode($arrayResp));

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/Welcome.php */